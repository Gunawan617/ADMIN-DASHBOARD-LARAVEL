-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 02, 2025 at 11:43 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `admin_dashboard`
--

-- --------------------------------------------------------

--
-- Table structure for table `bimbel_programs`
--

CREATE TABLE `bimbel_programs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `participants` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bimbel_programs`
--

INSERT INTO `bimbel_programs` (`id`, `code`, `name`, `category`, `participants`, `image`, `description`, `created_at`, `updated_at`) VALUES
(1, 'UKOM_Perawat', 'Bimbel Perawat', 'Kesehatan', '3200', 'uploads/bimbel/ZKvbAnK1WAW7xOKq9p5IKgX7eWbhGxLBJ1PC5eYo.png', 'Persiapan UKOM Perawat', '2025-08-28 02:14:46', '2025-08-31 20:24:21'),
(2, 'bidan', 'BIMBEL BIDAN', 'dsf', 'dsf', 'uploads/bimbel/Mi3azFdVxNF7KVSgNnPBec80ubehsnPnkmFqxOq2.png', NULL, '2025-08-28 02:35:11', '2025-08-31 20:23:44');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `excerpt` text NOT NULL,
  `description` text NOT NULL,
  `price` varchar(255) NOT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `category`, `excerpt`, `description`, `price`, `cover_image`, `created_at`, `updated_at`) VALUES
