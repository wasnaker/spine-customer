<?php

namespace Modules\Customer\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class CustomerBaseRoleSeeder extends Seeder
{
    /**
     * Base role staff customer: semua staff dapat 'customer'.
     * Admin entity (customers.admin_id) dapat role admin tambahan (multirole):
     *   - admin customer HO (type != branch) -> +customer-admin
     *   - admin branch (type = branch)        -> +customer-branch-admin
     * Idempotent (unique model_id+role_id).
     */
    public function run(): void
    {
        $userIds = \DB::table('customer_staffs')->pluck('user_id')->unique();

        User::whereIn('id', $userIds)->get()
            ->each(fn ($user) => $user->assignRole('customer'));

        foreach (\DB::table('customers')->whereNotNull('admin_id')->get(['admin_id', 'type']) as $c) {
            $role = $c->type === 'branch' ? 'customer-branch-admin' : 'customer-admin';
            User::find($c->admin_id)?->assignRole($role);
        }
    }
}
