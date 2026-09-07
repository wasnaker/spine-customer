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
            ['email' => 'fajar-manullang@wasnaker.lan', 'name' => 'fajar-manullang', 'realname' => 'Fajar Manullang', 'jabatan' => 'Admin Perusahaan', 'phone' => null, 'customer_code' => 'ALPHA', 'branch_code' => null, 'role' => 'customer'],
            ['email' => 'joko-wibowo@wasnaker.lan', 'name' => 'joko-wibowo', 'realname' => 'Joko Wibowo', 'jabatan' => 'Admin Perusahaan', 'phone' => null, 'customer_code' => 'ANTARIKSA', 'branch_code' => null, 'role' => 'customer'],
            ['email' => 'zainal-manullang@wasnaker.lan', 'name' => 'zainal-manullang', 'realname' => 'Zainal Manullang', 'jabatan' => 'Admin Perusahaan', 'phone' => null, 'customer_code' => 'BINTANG', 'branch_code' => null, 'role' => 'customer'],
            ['email' => 'dwi-siahaan@wasnaker.lan', 'name' => 'dwi-siahaan', 'realname' => 'Dwi Siahaan', 'jabatan' => 'Admin Perusahaan', 'phone' => null, 'customer_code' => 'BIRU', 'branch_code' => null, 'role' => 'customer'],
            ['email' => 'hadi-rahayu@wasnaker.lan', 'name' => 'hadi-rahayu', 'realname' => 'Hadi Rahayu', 'jabatan' => 'Admin Perusahaan', 'phone' => null, 'customer_code' => 'c1212', 'branch_code' => null, 'role' => 'customer'],
            ['email' => 'joko-firmansyah@wasnaker.lan', 'name' => 'joko-firmansyah', 'realname' => 'Joko Firmansyah', 'jabatan' => 'Admin Perusahaan', 'phone' => null, 'customer_code' => 'CENDANA', 'branch_code' => null, 'role' => 'customer'],
            ['email' => 'rina-silitonga@wasnaker.lan', 'name' => 'rina-silitonga', 'realname' => 'Rina Silitonga', 'jabatan' => 'Admin Perusahaan', 'phone' => null, 'customer_code' => 'CITRA', 'branch_code' => null, 'role' => 'customer'],
            ['email' => 'kadek-susanto@wasnaker.lan', 'name' => 'kadek-susanto', 'realname' => 'Kadek Susanto', 'jabatan' => 'Admin Perusahaan', 'phone' => null, 'customer_code' => 'DAMAR', 'branch_code' => null, 'role' => 'customer'],
            ['email' => 'indah-utami@wasnaker.lan', 'name' => 'indah-utami', 'realname' => 'Indah Utami', 'jabatan' => 'Admin Perusahaan', 'phone' => null, 'customer_code' => 'DEWI', 'branch_code' => null, 'role' => 'customer'],
            ['email' => 'tono-hidayat@wasnaker.lan', 'name' => 'tono-hidayat', 'realname' => 'Tono Hidayat', 'jabatan' => 'Admin Perusahaan', 'phone' => null, 'customer_code' => 'ELANG', 'branch_code' => null, 'role' => 'customer'],
            ['email' => 'yanti-gunawan@wasnaker.lan', 'name' => 'yanti-gunawan', 'realname' => 'Yanti Gunawan', 'jabatan' => 'Admin Perusahaan', 'phone' => null, 'customer_code' => 'ESTU', 'branch_code' => null, 'role' => 'customer'],
            ['email' => 'dewi-gunawan@wasnaker.lan', 'name' => 'dewi-gunawan', 'realname' => 'Dewi Gunawan', 'jabatan' => 'Admin Perusahaan', 'phone' => null, 'customer_code' => 'FAJAR', 'branch_code' => null, 'role' => 'customer'],
            ['email' => 'indah-siregar@wasnaker.lan', 'name' => 'indah-siregar', 'realname' => 'Indah Siregar', 'jabatan' => 'Admin Perusahaan', 'phone' => null, 'customer_code' => 'FLORES', 'branch_code' => null, 'role' => 'customer'],
            ['email' => 'ratna-firmansyah@wasnaker.lan', 'name' => 'ratna-firmansyah', 'realname' => 'Ratna Firmansyah', 'jabatan' => 'Admin Perusahaan', 'phone' => null, 'customer_code' => 'GAJAH', 'branch_code' => null, 'role' => 'customer'],
            ['email' => 'made-saputra@wasnaker.lan', 'name' => 'made-saputra', 'realname' => 'Made Saputra', 'jabatan' => 'Admin Perusahaan', 'phone' => null, 'customer_code' => 'GITA', 'branch_code' => null, 'role' => 'customer'],
            ['email' => 'andi-wijaya@wasnaker.lan', 'name' => 'andi-wijaya', 'realname' => 'Andi Wijaya', 'jabatan' => 'Admin Perusahaan', 'phone' => null, 'customer_code' => 'HARUM', 'branch_code' => null, 'role' => 'customer'],
            ['email' => 'zainal-kusuma@wasnaker.lan', 'name' => 'zainal-kusuma', 'realname' => 'Zainal Kusuma', 'jabatan' => 'Admin Perusahaan', 'phone' => null, 'customer_code' => 'HIJAU', 'branch_code' => null, 'role' => 'customer'],
            ['email' => 'indah-silitonga@wasnaker.lan', 'name' => 'indah-silitonga', 'realname' => 'Indah Silitonga', 'jabatan' => 'Admin Perusahaan', 'phone' => null, 'customer_code' => 'INDAH', 'branch_code' => null, 'role' => 'customer'],
            ['email' => 'endah-silitonga@wasnaker.lan', 'name' => 'endah-silitonga', 'realname' => 'Endah Silitonga', 'jabatan' => 'Admin Perusahaan', 'phone' => null, 'customer_code' => 'INTAN', 'branch_code' => null, 'role' => 'customer'],
            ['email' => 'indah-saputra@wasnaker.lan', 'name' => 'indah-saputra', 'realname' => 'Indah Saputra', 'jabatan' => 'Admin Perusahaan', 'phone' => null, 'customer_code' => 'JAYA', 'branch_code' => null, 'role' => 'customer'],
            ['email' => 'made-setiawan@wasnaker.lan', 'name' => 'made-setiawan', 'realname' => 'Made Setiawan', 'jabatan' => 'Admin Perusahaan', 'phone' => null, 'customer_code' => 'JINGGA', 'branch_code' => null, 'role' => 'customer'],
            ['email' => 'zainal-hutapea@wasnaker.lan', 'name' => 'zainal-hutapea', 'realname' => 'Zainal Hutapea', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => 'A01', 'branch_code' => 'A01', 'role' => 'customer'],
            ['email' => 'kadek-utami@wasnaker.lan', 'name' => 'kadek-utami', 'realname' => 'Kadek Utami', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => 'A01', 'branch_code' => 'A01', 'role' => 'customer'],
            ['email' => 'nina-saputra@wasnaker.lan', 'name' => 'nina-saputra', 'realname' => 'Nina Saputra', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => 'A02', 'branch_code' => 'A02', 'role' => 'customer'],
            ['email' => 'ratna-gunawan@wasnaker.lan', 'name' => 'ratna-gunawan', 'realname' => 'Ratna Gunawan', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => 'A02', 'branch_code' => 'A02', 'role' => 'customer'],
            ['email' => 'endah-wibowo@wasnaker.lan', 'name' => 'endah-wibowo', 'realname' => 'Endah Wibowo', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => 'A03', 'branch_code' => 'A03', 'role' => 'customer'],
            ['email' => 'tono-ramadhan@wasnaker.lan', 'name' => 'tono-ramadhan', 'realname' => 'Tono Ramadhan', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => 'A03', 'branch_code' => 'A03', 'role' => 'customer'],
            ['email' => 'putra-siahaan@wasnaker.lan', 'name' => 'putra-siahaan', 'realname' => 'Putra Siahaan', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => 'B01', 'branch_code' => 'B01', 'role' => 'customer'],
            ['email' => 'dwi-nasution@wasnaker.lan', 'name' => 'dwi-nasution', 'realname' => 'Dwi Nasution', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => 'B01', 'branch_code' => 'B01', 'role' => 'customer'],
            ['email' => 'agus-siahaan@wasnaker.lan', 'name' => 'agus-siahaan', 'realname' => 'Agus Siahaan', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => 'B02', 'branch_code' => 'B02', 'role' => 'customer'],
            ['email' => 'endah-susanto@wasnaker.lan', 'name' => 'endah-susanto', 'realname' => 'Endah Susanto', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => 'B02', 'branch_code' => 'B02', 'role' => 'customer'],
            ['email' => 'umi-rahayu@wasnaker.lan', 'name' => 'umi-rahayu', 'realname' => 'Umi Rahayu', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => 'B03', 'branch_code' => 'B03', 'role' => 'customer'],
            ['email' => 'dewi-silitonga@wasnaker.lan', 'name' => 'dewi-silitonga', 'realname' => 'Dewi Silitonga', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => 'B03', 'branch_code' => 'B03', 'role' => 'customer'],
            ['email' => 'indah-hidayat@wasnaker.lan', 'name' => 'indah-hidayat', 'realname' => 'Indah Hidayat', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => 'C01', 'branch_code' => 'C01', 'role' => 'customer'],
            ['email' => 'budi-rahayu@wasnaker.lan', 'name' => 'budi-rahayu', 'realname' => 'Budi Rahayu', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => 'C01', 'branch_code' => 'C01', 'role' => 'customer'],
            ['email' => 'dwi-lestari@wasnaker.lan', 'name' => 'dwi-lestari', 'realname' => 'Dwi Lestari', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => 'C02', 'branch_code' => 'C02', 'role' => 'customer'],
            ['email' => 'slamet-halim@wasnaker.lan', 'name' => 'slamet-halim', 'realname' => 'Slamet Halim', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => 'C02', 'branch_code' => 'C02', 'role' => 'customer'],
            ['email' => 'umi-lestari@wasnaker.lan', 'name' => 'umi-lestari', 'realname' => 'Umi Lestari', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => 'C03', 'branch_code' => 'C03', 'role' => 'customer'],
            ['email' => 'indah-siahaan@wasnaker.lan', 'name' => 'indah-siahaan', 'realname' => 'Indah Siahaan', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => 'C03', 'branch_code' => 'C03', 'role' => 'customer'],
            ['email' => 'rina-wijaya@wasnaker.lan', 'name' => 'rina-wijaya', 'realname' => 'Rina Wijaya', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => 'D01', 'branch_code' => 'D01', 'role' => 'customer'],
            ['email' => 'dewi-hidayat@wasnaker.lan', 'name' => 'dewi-hidayat', 'realname' => 'Dewi Hidayat', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => 'D01', 'branch_code' => 'D01', 'role' => 'customer'],
            ['email' => 'putra-anggraini@wasnaker.lan', 'name' => 'putra-anggraini', 'realname' => 'Putra Anggraini', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => 'D02', 'branch_code' => 'D02', 'role' => 'customer'],
            ['email' => 'dewi-anggraini@wasnaker.lan', 'name' => 'dewi-anggraini', 'realname' => 'Dewi Anggraini', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => 'D02', 'branch_code' => 'D02', 'role' => 'customer'],
            ['email' => 'adi-setiawan@wasnaker.lan', 'name' => 'adi-setiawan', 'realname' => 'Adi Setiawan', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => 'D03', 'branch_code' => 'D03', 'role' => 'customer'],
            ['email' => 'made-rahayu@wasnaker.lan', 'name' => 'made-rahayu', 'realname' => 'Made Rahayu', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => 'D03', 'branch_code' => 'D03', 'role' => 'customer'],
            ['email' => 'endah-halim@wasnaker.lan', 'name' => 'endah-halim', 'realname' => 'Endah Halim', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => 'E01', 'branch_code' => 'E01', 'role' => 'customer'],
            ['email' => 'kadek-sinaga@wasnaker.lan', 'name' => 'kadek-sinaga', 'realname' => 'Kadek Sinaga', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => 'E01', 'branch_code' => 'E01', 'role' => 'customer'],
            ['email' => 'wahyu-saputra@wasnaker.lan', 'name' => 'wahyu-saputra', 'realname' => 'Wahyu Saputra', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => 'E02', 'branch_code' => 'E02', 'role' => 'customer'],
            ['email' => 'bambang-sinaga@wasnaker.lan', 'name' => 'bambang-sinaga', 'realname' => 'Bambang Sinaga', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => 'E02', 'branch_code' => 'E02', 'role' => 'customer'],
            ['email' => 'nina-setiawan@wasnaker.lan', 'name' => 'nina-setiawan', 'realname' => 'Nina Setiawan', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => 'E03', 'branch_code' => 'E03', 'role' => 'customer'],
            ['email' => 'dewi-halim@wasnaker.lan', 'name' => 'dewi-halim', 'realname' => 'Dewi Halim', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => 'E03', 'branch_code' => 'E03', 'role' => 'customer'],
            ['email' => 'umi-nasution@wasnaker.lan', 'name' => 'umi-nasution', 'realname' => 'Umi Nasution', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => 'F01', 'branch_code' => 'F01', 'role' => 'customer'],
            ['email' => 'fajar-halim@wasnaker.lan', 'name' => 'fajar-halim', 'realname' => 'Fajar Halim', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => 'F01', 'branch_code' => 'F01', 'role' => 'customer'],
            ['email' => 'sari-siahaan@wasnaker.lan', 'name' => 'sari-siahaan', 'realname' => 'Sari Siahaan', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => 'F02', 'branch_code' => 'F02', 'role' => 'customer'],
            ['email' => 'dewi-sihombing@wasnaker.lan', 'name' => 'dewi-sihombing', 'realname' => 'Dewi Sihombing', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => 'F02', 'branch_code' => 'F02', 'role' => 'customer'],
            ['email' => 'dwi-hidayat@wasnaker.lan', 'name' => 'dwi-hidayat', 'realname' => 'Dwi Hidayat', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => 'F03', 'branch_code' => 'F03', 'role' => 'customer'],
            ['email' => 'adi-gunawan@wasnaker.lan', 'name' => 'adi-gunawan', 'realname' => 'Adi Gunawan', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => 'F03', 'branch_code' => 'F03', 'role' => 'customer'],
            ['email' => 'sari-rahayu@wasnaker.lan', 'name' => 'sari-rahayu', 'realname' => 'Sari Rahayu', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => 'G01', 'branch_code' => 'G01', 'role' => 'customer'],
            ['email' => 'cahyo-sihombing@wasnaker.lan', 'name' => 'cahyo-sihombing', 'realname' => 'Cahyo Sihombing', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => 'G01', 'branch_code' => 'G01', 'role' => 'customer'],
            ['email' => 'gita-saputra@wasnaker.lan', 'name' => 'gita-saputra', 'realname' => 'Gita Saputra', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => 'G02', 'branch_code' => 'G02', 'role' => 'customer'],
            ['email' => 'bambang-tambunan@wasnaker.lan', 'name' => 'bambang-tambunan', 'realname' => 'Bambang Tambunan', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => 'G02', 'branch_code' => 'G02', 'role' => 'customer'],
            ['email' => 'cahyo-lestari@wasnaker.lan', 'name' => 'cahyo-lestari', 'realname' => 'Cahyo Lestari', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => 'G03', 'branch_code' => 'G03', 'role' => 'customer'],
            ['email' => 'yanti-lestari@wasnaker.lan', 'name' => 'yanti-lestari', 'realname' => 'Yanti Lestari', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => 'G03', 'branch_code' => 'G03', 'role' => 'customer'],
            ['email' => 'tono-hutapea@wasnaker.lan', 'name' => 'tono-hutapea', 'realname' => 'Tono Hutapea', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => 'H01', 'branch_code' => 'H01', 'role' => 'customer'],
            ['email' => 'gita-manullang@wasnaker.lan', 'name' => 'gita-manullang', 'realname' => 'Gita Manullang', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => 'H01', 'branch_code' => 'H01', 'role' => 'customer'],
            ['email' => 'hadi-siregar@wasnaker.lan', 'name' => 'hadi-siregar', 'realname' => 'Hadi Siregar', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => 'H02', 'branch_code' => 'H02', 'role' => 'customer'],
            ['email' => 'eko-siahaan@wasnaker.lan', 'name' => 'eko-siahaan', 'realname' => 'Eko Siahaan', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => 'H02', 'branch_code' => 'H02', 'role' => 'customer'],
            ['email' => 'rina-saputra@wasnaker.lan', 'name' => 'rina-saputra', 'realname' => 'Rina Saputra', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => 'H03', 'branch_code' => 'H03', 'role' => 'customer'],
            ['email' => 'sari-utami@wasnaker.lan', 'name' => 'sari-utami', 'realname' => 'Sari Utami', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => 'H03', 'branch_code' => 'H03', 'role' => 'customer'],
            ['email' => 'dedi-nugroho@wasnaker.lan', 'name' => 'dedi-nugroho', 'realname' => 'Dedi Nugroho', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => 'I01', 'branch_code' => 'I01', 'role' => 'customer'],
            ['email' => 'budi-silitonga@wasnaker.lan', 'name' => 'budi-silitonga', 'realname' => 'Budi Silitonga', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => 'I01', 'branch_code' => 'I01', 'role' => 'customer'],
            ['email' => 'zainal-saputra@wasnaker.lan', 'name' => 'zainal-saputra', 'realname' => 'Zainal Saputra', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => 'I02', 'branch_code' => 'I02', 'role' => 'customer'],
            ['email' => 'tono-siregar@wasnaker.lan', 'name' => 'tono-siregar', 'realname' => 'Tono Siregar', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => 'I02', 'branch_code' => 'I02', 'role' => 'customer'],
            ['email' => 'putra-hidayat@wasnaker.lan', 'name' => 'putra-hidayat', 'realname' => 'Putra Hidayat', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => 'I03', 'branch_code' => 'I03', 'role' => 'customer'],
            ['email' => 'sari-nugroho@wasnaker.lan', 'name' => 'sari-nugroho', 'realname' => 'Sari Nugroho', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => 'I03', 'branch_code' => 'I03', 'role' => 'customer'],
            ['email' => 'cahyo-wibowo@wasnaker.lan', 'name' => 'cahyo-wibowo', 'realname' => 'Cahyo Wibowo', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => 'J01', 'branch_code' => 'J01', 'role' => 'customer'],
            ['email' => 'zainal-nugroho@wasnaker.lan', 'name' => 'zainal-nugroho', 'realname' => 'Zainal Nugroho', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => 'J01', 'branch_code' => 'J01', 'role' => 'customer'],
            ['email' => 'lina-pratama@wasnaker.lan', 'name' => 'lina-pratama', 'realname' => 'Lina Pratama', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => 'J02', 'branch_code' => 'J02', 'role' => 'customer'],
            ['email' => 'fajar-pratama@wasnaker.lan', 'name' => 'fajar-pratama', 'realname' => 'Fajar Pratama', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => 'J02', 'branch_code' => 'J02', 'role' => 'customer'],
            ['email' => 'sari-hutapea@wasnaker.lan', 'name' => 'sari-hutapea', 'realname' => 'Sari Hutapea', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => 'J03', 'branch_code' => 'J03', 'role' => 'customer'],
            ['email' => 'budi-lestari@wasnaker.lan', 'name' => 'budi-lestari', 'realname' => 'Budi Lestari', 'jabatan' => 'Admin Cabang', 'phone' => null, 'customer_code' => 'J03', 'branch_code' => 'J03', 'role' => 'customer'],
        ];

        foreach ($staffs as $s) {
            $user = User::firstOrCreate(
                ['email' => $s['email']],
                ['name' => $s['name'], 'password' => $password, 'is_active' => true]
            );

            // Normalisasi: users.name = slug realname (snapshot DemoSeeder
            // menulis "Admin PT X" — seeder staff menang).
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