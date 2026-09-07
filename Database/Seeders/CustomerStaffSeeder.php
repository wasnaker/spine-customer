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
            ['email' => 'fajar-manullang@wasnaker.lan', 'name' => 'Admin PT Cipta Karya', 'realname' => 'Budi Sihombing', 'jabatan' => 'Admin Perusahaan', 'phone' => null, 'customer_code' => '16IG', 'branch_code' => null, 'role' => 'customer'],
            ['email' => 'joko-wibowo@wasnaker.lan', 'name' => 'Admin PT Nusantara Sejahtera', 'realname' => 'Umi Wibowo', 'jabatan' => 'Admin Perusahaan', 'phone' => null, 'customer_code' => '16L5', 'branch_code' => null, 'role' => 'customer'],
            ['email' => 'zainal-manullang@wasnaker.lan', 'name' => 'Admin PT Bina Marga', 'realname' => 'Eko Hutapea', 'jabatan' => 'Admin Perusahaan', 'phone' => null, 'customer_code' => '16NU', 'branch_code' => null, 'role' => 'customer'],
            ['email' => 'dwi-siahaan@wasnaker.lan', 'name' => 'Admin PT Jaya Abadi', 'realname' => 'Tono Tambunan', 'jabatan' => 'Admin Perusahaan', 'phone' => null, 'customer_code' => '16QJ', 'branch_code' => null, 'role' => 'customer'],
            ['email' => 'hadi-rahayu@wasnaker.lan', 'name' => 'Admin PT Karunia Abadi', 'realname' => 'Agus Sihombing', 'jabatan' => 'Admin Perusahaan', 'phone' => null, 'customer_code' => '16T8', 'branch_code' => null, 'role' => 'customer'],
            ['email' => 'joko-firmansyah@wasnaker.lan', 'name' => 'Admin PT Mulia Bersama', 'realname' => 'Gita Sinaga', 'jabatan' => 'Admin Perusahaan', 'phone' => null, 'customer_code' => '16VX', 'branch_code' => null, 'role' => 'customer'],
            ['email' => 'rina-silitonga@wasnaker.lan', 'name' => 'Admin PT Sinar Mas', 'realname' => 'Gita Tambunan', 'jabatan' => 'Admin Perusahaan', 'phone' => null, 'customer_code' => '16YM', 'branch_code' => null, 'role' => 'customer'],
            ['email' => 'kadek-susanto@wasnaker.lan', 'name' => 'Admin PT Bumi Persada', 'realname' => 'Umi Nasution', 'jabatan' => 'Admin Perusahaan', 'phone' => null, 'customer_code' => '171B', 'branch_code' => null, 'role' => 'customer'],
            ['email' => 'indah-utami@wasnaker.lan', 'name' => 'Admin PT Prima Utama', 'realname' => 'Dewi Tambunan', 'jabatan' => 'Admin Perusahaan', 'phone' => null, 'customer_code' => '1740', 'branch_code' => null, 'role' => 'customer'],
            ['email' => 'tono-hidayat@wasnaker.lan', 'name' => 'Admin PT Indah Kiat', 'realname' => 'Slamet Hidayat', 'jabatan' => 'Admin Perusahaan', 'phone' => null, 'customer_code' => '176P', 'branch_code' => null, 'role' => 'customer'],
            ['email' => 'yanti-gunawan@wasnaker.lan', 'name' => 'Admin PT Surya Gemilang', 'realname' => 'Kadek Lestari', 'jabatan' => 'Admin Perusahaan', 'phone' => null, 'customer_code' => '179E', 'branch_code' => null, 'role' => 'customer'],
            ['email' => 'dewi-gunawan@wasnaker.lan', 'name' => 'Admin PT Kencana Tunggal', 'realname' => 'Dewi Rahayu', 'jabatan' => 'Admin Perusahaan', 'phone' => null, 'customer_code' => '17C3', 'branch_code' => null, 'role' => 'customer'],
            ['email' => 'indah-siregar@wasnaker.lan', 'name' => 'Admin PT Harapan Jaya', 'realname' => 'Andi Ramadhan', 'jabatan' => 'Admin Perusahaan', 'phone' => null, 'customer_code' => '17ES', 'branch_code' => null, 'role' => 'customer'],
            ['email' => 'ratna-firmansyah@wasnaker.lan', 'name' => 'Admin PT Berkah Mandiri', 'realname' => 'Bambang Saputra', 'jabatan' => 'Admin Perusahaan', 'phone' => null, 'customer_code' => '17HH', 'branch_code' => null, 'role' => 'customer'],
            ['email' => 'made-saputra@wasnaker.lan', 'name' => 'Admin PT Cahaya Nusantara', 'realname' => 'Fajar Hutapea', 'jabatan' => 'Admin Perusahaan', 'phone' => null, 'customer_code' => '17K6', 'branch_code' => null, 'role' => 'customer'],
            ['email' => 'andi-wijaya@wasnaker.lan', 'name' => 'Admin PT Sentosa Abadi', 'realname' => 'Fajar Sihombing', 'jabatan' => 'Admin Perusahaan', 'phone' => null, 'customer_code' => '17MV', 'branch_code' => null, 'role' => 'customer'],
            ['email' => 'zainal-kusuma@wasnaker.lan', 'name' => 'Admin PT Mitra Sejati', 'realname' => 'Endah Susanto', 'jabatan' => 'Admin Perusahaan', 'phone' => null, 'customer_code' => '17PK', 'branch_code' => null, 'role' => 'customer'],
            ['email' => 'indah-silitonga@wasnaker.lan', 'name' => 'Admin PT Prasetya Utama', 'realname' => 'Rina Tambunan', 'jabatan' => 'Admin Perusahaan', 'phone' => null, 'customer_code' => '17S9', 'branch_code' => null, 'role' => 'customer'],
            ['email' => 'endah-silitonga@wasnaker.lan', 'name' => 'Admin PT Wijaya Karya', 'realname' => 'Wahyu Silitonga', 'jabatan' => 'Admin Perusahaan', 'phone' => null, 'customer_code' => '17UY', 'branch_code' => null, 'role' => 'customer'],
            ['email' => 'indah-saputra@wasnaker.lan', 'name' => 'Admin PT Bhakti Nusantara', 'realname' => 'Lina Setiawan', 'jabatan' => 'Admin Perusahaan', 'phone' => null, 'customer_code' => '17XN', 'branch_code' => null, 'role' => 'customer'],
            ['email' => 'made-setiawan@wasnaker.lan', 'name' => 'Admin PT Sukses Mandiri', 'realname' => 'Gita Anggraini', 'jabatan' => 'Admin Perusahaan', 'phone' => null, 'customer_code' => '180C', 'branch_code' => null, 'role' => 'customer'],
            ['email' => 'zainal-hutapea@wasnaker.lan', 'name' => 'Admin PT Cipta Karya - Cabang Jawa Barat', 'realname' => 'Dewi Pratama', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => '1831', 'branch_code' => '1831', 'role' => 'customer'],
            ['email' => 'kadek-utami@wasnaker.lan', 'name' => 'Admin PT Nusantara Sejahtera - Cabang Jawa Tengah', 'realname' => 'Andi Simanjuntak', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => '185Q', 'branch_code' => '185Q', 'role' => 'customer'],
            ['email' => 'nina-saputra@wasnaker.lan', 'name' => 'Admin PT Cipta Karya - Plant Jawa Tengah', 'realname' => 'Wahyu Santoso', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => '188F', 'branch_code' => '188F', 'role' => 'customer'],
            ['email' => 'ratna-gunawan@wasnaker.lan', 'name' => 'Admin PT Nusantara Sejahtera - Plant DI Yogyakarta', 'realname' => 'Made Anggraini', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => '18B4', 'branch_code' => '18B4', 'role' => 'customer'],
            ['email' => 'endah-wibowo@wasnaker.lan', 'name' => 'Admin PT Cipta Karya - Site DI Yogyakarta', 'realname' => 'Sari Maulana', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => '18DT', 'branch_code' => '18DT', 'role' => 'customer'],
            ['email' => 'tono-ramadhan@wasnaker.lan', 'name' => 'Admin PT Nusantara Sejahtera - Site Jawa Timur', 'realname' => 'Slamet Tambunan', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => '18GI', 'branch_code' => '18GI', 'role' => 'customer'],
            ['email' => 'putra-siahaan@wasnaker.lan', 'name' => 'Admin PT Jaya Abadi - Cabang DI Yogyakarta', 'realname' => 'Andi Sinaga', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => '18J7', 'branch_code' => '18J7', 'role' => 'customer'],
            ['email' => 'dwi-nasution@wasnaker.lan', 'name' => 'Admin PT Bina Marga - Cabang Sumatera Selatan', 'realname' => 'Umi Utami', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => '18LW', 'branch_code' => '18LW', 'role' => 'customer'],
            ['email' => 'agus-siahaan@wasnaker.lan', 'name' => 'Admin PT Jaya Abadi - Plant Jawa Timur', 'realname' => 'Slamet Halim', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => '18OL', 'branch_code' => '18OL', 'role' => 'customer'],
            ['email' => 'endah-susanto@wasnaker.lan', 'name' => 'Admin PT Bina Marga - Plant Sumatera Selatan', 'realname' => 'Eko Utami', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => '18RA', 'branch_code' => '18RA', 'role' => 'customer'],
            ['email' => 'umi-rahayu@wasnaker.lan', 'name' => 'Admin PT Jaya Abadi - Site Banten', 'realname' => 'Cahyo Tambunan', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => '18TZ', 'branch_code' => '18TZ', 'role' => 'customer'],
            ['email' => 'dewi-silitonga@wasnaker.lan', 'name' => 'Admin PT Bina Marga - Site Sumatera Selatan', 'realname' => 'Eko Sihombing', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => '18WO', 'branch_code' => '18WO', 'role' => 'customer'],
            ['email' => 'indah-hidayat@wasnaker.lan', 'name' => 'Admin PT Sinar Mas - Cabang Banten', 'realname' => 'Umi Silitonga', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => '18ZD', 'branch_code' => '18ZD', 'role' => 'customer'],
            ['email' => 'budi-rahayu@wasnaker.lan', 'name' => 'Admin PT Mulia Bersama - Cabang Bali', 'realname' => 'Tono Sihombing', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => '1922', 'branch_code' => '1922', 'role' => 'customer'],
            ['email' => 'dwi-lestari@wasnaker.lan', 'name' => 'Admin PT Sinar Mas - Plant Bali', 'realname' => 'Zainal Nugroho', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => '194R', 'branch_code' => '194R', 'role' => 'customer'],
            ['email' => 'slamet-halim@wasnaker.lan', 'name' => 'Admin PT Mulia Bersama - Plant Sumatera Utara', 'realname' => 'Budi Rahayu', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => '197G', 'branch_code' => '197G', 'role' => 'customer'],
            ['email' => 'umi-lestari@wasnaker.lan', 'name' => 'Admin PT Sinar Mas - Site Sumatera Utara', 'realname' => 'Dedi Lestari', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => '19A5', 'branch_code' => '19A5', 'role' => 'customer'],
            ['email' => 'indah-siahaan@wasnaker.lan', 'name' => 'Admin PT Mulia Bersama - Site Riau', 'realname' => 'Endah Firmansyah', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => '19CU', 'branch_code' => '19CU', 'role' => 'customer'],
            ['email' => 'dewi-hidayat@wasnaker.lan', 'name' => 'Admin PT Prima Utama - Cabang Riau', 'realname' => 'Yanti Hidayat', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => '19FJ', 'branch_code' => '19FJ', 'role' => 'customer'],
            ['email' => 'rina-wijaya@wasnaker.lan', 'name' => 'Admin PT Bumi Persada - Cabang Sumatera Utara', 'realname' => 'Cahyo Siahaan', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => '19I8', 'branch_code' => '19I8', 'role' => 'customer'],
            ['email' => 'putra-anggraini@wasnaker.lan', 'name' => 'Admin PT Bumi Persada - Plant Riau', 'realname' => 'Kadek Siregar', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => '19KX', 'branch_code' => '19KX', 'role' => 'customer'],
            ['email' => 'dewi-anggraini@wasnaker.lan', 'name' => 'Admin PT Prima Utama - Plant Sulawesi Selatan', 'realname' => 'Eko Pratama', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => '19NM', 'branch_code' => '19NM', 'role' => 'customer'],
            ['email' => 'adi-setiawan@wasnaker.lan', 'name' => 'Admin PT Bumi Persada - Site Sulawesi Selatan', 'realname' => 'Rina Wibowo', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => '19QB', 'branch_code' => '19QB', 'role' => 'customer'],
            ['email' => 'made-rahayu@wasnaker.lan', 'name' => 'Admin PT Prima Utama - Site DKI Jakarta', 'realname' => 'Made Purba', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => '19T0', 'branch_code' => '19T0', 'role' => 'customer'],
            ['email' => 'endah-halim@wasnaker.lan', 'name' => 'Admin PT Indah Kiat - Cabang Sulawesi Selatan', 'realname' => 'Andi Firmansyah', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => '19VP', 'branch_code' => '19VP', 'role' => 'customer'],
            ['email' => 'kadek-sinaga@wasnaker.lan', 'name' => 'Admin PT Surya Gemilang - Cabang DKI Jakarta', 'realname' => 'Endah Rahayu', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => '19YE', 'branch_code' => '19YE', 'role' => 'customer'],
            ['email' => 'wahyu-saputra@wasnaker.lan', 'name' => 'Admin PT Indah Kiat - Plant DKI Jakarta', 'realname' => 'Nina Nugroho', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => '1A13', 'branch_code' => '1A13', 'role' => 'customer'],
            ['email' => 'bambang-sinaga@wasnaker.lan', 'name' => 'Admin PT Surya Gemilang - Plant Jawa Barat', 'realname' => 'Hadi Halim', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => '1A3S', 'branch_code' => '1A3S', 'role' => 'customer'],
            ['email' => 'nina-setiawan@wasnaker.lan', 'name' => 'Admin PT Indah Kiat - Site Jawa Barat', 'realname' => 'Joko Tambunan', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => '1A6H', 'branch_code' => '1A6H', 'role' => 'customer'],
            ['email' => 'dewi-halim@wasnaker.lan', 'name' => 'Admin PT Surya Gemilang - Site Jawa Tengah', 'realname' => 'Budi Sinaga', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => '1A96', 'branch_code' => '1A96', 'role' => 'customer'],
            ['email' => 'umi-nasution@wasnaker.lan', 'name' => 'Admin PT Kencana Tunggal - Cabang Jawa Barat', 'realname' => 'Agus Hidayat', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => '1ABV', 'branch_code' => '1ABV', 'role' => 'customer'],
            ['email' => 'fajar-halim@wasnaker.lan', 'name' => 'Admin PT Harapan Jaya - Cabang Jawa Tengah', 'realname' => 'Eko Susanto', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => '1AEK', 'branch_code' => '1AEK', 'role' => 'customer'],
            ['email' => 'sari-siahaan@wasnaker.lan', 'name' => 'Admin PT Kencana Tunggal - Plant Jawa Tengah', 'realname' => 'Bambang Rahayu', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => '1AH9', 'branch_code' => '1AH9', 'role' => 'customer'],
            ['email' => 'dewi-sihombing@wasnaker.lan', 'name' => 'Admin PT Harapan Jaya - Plant DI Yogyakarta', 'realname' => 'Adi Purba', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => '1AJY', 'branch_code' => '1AJY', 'role' => 'customer'],
            ['email' => 'dwi-hidayat@wasnaker.lan', 'name' => 'Admin PT Kencana Tunggal - Site DI Yogyakarta', 'realname' => 'Ratna Sinaga', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => '1AMN', 'branch_code' => '1AMN', 'role' => 'customer'],
            ['email' => 'adi-gunawan@wasnaker.lan', 'name' => 'Admin PT Harapan Jaya - Site Jawa Timur', 'realname' => 'Lina Tambunan', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => '1APC', 'branch_code' => '1APC', 'role' => 'customer'],
            ['email' => 'sari-rahayu@wasnaker.lan', 'name' => 'Admin PT Berkah Mandiri - Cabang DI Yogyakarta', 'realname' => 'Budi Lestari', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => '1AS1', 'branch_code' => '1AS1', 'role' => 'customer'],
            ['email' => 'cahyo-sihombing@wasnaker.lan', 'name' => 'Admin PT Cahaya Nusantara - Cabang Sumatera Selatan', 'realname' => 'Made Setiawan', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => '1AUQ', 'branch_code' => '1AUQ', 'role' => 'customer'],
            ['email' => 'bambang-tambunan@wasnaker.lan', 'name' => 'Admin PT Cahaya Nusantara - Plant Sumatera Selatan', 'realname' => 'Umi Sinaga', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => '1AXF', 'branch_code' => '1AXF', 'role' => 'customer'],
            ['email' => 'gita-saputra@wasnaker.lan', 'name' => 'Admin PT Berkah Mandiri - Plant Jawa Timur', 'realname' => 'Lina Sinaga', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => '1B04', 'branch_code' => '1B04', 'role' => 'customer'],
            ['email' => 'cahyo-lestari@wasnaker.lan', 'name' => 'Admin PT Berkah Mandiri - Site Banten', 'realname' => 'Dwi Simanjuntak', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => '1B2T', 'branch_code' => '1B2T', 'role' => 'customer'],
            ['email' => 'yanti-lestari@wasnaker.lan', 'name' => 'Admin PT Cahaya Nusantara - Site Sumatera Selatan', 'realname' => 'Made Utami', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => '1B5I', 'branch_code' => '1B5I', 'role' => 'customer'],
            ['email' => 'tono-hutapea@wasnaker.lan', 'name' => 'Admin PT Sentosa Abadi - Cabang Banten', 'realname' => 'Andi Santoso', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => '1B87', 'branch_code' => '1B87', 'role' => 'customer'],
            ['email' => 'gita-manullang@wasnaker.lan', 'name' => 'Admin PT Mitra Sejati - Cabang Bali', 'realname' => 'Fajar Wibowo', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => '1BAW', 'branch_code' => '1BAW', 'role' => 'customer'],
            ['email' => 'hadi-siregar@wasnaker.lan', 'name' => 'Admin PT Sentosa Abadi - Plant Bali', 'realname' => 'Putra Halim', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => '1BDL', 'branch_code' => '1BDL', 'role' => 'customer'],
            ['email' => 'eko-siahaan@wasnaker.lan', 'name' => 'Admin PT Mitra Sejati - Plant Sumatera Utara', 'realname' => 'Zainal Susanto', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => '1BGA', 'branch_code' => '1BGA', 'role' => 'customer'],
            ['email' => 'rina-saputra@wasnaker.lan', 'name' => 'Admin PT Sentosa Abadi - Site Sumatera Utara', 'realname' => 'Yanti Silitonga', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => '1BIZ', 'branch_code' => '1BIZ', 'role' => 'customer'],
            ['email' => 'sari-utami@wasnaker.lan', 'name' => 'Admin PT Mitra Sejati - Site Riau', 'realname' => 'Yanti Simanjuntak', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => '1BLO', 'branch_code' => '1BLO', 'role' => 'customer'],
            ['email' => 'budi-silitonga@wasnaker.lan', 'name' => 'Admin PT Prasetya Utama - Cabang Riau', 'realname' => 'Budi Maulana', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => '1BOD', 'branch_code' => '1BOD', 'role' => 'customer'],
            ['email' => 'dedi-nugroho@wasnaker.lan', 'name' => 'Admin PT Wijaya Karya - Cabang Sumatera Utara', 'realname' => 'Wahyu Siregar', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => '1BR2', 'branch_code' => '1BR2', 'role' => 'customer'],
            ['email' => 'zainal-saputra@wasnaker.lan', 'name' => 'Admin PT Wijaya Karya - Plant Riau', 'realname' => 'Adi Gunawan', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => '1BTR', 'branch_code' => '1BTR', 'role' => 'customer'],
            ['email' => 'tono-siregar@wasnaker.lan', 'name' => 'Admin PT Prasetya Utama - Plant Sulawesi Selatan', 'realname' => 'Bambang Simanjuntak', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => '1BWG', 'branch_code' => '1BWG', 'role' => 'customer'],
            ['email' => 'putra-hidayat@wasnaker.lan', 'name' => 'Admin PT Wijaya Karya - Site Sulawesi Selatan', 'realname' => 'Rina Manullang', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => '1BZ5', 'branch_code' => '1BZ5', 'role' => 'customer'],
            ['email' => 'sari-nugroho@wasnaker.lan', 'name' => 'Admin PT Prasetya Utama - Site DKI Jakarta', 'realname' => 'Slamet Ramadhan', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => '1C1U', 'branch_code' => '1C1U', 'role' => 'customer'],
            ['email' => 'cahyo-wibowo@wasnaker.lan', 'name' => 'Admin PT Bhakti Nusantara - Cabang Sulawesi Selatan', 'realname' => 'Budi Hidayat', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => '1C4J', 'branch_code' => '1C4J', 'role' => 'customer'],
            ['email' => 'zainal-nugroho@wasnaker.lan', 'name' => 'Admin PT Sukses Mandiri - Cabang DKI Jakarta', 'realname' => 'Gita Sihombing', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => '1C78', 'branch_code' => '1C78', 'role' => 'customer'],
            ['email' => 'lina-pratama@wasnaker.lan', 'name' => 'Admin PT Bhakti Nusantara - Plant DKI Jakarta', 'realname' => 'Joko Nugroho', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => '1C9X', 'branch_code' => '1C9X', 'role' => 'customer'],
            ['email' => 'fajar-pratama@wasnaker.lan', 'name' => 'Admin PT Sukses Mandiri - Plant Jawa Barat', 'realname' => 'Eko Wijaya', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => '1CCM', 'branch_code' => '1CCM', 'role' => 'customer'],
            ['email' => 'sari-hutapea@wasnaker.lan', 'name' => 'Admin PT Bhakti Nusantara - Site Jawa Barat', 'realname' => 'Umi Hutapea', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => '1CFB', 'branch_code' => '1CFB', 'role' => 'customer'],
            ['email' => 'budi-lestari@wasnaker.lan', 'name' => 'Admin PT Sukses Mandiri - Site Jawa Tengah', 'realname' => 'Agus Santoso', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => '1CI0', 'branch_code' => '1CI0', 'role' => 'customer'],
            ['email' => 'rudi-hartono@wasnaker.lan', 'name' => 'rudi-hartono', 'realname' => 'Rudi Hartono', 'jabatan' => 'HRD', 'phone' => null, 'customer_code' => '16IG', 'branch_code' => null, 'role' => 'customer'],
            ['email' => 'susi-susanti@wasnaker.lan', 'name' => 'susi-susanti', 'realname' => 'Susi Susanti', 'jabatan' => 'HRD', 'phone' => null, 'customer_code' => '16L5', 'branch_code' => null, 'role' => 'customer'],
            ['email' => 'teguh-prasetyo@wasnaker.lan', 'name' => 'teguh-prasetyo', 'realname' => 'Teguh Prasetyo', 'jabatan' => 'HRD', 'phone' => null, 'customer_code' => '16NU', 'branch_code' => null, 'role' => 'customer'],
            ['email' => 'dian-pertiwi@wasnaker.lan', 'name' => 'dian-pertiwi', 'realname' => 'Dian Pertiwi', 'jabatan' => 'Finance', 'phone' => null, 'customer_code' => '16QJ', 'branch_code' => null, 'role' => 'customer'],
            ['email' => 'hendra-gunawan@wasnaker.lan', 'name' => 'hendra-gunawan', 'realname' => 'Hendra Gunawan', 'jabatan' => 'Purchasing', 'phone' => null, 'customer_code' => '16QJ', 'branch_code' => null, 'role' => 'customer'],
            ['email' => 'ratih-kumala@wasnaker.lan', 'name' => 'ratih-kumala', 'realname' => 'Ratih Kumala', 'jabatan' => 'HRD', 'phone' => null, 'customer_code' => '16QJ', 'branch_code' => null, 'role' => 'customer'],
            ['email' => 'rina-marlina@wasnaker.lan', 'name' => 'rina-marlina', 'realname' => 'Rina Marlina', 'jabatan' => 'Finance', 'phone' => null, 'customer_code' => '16T8', 'branch_code' => null, 'role' => 'customer'],
            ['email' => 'bowo-laksono@wasnaker.lan', 'name' => 'bowo-laksono', 'realname' => 'Bowo Laksono', 'jabatan' => 'Purchasing', 'phone' => null, 'customer_code' => '16T8', 'branch_code' => null, 'role' => 'customer'],
            ['email' => 'sri-wahyuni@wasnaker.lan', 'name' => 'sri-wahyuni', 'realname' => 'Sri Wahyuni', 'jabatan' => 'HRD', 'phone' => null, 'customer_code' => '16T8', 'branch_code' => null, 'role' => 'customer'],
        ];

        foreach ($staffs as $s) {
            $user = User::firstOrCreate(
                ['email' => $s['email']],
                ['name' => $s['name'], 'password' => $password, 'is_active' => true]
            );

            $user->name = $s['name'];
            $user->save();

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