(17, 'RAHASIA SUSKSES UKOM PROFESI NERS', 'Tri Ratnaningsih dkk.', 'UKOM Keperawatan', 'Panduan Lengkap UKOM Keperawatan 2025', 'Buku ini berisi soal-soal prediksi UKOM terbaru, pembahasan detail, strategi belajar efektif, dan tips sukses menghadapi ujian profesi ners', 'Rp.110.000', 'books/v37R9cilGD3KDGu0yzkzrqqtyEWMfZSPMdnnMhON.png', '2025-08-31 20:35:25', '2025-09-01 23:11:56'),
(18, 'Rangkuman Materi Keperawatan Terintegrasi UKOM 2025', 'M Iqbal Angga Kusuma S.Kep.,Ns., M.Kep dkk.', 'UKOM Keperawatan', 'Rangkuman materi keperawatan lengkap untuk persiapan UKOM...', 'Ebook', 'Rp.49.000', 'books/cpJ4de72UrOyoz8Wqo4Kok6WUajfGi9MpBLLQWyZ.png', '2025-08-31 20:38:20', '2025-09-01 23:12:31'),
(19, 'Rahasia Sukses UKOM Bidan 2025', 'Atika Zahria Arisanti dkk.', 'Kesehatan', 'Panduan lengkap dan strategi sukses menghadapi UKOM Bidan...', 'Buku ini berisi tips, strategi, dan soal-soal prediksi UKOM Bidan terbaru agar lulus dengan nilai maksimal.', 'Rp.110.000', 'books/ns2kdoG7c5ezlKKcNH7ujAOK19Cs1pilS8Hln65r.png', '2025-09-01 02:13:53', '2025-09-01 23:12:58');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(21, '0001_01_01_000000_create_users_table', 1),
(22, '0001_01_01_000001_create_cache_table', 1),
(23, '0001_01_01_000002_create_jobs_table', 1),
(24, '2025_08_18_065026_create_posts_table', 1),
(25, '2025_08_22_000001_add_role_to_users_table', 1),
(26, '2025_08_22_014633_create_personal_access_tokens_table', 1),
(27, '2025_08_25_000001_add_seo_fields_to_posts_table', 1),
(28, '2025_08_25_100000_create_categories_table', 1),
(29, '2025_08_25_100001_create_tags_table', 1),
(30, '2025_08_27_024457_create_books_table', 1),
(31, '2025_08_27_061739_create_visits_table', 2),
(32, '2025_08_27_072552_ensure_seo_fields_in_posts_table', 3),
(33, '2025_08_27_085535_create_team_members_table', 4),
(34, '2025_08_27_184341_create_tryout_programs_table', 5),
(35, '2025_08_27_233702_create_bimbel_programs_table', 5);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 1, 'api-token', '2ed72a20f34fc31797bbdb67dfe6ca750ffacbebfebb9d3c9b9102085cf6b82f', '[\"*\"]', NULL, NULL, '2025-08-26 21:15:34', '2025-08-26 21:15:34'),
(2, 'App\\Models\\User', 2, 'api-token', 'e49ccd1a4c83e936c3343c4fd02a50427fcc3308fe834951b8d88aec82194f30', '[\"*\"]', NULL, NULL, '2025-08-26 21:15:34', '2025-08-26 21:15:34'),
(14, 'App\\Models\\User', 3, 'api-token', '4c258a3170967ad3cbebb5ceb6005c9577b36cc7efe85c6fb7f6d490e6b8753e', '[\"*\"]', NULL, NULL, '2025-08-27 00:20:49', '2025-08-27 00:20:49'),
(16, 'App\\Models\\User', 4, 'api-token', '35251e7634aee952edb5625be80d7c9c4c75b16594e766a99cd1ecb095b0f46c', '[\"*\"]', NULL, NULL, '2025-08-27 00:21:34', '2025-08-27 00:21:34'),
(18, 'App\\Models\\User', 8, 'api-token', 'fa200ed2fd32c47a996ffbdeef301d4f60c51ff7d69acf757a6981753f402f16', '[\"*\"]', NULL, NULL, '2025-08-28 02:13:53', '2025-08-28 02:13:53'),
(19, 'App\\Models\\User', 8, 'api-token', 'a9be89385d21eb48dc320ffb8915cc972f850b834a90b4c18e097634fb18843a', '[\"*\"]', '2025-08-28 02:14:46', NULL, '2025-08-28 02:14:13', '2025-08-28 02:14:46');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `summary` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_keywords` text DEFAULT NULL,
  `canonical_url` varchar(255) DEFAULT NULL,
  `published_at` datetime DEFAULT NULL,
  `status` enum('draft','published','archived') NOT NULL DEFAULT 'draft',
  `author` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `slug`, `summary`, `content`, `image`, `created_at`, `updated_at`, `meta_title`, `meta_description`, `meta_keywords`, `canonical_url`, `published_at`, `status`, `author`, `category`) VALUES
(1, 'API Test Post', 'api-test-post', 'This post was created via API test', '<img src=\"https://developers.google.com/static/focus/images/jules.jpg\"><p></p><p></p><p></p><p></p><p>sadsadsadasdasdsdasdasdasdasdasdasdas</p><p></p><p></p><p></p><p></p><p></p>', 'posts/FgpOl8xCgR56FK8UL3LDSFfPoNj5MKZVgh75rEFN.png', '2025-08-26 21:15:34', '2025-08-31 18:47:14', NULL, NULL, NULL, NULL, NULL, 'published', 'David', NULL),
(19, 'OPINI PUBLIK TERHADAP EKONOMI SAAT INI', 'opini-publik-terhadap-ekonomi-saat-ini', 'Blog adalah sarana menyampaikan informasi', '<p>Nah, blogger adalah orang yang membuat atau memiliki dan mengelola blog, membagikan pandangan serta perspektif kepada audiens untuk tujuan pribadi maupun bisnis. Blogger juga merupakan nama layanan blogging dari Google, dengan alamat <a target=\"_blank\" rel=\"noopener noreferrer nofollow\" href=\"http://Blogger.com\"><strong>Blogger.com</strong></a> atau yang sering kita jumpai sebagai <a target=\"_blank\" rel=\"follow\" href=\"https://www.hostinger.com/id/tutorial/wordpress-vs-blogspot\"><strong>Blogspot</strong></a></p><p>Di artikel ini, kami membahas berbagai informasi seputar blog, seperti apa itu blog, apa itu blogging, sejarah blog, berbagai jenis blog, fungsi blog, dan lain sebagainya. Selamat membaca!</p><p></p>', 'posts/OO8rco1yFtYwhyws2CZ5kqMupawrFnUCls31CJ6P.jpg', '2025-08-31 23:18:36', '2025-09-01 18:56:49', 'apa itu blog?', 'blog', NULL, NULL, '2025-09-24 02:02:00', 'draft', '1', '1'),
(22, 'Demo di Jakarta, Tujuh Titik Aksi Digelar Hari Ini', 'demo-di-jakarta-tujuh-titik-aksi-digelar-hari-ini', 'Sebanyak tujuh elemen masyarakat menggelar aksi unjuk rasa di berbagai lokasi di Jakarta Pusat pada Selasa (2/9/2025).', '<p><strong>Jakarta, 2 September 2025</strong> – Sebanyak tujuh elemen masyarakat menggelar aksi unjuk rasa di berbagai lokasi di Jakarta Pusat pada Selasa (2/9/2025). Isu yang diangkat beragam, mulai dari energi, transparansi dana, hingga polemik pendidikan.</p><p>Kasi Humas Polres Metro Jakarta Pusat, Iptu Ruslan Basuki, menyampaikan bahwa seluruh aksi tersebut sudah terdata pihak kepolisian.<br>“Total ada tujuh elemen dengan tujuh lokasi aksi yang sudah tercatat hari ini,” ujarnya.</p><p></p><h4>Empat Aksi di Kawasan Monas</h4><ol><li><p><strong>Komunitas Ojek Online Mahasiswa Indonesia (KOMI)</strong></p><ul><li><p>Peserta: ±100 orang</p></li><li><p>Isu: Dugaan tindakan represif Brimob terhadap pengemudi ojek online</p></li><li><p>Waktu: 10.00 WIB</p></li></ul></li><li><p><strong>Aliansi Rakyat Peduli Energi (ARPE)</strong></p><ul><li><p>Peserta: 15 orang, dipimpin Abdul Rahman Soulisa</p></li><li><p>Isu: Desakan pembentukan tim investigasi independen terkait kontrak Pertamina–Adaro</p></li><li><p>Waktu: 10.00 WIB</p></li></ul></li><li><p><strong>Forum Ketua DPW Partai Berkarya</strong></p><ul><li><p>Peserta: ±200 orang</p></li><li><p>Isu: Kritik atas lambannya Kementerian Hukum mengesahkan kepengurusan hasil Munas I Partai Berkarya</p></li><li><p>Waktu: 13.00 WIB</p></li></ul></li><li><p><strong>Aliansi Taktis Aksi 177 URC Bergerak</strong></p><ul><li><p>Peserta: ±300 orang, dipimpin Ernalis dan Firmansyah</p></li><li><p>Aksi: Konvoi dari Monas menuju Mako Brimob, Polres Jakpus, dan Kodim 0501 Jakpus</p></li><li><p>Tema: <em>“Tebar sejuta mawar kebaikan”</em></p></li><li><p>Waktu: 14.00 WIB</p></li><li><p></p></li></ul></li></ol><h4>Aksi di Lokasi Lain</h4><ul><li><p><strong>Bank Indonesia, Jakpus</strong></p><ul><li><p>Pemuda Muslimin Indonesia, 30 peserta</p></li><li><p>Isu: Transparansi dugaan skandal dana CSR</p></li><li><p>Waktu: 10.00 WIB</p></li></ul></li><li><p><strong>Kementerian Dikti Saintek, Tanah Abang</strong></p><ul><li><p>Mantan dosen Universitas Muhammadiyah Madiun</p></li><li><p>Isu: Keberpihakan tim audit Itjen Kemendikti dalam kasus ijazah ilegal 2022</p></li><li><p>Waktu: 10.00 WIB</p></li></ul></li><li><p><strong>Kantor PT Pegadaian, Senen</strong></p><ul><li><p>Aliansi Rakyat Peduli BUMN</p></li><li><p>Isu: Dugaan kredit mikro fiktif di Cabang Syariah Karina Batam</p></li><li><p>Waktu: 10.00 WIB</p></li><li><p></p></li><li><p>Dengan banyaknya massa yang turun ke jalan secara bersamaan, aparat kepolisian menyiagakan personel di seluruh titik aksi untuk menjaga keamanan dan memastikan situasi tetap kondusif.</p></li></ul></li></ul><p></p>', 'posts/nHWVcs9c6HbUVgAMjgNpHyWKLKJXJfbhpB5GIwx1.jpg', '2025-09-01 19:43:42', '2025-09-01 20:54:49', 'Demo Jakarta 2 September 2025: 7 Titik Aksi di Jakpus', 'Sebanyak tujuh elemen masyarakat menggelar demo di Jakarta Pusat, 2 September 2025. Simak lokasi, isu, dan jadwal lengkap aksi hari ini.', 'demo jakarta 2 september 2025, titik demo jakarta pusat, jadwal aksi demo hari ini, demo monas, demo pegadaian, demo kementerian dikti', 'https://megapolitan.kompas.com/read/2025/09/02/09305251/demo-jakarta-hari-ini-ini-7-titik-demo-2september2025', '2025-09-05 11:11:00', 'published', 'Dani', 'Politik');

-- --------------------------------------------------------

--
-- Table structure for table `post_tag`
--

CREATE TABLE `post_tag` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `tag_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('cYZA1lp60AoRMpfzKwPL75PzgLPuyvawB4MzrnLc', 13, '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVVY0cEVIV3pZNmg2Y1pvbXg3em5LQWIzTm9DblpNdmlRQktNQ1JUViI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjEzO30=', 1756787204),
('II2lcem1Tv16RcsjLa8mJTRr0QHP5Vv6RkVeS851', 5, '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoicnc1MHFMNjAwTWRvOWNERldnYVdxNWNKT3RRRkptMHI5MFp4V0F6TiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjU7czo0OiJhdXRoIjthOjE6e3M6MjE6InBhc3N3b3JkX2NvbmZpcm1lZF9hdCI7aToxNzU2Nzg3NDAyO319', 1756794041);

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `team_members`
--

