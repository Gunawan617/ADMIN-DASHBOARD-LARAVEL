<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProgramDetail;

class ProgramDetailSeeder extends Seeder
{
    public function run(): void
    {
        $programs = [
            // Bimbel - Perawat
            [
                'slug' => 'bimbel-ukom-perawat-reguler',
                'title' => 'Bimbel UKOM Perawat Reguler',
                'description' => 'Program persiapan lengkap UKOM untuk perawat dengan materi komprehensif, latihan soal, dan try out berkala.',
                'image' => 'https://images.unsplash.com/photo-1725870475677-7dc91efe9f93?w=1080',
                'product_type' => 'bimbel',
                'audience_type' => 'nurse',
                'tag' => 'Paling Populer',
                'duration' => '2 Bulan',
                'students' => '3,200+',
                'level' => 'Semua Level',
                'price' => 'Rp 850.000',
                'features' => json_encode([
                    'Materi lengkap sesuai blueprint UKOM terbaru',
                    'Video pembelajaran dari instruktur berpengalaman',
                    'Bank soal 1000+ dengan pembahasan detail',
                    'Try out berkala dengan sistem CBT',
                    'Grup diskusi eksklusif dengan mentor',
                    'Sertifikat kelulusan program',
                    'Akses materi selamanya',
                    'Konsultasi gratis dengan mentor'
                ]),
                'schedule' => json_encode([
                    ['week' => 'Minggu 1-2', 'topic' => 'Dasar Keperawatan & Anatomi Fisiologi'],
                    ['week' => 'Minggu 3-4', 'topic' => 'Keperawatan Medikal Bedah'],
                    ['week' => 'Minggu 5-6', 'topic' => 'Keperawatan Maternitas & Anak'],
                    ['week' => 'Minggu 7-8', 'topic' => 'Keperawatan Jiwa & Komunitas']
                ]),
                'status' => 'published',
            ],
            [
                'slug' => 'bimbel-ukom-perawat-intensif',
                'title' => 'Bimbel UKOM Perawat Intensif',
                'description' => 'Program intensif dengan bimbingan mentor pribadi, kelas kecil, dan pendampingan hingga lulus UKOM.',
                'image' => 'https://images.unsplash.com/photo-1652787544912-137c7f92f99b?w=1080',
                'product_type' => 'bimbel',
                'audience_type' => 'nurse',
                'tag' => 'Batch Baru',
                'duration' => '1 Bulan',
                'students' => '1,500+',
                'level' => 'Intensif',
                'price' => 'Rp 1.200.000',
                'features' => json_encode([
                    'Kelas kecil maksimal 15 peserta',
                    'Mentor pribadi yang siap membantu 24/7',
                    'Materi super ringkas dan fokus',
                    'Drilling soal intensif setiap hari',
                    'Try out mingguan dengan pembahasan',
                    'Garansi mengulang gratis jika tidak lulus',
                    'Akses grup WhatsApp eksklusif',
                    'Sertifikat dan pendampingan hingga lulus'
                ]),
                'schedule' => json_encode([
                    ['week' => 'Minggu 1', 'topic' => 'Dasar Keperawatan & KMB Intensif'],
                    ['week' => 'Minggu 2', 'topic' => 'Keperawatan Maternitas & Anak'],
                    ['week' => 'Minggu 3', 'topic' => 'Keperawatan Jiwa & Komunitas'],
                    ['week' => 'Minggu 4', 'topic' => 'Review Komprehensif & Try Out Final']
                ]),
                'status' => 'published',
            ],
            // Bimbel - Bidan
            [
                'slug' => 'bimbel-ukom-bidan-reguler',
                'title' => 'Bimbel UKOM Bidan Reguler',
                'description' => 'Persiapan UKOM khusus bidan dengan materi terkini, simulasi ujian, dan pembahasan kasus klinis.',
                'image' => 'https://images.unsplash.com/photo-1560306990-18fa759c8713?w=1080',
                'product_type' => 'bimbel',
                'audience_type' => 'midwife',
                'tag' => '',
                'duration' => '2 Bulan',
                'students' => '2,800+',
                'level' => 'Semua Level',
                'price' => 'Rp 800.000',
                'features' => json_encode([
                    'Materi kebidanan sesuai blueprint UKOM',
                    'Video pembelajaran kasus klinis',
                    'Bank soal 800+ khusus kebidanan',
                    'Try out berkala sistem CBT',
                    'Diskusi kasus dengan mentor bidan',
                    'Sertifikat kelulusan',
                    'Akses materi selamanya',
                    'Konsultasi dengan bidan senior'
                ]),
                'schedule' => json_encode([
                    ['week' => 'Minggu 1-2', 'topic' => 'Asuhan Kebidanan Kehamilan'],
                    ['week' => 'Minggu 3-4', 'topic' => 'Asuhan Kebidanan Persalinan'],
                    ['week' => 'Minggu 5-6', 'topic' => 'Asuhan Kebidanan Nifas & BBL'],
                    ['week' => 'Minggu 7-8', 'topic' => 'KB & Kesehatan Reproduksi']
                ]),
                'status' => 'published',
            ],
            [
                'slug' => 'bimbel-ukom-bidan-intensif',
                'title' => 'Bimbel UKOM Bidan Intensif',
                'description' => 'Program super intensif untuk bidan dengan target lulus cepat, materi ringkas, dan drilling soal.',
                'image' => 'https://images.unsplash.com/photo-1576670160060-c4e874631c5a?w=1080',
                'product_type' => 'bimbel',
                'audience_type' => 'midwife',
                'tag' => '',
                'duration' => '1 Bulan',
                'students' => '1,200+',
                'level' => 'Intensif',
                'price' => 'Rp 1.100.000',
                'features' => json_encode([
                    'Kelas kecil khusus bidan',
                    'Mentor bidan berpengalaman',
                    'Materi ringkas dan padat',
                    'Drilling soal harian',
                    'Try out mingguan',
                    'Garansi mengulang gratis',
                    'Grup diskusi eksklusif',
                    'Pendampingan hingga lulus'
                ]),
                'schedule' => json_encode([
                    ['week' => 'Minggu 1', 'topic' => 'Asuhan Kehamilan & Persalinan'],
                    ['week' => 'Minggu 2', 'topic' => 'Asuhan Nifas, BBL & KB'],
                    ['week' => 'Minggu 3', 'topic' => 'Kesehatan Reproduksi & Komunitas'],
                    ['week' => 'Minggu 4', 'topic' => 'Review & Try Out Komprehensif']
                ]),
                'status' => 'published',
            ],
            // Books - Perawat
            [
                'slug' => 'buku-ukom-perawat-lengkap',
                'title' => 'Buku UKOM Perawat Lengkap',
                'description' => 'Buku panduan lengkap UKOM perawat dengan ringkasan materi, contoh soal, dan pembahasan detail.',
                'image' => 'https://images.unsplash.com/photo-1652787544912-137c7f92f99b?w=1080',
                'product_type' => 'books',
                'audience_type' => 'nurse',
                'tag' => 'Best Seller',
                'pages' => '500+ Halaman',
                'questions' => '1,000+ Soal',
                'price' => 'Rp 150.000',
                'status' => 'published',
            ],
            [
                'slug' => 'buku-soal-ukom-perawat',
                'title' => 'Buku Soal UKOM Perawat',
                'description' => 'Kumpulan soal UKOM perawat dengan pembahasan lengkap dari berbagai topik sesuai blueprint terbaru.',
                'image' => 'https://images.unsplash.com/photo-1652787544912-137c7f92f99b?w=1080',
                'product_type' => 'books',
                'audience_type' => 'nurse',
                'tag' => '',
                'pages' => '300+ Halaman',
                'questions' => '1,500+ Soal',
                'price' => 'Rp 120.000',
                'status' => 'published',
            ],
            // Books - Bidan
            [
                'slug' => 'buku-ukom-bidan-lengkap',
                'title' => 'Buku UKOM Bidan Lengkap',
                'description' => 'Buku panduan lengkap UKOM bidan dengan materi esensial, latihan soal, dan kunci jawaban.',
                'image' => 'https://images.unsplash.com/photo-1652787544912-137c7f92f99b?w=1080',
                'product_type' => 'books',
                'audience_type' => 'midwife',
                'tag' => 'Best Seller',
                'pages' => '450+ Halaman',
                'questions' => '900+ Soal',
                'price' => 'Rp 140.000',
                'status' => 'published',
            ],
            [
                'slug' => 'buku-soal-ukom-bidan',
                'title' => 'Buku Soal UKOM Bidan',
                'description' => 'Bank soal UKOM bidan dengan pembahasan komprehensif untuk persiapan ujian yang maksimal.',
                'image' => 'https://images.unsplash.com/photo-1652787544912-137c7f92f99b?w=1080',
                'product_type' => 'books',
                'audience_type' => 'midwife',
                'tag' => '',
                'pages' => '280+ Halaman',
                'questions' => '1,200+ Soal',
                'price' => 'Rp 110.000',
                'status' => 'published',
            ],
            // Try Out - Perawat
            [
                'slug' => 'try-out-ukom-perawat-premium',
                'title' => 'Try Out UKOM Perawat Premium',
                'description' => 'Paket try out online dengan sistem CBT mirip ujian sesungguhnya, pembahasan lengkap, dan analisis hasil.',
                'image' => 'https://images.unsplash.com/photo-1725870475677-7dc91efe9f93?w=1080',
                'product_type' => 'tryout',
                'audience_type' => 'nurse',
                'tag' => 'Unlimited',
                'questions' => '10x Try Out',
                'duration' => '3 Bulan Akses',
                'price' => 'Rp 200.000',
                'features' => json_encode([
                    'Sistem CBT (Computer Based Test) seperti ujian asli',
                    '10 paket try out dengan 180 soal per paket',
                    'Pembahasan lengkap setiap soal',
                    'Analisis hasil dan rekomendasi belajar',
                    'Ranking nasional peserta try out',
                    'Akses unlimited selama 3 bulan',
                    'Sertifikat digital setelah menyelesaikan',
                    'Update soal sesuai blueprint terbaru'
                ]),
                'packages' => json_encode([
                    ['name' => 'Try Out 1', 'topic' => 'Dasar Keperawatan & KMB', 'questions' => 180, 'duration' => '180 menit'],
                    ['name' => 'Try Out 2', 'topic' => 'Keperawatan Maternitas', 'questions' => 180, 'duration' => '180 menit'],
                    ['name' => 'Try Out 3', 'topic' => 'Keperawatan Anak', 'questions' => 180, 'duration' => '180 menit'],
                    ['name' => 'Try Out 4', 'topic' => 'Keperawatan Jiwa', 'questions' => 180, 'duration' => '180 menit'],
                    ['name' => 'Try Out 5', 'topic' => 'Keperawatan Komunitas', 'questions' => 180, 'duration' => '180 menit'],
                    ['name' => 'Try Out 6-10', 'topic' => 'Komprehensif (Semua Materi)', 'questions' => 180, 'duration' => '180 menit']
                ]),
                'status' => 'published',
            ],
            [
                'slug' => 'try-out-ukom-perawat-basic',
                'title' => 'Try Out UKOM Perawat Basic',
                'description' => 'Paket try out dasar untuk perawat dengan soal-soal pilihan sesuai blueprint UKOM terkini.',
                'image' => 'https://images.unsplash.com/photo-1725870475677-7dc91efe9f93?w=1080',
                'product_type' => 'tryout',
                'audience_type' => 'nurse',
                'tag' => '',
                'questions' => '5x Try Out',
                'duration' => '1 Bulan Akses',
                'price' => 'Rp 100.000',
                'status' => 'published',
            ],
            // Try Out - Bidan
            [
                'slug' => 'try-out-ukom-bidan-premium',
                'title' => 'Try Out UKOM Bidan Premium',
                'description' => 'Paket try out online untuk bidan dengan simulasi ujian lengkap dan evaluasi hasil yang mendetail.',
                'image' => 'https://images.unsplash.com/photo-1560306990-18fa759c8713?w=1080',
                'product_type' => 'tryout',
                'audience_type' => 'midwife',
                'tag' => 'Unlimited',
                'questions' => '10x Try Out',
                'duration' => '3 Bulan Akses',
                'price' => 'Rp 180.000',
                'status' => 'published',
            ],
            [
                'slug' => 'try-out-ukom-bidan-basic',
                'title' => 'Try Out UKOM Bidan Basic',
                'description' => 'Paket try out dasar untuk bidan dengan soal-soal esensial dan pembahasan singkat.',
                'image' => 'https://images.unsplash.com/photo-1560306990-18fa759c8713?w=1080',
                'product_type' => 'tryout',
                'audience_type' => 'midwife',
                'tag' => '',
                'questions' => '5x Try Out',
                'duration' => '1 Bulan Akses',
                'price' => 'Rp 90.000',
                'status' => 'published',
            ],
            // Video - Perawat
            [
                'slug' => 'video-pembelajaran-ukom-perawat',
                'title' => 'Video Pembelajaran UKOM Perawat',
                'description' => 'Koleksi video pembelajaran lengkap dengan penjelasan materi UKOM perawat dari ahli.',
                'image' => 'https://images.unsplash.com/photo-1576670160060-c4e874631c5a?w=1080',
                'product_type' => 'video',
                'audience_type' => 'nurse',
                'tag' => 'Lengkap',
                'duration' => '50+ Video',
                'level' => 'HD Quality',
                'price' => 'Rp 250.000',
                'status' => 'published',
            ],
            [
                'slug' => 'video-ringkas-ukom-perawat',
                'title' => 'Video Ringkas UKOM Perawat',
                'description' => 'Video ringkasan materi penting UKOM perawat untuk belajar cepat dan efisien.',
                'image' => 'https://images.unsplash.com/photo-1576670160060-c4e874631c5a?w=1080',
                'product_type' => 'video',
                'audience_type' => 'nurse',
                'tag' => '',
                'duration' => '20+ Video',
                'level' => 'HD Quality',
                'price' => 'Rp 150.000',
                'status' => 'published',
            ],
            // Video - Bidan
            [
                'slug' => 'video-pembelajaran-ukom-bidan',
                'title' => 'Video Pembelajaran UKOM Bidan',
                'description' => 'Koleksi video pembelajaran komprehensif dengan materi UKOM bidan dari praktisi berpengalaman.',
                'image' => 'https://images.unsplash.com/photo-1576670160060-c4e874631c5a?w=1080',
                'product_type' => 'video',
                'audience_type' => 'midwife',
                'tag' => 'Lengkap',
                'duration' => '45+ Video',
                'level' => 'HD Quality',
                'price' => 'Rp 230.000',
                'status' => 'published',
            ],
            [
                'slug' => 'video-ringkas-ukom-bidan',
                'title' => 'Video Ringkas UKOM Bidan',
                'description' => 'Video ringkasan materi esensial UKOM bidan untuk pembelajaran yang efektif dan tepat sasaran.',
                'image' => 'https://images.unsplash.com/photo-1576670160060-c4e874631c5a?w=1080',
                'product_type' => 'video',
                'audience_type' => 'midwife',
                'tag' => '',
                'duration' => '18+ Video',
                'level' => 'HD Quality',
                'price' => 'Rp 140.000',
                'status' => 'published',
            ],
        ];

        foreach ($programs as $program) {
            ProgramDetail::updateOrCreate(
                ['slug' => $program['slug']],
                $program
            );
        }
    }
}
