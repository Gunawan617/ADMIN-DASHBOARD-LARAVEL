<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProgramNew;

class ProgramNewSeeder extends Seeder
{
    public function run(): void
    {
        $programs = [
            // BIMBEL - KEPERAWATAN - D3
            [
                'title' => 'Bimbel D3 Keperawatan - Paket Reguler',
                'tag' => 'Terlaris',
                'card_type' => 'Belajar Mandiri',
                'sold_count' => '450 terjual',
                'features' => [
                    'Materi lengkap D3 Keperawatan sesuai blueprint UKOM',
                    'Video pembelajaran dan modul PDF',
                    'Akses 6 bulan',
                ],
                'price' => '299.000',
                'link' => '/daftar',
                'type' => 'bimbel',
                'major' => 'Keperawatan',
                'level' => 'd3',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Bimbel D3 Keperawatan - Paket Intensif',
                'tag' => null,
                'card_type' => 'Kelas Intensif',
                'sold_count' => '320 terjual',
                'features' => [
                    'Bimbingan intensif dengan mentor berpengalaman',
                    'Kelas zoom 3x seminggu selama 2 bulan',
                    'Grup diskusi eksklusif',
                ],
                'price' => '599.000',
                'link' => '/daftar',
                'type' => 'bimbel',
                'major' => 'Keperawatan',
                'level' => 'd3',
                'order' => 2,
                'is_active' => true,
            ],
            
            // BIMBEL - KEPERAWATAN - PROFESI
            [
                'title' => 'Bimbel Profesi Ners - Paket Premium',
                'tag' => 'Terlaris',
                'card_type' => 'Kelas Intensif',
                'sold_count' => '890 terjual',
                'features' => [
                    'Pembelajaran full via zoom bersama tutor [20x pertemuan materi]',
                    'Try out CBT via web Appskep, 27x [total 1.660 butir soal]',
                    'Grup belajar dan konsultasi',
                ],
                'price' => '849.000',
                'link' => '/daftar',
                'type' => 'bimbel',
                'major' => 'Keperawatan',
                'level' => 'profesi',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'Bimbel Profesi Ners - Paket Reguler',
                'tag' => null,
                'card_type' => 'Belajar Mandiri',
                'sold_count' => '650 terjual',
                'features' => [
                    'Materi lengkap Profesi Ners sesuai blueprint UKOM',
                    'Akses video pembelajaran selama 6 bulan',
                    'Bank soal 1000+ butir',
                ],
                'price' => '499.000',
                'link' => '/daftar',
                'type' => 'bimbel',
                'major' => 'Keperawatan',
                'level' => 'profesi',
                'order' => 4,
                'is_active' => true,
            ],
            
            // BIMBEL - KEPERAWATAN - S1
            [
                'title' => 'Bimbel S1 Keperawatan - Paket Lengkap',
                'tag' => null,
                'card_type' => 'Belajar Mandiri',
                'sold_count' => '380 terjual',
                'features' => [
                    'Materi S1 Keperawatan komprehensif',
                    'Bank soal 2000+ dengan pembahasan detail',
                    'Video pembelajaran HD',
                ],
                'price' => '399.000',
                'link' => '/daftar',
                'type' => 'bimbel',
                'major' => 'Keperawatan',
                'level' => 's1',
                'order' => 5,
                'is_active' => true,
            ],
            
            // BIMBEL - KEBIDANAN - D3
            [
                'title' => 'Bimbel D3 Kebidanan - Paket Reguler',
                'tag' => 'Terlaris',
                'card_type' => 'Belajar Mandiri',
                'sold_count' => '520 terjual',
                'features' => [
                    'Materi lengkap D3 Kebidanan sesuai blueprint',
                    'Video pembelajaran dan modul PDF',
                    'Akses 6 bulan',
                ],
                'price' => '279.000',
                'link' => '/daftar',
                'type' => 'bimbel',
                'major' => 'Kebidanan',
                'level' => 'd3',
                'order' => 6,
                'is_active' => true,
            ],
            [
                'title' => 'Bimbel D3 Kebidanan - Paket Intensif',
                'tag' => null,
                'card_type' => 'Kelas Intensif',
                'sold_count' => '410 terjual',
                'features' => [
                    'Bimbingan intensif dengan mentor kebidanan',
                    'Kelas zoom 3x seminggu selama 2 bulan',
                    'Grup diskusi eksklusif',
                ],
                'price' => '579.000',
                'link' => '/daftar',
                'type' => 'bimbel',
                'major' => 'Kebidanan',
                'level' => 'd3',
                'order' => 7,
                'is_active' => true,
            ],
            
            // BIMBEL - KEBIDANAN - PROFESI
            [
                'title' => 'Bimbel Profesi Bidan - Paket Premium',
                'tag' => 'Terlaris',
                'card_type' => 'Kelas Intensif',
                'sold_count' => '760 terjual',
                'features' => [
                    'Pembelajaran full via zoom dengan tutor berpengalaman',
                    'Try out CBT 25x dengan pembahasan lengkap',
                    'Grup belajar dan konsultasi',
                ],
                'price' => '799.000',
                'link' => '/daftar',
                'type' => 'bimbel',
                'major' => 'Kebidanan',
                'level' => 'profesi',
                'order' => 8,
                'is_active' => true,
            ],
            
            // BIMBEL - GIZI - D3
            [
                'title' => 'Bimbel D3 Gizi - Paket Reguler',
                'tag' => null,
                'card_type' => 'Belajar Mandiri',
                'sold_count' => '290 terjual',
                'features' => [
                    'Materi lengkap D3 Gizi sesuai blueprint UKOM',
                    'Video pembelajaran dan modul PDF',
                    'Akses 6 bulan',
                ],
                'price' => '269.000',
                'link' => '/daftar',
                'type' => 'bimbel',
                'major' => 'Gizi',
                'level' => 'd3',
                'order' => 9,
                'is_active' => true,
            ],
            
            // BIMBEL - GIZI - S1
            [
                'title' => 'Bimbel S1 Gizi - Paket Lengkap',
                'tag' => 'Terlaris',
                'card_type' => 'Belajar Mandiri',
                'sold_count' => '340 terjual',
                'features' => [
                    'Materi S1 Gizi komprehensif',
                    'Bank soal 1500+ dengan pembahasan detail',
                    'Video pembelajaran HD',
                ],
                'price' => '379.000',
                'link' => '/daftar',
                'type' => 'bimbel',
                'major' => 'Gizi',
                'level' => 's1',
                'order' => 10,
                'is_active' => true,
            ],
            
            // TRY OUT - KEPERAWATAN - D3
            [
                'title' => 'Try Out D3 Keperawatan - 5 Paket',
                'tag' => 'Terlaris',
                'card_type' => 'Belajar Mandiri',
                'sold_count' => '1200 terjual',
                'features' => [
                    '5 paket try out dengan sistem CBT',
                    'Total 900 soal dengan pembahasan lengkap',
                    'Laporan hasil detail',
                ],
                'price' => '149.000',
                'link' => '/daftar',
                'type' => 'tryout',
                'major' => 'Keperawatan',
                'level' => 'd3',
                'order' => 11,
                'is_active' => true,
            ],
            [
                'title' => 'Try Out D3 Keperawatan - 10 Paket',
                'tag' => null,
                'card_type' => 'Belajar Mandiri',
                'sold_count' => '850 terjual',
                'features' => [
                    '10 paket try out dengan sistem CBT',
                    'Total 1800 soal dengan pembahasan lengkap',
                    'Analisis kelemahan materi',
                ],
                'price' => '249.000',
                'link' => '/daftar',
                'type' => 'tryout',
                'major' => 'Keperawatan',
                'level' => 'd3',
                'order' => 12,
                'is_active' => true,
            ],
            
            // TRY OUT - KEPERAWATAN - PROFESI
            [
                'title' => 'Try Out Profesi Ners - 3 Paket',
                'tag' => 'Terlaris',
                'card_type' => 'Belajar Mandiri',
                'sold_count' => '989 terjual',
                'features' => [
                    '3 paket try out disertai pembahasan via web Apps UKOM',
                    'Total Soal 540 butir (3 paket try out)',
                    'Pembahasan video lengkap',
                ],
                'price' => '99.000',
                'link' => '/daftar',
                'type' => 'tryout',
                'major' => 'Keperawatan',
                'level' => 'profesi',
                'order' => 13,
                'is_active' => true,
            ],
            [
                'title' => 'Try Out Profesi Ners - 10 Paket Premium',
                'tag' => null,
                'card_type' => 'Belajar Mandiri',
                'sold_count' => '720 terjual',
                'features' => [
                    '10 paket try out dengan sistem CBT',
                    'Total 1800 soal dengan pembahasan video',
                    'Ranking nasional',
                ],
                'price' => '299.000',
                'link' => '/daftar',
                'type' => 'tryout',
                'major' => 'Keperawatan',
                'level' => 'profesi',
                'order' => 14,
                'is_active' => true,
            ],
            
            // TRY OUT - KEPERAWATAN - S1
            [
                'title' => 'Try Out S1 Keperawatan - 5 Paket',
                'tag' => null,
                'card_type' => 'Belajar Mandiri',
                'sold_count' => '680 terjual',
                'features' => [
                    '5 paket try out dengan sistem CBT',
                    'Total 900 soal dengan pembahasan lengkap',
                    'Laporan hasil detail',
                ],
                'price' => '139.000',
                'link' => '/daftar',
                'type' => 'tryout',
                'major' => 'Keperawatan',
                'level' => 's1',
                'order' => 15,
                'is_active' => true,
            ],
            
            // TRY OUT - KEBIDANAN - D3
            [
                'title' => 'Try Out D3 Kebidanan - 5 Paket',
                'tag' => 'Terlaris',
                'card_type' => 'Belajar Mandiri',
                'sold_count' => '950 terjual',
                'features' => [
                    '5 paket try out dengan sistem CBT',
                    'Total 900 soal dengan pembahasan lengkap',
                    'Laporan hasil detail',
                ],
                'price' => '139.000',
                'link' => '/daftar',
                'type' => 'tryout',
                'major' => 'Kebidanan',
                'level' => 'd3',
                'order' => 16,
                'is_active' => true,
            ],
            
            // TRY OUT - KEBIDANAN - PROFESI
            [
                'title' => 'Try Out Profesi Bidan - 3 Paket',
                'tag' => 'Terlaris',
                'card_type' => 'Belajar Mandiri',
                'sold_count' => '870 terjual',
                'features' => [
                    '3 paket try out disertai pembahasan',
                    'Total 540 soal dengan pembahasan video',
                    'Ranking nasional',
                ],
                'price' => '89.000',
                'link' => '/daftar',
                'type' => 'tryout',
                'major' => 'Kebidanan',
                'level' => 'profesi',
                'order' => 17,
                'is_active' => true,
            ],
            
            // TRY OUT - GIZI - D3
            [
                'title' => 'Try Out D3 Gizi - 5 Paket',
                'tag' => null,
                'card_type' => 'Belajar Mandiri',
                'sold_count' => '540 terjual',
                'features' => [
                    '5 paket try out dengan sistem CBT',
                    'Total 900 soal dengan pembahasan lengkap',
                    'Laporan hasil detail',
                ],
                'price' => '129.000',
                'link' => '/daftar',
                'type' => 'tryout',
                'major' => 'Gizi',
                'level' => 'd3',
                'order' => 18,
                'is_active' => true,
            ],
            
            // TRY OUT - GIZI - S1
            [
                'title' => 'Try Out S1 Gizi - 5 Paket',
                'tag' => 'Terlaris',
                'card_type' => 'Belajar Mandiri',
                'sold_count' => '620 terjual',
                'features' => [
                    '5 paket try out dengan sistem CBT',
                    'Total 900 soal dengan pembahasan lengkap',
                    'Analisis kelemahan materi',
                ],
                'price' => '139.000',
                'link' => '/daftar',
                'type' => 'tryout',
                'major' => 'Gizi',
                'level' => 's1',
                'order' => 19,
                'is_active' => true,
            ],
            
            // BUNDLE - KEPERAWATAN - PROFESI
            [
                'title' => 'Paket Bundle Profesi Ners - Bimbel + Try Out',
                'tag' => 'Hemat',
                'card_type' => 'Paket Bundle',
                'sold_count' => '1450 terjual',
                'features' => [
                    'Bimbel lengkap + 10 paket try out premium',
                    'Hemat 30% dari harga normal',
                    'Akses lifetime materi',
                ],
                'price' => '999.000',
                'link' => '/daftar',
                'type' => 'bundle',
                'major' => 'Keperawatan',
                'level' => 'profesi',
                'order' => 20,
                'is_active' => true,
            ],
            
            // BUNDLE - KEPERAWATAN - D3
            [
                'title' => 'Paket Bundle D3 Keperawatan - Bimbel + Try Out',
                'tag' => 'Hemat',
                'card_type' => 'Paket Bundle',
                'sold_count' => '890 terjual',
                'features' => [
                    'Bimbel lengkap + 8 paket try out',
                    'Hemat 25% dari harga normal',
                    'Grup belajar eksklusif',
                ],
                'price' => '699.000',
                'link' => '/daftar',
                'type' => 'bundle',
                'major' => 'Keperawatan',
                'level' => 'd3',
                'order' => 21,
                'is_active' => true,
            ],
            
            // BUNDLE - KEBIDANAN - PROFESI
            [
                'title' => 'Paket Bundle Profesi Bidan - Bimbel + Try Out',
                'tag' => 'Hemat',
                'card_type' => 'Paket Bundle',
                'sold_count' => '1120 terjual',
                'features' => [
                    'Bimbel lengkap + 10 paket try out premium',
                    'Hemat 30% dari harga normal',
                    'Konsultasi mentor unlimited',
                ],
                'price' => '949.000',
                'link' => '/daftar',
                'type' => 'bundle',
                'major' => 'Kebidanan',
                'level' => 'profesi',
                'order' => 22,
                'is_active' => true,
            ],
        ];

        foreach ($programs as $program) {
            ProgramNew::create($program);
        }
    }
}