CREATE TABLE `team_members` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `src` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `team_members`
--

INSERT INTO `team_members` (`id`, `name`, `src`, `created_at`, `updated_at`) VALUES
(7, 'Kak Awan', 'team-members/EJT4vpBZi8PeV8l31SbRzdkTkaYlNiJ1DeB7yVRF.png', '2025-08-31 20:11:03', '2025-08-31 20:11:03'),
(8, 'Kak Atta', 'team-members/KWcNWA25LaCgG7BehadaKqZMvnZTptSlmfoqgrNa.png', '2025-08-31 20:11:17', '2025-08-31 20:11:17'),
(9, 'Kak Naufal', 'team-members/MpSyuMO9oudhzJRZbpFl9sf7xbL6QpjZuRavd1HK.png', '2025-08-31 20:11:30', '2025-08-31 20:11:30'),
(10, 'Kak Daffa', 'team-members/BF7qz8s0rU4XoqGhzzXrxdlsiJ0GQ9zZoHufG9IB.png', '2025-08-31 20:11:55', '2025-08-31 20:11:55'),
(11, 'Kak Bian', 'team-members/r8bexz8PiBjwyhaf40S6OVdbKtAjHyOUFeG2pTNp.png', '2025-08-31 20:12:24', '2025-08-31 20:12:24'),
(12, 'Kak Syauqi', 'team-members/WOQmTh0WdNff0fhBv0iWOxlzGhHnzjiCHXqNmS8G.png', '2025-08-31 20:13:58', '2025-08-31 20:13:58'),
(13, 'Kak Rezz', 'team-members/SyCFCZMY16CeIH3zCWhf03Sg1nJXS1lxvx8oTyDd.png', '2025-09-01 18:57:30', '2025-09-01 18:57:30');

-- --------------------------------------------------------

--
-- Table structure for table `tryout_programs`
--

CREATE TABLE `tryout_programs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `participants` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tryout_programs`
--

