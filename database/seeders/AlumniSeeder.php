<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Alumni;

class AlumniSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $alumniData = [
            [
                'name' => "Ahmad Rizki",
                'batch' => "2020",
                'major' => "Teknik Informatika",
                'photo' => "https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=300&h=300&fit=crop&crop=face"
            ],
            [
                'name' => "Siti Nurhaliza",
                'batch' => "2019",
                'major' => "Manajemen",
                'photo' => "https://images.unsplash.com/photo-1494790108755-2616b612b786?w=300&h=300&fit=crop&crop=face"
            ],
            [
                'name' => "Budi Santoso",
                'batch' => "2021",
                'major' => "Teknik Sipil",
                'photo' => "https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=300&h=300&fit=crop&crop=face"
            ],
            [
                'name' => "Dewi Sartika",
                'batch' => "2020",
                'major' => "Akuntansi",
                'photo' => "https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=300&h=300&fit=crop&crop=face"
            ],
            [
                'name' => "Eko Prasetyo",
                'batch' => "2018",
                'major' => "Teknik Mesin",
                'photo' => "https://images.unsplash.com/photo-1560250097-0b93528c311a?w=300&h=300&fit=crop&crop=face"
            ],
            [
                'name' => "Rina Melati",
                'batch' => "2021",
                'major' => "Psikologi",
                'photo' => "https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=300&h=300&fit=crop&crop=face"
            ],
            [
                'name' => "Faisal Rahman",
                'batch' => "2019",
                'major' => "Ekonomi",
                'photo' => "https://images.unsplash.com/photo-1519345182560-3f2917c472ef?w=300&h=300&fit=crop&crop=face"
            ],
            [
                'name' => "Maya Sari",
                'batch' => "2020",
                'major' => "Desain Grafis",
                'photo' => "https://images.unsplash.com/photo-1517841905240-472988babdf9?w=300&h=300&fit=crop&crop=face"
            ],
            [
                'name' => "Doni Kusuma",
                'batch' => "2018",
                'major' => "Teknik Elektro",
                'photo' => "https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=300&h=300&fit=crop&crop=face"
            ],
            [
                'name' => "Lina Wijaya",
                'batch' => "2021",
                'major' => "Farmasi",
                'photo' => "https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=300&h=300&fit=crop&crop=face"
            ],
            [
                'name' => "Arif Hidayat",
                'batch' => "2019",
                'major' => "Hukum",
                'photo' => "https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=300&h=300&fit=crop&crop=face"
            ],
            [
                'name' => "Indah Permata",
                'batch' => "2020",
                'major' => "Komunikasi",
                'photo' => "https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=300&h=300&fit=crop&crop=face"
            ]
        ];

        foreach ($alumniData as $alumni) {
            Alumni::create($alumni);
        }
    }
}
