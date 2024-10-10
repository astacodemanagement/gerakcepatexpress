-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table db_gce.cabang
CREATE TABLE IF NOT EXISTS `cabang` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kode_cabang` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_cabang` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_kota` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_kota` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat_cabang` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_closing` datetime DEFAULT NULL,
  `kasir` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_gce.cabang: ~4 rows (approximately)
INSERT INTO `cabang` (`id`, `kode_cabang`, `nama_cabang`, `id_kota`, `nama_kota`, `alamat_cabang`, `status`, `tanggal_closing`, `kasir`, `created_at`, `updated_at`) VALUES
	(1, 'C001', 'Tasikmalaya', '7', 'Tasikmalaya', 'Jl. Tajur Indah No 121 Indihiang', NULL, NULL, 'Adi Rizki Yudita', '2023-11-21 09:43:51', '2024-02-02 06:24:30'),
	(9, 'C003', 'Surabaya Raya', '8', 'Surabaya', 'Jl. Suramadu', NULL, NULL, NULL, '2023-12-13 01:26:12', '2023-12-22 11:51:38'),
	(10, 'C002', 'Bandung', '9', 'Bandung', 'Jl. Kaum', NULL, NULL, NULL, '2023-12-13 01:26:32', '2024-01-13 16:16:33');

-- Dumping structure for table db_gce.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_gce.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table db_gce.invoice
CREATE TABLE IF NOT EXISTS `invoice` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cabang_id` varchar(50) CHARACTER SET armscii8 COLLATE armscii8_bin DEFAULT NULL,
  `tanggal_invoice` date DEFAULT NULL,
  `no_invoice` varchar(50) CHARACTER SET armscii8 COLLATE armscii8_bin NOT NULL,
  `status_invoice` varchar(50) CHARACTER SET armscii8 COLLATE armscii8_bin DEFAULT NULL,
  `bill_to_id` varchar(50) COLLATE armscii8_bin DEFAULT NULL,
  `bill_to` varchar(50) COLLATE armscii8_bin DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin;

-- Dumping data for table db_gce.invoice: ~0 rows (approximately)
INSERT INTO `invoice` (`id`, `cabang_id`, `tanggal_invoice`, `no_invoice`, `status_invoice`, `bill_to_id`, `bill_to`, `created_at`, `updated_at`) VALUES
	(26, '1', '2024-01-29', 'INV-C001-000001', 'Telah Dibuat', '17', 'Feny Cahyani', '2024-01-29 07:55:06', '2024-01-29 07:55:06');

-- Dumping structure for table db_gce.konsumen
CREATE TABLE IF NOT EXISTS `konsumen` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `cabang_id` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_cad` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_kontrak` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jatuh_tempo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_konsumen` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_perusahaan` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_telp` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_gce.konsumen: ~7 rows (approximately)
INSERT INTO `konsumen` (`id`, `cabang_id`, `status_cad`, `no_kontrak`, `jatuh_tempo`, `nama_konsumen`, `nama_perusahaan`, `no_telp`, `email`, `alamat`, `created_at`, `updated_at`) VALUES
	(16, '9', 'CAD', '12345678', '30', 'Rahman Hidayat', 'Makaroni 2 Saudara', '0853205553949', 'rahmat@gmail.com', 'Jl. Tajur Indah', '2024-01-13 16:26:56', '2024-03-20 20:19:08'),
	(17, '9', 'CAD', '1232423434', '12', 'Feny Cahyani', 'Gas LPG 2 Saudara', '085320555394', 'feny@gmail.com', 'Jl. Tajur Indah', '2024-01-13 16:27:17', '2024-03-20 16:33:30'),
	(18, '9', 'Non CAD', NULL, NULL, 'Setiadi', 'Makaroni 2 Saudara', '0853205553949', 'setiadi@gmail.com', 'Jl. Tajur Indah', '2024-01-14 04:43:24', '2024-01-14 04:43:24'),
	(19, '9', 'Non CAD', NULL, NULL, 'Rudi', 'Makaroni 2 Saudara', '0853205553949', 'rudi@gmail.com', 'Jl. Tajur Indah', '2024-01-14 04:43:40', '2024-01-14 04:43:40'),
	(21, '1', 'Non CAD', NULL, NULL, 'Tedi Sugandi', 'Kerupuk Garing', '085546545556', '1@a.com', 'hjh', '2024-01-14 06:45:13', '2024-03-25 06:31:40'),
	(22, '1', 'Non CAD', NULL, NULL, 'Asef', 'Dedengan Gurih', '085320555394', 'koperasisatu@gmail.com', 'Perumahan CGM Sukarindik Kecamatan Bungursari. Blok C31. RT/RW 02/11. Kota Tasikmalaya\r\nJl. Tajur Indah', '2024-03-01 12:17:16', '2024-03-01 12:17:16'),
	(25, '1', 'Non CAD', NULL, NULL, 'aa', 'aa', '085320555396', 'admin@gmail.com', 'aaa', '2024-03-19 09:23:33', '2024-03-19 09:23:33'),
	(26, '1', 'CAD', '123456782', '12', 'Gibran', 'Dedengan Gurih', '087575464354', 'koperasidua@gmail.com', 'Perumahan CGM Sukarindik Kecamatan Bungursari. Blok C31. RT/RW 02/11. Kota Tasikmalaya\r\nJl. Tajur Indah', '2024-03-20 16:16:37', '2024-03-25 06:31:31');

