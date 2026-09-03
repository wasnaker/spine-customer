<?php

declare(strict_types=1);

namespace Modules\Customer\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Modules\Customer\Models\Customer;
use Modules\Region\Models\Province;
use Modules\Region\Models\Regency;
use Modules\Vat\Services\VatService;

/**
 * CustomerDemoSeeder — data demo untuk situs wasnaker.lan (public demo).
 *
 * Isi: 20 customer HO + 60 branch (3 branch per HO, masing-masing di provinsi berbeda).
 *   - Branch disimpan sebagai row di tabel customers dengan type='branch' dan parent=ID HO.
 *   - 10 provinsi referensi (sudah ter-seed via RegionSeeder).
 *
 * Idempotent: firstOrCreate by code + parent. Demo periodik: hapus + re-seed.
 * Jalankan: php artisan db:seed --class="Modules\\Customer\\Database\\Seeders\\CustomerDemoSeeder"
 *
 * Catatan:
 *   - 1 customer HO punya 1 NPWP HO; tiap branch punya NPWP sendiri.
 *   - Nama customer fiktif generik (PT/CV Alpha s/d PT/CV Tango).
 */
class CustomerDemoSeeder extends Seeder
{
    /** 10 provinsi referensi (dari 38 existing di RegionSeeder). */
    private const PROVINCES = [
        '31' => 'DKI Jakarta',
        '32' => 'Jawa Barat',
        '33' => 'Jawa Tengah',
        '34' => 'DI Yogyakarta',
        '35' => 'Jawa Timur',
        '36' => 'Banten',
        '51' => 'Bali',
        '12' => 'Sumatera Utara',
        '14' => 'Riau',
        '73' => 'Sulawesi Selatan',
    ];

    /** 20 nama code customer (2 per provinsi, urut round-robin). */
    private const CUSTOMER_NAMES = [
        'Alpha', 'Antariksa', 'Biru', 'Bintang', 'Citra', 'Cendana',
        'Damar', 'Dewi', 'Elang', 'Estu', 'Fajar', 'Flores',
        'Gajah', 'Gita', 'Harum', 'Hijau', 'Intan', 'Indah',
        'Jaya', 'Jingga',
    ];

    /** 3 nama cabang generik (per customer HO dapat 3, masing-masing di provinsi beda). */
    private const BRANCH_KINDS = ['Cabang', 'Plant', 'Site'];

    public function run(): void
    {
        $vat = app(VatService::class);

        $provinces = Province::whereIn('code', array_keys(self::PROVINCES))
            ->pluck('id', 'code');
        if ($provinces->count() < count(self::PROVINCES)) {
            $this->command?->warn('Provinsi belum lengkap — jalankan RegionSeeder dulu.');
            return;
        }

        $provCodes = array_keys(self::PROVINCES);

        // admin: 1 user per entity (HO + branch). Email unik per code.
        $adminPass = 'adminpass';

        $makeAdmin = function (string $code, string $name, int $salt) use ($adminPass): int {
            $email = strtolower("admin.{$code}.{$salt}@wasnaker.lan");
            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name'     => "Admin {$name}",
                    'password' => Hash::make($adminPass),
                    'is_active' => true,
                ]
            );

            return $user->id;
        };

        // pilih regency acak milik provinsi tsb (untuk demo, stabil per provinsi)
        $regencyByProvince = Regency::select('province_id', 'id')
            ->get()
            ->groupBy('province_id')
            ->map(fn ($r) => $r->first()->id);

        foreach (self::CUSTOMER_NAMES as $idx => $name) {
            $hoProvCode  = $provCodes[$idx % count($provCodes)];
            $hoProvId    = $provinces[$hoProvCode];
            $hoProvName  = self::PROVINCES[$hoProvCode];
            $hoRegencyId = $regencyByProvince[$hoProvId] ?? null;

            $code = strtoupper($name);
            $suffix = str_pad((string) ($idx + 1), 3, '0', STR_PAD_LEFT);
            $npwpHo = sprintf('%02d.%s.%s.%s-%03d.%03d', $idx + 1, $suffix, $suffix, $suffix, $idx + 1, $idx + 1);

            $hoVat = $vat->findOrCreate($npwpHo, "PT {$name}");

            $customer = Customer::firstOrCreate(
                ['code' => $code, 'parent_id' => null],
                [
                    'name'      => "PT {$name}",
                    'email'     => strtolower("{$name}@mandala.demo"),
                    'phone'     => sprintf('%02d-555%04d', $hoProvId, $idx + 1),
                    'address'   => "Jl. Contoh No. 1, {$hoProvName}",
                    'vat_id'    => $hoVat->id,
                    'is_active' => true,
                    'type'      => 'customer',
                ]
            );
            $customer->update([
                'admin_id'     => $makeAdmin($code, $customer->name, $idx),
                'province_id'  => $hoProvId,
                'regency_id'   => $hoRegencyId,
            ]);

            // 3 branch di 3 provinsi lain (selain HO). Round-robin dari idx+1.
            foreach (self::BRANCH_KINDS as $bIdx => $bKind) {
                $branchProvCode = $provCodes[($idx + 1 + $bIdx) % count($provCodes)];
                if ($branchProvCode === $hoProvCode) {
                    $branchProvCode = $provCodes[($idx + 1 + $bIdx + 1) % count($provCodes)];
                }
                $branchProvName = self::PROVINCES[$branchProvCode];
                $branchCode = $code[0] . str_pad((string) ($bIdx + 1), 2, '0', STR_PAD_LEFT);
                $npwpBranch = sprintf('%02d.%s.%s.%s-%03d.%03d',
                    $idx + 1, $suffix, $suffix, $suffix,
                    $bIdx + 3, $idx + 1
                );
                $branchVat = $vat->findOrCreate($npwpBranch, "PT {$name} - {$bKind} {$branchProvName}");

                $branch = Customer::firstOrCreate(
                    ['code' => $branchCode, 'parent_id' => $customer->id],
                    [
                        'name'      => "{$bKind} {$branchProvName}",
                        'phone'     => sprintf('%02d-666%02d%02d', $provinces[$branchProvCode], $idx + 1, $bIdx + 1),
                        'address'   => "Jl. Contoh No. {$idx}{$bIdx}, {$branchProvName}",
                        'vat_id'    => $branchVat->id,
                        'is_active' => true,
                        'type'      => 'branch',
                    ]
                );
                $branchProvId = $provinces[$branchProvCode];
                $branch->update([
                    'admin_id'     => $makeAdmin("{$code}{$bIdx}", $branch->name, $idx + $bIdx),
                    'province_id'  => $branchProvId,
                    'regency_id'   => $regencyByProvince[$branchProvId] ?? null,
                ]);
            }
        }

        $hoCount    = Customer::where('type', 'customer')->count();
        $branchCount = Customer::where('type', 'branch')->count();

        $this->command?->info(sprintf(
            'Demo data siap: %d HO, %d branch, %d NPWP dalam customers.',
            $hoCount,
            $branchCount,
            \Modules\Vat\Models\Vat::count()
        ));
    }
}
