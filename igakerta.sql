-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 04, 2026 at 03:35 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `igakerta`
--

-- --------------------------------------------------------

--
-- Table structure for table `author_submissions`
--

CREATE TABLE `author_submissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `synopsis` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `author_submissions`
--

INSERT INTO `author_submissions` (`id`, `name`, `email`, `phone`, `title`, `synopsis`, `file_path`, `status`, `created_at`, `updated_at`) VALUES
(1, 'pangeran', 'pangeran@gmail.com', '088561384302', 'Pengantar Kecerdasan Tiruan untuk Pertanian', 'test', NULL, 'pending', '2026-06-02 22:54:51', '2026-06-02 22:54:51');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `cover_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `published_year` int DEFAULT NULL,
  `pages` int DEFAULT NULL,
  `isbn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `category`, `price`, `description`, `cover_image`, `is_featured`, `published_year`, `pages`, `isbn`, `created_at`, `updated_at`) VALUES
(1, 'Pengembangan UMKM Berbasis Digital Marketing', 'Dr. Endang Setyowati, M.M.', 'Ekonomi & Bisnis', 85000, 'Buku ini membahas strategi praktis pengembangan usaha mikro, kecil, dan menengah dengan memanfaatkan platform pemasaran digital untuk meningkatkan penjualan dan daya saing di era global.', 'book_umkm.jpg', 1, 2024, 180, '978-623-456-111-2', '2026-06-02 20:43:09', '2026-06-02 20:43:09'),
(2, 'Mitigasi Bencana Berbasis Komunitas', 'Ir. Suparman, M.T.', 'Pengabdian Masyarakat', 75000, 'Buku panduan edukasi masyarakat mengenai kesiapsiagaan bencana, strategi evakuasi mandiri, dan penguatan kelembagaan lokal dalam mengurangi risiko bencana alam di lingkungan sekitar.', 'book_bencana.jpg', 1, 2024, 160, '978-623-456-222-9', '2026-06-02 20:43:09', '2026-06-02 20:43:09'),
(3, 'Pemberdayaan Masyarakat Melalui Inovasi Sosial', 'Prof. Dr. Herman Yusuf', 'Sosial Humaniora', 90000, 'Menyajikan kajian mendalam mengenai program pemberdayaan masyarakat yang digerakkan oleh inovasi sosial dan partisipasi aktif warga untuk mewujudkan kemandirian ekonomi berkelanjutan.', 'book_pemberdayaan.jpg', 1, 2024, 210, '978-623-456-333-5', '2026-06-02 20:43:09', '2026-06-02 20:43:09'),
(4, 'Literasi dan Pendidikan untuk Semua', 'Dr. Maria Ulfah, M.Pd.', 'Pendidikan', 80000, 'Strategi peningkatan minat baca dan pemerataan akses pendidikan di daerah terpencil melalui program literasi inklusif dan taman bacaan masyarakat.', 'book_literasi.jpg', 1, 2024, 195, '978-623-456-444-1', '2026-06-02 20:43:09', '2026-06-02 20:43:09'),
(5, 'Kesehatan Masyarakat dan Lingkungan Hidup', 'Dr. dr. Budi Santoso, M.Kes.', 'Kesehatan', 88000, 'Menganalisis hubungan erat antara kesehatan sanitasi lingkungan, penyediaan air bersih, dan gaya hidup sehat dalam mencegah penyebaran penyakit menular di masyarakat.', 'book_kesehatan.jpg', 1, 2024, 220, '978-623-456-555-4', '2026-06-02 20:43:09', '2026-06-02 20:43:09'),
(6, 'Inovasi Pendidikan di Era Digital', 'Rian Hidayat, M.T. & Tim', 'Pendidikan', 82000, 'Mengulas metode pembelajaran modern menggunakan platform e-learning, teknologi multimedia interaktif, dan kecerdasan buatan untuk meningkatkan efektivitas belajar mengajar.', 'book_inovasi_edu.jpg', 1, 2024, 175, '978-623-456-666-7', '2026-06-02 20:43:09', '2026-06-02 20:43:09'),
(7, 'Artificial Intelligence Untuk Pemula', 'Dr. Eng. Farid Wajdi', 'Teknologi', 95000, 'Buku pengantar yang menjelaskan konsep dasar kecerdasan buatan, machine learning, neural networks, dan implementasi sederhananya dalam kehidupan sehari-hari menggunakan Python.', 'book_ai.jpg', 1, 2024, 205, '978-623-456-777-0', '2026-06-02 20:43:09', '2026-06-02 20:43:09'),
(8, 'Manajemen Keuangan Modern', 'Dr. H. M. Anwar, S.E., M.Si.', 'Ekonomi & Bisnis', 89000, 'Panduan lengkap perencanaan keuangan, investasi portofolio, analisis laporan keuangan perusahaan, serta pengambilan keputusan finansial strategis di masa kini.', 'book_keuangan.jpg', 1, 2024, 240, '978-623-456-888-3', '2026-06-02 20:43:09', '2026-06-02 20:43:09'),
(9, 'Hukum dan Masyarakat Kontemporer', 'Prof. Dr. Sudarmono, S.H., M.Hum.', 'Sosial Humaniora', 87000, 'Mengkaji perkembangan sistem hukum positif di Indonesia dalam merespons dinamika perubahan sosial, teknologi informasi, dan globalisasi masyarakat modern.', 'book_hukum.jpg', 1, 2024, 190, '978-623-456-999-6', '2026-06-02 20:43:09', '2026-06-02 20:43:09'),
(10, 'Bioteknologi Untuk Kehidupan', 'Dr. Rina Astuti, M.Si.', 'Sains', 98000, 'Menjelaskan teknik rekayasa genetika, kultur jaringan, dan pemanfaatan mikroorganisme dalam industri pangan, medis, pertanian, dan kelestarian alam.', 'book_biotech.jpg', 1, 2024, 215, '978-623-456-010-7', '2026-06-02 20:43:09', '2026-06-02 20:43:09'),
(11, 'Sastra Indonesia dan Budaya', 'Dra. Siti Nurbaya, M.Hum.', 'Sastra', 72000, 'Apresiasi karya sastra nusantara klasik hingga modern serta kaitannya dengan pelestarian nilai kearifan lokal dan karakter budaya bangsa Indonesia.', 'book_sastra.jpg', 1, 2024, 165, '978-623-456-020-6', '2026-06-02 20:43:09', '2026-06-02 20:43:09'),
(12, 'Energi Terbarukan dan Keberlanjutan', 'Dr. Ir. Joko Santoso', 'Sains', 92000, 'Mengulas potensi energi matahari, angin, hidro, dan biomassa sebagai solusi transisi energi bersih ramah lingkungan demi mewujudkan pembangunan berkelanjutan.', 'book_energi.jpg', 1, 2024, 185, '978-623-456-030-5', '2026-06-02 20:43:09', '2026-06-02 20:43:09');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2026_06_02_055602_create_books_table', 1),
(6, '2026_06_02_055606_create_author_submissions_table', 1),
(7, '2026_06_02_055615_create_news_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `title`, `slug`, `content`, `category`, `author`, `image`, `published_at`, `created_at`, `updated_at`) VALUES
(1, 'Cara Sukses Mengubah Tesis/Disertasi Menjadi Buku Ajar Terakreditasi', 'cara-sukses-mengubah-tesis-disertasi-menjadi-buku-ajar', 'Banyak akademisi yang bingung bagaimana memanfaatkan hasil penelitian tesis atau disertasi mereka agar tidak hanya tersimpan di perpustakaan. Salah satu cara terbaik adalah mengonversinya menjadi Buku Monograf atau Buku Ajar ber-ISBN. Langkah pertama adalah menyesuaikan gaya bahasa ilmiah yang kaku menjadi bahasa tutur yang edukatif. Kedua, sesuaikan struktur bab agar menyerupai kurikulum perkuliahan. Penerbit IGAKERTA menyediakan layanan pendampingan bagi dosen untuk mempermudah proses konversi ini.', 'Tips Menulis', 'Dr. Ahmad Fauzi, M.Pd.', 'news_writing.jpg', '2026-06-02 20:43:09', '2026-06-02 20:43:09', '2026-06-02 20:43:09'),
(2, 'Pentingnya E-ISSN 3048-4499 Bagi Jurnal Pengabdian Masyarakat', 'pentingnya-e-issn-bagi-jurnal-pengabdian-masyarakat', 'Jurnal Igakerta yang fokus pada Inovasi Gagasan Abdimas & Kuliah Kerja Nyata kini telah resmi memiliki E-ISSN 3048-4499. Keberadaan ISSN elektronik ini sangat krusial karena memastikan artikel ilmiah yang diterbitkan terindeks secara global, memudahkan sitasi, serta meningkatkan akreditasi jurnal (SINTA). Para penulis dan dosen disarankan untuk selalu memverifikasi status ISSN sebelum mengirimkan naskah pengabdian mereka agar kontribusi akademis mereka diakui secara resmi oleh Kemendikbudristek.', 'Info Jurnal', 'Sekretaris Redaksi Jurnal', 'news_journal.jpg', '2026-05-31 20:43:09', '2026-06-02 20:43:09', '2026-06-02 20:43:09'),
(3, 'IGAKERTA Membuka Program Insentif Penerbitan Buku Pendidikan 2026', 'igakerta-membuka-program-insentif-penerbitan-buku-2026', 'Sebagai wujud nyata komitmen dalam mencerdaskan kehidupan bangsa, Penerbit & Percetakan IGAKERTA meluncurkan Program Insentif Penerbitan Buku untuk periode awal tahun 2026. Melalui program ini, naskah terpilih dari guru dan dosen akan mendapatkan potongan biaya penerbitan hingga 50%, fasilitas editing gratis, desain cover eksklusif, serta pemasaran secara nasional baik fisik maupun e-book. Pengajuan naskah dibuka dari Juni hingga Agustus 2026 melalui portal online kami.', 'Pengumuman', 'Direktur Utama IGAKERTA', 'news_incentive.jpg', '2026-05-28 20:43:09', '2026-06-02 20:43:09', '2026-06-02 20:43:09');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `author_submissions`
--
ALTER TABLE `author_submissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `news_slug_unique` (`slug`);

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
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `author_submissions`
--
ALTER TABLE `author_submissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
