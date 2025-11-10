<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'Apa itu Klinik UKOM?',
                'answer' => 'Klinik UKOM adalah lembaga bimbingan belajar yang fokus membantu mahasiswa keperawatan dan ners dalam mempersiapkan diri menghadapi Uji Kompetensi (UKOM). Kami menyediakan berbagai program bimbingan, tryout, dan materi pembelajaran yang komprehensif.',
                'category' => 'general',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'question' => 'Bagaimana cara mendaftar program bimbel?',
                'answer' => 'Anda dapat mendaftar melalui halaman Daftar di website kami. Pilih program yang sesuai, isi formulir pendaftaran, dan tim kami akan segera menghubungi Anda untuk proses selanjutnya.',
                'category' => 'program',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'question' => 'Apa saja program yang tersedia?',
                'answer' => 'Kami menyediakan berbagai program seperti:\n- Bimbel Reguler UKOM\n- Bimbel Intensif UKOM\n- Tryout Online\n- Konsultasi Privat\n- Paket Belajar Mandiri\n\nSetiap program dirancang sesuai kebutuhan dan jadwal Anda.',
                'category' => 'program',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'question' => 'Berapa biaya program bimbel?',
                'answer' => 'Biaya bervariasi tergantung program yang dipilih. Untuk informasi detail mengenai biaya, silakan hubungi tim kami melalui WhatsApp atau email. Kami juga menyediakan berbagai paket dengan harga yang kompetitif.',
                'category' => 'payment',
                'order' => 4,
                'is_active' => true,
            ],
            [
                'question' => 'Apakah ada sistem cicilan pembayaran?',
                'answer' => 'Ya, kami menyediakan sistem pembayaran cicilan untuk memudahkan peserta. Detail skema cicilan dapat dikonsultasikan dengan tim kami saat pendaftaran.',
                'category' => 'payment',
                'order' => 5,
                'is_active' => true,
            ],
            [
                'question' => 'Bagaimana sistem pembelajaran dilakukan?',
                'answer' => 'Pembelajaran dilakukan secara hybrid (online dan offline). Untuk kelas online, kami menggunakan platform video conference yang mudah diakses. Materi pembelajaran juga tersedia dalam bentuk digital yang dapat diakses kapan saja.',
                'category' => 'technical',
                'order' => 6,
                'is_active' => true,
            ],
            [
                'question' => 'Apakah ada tryout gratis?',
                'answer' => 'Ya, kami secara berkala mengadakan tryout gratis untuk calon peserta. Informasi mengenai jadwal tryout gratis akan diumumkan melalui website dan media sosial kami.',
                'category' => 'program',
                'order' => 7,
                'is_active' => true,
            ],
            [
                'question' => 'Berapa lama durasi program bimbel?',
                'answer' => 'Durasi program bervariasi:\n- Program Reguler: 2-3 bulan\n- Program Intensif: 1 bulan\n- Program Privat: Fleksibel sesuai kebutuhan\n\nJadwal dapat disesuaikan dengan kebutuhan peserta.',
                'category' => 'program',
                'order' => 8,
                'is_active' => true,
            ],
            [
                'question' => 'Apakah ada garansi kelulusan?',
                'answer' => 'Kami tidak memberikan garansi 100% kelulusan karena hasil UKOM juga bergantung pada usaha dan persiapan masing-masing peserta. Namun, kami berkomitmen memberikan materi terbaik, bimbingan intensif, dan strategi yang terbukti efektif untuk meningkatkan peluang kelulusan Anda.',
                'category' => 'general',
                'order' => 9,
                'is_active' => true,
            ],
            [
                'question' => 'Bagaimana cara mengakses materi pembelajaran?',
                'answer' => 'Setelah mendaftar, Anda akan mendapatkan akses ke platform pembelajaran online kami. Di sana tersedia video pembelajaran, modul, latihan soal, dan tryout yang dapat diakses 24/7.',
                'category' => 'technical',
                'order' => 10,
                'is_active' => true,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }
    }
}
