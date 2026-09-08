<?php

namespace Modules\Customer\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class CustomerBaseRoleSeeder extends Seeder
{
    /**
     * Base role untuk semua staff customer. Multirole: assignRole menambah,
     * tidak menghapus role lain. Idempotent (unique model_id+role_id).
     */
    public function run(): void
    {
        $userIds = \DB::table('customer_staffs')->pluck('user_id')->unique();

        User::whereIn('id', $userIds)->get()
            ->each(fn ($user) => $user->assignRole('customer'));
    }
}
