<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VideoSection;

class VideoSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        VideoSection::create([
            'title' => 'Lihat Bagaimana Kami Membantu Anda Lulus UKOM',
            'description' => 'Dengar langsung dari alumni kami yang telah berhasil lulus dengan bimbingan Klinik Ukom',
            'video_url' => '/videos/hero-video.mp4',
            'video_webm_url' => '/videos/hero-video.webm',
            'thumbnail_url' => 'https://images.unsplash.com/photo-1588072432836-e10032774350?w=1200',
            'badge_title' => 'Testimoni Alumni Klinik Ukom',
            'badge_subtitle' => 'Video otomatis diputar',
            'feature1_icon' => '📚',
            'feature1_title' => 'Materi Lengkap',
            'feature1_description' => 'Semua materi UKOM dari A-Z',
            'feature2_icon' => '👨‍🏫',
            'feature2_title' => 'Mentor Berpengalaman',
            'feature2_description' => 'Dibimbing langsung oleh ahli',
            'feature3_icon' => '✅',
            'feature3_title' => 'Garansi Lulus',
            'feature3_description' => 'Bimbingan hingga lulus UKOM',
            'is_active' => true,
        ]);
    }
}
