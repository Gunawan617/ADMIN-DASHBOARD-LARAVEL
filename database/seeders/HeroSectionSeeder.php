<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\HeroSection;

class HeroSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HeroSection::create([
            'badge_text' => 'Dipercaya 5,000+ Peserta',
            'title' => 'Temani perjalananmu menuju kompeten 1x ujian',
            'description' => 'Persiapan lengkap Uji Kompetensi untuk Perawat dan Bidan. Bimbingan intensif dengan materi terkini, try out berkala, dan pendampingan hingga lulus.',
            'primary_button_text' => 'Daftar Sekarang',
            'primary_button_link' => '/daftar',
            'secondary_button_text' => 'Video Penjelasan',
            'secondary_button_link' => null,
            'image_url' => 'https://images.unsplash.com/photo-1676552055618-22ec8cde399a?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxudXJzZSUyMHN0dWR5aW5nJTIwbWVkaWNhbHxlbnwxfHx8fDE3NjIxNDMyMTV8MA&ixlib=rb-4.1.0&q=80&w=1080&utm_source=figma&utm_medium=referral',
            'stat1_value' => '92%',
            'stat1_label' => 'Tingkat Kelulusan',
            'stat2_value' => '100+',
            'stat2_label' => 'Rumah Sakit Mitra',
            'stat3_value' => '4.8/5',
            'stat3_label' => 'Rating Peserta',
            'floating_card_text' => 'Peserta Lulus',
            'floating_card_value' => '92% Berhasil',
            'is_active' => true,
        ]);
    }
}