INSERT INTO `tryout_programs` (`id`, `code`, `name`, `category`, `participants`, `image`, `description`, `created_at`, `updated_at`) VALUES
(1, 'ds', 'KEBIDANAN', 'sad', '3200', 'storage/tryouts/zH9QSBHt486Ga0kwyyVn4ueGcWt9XeHSjKibTKlq.png', 'sad', '2025-08-28 02:49:46', '2025-08-31 20:22:53'),
(2, 'vxcb', 'PERAWAT', 'cxv', '4000', 'storage/tryouts/ajKfqdCrrmGQoVNK2VeT1FWyyD9MhLXII8VeiJ1b.png', 'cxv', '2025-08-28 02:52:41', '2025-09-01 01:04:24');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`) VALUES
(1, 'API Test User', 'apitest@example.com', NULL, '$2y$12$8X22fR3TiBB0GnLwx.Yle.FEBwf.QEEDWvAPSoclvqQvLHivlKSVW', NULL, '2025-08-26 21:15:34', '2025-08-26 21:55:26', 'admin'),
(2, 'API Test User', 'apitest12345678@example.com', NULL, '$2y$12$J/slIgUrxzOGSP4BJW/HjuSTsPDys1NzHiqQhNnMunXna.6dmH8/u', NULL, '2025-08-26 21:15:34', '2025-08-26 21:55:30', 'admin'),
(3, 'API Test User', 'apitest123456789@example.com', NULL, '$2y$12$/rDEbypnE0EWzH6x8HcxG.ZNx6.Nin5eE4LMt6860Hk5e8iU.ljAC', NULL, '2025-08-27 00:20:49', '2025-08-27 00:20:49', 'user'),
(4, 'API Test User', 'apitest1234567890@example.com', NULL, '$2y$12$C4B0JBpw4W55mh.iZsqlPuCL.V.wF9Fwl6djMp2NjuPGbOjac2niy', NULL, '2025-08-27 00:21:34', '2025-08-27 00:21:34', 'user'),
(5, 'muhamad', 'abc1@gmail.com', NULL, '$2y$12$xNm/rFtUT91S8pFtOL0kmukccpe1GaU79r/8NRCVtRHB/tLsJkzje', NULL, '2025-08-27 02:30:10', '2025-08-27 02:30:10', 'user'),
(6, 'dsad', 'aa@gmail.com', NULL, '$2y$12$5V3S3Z51a5iZzAhMgQOZb.hFkXxC8UQa9L5wyX3NdU0OGRgPcGpwS', NULL, '2025-08-27 02:33:59', '2025-08-27 02:33:59', 'user'),
(7, 'Gunawan', 'abc123@gmail.com', NULL, '$2y$12$tCSpM4fN8VkKF5kl3RDPNuAGu/ijFYLqFhPvOVkX2e3ek4qOlNw1O', NULL, '2025-08-27 18:31:54', '2025-08-27 18:31:54', 'user'),
(8, 'Marco', 'marco@example.com', NULL, '$2y$12$E6CA85s.oB9iZsig903vlOkwqN4vnKBkrE5NNkRPS/fM7GTfv3W7W', NULL, '2025-08-28 02:13:53', '2025-08-28 02:13:53', 'user'),
(9, 'abdi', 'abc134@gmail.com', NULL, '$2y$12$Y0g2eAtVWT/6GseXsRVplu9w0wdSkrwTTffTwwcMFhS2VcSyhSrtq', NULL, '2025-08-28 23:27:38', '2025-08-28 23:27:38', 'user'),
(10, 'abc123', 'abc12@gmail.com', NULL, '$2y$12$cJu2ww0he7tMVUk3Ao.Kduqra45kQRXduZwR3qD1woiohU6C1QouO', NULL, '2025-08-31 18:45:42', '2025-08-31 18:45:42', 'user'),
(11, 'abdi', 'a1@gmail.com', NULL, '$2y$12$V3wo5cwo.Ez7FHQSHl7vnu7w3c8QWSuFP3WQMh5QNNZhkG33ASZ6e', NULL, '2025-08-31 23:16:49', '2025-08-31 23:16:49', 'user'),
(12, 'Gunawan', 'abc111@gmail.com', NULL, '$2y$12$3YCq6LFpn.n8HgWu8YLtIeNpJEqVwPbctJz.tR/RocfTawpKVjvYu', NULL, '2025-08-31 23:39:41', '2025-08-31 23:39:41', 'user'),
(13, 'admin', 'admin@gmail.com', NULL, '$2y$12$Vw0xM/nXEhhPqvRtf8lxduy0SP/FNwB7Pn15pZsqd1qenXodIZnT2', NULL, '2025-09-01 18:50:45', '2025-09-01 18:50:45', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `visits`
--

CREATE TABLE `visits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `url` varchar(255) NOT NULL,
  `referrer` varchar(255) DEFAULT NULL,
  `user_agent` varchar(255) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `visits`
--

