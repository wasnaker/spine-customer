<?php

declare(strict_types=1);

namespace Modules\Customer\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Modules\Customer\Models\Customer;
use Modules\Region\Models\Province;
use Modules\Region\Models\Regency;
use Modules\Vat\Models\Vat;

/**
 * CustomerDemoSeeder — snapshot data demo customers (wasnaker.lan).
 *
 * Data (81 baris: 21 HO + 60 branch) diambil dari DB staging (2026-09-04),
 * disimpan sebagai JSON di data/customer-demo.json. Idempotent:
 * firstOrCreate by code (+parent), lalu update kolom.
 */
class CustomerDemoSeeder extends Seeder
{
    public function run(): void
    {
        $provinces = Province::pluck('id', 'name');
        $regencies = Regency::select('id', 'name', 'province_id')->get()
            ->keyBy(fn ($r) => $r->province_id . ':' . $r->name);

        $hoIds = []; // code => id
        foreach ($this->loadData() as [$code, $name, $email, $phone, $address, $isActive, $province, $regency, $parentCode, $npwp, $vatName, $adminEmail]) {
            $provId = $provinces[$province] ?? null;
            $regId  = $provId && $regency ? ($regencies[$provId . ':' . $regency]->id ?? null) : null;

            $vat = $npwp ? Vat::firstOrCreate(['npwp' => $npwp], ['name' => $vatName]) : null;

            $admin = $adminEmail ? User::firstOrCreate(
                ['email' => $adminEmail],
                ['name' => "Admin {$name}", 'password' => Hash::make('adminpass'), 'is_active' => true]
            ) : null;

            $parentId = $parentCode !== null ? ($hoIds[$parentCode] ?? null) : null;
            $type = $parentCode !== null ? 'branch' : 'customer';

            $customer = Customer::firstOrCreate(
                ['code' => $code, 'parent_id' => $parentId],
                [
                    'type'      => $type,
                    'name'      => $name,
                    'is_active' => $isActive === 'true',
                ]
            );
            $customer->update([
                'type'        => $type,
                'name'        => $name,
                'email'       => $email,
                'phone'       => $phone,
                'address'     => $address,
                'is_active'   => $isActive === 'true',
                'province_id' => $provId,
                'regency_id'  => $regId,
                'vat_id'      => $vat?->id,
                'admin_id'    => $admin?->id,
            ]);

            if ($type === 'customer') {
                $hoIds[$code] = $customer->id;
            }
        }

        $this->command?->info(sprintf(
            'Demo data siap: %d HO, %d branch, %d NPWP.',
            Customer::where('type', 'customer')->count(),
            Customer::where('type', 'branch')->count(),
            Vat::count()
        ));
    }

    /** @return array<int, array{0: string, 1: string, 2: string|null, 3: string|null, 4: string|null, 5: string, 6: string|null, 7: string|null, 8: string|null, 9: string|null, 10: string|null, 11: string|null}> */
    private function loadData(): array
    {
        $rows = json_decode(
            file_get_contents(__DIR__ . '/data/customer-demo.json'),
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        return array_map(fn ($r) => [
            $r[0], $r[1], $r[2], $r[3], $r[4], $r[5],
            $r[6], $r[7], $r[8], $r[9], $r[10], $r[11],
        ], $rows);
    }
}
