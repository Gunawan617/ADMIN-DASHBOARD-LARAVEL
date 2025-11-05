<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $books = [
            // Buku untuk Perawat
            [
                'title' => 'Panduan Lengkap UKOM Perawat 2024',
                'author' => 'Dr. Siti Nurhaliza, S.Kep., M.Kep',
                'category' => 'Keperawatan',
                'excerpt' => 'Buku panduan komprehensif untuk persiapan UKOM Perawat dengan materi terlengkap dan terkini.',
                'description' => 'Buku ini berisi materi lengkap sesuai blueprint UKOM terbaru, dilengkapi dengan 1000+ soal latihan dan pembahasan detail. Cocok untuk persiapan UKOM Perawat yang maksimal.',
                'price' => 'Rp 150.000',
                'cover_image' => 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=400',
                'audience_type' => 'nurse',
                'buy_link' => 'https://tokopedia.com/example-book-1',
                'status' => 'published',
            ],
            [
                'title' => 'Bank Soal UKOM Perawat + Pembahasan',
                'author' => 'Tim Ahli Keperawatan Indonesia',
                'category' => 'Latihan Soal',
                'excerpt' => 'Kumpulan 1500+ soal UKOM Perawat dengan pembahasan lengkap dan strategi menjawab.',
                'description' => 'Bank soal terlengkap untuk UKOM Perawat dengan pembahasan detail setiap soal. Dilengkapi tips dan trik menjawab soal dengan cepat dan tepat.',
                'price' => 'Rp 120.000',
                'cover_image' => 'https://images.unsplash.com/photo-1532012197267-da84d127e765?w=400',
                'audience_type' => 'nurse',
                'buy_link' => 'https://shopee.com/example-book-2',
                'status' => 'published',
            ],
            [
                'title' => 'Keperawatan Medikal Bedah untuk UKOM',
                'author' => 'Prof. Dr. Ahmad Hidayat, S.Kep., M.Kep',
                'category' => 'Keperawatan Medikal Bedah',
                'excerpt' => 'Fokus pada materi Keperawatan Medikal Bedah yang sering keluar di UKOM.',
                'description' => 'Buku khusus membahas materi KMB dengan detail, dilengkapi kasus klinis dan cara penanganannya. Sangat membantu untuk memahami konsep KMB secara mendalam.',
                'price' => 'Rp 135.000',
                'cover_image' => 'https://images.unsplash.com/photo-1589998059171-988d887df646?w=400',
                'audience_type' => 'nurse',
                'buy_link' => 'https://tokopedia.com/example-book-3',
                'status' => 'published',
            ],
            [
                'title' => 'Ringkasan Materi UKOM Perawat',
                'author' => 'Ns. Dewi Lestari, S.Kep., M.Kep',
                'category' => 'Ringkasan Materi',
                'excerpt' => 'Ringkasan materi UKOM Perawat yang praktis dan mudah dipahami.',
                'description' => 'Buku ringkasan materi yang efektif untuk belajar cepat. Cocok untuk review menjelang ujian UKOM dengan format yang mudah dipahami.',
                'price' => 'Rp 95.000',
                'cover_image' => 'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=400',
                'audience_type' => 'nurse',
                'buy_link' => 'https://shopee.com/example-book-4',
                'status' => 'published',
            ],
            
            // Buku untuk Bidan
            [
                'title' => 'Panduan Lengkap UKOM Bidan 2024',
                'author' => 'Bd. Ratna Sari, S.ST., M.Keb',
                'category' => 'Kebidanan',
                'excerpt' => 'Buku panduan komprehensif untuk persiapan UKOM Bidan dengan materi terlengkap.',
                'description' => 'Buku ini berisi materi lengkap kebidanan sesuai blueprint UKOM terbaru, dilengkapi dengan 800+ soal latihan dan pembahasan detail.',
                'price' => 'Rp 140.000',
                'cover_image' => 'https://images.unsplash.com/photo-1512820790803-83ca734da794?w=400',
                'audience_type' => 'midwife',
                'buy_link' => 'https://tokopedia.com/example-book-5',
                'status' => 'published',
            ],
            [
                'title' => 'Bank Soal UKOM Bidan + Pembahasan',
                'author' => 'Tim Ahli Kebidanan Indonesia',
                'category' => 'Latihan Soal',
                'excerpt' => 'Kumpulan 1200+ soal UKOM Bidan dengan pembahasan lengkap.',
                'description' => 'Bank soal terlengkap untuk UKOM Bidan dengan pembahasan detail. Dilengkapi strategi menjawab soal dan tips sukses UKOM.',
                'price' => 'Rp 110.000',
                'cover_image' => 'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?w=400',
                'audience_type' => 'midwife',
                'buy_link' => 'https://shopee.com/example-book-6',
                'status' => 'published',
            ],
            [
                'title' => 'Asuhan Kebidanan untuk UKOM',
                'author' => 'Bd. Siti Aminah, S.ST., M.Keb',
                'category' => 'Asuhan Kebidanan',
                'excerpt' => 'Fokus pada asuhan kebidanan yang sering keluar di UKOM.',
                'description' => 'Buku khusus membahas asuhan kebidanan dari kehamilan, persalinan, nifas, hingga KB. Dilengkapi dengan kasus klinis dan penanganannya.',
                'price' => 'Rp 125.000',
                'cover_image' => 'https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?w=400',
                'audience_type' => 'midwife',
                'buy_link' => 'https://tokopedia.com/example-book-7',
                'status' => 'published',
            ],
            [
                'title' => 'Ringkasan Materi UKOM Bidan',
                'author' => 'Bd. Nur Azizah, S.ST., M.Keb',
                'category' => 'Ringkasan Materi',
                'excerpt' => 'Ringkasan materi UKOM Bidan yang praktis dan mudah dipahami.',
                'description' => 'Buku ringkasan materi kebidanan yang efektif untuk belajar cepat. Format ringkas dan padat untuk review menjelang ujian UKOM.',
                'price' => 'Rp 90.000',
                'cover_image' => 'https://images.unsplash.com/photo-1507842217343-583bb7270b66?w=400',
                'audience_type' => 'midwife',
                'buy_link' => 'https://shopee.com/example-book-8',
                'status' => 'published',
            ],
        ];

        foreach ($books as $book) {
            Book::updateOrCreate(
                ['title' => $book['title']],
                $book
            );
        }
    }
}
