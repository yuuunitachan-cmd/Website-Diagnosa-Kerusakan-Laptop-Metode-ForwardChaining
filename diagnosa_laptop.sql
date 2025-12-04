-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 20, 2025 at 03:00 AM
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
-- Database: `diagnosa_laptop`
--

-- --------------------------------------------------------

--
-- Table structure for table `basis_pengetahuans`
--

CREATE TABLE `basis_pengetahuans` (
  `id` bigint UNSIGNED NOT NULL,
  `kerusakan_id` bigint UNSIGNED NOT NULL,
  `gejala_id` bigint UNSIGNED NOT NULL,
  `bobot` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `basis_pengetahuans`
--

INSERT INTO `basis_pengetahuans` (`id`, `kerusakan_id`, `gejala_id`, `bobot`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 0.80, '2025-11-17 23:14:23', '2025-11-17 23:14:23'),
(2, 1, 2, 0.60, '2025-11-17 23:14:23', '2025-11-17 23:14:23'),
(3, 1, 7, 0.70, '2025-11-17 23:14:23', '2025-11-17 23:14:23'),
(4, 2, 3, 0.90, '2025-11-17 23:14:23', '2025-11-17 23:14:23'),
(5, 2, 4, 0.80, '2025-11-17 23:14:23', '2025-11-17 23:14:23'),
(6, 2, 2, 0.50, '2025-11-17 23:14:23', '2025-11-17 23:14:23'),
(7, 3, 5, 0.90, '2025-11-17 23:14:23', '2025-11-17 23:14:23'),
(8, 3, 10, 0.70, '2025-11-17 23:14:23', '2025-11-17 23:14:23'),
(9, 3, 2, 0.60, '2025-11-17 23:14:23', '2025-11-17 23:14:23'),
(10, 4, 6, 0.90, '2025-11-17 23:14:23', '2025-11-17 23:14:23'),
(11, 4, 9, 0.80, '2025-11-17 23:14:23', '2025-11-17 23:14:23'),
(12, 4, 2, 0.70, '2025-11-17 23:14:23', '2025-11-17 23:14:23'),
(13, 4, 4, 0.60, '2025-11-17 23:14:23', '2025-11-17 23:14:23'),
(14, 5, 7, 0.80, '2025-11-17 23:14:23', '2025-11-17 23:14:23'),
(15, 5, 8, 0.90, '2025-11-17 23:14:23', '2025-11-17 23:14:23'),
(16, 5, 1, 0.40, '2025-11-17 23:14:23', '2025-11-17 23:14:23');

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
-- Table structure for table `gejalas`
--

CREATE TABLE `gejalas` (
  `id` bigint UNSIGNED NOT NULL,
  `kode_gejala` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_gejala` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gejalas`
--

INSERT INTO `gejalas` (`id`, `kode_gejala`, `nama_gejala`, `deskripsi`, `created_at`, `updated_at`) VALUES
(1, 'G001', 'Laptop tidak bisa menyala', 'Laptop sama sekali tidak menunjukkan tanda HIDUP', '2025-11-17 23:14:23', '2025-11-18 01:31:35'),
(2, 'G002', 'Laptop mati sendiri', 'Laptop tiba-tiba mati saat digunakan', '2025-11-17 23:14:23', '2025-11-17 23:14:23'),
(3, 'G003', 'Blue Screen (BSOD)', 'Muncul layar biru dengan kode error', '2025-11-17 23:14:23', '2025-11-17 23:14:23'),
(4, 'G004', 'Laptop lambat dan sering hang', 'Performa laptop sangat lambat dan sering not responding', '2025-11-17 23:14:23', '2025-11-17 23:14:23'),
(5, 'G005', 'Baterai tidak bisa dicharge', 'Baterai tidak terisi meski sudah dicharge lama', '2025-11-17 23:14:23', '2025-11-17 23:14:23'),
(6, 'G006', 'Laptop cepat panas', 'Laptop menjadi sangat panas dalam waktu singkat', '2025-11-17 23:14:23', '2025-11-17 23:14:23'),
(7, 'G007', 'Layar blank/hitam', 'Laptop menyala tapi layar tetap hitam', '2025-11-17 23:14:23', '2025-11-17 23:14:23'),
(8, 'G008', 'Ada garis-garis pada layar', 'Muncul garis vertikal/horizontal pada layar', '2025-11-17 23:14:23', '2025-11-17 23:14:23'),
(9, 'G009', 'Suara kipas berisik', 'Kipas laptop berbunyi keras tidak normal', '2025-11-17 23:14:23', '2025-11-17 23:14:23'),
(10, 'G010', 'Baterai cepat habis', 'Daya baterai terkuras sangat cepat', '2025-11-17 23:14:23', '2025-11-17 23:14:23');

-- --------------------------------------------------------

--
-- Table structure for table `histories`
--

CREATE TABLE `histories` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_pengguna` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gejala_terpilih` json NOT NULL,
  `hasil_diagnosa` json NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `histories`
--

INSERT INTO `histories` (`id`, `nama_pengguna`, `email`, `gejala_terpilih`, `hasil_diagnosa`, `created_at`, `updated_at`) VALUES
(1, 'John Doe', 'john@example.com', '\"[1,2]\"', '\"[{\\\"kerusakan\\\":{\\\"id\\\":1,\\\"kode_kerusakan\\\":\\\"K001\\\",\\\"nama_kerusakan\\\":\\\"Hardware Failure\\\",\\\"deskripsi\\\":\\\"Kerusakan pada komponen hardware laptop\\\",\\\"solusi\\\":\\\"Ganti komponen yang rusak, bawa ke service center\\\"},\\\"cf\\\":85.5,\\\"persentase\\\":85.5}]\"', '2025-11-17 23:14:23', '2025-11-17 23:14:23');

-- --------------------------------------------------------

--
-- Table structure for table `kerusakans`
--

CREATE TABLE `kerusakans` (
  `id` bigint UNSIGNED NOT NULL,
  `kode_kerusakan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_kerusakan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `solusi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kerusakans`
--

INSERT INTO `kerusakans` (`id`, `kode_kerusakan`, `nama_kerusakan`, `deskripsi`, `solusi`, `created_at`, `updated_at`) VALUES
(1, 'K001', 'Hardware Failure', 'Kerusakan pada komponen hardware laptop', 'Ganti komponen yang rusak, bawa ke service center', '2025-11-17 23:14:23', '2025-11-17 23:14:23'),
(2, 'K002', 'Software Corruption', 'Kerusakan sistem operasi atau software', 'Install ulang sistem operasi, update driver', '2025-11-17 23:14:23', '2025-11-17 23:14:23'),
(3, 'K003', 'Battery Problem', 'Masalah pada baterai laptop', 'Ganti baterai, kalibrasi baterai, cek charger', '2025-11-17 23:14:23', '2025-11-17 23:14:23'),
(4, 'K004', 'Overheating', 'Laptop terlalu panas', 'Bersihkan kipas, ganti thermal paste, gunakan cooling pad', '2025-11-17 23:14:23', '2025-11-17 23:14:23'),
(5, 'K005', 'Display Issue', 'Masalah pada layar laptop', 'Cek kabel LCD, ganti layar, update driver grafis', '2025-11-17 23:14:23', '2025-11-17 23:14:23');

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
(5, '2025_11_18_053158_create_kerusakans_table', 1),
(6, '2025_11_18_053506_create_gejala_table', 1),
(7, '2025_11_18_053546_create_basis_pengetahuan_table', 1),
(8, '2025_11_18_053625_create_histories_table', 1),
(9, '2025_11_18_055955_update_histories_table', 1),
(10, '2025_11_18_063041_add_role_to_users_table', 1);

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
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` enum('admin','user') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`) VALUES
(1, 'Admin', 'admin@diagnosa.com', NULL, '$2y$12$dBthcvBCDjrhSqu.mqM7O.iG7Bx.UA7IbXHU75RzFlvVfJpMuPLkS', 'oojQgTspNS7XYGPOXhXySvH4AvGPNdrZAIhi6TsdlkQdamQTY44RxLDORiQv', '2025-11-17 23:14:23', '2025-11-17 23:14:23', 'admin'),
(2, 'User Demo', 'user@diagnosa.com', NULL, '$2y$12$EBlDhni0634DvvzlUXkH4OzlRjoqYXOC7OT3940UD8BzL2LJ7KHCe', NULL, '2025-11-17 23:14:23', '2025-11-17 23:14:23', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `basis_pengetahuans`
--
ALTER TABLE `basis_pengetahuans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `basis_pengetahuans_kerusakan_id_foreign` (`kerusakan_id`),
  ADD KEY `basis_pengetahuans_gejala_id_foreign` (`gejala_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `gejalas`
--
ALTER TABLE `gejalas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `gejalas_kode_gejala_unique` (`kode_gejala`);

--
-- Indexes for table `histories`
--
ALTER TABLE `histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kerusakans`
--
ALTER TABLE `kerusakans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kerusakans_kode_kerusakan_unique` (`kode_kerusakan`);

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
-- AUTO_INCREMENT for table `basis_pengetahuans`
--
ALTER TABLE `basis_pengetahuans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gejalas`
--
ALTER TABLE `gejalas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `histories`
--
ALTER TABLE `histories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kerusakans`
--
ALTER TABLE `kerusakans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `basis_pengetahuans`
--
ALTER TABLE `basis_pengetahuans`
  ADD CONSTRAINT `basis_pengetahuans_gejala_id_foreign` FOREIGN KEY (`gejala_id`) REFERENCES `gejalas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `basis_pengetahuans_kerusakan_id_foreign` FOREIGN KEY (`kerusakan_id`) REFERENCES `kerusakans` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