-- Dumping structure for table db_gce.kota
CREATE TABLE IF NOT EXISTS `kota` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kode_kota` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_kota` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_gce.kota: ~4 rows (approximately)
INSERT INTO `kota` (`id`, `kode_kota`, `nama_kota`, `created_at`, `updated_at`) VALUES
	(7, 'TSM', 'Tasikmalaya', '2023-12-13 01:23:09', '2023-12-13 01:23:09'),
	(8, 'SBY', 'Surabaya', '2023-12-13 01:23:19', '2023-12-13 01:23:19'),
	(9, 'BDG', 'Bandung', '2023-12-13 01:23:30', '2023-12-13 01:23:30'),
	(12, 'YGY', 'Yogyakarta', '2023-12-18 21:48:29', '2023-12-18 21:48:29');

-- Dumping structure for table db_gce.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_gce.migrations: ~13 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_resets_table', 1),
	(3, '2019_08_19_000000_create_failed_jobs_table', 1),
	(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(5, '2023_11_19_224528_create_profil_table', 1),
	(6, '2023_11_20_140156_create_konsumen_table', 2),
	(7, '2023_11_21_123211_create_kota_table', 3),
	(8, '2023_11_21_130109_create_cabang_table', 4),
	(9, '2023_11_21_165232_create_booking_table', 5),
	(12, '2023_11_21_230259_create_pengeluaran_table', 6),
	(13, '2023_11_21_225147_create_transaksi_table', 7),
	(14, '2023_11_29_011646_create_permission_tables', 8),
	(15, '2023_11_30_064826_create_tambah_penerima_pengambilan_table', 9),
	(16, '2024_03_01_140151_add_link_to_profil_table', 10),
	(17, '2024_03_20_094136_add_no_kontrak_to_konsumen_table', 11),
	(18, '2024_03_20_230913_add_jatuh_tempo_to_konsumen_table', 12);

-- Dumping structure for table db_gce.model_has_permissions
CREATE TABLE IF NOT EXISTS `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_gce.model_has_permissions: ~0 rows (approximately)

-- Dumping structure for table db_gce.model_has_roles
CREATE TABLE IF NOT EXISTS `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_gce.model_has_roles: ~18 rows (approximately)
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
	(1, 'App\\Models\\User', 1),
	(5, 'App\\Models\\User', 2),
	(3, 'App\\Models\\User', 3),
	(4, 'App\\Models\\User', 4),
	(3, 'App\\Models\\User', 5),
	(4, 'App\\Models\\User', 22),
	(3, 'App\\Models\\User', 23),
	(2, 'App\\Models\\User', 24),
	(5, 'App\\Models\\User', 25),
	(4, 'App\\Models\\User', 26),
	(3, 'App\\Models\\User', 27),
	(2, 'App\\Models\\User', 28),
	(4, 'App\\Models\\User', 29),
	(3, 'App\\Models\\User', 30),
	(2, 'App\\Models\\User', 31),
	(5, 'App\\Models\\User', 32),
	(3, 'App\\Models\\User', 33),
	(4, 'App\\Models\\User', 34),
	(3, 'App\\Models\\User', 35),
	(4, 'App\\Models\\User', 36),
	(3, 'App\\Models\\User', 37),
	(4, 'App\\Models\\User', 38),
	(2, 'App\\Models\\User', 39);

-- Dumping structure for table db_gce.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_gce.password_resets: ~0 rows (approximately)

-- Dumping structure for table db_gce.pengeluaran
CREATE TABLE IF NOT EXISTS `pengeluaran` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `cabang_id` bigint NOT NULL DEFAULT '0',
  `tanggal_pengeluaran` date NOT NULL,
  `kode_pengeluaran` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_pengeluaran` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah_pengeluaran` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pic` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bukti` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_gce.pengeluaran: ~1 rows (approximately)
INSERT INTO `pengeluaran` (`id`, `cabang_id`, `tanggal_pengeluaran`, `kode_pengeluaran`, `nama_pengeluaran`, `jumlah_pengeluaran`, `keterangan`, `pic`, `bukti`, `created_at`, `updated_at`) VALUES
	(10, 1, '2024-01-18', 'EXP0001', 'Proposal Karang Taruna', '50000', 'Agsutusan', 'Rudi', '1705429386.webp', '2024-01-16 18:23:06', '2024-01-16 18:23:06');

-- Dumping structure for table db_gce.permissions
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_gce.permissions: ~0 rows (approximately)

-- Dumping structure for table db_gce.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_gce.personal_access_tokens: ~0 rows (approximately)

-- Dumping structure for table db_gce.profil
CREATE TABLE IF NOT EXISTS `profil` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_profil` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alias` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_telp` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `no_rekening` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `atas_nama` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `biaya_admin` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `biaya_pembatalan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `gambar` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_gce.profil: ~1 rows (approximately)
INSERT INTO `profil` (`id`, `nama_profil`, `alias`, `no_telp`, `email`, `link`, `alamat`, `no_rekening`, `bank`, `atas_nama`, `biaya_admin`, `biaya_pembatalan`, `gambar`, `created_at`, `updated_at`) VALUES
	(9, 'Gerak Cepat Express', 'GCE', '085320555394', 'gce@example.com', 'gce.com', 'Jl. Tajur Indah No 121 Indihiang Tasikmalaya', '3224353444', 'BSI', 'Muhammad Rafi Heryadi', '100000', '100000', '1700472475.png', '2023-11-20 00:49:51', '2024-03-01 07:11:28');

-- Dumping structure for table db_gce.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_gce.roles: ~5 rows (approximately)
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
	(1, 'superadmin', 'web', '2023-11-29 23:17:00', '2023-11-29 23:17:00'),
	(2, 'manager', 'web', '2023-11-29 23:17:00', '2023-11-29 23:17:00'),
	(3, 'kasir', 'web', '2023-11-29 23:17:00', '2023-11-29 23:17:00'),
	(4, 'gudang', 'web', '2023-11-29 23:17:00', '2023-11-29 23:17:00'),
	(5, 'finance', 'web', '2023-12-23 08:02:44', '2023-12-23 08:02:45');

-- Dumping structure for table db_gce.role_has_permissions
CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_gce.role_has_permissions: ~0 rows (approximately)

-- Dumping structure for table db_gce.transaksi
CREATE TABLE IF NOT EXISTS `transaksi` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `cabang_id` bigint NOT NULL DEFAULT '0',
  `tanggal_booking` date NOT NULL,
  `tanggal_kirim` date DEFAULT NULL,
  `tanggal_terima` date DEFAULT NULL,
  `tanggal_bawa` date DEFAULT NULL,
  `tanggal_aju_pembatalan` date DEFAULT NULL,
  `tanggal_verifikasi_pembatalan` date DEFAULT NULL,
  `tanggal_ambil_pembatalan` date DEFAULT NULL,
  `kode_resi` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_barang` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `koli` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `berat` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `konsumen_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_konsumen` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `konsumen_penerima_id` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_konsumen_penerima` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bill_to` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_bill_to` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cabang_id_asal` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cabang_id_tujuan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `keterangan_kasir` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `total` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `harga_kirim` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sub_charge` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `biaya_admin` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_bayar` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_pembayaran` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `metode_pembayaran` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jumlah_bayar` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bukti_bayar` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_bayar` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_bawa` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_batal` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `biaya_pembatalan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan_batal` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `bukti_pembatalan` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kode_pembatalan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alasan_tolak` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `no_invoice` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pengambil` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gambar_pengambil` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_gce.transaksi: ~5 rows (approximately)
INSERT INTO `transaksi` (`id`, `cabang_id`, `tanggal_booking`, `tanggal_kirim`, `tanggal_terima`, `tanggal_bawa`, `tanggal_aju_pembatalan`, `tanggal_verifikasi_pembatalan`, `tanggal_ambil_pembatalan`, `kode_resi`, `nama_barang`, `koli`, `berat`, `konsumen_id`, `nama_konsumen`, `konsumen_penerima_id`, `nama_konsumen_penerima`, `bill_to`, `nama_bill_to`, `cabang_id_asal`, `cabang_id_tujuan`, `keterangan`, `keterangan_kasir`, `total`, `harga_kirim`, `sub_charge`, `biaya_admin`, `total_bayar`, `jenis_pembayaran`, `metode_pembayaran`, `jumlah_bayar`, `bukti_bayar`, `status_bayar`, `status_bawa`, `status_batal`, `biaya_pembatalan`, `keterangan_batal`, `bukti_pembatalan`, `kode_pembatalan`, `alasan_tolak`, `no_invoice`, `pengambil`, `gambar_pengambil`, `created_at`, `updated_at`) VALUES
	(14, 1, '2024-01-18', '2024-02-18', '2024-02-02', '2024-02-02', NULL, NULL, NULL, 'GCETSMC001000001', 'Sarung', '10', '5', '16', 'Rahman Hidayat', '17', 'Feny Cahyani', NULL, NULL, '1', '9', 'Gajah Duduk', 'JL. Letjen Mashudi', NULL, '30000', '10000', '100000', '140000', 'CASH', 'Tunai', '140000', NULL, 'Sudah Lunas', 'Sudah Dibawa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-01-18 09:07:26', '2024-01-18 09:09:52'),
	(15, 1, '2024-01-18', '2024-04-18', '2024-02-02', '2024-02-02', NULL, NULL, NULL, 'GCETSMC001000002', 'Gas LPG', '10', '30', '16', 'Rahman Hidayat', '17', 'Feny Cahyani', NULL, NULL, '1', '10', 'Subsidi', 'Tolong antarkan ke rumah, biaya tambahan nanti biar di bayar penerima', NULL, '50000', '10000', '100000', '160000', 'CASH', 'Tunai', '160000', NULL, 'Sudah Lunas', 'Sudah Dibawa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-01-18 09:07:45', '2024-01-18 09:10:57'),
	(16, 1, '2024-01-18', '2024-02-12', '2024-02-02', '2024-02-02', NULL, NULL, NULL, 'GCETSMC001000003', 'Motor', '5', '30', '16', 'Rahman Hidayat', '17', 'Feny Cahyani', NULL, NULL, '1', '10', 'Listrik', 'Tolong antarkan ke rumah, biaya tambahan nanti biar di bayar penerima', NULL, '70000', '10000', '100000', '180000', 'COD', NULL, '', NULL, 'Sudah Lunas', 'Sudah Dibawa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-01-18 09:08:06', '2024-01-18 09:11:52'),
	(17, 1, '2024-01-18', '2024-02-15', '2024-02-02', '2024-02-02', NULL, NULL, NULL, 'GCETSMC001000004', 'Sepeda', '8', '12', '16', 'Rahman Hidayat', '17', 'Feny Cahyani', NULL, NULL, '1', '10', 'Uwinfly', 'Tolong antarkan ke rumah, biaya tambahan nanti biar di bayar penerima', NULL, '90000', '10000', '100000', '200000', 'COD', NULL, '', NULL, 'Sudah Lunas', 'Sudah Dibawa', '1', '20000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-01-18 09:14:46', '2024-01-18 09:15:33'),
	(18, 1, '2024-01-29', '2024-05-29', '2024-01-29', '2024-01-29', NULL, NULL, NULL, 'GCETSMC001000005', '11111', '11', '11', '16', 'Rahman Hidayat', '17', 'Feny Cahyani', '17', 'Feny Cahyani', '1', '9', '111111', 'Dooring', NULL, '30000', '0', '100000', '130000', 'CAD', 'Tunai', '130000', NULL, 'Sudah Lunas', 'Sudah Dibawa', NULL, NULL, NULL, NULL, NULL, NULL, 'INV-C001-000001', NULL, NULL, '2024-01-29 07:08:55', '2024-01-29 07:55:06'),
	(19, 1, '2024-01-29', '2024-06-29', '2024-01-29', '2024-01-29', NULL, NULL, NULL, 'GCETSMC001000006', '2222', '100', '222', '17', 'Feny Cahyani', '16', 'Rahman Hidayat', '17', 'Feny Cahyani', '1', '9', '2222', 'Dooring', NULL, '30000', '0', '100000', '130000', 'CAD', NULL, '', NULL, 'Sudah Lunas', 'Sudah Dibawa', NULL, NULL, NULL, NULL, NULL, NULL, 'INV-C001-000001', NULL, NULL, '2024-01-29 07:43:19', '2024-01-29 07:55:06'),
	(20, 1, '2024-02-02', NULL, NULL, NULL, NULL, NULL, NULL, 'GCETSMC001000007', '1', '1', '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-02-02 09:50:37', '2024-02-02 09:50:37'),
	(21, 1, '2024-02-13', '2024-02-13', NULL, NULL, '2024-02-13', '2024-02-13', '2024-02-13', 'GCETSMC001000008', 'ewi', '2', '2', '16', 'Rahman Hidayat', '17', 'Feny Cahyani', '16', 'Rahman Hidayat', '1', '9', 'q', NULL, NULL, '30000', '0', '100000', '130000', 'CAD', NULL, '', NULL, 'Belum Lunas', 'Belum Dibawa', 'Telah Diambil Pembatalan', '100000', 'mnbmnb', '1707812692.webp', 'H3yhP0', NULL, NULL, NULL, NULL, '2024-02-13 08:22:32', '2024-02-13 08:28:16');

-- Dumping structure for table db_gce.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cabang_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_gce.users: ~8 rows (approximately)
INSERT INTO `users` (`id`, `name`, `cabang_id`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Superadmin', '0', 'su@gce.com', '2023-11-29 23:17:08', '$2y$10$Ckst/kCYl4rQmstz404Cs.XcedhE.9tT7b5.WCAQwlvDnXvoELuPW', 'QCbrdKTHb0ZBRg24Ub9wvogR2LoTgJG4WdI8ghj1IWpHuzQft6ymRkpLNszQ', '2023-11-29 23:17:08', '2023-12-07 19:17:57'),
	(32, 'Muhammad Rafi Heryadi', '0', 'finance@gce.com', NULL, '$2y$10$ZyDCjWC57O30qWKHOiA93OCYxJIft18kkoQBabvD2Wn0PiFRTxRky', NULL, '2024-01-13 16:20:25', '2024-01-13 16:20:25'),
	(33, 'Adi Rizki Yudita', '1', 'kasir.tsk@gce.com', NULL, '$2y$10$NW/flProWjyZj2bxAES3meNSCUDLExbZc0WzMoY3RKw/xe537Ufhu', NULL, '2024-01-13 16:21:22', '2024-01-13 16:21:22'),
	(34, 'Hendri Mara', '1', 'gudang.tsk@gce.com', NULL, '$2y$10$q..d05abc1r9roo6fbyetet7EQdCfWDYj2yytY.7iTzzbsyzYZ.Oi', NULL, '2024-01-13 16:22:02', '2024-01-13 16:22:02'),
	(35, 'Gerand', '10', 'kasir.bdg@gce.com', NULL, '$2y$10$CXO8Uygcvg7EgduPmgFSU.omoDCsNowXMKznq0CcWIFEo8/hqB9ii', NULL, '2024-01-13 16:22:54', '2024-01-13 16:22:54'),
	(36, 'Sabri', '10', 'gudang.bdg@gce.com', NULL, '$2y$10$/fKX45lKgfnRpHPubSOZ7uVfBgs8qxQCfPsU5ayCICMgGIpUbBw7.', NULL, '2024-01-13 16:23:22', '2024-01-13 16:23:22'),
	(37, 'Tedi Alamsyah', '9', 'kasir.sby@gce.com', NULL, '$2y$10$aMoa3JMVqorkdD3ETKb1POYPE6wnA8pVpvTouh9asXWfaBo27MYEW', NULL, '2024-01-14 01:40:01', '2024-01-14 01:40:01'),
	(38, '111', '9', 'gudang.sby@gce.com', NULL, '$2y$10$jVmZ5NEQYa4whX3HeN5Ybef8JoqoTiuARQsaK7ANDPv6F8YJ5SoPC', NULL, '2024-01-14 06:43:58', '2024-01-14 06:43:58'),
	(39, 'Rendi', '1', 'manager.tsk@gce.com', NULL, '$2y$10$der55Gju6O593hdMkbnfweHKVVlIeUSnRf6.NJIuT3R1bYyACDjKO', NULL, '2024-01-16 06:47:44', '2024-01-16 06:47:44');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
