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
 * Data dihasilkan dari DB staging (2026-09-04): 21 HO + 60 branch,
 * termasuk domisili (province/regency) yang sudah disebar agar tiap
 * unit Agency punya company. Idempotent: firstOrCreate by code (+parent).
 */
class CustomerDemoSeeder extends Seeder
{
    // [code, name, email, phone, address, is_active, province, regency, parent_code, npwp, vat_name, admin_email]
    private const DATA =     [
        // customer (HO)
        ['ALPHA', 'TEST 104614', 'alpha@mandala.demo', '11-5550001', NULL, 'true', 'Daerah Khusus Ibukota Jakarta', 'Kabupaten Administrasi Kepulauan Seribu', NULL, '01.001.001.001-001.001', 'HOOK TEST 105914', 'admin.alpha.0@wasnaker.lan'],
        // customer (HO)
        ['ANTARIKSA', 'PT Antariksa', 'antariksa@mandala.demo', '12-5550002', NULL, 'true', 'Jawa Barat', 'Kabupaten Bandung', NULL, '02.002.002.002-002.002', 'PT Antariksa', 'admin.antariksa.1@wasnaker.lan'],
        // customer (HO)
        ['BINTANG', 'PT Bintang', 'bintang@mandala.demo', '14-5550004', NULL, 'true', 'Sumatera Selatan', 'Kota Palembang', NULL, '04.004.004.004-004.004', 'PT Bintang', 'admin.bintang.3@wasnaker.lan'],
        // customer (HO)
        ['BIRU', 'PT Biru', 'biru@mandala.demo', '13-5550003', NULL, 'true', 'Jawa Tengah', 'Kabupaten Banjarnegara', NULL, '03.003.003.003-003.003', 'PT Biru', 'admin.biru.2@wasnaker.lan'],
        // customer (HO)
        ['CENDANA', 'PT Cendana', 'cendana@mandala.demo', '16-5550006', NULL, 'true', 'Banten', 'Kabupaten Lebak', NULL, '06.006.006.006-006.006', 'PT Cendana', 'admin.cendana.5@wasnaker.lan'],
        // customer (HO)
        ['CITRA', 'PT Citra', 'citra@mandala.demo', '15-5550005', NULL, 'true', 'Jawa Timur', 'Kabupaten Tulungagung', NULL, '05.005.005.005-005.005', 'PT Citra', 'admin.citra.4@wasnaker.lan'],
        // customer (HO)
        ['DAMAR', 'PT Damar', 'damar@mandala.demo', '17-5550007', NULL, 'true', 'Bali', 'Kabupaten Gianyar', NULL, '07.007.007.007-007.007', 'PT Damar', 'admin.damar.6@wasnaker.lan'],
        // customer (HO)
        ['DEWI', 'PT Dewi', 'dewi@mandala.demo', '02-5550008', NULL, 'true', 'Sumatera Utara', 'Kabupaten Nias', NULL, '08.008.008.008-008.008', 'PT Dewi', 'admin.dewi.7@wasnaker.lan'],
        // customer (HO)
        ['ELANG', 'PT Elang', 'elang@mandala.demo', '04-5550009', NULL, 'true', 'Riau', 'Kabupaten Indragiri Hilir', NULL, '09.009.009.009-009.009', 'PT Elang', 'admin.elang.8@wasnaker.lan'],
        // customer (HO)
        ['ESTU', 'PT Estu', 'estu@mandala.demo', '27-5550010', NULL, 'true', 'Sulawesi Selatan', 'Kabupaten Jeneponto', NULL, '10.010.010.010-010.010', 'PT Estu', 'admin.estu.9@wasnaker.lan'],
        // customer (HO)
        ['FAJAR', 'PT Fajar', 'fajar@mandala.demo', '11-5550011', NULL, 'true', 'Daerah Khusus Ibukota Jakarta', 'Kota Administrasi Jakarta Selatan', NULL, '11.011.011.011-011.011', 'PT Fajar', 'admin.fajar.10@wasnaker.lan'],
        // customer (HO)
        ['FLORES', 'PT Flores', 'flores@mandala.demo', '12-5550012', NULL, 'true', 'Jawa Barat', 'Kabupaten Ciamis', NULL, '12.012.012.012-012.012', 'PT Flores', 'admin.flores.11@wasnaker.lan'],
        // customer (HO)
        ['GAJAH', 'PT Gajah', 'gajah@mandala.demo', '13-5550013', NULL, 'true', 'Jawa Tengah', 'Kabupaten Wonosobo', NULL, '13.013.013.013-013.013', 'PT Gajah', 'admin.gajah.12@wasnaker.lan'],
        // customer (HO)
        ['GITA', 'PT Gita', 'gita@mandala.demo', '14-5550014', NULL, 'true', 'Sumatera Selatan', 'Kota Palembang', NULL, '14.014.014.014-014.014', 'PT Gita', 'admin.gita.13@wasnaker.lan'],
        // customer (HO)
        ['HARUM', 'PT Harum', 'harum@mandala.demo', '15-5550015', NULL, 'true', 'Jawa Timur', 'Kabupaten Malang', NULL, '15.015.015.015-015.015', 'PT Harum', 'admin.harum.14@wasnaker.lan'],
        // customer (HO)
        ['HIJAU', 'PT Hijau', 'hijau@mandala.demo', '16-5550016', NULL, 'true', 'Banten', 'Kota Serang', NULL, '16.016.016.016-016.016', 'PT Hijau', 'admin.hijau.15@wasnaker.lan'],
        // customer (HO)
        ['INDAH', 'PT Indah', 'indah@mandala.demo', '02-5550018', NULL, 'true', 'Sumatera Utara', 'Kabupaten Deli Serdang', NULL, '18.018.018.018-018.018', 'PT Indah', 'admin.indah.17@wasnaker.lan'],
        // customer (HO)
        ['INTAN', 'PT Intan', 'intan@mandala.demo', '17-5550017', NULL, 'true', 'Bali', 'Kabupaten Buleleng', NULL, '17.017.017.017-017.017', 'PT Intan', 'admin.intan.16@wasnaker.lan'],
        // customer (HO)
        ['JAYA', 'PT Jaya', 'jaya@mandala.demo', '04-5550019', NULL, 'true', 'Riau', 'Kabupaten Rokan Hilir', NULL, '19.019.019.019-019.019', 'PT Jaya', 'admin.jaya.18@wasnaker.lan'],
        // customer (HO)
        ['JINGGA', 'PT Jingga', 'jingga@mandala.demo', '27-5550020', NULL, 'true', 'Sulawesi Selatan', 'Kabupaten Sinjai', NULL, '20.020.020.020-020.020', 'PT Jingga', 'admin.jingga.19@wasnaker.lan'],
        // customer (HO)
        ['c1212', 'PT Test saja', 'batcasssh10@test.lan', '23243wqewe', NULL, 'true', 'Daerah Khusus Ibukota Jakarta', 'Kota Administrasi Jakarta Pusat', NULL, '20.021.020.021-020.020', 'PT Test saja', 'admin.test.77@wasnaker.lan'],
        // branch (HO: ALPHA)
        ['A01', 'Cabang Jawa Barat', NULL, '12-6660101', 'Jl. Contoh No. 00, Jawa Barat', 'true', 'Jawa Barat', 'Kabupaten Bogor', 'ALPHA', '01.001.001.001-003.001', 'PT Alpha - Cabang Jawa Barat', 'admin.alpha0.0@wasnaker.lan'],
        // branch (HO: ANTARIKSA)
        ['A01', 'Cabang Jawa Tengah', NULL, '13-6660201', 'Jl. Contoh No. 10, Jawa Tengah', 'true', 'Jawa Tengah', 'Kabupaten Cilacap', 'ANTARIKSA', '02.002.002.002-003.002', 'PT Antariksa - Cabang Jawa Tengah', 'admin.antariksa0.1@wasnaker.lan'],
        // branch (HO: ALPHA)
        ['A02', 'Plant Jawa Tengah', NULL, '13-6660102', 'Jl. Contoh No. 01, Jawa Tengah', 'true', 'Jawa Tengah', 'Kabupaten Cilacap', 'ALPHA', '01.001.001.001-004.001', 'PT Alpha - Plant Jawa Tengah', 'admin.alpha1.1@wasnaker.lan'],
        // branch (HO: ANTARIKSA)
        ['A02', 'Plant DI Yogyakarta', NULL, '14-6660202', 'Jl. Contoh No. 11, DI Yogyakarta', 'true', 'Daerah Istimewa Yogyakarta', 'Kabupaten Kulon Progo', 'ANTARIKSA', '02.002.002.002-004.002', 'PT Antariksa - Plant DI Yogyakarta', 'admin.antariksa1.2@wasnaker.lan'],
        // branch (HO: ALPHA)
        ['A03', 'Site DI Yogyakarta', NULL, '14-6660103', 'Jl. Contoh No. 02, DI Yogyakarta', 'true', 'Daerah Istimewa Yogyakarta', 'Kabupaten Kulon Progo', 'ALPHA', '01.001.001.001-005.001', 'PT Alpha - Site DI Yogyakarta', 'admin.alpha2.2@wasnaker.lan'],
        // branch (HO: ANTARIKSA)
        ['A03', 'Site Jawa Timur', NULL, '15-6660203', 'Jl. Contoh No. 12, Jawa Timur', 'true', 'Jawa Timur', 'Kabupaten Pacitan', 'ANTARIKSA', '02.002.002.002-005.002', 'PT Antariksa - Site Jawa Timur', 'admin.antariksa2.3@wasnaker.lan'],
        // branch (HO: BIRU)
        ['B01', 'Cabang DI Yogyakarta', NULL, '14-6660301', 'Jl. Contoh No. 20, DI Yogyakarta', 'true', 'Daerah Istimewa Yogyakarta', 'Kabupaten Kulon Progo', 'BIRU', '03.003.003.003-003.003', 'PT Biru', 'admin.biru0.2@wasnaker.lan'],
        // branch (HO: BINTANG)
        ['B01', 'Cabang Sumatera Selatan', NULL, '15-6660401', 'Jl. Contoh No. 30, Jawa Timur', 'true', 'Sumatera Selatan', 'Kabupaten Ogan Komering Ulu', 'BINTANG', '04.004.004.004-003.004', 'PT Bintang - Cabang Jawa Timur', 'admin.bintang0.3@wasnaker.lan'],
        // branch (HO: BIRU)
        ['B02', 'Plant Jawa Timur', NULL, '15-6660302', 'Jl. Contoh No. 21, Jawa Timur', 'true', 'Jawa Timur', 'Kabupaten Pacitan', 'BIRU', '03.003.003.003-004.003', 'PT Biru - Plant Jawa Timur', 'admin.biru1.3@wasnaker.lan'],
        // branch (HO: BINTANG)
        ['B02', 'Plant Sumatera Selatan', NULL, '16-6660402', 'Jl. Contoh No. 31, Banten', 'true', 'Sumatera Selatan', 'Kabupaten Lahat', 'BINTANG', '04.004.004.004-004.004', 'PT Bintang', 'admin.bintang1.4@wasnaker.lan'],
        // branch (HO: BIRU)
        ['B03', 'Site Banten', NULL, '16-6660303', 'Jl. Contoh No. 22, Banten', 'true', 'Banten', 'Kabupaten Pandeglang', 'BIRU', '03.003.003.003-005.003', 'PT Biru - Site Banten', 'admin.biru2.4@wasnaker.lan'],
        // branch (HO: BINTANG)
        ['B03', 'Site Sumatera Selatan', NULL, '17-6660403', 'Jl. Contoh No. 32, Bali', 'true', 'Sumatera Selatan', 'Kabupaten Banyuasin', 'BINTANG', '04.004.004.004-005.004', 'PT Bintang - Site Bali', 'admin.bintang2.5@wasnaker.lan'],
        // branch (HO: CITRA)
        ['C01', 'Cabang Banten', NULL, '16-6660501', 'Jl. Contoh No. 40, Banten', 'true', 'Banten', 'Kabupaten Pandeglang', 'CITRA', '05.005.005.005-003.005', 'PT Citra - Cabang Banten', 'admin.citra0.4@wasnaker.lan'],
        // branch (HO: CENDANA)
        ['C01', 'Cabang Bali', NULL, '17-6660601', 'Jl. Contoh No. 50, Bali', 'true', 'Bali', 'Kabupaten Jembrana', 'CENDANA', '06.006.006.006-003.006', 'PT Cendana - Cabang Bali', 'admin.cendana0.5@wasnaker.lan'],
        // branch (HO: CITRA)
        ['C02', 'Plant Bali', NULL, '17-6660502', 'Jl. Contoh No. 41, Bali', 'true', 'Bali', 'Kabupaten Jembrana', 'CITRA', '05.005.005.005-004.005', 'PT Citra - Plant Bali', 'admin.citra1.5@wasnaker.lan'],
        // branch (HO: CENDANA)
        ['C02', 'Plant Sumatera Utara', NULL, '02-6660602', 'Jl. Contoh No. 51, Sumatera Utara', 'true', 'Sumatera Utara', 'Kabupaten Tapanuli Tengah', 'CENDANA', '06.006.006.006-004.006', 'PT Cendana - Plant Sumatera Utara', 'admin.cendana1.6@wasnaker.lan'],
        // branch (HO: CITRA)
        ['C03', 'Site Sumatera Utara', NULL, '02-6660503', 'Jl. Contoh No. 42, Sumatera Utara', 'true', 'Sumatera Utara', 'Kabupaten Tapanuli Tengah', 'CITRA', '05.005.005.005-005.005', 'PT Citra', 'admin.citra2.6@wasnaker.lan'],
        // branch (HO: CENDANA)
        ['C03', 'Site Riau', NULL, '04-6660603', 'Jl. Contoh No. 52, Riau', 'true', 'Riau', 'Kabupaten Kampar', 'CENDANA', '06.006.006.006-005.006', 'PT Cendana - Site Riau', 'admin.cendana2.7@wasnaker.lan'],
        // branch (HO: DAMAR)
        ['D01', 'Cabang Sumatera Utara', NULL, '02-6660701', 'Jl. Contoh No. 60, Sumatera Utara', 'true', 'Sumatera Utara', 'Kabupaten Tapanuli Tengah', 'DAMAR', '07.007.007.007-003.007', 'PT Damar - Cabang Sumatera Utara', 'admin.damar0.6@wasnaker.lan'],
        // branch (HO: DEWI)
        ['D01', 'Cabang Riau', NULL, '04-6660801', 'Jl. Contoh No. 70, Riau', 'true', 'Riau', 'Kabupaten Kampar', 'DEWI', '08.008.008.008-003.008', 'PT Dewi - Cabang Riau', 'admin.dewi0.7@wasnaker.lan'],
        // branch (HO: DAMAR)
        ['D02', 'Plant Riau', NULL, '04-6660702', 'Jl. Contoh No. 61, Riau', 'true', 'Riau', 'Kabupaten Kampar', 'DAMAR', '07.007.007.007-004.007', 'PT Damar - Plant Riau', 'admin.damar1.7@wasnaker.lan'],
        // branch (HO: DEWI)
        ['D02', 'Plant Sulawesi Selatan', NULL, '27-6660802', 'Jl. Contoh No. 71, Sulawesi Selatan', 'true', 'Sulawesi Selatan', 'Kabupaten Kepulauan Selayar', 'DEWI', '08.008.008.008-004.008', 'PT Dewi - Plant Sulawesi Selatan', 'admin.dewi1.8@wasnaker.lan'],
        // branch (HO: DAMAR)
        ['D03', 'Site Sulawesi Selatan', NULL, '27-6660703', 'Jl. Contoh No. 62, Sulawesi Selatan', 'true', 'Sulawesi Selatan', 'Kabupaten Kepulauan Selayar', 'DAMAR', '07.007.007.007-005.007', 'PT Damar - Site Sulawesi Selatan', 'admin.damar2.8@wasnaker.lan'],
        // branch (HO: DEWI)
        ['D03', 'Site DKI Jakarta', NULL, '11-6660803', 'Jl. Contoh No. 72, DKI Jakarta', 'true', 'Daerah Khusus Ibukota Jakarta', 'Kabupaten Administrasi Kepulauan Seribu', 'DEWI', '08.008.008.008-005.008', 'PT Dewi - Site DKI Jakarta', 'admin.dewi2.9@wasnaker.lan'],
        // branch (HO: ELANG)
        ['E01', 'Cabang Sulawesi Selatan', NULL, '27-6660901', 'Jl. Contoh No. 80, Sulawesi Selatan', 'true', 'Sulawesi Selatan', 'Kabupaten Kepulauan Selayar', 'ELANG', '09.009.009.009-003.009', 'PT Elang - Cabang Sulawesi Selatan', 'admin.elang0.8@wasnaker.lan'],
        // branch (HO: ESTU)
        ['E01', 'Cabang DKI Jakarta', NULL, '11-6661001', 'Jl. Contoh No. 90, DKI Jakarta', 'true', 'Daerah Khusus Ibukota Jakarta', 'Kota Administrasi Jakarta Pusat', 'ESTU', '10.010.010.010-003.010', 'PT Estu - Cabang DKI Jakarta', 'admin.estu0.9@wasnaker.lan'],
        // branch (HO: ELANG)
        ['E02', 'Plant DKI Jakarta', NULL, '11-6660902', 'Jl. Contoh No. 81, DKI Jakarta', 'true', 'Daerah Khusus Ibukota Jakarta', 'Kabupaten Administrasi Kepulauan Seribu', 'ELANG', '09.009.009.009-004.009', 'PT Elang - Plant DKI Jakarta', 'admin.elang1.9@wasnaker.lan'],
        // branch (HO: ESTU)
        ['E02', 'Plant Jawa Barat', NULL, '12-6661002', 'Jl. Contoh No. 91, Jawa Barat', 'true', 'Jawa Barat', 'Kabupaten Cianjur', 'ESTU', '10.010.010.010-004.010', 'PT Estu - Plant Jawa Barat', 'admin.estu1.10@wasnaker.lan'],
        // branch (HO: ELANG)
        ['E03', 'Site Jawa Barat', NULL, '12-6660903', 'Jl. Contoh No. 82, Jawa Barat', 'true', 'Jawa Barat', 'Kabupaten Bogor', 'ELANG', '09.009.009.009-005.009', 'PT Elang - Site Jawa Barat', 'admin.elang2.10@wasnaker.lan'],
        // branch (HO: ESTU)
        ['E03', 'Site Jawa Tengah', NULL, '13-6661003', 'Jl. Contoh No. 92, Jawa Tengah', 'true', 'Jawa Tengah', 'Kabupaten Cilacap', 'ESTU', '10.010.010.010-005.010', 'PT Estu - Site Jawa Tengah', 'admin.estu2.11@wasnaker.lan'],
        // branch (HO: FAJAR)
        ['F01', 'Cabang Jawa Barat', NULL, '12-6661101', 'Jl. Contoh No. 100, Jawa Barat', 'true', 'Jawa Barat', 'Kabupaten Bogor', 'FAJAR', '11.011.011.011-003.011', 'PT Fajar - Cabang Jawa Barat', 'admin.fajar0.10@wasnaker.lan'],
        // branch (HO: FLORES)
        ['F01', 'Cabang Jawa Tengah', NULL, '13-6661201', 'Jl. Contoh No. 110, Jawa Tengah', 'true', 'Jawa Tengah', 'Kabupaten Cilacap', 'FLORES', '12.012.012.012-003.012', 'PT Flores - Cabang Jawa Tengah', 'admin.flores0.11@wasnaker.lan'],
        // branch (HO: FAJAR)
        ['F02', 'Plant Jawa Tengah', NULL, '13-6661102', 'Jl. Contoh No. 101, Jawa Tengah', 'true', 'Jawa Tengah', 'Kabupaten Cilacap', 'FAJAR', '11.011.011.011-004.011', 'PT Fajar - Plant Jawa Tengah', 'admin.fajar1.11@wasnaker.lan'],
        // branch (HO: FLORES)
        ['F02', 'Plant DI Yogyakarta', NULL, '14-6661202', 'Jl. Contoh No. 111, DI Yogyakarta', 'true', 'Daerah Istimewa Yogyakarta', 'Kabupaten Kulon Progo', 'FLORES', '12.012.012.012-004.012', 'PT Flores - Plant DI Yogyakarta', 'admin.flores1.12@wasnaker.lan'],
        // branch (HO: FAJAR)
        ['F03', 'Site DI Yogyakarta', NULL, '14-6661103', 'Jl. Contoh No. 102, DI Yogyakarta', 'true', 'Daerah Istimewa Yogyakarta', 'Kabupaten Kulon Progo', 'FAJAR', '11.011.011.011-005.011', 'PT Fajar - Site DI Yogyakarta', 'admin.fajar2.12@wasnaker.lan'],
        // branch (HO: FLORES)
        ['F03', 'Site Jawa Timur', NULL, '15-6661203', 'Jl. Contoh No. 112, Jawa Timur', 'true', 'Jawa Timur', 'Kabupaten Pacitan', 'FLORES', '12.012.012.012-005.012', 'PT Flores - Site Jawa Timur', 'admin.flores2.13@wasnaker.lan'],
        // branch (HO: GAJAH)
        ['G01', 'Cabang DI Yogyakarta', NULL, '14-6661301', 'Jl. Contoh No. 120, DI Yogyakarta', 'true', 'Daerah Istimewa Yogyakarta', 'Kabupaten Kulon Progo', 'GAJAH', '13.013.013.013-003.013', 'PT Gajah - Cabang DI Yogyakarta', 'admin.gajah0.12@wasnaker.lan'],
        // branch (HO: GITA)
        ['G01', 'Cabang Sumatera Selatan', NULL, '15-6661401', 'Jl. Contoh No. 130, Jawa Timur', 'true', 'Sumatera Selatan', 'Kabupaten Ogan Komering Ulu', 'GITA', '14.014.014.014-003.014', 'PT Gita - Cabang Jawa Timur', 'admin.gita0.13@wasnaker.lan'],
        // branch (HO: GAJAH)
        ['G02', 'Plant Jawa Timur', NULL, '15-6661302', 'Jl. Contoh No. 121, Jawa Timur', 'true', 'Jawa Timur', 'Kabupaten Pacitan', 'GAJAH', '13.013.013.013-004.013', 'PT Gajah - Plant Jawa Timur', 'admin.gajah1.13@wasnaker.lan'],
        // branch (HO: GITA)
        ['G02', 'Plant Sumatera Selatan', NULL, '16-6661402', 'Jl. Contoh No. 131, Banten', 'true', 'Sumatera Selatan', 'Kabupaten Lahat', 'GITA', '14.014.014.014-004.014', 'PT Gita - Plant Banten', 'admin.gita1.14@wasnaker.lan'],
        // branch (HO: GAJAH)
        ['G03', 'Site Banten', NULL, '16-6661303', 'Jl. Contoh No. 122, Banten', 'true', 'Banten', 'Kabupaten Pandeglang', 'GAJAH', '13.013.013.013-005.013', 'PT Gajah - Site Banten', 'admin.gajah2.14@wasnaker.lan'],
        // branch (HO: GITA)
        ['G03', 'Site Sumatera Selatan', NULL, '17-6661403', 'Jl. Contoh No. 132, Bali', 'true', 'Sumatera Selatan', 'Kabupaten Banyuasin', 'GITA', '14.014.014.014-005.014', 'PT Gita - Site Bali', 'admin.gita2.15@wasnaker.lan'],
        // branch (HO: HARUM)
        ['H01', 'Cabang Banten', NULL, '16-6661501', 'Jl. Contoh No. 140, Banten', 'true', 'Banten', 'Kabupaten Pandeglang', 'HARUM', '15.015.015.015-003.015', 'PT Harum - Cabang Banten', 'admin.harum0.14@wasnaker.lan'],
        // branch (HO: HIJAU)
        ['H01', 'Cabang Bali', NULL, '17-6661601', 'Jl. Contoh No. 150, Bali', 'true', 'Bali', 'Kabupaten Jembrana', 'HIJAU', '16.016.016.016-003.016', 'PT Hijau - Cabang Bali', 'admin.hijau0.15@wasnaker.lan'],
        // branch (HO: HARUM)
        ['H02', 'Plant Bali', NULL, '17-6661502', 'Jl. Contoh No. 141, Bali', 'true', 'Bali', 'Kabupaten Jembrana', 'HARUM', '15.015.015.015-004.015', 'PT Harum - Plant Bali', 'admin.harum1.15@wasnaker.lan'],
        // branch (HO: HIJAU)
        ['H02', 'Plant Sumatera Utara', NULL, '02-6661602', 'Jl. Contoh No. 151, Sumatera Utara', 'true', 'Sumatera Utara', 'Kabupaten Tapanuli Tengah', 'HIJAU', '16.016.016.016-004.016', 'PT Hijau - Plant Sumatera Utara', 'admin.hijau1.16@wasnaker.lan'],
        // branch (HO: HARUM)
        ['H03', 'Site Sumatera Utara', NULL, '02-6661503', 'Jl. Contoh No. 142, Sumatera Utara', 'true', 'Sumatera Utara', 'Kabupaten Tapanuli Tengah', 'HARUM', '15.015.015.015-005.015', 'PT Harum - Site Sumatera Utara', 'admin.harum2.16@wasnaker.lan'],
        // branch (HO: HIJAU)
        ['H03', 'Site Riau', NULL, '04-6661603', 'Jl. Contoh No. 152, Riau', 'true', 'Riau', 'Kabupaten Kampar', 'HIJAU', '16.016.016.016-005.016', 'PT Hijau - Site Riau', 'admin.hijau2.17@wasnaker.lan'],
        // branch (HO: INTAN)
        ['I01', 'Cabang Sumatera Utara', NULL, '02-6661701', 'Jl. Contoh No. 160, Sumatera Utara', 'true', 'Sumatera Utara', 'Kabupaten Tapanuli Tengah', 'INTAN', '17.017.017.017-003.017', 'PT Intan - Cabang Sumatera Utara', 'admin.intan0.16@wasnaker.lan'],
        // branch (HO: INDAH)
        ['I01', 'Cabang Riau', NULL, '04-6661801', 'Jl. Contoh No. 170, Riau', 'true', 'Riau', 'Kabupaten Kampar', 'INDAH', '18.018.018.018-003.018', 'PT Indah - Cabang Riau', 'admin.indah0.17@wasnaker.lan'],
        // branch (HO: INTAN)
        ['I02', 'Plant Riau', NULL, '04-6661702', 'Jl. Contoh No. 161, Riau', 'true', 'Riau', 'Kabupaten Kampar', 'INTAN', '17.017.017.017-004.017', 'PT Intan - Plant Riau', 'admin.intan1.17@wasnaker.lan'],
        // branch (HO: INDAH)
        ['I02', 'Plant Sulawesi Selatan', NULL, '27-6661802', 'Jl. Contoh No. 171, Sulawesi Selatan', 'true', 'Sulawesi Selatan', 'Kabupaten Kepulauan Selayar', 'INDAH', '18.018.018.018-004.018', 'PT Indah - Plant Sulawesi Selatan', 'admin.indah1.18@wasnaker.lan'],
        // branch (HO: INTAN)
        ['I03', 'Site Sulawesi Selatan', NULL, '27-6661703', 'Jl. Contoh No. 162, Sulawesi Selatan', 'true', 'Sulawesi Selatan', 'Kabupaten Kepulauan Selayar', 'INTAN', '17.017.017.017-005.017', 'PT Intan - Site Sulawesi Selatan', 'admin.intan2.18@wasnaker.lan'],
        // branch (HO: INDAH)
        ['I03', 'Site DKI Jakarta', NULL, '11-6661803', 'Jl. Contoh No. 172, DKI Jakarta', 'true', 'Daerah Khusus Ibukota Jakarta', 'Kabupaten Administrasi Kepulauan Seribu', 'INDAH', '18.018.018.018-005.018', 'PT Indah - Site DKI Jakarta', 'admin.indah2.19@wasnaker.lan'],
        // branch (HO: JAYA)
        ['J01', 'Cabang Sulawesi Selatan', NULL, '27-6661901', 'Jl. Contoh No. 180, Sulawesi Selatan', 'true', 'Sulawesi Selatan', 'Kabupaten Kepulauan Selayar', 'JAYA', '19.019.019.019-003.019', 'PT Jaya - Cabang Sulawesi Selatan', 'admin.jaya0.18@wasnaker.lan'],
        // branch (HO: JINGGA)
        ['J01', 'Cabang DKI Jakarta', NULL, '11-6662001', 'Jl. Contoh No. 190, DKI Jakarta', 'true', 'Daerah Khusus Ibukota Jakarta', 'Kota Administrasi Jakarta Utara ', 'JINGGA', '20.020.020.020-003.020', 'PT Jingga - Cabang DKI Jakarta', 'admin.jingga0.19@wasnaker.lan'],
        // branch (HO: JAYA)
        ['J02', 'Plant DKI Jakarta', NULL, '11-6661902', 'Jl. Contoh No. 181, DKI Jakarta', 'true', 'Daerah Khusus Ibukota Jakarta', 'Kabupaten Administrasi Kepulauan Seribu', 'JAYA', '19.019.019.019-004.019', 'PT Jaya - Plant DKI Jakarta', 'admin.jaya1.19@wasnaker.lan'],
        // branch (HO: JINGGA)
        ['J02', 'Plant Jawa Barat', NULL, '12-6662002', 'Jl. Contoh No. 191, Jawa Barat', 'true', 'Jawa Barat', 'Kabupaten Sukabumi', 'JINGGA', '20.020.020.020-004.020', 'PT Jingga - Plant Jawa Barat', 'admin.jingga1.20@wasnaker.lan'],
        // branch (HO: JAYA)
        ['J03', 'Site Jawa Barat', NULL, '12-6661903', 'Jl. Contoh No. 182, Jawa Barat', 'true', 'Jawa Barat', 'Kabupaten Bogor', 'JAYA', '19.019.019.019-005.019', 'PT Jaya - Site Jawa Barat', 'admin.jaya2.20@wasnaker.lan'],
        // branch (HO: JINGGA)
        ['J03', 'Site Jawa Tengah', NULL, '13-6662003', 'Jl. Contoh No. 192, Jawa Tengah', 'true', 'Jawa Tengah', 'Kabupaten Cilacap', 'JINGGA', '20.020.020.020-005.020', 'PT Jingga - Site Jawa Tengah', 'admin.jingga2.21@wasnaker.lan'],
    ];

    public function run(): void
    {
        $provinces = Province::pluck('id', 'name');
        $regencies = Regency::select('id', 'name', 'province_id')->get()
            ->keyBy(fn ($r) => $r->province_id . ':' . $r->name);

        $hoIds = []; // code => id
        foreach (self::DATA as [$code, $name, $email, $phone, $address, $isActive, $province, $regency, $parentCode, $npwp, $vatName, $adminEmail]) {
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
}