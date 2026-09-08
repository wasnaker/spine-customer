<?php

namespace Modules\Customer\Database\Seeders;

use Illuminate\Database\Seeder;

class CustomerVatsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('vats')->whereIn('id', [1, 3, 4, 5, 6, 7, 8, 10, 11, 13, 14, 16, 17, 18, 20, 21, 22, 24, 25, 26, 28, 29, 30, 32, 33, 34, 36, 37, 38, 40, 41, 42, 44, 45, 46, 48, 49, 50, 52, 53, 54, 56, 57, 58, 60, 61, 62, 64, 65, 66, 68, 69, 70, 72, 73, 74, 76, 77, 78, 79, 80, 81, 82, 83, 84, 85, 86, 87, 88, 89, 90, 91, 92, 93, 94, 95, 96, 97])->delete();
        
        \DB::table('vats')->insert(array (
            0 => 
            array (
                'id' => 1,
                'ulid' => '01m1xs5zjemfj8p7nsmg6408zy',
                'npwp' => '01.001.001.001-001.001',
                'name' => 'PT Citra Buana - Plant Jawa Tengah',
                'created_at' => '2026-09-07 11:13:46',
                'updated_at' => '2026-09-07 15:59:11',
            ),
            1 => 
            array (
                'id' => 3,
                'ulid' => '01m1xs940spnt3060nt1kx6q2c',
                'npwp' => '01.001.001.001-003.001',
                'name' => 'PT Cipta Karya - Cabang Jawa Barat',
                'created_at' => '2026-09-07 11:15:28',
                'updated_at' => '2026-09-07 12:11:59',
            ),
            2 => 
            array (
                'id' => 4,
                'ulid' => '01m1xs9411ybp52m7rxv0p7han',
                'npwp' => '01.001.001.001-004.001',
                'name' => 'PT Cipta Karya - Plant Jawa Tengah',
                'created_at' => '2026-09-07 11:15:28',
                'updated_at' => '2026-09-07 12:11:59',
            ),
            3 => 
            array (
                'id' => 5,
                'ulid' => '01m1xs941aknyjzmkr6dpwg1yg',
                'npwp' => '02.002.002.002-002.002',
                'name' => 'PT Delta Mandiri - Plant DI Yogyakarta',
                'created_at' => '2026-09-07 11:15:28',
                'updated_at' => '2026-09-07 15:59:11',
            ),
            4 => 
            array (
                'id' => 6,
                'ulid' => '01m1xs941qcd3vjxheyntrd5fe',
                'npwp' => '02.002.002.002-003.002',
                'name' => 'PT Nusantara Sejahtera - Cabang Jawa Tengah',
                'created_at' => '2026-09-07 11:15:28',
                'updated_at' => '2026-09-07 12:11:59',
            ),
            5 => 
            array (
                'id' => 7,
                'ulid' => '01m1xs9420ym8r261vqrpgyq4q',
                'npwp' => '02.002.002.002-004.002',
                'name' => 'PT Nusantara Sejahtera - Plant DI Yogyakarta',
                'created_at' => '2026-09-07 11:15:28',
                'updated_at' => '2026-09-07 12:11:59',
            ),
            6 => 
            array (
                'id' => 8,
                'ulid' => '01m1xs9428nn2vvtx70qejrj5y',
                'npwp' => '03.003.003.003-003.003',
                'name' => 'PT Garuda Perkasa - Plant Jawa Timur',
                'created_at' => '2026-09-07 11:15:28',
                'updated_at' => '2026-09-07 15:59:11',
            ),
            7 => 
            array (
                'id' => 10,
                'ulid' => '01m1xs9432713mkmer51jm66jq',
                'npwp' => '03.003.003.003-004.003',
                'name' => 'PT Jaya Abadi - Plant Jawa Timur',
                'created_at' => '2026-09-07 11:15:28',
                'updated_at' => '2026-09-07 12:11:59',
            ),
            8 => 
            array (
                'id' => 11,
                'ulid' => '01m1xs943dh6h5n27a02dxgy16',
                'npwp' => '04.004.004.004-004.004',
                'name' => 'PT Karya Bahari - Plant DKI Jakarta',
                'created_at' => '2026-09-07 11:15:29',
                'updated_at' => '2026-09-07 15:59:11',
            ),
            9 => 
            array (
                'id' => 13,
                'ulid' => '01m1xs944aq98pg1890tfg6654',
                'npwp' => '04.004.004.004-003.004',
                'name' => 'PT Bina Marga - Cabang Sumatera Selatan',
                'created_at' => '2026-09-07 11:15:29',
                'updated_at' => '2026-09-07 12:11:59',
            ),
            10 => 
            array (
                'id' => 14,
                'ulid' => '01m1xs9451jc1wp1fq7e2tzdx8',
                'npwp' => '05.005.005.005-005.005',
                'name' => 'PT Lestari Nusantara - Plant Jawa Barat',
                'created_at' => '2026-09-07 11:15:29',
                'updated_at' => '2026-09-07 15:59:11',
            ),
            11 => 
            array (
                'id' => 16,
                'ulid' => '01m1xs945xyq0ne3r9jwf1eb1h',
                'npwp' => '05.005.005.005-003.005',
                'name' => 'PT Sinar Mas - Cabang Banten',
                'created_at' => '2026-09-07 11:15:29',
                'updated_at' => '2026-09-07 12:11:59',
            ),
            12 => 
            array (
                'id' => 17,
                'ulid' => '01m1xs9469t53x45g0e1j4ehwy',
                'npwp' => '05.005.005.005-004.005',
                'name' => 'PT Sinar Mas - Plant Bali',
                'created_at' => '2026-09-07 11:15:29',
                'updated_at' => '2026-09-07 12:11:59',
            ),
            13 => 
            array (
                'id' => 18,
                'ulid' => '01m1xs946nrsjrvtfsneh5t063',
                'npwp' => '06.006.006.006-006.006',
                'name' => 'PT Surya Pratama - Plant Jawa Tengah',
                'created_at' => '2026-09-07 11:15:29',
                'updated_at' => '2026-09-07 15:59:11',
            ),
            14 => 
            array (
                'id' => 20,
                'ulid' => '01m1xs947kzsr75pk8jx75vzy5',
                'npwp' => '06.006.006.006-003.006',
                'name' => 'PT Mulia Bersama - Cabang Bali',
                'created_at' => '2026-09-07 11:15:29',
                'updated_at' => '2026-09-07 12:11:59',
            ),
            15 => 
            array (
                'id' => 21,
                'ulid' => '01m1xs9482fge2p4fmenjtbbpn',
                'npwp' => '06.006.006.006-004.006',
                'name' => 'PT Mulia Bersama - Plant Sumatera Utara',
                'created_at' => '2026-09-07 11:15:29',
                'updated_at' => '2026-09-07 12:11:59',
            ),
            16 => 
            array (
                'id' => 22,
                'ulid' => '01m1xs948jq2hndeam4zgpshm9',
                'npwp' => '07.007.007.007-007.007',
                'name' => 'PT Nusa Indah - Plant DI Yogyakarta',
                'created_at' => '2026-09-07 11:15:29',
                'updated_at' => '2026-09-07 15:59:11',
            ),
            17 => 
            array (
                'id' => 24,
                'ulid' => '01m1xs949a0rqn02vqz4k96je1',
                'npwp' => '07.007.007.007-003.007',
                'name' => 'PT Bumi Persada - Cabang Sumatera Utara',
                'created_at' => '2026-09-07 11:15:29',
                'updated_at' => '2026-09-07 12:11:59',
            ),
            18 => 
            array (
                'id' => 25,
                'ulid' => '01m1xs949q07xg9eq2hn2ncxs8',
                'npwp' => '07.007.007.007-004.007',
                'name' => 'PT Bumi Persada - Plant Riau',
                'created_at' => '2026-09-07 11:15:29',
                'updated_at' => '2026-09-07 12:11:59',
            ),
            19 => 
            array (
                'id' => 26,
                'ulid' => '01m1xs94a450afpd10m6wscv65',
                'npwp' => '08.008.008.008-008.008',
                'name' => 'PT Pilar Sejahtera - Plant Jawa Timur',
                'created_at' => '2026-09-07 11:15:29',
                'updated_at' => '2026-09-07 15:59:11',
            ),
            20 => 
            array (
                'id' => 28,
                'ulid' => '01m1xs94axj28sf0952rwg146f',
                'npwp' => '08.008.008.008-003.008',
                'name' => 'PT Prima Utama - Cabang Riau',
                'created_at' => '2026-09-07 11:15:29',
                'updated_at' => '2026-09-07 12:11:59',
            ),
            21 => 
            array (
                'id' => 29,
                'ulid' => '01m1xs94bd8xy3vnew8sdshj63',
                'npwp' => '08.008.008.008-004.008',
                'name' => 'PT Prima Utama - Plant Sulawesi Selatan',
                'created_at' => '2026-09-07 11:15:29',
                'updated_at' => '2026-09-07 12:11:59',
            ),
            22 => 
            array (
                'id' => 30,
                'ulid' => '01m1xs94bsyx7zq5ysr7cqw5hz',
                'npwp' => '09.009.009.009-009.009',
                'name' => 'PT Rajawali Nusantara - Plant DKI Jakarta',
                'created_at' => '2026-09-07 11:15:29',
                'updated_at' => '2026-09-07 15:59:11',
            ),
            23 => 
            array (
                'id' => 32,
                'ulid' => '01m1xs94chdd17hafhhcs90mea',
                'npwp' => '09.009.009.009-003.009',
                'name' => 'PT Indah Kiat - Cabang Sulawesi Selatan',
                'created_at' => '2026-09-07 11:15:29',
                'updated_at' => '2026-09-07 12:11:59',
            ),
            24 => 
            array (
                'id' => 33,
                'ulid' => '01m1xs94cvkf00trfzhrqf4tmz',
                'npwp' => '09.009.009.009-004.009',
                'name' => 'PT Indah Kiat - Plant DKI Jakarta',
                'created_at' => '2026-09-07 11:15:29',
                'updated_at' => '2026-09-07 12:11:59',
            ),
            25 => 
            array (
                'id' => 34,
                'ulid' => '01m1xs94d8c1rw98gv6kdh8qkv',
                'npwp' => '10.010.010.010-010.010',
                'name' => 'PT Tunas Karya - Plant Jawa Barat',
                'created_at' => '2026-09-07 11:15:29',
                'updated_at' => '2026-09-07 15:59:11',
            ),
            26 => 
            array (
                'id' => 36,
                'ulid' => '01m1xs94dxpbmxtevc451v4smd',
                'npwp' => '10.010.010.010-003.010',
                'name' => 'PT Surya Gemilang - Cabang DKI Jakarta',
                'created_at' => '2026-09-07 11:15:29',
                'updated_at' => '2026-09-07 12:11:59',
            ),
            27 => 
            array (
                'id' => 37,
                'ulid' => '01m1xs94e8b8ms7xp71nhkjan8',
                'npwp' => '10.010.010.010-004.010',
                'name' => 'PT Surya Gemilang - Plant Jawa Barat',
                'created_at' => '2026-09-07 11:15:29',
                'updated_at' => '2026-09-07 12:11:59',
            ),
            28 => 
            array (
                'id' => 38,
                'ulid' => '01m1xs94epyz8nyqfp52va73bb',
                'npwp' => '11.011.011.011-011.011',
                'name' => 'PT Kencana Tunggal',
                'created_at' => '2026-09-07 11:15:29',
                'updated_at' => '2026-09-07 12:11:59',
            ),
            29 => 
            array (
                'id' => 40,
                'ulid' => '01m1xs94fd40v37v5n2ht3bf4y',
                'npwp' => '11.011.011.011-003.011',
                'name' => 'PT Kencana Tunggal - Cabang Jawa Barat',
                'created_at' => '2026-09-07 11:15:29',
                'updated_at' => '2026-09-07 12:11:59',
            ),
            30 => 
            array (
                'id' => 41,
                'ulid' => '01m1xs94fr24057s9rs84a7eey',
                'npwp' => '11.011.011.011-004.011',
                'name' => 'PT Kencana Tunggal - Plant Jawa Tengah',
                'created_at' => '2026-09-07 11:15:29',
                'updated_at' => '2026-09-07 12:11:59',
            ),
            31 => 
            array (
                'id' => 42,
                'ulid' => '01m1xs94g1nbmt7gy4y5hd81n4',
                'npwp' => '12.012.012.012-012.012',
                'name' => 'PT Harapan Jaya',
                'created_at' => '2026-09-07 11:15:29',
                'updated_at' => '2026-09-07 12:11:59',
            ),
            32 => 
            array (
                'id' => 44,
                'ulid' => '01m1xs94gsqwtja7a1jgtkzwcx',
                'npwp' => '12.012.012.012-003.012',
                'name' => 'PT Harapan Jaya - Cabang Jawa Tengah',
                'created_at' => '2026-09-07 11:15:29',
                'updated_at' => '2026-09-07 12:11:59',
            ),
            33 => 
            array (
                'id' => 45,
                'ulid' => '01m1xs94h5j6e8mhgzqwy9yhxc',
                'npwp' => '12.012.012.012-004.012',
                'name' => 'PT Harapan Jaya - Plant DI Yogyakarta',
                'created_at' => '2026-09-07 11:15:29',
                'updated_at' => '2026-09-07 12:11:59',
            ),
            34 => 
            array (
                'id' => 46,
                'ulid' => '01m1xs94hk6kr8rt6m7sdnh2qj',
                'npwp' => '13.013.013.013-013.013',
                'name' => 'PT Berkah Mandiri',
                'created_at' => '2026-09-07 11:15:29',
                'updated_at' => '2026-09-07 12:12:00',
            ),
            35 => 
            array (
                'id' => 48,
                'ulid' => '01m1xs94j4q1r1a13tw42f8qd7',
                'npwp' => '13.013.013.013-003.013',
                'name' => 'PT Berkah Mandiri - Cabang DI Yogyakarta',
                'created_at' => '2026-09-07 11:15:29',
                'updated_at' => '2026-09-07 12:12:00',
            ),
            36 => 
            array (
                'id' => 49,
                'ulid' => '01m1xs94jc3n0dnkc8qs5zpvt3',
                'npwp' => '13.013.013.013-004.013',
                'name' => 'PT Berkah Mandiri - Plant Jawa Timur',
                'created_at' => '2026-09-07 11:15:29',
                'updated_at' => '2026-09-07 12:12:00',
            ),
            37 => 
            array (
                'id' => 50,
                'ulid' => '01m1xs94jns310hn6zssfvzzv3',
                'npwp' => '14.014.014.014-014.014',
                'name' => 'PT Cahaya Nusantara',
                'created_at' => '2026-09-07 11:15:29',
                'updated_at' => '2026-09-07 12:12:00',
            ),
            38 => 
            array (
                'id' => 52,
                'ulid' => '01m1xs94rwdgcm51fd8p8jx70g',
                'npwp' => '14.014.014.014-003.014',
                'name' => 'PT Cahaya Nusantara - Cabang Sumatera Selatan',
                'created_at' => '2026-09-07 11:15:29',
                'updated_at' => '2026-09-07 12:12:00',
            ),
            39 => 
            array (
                'id' => 53,
                'ulid' => '01m1xs94x0nszv2wm8sy4hf0fs',
                'npwp' => '14.014.014.014-004.014',
                'name' => 'PT Cahaya Nusantara - Plant Sumatera Selatan',
                'created_at' => '2026-09-07 11:15:29',
                'updated_at' => '2026-09-07 12:12:00',
            ),
            40 => 
            array (
                'id' => 54,
                'ulid' => '01m1xs94xd598sgn65d7xg695h',
                'npwp' => '15.015.015.015-015.015',
                'name' => 'PT Sentosa Abadi',
                'created_at' => '2026-09-07 11:15:29',
                'updated_at' => '2026-09-07 12:12:00',
            ),
            41 => 
            array (
                'id' => 56,
                'ulid' => '01m1xs94y7fy7n1nhcj85hndzm',
                'npwp' => '15.015.015.015-003.015',
                'name' => 'PT Sentosa Abadi - Cabang Banten',
                'created_at' => '2026-09-07 11:15:29',
                'updated_at' => '2026-09-07 12:12:00',
            ),
            42 => 
            array (
                'id' => 57,
                'ulid' => '01m1xs94ymg8hvykndf29pysq7',
                'npwp' => '15.015.015.015-004.015',
                'name' => 'PT Sentosa Abadi - Plant Bali',
                'created_at' => '2026-09-07 11:15:29',
                'updated_at' => '2026-09-07 12:12:00',
            ),
            43 => 
            array (
                'id' => 58,
                'ulid' => '01m1xs94z19tnsyb4454ana7mp',
                'npwp' => '16.016.016.016-016.016',
                'name' => 'PT Mitra Sejati',
                'created_at' => '2026-09-07 11:15:29',
                'updated_at' => '2026-09-07 12:12:00',
            ),
            44 => 
            array (
                'id' => 60,
                'ulid' => '01m1xs94zve9cn8eh347czpk5z',
                'npwp' => '16.016.016.016-003.016',
                'name' => 'PT Mitra Sejati - Cabang Bali',
                'created_at' => '2026-09-07 11:15:29',
                'updated_at' => '2026-09-07 12:12:00',
            ),
            45 => 
            array (
                'id' => 61,
                'ulid' => '01m1xs9509sardx0q3marejk1f',
                'npwp' => '16.016.016.016-004.016',
                'name' => 'PT Mitra Sejati - Plant Sumatera Utara',
                'created_at' => '2026-09-07 11:15:29',
                'updated_at' => '2026-09-07 12:12:00',
            ),
            46 => 
            array (
                'id' => 62,
                'ulid' => '01m1xs950prqmqxx04r02ha0z5',
                'npwp' => '17.017.017.017-017.017',
                'name' => 'PT Wijaya Karya',
                'created_at' => '2026-09-07 11:15:29',
                'updated_at' => '2026-09-07 12:12:00',
            ),
            47 => 
            array (
                'id' => 64,
                'ulid' => '01m1xs951hcjwega72ntg3vr79',
                'npwp' => '17.017.017.017-003.017',
                'name' => 'PT Wijaya Karya - Cabang Sumatera Utara',
                'created_at' => '2026-09-07 11:15:29',
                'updated_at' => '2026-09-07 12:12:00',
            ),
            48 => 
            array (
                'id' => 65,
                'ulid' => '01m1xs951x2ywmgb8hcy2s2vxz',
                'npwp' => '17.017.017.017-004.017',
                'name' => 'PT Wijaya Karya - Plant Riau',
                'created_at' => '2026-09-07 11:15:29',
                'updated_at' => '2026-09-07 12:12:00',
            ),
            49 => 
            array (
                'id' => 66,
                'ulid' => '01m1xs9529pgn30yd9fmwght5m',
                'npwp' => '18.018.018.018-018.018',
                'name' => 'PT Prasetya Utama',
                'created_at' => '2026-09-07 11:15:29',
                'updated_at' => '2026-09-07 12:12:00',
            ),
            50 => 
            array (
                'id' => 68,
                'ulid' => '01m1xs953bch9z1k18ma93xw9x',
                'npwp' => '18.018.018.018-003.018',
                'name' => 'PT Prasetya Utama - Cabang Riau',
                'created_at' => '2026-09-07 11:15:30',
                'updated_at' => '2026-09-07 12:12:00',
            ),
            51 => 
            array (
                'id' => 69,
                'ulid' => '01m1xs9542836mevrzv5c1ma5j',
                'npwp' => '18.018.018.018-004.018',
                'name' => 'PT Prasetya Utama - Plant Sulawesi Selatan',
                'created_at' => '2026-09-07 11:15:30',
                'updated_at' => '2026-09-07 12:12:00',
            ),
            52 => 
            array (
                'id' => 70,
                'ulid' => '01m1xs954n80csty09t085497c',
                'npwp' => '19.019.019.019-019.019',
                'name' => 'PT Bhakti Nusantara',
                'created_at' => '2026-09-07 11:15:30',
                'updated_at' => '2026-09-07 12:12:00',
            ),
            53 => 
            array (
                'id' => 72,
                'ulid' => '01m1xs955w9k2dfrq6y00xw8dr',
                'npwp' => '19.019.019.019-003.019',
                'name' => 'PT Bhakti Nusantara - Cabang Sulawesi Selatan',
                'created_at' => '2026-09-07 11:15:30',
                'updated_at' => '2026-09-07 12:12:01',
            ),
            54 => 
            array (
                'id' => 73,
                'ulid' => '01m1xs956fak7vz3gx0mdwza83',
                'npwp' => '19.019.019.019-004.019',
                'name' => 'PT Bhakti Nusantara - Plant DKI Jakarta',
                'created_at' => '2026-09-07 11:15:30',
                'updated_at' => '2026-09-07 12:12:01',
            ),
            55 => 
            array (
                'id' => 74,
                'ulid' => '01m1xs956ztxt8t4d7vddyrrkd',
                'npwp' => '20.020.020.020-020.020',
                'name' => 'PT Sukses Mandiri',
                'created_at' => '2026-09-07 11:15:30',
                'updated_at' => '2026-09-07 12:12:01',
            ),
            56 => 
            array (
                'id' => 76,
                'ulid' => '01m1xs95879hvqwwzn4h5v5kdx',
                'npwp' => '20.020.020.020-003.020',
                'name' => 'PT Sukses Mandiri - Cabang DKI Jakarta',
                'created_at' => '2026-09-07 11:15:30',
                'updated_at' => '2026-09-07 12:12:01',
            ),
            57 => 
            array (
                'id' => 77,
                'ulid' => '01m1xs958vt639mhae8s68g151',
                'npwp' => '20.020.020.020-004.020',
                'name' => 'PT Sukses Mandiri - Plant Jawa Barat',
                'created_at' => '2026-09-07 11:15:30',
                'updated_at' => '2026-09-07 12:12:01',
            ),
            58 => 
            array (
                'id' => 78,
                'ulid' => '01m1xvv6jdf7455e5k9h55zvmr',
                'npwp' => '20.021.020.021-020.020',
                'name' => 'PT Karunia Abadi',
                'created_at' => '2026-09-07 12:00:18',
                'updated_at' => '2026-09-07 12:12:01',
            ),
            59 => 
            array (
                'id' => 79,
                'ulid' => '01m1xvv892k82dtkbq3n3xc9ck',
                'npwp' => '01.001.001.001-005.001',
                'name' => 'PT Cipta Karya - Site DI Yogyakarta',
                'created_at' => '2026-09-07 12:00:20',
                'updated_at' => '2026-09-07 12:11:59',
            ),
            60 => 
            array (
                'id' => 80,
                'ulid' => '01m1xvv8hysrpvy5n6m8jj15rz',
                'npwp' => '02.002.002.002-005.002',
                'name' => 'PT Nusantara Sejahtera - Site Jawa Timur',
                'created_at' => '2026-09-07 12:00:20',
                'updated_at' => '2026-09-07 12:11:59',
            ),
            61 => 
            array (
                'id' => 81,
                'ulid' => '01m1xvvaeznhmdq9tngaxn399z',
                'npwp' => '03.003.003.003-005.003',
                'name' => 'PT Jaya Abadi - Site Banten',
                'created_at' => '2026-09-07 12:00:22',
                'updated_at' => '2026-09-07 12:11:59',
            ),
            62 => 
            array (
                'id' => 82,
                'ulid' => '01m1xvvb3bj90b9qphxv3dak6j',
                'npwp' => '04.004.004.004-005.004',
                'name' => 'PT Bina Marga - Site Sumatera Selatan',
                'created_at' => '2026-09-07 12:00:23',
                'updated_at' => '2026-09-07 12:11:59',
            ),
            63 => 
            array (
                'id' => 83,
                'ulid' => '01m1xvvd5z6rfy3jm6nkspp61e',
                'npwp' => '06.006.006.006-005.006',
                'name' => 'PT Mulia Bersama - Site Riau',
                'created_at' => '2026-09-07 12:00:25',
                'updated_at' => '2026-09-07 12:11:59',
            ),
            64 => 
            array (
                'id' => 84,
                'ulid' => '01m1xvvffn771r47rg0fyd394t',
                'npwp' => '07.007.007.007-005.007',
                'name' => 'PT Bumi Persada - Site Sulawesi Selatan',
                'created_at' => '2026-09-07 12:00:27',
                'updated_at' => '2026-09-07 12:11:59',
            ),
            65 => 
            array (
                'id' => 85,
                'ulid' => '01m1xvvfvx9se2kdxtgb497thg',
                'npwp' => '08.008.008.008-005.008',
                'name' => 'PT Prima Utama - Site DKI Jakarta',
                'created_at' => '2026-09-07 12:00:28',
                'updated_at' => '2026-09-07 12:11:59',
            ),
            66 => 
            array (
                'id' => 86,
                'ulid' => '01m1xvvhchmcye0pkmadaghy4h',
                'npwp' => '09.009.009.009-005.009',
                'name' => 'PT Indah Kiat - Site Jawa Barat',
                'created_at' => '2026-09-07 12:00:29',
                'updated_at' => '2026-09-07 12:11:59',
            ),
            67 => 
            array (
                'id' => 87,
                'ulid' => '01m1xvvhyawbjm41x9qyc78svy',
                'npwp' => '10.010.010.010-005.010',
                'name' => 'PT Surya Gemilang - Site Jawa Tengah',
                'created_at' => '2026-09-07 12:00:30',
                'updated_at' => '2026-09-07 12:11:59',
            ),
            68 => 
            array (
                'id' => 88,
                'ulid' => '01m1xvvm5v4xg96v1azgm6b76b',
                'npwp' => '11.011.011.011-005.011',
                'name' => 'PT Kencana Tunggal - Site DI Yogyakarta',
                'created_at' => '2026-09-07 12:00:32',
                'updated_at' => '2026-09-07 12:11:59',
            ),
            69 => 
            array (
                'id' => 89,
                'ulid' => '01m1xvvmk1v9gxsw0c5zfs9fpw',
                'npwp' => '12.012.012.012-005.012',
                'name' => 'PT Harapan Jaya - Site Jawa Timur',
                'created_at' => '2026-09-07 12:00:32',
                'updated_at' => '2026-09-07 12:11:59',
            ),
            70 => 
            array (
                'id' => 90,
                'ulid' => '01m1xvvp9jkrmbj71ph3antcta',
                'npwp' => '13.013.013.013-005.013',
                'name' => 'PT Berkah Mandiri - Site Banten',
                'created_at' => '2026-09-07 12:00:34',
                'updated_at' => '2026-09-07 12:12:00',
            ),
            71 => 
            array (
                'id' => 91,
                'ulid' => '01m1xvvpjn80fmreg9zh0q28r5',
                'npwp' => '14.014.014.014-005.014',
                'name' => 'PT Cahaya Nusantara - Site Sumatera Selatan',
                'created_at' => '2026-09-07 12:00:34',
                'updated_at' => '2026-09-07 12:12:00',
            ),
            72 => 
            array (
                'id' => 92,
                'ulid' => '01m1xvvr1y80jyx7x9b8mccb1x',
                'npwp' => '15.015.015.015-005.015',
                'name' => 'PT Sentosa Abadi - Site Sumatera Utara',
                'created_at' => '2026-09-07 12:00:36',
                'updated_at' => '2026-09-07 12:12:00',
            ),
            73 => 
            array (
                'id' => 93,
                'ulid' => '01m1xvvrav737s69rjk2cbqdzy',
                'npwp' => '16.016.016.016-005.016',
                'name' => 'PT Mitra Sejati - Site Riau',
                'created_at' => '2026-09-07 12:00:36',
                'updated_at' => '2026-09-07 12:12:00',
            ),
            74 => 
            array (
                'id' => 94,
                'ulid' => '01m1xvvtmdrqh8s0e477ergyze',
                'npwp' => '17.017.017.017-005.017',
                'name' => 'PT Wijaya Karya - Site Sulawesi Selatan',
                'created_at' => '2026-09-07 12:00:39',
                'updated_at' => '2026-09-07 12:12:00',
            ),
            75 => 
            array (
                'id' => 95,
                'ulid' => '01m1xvvv3vh2e4h8r2xrwgn4g4',
                'npwp' => '18.018.018.018-005.018',
                'name' => 'PT Prasetya Utama - Site DKI Jakarta',
                'created_at' => '2026-09-07 12:00:39',
                'updated_at' => '2026-09-07 12:12:00',
            ),
            76 => 
            array (
                'id' => 96,
                'ulid' => '01m1xvvxcwz7aszsrkmhm429fr',
                'npwp' => '19.019.019.019-005.019',
                'name' => 'PT Bhakti Nusantara - Site Jawa Barat',
                'created_at' => '2026-09-07 12:00:41',
                'updated_at' => '2026-09-07 12:12:01',
            ),
            77 => 
            array (
                'id' => 97,
                'ulid' => '01m1xvvxny2dq96gz5rszmdw0q',
                'npwp' => '20.020.020.020-005.020',
                'name' => 'PT Sukses Mandiri - Site Jawa Tengah',
                'created_at' => '2026-09-07 12:00:42',
                'updated_at' => '2026-09-07 12:12:01',
            ),
        ));
        
        
    }
}