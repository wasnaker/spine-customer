<?php

namespace Modules\Customer\Database\Seeders;

use Illuminate\Database\Seeder;

class CustomerPengawasTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('customer_pengawas')->delete();
        
        \DB::table('customer_pengawas')->insert(array (
            0 => 
            array (
                'id' => 1,
                'customer_id' => 20739,
                'pengawas_id' => 41628,
                'created_at' => '2026-09-08 07:05:46',
                'updated_at' => '2026-09-08 07:05:46',
            ),
            1 => 
            array (
                'id' => 2,
                'customer_id' => 20738,
                'pengawas_id' => 41614,
                'created_at' => '2026-09-08 07:05:55',
                'updated_at' => '2026-09-08 07:05:55',
            ),
            2 => 
            array (
                'id' => 3,
                'customer_id' => 20736,
                'pengawas_id' => 41595,
                'created_at' => '2026-09-08 07:06:00',
                'updated_at' => '2026-09-08 07:06:00',
            ),
            3 => 
            array (
                'id' => 4,
                'customer_id' => 20734,
                'pengawas_id' => 41590,
                'created_at' => '2026-09-08 07:06:09',
                'updated_at' => '2026-09-08 07:06:09',
            ),
        ));
        
        
    }
}