INSERT INTO `visits` (`id`, `url`, `referrer`, `user_agent`, `ip_address`, `created_at`, `updated_at`) VALUES
(1, '/test', 'https://google.com', 'curl/7.68.0', '127.0.0.1', '2025-09-01 02:42:18', '2025-09-01 02:42:18'),
(2, '/test', 'https://google.com', 'curl/7.68.0', '127.0.0.1', '2025-09-01 03:11:07', '2025-09-01 03:11:07'),
(3, '/test', 'https://google.com', 'curl/7.68.0', '127.0.0.1', '2025-09-01 03:11:20', '2025-09-01 03:11:20'),
(4, '/', NULL, 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '127.0.0.1', '2025-09-01 19:07:02', '2025-09-01 19:07:02'),
(5, '/', NULL, 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '127.0.0.1', '2025-09-01 19:08:09', '2025-09-01 19:08:09'),
(6, '/', NULL, 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '127.0.0.1', '2025-09-01 19:08:11', '2025-09-01 19:08:11'),
(7, '/', NULL, 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '127.0.0.1', '2025-09-01 19:08:29', '2025-09-01 19:08:29'),
(8, '/', NULL, 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '127.0.0.1', '2025-09-01 19:09:27', '2025-09-01 19:09:27'),
(9, '/', NULL, 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '127.0.0.1', '2025-09-01 19:09:31', '2025-09-01 19:09:31'),
(10, '/', 'http://localhost:3001/', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '127.0.0.1', '2025-09-01 19:09:45', '2025-09-01 19:09:45'),
(11, '/', 'http://localhost:3001/', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '127.0.0.1', '2025-09-01 19:09:50', '2025-09-01 19:09:50'),
(12, '/', NULL, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '127.0.0.1', '2025-09-01 19:10:56', '2025-09-01 19:10:56'),
(13, '/test-csrf', 'curl', 'curl-test', '127.0.0.1', '2025-09-01 19:52:55', '2025-09-01 19:52:55'),
(14, '/test-csrf', 'curl', 'curl-test', '127.0.0.1', '2025-09-01 19:54:36', '2025-09-01 19:54:36'),
(15, '/blog', 'http://localhost:3000/faq', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '127.0.0.1', '2025-09-01 20:16:15', '2025-09-01 20:16:15'),
(16, '/blog', 'http://localhost:3000/blog', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '127.0.0.1', '2025-09-01 20:16:20', '2025-09-01 20:16:20'),
(17, '/blog', 'http://localhost:3000/blog', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '127.0.0.1', '2025-09-01 20:16:50', '2025-09-01 20:16:50'),
(18, '/', 'http://localhost:3000/blog', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '127.0.0.1', '2025-09-01 20:21:42', '2025-09-01 20:21:42'),
(19, '/blog', 'http://localhost:3000/blog', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '127.0.0.1', '2025-09-01 20:21:57', '2025-09-01 20:21:57'),
(20, '/', 'http://localhost:3000/blog', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '127.0.0.1', '2025-09-01 20:22:07', '2025-09-01 20:22:07'),
(21, '/bimbel', 'http://localhost:3000/', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '127.0.0.1', '2025-09-01 20:22:14', '2025-09-01 20:22:14'),
(22, '/', 'http://localhost:3000/', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '127.0.0.1', '2025-09-01 20:22:17', '2025-09-01 20:22:17'),
(23, '/blog', 'http://localhost:3000/', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '127.0.0.1', '2025-09-01 20:22:28', '2025-09-01 20:22:28'),
(24, '/blog/opini-publik-terhadap-ekonomi-saat-ini', 'http://localhost:3000/blog', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '127.0.0.1', '2025-09-01 20:22:31', '2025-09-01 20:22:31'),
(25, '/blog', 'http://localhost:3000/', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '127.0.0.1', '2025-09-01 20:22:39', '2025-09-01 20:22:39'),
(26, '/blog/crowd', 'http://localhost:3000/blog', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '127.0.0.1', '2025-09-01 20:22:40', '2025-09-01 20:22:40'),
(27, '/blog', 'http://localhost:3000/', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '127.0.0.1', '2025-09-01 20:22:42', '2025-09-01 20:22:42'),
(28, '/blog/opini-publik-terhadap-ekonomi-saat-ini', 'http://localhost:3000/blog', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '127.0.0.1', '2025-09-01 20:22:43', '2025-09-01 20:22:43'),
(29, '/blog/opini-publik-terhadap-ekonomi-saat-ini', 'http://localhost:3000/blog', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '127.0.0.1', '2025-09-01 20:35:37', '2025-09-01 20:35:37'),
(30, '/blog', 'http://localhost:3000/', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '127.0.0.1', '2025-09-01 20:35:41', '2025-09-01 20:35:41'),
(31, '/blog', 'http://localhost:3000/', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '127.0.0.1', '2025-09-01 20:53:16', '2025-09-01 20:53:16'),
(32, '/blog/demo-di-jakarta-tujuh-titik-aksi-digelar-hari-ini', 'http://localhost:3000/blog', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '127.0.0.1', '2025-09-01 20:53:18', '2025-09-01 20:53:18'),
(33, '/blog/demo-di-jakarta-tujuh-titik-aksi-digelar-hari-ini', 'http://localhost:3000/blog', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '127.0.0.1', '2025-09-01 20:54:02', '2025-09-01 20:54:02'),
(34, '/blog/demo-di-jakarta-tujuh-titik-aksi-digelar-hari-ini', 'http://localhost:3000/blog', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '127.0.0.1', '2025-09-01 20:54:04', '2025-09-01 20:54:04'),
(35, '/blog/demo-di-jakarta-tujuh-titik-aksi-digelar-hari-ini', 'http://localhost:3000/blog', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '127.0.0.1', '2025-09-01 20:54:53', '2025-09-01 20:54:53'),
(36, '/blog', 'http://localhost:3000/', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '127.0.0.1', '2025-09-01 20:55:04', '2025-09-01 20:55:04'),
(37, '/blog/opini-publik-terhadap-ekonomi-saat-ini', 'http://localhost:3000/blog', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '127.0.0.1', '2025-09-01 20:55:06', '2025-09-01 20:55:06'),
(38, '/blog', 'http://localhost:3000/', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '127.0.0.1', '2025-09-01 20:55:07', '2025-09-01 20:55:07'),
(39, '/blog/api-test-post', 'http://localhost:3000/blog', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '127.0.0.1', '2025-09-01 20:55:09', '2025-09-01 20:55:09'),
(40, '/blog', 'http://localhost:3000/', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '127.0.0.1', '2025-09-01 20:55:10', '2025-09-01 20:55:10'),
(41, '/', 'http://localhost:3000/', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '127.0.0.1', '2025-09-01 20:55:14', '2025-09-01 20:55:14'),
(42, '/cbt', 'http://localhost:3000/', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '127.0.0.1', '2025-09-01 20:55:17', '2025-09-01 20:55:17'),
(43, '/cbt', 'http://localhost:3000/', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '127.0.0.1', '2025-09-01 20:58:30', '2025-09-01 20:58:30'),
(44, '/', 'http://localhost:3000/cbt', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '127.0.0.1', '2025-09-01 21:00:07', '2025-09-01 21:00:07'),
(45, '/cbt', 'http://localhost:3000/cbt', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '127.0.0.1', '2025-09-01 21:00:09', '2025-09-01 21:00:09'),
(46, '/', 'http://localhost:3000/cbt', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '127.0.0.1', '2025-09-01 21:01:02', '2025-09-01 21:01:02'),
(47, '/buku', 'http://localhost:3000/', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '127.0.0.1', '2025-09-01 21:17:35', '2025-09-01 21:17:35'),
(48, '/', 'http://localhost:3000/', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '127.0.0.1', '2025-09-01 21:17:56', '2025-09-01 21:17:56'),
(49, '/', 'http://localhost:3000/', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '127.0.0.1', '2025-09-01 21:18:54', '2025-09-01 21:18:54'),
(50, '/', 'http://localhost:3000/', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '127.0.0.1', '2025-09-01 21:24:57', '2025-09-01 21:24:57'),
(51, '/cbt', 'http://localhost:3000/', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '127.0.0.1', '2025-09-01 21:25:23', '2025-09-01 21:25:23'),
(52, '/blog', 'http://localhost:3000/', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '127.0.0.1', '2025-09-01 21:25:48', '2025-09-01 21:25:48'),
(53, '/blog/demo-di-jakarta-tujuh-titik-aksi-digelar-hari-ini', 'http://localhost:3000/blog', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '127.0.0.1', '2025-09-01 21:25:51', '2025-09-01 21:25:51'),
(54, '/blog/demo-di-jakarta-tujuh-titik-aksi-digelar-hari-ini', 'http://localhost:3000/blog', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '127.0.0.1', '2025-09-01 21:26:51', '2025-09-01 21:26:51'),
(55, '/blog/demo-di-jakarta-tujuh-titik-aksi-digelar-hari-ini', 'http://localhost:3000/blog', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '127.0.0.1', '2025-09-01 21:28:48', '2025-09-01 21:28:48'),
(56, '/', NULL, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '127.0.0.1', '2025-09-01 21:31:06', '2025-09-01 21:31:06'),
(57, '/', 'http://localhost:3000/blog', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '127.0.0.1', '2025-09-01 21:33:40', '2025-09-01 21:33:40'),
(58, '/blog', 'http://localhost:3000/blog', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '127.0.0.1', '2025-09-01 21:33:43', '2025-09-01 21:33:43'),
(59, '/blog/opini-publik-terhadap-ekonomi-saat-ini', 'http://localhost:3000/blog', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '127.0.0.1', '2025-09-01 21:33:46', '2025-09-01 21:33:46'),
(60, '/blog', 'http://localhost:3000/blog', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '127.0.0.1', '2025-09-01 21:33:49', '2025-09-01 21:33:49'),
(61, '/blog/demo-di-jakarta-tujuh-titik-aksi-digelar-hari-ini', 'http://localhost:3000/blog', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '127.0.0.1', '2025-09-01 21:33:50', '2025-09-01 21:33:50'),
(62, '/', 'http://localhost:3000/blog/demo-di-jakarta-tujuh-titik-aksi-digelar-hari-ini', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '127.0.0.1', '2025-09-01 21:39:08', '2025-09-01 21:39:08'),
(63, '/blog', NULL, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '127.0.0.1', '2025-09-01 21:58:35', '2025-09-01 21:58:35'),
(64, '/', NULL, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '127.0.0.1', '2025-09-01 23:10:01', '2025-09-01 23:10:01'),
(65, '/blog', NULL, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '127.0.0.1', '2025-09-01 23:10:37', '2025-09-01 23:10:37'),
(66, '/blog/demo-di-jakarta-tujuh-titik-aksi-digelar-hari-ini', 'http://localhost:3000/blog', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '127.0.0.1', '2025-09-01 23:11:00', '2025-09-01 23:11:00'),
(67, '/', 'http://localhost:3000/blog', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '127.0.0.1', '2025-09-01 23:11:09', '2025-09-01 23:11:09'),
(68, '/', 'http://localhost:3000/blog', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '127.0.0.1', '2025-09-01 23:11:38', '2025-09-01 23:11:38'),
(69, '/', 'http://localhost:3000/blog', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '127.0.0.1', '2025-09-01 23:11:59', '2025-09-01 23:11:59'),
(70, '/', 'http://localhost:3000/blog', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '127.0.0.1', '2025-09-01 23:13:03', '2025-09-01 23:13:03'),
(71, '/', 'http://localhost:3000/blog', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '127.0.0.1', '2025-09-01 23:13:50', '2025-09-01 23:13:50'),
(72, '/bimbel', 'http://localhost:3000/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '127.0.0.1', '2025-09-01 23:13:51', '2025-09-01 23:13:51'),
(73, '/', 'http://localhost:3000/blog', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '127.0.0.1', '2025-09-01 23:13:54', '2025-09-01 23:13:54'),
(74, '/bimbel', 'http://localhost:3000/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '127.0.0.1', '2025-09-01 23:13:56', '2025-09-01 23:13:56'),
(75, '/', 'http://localhost:3000/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '127.0.0.1', '2025-09-01 23:14:03', '2025-09-01 23:14:03'),
(76, '/bimbel', 'http://localhost:3000/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '127.0.0.1', '2025-09-01 23:14:06', '2025-09-01 23:14:06'),
(77, '/', 'http://localhost:3000/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '127.0.0.1', '2025-09-01 23:15:02', '2025-09-01 23:15:02'),
(78, '/blog', 'http://localhost:3000/blog/demo-di-jakarta-tujuh-titik-aksi-digelar-hari-ini', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '127.0.0.1', '2025-09-01 23:19:03', '2025-09-01 23:19:03'),
(79, '/blog/demo-di-jakarta-tujuh-titik-aksi-digelar-hari-ini', 'http://localhost:3000/blog', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '127.0.0.1', '2025-09-01 23:19:08', '2025-09-01 23:19:08'),
(80, '/', 'http://localhost:3000/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '127.0.0.1', '2025-09-02 00:02:10', '2025-09-02 00:02:10'),
(81, '/blog/demo-di-jakarta-tujuh-titik-aksi-digelar-hari-ini', 'http://localhost:3000/blog', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '127.0.0.1', '2025-09-02 00:02:10', '2025-09-02 00:02:10'),
(82, '/', 'http://localhost:3000/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '127.0.0.1', '2025-09-02 00:03:47', '2025-09-02 00:03:47'),
(83, '/blog/demo-di-jakarta-tujuh-titik-aksi-digelar-hari-ini', 'http://localhost:3000/blog', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '127.0.0.1', '2025-09-02 00:03:47', '2025-09-02 00:03:47'),
(84, '/', 'http://localhost:3000/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '127.0.0.1', '2025-09-02 00:04:16', '2025-09-02 00:04:16'),
(85, '/blog/demo-di-jakarta-tujuh-titik-aksi-digelar-hari-ini', 'http://localhost:3000/blog/demo-di-jakarta-tujuh-titik-aksi-digelar-hari-ini', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '127.0.0.1', '2025-09-02 00:04:16', '2025-09-02 00:04:16'),
(86, '/', 'http://localhost:3000/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '127.0.0.1', '2025-09-02 00:07:04', '2025-09-02 00:07:04'),
(87, '/', NULL, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '127.0.0.1', '2025-09-02 00:35:50', '2025-09-02 00:35:50'),
(88, '/', NULL, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '127.0.0.1', '2025-09-02 00:35:52', '2025-09-02 00:35:52'),
(89, '/', 'http://localhost:3000/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '127.0.0.1', '2025-09-02 00:37:02', '2025-09-02 00:37:02'),
(90, '/', NULL, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '127.0.0.1', '2025-09-02 00:40:09', '2025-09-02 00:40:09'),
(91, '/', 'http://localhost:3000/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '127.0.0.1', '2025-09-02 00:40:09', '2025-09-02 00:40:09'),
(92, '/', 'http://localhost:3000/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '127.0.0.1', '2025-09-02 00:40:21', '2025-09-02 00:40:21'),
(93, '/', NULL, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '127.0.0.1', '2025-09-02 00:40:22', '2025-09-02 00:40:22'),
(94, '/', 'http://localhost:3000/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '127.0.0.1', '2025-09-02 00:40:24', '2025-09-02 00:40:24'),
(95, '/', 'http://localhost:3000/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '127.0.0.1', '2025-09-02 00:40:26', '2025-09-02 00:40:26'),
(96, '/', 'http://localhost:3000/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '127.0.0.1', '2025-09-02 00:41:30', '2025-09-02 00:41:30'),
(97, '/', 'http://localhost:3000/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '127.0.0.1', '2025-09-02 00:42:34', '2025-09-02 00:42:34'),
(98, '/blog/demo-di-jakarta-tujuh-titik-aksi-digelar-hari-ini', 'http://localhost:3000/blog/demo-di-jakarta-tujuh-titik-aksi-digelar-hari-ini', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '127.0.0.1', '2025-09-02 00:42:54', '2025-09-02 00:42:54'),
(99, '/', 'http://localhost:3000/blog/demo-di-jakarta-tujuh-titik-aksi-digelar-hari-ini', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '127.0.0.1', '2025-09-02 00:42:56', '2025-09-02 00:42:56'),
(100, '/', 'http://localhost:3000/blog/demo-di-jakarta-tujuh-titik-aksi-digelar-hari-ini', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '127.0.0.1', '2025-09-02 00:42:58', '2025-09-02 00:42:58'),
(101, '/', 'http://localhost:3000/blog/demo-di-jakarta-tujuh-titik-aksi-digelar-hari-ini', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '127.0.0.1', '2025-09-02 00:43:03', '2025-09-02 00:43:03'),
(102, '/', 'http://localhost:3000/blog/demo-di-jakarta-tujuh-titik-aksi-digelar-hari-ini', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '127.0.0.1', '2025-09-02 00:43:13', '2025-09-02 00:43:13'),
(103, '/', 'http://localhost:3000/blog/demo-di-jakarta-tujuh-titik-aksi-digelar-hari-ini', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '127.0.0.1', '2025-09-02 00:45:01', '2025-09-02 00:45:01'),
(104, '/', 'http://localhost:3000/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '127.0.0.1', '2025-09-02 00:45:01', '2025-09-02 00:45:01'),
(105, '/', 'http://localhost:3000/blog/demo-di-jakarta-tujuh-titik-aksi-digelar-hari-ini', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '127.0.0.1', '2025-09-02 00:45:30', '2025-09-02 00:45:30'),
(106, '/', 'http://localhost:3000/blog/demo-di-jakarta-tujuh-titik-aksi-digelar-hari-ini', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '127.0.0.1', '2025-09-02 00:45:33', '2025-09-02 00:45:33'),
(107, '/', 'http://localhost:3000/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '127.0.0.1', '2025-09-02 00:46:50', '2025-09-02 00:46:50'),
(108, '/', 'http://localhost:3000/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '127.0.0.1', '2025-09-02 00:46:52', '2025-09-02 00:46:52'),
(109, '/', 'http://localhost:3000/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '127.0.0.1', '2025-09-02 00:46:55', '2025-09-02 00:46:55'),
(110, '/', 'http://localhost:3000/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '127.0.0.1', '2025-09-02 00:46:57', '2025-09-02 00:46:57'),
(111, '/', 'http://localhost:3000/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '127.0.0.1', '2025-09-02 00:47:01', '2025-09-02 00:47:01'),
(112, '/', 'http://localhost:3000/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '127.0.0.1', '2025-09-02 00:47:18', '2025-09-02 00:47:18'),
(113, '/blog', 'http://localhost:3000/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '127.0.0.1', '2025-09-02 00:47:19', '2025-09-02 00:47:19'),
(114, '/blog', 'http://localhost:3000/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '127.0.0.1', '2025-09-02 00:47:22', '2025-09-02 00:47:22'),
(115, '/blog/api-test-post', 'http://localhost:3000/blog', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '127.0.0.1', '2025-09-02 00:47:22', '2025-09-02 00:47:22'),
(116, '/blog', 'http://localhost:3000/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '127.0.0.1', '2025-09-02 00:47:24', '2025-09-02 00:47:24'),
(117, '/', 'http://localhost:3000/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '127.0.0.1', '2025-09-02 00:47:26', '2025-09-02 00:47:26'),
(118, '/blog', 'http://localhost:3000/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '127.0.0.1', '2025-09-02 00:47:28', '2025-09-02 00:47:28'),
(119, '/blog', 'http://localhost:3000/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '127.0.0.1', '2025-09-02 00:49:05', '2025-09-02 00:49:05'),
(120, '/blog', 'http://localhost:3000/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '127.0.0.1', '2025-09-02 00:49:46', '2025-09-02 00:49:46'),
(121, '/blog', 'http://localhost:3000/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '127.0.0.1', '2025-09-02 00:49:51', '2025-09-02 00:49:51'),
(122, '/blog', 'http://localhost:3000/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '127.0.0.1', '2025-09-02 00:50:35', '2025-09-02 00:50:35'),
(123, '/', 'http://localhost:3000/blog/demo-di-jakarta-tujuh-titik-aksi-digelar-hari-ini', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '127.0.0.1', '2025-09-02 00:50:36', '2025-09-02 00:50:36'),
(124, '/blog', 'http://localhost:3000/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '127.0.0.1', '2025-09-02 00:50:50', '2025-09-02 00:50:50'),
(125, '/blog', 'http://localhost:3000/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '127.0.0.1', '2025-09-02 00:50:52', '2025-09-02 00:50:52'),
(126, '/blog', 'http://localhost:3000/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '127.0.0.1', '2025-09-02 00:50:58', '2025-09-02 00:50:58'),
(127, '/blog', 'http://localhost:3000/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '127.0.0.1', '2025-09-02 00:51:01', '2025-09-02 00:51:01'),
(128, '/blog', 'http://localhost:3000/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '127.0.0.1', '2025-09-02 00:51:05', '2025-09-02 00:51:05'),
(129, '/blog', 'http://localhost:3000/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '127.0.0.1', '2025-09-02 00:51:08', '2025-09-02 00:51:08'),
(130, '/blog', 'http://localhost:3000/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '127.0.0.1', '2025-09-02 00:51:10', '2025-09-02 00:51:10'),
(131, '/blog', 'http://localhost:3000/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '127.0.0.1', '2025-09-02 00:51:44', '2025-09-02 00:51:44'),
(132, '/', 'http://localhost:3000/blog/demo-di-jakarta-tujuh-titik-aksi-digelar-hari-ini', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '127.0.0.1', '2025-09-02 00:51:51', '2025-09-02 00:51:51'),
(133, '/', 'http://localhost:3000/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '127.0.0.1', '2025-09-02 00:52:09', '2025-09-02 00:52:09'),
(134, '/', 'http://localhost:3000/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '127.0.0.1', '2025-09-02 00:52:12', '2025-09-02 00:52:12'),
(135, '/', 'http://localhost:3000/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '127.0.0.1', '2025-09-02 01:06:45', '2025-09-02 01:06:45'),
(136, '/', 'http://localhost:3000/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '127.0.0.1', '2025-09-02 01:06:49', '2025-09-02 01:06:49'),
(137, '/blog', 'http://localhost:3000/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '127.0.0.1', '2025-09-02 01:06:57', '2025-09-02 01:06:57'),
(138, '/faq', 'http://localhost:3000/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '127.0.0.1', '2025-09-02 01:06:58', '2025-09-02 01:06:58'),
(139, '/', 'http://localhost:3000/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '127.0.0.1', '2025-09-02 01:07:00', '2025-09-02 01:07:00'),
(140, '/blog', 'http://localhost:3000/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '127.0.0.1', '2025-09-02 01:07:09', '2025-09-02 01:07:09'),
(141, '/faq', 'http://localhost:3000/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '127.0.0.1', '2025-09-02 01:07:09', '2025-09-02 01:07:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bimbel_programs`
--
ALTER TABLE `bimbel_programs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bimbel_programs_code_unique` (`code`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `posts_slug_unique` (`slug`);

--
-- Indexes for table `post_tag`
--
ALTER TABLE `post_tag`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_tag_post_id_foreign` (`post_id`),
  ADD KEY `post_tag_tag_id_foreign` (`tag_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tags_slug_unique` (`slug`);

--
-- Indexes for table `team_members`
--
ALTER TABLE `team_members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tryout_programs`
--
ALTER TABLE `tryout_programs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tryout_programs_code_unique` (`code`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `visits`
--
ALTER TABLE `visits`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bimbel_programs`
--
ALTER TABLE `bimbel_programs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `post_tag`
--
ALTER TABLE `post_tag`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `team_members`
--
ALTER TABLE `team_members`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tryout_programs`
--
ALTER TABLE `tryout_programs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `visits`
--
ALTER TABLE `visits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=142;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `post_tag`
--
ALTER TABLE `post_tag`
  ADD CONSTRAINT `post_tag_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_tag_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
