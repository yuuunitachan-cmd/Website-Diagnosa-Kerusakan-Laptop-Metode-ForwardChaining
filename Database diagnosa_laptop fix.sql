-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 30, 2025 at 06:38 AM
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
-- Table structure for table `basis_pengetahuan`
--

CREATE TABLE `basis_pengetahuan` (
  `id` bigint UNSIGNED NOT NULL,
  `kerusakan_id` bigint UNSIGNED NOT NULL,
  `gejala_id` bigint UNSIGNED NOT NULL,
  `urutan` int NOT NULL DEFAULT '1',
  `is_aktif` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
-- Table structure for table `gejala`
--

CREATE TABLE `gejala` (
  `id` bigint UNSIGNED NOT NULL,
  `kode_gejala` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_gejala` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `kategori` enum('hardware','software','battery','display') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_aktif` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gejala`
--

INSERT INTO `gejala` (`id`, `kode_gejala`, `nama_gejala`, `deskripsi`, `kategori`, `is_aktif`, `created_at`, `updated_at`) VALUES
(1, 'G001', 'Laptop tidak bisa menyala', 'Laptop sama sekali tidak menunjukkan tanda HIDUP', 'hardware', 1, '2025-11-17 23:14:23', '2025-11-18 01:31:35'),
(2, 'G002', 'Laptop mati sendiri', 'Laptop tiba-tiba mati saat digunakan', 'hardware', 1, '2025-11-17 23:14:23', '2025-11-17 23:14:23'),
(3, 'G003', 'Blue Screen (BSOD)', 'Muncul layar biru dengan kode error', 'software', 1, '2025-11-17 23:14:23', '2025-11-17 23:14:23'),
(4, 'G004', 'Laptop lambat dan sering hang', 'Performa laptop sangat lambat dan sering not responding', 'software', 1, '2025-11-17 23:14:23', '2025-11-17 23:14:23'),
(5, 'G005', 'Baterai tidak bisa dicharge', 'Baterai tidak terisi meski sudah dicharge lama', 'battery', 1, '2025-11-17 23:14:23', '2025-11-17 23:14:23'),
(6, 'G006', 'Laptop cepat panas', 'Laptop menjadi sangat panas dalam waktu singkat', 'hardware', 1, '2025-11-17 23:14:23', '2025-11-17 23:14:23'),
(7, 'G007', 'Layar blank/hitam', 'Laptop menyala tapi layar tetap hitam', 'hardware', 1, '2025-11-17 23:14:23', '2025-11-17 23:14:23'),
(8, 'G008', 'Ada garis-garis pada layar', 'Muncul garis vertikal/horizontal pada layar', 'hardware', 1, '2025-11-17 23:14:23', '2025-11-17 23:14:23'),
(9, 'G009', 'Suara kipas berisik', 'Kipas laptop berbunyi keras tidak normal', 'hardware', 1, '2025-11-17 23:14:23', '2025-11-17 23:14:23'),
(10, 'G010', 'Baterai cepat habis', 'Daya baterai terkuras sangat cepat', 'battery', 1, '2025-11-17 23:14:23', '2025-11-17 23:14:23');

-- --------------------------------------------------------

--
-- Table structure for table `histories`
--

CREATE TABLE `histories` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_pengguna` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `gejala_terpilih` json NOT NULL,
  `fakta_terbukti` json DEFAULT NULL,
  `rules_tertrigger` json DEFAULT NULL,
  `hasil_akhir` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `langkah_diagnosa` int NOT NULL DEFAULT '0',
  `hasil_diagnosa` json NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `histories`
--

INSERT INTO `histories` (`id`, `nama_pengguna`, `email`, `user_id`, `gejala_terpilih`, `fakta_terbukti`, `rules_tertrigger`, `hasil_akhir`, `langkah_diagnosa`, `hasil_diagnosa`, `created_at`, `updated_at`) VALUES
(1, 'John Doe', 'john@example.com', NULL, '\"[1,2]\"', NULL, NULL, NULL, 0, '\"[{\\\"kerusakan\\\":{\\\"id\\\":1,\\\"kode_kerusakan\\\":\\\"K001\\\",\\\"nama_kerusakan\\\":\\\"Hardware Failure\\\",\\\"deskripsi\\\":\\\"Kerusakan pada komponen hardware laptop\\\",\\\"solusi\\\":\\\"Ganti komponen yang rusak, bawa ke service center\\\"},\\\"cf\\\":85.5,\\\"persentase\\\":85.5}]\"', '2025-11-17 23:14:23', '2025-11-17 23:14:23'),
(2, 'User Demo', 'user@diagnosa.com', 2, '\"[\\\"10\\\"]\"', NULL, NULL, NULL, 0, '\"[{\\\"kerusakan\\\":{\\\"id\\\":3,\\\"kode_kerusakan\\\":\\\"K003\\\",\\\"nama_kerusakan\\\":\\\"Battery Problem\\\",\\\"deskripsi\\\":\\\"Masalah pada baterai laptop\\\",\\\"solusi\\\":\\\"Ganti baterai, kalibrasi baterai, cek charger\\\",\\\"kategori\\\":\\\"battery\\\",\\\"tingkat_kerusakan\\\":\\\"sedang\\\",\\\"created_at\\\":\\\"2025-11-18T07:14:23.000000Z\\\",\\\"updated_at\\\":\\\"2025-11-18T07:14:23.000000Z\\\",\\\"basis_pengetahuan\\\":[{\\\"id\\\":8,\\\"kerusakan_id\\\":3,\\\"gejala_id\\\":10,\\\"bobot\\\":0.7,\\\"created_at\\\":\\\"2025-11-18T07:14:23.000000Z\\\",\\\"updated_at\\\":\\\"2025-11-18T07:14:23.000000Z\\\"}]},\\\"cf\\\":0.7,\\\"persentase\\\":70,\\\"gejala_count\\\":1}]\"', '2025-11-20 08:49:15', '2025-11-20 08:49:15'),
(3, 'User Demo', 'user@diagnosa.com', 2, '\"[\\\"1\\\",\\\"4\\\"]\"', NULL, NULL, NULL, 0, '\"[{\\\"kerusakan\\\":{\\\"id\\\":1,\\\"kode_kerusakan\\\":\\\"K001\\\",\\\"nama_kerusakan\\\":\\\"Hardware Failure\\\",\\\"deskripsi\\\":\\\"Kerusakan pada komponen hardware laptop seperti motherboard, RAM, atau processor\\\",\\\"solusi\\\":\\\"Ganti komponen yang rusak, bawa ke service center, cek kabel internal\\\",\\\"kategori\\\":\\\"hardware\\\",\\\"tingkat_kerusakan\\\":\\\"sedang\\\",\\\"created_at\\\":\\\"2025-11-18T07:14:23.000000Z\\\",\\\"updated_at\\\":\\\"2025-11-20T03:45:24.000000Z\\\",\\\"basis_pengetahuan\\\":[{\\\"id\\\":1,\\\"kerusakan_id\\\":1,\\\"gejala_id\\\":1,\\\"bobot\\\":0.8,\\\"created_at\\\":\\\"2025-11-18T07:14:23.000000Z\\\",\\\"updated_at\\\":\\\"2025-11-18T07:14:23.000000Z\\\"}]},\\\"cf\\\":0.8,\\\"persentase\\\":80,\\\"gejala_count\\\":1},{\\\"kerusakan\\\":{\\\"id\\\":2,\\\"kode_kerusakan\\\":\\\"K002\\\",\\\"nama_kerusakan\\\":\\\"Software Corruption\\\",\\\"deskripsi\\\":\\\"Kerusakan sistem operasi atau software\\\",\\\"solusi\\\":\\\"Install ulang sistem operasi, update driver\\\",\\\"kategori\\\":\\\"software\\\",\\\"tingkat_kerusakan\\\":\\\"sedang\\\",\\\"created_at\\\":\\\"2025-11-18T07:14:23.000000Z\\\",\\\"updated_at\\\":\\\"2025-11-18T07:14:23.000000Z\\\",\\\"basis_pengetahuan\\\":[{\\\"id\\\":5,\\\"kerusakan_id\\\":2,\\\"gejala_id\\\":4,\\\"bobot\\\":0.8,\\\"created_at\\\":\\\"2025-11-18T07:14:23.000000Z\\\",\\\"updated_at\\\":\\\"2025-11-18T07:14:23.000000Z\\\"}]},\\\"cf\\\":0.8,\\\"persentase\\\":80,\\\"gejala_count\\\":1},{\\\"kerusakan\\\":{\\\"id\\\":4,\\\"kode_kerusakan\\\":\\\"K004\\\",\\\"nama_kerusakan\\\":\\\"Overheating\\\",\\\"deskripsi\\\":\\\"Laptop terlalu panas\\\",\\\"solusi\\\":\\\"Bersihkan kipas, ganti thermal paste, gunakan cooling pad\\\",\\\"kategori\\\":\\\"hardware\\\",\\\"tingkat_kerusakan\\\":\\\"sedang\\\",\\\"created_at\\\":\\\"2025-11-18T07:14:23.000000Z\\\",\\\"updated_at\\\":\\\"2025-11-18T07:14:23.000000Z\\\",\\\"basis_pengetahuan\\\":[{\\\"id\\\":13,\\\"kerusakan_id\\\":4,\\\"gejala_id\\\":4,\\\"bobot\\\":0.6,\\\"created_at\\\":\\\"2025-11-18T07:14:23.000000Z\\\",\\\"updated_at\\\":\\\"2025-11-18T07:14:23.000000Z\\\"}]},\\\"cf\\\":0.6,\\\"persentase\\\":60,\\\"gejala_count\\\":1},{\\\"kerusakan\\\":{\\\"id\\\":5,\\\"kode_kerusakan\\\":\\\"K005\\\",\\\"nama_kerusakan\\\":\\\"Display Issue\\\",\\\"deskripsi\\\":\\\"Masalah pada layar laptop\\\",\\\"solusi\\\":\\\"Cek kabel LCD, ganti layar, update driver grafis\\\",\\\"kategori\\\":\\\"display\\\",\\\"tingkat_kerusakan\\\":\\\"sedang\\\",\\\"created_at\\\":\\\"2025-11-18T07:14:23.000000Z\\\",\\\"updated_at\\\":\\\"2025-11-18T07:14:23.000000Z\\\",\\\"basis_pengetahuan\\\":[{\\\"id\\\":16,\\\"kerusakan_id\\\":5,\\\"gejala_id\\\":1,\\\"bobot\\\":0.4,\\\"created_at\\\":\\\"2025-11-18T07:14:23.000000Z\\\",\\\"updated_at\\\":\\\"2025-11-18T07:14:23.000000Z\\\"}]},\\\"cf\\\":0.4,\\\"persentase\\\":40,\\\"gejala_count\\\":1}]\"', '2025-11-20 17:54:41', '2025-11-20 17:54:41'),
(4, 'User Demo', 'user@diagnosa.com', 2, '\"[\\\"1\\\",\\\"3\\\",\\\"10\\\"]\"', NULL, NULL, NULL, 0, '\"[{\\\"kerusakan\\\":{\\\"id\\\":2,\\\"kode_kerusakan\\\":\\\"K002\\\",\\\"nama_kerusakan\\\":\\\"Software Corruption\\\",\\\"deskripsi\\\":\\\"Kerusakan sistem operasi atau software\\\",\\\"solusi\\\":\\\"Install ulang sistem operasi, update driver\\\",\\\"kategori\\\":\\\"software\\\",\\\"tingkat_kerusakan\\\":\\\"sedang\\\",\\\"created_at\\\":\\\"2025-11-18T07:14:23.000000Z\\\",\\\"updated_at\\\":\\\"2025-11-18T07:14:23.000000Z\\\",\\\"basis_pengetahuan\\\":[{\\\"id\\\":4,\\\"kerusakan_id\\\":2,\\\"gejala_id\\\":3,\\\"bobot\\\":0.9,\\\"created_at\\\":\\\"2025-11-18T07:14:23.000000Z\\\",\\\"updated_at\\\":\\\"2025-11-18T07:14:23.000000Z\\\"}]},\\\"cf\\\":0.9,\\\"persentase\\\":90,\\\"gejala_count\\\":1},{\\\"kerusakan\\\":{\\\"id\\\":1,\\\"kode_kerusakan\\\":\\\"K001\\\",\\\"nama_kerusakan\\\":\\\"Hardware Failure\\\",\\\"deskripsi\\\":\\\"Kerusakan pada komponen hardware laptop seperti motherboard, RAM, atau processor\\\",\\\"solusi\\\":\\\"Ganti komponen yang rusak, bawa ke service center, cek kabel internal\\\",\\\"kategori\\\":\\\"hardware\\\",\\\"tingkat_kerusakan\\\":\\\"sedang\\\",\\\"created_at\\\":\\\"2025-11-18T07:14:23.000000Z\\\",\\\"updated_at\\\":\\\"2025-11-20T03:45:24.000000Z\\\",\\\"basis_pengetahuan\\\":[{\\\"id\\\":1,\\\"kerusakan_id\\\":1,\\\"gejala_id\\\":1,\\\"bobot\\\":0.8,\\\"created_at\\\":\\\"2025-11-18T07:14:23.000000Z\\\",\\\"updated_at\\\":\\\"2025-11-18T07:14:23.000000Z\\\"}]},\\\"cf\\\":0.8,\\\"persentase\\\":80,\\\"gejala_count\\\":1},{\\\"kerusakan\\\":{\\\"id\\\":3,\\\"kode_kerusakan\\\":\\\"K003\\\",\\\"nama_kerusakan\\\":\\\"Battery Problem\\\",\\\"deskripsi\\\":\\\"Masalah pada baterai laptop\\\",\\\"solusi\\\":\\\"Ganti baterai, kalibrasi baterai, cek charger\\\",\\\"kategori\\\":\\\"battery\\\",\\\"tingkat_kerusakan\\\":\\\"sedang\\\",\\\"created_at\\\":\\\"2025-11-18T07:14:23.000000Z\\\",\\\"updated_at\\\":\\\"2025-11-18T07:14:23.000000Z\\\",\\\"basis_pengetahuan\\\":[{\\\"id\\\":8,\\\"kerusakan_id\\\":3,\\\"gejala_id\\\":10,\\\"bobot\\\":0.7,\\\"created_at\\\":\\\"2025-11-18T07:14:23.000000Z\\\",\\\"updated_at\\\":\\\"2025-11-18T07:14:23.000000Z\\\"}]},\\\"cf\\\":0.7,\\\"persentase\\\":70,\\\"gejala_count\\\":1},{\\\"kerusakan\\\":{\\\"id\\\":5,\\\"kode_kerusakan\\\":\\\"K005\\\",\\\"nama_kerusakan\\\":\\\"Display Issue\\\",\\\"deskripsi\\\":\\\"Masalah pada layar laptop\\\",\\\"solusi\\\":\\\"Cek kabel LCD, ganti layar, update driver grafis\\\",\\\"kategori\\\":\\\"display\\\",\\\"tingkat_kerusakan\\\":\\\"sedang\\\",\\\"created_at\\\":\\\"2025-11-18T07:14:23.000000Z\\\",\\\"updated_at\\\":\\\"2025-11-18T07:14:23.000000Z\\\",\\\"basis_pengetahuan\\\":[{\\\"id\\\":16,\\\"kerusakan_id\\\":5,\\\"gejala_id\\\":1,\\\"bobot\\\":0.4,\\\"created_at\\\":\\\"2025-11-18T07:14:23.000000Z\\\",\\\"updated_at\\\":\\\"2025-11-18T07:14:23.000000Z\\\"}]},\\\"cf\\\":0.4,\\\"persentase\\\":40,\\\"gejala_count\\\":1}]\"', '2025-11-20 18:07:53', '2025-11-20 18:07:53'),
(7, 'User', 'user@diagnosa.com', 2, '\"[\\\"1\\\",\\\"6\\\"]\"', NULL, NULL, NULL, 0, '\"[{\\\"kerusakan\\\":{\\\"id\\\":4,\\\"kode_kerusakan\\\":\\\"K004\\\",\\\"nama_kerusakan\\\":\\\"Overheating\\\",\\\"deskripsi\\\":\\\"Laptop terlalu panas\\\",\\\"solusi\\\":\\\"Bersihkan kipas, ganti thermal paste, gunakan cooling pad\\\",\\\"kategori\\\":\\\"hardware\\\",\\\"tingkat_kerusakan\\\":\\\"sedang\\\",\\\"created_at\\\":\\\"2025-11-18T07:14:23.000000Z\\\",\\\"updated_at\\\":\\\"2025-11-18T07:14:23.000000Z\\\",\\\"basis_pengetahuan\\\":[{\\\"id\\\":10,\\\"kerusakan_id\\\":4,\\\"gejala_id\\\":6,\\\"bobot\\\":0.9,\\\"created_at\\\":\\\"2025-11-18T07:14:23.000000Z\\\",\\\"updated_at\\\":\\\"2025-11-18T07:14:23.000000Z\\\"}]},\\\"cf\\\":0.9,\\\"persentase\\\":90,\\\"gejala_count\\\":1},{\\\"kerusakan\\\":{\\\"id\\\":1,\\\"kode_kerusakan\\\":\\\"K001\\\",\\\"nama_kerusakan\\\":\\\"Hardware Failure\\\",\\\"deskripsi\\\":\\\"Kerusakan pada komponen hardware laptop seperti motherboard, RAM, atau processor\\\",\\\"solusi\\\":\\\"Ganti komponen yang rusak, bawa ke service center, cek kabel internal\\\",\\\"kategori\\\":\\\"hardware\\\",\\\"tingkat_kerusakan\\\":\\\"sedang\\\",\\\"created_at\\\":\\\"2025-11-18T07:14:23.000000Z\\\",\\\"updated_at\\\":\\\"2025-11-20T03:45:24.000000Z\\\",\\\"basis_pengetahuan\\\":[{\\\"id\\\":1,\\\"kerusakan_id\\\":1,\\\"gejala_id\\\":1,\\\"bobot\\\":0.8,\\\"created_at\\\":\\\"2025-11-18T07:14:23.000000Z\\\",\\\"updated_at\\\":\\\"2025-11-18T07:14:23.000000Z\\\"}]},\\\"cf\\\":0.8,\\\"persentase\\\":80,\\\"gejala_count\\\":1},{\\\"kerusakan\\\":{\\\"id\\\":5,\\\"kode_kerusakan\\\":\\\"K005\\\",\\\"nama_kerusakan\\\":\\\"Display Issue\\\",\\\"deskripsi\\\":\\\"Masalah pada layar laptop\\\",\\\"solusi\\\":\\\"Cek kabel LCD, ganti layar, update driver grafis\\\",\\\"kategori\\\":\\\"display\\\",\\\"tingkat_kerusakan\\\":\\\"sedang\\\",\\\"created_at\\\":\\\"2025-11-18T07:14:23.000000Z\\\",\\\"updated_at\\\":\\\"2025-11-18T07:14:23.000000Z\\\",\\\"basis_pengetahuan\\\":[{\\\"id\\\":16,\\\"kerusakan_id\\\":5,\\\"gejala_id\\\":1,\\\"bobot\\\":0.4,\\\"created_at\\\":\\\"2025-11-18T07:14:23.000000Z\\\",\\\"updated_at\\\":\\\"2025-11-18T07:14:23.000000Z\\\"}]},\\\"cf\\\":0.4,\\\"persentase\\\":40,\\\"gejala_count\\\":1}]\"', '2025-11-20 19:27:36', '2025-11-20 19:27:36'),
(8, 'User', 'user@diagnosa.com', 2, '\"[\\\"2\\\",\\\"10\\\"]\"', NULL, NULL, NULL, 0, '\"[{\\\"kerusakan\\\":{\\\"id\\\":3,\\\"kode_kerusakan\\\":\\\"K003\\\",\\\"nama_kerusakan\\\":\\\"Battery Problem\\\",\\\"deskripsi\\\":\\\"Masalah pada baterai laptop\\\",\\\"solusi\\\":\\\"Ganti baterai, kalibrasi baterai, cek charger\\\",\\\"kategori\\\":\\\"battery\\\",\\\"tingkat_kerusakan\\\":\\\"sedang\\\",\\\"created_at\\\":\\\"2025-11-18T07:14:23.000000Z\\\",\\\"updated_at\\\":\\\"2025-11-18T07:14:23.000000Z\\\",\\\"basis_pengetahuan\\\":[{\\\"id\\\":9,\\\"kerusakan_id\\\":3,\\\"gejala_id\\\":2,\\\"bobot\\\":0.6,\\\"created_at\\\":\\\"2025-11-18T07:14:23.000000Z\\\",\\\"updated_at\\\":\\\"2025-11-18T07:14:23.000000Z\\\"},{\\\"id\\\":8,\\\"kerusakan_id\\\":3,\\\"gejala_id\\\":10,\\\"bobot\\\":0.7,\\\"created_at\\\":\\\"2025-11-18T07:14:23.000000Z\\\",\\\"updated_at\\\":\\\"2025-11-18T07:14:23.000000Z\\\"}]},\\\"cf\\\":0.8799999999999999,\\\"persentase\\\":88,\\\"gejala_count\\\":2},{\\\"kerusakan\\\":{\\\"id\\\":4,\\\"kode_kerusakan\\\":\\\"K004\\\",\\\"nama_kerusakan\\\":\\\"Overheating\\\",\\\"deskripsi\\\":\\\"Laptop terlalu panas\\\",\\\"solusi\\\":\\\"Bersihkan kipas, ganti thermal paste, gunakan cooling pad\\\",\\\"kategori\\\":\\\"hardware\\\",\\\"tingkat_kerusakan\\\":\\\"sedang\\\",\\\"created_at\\\":\\\"2025-11-18T07:14:23.000000Z\\\",\\\"updated_at\\\":\\\"2025-11-18T07:14:23.000000Z\\\",\\\"basis_pengetahuan\\\":[{\\\"id\\\":12,\\\"kerusakan_id\\\":4,\\\"gejala_id\\\":2,\\\"bobot\\\":0.7,\\\"created_at\\\":\\\"2025-11-18T07:14:23.000000Z\\\",\\\"updated_at\\\":\\\"2025-11-18T07:14:23.000000Z\\\"}]},\\\"cf\\\":0.7,\\\"persentase\\\":70,\\\"gejala_count\\\":1},{\\\"kerusakan\\\":{\\\"id\\\":1,\\\"kode_kerusakan\\\":\\\"K001\\\",\\\"nama_kerusakan\\\":\\\"Hardware Failure\\\",\\\"deskripsi\\\":\\\"Kerusakan pada komponen hardware laptop seperti motherboard, RAM, atau processor\\\",\\\"solusi\\\":\\\"Ganti komponen yang rusak, bawa ke service center, cek kabel internal\\\",\\\"kategori\\\":\\\"hardware\\\",\\\"tingkat_kerusakan\\\":\\\"sedang\\\",\\\"created_at\\\":\\\"2025-11-18T07:14:23.000000Z\\\",\\\"updated_at\\\":\\\"2025-11-20T03:45:24.000000Z\\\",\\\"basis_pengetahuan\\\":[{\\\"id\\\":2,\\\"kerusakan_id\\\":1,\\\"gejala_id\\\":2,\\\"bobot\\\":0.6,\\\"created_at\\\":\\\"2025-11-18T07:14:23.000000Z\\\",\\\"updated_at\\\":\\\"2025-11-18T07:14:23.000000Z\\\"}]},\\\"cf\\\":0.6,\\\"persentase\\\":60,\\\"gejala_count\\\":1},{\\\"kerusakan\\\":{\\\"id\\\":2,\\\"kode_kerusakan\\\":\\\"K002\\\",\\\"nama_kerusakan\\\":\\\"Software Corruption\\\",\\\"deskripsi\\\":\\\"Kerusakan sistem operasi atau software\\\",\\\"solusi\\\":\\\"Install ulang sistem operasi, update driver\\\",\\\"kategori\\\":\\\"software\\\",\\\"tingkat_kerusakan\\\":\\\"sedang\\\",\\\"created_at\\\":\\\"2025-11-18T07:14:23.000000Z\\\",\\\"updated_at\\\":\\\"2025-11-18T07:14:23.000000Z\\\",\\\"basis_pengetahuan\\\":[{\\\"id\\\":6,\\\"kerusakan_id\\\":2,\\\"gejala_id\\\":2,\\\"bobot\\\":0.5,\\\"created_at\\\":\\\"2025-11-18T07:14:23.000000Z\\\",\\\"updated_at\\\":\\\"2025-11-18T07:14:23.000000Z\\\"}]},\\\"cf\\\":0.5,\\\"persentase\\\":50,\\\"gejala_count\\\":1}]\"', '2025-11-20 19:49:06', '2025-11-20 19:49:06'),
(9, 'Admin', 'admin@diagnosa.com', 1, '[\"2\", \"10\"]', '[\"2\", \"10\"]', '[{\"id\": 2, \"rule\": \"IF G002 THEN K001\", \"step\": 1, \"gejala_kode\": \"G002\", \"gejala_nama\": \"Laptop mati sendiri\", \"kerusakan_kode\": \"K001\", \"kerusakan_nama\": \"Hardware Failure\"}, {\"id\": 7, \"rule\": \"IF G010 THEN K003\", \"step\": 2, \"gejala_kode\": \"G010\", \"gejala_nama\": \"Baterai cepat habis\", \"kerusakan_kode\": \"K003\", \"kerusakan_nama\": \"Battery Problem\"}]', 'Hardware Failure', 3, '{\"total_langkah\": 3, \"fakta_terbukti\": [\"2\", \"10\"], \"kesimpulan_akhir\": {\"kerusakan\": {\"id\": 1, \"solusi\": \"Ganti komponen yang rusak, bawa ke service center, cek kabel internal\", \"is_final\": 1, \"kategori\": \"hardware\", \"deskripsi\": \"Kerusakan pada komponen hardware laptop seperti motherboard, RAM, atau processor\", \"created_at\": \"2025-11-18T07:14:23.000000Z\", \"updated_at\": \"2025-11-20T03:45:24.000000Z\", \"kode_kerusakan\": \"K001\", \"nama_kerusakan\": \"Hardware Failure\", \"tingkat_kerusakan\": \"sedang\"}, \"confidence\": 33.33333333333333, \"total_rules\": 1, \"gejala_terkait\": [2]}, \"langkah_diagnosa\": [{\"step\": 1, \"action\": \"Memulai diagnosa dengan gejala: Laptop mati sendiri, Baterai cepat habis\", \"conclusions\": [], \"working_memory\": [\"2\", \"10\"]}, {\"step\": 1, \"action\": \"Rule triggered: IF Laptop mati sendiri THEN Hardware Failure\", \"conclusions\": [1], \"working_memory\": [\"2\", \"10\"]}, {\"step\": 2, \"action\": \"Rule triggered: IF Baterai cepat habis THEN Battery Problem\", \"conclusions\": [1, 3], \"working_memory\": [\"2\", \"10\"]}], \"rules_tertrigger\": [{\"id\": 2, \"rule\": \"IF G002 THEN K001\", \"step\": 1, \"gejala_kode\": \"G002\", \"gejala_nama\": \"Laptop mati sendiri\", \"kerusakan_kode\": \"K001\", \"kerusakan_nama\": \"Hardware Failure\"}, {\"id\": 7, \"rule\": \"IF G010 THEN K003\", \"step\": 2, \"gejala_kode\": \"G010\", \"gejala_nama\": \"Baterai cepat habis\", \"kerusakan_kode\": \"K003\", \"kerusakan_nama\": \"Battery Problem\"}], \"semua_kemungkinan\": [{\"kerusakan\": {\"id\": 1, \"solusi\": \"Ganti komponen yang rusak, bawa ke service center, cek kabel internal\", \"is_final\": 1, \"kategori\": \"hardware\", \"deskripsi\": \"Kerusakan pada komponen hardware laptop seperti motherboard, RAM, atau processor\", \"created_at\": \"2025-11-18T07:14:23.000000Z\", \"updated_at\": \"2025-11-20T03:45:24.000000Z\", \"kode_kerusakan\": \"K001\", \"nama_kerusakan\": \"Hardware Failure\", \"tingkat_kerusakan\": \"sedang\"}, \"total_rules\": 1, \"gejala_terkait\": [2]}, {\"kerusakan\": {\"id\": 3, \"solusi\": \"Ganti baterai, kalibrasi baterai, cek charger\", \"is_final\": 1, \"kategori\": \"battery\", \"deskripsi\": \"Masalah pada baterai laptop\", \"created_at\": \"2025-11-18T07:14:23.000000Z\", \"updated_at\": \"2025-11-18T07:14:23.000000Z\", \"kode_kerusakan\": \"K003\", \"nama_kerusakan\": \"Battery Problem\", \"tingkat_kerusakan\": \"sedang\"}, \"total_rules\": 1, \"gejala_terkait\": [10]}], \"total_rules_tertrigger\": 2}', '2025-11-22 05:46:50', '2025-11-22 05:46:50'),
(10, 'Admin', 'admin@diagnosa.com', 1, '[\"2\", \"10\"]', '[\"2\", \"10\"]', '[{\"id\": 2, \"rule\": \"IF G002 THEN K001\", \"step\": 1, \"gejala_kode\": \"G002\", \"gejala_nama\": \"Laptop mati sendiri\", \"kerusakan_kode\": \"K001\", \"kerusakan_nama\": \"Hardware Failure\"}, {\"id\": 7, \"rule\": \"IF G010 THEN K003\", \"step\": 2, \"gejala_kode\": \"G010\", \"gejala_nama\": \"Baterai cepat habis\", \"kerusakan_kode\": \"K003\", \"kerusakan_nama\": \"Battery Problem\"}]', 'Hardware Failure', 3, '{\"total_langkah\": 3, \"fakta_terbukti\": [\"2\", \"10\"], \"kesimpulan_akhir\": {\"kerusakan\": {\"id\": 1, \"solusi\": \"Ganti komponen yang rusak, bawa ke service center, cek kabel internal\", \"is_final\": 1, \"kategori\": \"hardware\", \"deskripsi\": \"Kerusakan pada komponen hardware laptop seperti motherboard, RAM, atau processor\", \"created_at\": \"2025-11-18T07:14:23.000000Z\", \"updated_at\": \"2025-11-20T03:45:24.000000Z\", \"kode_kerusakan\": \"K001\", \"nama_kerusakan\": \"Hardware Failure\", \"tingkat_kerusakan\": \"sedang\"}, \"confidence\": 33.33333333333333, \"total_rules\": 1, \"gejala_terkait\": [2]}, \"langkah_diagnosa\": [{\"step\": 1, \"action\": \"Memulai diagnosa dengan gejala: Laptop mati sendiri, Baterai cepat habis\", \"conclusions\": [], \"working_memory\": [\"2\", \"10\"]}, {\"step\": 1, \"action\": \"Rule triggered: IF Laptop mati sendiri THEN Hardware Failure\", \"conclusions\": [1], \"working_memory\": [\"2\", \"10\"]}, {\"step\": 2, \"action\": \"Rule triggered: IF Baterai cepat habis THEN Battery Problem\", \"conclusions\": [1, 3], \"working_memory\": [\"2\", \"10\"]}], \"rules_tertrigger\": [{\"id\": 2, \"rule\": \"IF G002 THEN K001\", \"step\": 1, \"gejala_kode\": \"G002\", \"gejala_nama\": \"Laptop mati sendiri\", \"kerusakan_kode\": \"K001\", \"kerusakan_nama\": \"Hardware Failure\"}, {\"id\": 7, \"rule\": \"IF G010 THEN K003\", \"step\": 2, \"gejala_kode\": \"G010\", \"gejala_nama\": \"Baterai cepat habis\", \"kerusakan_kode\": \"K003\", \"kerusakan_nama\": \"Battery Problem\"}], \"semua_kemungkinan\": [{\"kerusakan\": {\"id\": 1, \"solusi\": \"Ganti komponen yang rusak, bawa ke service center, cek kabel internal\", \"is_final\": 1, \"kategori\": \"hardware\", \"deskripsi\": \"Kerusakan pada komponen hardware laptop seperti motherboard, RAM, atau processor\", \"created_at\": \"2025-11-18T07:14:23.000000Z\", \"updated_at\": \"2025-11-20T03:45:24.000000Z\", \"kode_kerusakan\": \"K001\", \"nama_kerusakan\": \"Hardware Failure\", \"tingkat_kerusakan\": \"sedang\"}, \"total_rules\": 1, \"gejala_terkait\": [2]}, {\"kerusakan\": {\"id\": 3, \"solusi\": \"Ganti baterai, kalibrasi baterai, cek charger\", \"is_final\": 1, \"kategori\": \"battery\", \"deskripsi\": \"Masalah pada baterai laptop\", \"created_at\": \"2025-11-18T07:14:23.000000Z\", \"updated_at\": \"2025-11-18T07:14:23.000000Z\", \"kode_kerusakan\": \"K003\", \"nama_kerusakan\": \"Battery Problem\", \"tingkat_kerusakan\": \"sedang\"}, \"total_rules\": 1, \"gejala_terkait\": [10]}], \"total_rules_tertrigger\": 2}', '2025-11-22 05:47:44', '2025-11-22 05:47:44'),
(11, 'User', 'user@diagnosa.com', 2, '[\"1\", \"9\", \"5\", \"10\"]', '[\"1\", \"9\", \"5\", \"10\"]', '[{\"id\": 1, \"rule\": \"IF G001 THEN K001\", \"step\": 1, \"gejala_kode\": \"G001\", \"gejala_nama\": \"Laptop tidak bisa menyala\", \"kerusakan_kode\": \"K001\", \"kerusakan_nama\": \"Hardware Failure\"}, {\"id\": 6, \"rule\": \"IF G005 THEN K003\", \"step\": 2, \"gejala_kode\": \"G005\", \"gejala_nama\": \"Baterai tidak bisa dicharge\", \"kerusakan_kode\": \"K003\", \"kerusakan_nama\": \"Battery Problem\"}, {\"id\": 9, \"rule\": \"IF G009 THEN K004\", \"step\": 3, \"gejala_kode\": \"G009\", \"gejala_nama\": \"Suara kipas berisik\", \"kerusakan_kode\": \"K004\", \"kerusakan_nama\": \"Overheating\"}]', 'Hardware Failure', 4, '{\"total_langkah\": 4, \"fakta_terbukti\": [\"1\", \"9\", \"5\", \"10\"], \"kesimpulan_akhir\": {\"kerusakan\": {\"id\": 1, \"solusi\": \"Ganti komponen yang rusak, bawa ke service center, cek kabel internal\", \"is_final\": 1, \"kategori\": \"hardware\", \"deskripsi\": \"Kerusakan pada komponen hardware laptop seperti motherboard, RAM, atau processor\", \"created_at\": \"2025-11-18T07:14:23.000000Z\", \"updated_at\": \"2025-11-20T03:45:24.000000Z\", \"kode_kerusakan\": \"K001\", \"nama_kerusakan\": \"Hardware Failure\", \"tingkat_kerusakan\": \"sedang\"}, \"confidence\": 50, \"total_rules\": 1, \"gejala_terkait\": [1]}, \"langkah_diagnosa\": [{\"step\": 1, \"action\": \"Memulai diagnosa dengan gejala: Laptop tidak bisa menyala, Baterai tidak bisa dicharge, Suara kipas berisik, Baterai cepat habis\", \"conclusions\": [], \"working_memory\": [\"1\", \"9\", \"5\", \"10\"]}, {\"step\": 1, \"action\": \"Rule triggered: IF Laptop tidak bisa menyala THEN Hardware Failure\", \"conclusions\": [1], \"working_memory\": [\"1\", \"9\", \"5\", \"10\"]}, {\"step\": 2, \"action\": \"Rule triggered: IF Baterai tidak bisa dicharge THEN Battery Problem\", \"conclusions\": [1, 3], \"working_memory\": [\"1\", \"9\", \"5\", \"10\"]}, {\"step\": 3, \"action\": \"Rule triggered: IF Suara kipas berisik THEN Overheating\", \"conclusions\": [1, 3, 4], \"working_memory\": [\"1\", \"9\", \"5\", \"10\"]}], \"rules_tertrigger\": [{\"id\": 1, \"rule\": \"IF G001 THEN K001\", \"step\": 1, \"gejala_kode\": \"G001\", \"gejala_nama\": \"Laptop tidak bisa menyala\", \"kerusakan_kode\": \"K001\", \"kerusakan_nama\": \"Hardware Failure\"}, {\"id\": 6, \"rule\": \"IF G005 THEN K003\", \"step\": 2, \"gejala_kode\": \"G005\", \"gejala_nama\": \"Baterai tidak bisa dicharge\", \"kerusakan_kode\": \"K003\", \"kerusakan_nama\": \"Battery Problem\"}, {\"id\": 9, \"rule\": \"IF G009 THEN K004\", \"step\": 3, \"gejala_kode\": \"G009\", \"gejala_nama\": \"Suara kipas berisik\", \"kerusakan_kode\": \"K004\", \"kerusakan_nama\": \"Overheating\"}], \"semua_kemungkinan\": [{\"kerusakan\": {\"id\": 1, \"solusi\": \"Ganti komponen yang rusak, bawa ke service center, cek kabel internal\", \"is_final\": 1, \"kategori\": \"hardware\", \"deskripsi\": \"Kerusakan pada komponen hardware laptop seperti motherboard, RAM, atau processor\", \"created_at\": \"2025-11-18T07:14:23.000000Z\", \"updated_at\": \"2025-11-20T03:45:24.000000Z\", \"kode_kerusakan\": \"K001\", \"nama_kerusakan\": \"Hardware Failure\", \"tingkat_kerusakan\": \"sedang\"}, \"total_rules\": 1, \"gejala_terkait\": [1]}, {\"kerusakan\": {\"id\": 3, \"solusi\": \"Ganti baterai, kalibrasi baterai, cek charger\", \"is_final\": 1, \"kategori\": \"battery\", \"deskripsi\": \"Masalah pada baterai laptop\", \"created_at\": \"2025-11-18T07:14:23.000000Z\", \"updated_at\": \"2025-11-18T07:14:23.000000Z\", \"kode_kerusakan\": \"K003\", \"nama_kerusakan\": \"Battery Problem\", \"tingkat_kerusakan\": \"sedang\"}, \"total_rules\": 1, \"gejala_terkait\": [5]}, {\"kerusakan\": {\"id\": 4, \"solusi\": \"Bersihkan kipas, ganti thermal paste, gunakan cooling pad\", \"is_final\": 1, \"kategori\": \"hardware\", \"deskripsi\": \"Laptop terlalu panas\", \"created_at\": \"2025-11-18T07:14:23.000000Z\", \"updated_at\": \"2025-11-18T07:14:23.000000Z\", \"kode_kerusakan\": \"K004\", \"nama_kerusakan\": \"Overheating\", \"tingkat_kerusakan\": \"sedang\"}, \"total_rules\": 1, \"gejala_terkait\": [9]}], \"total_rules_tertrigger\": 3}', '2025-11-22 06:43:44', '2025-11-22 06:43:44'),
(12, 'User', 'user@diagnosa.com', 2, '[\"1\", \"2\", \"6\", \"7\", \"8\", \"9\", \"3\", \"4\", \"5\", \"10\"]', '[\"1\", \"2\", \"6\", \"7\", \"8\", \"9\", \"3\", \"4\", \"5\", \"10\"]', '[{\"id\": 1, \"rule\": \"IF G001 THEN K001\", \"step\": 1, \"gejala_kode\": \"G001\", \"gejala_nama\": \"Laptop tidak bisa menyala\", \"kerusakan_kode\": \"K001\", \"kerusakan_nama\": \"Hardware Failure\"}, {\"id\": 6, \"rule\": \"IF G005 THEN K003\", \"step\": 2, \"gejala_kode\": \"G005\", \"gejala_nama\": \"Baterai tidak bisa dicharge\", \"kerusakan_kode\": \"K003\", \"kerusakan_nama\": \"Battery Problem\"}, {\"id\": 8, \"rule\": \"IF G006 THEN K004\", \"step\": 3, \"gejala_kode\": \"G006\", \"gejala_nama\": \"Laptop cepat panas\", \"kerusakan_kode\": \"K004\", \"kerusakan_nama\": \"Overheating\"}, {\"id\": 10, \"rule\": \"IF G007 THEN K005\", \"step\": 4, \"gejala_kode\": \"G007\", \"gejala_nama\": \"Layar blank/hitam\", \"kerusakan_kode\": \"K005\", \"kerusakan_nama\": \"Display Issue\"}, {\"id\": 12, \"rule\": \"IF G004 THEN K006\", \"step\": 5, \"gejala_kode\": \"G004\", \"gejala_nama\": \"Laptop lambat dan sering hang\", \"kerusakan_kode\": \"K006\", \"kerusakan_nama\": \"crash atau hang\"}, {\"id\": 2, \"rule\": \"IF G002 THEN K001\", \"step\": 6, \"gejala_kode\": \"G002\", \"gejala_nama\": \"Laptop mati sendiri\", \"kerusakan_kode\": \"K001\", \"kerusakan_nama\": \"Hardware Failure\"}, {\"id\": 9, \"rule\": \"IF G009 THEN K004\", \"step\": 7, \"gejala_kode\": \"G009\", \"gejala_nama\": \"Suara kipas berisik\", \"kerusakan_kode\": \"K004\", \"kerusakan_nama\": \"Overheating\"}, {\"id\": 11, \"rule\": \"IF G008 THEN K005\", \"step\": 8, \"gejala_kode\": \"G008\", \"gejala_nama\": \"Ada garis-garis pada layar\", \"kerusakan_kode\": \"K005\", \"kerusakan_nama\": \"Display Issue\"}, {\"id\": 13, \"rule\": \"IF G003 THEN K006\", \"step\": 9, \"gejala_kode\": \"G003\", \"gejala_nama\": \"Blue Screen (BSOD)\", \"kerusakan_kode\": \"K006\", \"kerusakan_nama\": \"crash atau hang\"}]', 'Hardware Failure', 10, '{\"total_langkah\": 10, \"fakta_terbukti\": [\"1\", \"2\", \"6\", \"7\", \"8\", \"9\", \"3\", \"4\", \"5\", \"10\"], \"kesimpulan_akhir\": {\"kerusakan\": {\"id\": 1, \"solusi\": \"Ganti komponen yang rusak, bawa ke service center, cek kabel internal\", \"is_final\": 1, \"kategori\": \"hardware\", \"deskripsi\": \"Kerusakan pada komponen hardware laptop seperti motherboard, RAM, atau processor\", \"created_at\": \"2025-11-18T07:14:23.000000Z\", \"updated_at\": \"2025-11-20T03:45:24.000000Z\", \"kode_kerusakan\": \"K001\", \"nama_kerusakan\": \"Hardware Failure\", \"tingkat_kerusakan\": \"sedang\"}, \"confidence\": 100, \"total_rules\": 2, \"gejala_terkait\": [1, 2]}, \"langkah_diagnosa\": [{\"step\": 1, \"action\": \"Memulai diagnosa dengan gejala: Laptop tidak bisa menyala, Laptop mati sendiri, Blue Screen (BSOD), Laptop lambat dan sering hang, Baterai tidak bisa dicharge, Laptop cepat panas, Layar blank/hitam, Ada garis-garis pada layar, Suara kipas berisik, Baterai cepat habis\", \"conclusions\": [], \"working_memory\": [\"1\", \"2\", \"6\", \"7\", \"8\", \"9\", \"3\", \"4\", \"5\", \"10\"]}, {\"step\": 1, \"action\": \"Rule triggered: IF Laptop tidak bisa menyala THEN Hardware Failure\", \"conclusions\": [1], \"working_memory\": [\"1\", \"2\", \"6\", \"7\", \"8\", \"9\", \"3\", \"4\", \"5\", \"10\"]}, {\"step\": 2, \"action\": \"Rule triggered: IF Baterai tidak bisa dicharge THEN Battery Problem\", \"conclusions\": [1, 3], \"working_memory\": [\"1\", \"2\", \"6\", \"7\", \"8\", \"9\", \"3\", \"4\", \"5\", \"10\"]}, {\"step\": 3, \"action\": \"Rule triggered: IF Laptop cepat panas THEN Overheating\", \"conclusions\": [1, 3, 4], \"working_memory\": [\"1\", \"2\", \"6\", \"7\", \"8\", \"9\", \"3\", \"4\", \"5\", \"10\"]}, {\"step\": 4, \"action\": \"Rule triggered: IF Layar blank/hitam THEN Display Issue\", \"conclusions\": [1, 3, 4, 5], \"working_memory\": [\"1\", \"2\", \"6\", \"7\", \"8\", \"9\", \"3\", \"4\", \"5\", \"10\"]}, {\"step\": 5, \"action\": \"Rule triggered: IF Laptop lambat dan sering hang THEN crash atau hang\", \"conclusions\": [1, 3, 4, 5, 6], \"working_memory\": [\"1\", \"2\", \"6\", \"7\", \"8\", \"9\", \"3\", \"4\", \"5\", \"10\"]}, {\"step\": 6, \"action\": \"Rule triggered: IF Laptop mati sendiri THEN Hardware Failure\", \"conclusions\": [1, 3, 4, 5, 6], \"working_memory\": [\"1\", \"2\", \"6\", \"7\", \"8\", \"9\", \"3\", \"4\", \"5\", \"10\"]}, {\"step\": 7, \"action\": \"Rule triggered: IF Suara kipas berisik THEN Overheating\", \"conclusions\": [1, 3, 4, 5, 6], \"working_memory\": [\"1\", \"2\", \"6\", \"7\", \"8\", \"9\", \"3\", \"4\", \"5\", \"10\"]}, {\"step\": 8, \"action\": \"Rule triggered: IF Ada garis-garis pada layar THEN Display Issue\", \"conclusions\": [1, 3, 4, 5, 6], \"working_memory\": [\"1\", \"2\", \"6\", \"7\", \"8\", \"9\", \"3\", \"4\", \"5\", \"10\"]}, {\"step\": 9, \"action\": \"Rule triggered: IF Blue Screen (BSOD) THEN crash atau hang\", \"conclusions\": [1, 3, 4, 5, 6], \"working_memory\": [\"1\", \"2\", \"6\", \"7\", \"8\", \"9\", \"3\", \"4\", \"5\", \"10\"]}], \"rules_tertrigger\": [{\"id\": 1, \"rule\": \"IF G001 THEN K001\", \"step\": 1, \"gejala_kode\": \"G001\", \"gejala_nama\": \"Laptop tidak bisa menyala\", \"kerusakan_kode\": \"K001\", \"kerusakan_nama\": \"Hardware Failure\"}, {\"id\": 6, \"rule\": \"IF G005 THEN K003\", \"step\": 2, \"gejala_kode\": \"G005\", \"gejala_nama\": \"Baterai tidak bisa dicharge\", \"kerusakan_kode\": \"K003\", \"kerusakan_nama\": \"Battery Problem\"}, {\"id\": 8, \"rule\": \"IF G006 THEN K004\", \"step\": 3, \"gejala_kode\": \"G006\", \"gejala_nama\": \"Laptop cepat panas\", \"kerusakan_kode\": \"K004\", \"kerusakan_nama\": \"Overheating\"}, {\"id\": 10, \"rule\": \"IF G007 THEN K005\", \"step\": 4, \"gejala_kode\": \"G007\", \"gejala_nama\": \"Layar blank/hitam\", \"kerusakan_kode\": \"K005\", \"kerusakan_nama\": \"Display Issue\"}, {\"id\": 12, \"rule\": \"IF G004 THEN K006\", \"step\": 5, \"gejala_kode\": \"G004\", \"gejala_nama\": \"Laptop lambat dan sering hang\", \"kerusakan_kode\": \"K006\", \"kerusakan_nama\": \"crash atau hang\"}, {\"id\": 2, \"rule\": \"IF G002 THEN K001\", \"step\": 6, \"gejala_kode\": \"G002\", \"gejala_nama\": \"Laptop mati sendiri\", \"kerusakan_kode\": \"K001\", \"kerusakan_nama\": \"Hardware Failure\"}, {\"id\": 9, \"rule\": \"IF G009 THEN K004\", \"step\": 7, \"gejala_kode\": \"G009\", \"gejala_nama\": \"Suara kipas berisik\", \"kerusakan_kode\": \"K004\", \"kerusakan_nama\": \"Overheating\"}, {\"id\": 11, \"rule\": \"IF G008 THEN K005\", \"step\": 8, \"gejala_kode\": \"G008\", \"gejala_nama\": \"Ada garis-garis pada layar\", \"kerusakan_kode\": \"K005\", \"kerusakan_nama\": \"Display Issue\"}, {\"id\": 13, \"rule\": \"IF G003 THEN K006\", \"step\": 9, \"gejala_kode\": \"G003\", \"gejala_nama\": \"Blue Screen (BSOD)\", \"kerusakan_kode\": \"K006\", \"kerusakan_nama\": \"crash atau hang\"}], \"semua_kemungkinan\": [{\"kerusakan\": {\"id\": 1, \"solusi\": \"Ganti komponen yang rusak, bawa ke service center, cek kabel internal\", \"is_final\": 1, \"kategori\": \"hardware\", \"deskripsi\": \"Kerusakan pada komponen hardware laptop seperti motherboard, RAM, atau processor\", \"created_at\": \"2025-11-18T07:14:23.000000Z\", \"updated_at\": \"2025-11-20T03:45:24.000000Z\", \"kode_kerusakan\": \"K001\", \"nama_kerusakan\": \"Hardware Failure\", \"tingkat_kerusakan\": \"sedang\"}, \"total_rules\": 2, \"gejala_terkait\": [1, 2]}, {\"kerusakan\": {\"id\": 3, \"solusi\": \"Ganti baterai, kalibrasi baterai, cek charger\", \"is_final\": 1, \"kategori\": \"battery\", \"deskripsi\": \"Masalah pada baterai laptop\", \"created_at\": \"2025-11-18T07:14:23.000000Z\", \"updated_at\": \"2025-11-18T07:14:23.000000Z\", \"kode_kerusakan\": \"K003\", \"nama_kerusakan\": \"Battery Problem\", \"tingkat_kerusakan\": \"sedang\"}, \"total_rules\": 1, \"gejala_terkait\": [5]}, {\"kerusakan\": {\"id\": 4, \"solusi\": \"Bersihkan kipas, ganti thermal paste, gunakan cooling pad\", \"is_final\": 1, \"kategori\": \"hardware\", \"deskripsi\": \"Laptop terlalu panas\", \"created_at\": \"2025-11-18T07:14:23.000000Z\", \"updated_at\": \"2025-11-18T07:14:23.000000Z\", \"kode_kerusakan\": \"K004\", \"nama_kerusakan\": \"Overheating\", \"tingkat_kerusakan\": \"sedang\"}, \"total_rules\": 2, \"gejala_terkait\": [6, 9]}, {\"kerusakan\": {\"id\": 5, \"solusi\": \"Cek kabel LCD, ganti layar, update driver grafis\", \"is_final\": 1, \"kategori\": \"display\", \"deskripsi\": \"Masalah pada layar laptop\", \"created_at\": \"2025-11-18T07:14:23.000000Z\", \"updated_at\": \"2025-11-18T07:14:23.000000Z\", \"kode_kerusakan\": \"K005\", \"nama_kerusakan\": \"Display Issue\", \"tingkat_kerusakan\": \"sedang\"}, \"total_rules\": 2, \"gejala_terkait\": [7, 8]}, {\"kerusakan\": {\"id\": 6, \"solusi\": \"perbarui  sistem dan driver, pindai malware, bersihkan file, periksa suhu.\", \"is_final\": 1, \"kategori\": \"software\", \"deskripsi\": \"aplikasi tiba-tiba berhenti berfungsi, menutup sendiri, atau seluruh perangkat hang\", \"created_at\": \"2025-11-21T03:33:56.000000Z\", \"updated_at\": \"2025-11-21T03:33:56.000000Z\", \"kode_kerusakan\": \"K006\", \"nama_kerusakan\": \"crash atau hang\", \"tingkat_kerusakan\": \"sedang\"}, \"total_rules\": 2, \"gejala_terkait\": [4, 3]}], \"total_rules_tertrigger\": 9}', '2025-11-22 06:44:44', '2025-11-22 06:44:44'),
(13, 'User', 'user@diagnosa.com', 2, '[\"1\", \"4\"]', '[\"1\", \"4\"]', '[{\"id\": 1, \"rule\": \"IF G001 THEN K001\", \"step\": 1, \"gejala_kode\": \"G001\", \"gejala_nama\": \"Laptop tidak bisa menyala\", \"kerusakan_kode\": \"K001\", \"kerusakan_nama\": \"Hardware Failure\"}, {\"id\": 12, \"rule\": \"IF G004 THEN K006\", \"step\": 2, \"gejala_kode\": \"G004\", \"gejala_nama\": \"Laptop lambat dan sering hang\", \"kerusakan_kode\": \"K006\", \"kerusakan_nama\": \"crash atau hang\"}]', 'Hardware Failure', 3, '{\"total_langkah\": 3, \"fakta_terbukti\": [\"1\", \"4\"], \"kesimpulan_akhir\": {\"kerusakan\": {\"id\": 1, \"solusi\": \"Ganti komponen yang rusak, bawa ke service center, cek kabel internal\", \"is_final\": 1, \"kategori\": \"hardware\", \"deskripsi\": \"Kerusakan pada komponen hardware laptop seperti motherboard, RAM, atau processor\", \"created_at\": \"2025-11-18T07:14:23.000000Z\", \"updated_at\": \"2025-11-20T03:45:24.000000Z\", \"kode_kerusakan\": \"K001\", \"nama_kerusakan\": \"Hardware Failure\", \"tingkat_kerusakan\": \"sedang\"}, \"confidence\": 50, \"total_rules\": 1, \"gejala_terkait\": [1]}, \"langkah_diagnosa\": [{\"step\": 1, \"action\": \"Memulai diagnosa dengan gejala: Laptop tidak bisa menyala, Laptop lambat dan sering hang\", \"conclusions\": [], \"working_memory\": [\"1\", \"4\"]}, {\"step\": 1, \"action\": \"Rule triggered: IF Laptop tidak bisa menyala THEN Hardware Failure\", \"conclusions\": [1], \"working_memory\": [\"1\", \"4\"]}, {\"step\": 2, \"action\": \"Rule triggered: IF Laptop lambat dan sering hang THEN crash atau hang\", \"conclusions\": [1, 6], \"working_memory\": [\"1\", \"4\"]}], \"rules_tertrigger\": [{\"id\": 1, \"rule\": \"IF G001 THEN K001\", \"step\": 1, \"gejala_kode\": \"G001\", \"gejala_nama\": \"Laptop tidak bisa menyala\", \"kerusakan_kode\": \"K001\", \"kerusakan_nama\": \"Hardware Failure\"}, {\"id\": 12, \"rule\": \"IF G004 THEN K006\", \"step\": 2, \"gejala_kode\": \"G004\", \"gejala_nama\": \"Laptop lambat dan sering hang\", \"kerusakan_kode\": \"K006\", \"kerusakan_nama\": \"crash atau hang\"}], \"semua_kemungkinan\": [{\"kerusakan\": {\"id\": 1, \"solusi\": \"Ganti komponen yang rusak, bawa ke service center, cek kabel internal\", \"is_final\": 1, \"kategori\": \"hardware\", \"deskripsi\": \"Kerusakan pada komponen hardware laptop seperti motherboard, RAM, atau processor\", \"created_at\": \"2025-11-18T07:14:23.000000Z\", \"updated_at\": \"2025-11-20T03:45:24.000000Z\", \"kode_kerusakan\": \"K001\", \"nama_kerusakan\": \"Hardware Failure\", \"tingkat_kerusakan\": \"sedang\"}, \"total_rules\": 1, \"gejala_terkait\": [1]}, {\"kerusakan\": {\"id\": 6, \"solusi\": \"perbarui  sistem dan driver, pindai malware, bersihkan file, periksa suhu.\", \"is_final\": 1, \"kategori\": \"software\", \"deskripsi\": \"aplikasi tiba-tiba berhenti berfungsi, menutup sendiri, atau seluruh perangkat hang\", \"created_at\": \"2025-11-21T03:33:56.000000Z\", \"updated_at\": \"2025-11-21T03:33:56.000000Z\", \"kode_kerusakan\": \"K006\", \"nama_kerusakan\": \"crash atau hang\", \"tingkat_kerusakan\": \"sedang\"}, \"total_rules\": 1, \"gejala_terkait\": [4]}], \"total_rules_tertrigger\": 2}', '2025-11-22 06:49:45', '2025-11-22 06:49:45'),
(14, 'yunitanime', 'yunitanime@gmail.com', 3, '[\"1\", \"9\", \"4\", \"10\"]', '[\"1\", \"9\", \"4\", \"10\"]', '[{\"id\": 1, \"rule\": \"IF G001 THEN K001\", \"step\": 1, \"gejala_kode\": \"G001\", \"gejala_nama\": \"Laptop tidak bisa menyala\", \"kerusakan_kode\": \"K001\", \"kerusakan_nama\": \"Hardware Failure\"}, {\"id\": 12, \"rule\": \"IF G004 THEN K006\", \"step\": 2, \"gejala_kode\": \"G004\", \"gejala_nama\": \"Laptop lambat dan sering hang\", \"kerusakan_kode\": \"K006\", \"kerusakan_nama\": \"crash atau hang\"}, {\"id\": 9, \"rule\": \"IF G009 THEN K004\", \"step\": 3, \"gejala_kode\": \"G009\", \"gejala_nama\": \"Suara kipas berisik\", \"kerusakan_kode\": \"K004\", \"kerusakan_nama\": \"Overheating\"}]', 'Hardware Failure', 4, '{\"total_langkah\": 4, \"fakta_terbukti\": [\"1\", \"9\", \"4\", \"10\"], \"kesimpulan_akhir\": {\"kerusakan\": {\"id\": 1, \"solusi\": \"Ganti komponen yang rusak, bawa ke service center, cek kabel internal\", \"is_final\": 1, \"kategori\": \"hardware\", \"deskripsi\": \"Kerusakan pada komponen hardware laptop seperti motherboard, RAM, atau processor\", \"created_at\": \"2025-11-18T07:14:23.000000Z\", \"updated_at\": \"2025-11-20T03:45:24.000000Z\", \"kode_kerusakan\": \"K001\", \"nama_kerusakan\": \"Hardware Failure\", \"tingkat_kerusakan\": \"sedang\"}, \"confidence\": 50, \"total_rules\": 1, \"gejala_terkait\": [1]}, \"langkah_diagnosa\": [{\"step\": 1, \"action\": \"Memulai diagnosa dengan gejala: Laptop tidak bisa menyala, Laptop lambat dan sering hang, Suara kipas berisik, Baterai cepat habis\", \"conclusions\": [], \"working_memory\": [\"1\", \"9\", \"4\", \"10\"]}, {\"step\": 1, \"action\": \"Rule triggered: IF Laptop tidak bisa menyala THEN Hardware Failure\", \"conclusions\": [1], \"working_memory\": [\"1\", \"9\", \"4\", \"10\"]}, {\"step\": 2, \"action\": \"Rule triggered: IF Laptop lambat dan sering hang THEN crash atau hang\", \"conclusions\": [1, 6], \"working_memory\": [\"1\", \"9\", \"4\", \"10\"]}, {\"step\": 3, \"action\": \"Rule triggered: IF Suara kipas berisik THEN Overheating\", \"conclusions\": [1, 6, 4], \"working_memory\": [\"1\", \"9\", \"4\", \"10\"]}], \"rules_tertrigger\": [{\"id\": 1, \"rule\": \"IF G001 THEN K001\", \"step\": 1, \"gejala_kode\": \"G001\", \"gejala_nama\": \"Laptop tidak bisa menyala\", \"kerusakan_kode\": \"K001\", \"kerusakan_nama\": \"Hardware Failure\"}, {\"id\": 12, \"rule\": \"IF G004 THEN K006\", \"step\": 2, \"gejala_kode\": \"G004\", \"gejala_nama\": \"Laptop lambat dan sering hang\", \"kerusakan_kode\": \"K006\", \"kerusakan_nama\": \"crash atau hang\"}, {\"id\": 9, \"rule\": \"IF G009 THEN K004\", \"step\": 3, \"gejala_kode\": \"G009\", \"gejala_nama\": \"Suara kipas berisik\", \"kerusakan_kode\": \"K004\", \"kerusakan_nama\": \"Overheating\"}], \"semua_kemungkinan\": [{\"kerusakan\": {\"id\": 1, \"solusi\": \"Ganti komponen yang rusak, bawa ke service center, cek kabel internal\", \"is_final\": 1, \"kategori\": \"hardware\", \"deskripsi\": \"Kerusakan pada komponen hardware laptop seperti motherboard, RAM, atau processor\", \"created_at\": \"2025-11-18T07:14:23.000000Z\", \"updated_at\": \"2025-11-20T03:45:24.000000Z\", \"kode_kerusakan\": \"K001\", \"nama_kerusakan\": \"Hardware Failure\", \"tingkat_kerusakan\": \"sedang\"}, \"total_rules\": 1, \"gejala_terkait\": [1]}, {\"kerusakan\": {\"id\": 6, \"solusi\": \"perbarui  sistem dan driver, pindai malware, bersihkan file, periksa suhu.\", \"is_final\": 1, \"kategori\": \"software\", \"deskripsi\": \"aplikasi tiba-tiba berhenti berfungsi, menutup sendiri, atau seluruh perangkat hang\", \"created_at\": \"2025-11-21T03:33:56.000000Z\", \"updated_at\": \"2025-11-21T03:33:56.000000Z\", \"kode_kerusakan\": \"K006\", \"nama_kerusakan\": \"crash atau hang\", \"tingkat_kerusakan\": \"sedang\"}, \"total_rules\": 1, \"gejala_terkait\": [4]}, {\"kerusakan\": {\"id\": 4, \"solusi\": \"Bersihkan kipas, ganti thermal paste, gunakan cooling pad\", \"is_final\": 1, \"kategori\": \"hardware\", \"deskripsi\": \"Laptop terlalu panas\", \"created_at\": \"2025-11-18T07:14:23.000000Z\", \"updated_at\": \"2025-11-18T07:14:23.000000Z\", \"kode_kerusakan\": \"K004\", \"nama_kerusakan\": \"Overheating\", \"tingkat_kerusakan\": \"sedang\"}, \"total_rules\": 1, \"gejala_terkait\": [9]}], \"total_rules_tertrigger\": 3}', '2025-11-22 07:00:39', '2025-11-22 07:00:39'),
(15, 'Admin', 'admin@diagnosa.com', 1, '[\"1\", \"9\", \"10\"]', '[\"1\", \"9\", \"10\"]', '[{\"id\": 1, \"rule\": \"IF G001 THEN K001\", \"step\": 1, \"gejala_kode\": \"G001\", \"gejala_nama\": \"Laptop tidak bisa menyala\", \"kerusakan_kode\": \"K001\", \"kerusakan_nama\": \"Hardware Failure\"}, {\"id\": 9, \"rule\": \"IF G009 THEN K004\", \"step\": 2, \"gejala_kode\": \"G009\", \"gejala_nama\": \"Suara kipas berisik\", \"kerusakan_kode\": \"K004\", \"kerusakan_nama\": \"Overheating\"}]', 'Hardware Failure', 3, '{\"total_langkah\": 3, \"fakta_terbukti\": [\"1\", \"9\", \"10\"], \"kesimpulan_akhir\": {\"kerusakan\": {\"id\": 1, \"solusi\": \"Ganti komponen yang rusak, bawa ke service center, cek kabel internal\", \"is_final\": 1, \"kategori\": \"hardware\", \"deskripsi\": \"Kerusakan pada komponen hardware laptop seperti motherboard, RAM, atau processor\", \"created_at\": \"2025-11-18T07:14:23.000000Z\", \"updated_at\": \"2025-11-20T03:45:24.000000Z\", \"kode_kerusakan\": \"K001\", \"nama_kerusakan\": \"Hardware Failure\", \"tingkat_kerusakan\": \"sedang\"}, \"confidence\": 50, \"total_rules\": 1, \"gejala_terkait\": [1]}, \"langkah_diagnosa\": [{\"step\": 1, \"action\": \"Memulai diagnosa dengan gejala: Laptop tidak bisa menyala, Suara kipas berisik, Baterai cepat habis\", \"conclusions\": [], \"working_memory\": [\"1\", \"9\", \"10\"]}, {\"step\": 1, \"action\": \"Rule triggered: IF Laptop tidak bisa menyala THEN Hardware Failure\", \"conclusions\": [1], \"working_memory\": [\"1\", \"9\", \"10\"]}, {\"step\": 2, \"action\": \"Rule triggered: IF Suara kipas berisik THEN Overheating\", \"conclusions\": [1, 4], \"working_memory\": [\"1\", \"9\", \"10\"]}], \"rules_tertrigger\": [{\"id\": 1, \"rule\": \"IF G001 THEN K001\", \"step\": 1, \"gejala_kode\": \"G001\", \"gejala_nama\": \"Laptop tidak bisa menyala\", \"kerusakan_kode\": \"K001\", \"kerusakan_nama\": \"Hardware Failure\"}, {\"id\": 9, \"rule\": \"IF G009 THEN K004\", \"step\": 2, \"gejala_kode\": \"G009\", \"gejala_nama\": \"Suara kipas berisik\", \"kerusakan_kode\": \"K004\", \"kerusakan_nama\": \"Overheating\"}], \"semua_kemungkinan\": [{\"kerusakan\": {\"id\": 1, \"solusi\": \"Ganti komponen yang rusak, bawa ke service center, cek kabel internal\", \"is_final\": 1, \"kategori\": \"hardware\", \"deskripsi\": \"Kerusakan pada komponen hardware laptop seperti motherboard, RAM, atau processor\", \"created_at\": \"2025-11-18T07:14:23.000000Z\", \"updated_at\": \"2025-11-20T03:45:24.000000Z\", \"kode_kerusakan\": \"K001\", \"nama_kerusakan\": \"Hardware Failure\", \"tingkat_kerusakan\": \"sedang\"}, \"total_rules\": 1, \"gejala_terkait\": [1]}, {\"kerusakan\": {\"id\": 4, \"solusi\": \"Bersihkan kipas, ganti thermal paste, gunakan cooling pad\", \"is_final\": 1, \"kategori\": \"hardware\", \"deskripsi\": \"Laptop terlalu panas\", \"created_at\": \"2025-11-18T07:14:23.000000Z\", \"updated_at\": \"2025-11-18T07:14:23.000000Z\", \"kode_kerusakan\": \"K004\", \"nama_kerusakan\": \"Overheating\", \"tingkat_kerusakan\": \"sedang\"}, \"total_rules\": 1, \"gejala_terkait\": [9]}], \"total_rules_tertrigger\": 2}', '2025-11-22 08:13:49', '2025-11-22 08:13:49'),
(16, 'yunitanime', 'yunitanime@gmail.com', 3, '[\"1\", \"3\", \"4\", \"5\"]', '[\"1\", \"3\", \"4\", \"5\"]', '[{\"id\": 6, \"rule\": \"IF G005 THEN K003\", \"step\": 1, \"gejala_kode\": \"G005\", \"gejala_nama\": \"Baterai tidak bisa dicharge\", \"kerusakan_kode\": \"K003\", \"kerusakan_nama\": \"Battery Problem\"}, {\"id\": 12, \"rule\": \"IF G004 THEN K006\", \"step\": 2, \"gejala_kode\": \"G004\", \"gejala_nama\": \"Laptop lambat dan sering hang\", \"kerusakan_kode\": \"K006\", \"kerusakan_nama\": \"crash atau hang\"}, {\"id\": 13, \"rule\": \"IF G003 THEN K006\", \"step\": 3, \"gejala_kode\": \"G003\", \"gejala_nama\": \"Blue Screen (BSOD)\", \"kerusakan_kode\": \"K006\", \"kerusakan_nama\": \"crash atau hang\"}]', 'crash atau hang', 4, '{\"total_langkah\": 4, \"fakta_terbukti\": [\"1\", \"3\", \"4\", \"5\"], \"kesimpulan_akhir\": {\"kerusakan\": {\"id\": 6, \"solusi\": \"perbarui  sistem dan driver, pindai malware, bersihkan file, periksa suhu.\", \"is_final\": 1, \"kategori\": \"software\", \"deskripsi\": \"aplikasi tiba-tiba berhenti berfungsi, menutup sendiri, atau seluruh perangkat hang\", \"created_at\": \"2025-11-21T03:33:56.000000Z\", \"updated_at\": \"2025-11-21T03:33:56.000000Z\", \"kode_kerusakan\": \"K006\", \"nama_kerusakan\": \"crash atau hang\", \"tingkat_kerusakan\": \"sedang\"}, \"confidence\": 100, \"total_rules\": 2, \"gejala_terkait\": [4, 3]}, \"langkah_diagnosa\": [{\"step\": 1, \"action\": \"Memulai diagnosa dengan gejala: Laptop tidak bisa menyala, Blue Screen (BSOD), Laptop lambat dan sering hang, Baterai tidak bisa dicharge\", \"conclusions\": [], \"working_memory\": [\"1\", \"3\", \"4\", \"5\"]}, {\"step\": 1, \"action\": \"Rule triggered: IF Baterai tidak bisa dicharge THEN Battery Problem\", \"conclusions\": [3], \"working_memory\": [\"1\", \"3\", \"4\", \"5\"]}, {\"step\": 2, \"action\": \"Rule triggered: IF Laptop lambat dan sering hang THEN crash atau hang\", \"conclusions\": [3, 6], \"working_memory\": [\"1\", \"3\", \"4\", \"5\"]}, {\"step\": 3, \"action\": \"Rule triggered: IF Blue Screen (BSOD) THEN crash atau hang\", \"conclusions\": [3, 6], \"working_memory\": [\"1\", \"3\", \"4\", \"5\"]}], \"rules_tertrigger\": [{\"id\": 6, \"rule\": \"IF G005 THEN K003\", \"step\": 1, \"gejala_kode\": \"G005\", \"gejala_nama\": \"Baterai tidak bisa dicharge\", \"kerusakan_kode\": \"K003\", \"kerusakan_nama\": \"Battery Problem\"}, {\"id\": 12, \"rule\": \"IF G004 THEN K006\", \"step\": 2, \"gejala_kode\": \"G004\", \"gejala_nama\": \"Laptop lambat dan sering hang\", \"kerusakan_kode\": \"K006\", \"kerusakan_nama\": \"crash atau hang\"}, {\"id\": 13, \"rule\": \"IF G003 THEN K006\", \"step\": 3, \"gejala_kode\": \"G003\", \"gejala_nama\": \"Blue Screen (BSOD)\", \"kerusakan_kode\": \"K006\", \"kerusakan_nama\": \"crash atau hang\"}], \"semua_kemungkinan\": [{\"kerusakan\": {\"id\": 3, \"solusi\": \"Ganti baterai, kalibrasi baterai, cek charger\", \"is_final\": 1, \"kategori\": \"battery\", \"deskripsi\": \"Masalah pada baterai laptop\", \"created_at\": \"2025-11-18T07:14:23.000000Z\", \"updated_at\": \"2025-11-18T07:14:23.000000Z\", \"kode_kerusakan\": \"K003\", \"nama_kerusakan\": \"Battery Problem\", \"tingkat_kerusakan\": \"sedang\"}, \"total_rules\": 1, \"gejala_terkait\": [5]}, {\"kerusakan\": {\"id\": 6, \"solusi\": \"perbarui  sistem dan driver, pindai malware, bersihkan file, periksa suhu.\", \"is_final\": 1, \"kategori\": \"software\", \"deskripsi\": \"aplikasi tiba-tiba berhenti berfungsi, menutup sendiri, atau seluruh perangkat hang\", \"created_at\": \"2025-11-21T03:33:56.000000Z\", \"updated_at\": \"2025-11-21T03:33:56.000000Z\", \"kode_kerusakan\": \"K006\", \"nama_kerusakan\": \"crash atau hang\", \"tingkat_kerusakan\": \"sedang\"}, \"total_rules\": 2, \"gejala_terkait\": [4, 3]}], \"total_rules_tertrigger\": 3}', '2025-11-22 08:25:20', '2025-11-22 08:25:20');

-- --------------------------------------------------------

--
-- Table structure for table `kerusakan`
--

CREATE TABLE `kerusakan` (
  `id` bigint UNSIGNED NOT NULL,
  `kode_kerusakan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_kerusakan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `solusi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori` enum('hardware','software','battery','display') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tingkat_kerusakan` enum('ringan','sedang','berat') COLLATE utf8mb4_unicode_ci DEFAULT 'sedang',
  `is_final` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kerusakan`
--

INSERT INTO `kerusakan` (`id`, `kode_kerusakan`, `nama_kerusakan`, `deskripsi`, `solusi`, `kategori`, `tingkat_kerusakan`, `is_final`, `created_at`, `updated_at`) VALUES
(1, 'K001', 'Hardware Failure', 'Kerusakan pada komponen hardware laptop seperti motherboard, RAM, atau processor', 'Ganti komponen yang rusak, bawa ke service center, cek kabel internal', 'hardware', 'sedang', 1, '2025-11-17 23:14:23', '2025-11-19 19:45:24'),
(2, 'K002', 'Software Corruption', 'Kerusakan sistem operasi atau software', 'Install ulang sistem operasi, update driver', 'software', 'sedang', 1, '2025-11-17 23:14:23', '2025-11-17 23:14:23'),
(3, 'K003', 'Battery Problem', 'Masalah pada baterai laptop', 'Ganti baterai, kalibrasi baterai, cek charger', 'battery', 'sedang', 1, '2025-11-17 23:14:23', '2025-11-17 23:14:23'),
(4, 'K004', 'Overheating', 'Laptop terlalu panas', 'Bersihkan kipas, ganti thermal paste, gunakan cooling pad', 'hardware', 'sedang', 1, '2025-11-17 23:14:23', '2025-11-17 23:14:23'),
(5, 'K005', 'Display Issue', 'Masalah pada layar laptop', 'Cek kabel LCD, ganti layar, update driver grafis', 'display', 'sedang', 1, '2025-11-17 23:14:23', '2025-11-17 23:14:23'),
(6, 'K006', 'crash atau hang', 'aplikasi tiba-tiba berhenti berfungsi, menutup sendiri, atau seluruh perangkat hang', 'perbarui  sistem dan driver, pindai malware, bersihkan file, periksa suhu.', 'software', 'sedang', 1, '2025-11-20 19:33:56', '2025-11-20 19:33:56');

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
(10, '2025_11_18_063041_add_role_to_users_table', 1),
(11, '2025_11_20_162954_fix_histories_table_structure', 2),
(12, '2025_11_20_163654_add_user_id_to_histories_table', 3),
(13, '2025_11_22_130414_update_tables_for_forward_chaining', 4);

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
(1, 'Admin', 'admin@diagnosa.com', NULL, '$2y$12$dBthcvBCDjrhSqu.mqM7O.iG7Bx.UA7IbXHU75RzFlvVfJpMuPLkS', 'dxu2ONbwgOrRZZGWsfy0Lr7uTQcfJRUXrHJwRwGJU0nzHAIMCFdMsKDqmvKy', '2025-11-17 23:14:23', '2025-11-17 23:14:23', 'admin'),
(2, 'User', 'user@diagnosa.com', NULL, '$2y$12$EBlDhni0634DvvzlUXkH4OzlRjoqYXOC7OT3940UD8BzL2LJ7KHCe', 'lNcUzNVIQznZRXi2V8yDywbiMuK7KoZcjnMG15b6wXIyyAgPegyOLPoRYsyk', '2025-11-17 23:14:23', '2025-11-20 19:12:06', 'user'),
(3, 'yunitanime', 'yunitanime@gmail.com', NULL, '$2y$12$FIMcKKFj2AJl0BtxaRd8GOBo7JiFrL/POyBWELbcEN6n7zw3hkLZq', 'PFdeuGrRzika3JekXR6uJ7dN1olJL4WvuJ1IYZUDDQEKnOUhFJx1xERTkSLV', '2025-11-22 06:59:04', '2025-11-22 06:59:04', 'user'),
(4, 'pemweb', 'pemweb@gmail.com', NULL, '$2y$12$BKbNBu6rtuWZWU5SjHYC1eHvFJK/aOkH6MykqXwG5vOtDKLuLltbm', 'hWL1Cz9rLSMtuXCW1PgW9c7OPPHN5H1Lcdv9Obi3Yca4SVmo2ZtW5aPb98me', '2025-11-29 21:34:23', '2025-11-29 21:34:23', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `basis_pengetahuan`
--
ALTER TABLE `basis_pengetahuan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kerusakan_id` (`kerusakan_id`),
  ADD KEY `gejala_id` (`gejala_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `gejala`
--
ALTER TABLE `gejala`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `gejalas_kode_gejala_unique` (`kode_gejala`);

--
-- Indexes for table `histories`
--
ALTER TABLE `histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `histories_user_id_foreign` (`user_id`);

--
-- Indexes for table `kerusakan`
--
ALTER TABLE `kerusakan`
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
-- AUTO_INCREMENT for table `basis_pengetahuan`
--
ALTER TABLE `basis_pengetahuan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gejala`
--
ALTER TABLE `gejala`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `histories`
--
ALTER TABLE `histories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `kerusakan`
--
ALTER TABLE `kerusakan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `basis_pengetahuan`
--
ALTER TABLE `basis_pengetahuan`
  ADD CONSTRAINT `basis_pengetahuan_ibfk_1` FOREIGN KEY (`kerusakan_id`) REFERENCES `kerusakan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `basis_pengetahuan_ibfk_2` FOREIGN KEY (`gejala_id`) REFERENCES `gejala` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `histories`
--
ALTER TABLE `histories`
  ADD CONSTRAINT `histories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
