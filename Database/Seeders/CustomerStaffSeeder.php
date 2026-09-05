<?php

namespace Modules\Customer\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Modules\Customer\Models\Customer;
use Modules\Customer\Models\CustomerStaff;
use Spatie\Permission\PermissionRegistrar;

/**
 * Dibangun dari record DB (demo reset periodik — sumber kebenaran = DB).
 * Idempotent: re-run aman (firstOrCreate by email, updateOrCreate staff).
 */
class CustomerStaffSeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make('adminpass');

        $staffs = [
            ['email' => 'staff.dewi-01@wasnaker.lan', 'name' => 'Staff PT Dewi 1', 'realname' => 'Rina Kusuma', 'jabatan' => 'Admin Keuangan', 'phone' => null, 'customer_code' => 'DEWI', 'branch_code' => null, 'role' => 'customer'],
            ['email' => 'staff.dewi-02@wasnaker.lan', 'name' => 'Staff PT Dewi 2', 'realname' => 'Budi Santoso', 'jabatan' => 'HRD', 'phone' => null, 'customer_code' => 'DEWI', 'branch_code' => null, 'role' => null],
            ['email' => 'staff.dewi-03@wasnaker.lan', 'name' => 'Staff PT Dewi 3', 'realname' => 'Sari Wulandari', 'jabatan' => 'Admin Operasional', 'phone' => null, 'customer_code' => 'DEWI', 'branch_code' => null, 'role' => null],
        ];

        foreach ($staffs as $s) {
            $user = User::firstOrCreate(
                ['email' => $s['email']],
                ['name' => $s['name'], 'password' => $password, 'is_active' => true]
            );

            if ($s['role']) {
                $user->assignRole($s['role']);
            }

            $customer = Customer::where('code', $s['customer_code'])->first();
            if (! $customer) {
                $this->command->warn("Customer code not found: {$s['customer_code']} (skip {$s['email']})");
                continue;
            }

            $branch = $s['branch_code'] ? Customer::where('code', $s['branch_code'])->where('parent_id', $customer->id)->first() : null;

            CustomerStaff::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'customer_id' => $branch?->id ?? $customer->id,
                    'realname'    => $s['realname'],
                    'jabatan'     => $s['jabatan'],
                    'phone'       => $s['phone'],
                    'is_active'   => true,
                ]
            );
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}