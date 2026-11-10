-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Waktu pembuatan: 10 Nov 2026 pada 06.04
-- Versi server: 11.8.9-MariaDB-log
-- Versi PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u308178056_mbg_sigita`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `activities`
--

CREATE TABLE `activities` (
  `id` int(11) NOT NULL,
  `id_sppg` varchar(20) NOT NULL,
  `activity_name` varchar(200) NOT NULL,
  `activity_date` date NOT NULL,
  `status` enum('pending','approved','completed','cancelled') DEFAULT 'pending',
  `description` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `amount` decimal(15,2) DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin_sppg`
--

CREATE TABLE `admin_sppg` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `id_sppg` varchar(20) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `bahan_baku`
--

CREATE TABLE `bahan_baku` (
  `id` int(11) NOT NULL,
  `kode_transaksi` varchar(30) NOT NULL,
  `id_sppg` varchar(20) NOT NULL,
  `tanggal` date NOT NULL,
  `sumber_pengadaan` enum('koperasi','mandiri') DEFAULT 'koperasi',
  `status` enum('draft','waiting_approval','waiting_finance','rejected_finance','waiting_kepala','rejected_kepala','waiting_koperasi','procurement','completed','approved','rejected') NOT NULL DEFAULT 'draft',
  `catatan_keuangan` text DEFAULT NULL,
  `finance_reviewed_by` int(11) DEFAULT NULL,
  `finance_reviewed_at` datetime DEFAULT NULL,
  `foto_struk` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `kepala_approved_by` int(11) DEFAULT NULL,
  `kepala_approved_at` datetime DEFAULT NULL,
  `koperasi_processed_by` int(11) DEFAULT NULL,
  `koperasi_processed_at` datetime DEFAULT NULL,
  `koperasi_note` text DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `catatan_approval` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `pagu_tanggal` date DEFAULT NULL,
  `pagu_porsi_kecil` bigint(20) UNSIGNED DEFAULT NULL,
  `pagu_porsi_besar` bigint(20) UNSIGNED DEFAULT NULL,
  `pagu_tarif_kecil` bigint(20) UNSIGNED DEFAULT NULL,
  `pagu_tarif_besar` bigint(20) UNSIGNED DEFAULT NULL,
  `pagu_total` bigint(20) UNSIGNED DEFAULT NULL,
  `pagu_selisih` decimal(18,2) DEFAULT NULL,
  `pagu_snapshot_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `bahan_baku`
--

INSERT INTO `bahan_baku` (`id`, `kode_transaksi`, `id_sppg`, `tanggal`, `sumber_pengadaan`, `status`, `catatan_keuangan`, `finance_reviewed_by`, `finance_reviewed_at`, `foto_struk`, `created_by`, `approved_by`, `kepala_approved_by`, `kepala_approved_at`, `koperasi_processed_by`, `koperasi_processed_at`, `koperasi_note`, `approved_at`, `catatan_approval`, `created_at`, `updated_at`, `pagu_tanggal`, `pagu_porsi_kecil`, `pagu_porsi_besar`, `pagu_tarif_kecil`, `pagu_tarif_besar`, `pagu_total`, `pagu_selisih`, `pagu_snapshot_at`) VALUES
(7, '', 'Tampaksiring01', '2026-06-01', 'koperasi', 'rejected_finance', '0', 16, '2026-09-09 21:09:11', NULL, 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-05-31 11:43:27', '2026-09-09 21:09:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 'BB-20260607-0000001', 'Tampaksiring01', '2026-06-08', 'koperasi', 'completed', 'yaudah lah', 16, '2026-09-09 21:08:52', '1780819122_383f33947bfbc2c747dd.jpeg', 15, NULL, 14, '2026-09-09 21:09:33', 34, '2026-09-29 11:42:20', NULL, NULL, NULL, '2026-06-07 00:58:42', '2026-09-29 11:42:20', '2026-06-08', 366, 480, 8000, 10000, 7728000, -8432000.00, '2026-09-09 21:08:14'),
(9, 'BB-20260607-0000002', 'Tampaksiring01', '2026-06-09', 'koperasi', 'rejected_kepala', 'jalan dah', 16, '2026-09-08 19:26:52', '1780833809_8df55df524883e443035.jpeg', 15, NULL, 14, '2026-09-09 21:03:08', NULL, NULL, NULL, NULL, 'dikit amat', '2026-06-07 05:03:29', '2026-09-09 21:03:08', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, 'BB-20260907-0000006', 'Tampaksiring01', '2026-09-07', 'koperasi', 'completed', 'sip ok', 16, '2026-09-07 21:26:12', NULL, 15, NULL, 14, '2026-09-07 21:28:53', 34, '2026-09-08 19:23:28', 'Siap diproses', NULL, 'sip sudah ok', '2026-09-07 19:37:24', '2026-09-08 19:23:28', '2026-09-07', 366, 480, 8000, 10000, 7728000, 1113000.00, '2026-09-07 21:24:17'),
(14, 'BB-20260909-0000007', 'Tampaksiring01', '2026-09-09', 'koperasi', 'completed', 'oke', 16, '2026-09-09 21:02:30', NULL, 15, NULL, 14, '2026-09-09 21:03:31', 34, '2026-09-09 21:07:00', 'siap disiapkan', NULL, 'sip', '2026-09-09 20:50:49', '2026-09-09 21:07:00', '2026-09-09', 366, 480, 8000, 10000, 7728000, 1829000.00, '2026-09-09 21:02:13'),
(15, 'BB-20260929-0000008', 'Tampaksiring01', '2026-09-29', 'koperasi', 'procurement', 'tidak apa2 nanti disesuaikan dari pagu lain', 16, '2026-09-29 14:02:42', NULL, 15, NULL, 14, '2026-09-29 14:03:40', 34, '2026-09-29 14:05:35', 'sedang disiapkan', NULL, 'setuju', '2026-09-29 11:45:13', '2026-09-29 14:05:35', '2026-09-29', 366, 480, 8000, 10000, 7728000, -832000.00, '2026-09-29 14:01:12'),
(16, 'BB-20261022-0000009', 'Tampaksiring01', '2026-10-30', 'koperasi', 'completed', 'ok', 16, '2026-10-22 21:15:57', NULL, 15, NULL, 14, '2026-10-22 21:18:41', 34, '2026-10-22 21:29:51', NULL, NULL, 'ok', '2026-10-22 20:49:16', '2026-10-22 21:29:51', '2026-10-30', 603, 675, 8000, 10000, 11574000, 989000.00, '2026-10-22 21:15:30');

-- --------------------------------------------------------

--
-- Struktur dari tabel `bahan_baku_detail`
--

CREATE TABLE `bahan_baku_detail` (
  `id` int(11) NOT NULL,
  `belanja_id` int(11) NOT NULL,
  `bahan_id` int(11) DEFAULT NULL,
  `nama_bahan` varchar(200) NOT NULL,
  `qty` decimal(10,2) NOT NULL DEFAULT 0.00,
  `satuan` varchar(50) NOT NULL,
  `harga` decimal(15,2) DEFAULT 0.00,
  `total_harga` decimal(15,2) DEFAULT 0.00,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `bahan_baku_detail`
--

INSERT INTO `bahan_baku_detail` (`id`, `belanja_id`, `bahan_id`, `nama_bahan`, `qty`, `satuan`, `harga`, `total_harga`, `updated_by`, `updated_at`, `created_at`) VALUES
(15, 7, 24, 'Tepung Terigu', 200.00, 'gram', 0.00, 0.00, NULL, NULL, '2026-05-31 11:43:27'),
(16, 7, 21, 'Sayuran', 5.00, 'bungkus', 0.00, 0.00, NULL, NULL, '2026-05-31 11:43:27'),
(17, 7, 26, 'Tempe', 10.00, 'bungkus', 0.00, 0.00, NULL, NULL, '2026-05-31 11:43:27'),
(18, 7, 25, 'Tahu', 3.00, 'pack', 0.00, 0.00, NULL, NULL, '2026-05-31 11:43:27'),
(19, 8, 13, 'Beras', 30.00, 'kg', 15000.00, 450000.00, NULL, NULL, '2026-06-07 10:47:34'),
(20, 8, 123, 'Jagung', 100.00, 'Kg', 12000.00, 1200000.00, NULL, NULL, '2026-06-07 10:50:04'),
(21, 8, 124, 'Royco', 200.00, 'Bungkus', 3000.00, 600000.00, NULL, NULL, '2026-06-07 10:52:06'),
(22, 8, 124, 'Royco', 200.00, 'Bungkus', 3000.00, 600000.00, NULL, NULL, '2026-06-07 10:52:25'),
(23, 8, 17, 'Garam', 20.00, 'kg', 50500.00, 1010000.00, NULL, NULL, '2026-06-07 10:53:18'),
(24, 8, 19, 'Daging Sapi', 70.00, 'kg', 120000.00, 8400000.00, NULL, NULL, '2026-06-07 10:53:46'),
(25, 8, 26, 'Tempe', 150.00, 'potong', 2000.00, 300000.00, NULL, NULL, '2026-06-07 10:58:18'),
(26, 8, 24, 'Tepung Terigu', 300.00, 'kg', 12000.00, 3600000.00, NULL, NULL, '2026-06-07 12:02:21'),
(27, 9, 17, 'Garam', 23.00, 'kg', 6000.00, 138000.00, NULL, NULL, '2026-06-07 12:03:44'),
(45, 13, 13, 'Beras', 30.00, 'Liter', 15500.00, 465000.00, NULL, NULL, '2026-09-07 12:37:39'),
(46, 13, 18, 'Daging Ayam', 20.00, 'kg', 35000.00, 700000.00, 15, NULL, '2026-09-07 12:37:51'),
(47, 13, 126, 'Daging Kambing', 25.00, 'Kg', 130000.00, 3250000.00, 15, NULL, '2026-09-07 12:38:04'),
(48, 13, 19, 'Daging Sapi', 20.00, 'kg', 110000.00, 2200000.00, NULL, NULL, '2026-09-07 12:38:28'),
(50, 14, 13, 'Beras', 50.00, 'Liter', 15500.00, 775000.00, NULL, NULL, '2026-09-09 13:52:07'),
(51, 14, 18, 'Daging Ayam', 60.00, 'kg', 35000.00, 2100000.00, NULL, NULL, '2026-09-09 13:52:17'),
(53, 14, 130, 'Ikan dori', 56.00, 'Kg', 54000.00, 3024000.00, NULL, NULL, '2026-09-09 14:00:02'),
(54, 15, 18, 'Daging Ayam', 30.00, 'kg', 35000.00, 1050000.00, NULL, NULL, '2026-09-29 04:45:31'),
(55, 15, 19, 'Daging Sapi', 40.00, 'kg', 95000.00, 3800000.00, NULL, NULL, '2026-09-29 04:45:46'),
(56, 15, 13, 'Beras', 100.00, 'Kg', 15500.00, 1550000.00, NULL, NULL, '2026-09-29 04:46:00'),
(58, 15, 130, 'Ikan dori', 40.00, 'Kg', 54000.00, 2160000.00, NULL, NULL, '2026-09-29 07:00:51'),
(59, 16, 18, 'Daging Ayam', 20.00, 'kg', 35000.00, 700000.00, NULL, NULL, '2026-10-22 13:49:37'),
(60, 16, 13, 'Beras', 200.00, 'Kg', 15500.00, 3100000.00, NULL, NULL, '2026-10-22 13:49:51'),
(61, 16, 132, 'Daging Bebek', 12.00, 'Kg', 43000.00, 516000.00, NULL, NULL, '2026-10-22 13:55:35'),
(62, 16, 19, 'Daging Sapi', 40.00, 'kg', 95000.00, 3800000.00, NULL, NULL, '2026-10-22 13:55:46'),
(63, 16, 16, 'Gula Pasir', 12.00, 'kg', 12000.00, 144000.00, 15, NULL, '2026-10-22 13:57:15'),
(64, 16, 14, 'Telur', 50.00, 'Kg', 28000.00, 1400000.00, NULL, NULL, '2026-10-22 13:57:35'),
(65, 16, 20, 'Ikan Segar', 15.00, 'kg', 35000.00, 525000.00, 15, NULL, '2026-10-22 13:57:47'),
(66, 16, 123, 'Jagung', 20.00, 'Kg', 20000.00, 400000.00, NULL, NULL, '2026-10-22 13:57:59');

-- --------------------------------------------------------

--
-- Struktur dari tabel `bahan_request`
--

CREATE TABLE `bahan_request` (
  `id` int(11) NOT NULL,
  `id_sppg` varchar(20) NOT NULL,
  `nama_bahan` varchar(150) NOT NULL,
  `satuan` varchar(50) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `status` enum('menunggu','diproses','dipenuhi','ditolak') NOT NULL DEFAULT 'menunggu',
  `requested_by` int(11) DEFAULT NULL,
  `processed_by` int(11) DEFAULT NULL,
  `processed_at` datetime DEFAULT NULL,
  `rejection_reason` text DEFAULT NULL,
  `master_bahan_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `bahan_request`
--

INSERT INTO `bahan_request` (`id`, `id_sppg`, `nama_bahan`, `satuan`, `keterangan`, `status`, `requested_by`, `processed_by`, `processed_at`, `rejection_reason`, `master_bahan_id`, `created_at`, `updated_at`) VALUES
(1, 'Tampaksiring01', 'Keju Mozarella', 'Box', 'Butuh doooong', 'dipenuhi', 15, 34, '2026-09-04 05:15:24', NULL, 128, '2026-08-31 16:19:27', '2026-09-04 05:15:24'),
(2, 'Tampaksiring01', 'Telur Puyuh', 'Kg', 'untuk sop', 'dipenuhi', 15, 34, '2026-09-04 05:15:10', NULL, 127, '2026-08-31 16:23:37', '2026-09-04 05:15:10'),
(3, 'Tampaksiring01', 'Ikan dori', 'Kg', 'Butuh', 'dipenuhi', 15, 34, '2026-09-09 20:53:38', NULL, 130, '2026-09-09 20:51:26', '2026-09-09 20:53:38'),
(4, 'Tampaksiring01', 'Daging Bebek', 'Kg', NULL, 'dipenuhi', 15, 34, '2026-10-22 20:51:06', NULL, 132, '2026-10-22 20:50:27', '2026-10-22 20:51:06');

-- --------------------------------------------------------

--
-- Struktur dari tabel `biaya_operasional`
--

CREATE TABLE `biaya_operasional` (
  `id` int(11) NOT NULL,
  `id_sppg` varchar(20) NOT NULL,
  `nomor_pengajuan` varchar(50) NOT NULL,
  `tanggal` date NOT NULL,
  `keterangan` text DEFAULT NULL,
  `total_amount` decimal(15,2) DEFAULT 0.00,
  `status` enum('draft','submitted','approved','rejected','paid') DEFAULT 'draft',
  `created_by` int(11) DEFAULT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `paid_by` int(11) DEFAULT NULL,
  `paid_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `biaya_operasional_detail`
--

CREATE TABLE `biaya_operasional_detail` (
  `id` int(11) NOT NULL,
  `pengajuan_id` int(11) NOT NULL,
  `jenis_pengeluaran` varchar(200) NOT NULL,
  `qty` decimal(10,2) NOT NULL DEFAULT 0.00,
  `satuan` varchar(50) NOT NULL,
  `harga` decimal(15,2) NOT NULL DEFAULT 0.00,
  `subtotal` decimal(15,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `biaya_operasional_file`
--

CREATE TABLE `biaya_operasional_file` (
  `id` int(11) NOT NULL,
  `pengajuan_id` int(11) NOT NULL,
  `file_path` varchar(500) NOT NULL,
  `file_nama` varchar(200) NOT NULL,
  `file_original` varchar(200) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jadwal_relawan`
--

CREATE TABLE `jadwal_relawan` (
  `id` int(11) NOT NULL,
  `id_sppg` varchar(20) NOT NULL,
  `relawan_id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `shift` enum('pagi','siang','malam') DEFAULT 'pagi',
  `keterangan` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kegiatan_aslap`
--

CREATE TABLE `kegiatan_aslap` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_sppg` varchar(50) NOT NULL,
  `tanggal` date NOT NULL,
  `judul_kegiatan` varchar(255) NOT NULL,
  `lokasi` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kegiatan_aslap`
--

INSERT INTO `kegiatan_aslap` (`id`, `id_sppg`, `tanggal`, `judul_kegiatan`, `lokasi`, `deskripsi`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Tampaksiring01', '2026-06-10', 'Cek Lapangan', 'SMP Kalijaga', 'ibjjkabsdkjbkjasdbnkasd ajksdbjasdasfdsdagdsg', 17, '2026-06-10 17:04:52', '2026-06-10 17:04:52'),
(2, 'Tampaksiring01', '2026-06-11', 'Surfey Sekolah', 'SMP Pembangunan', 'Melihat jumlah siswa', 17, '2026-06-12 16:19:56', '2026-06-12 16:19:56'),
(3, 'Tampaksiring01', '2026-06-12', 'Survey Lapanga', 'SMA SUK Karage', 'Menghitung Jumlah Siswa', 17, '2026-06-12 16:21:52', '2026-06-12 16:21:52'),
(6, 'Tampaksiring01', '2026-06-13', 'Sosialisasi dengan kepsek', 'SD Makmur', 'Mensosialisaikan SPPG di sekolah', 17, '2026-06-13 11:33:32', '2026-06-13 11:33:32');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kegiatan_aslap_foto`
--

CREATE TABLE `kegiatan_aslap_foto` (
  `id` int(11) UNSIGNED NOT NULL,
  `kegiatan_id` int(11) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kegiatan_aslap_foto`
--

INSERT INTO `kegiatan_aslap_foto` (`id`, `kegiatan_id`, `foto`, `created_at`) VALUES
(1, 1, '1781111092_38bcd3364cd12d52a89e.jpeg', NULL),
(2, 1, '1781111092_19ed006ee08ec022d58b.jpeg', NULL),
(4, 1, '1781111092_7e2fdc2b0403e470ea38.jpeg', NULL),
(5, 1, '1781269678_85b01d901a24979d9a00.jpeg', NULL),
(7, 2, '1781281196_0b767c47ededcdda229c.jpeg', NULL),
(8, 2, '1781281196_cf415e9d3960992ea092.jpeg', NULL),
(10, 3, '1781281312_dae1af7c6b17b9bde8d8.jpeg', NULL),
(11, 3, '1781281312_012fd60cf81add8bdc90.jpeg', NULL),
(12, 3, '1781281312_5465c4f55aecec2d4000.jpeg', NULL),
(17, 6, '1781351175_0073c18e49e315ddc035.png', NULL),
(19, 6, '6a2d44a194255.jpg', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kegiatan_gizi`
--

CREATE TABLE `kegiatan_gizi` (
  `id` int(11) NOT NULL,
  `id_sppg` varchar(20) NOT NULL,
  `tanggal` date NOT NULL,
  `lokasi_tipe` enum('sekolah','dapur','gudang','lainnya') DEFAULT 'sekolah',
  `lokasi_id` int(11) DEFAULT NULL,
  `lokasi_nama` varchar(200) DEFAULT NULL,
  `jenis_kegiatan_id` int(11) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kegiatan_gizi`
--

INSERT INTO `kegiatan_gizi` (`id`, `id_sppg`, `tanggal`, `lokasi_tipe`, `lokasi_id`, `lokasi_nama`, `jenis_kegiatan_id`, `deskripsi`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Tampaksiring01', '2026-06-27', 'sekolah', NULL, 'SD Hikmah Suka Jadi', 8, 'Konsultasi mengenai gizi pada setiap menu makanan', 15, '2026-06-27 23:06:51', '2026-06-27 23:06:51'),
(2, 'Tampaksiring01', '2026-06-27', 'sekolah', NULL, 'Dapur SPPG', 1, 'Merencanakan menu gizi', 15, '2026-06-27 23:13:44', '2026-06-27 23:13:44'),
(3, 'Tampaksiring01', '2026-06-28', 'sekolah', NULL, 'Dapur SPPG', 2, 'Menghitung bahan makana yang sudah ada', 15, '2026-06-27 23:26:19', '2026-06-27 23:26:19'),
(4, 'Tampaksiring01', '2026-08-23', 'sekolah', NULL, 'Dapur SPPG', 2, 'dgfgdfg', 15, '2026-08-23 20:53:50', '2026-08-23 20:53:50'),
(5, 'Tampaksiring01', '2026-09-08', 'sekolah', NULL, 'Pon-pes serbaguna', 11, 'ngapain ya...', 15, '2026-09-08 21:34:59', '2026-09-09 03:38:17');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kegiatan_gizi_foto`
--

CREATE TABLE `kegiatan_gizi_foto` (
  `id` int(11) NOT NULL,
  `kegiatan_id` int(11) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `urutan` int(11) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kegiatan_gizi_foto`
--

INSERT INTO `kegiatan_gizi_foto` (`id`, `kegiatan_id`, `foto`, `urutan`, `created_at`) VALUES
(1, 3, '6a3ff9ab343e7.jpg', 1, '2026-06-27 16:26:19'),
(2, 3, '6a3ff9ab49bb0.jpg', 1, '2026-06-27 16:26:20'),
(3, 3, '6a3ff9ac3f5bb.jpg', 1, '2026-06-27 16:26:20'),
(4, 5, '6aa01d130977a.jpg', 1, '2026-09-08 14:34:59');

-- --------------------------------------------------------

--
-- Struktur dari tabel `koperasi`
--

CREATE TABLE `koperasi` (
  `id` int(11) NOT NULL,
  `kode_koperasi` varchar(30) NOT NULL,
  `nama_koperasi` varchar(150) NOT NULL,
  `alamat` text DEFAULT NULL,
  `telepon` varchar(30) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `koperasi`
--

INSERT INTO `koperasi` (`id`, `kode_koperasi`, `nama_koperasi`, `alamat`, `telepon`, `email`, `status`, `created_at`, `updated_at`) VALUES
(1, 'KOPBB01', 'Koperasi Bahagia Bersama', 'Jl. Bersama', '0822211443335', 'KOPBB01@Sigita-mbg.net', 'active', '2026-09-01 10:20:48', '2026-09-04 04:59:29'),
(2, 'kop21', 'Koperasi Bineka Tunggal Ika', 'Jl. Suko Makmur', '88993332', 'koperasi@gmail.com', 'active', '2026-09-04 04:33:36', '2026-09-03 21:39:49');

-- --------------------------------------------------------

--
-- Struktur dari tabel `koperasi_pembelian`
--

CREATE TABLE `koperasi_pembelian` (
  `id` int(10) UNSIGNED NOT NULL,
  `no_pembelian` varchar(40) NOT NULL,
  `belanja_id` int(10) UNSIGNED NOT NULL,
  `id_sppg` varchar(50) NOT NULL,
  `tanggal_pembelian` date NOT NULL,
  `supplier` varchar(255) DEFAULT NULL,
  `supplier_id` int(11) UNSIGNED DEFAULT NULL,
  `no_invoice_supplier` varchar(100) DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `status` enum('draft','dibeli','dikirim') NOT NULL DEFAULT 'draft',
  `total` decimal(18,2) NOT NULL DEFAULT 0.00,
  `total_harga_beli` decimal(18,2) NOT NULL DEFAULT 0.00,
  `total_margin` decimal(18,2) NOT NULL DEFAULT 0.00,
  `margin_persen` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `dibeli_at` datetime DEFAULT NULL,
  `dibeli_by` int(10) UNSIGNED DEFAULT NULL,
  `dikirim_at` datetime DEFAULT NULL,
  `dikirim_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `koperasi_pembelian`
--

INSERT INTO `koperasi_pembelian` (`id`, `no_pembelian`, `belanja_id`, `id_sppg`, `tanggal_pembelian`, `supplier`, `supplier_id`, `no_invoice_supplier`, `catatan`, `status`, `total`, `total_harga_beli`, `total_margin`, `margin_persen`, `created_by`, `updated_by`, `dibeli_at`, `dibeli_by`, `dikirim_at`, `dikirim_by`, `created_at`, `updated_at`) VALUES
(1, 'PB-20260907-00001', 13, 'Tampaksiring01', '2026-09-07', 'Koperasi', NULL, NULL, 'Siap diproses', 'dikirim', 6139500.00, 0.00, 0.00, 0.00, 34, 34, '2026-09-08 19:23:23', 34, '2026-09-08 19:23:28', 34, '2026-09-07 23:06:45', '2026-09-08 19:23:28'),
(2, 'PB-20260909-00002', 14, 'Tampaksiring01', '2026-09-09', 'koperasi', NULL, NULL, 'siap disiapkan', 'dikirim', 5497500.00, 0.00, 0.00, 0.00, 34, 34, '2026-09-09 21:06:18', 34, '2026-09-09 21:07:00', 34, '2026-09-09 21:04:14', '2026-09-09 21:07:00'),
(3, 'PB-20260909-00003', 8, 'Tampaksiring01', '2026-09-09', NULL, NULL, NULL, NULL, 'dikirim', 16160000.00, 14755000.00, 1405000.00, 9.52, 34, 34, '2026-09-28 15:43:57', 34, '2026-09-29 11:42:20', 34, '2026-09-09 21:23:10', '2026-09-29 11:42:20'),
(4, 'PB-20260929-00004', 15, 'Tampaksiring01', '2026-09-29', NULL, NULL, NULL, 'sedang disiapkan', 'draft', 8560000.00, 7400000.00, 1160000.00, 15.68, 34, 34, NULL, NULL, NULL, NULL, '2026-09-29 14:05:35', '2026-10-22 21:47:39'),
(5, 'PB-20261022-00005', 16, 'Tampaksiring01', '2026-10-22', NULL, NULL, NULL, NULL, 'dikirim', 10585000.00, 9104000.00, 1481000.00, 16.27, 34, 34, '2026-10-22 21:29:37', 34, '2026-10-22 21:29:51', 34, '2026-10-22 21:19:38', '2026-10-22 21:29:51');

-- --------------------------------------------------------

--
-- Struktur dari tabel `koperasi_pembelian_detail`
--

CREATE TABLE `koperasi_pembelian_detail` (
  `id` int(10) UNSIGNED NOT NULL,
  `pembelian_id` int(10) UNSIGNED NOT NULL,
  `bahan_id` int(10) UNSIGNED DEFAULT NULL,
  `supplier_bahan_id` int(11) UNSIGNED DEFAULT NULL,
  `no_invoice_supplier` varchar(150) DEFAULT NULL,
  `nama_bahan` varchar(255) NOT NULL,
  `qty_diminta` decimal(18,2) NOT NULL DEFAULT 0.00,
  `qty_dibeli` decimal(18,2) NOT NULL DEFAULT 0.00,
  `satuan` varchar(50) NOT NULL,
  `harga_satuan` decimal(18,2) NOT NULL DEFAULT 0.00,
  `harga_beli_snapshot` decimal(18,2) NOT NULL DEFAULT 0.00,
  `harga_jual_snapshot` decimal(18,2) NOT NULL DEFAULT 0.00,
  `margin_snapshot` decimal(18,2) NOT NULL DEFAULT 0.00,
  `margin_persen_snapshot` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_harga` decimal(18,2) NOT NULL DEFAULT 0.00,
  `keterangan` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `koperasi_pembelian_detail`
--

INSERT INTO `koperasi_pembelian_detail` (`id`, `pembelian_id`, `bahan_id`, `supplier_bahan_id`, `no_invoice_supplier`, `nama_bahan`, `qty_diminta`, `qty_dibeli`, `satuan`, `harga_satuan`, `harga_beli_snapshot`, `harga_jual_snapshot`, `margin_snapshot`, `margin_persen_snapshot`, `total_harga`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 1, 13, NULL, NULL, 'Beras', 30.00, 29.00, 'Liter', 15500.00, 0.00, 0.00, 0.00, 0.00, 449500.00, 'tinggal 29 liter', '2026-09-07 23:06:45', '2026-09-08 19:21:18'),
(2, 1, 18, NULL, NULL, 'Daging Ayam', 20.00, 18.00, 'kg', 35000.00, 0.00, 0.00, 0.00, 0.00, 630000.00, 'tinggal 18', '2026-09-07 23:06:46', '2026-09-08 19:21:18'),
(3, 1, 126, NULL, NULL, 'Daging Kambing', 25.00, 22.00, 'Kg', 130000.00, 0.00, 0.00, 0.00, 0.00, 2860000.00, 'tinggal 22', '2026-09-07 23:06:46', '2026-09-08 19:21:18'),
(4, 1, 19, NULL, NULL, 'Daging Sapi', 20.00, 20.00, 'kg', 110000.00, 0.00, 0.00, 0.00, 0.00, 2200000.00, NULL, '2026-09-07 23:06:46', '2026-09-08 19:21:18'),
(5, 2, 13, NULL, NULL, 'Beras', 50.00, 45.00, 'Liter', 15500.00, 0.00, 0.00, 0.00, 0.00, 697500.00, 'waduuuhh', '2026-09-09 21:04:14', '2026-09-09 21:05:26'),
(6, 2, 18, NULL, NULL, 'Daging Ayam', 60.00, 60.00, 'kg', 35000.00, 0.00, 0.00, 0.00, 0.00, 2100000.00, NULL, '2026-09-09 21:04:14', '2026-09-09 21:05:26'),
(7, 2, 130, NULL, NULL, 'Ikan dori', 56.00, 50.00, 'Kg', 54000.00, 0.00, 0.00, 0.00, 0.00, 2700000.00, NULL, '2026-09-09 21:04:14', '2026-09-09 21:05:26'),
(8, 3, 13, 1, 'INV-PB-20260909-00003', 'Beras', 30.00, 30.00, 'kg', 15000.00, 13000.00, 15000.00, 2000.00, 15.38, 450000.00, NULL, '2026-09-09 21:23:10', '2026-09-28 15:43:43'),
(9, 3, 123, 3, 'INV-PB-20260909-00003', 'Jagung', 100.00, 100.00, 'Kg', 12000.00, 10000.00, 12000.00, 2000.00, 20.00, 1200000.00, NULL, '2026-09-09 21:23:10', '2026-09-28 15:43:43'),
(10, 3, 124, 5, 'INV-PB-20260909-00003', 'Royco', 200.00, 200.00, 'Bungkus', 3000.00, 2000.00, 3000.00, 1000.00, 50.00, 600000.00, NULL, '2026-09-09 21:23:10', '2026-09-28 15:43:43'),
(11, 3, 124, 7, 'INV-PB-20260909-00003', 'Royco', 200.00, 200.00, 'Bungkus', 3000.00, 3000.00, 3000.00, 0.00, 0.00, 600000.00, NULL, '2026-09-09 21:23:10', '2026-09-28 15:43:43'),
(12, 3, 17, 4, 'INV-PB-20260909-00003', 'Garam', 20.00, 20.00, 'kg', 50500.00, 40000.00, 50500.00, 10500.00, 26.25, 1010000.00, NULL, '2026-09-09 21:23:10', '2026-09-28 15:43:43'),
(13, 3, 19, 6, 'INV-PB-20260909-00003', 'Daging Sapi', 70.00, 70.00, 'kg', 120000.00, 117000.00, 120000.00, 3000.00, 2.56, 8400000.00, NULL, '2026-09-09 21:23:10', '2026-09-28 15:43:43'),
(14, 3, 26, 8, 'INV-PB-20260909-00003', 'Tempe', 150.00, 150.00, 'potong', 2000.00, 1500.00, 2000.00, 500.00, 33.33, 300000.00, NULL, '2026-09-09 21:23:10', '2026-09-28 15:43:43'),
(15, 3, 24, 9, 'INV-PB-20260909-00003', 'Tepung Terigu', 300.00, 300.00, 'kg', 12000.00, 10500.00, 12000.00, 1500.00, 14.29, 3600000.00, NULL, '2026-09-09 21:23:10', '2026-09-28 15:43:43'),
(16, 4, 18, 15, 'INV-PB-20260929-00004', 'Daging Ayam', 30.00, 30.00, 'kg', 35000.00, 30000.00, 35000.00, 5000.00, 16.67, 1050000.00, NULL, '2026-09-29 14:05:35', '2026-10-22 21:47:39'),
(17, 4, 19, 6, 'INV-PB-20260929-00004', 'Daging Sapi', 40.00, 40.00, 'kg', 95000.00, 90000.00, 95000.00, 5000.00, 5.56, 3800000.00, NULL, '2026-09-29 14:05:35', '2026-10-22 21:47:39'),
(18, 4, 13, 1, 'INV-PB-20260929-00004', 'Beras', 100.00, 100.00, 'Kg', 15500.00, 13000.00, 15500.00, 2500.00, 19.23, 1550000.00, NULL, '2026-09-29 14:05:35', '2026-10-22 21:47:39'),
(19, 4, 130, 10, 'INV-PB-20260929-00004', 'Ikan dori', 40.00, 40.00, 'Kg', 54000.00, 40000.00, 54000.00, 14000.00, 35.00, 2160000.00, NULL, '2026-09-29 14:05:35', '2026-10-22 21:47:39'),
(20, 5, 18, 15, 'INV-PB-20261022-00005', 'Daging Ayam', 20.00, 20.00, 'kg', 35000.00, 25000.00, 35000.00, 10000.00, 40.00, 700000.00, NULL, '2026-10-22 21:19:38', '2026-10-22 21:29:30'),
(21, 5, 13, 1, 'INV-PB-20261022-00005', 'Beras', 200.00, 200.00, 'Kg', 15500.00, 13000.00, 15500.00, 2500.00, 19.23, 3100000.00, NULL, '2026-10-22 21:19:38', '2026-10-22 21:29:30'),
(22, 5, 132, 13, 'INV-PB-20261022-00005', 'Daging Bebek', 12.00, 12.00, 'Kg', 43000.00, 35000.00, 43000.00, 8000.00, 22.86, 516000.00, NULL, '2026-10-22 21:19:38', '2026-10-22 21:29:30'),
(23, 5, 19, 6, 'INV-PB-20261022-00005', 'Daging Sapi', 40.00, 40.00, 'kg', 95000.00, 90000.00, 95000.00, 5000.00, 5.56, 3800000.00, NULL, '2026-10-22 21:19:38', '2026-10-22 21:29:30'),
(24, 5, 16, 17, 'INV-PB-20261022-00005', 'Gula Pasir', 12.00, 12.00, 'kg', 12000.00, 12000.00, 12000.00, 0.00, 0.00, 144000.00, NULL, '2026-10-22 21:19:38', '2026-10-22 21:29:30'),
(25, 5, 14, 14, 'INV-PB-20261022-00005', 'Telur', 50.00, 50.00, 'Kg', 28000.00, 25000.00, 28000.00, 3000.00, 12.00, 1400000.00, NULL, '2026-10-22 21:19:38', '2026-10-22 21:29:30'),
(26, 5, 20, 16, 'INV-PB-20261022-00005', 'Ikan Segar', 15.00, 15.00, 'kg', 35000.00, 26000.00, 35000.00, 9000.00, 34.62, 525000.00, NULL, '2026-10-22 21:19:38', '2026-10-22 21:29:30'),
(27, 5, 123, 3, 'INV-PB-20261022-00005', 'Jagung', 20.00, 20.00, 'Kg', 20000.00, 10000.00, 20000.00, 10000.00, 100.00, 400000.00, NULL, '2026-10-22 21:19:38', '2026-10-22 21:29:30');

-- --------------------------------------------------------

--
-- Struktur dari tabel `koperasi_sppg`
--

CREATE TABLE `koperasi_sppg` (
  `id` int(11) NOT NULL,
  `koperasi_id` int(11) NOT NULL,
  `id_sppg` varchar(20) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `koperasi_sppg`
--

INSERT INTO `koperasi_sppg` (`id`, `koperasi_id`, `id_sppg`, `status`, `tanggal_mulai`, `tanggal_selesai`, `created_at`, `updated_at`) VALUES
(12, 1, 'Pandak01', 'active', NULL, NULL, '2026-09-01 15:20:12', '2026-09-06 12:37:22'),
(13, 1, 'Tampaksiring01', 'active', NULL, NULL, '2026-09-01 15:20:12', '2026-09-06 12:37:22'),
(14, 1, 'Ngaglik01', 'active', NULL, NULL, '2026-09-01 15:20:12', '2026-09-06 12:37:22'),
(15, 2, 'Pandak01', 'active', '2026-09-04', NULL, '2026-09-04 04:52:22', '2026-09-04 04:52:22'),
(16, 2, 'Tampaksiring01', 'active', '2026-09-04', NULL, '2026-09-04 04:52:22', '2026-09-04 04:52:22');

-- --------------------------------------------------------

--
-- Struktur dari tabel `master_bahan`
--

CREATE TABLE `master_bahan` (
  `id` int(11) NOT NULL,
  `id_sppg` varchar(20) NOT NULL,
  `nama_bahan` varchar(100) NOT NULL,
  `satuan_default` varchar(50) NOT NULL,
  `harga` decimal(15,2) NOT NULL DEFAULT 0.00,
  `status` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `harga_pokok` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `master_bahan`
--

INSERT INTO `master_bahan` (`id`, `id_sppg`, `nama_bahan`, `satuan_default`, `harga`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`, `harga_pokok`) VALUES
(13, 'Tampaksiring01', 'Beras', 'Kg', 15500.00, 'aktif', NULL, 34, '2026-05-29 14:30:14', '2026-09-09 20:58:42', 0),
(14, 'Tampaksiring01', 'Telur', 'Kg', 28000.00, 'aktif', NULL, 34, '2026-05-29 14:30:14', '2026-10-22 20:54:29', 0),
(15, 'Tampaksiring01', 'Minyak Goreng', 'liter', 0.00, 'aktif', NULL, NULL, '2026-05-29 14:30:14', '2026-05-29 14:30:14', 0),
(16, 'Tampaksiring01', 'Gula Pasir', 'kg', 12000.00, 'aktif', NULL, 34, '2026-05-29 14:30:14', '2026-10-13 18:14:44', 0),
(17, 'Tampaksiring01', 'Garam', 'kg', 5000.00, 'aktif', NULL, 34, '2026-05-29 14:30:14', '2026-10-13 18:14:44', 0),
(18, 'Tampaksiring01', 'Daging Ayam', 'kg', 35000.00, 'aktif', NULL, 34, '2026-05-29 14:30:14', '2026-09-04 14:59:39', 0),
(19, 'Tampaksiring01', 'Daging Sapi', 'kg', 95000.00, 'aktif', NULL, 34, '2026-05-29 14:30:14', '2026-09-09 20:59:23', 0),
(20, 'Tampaksiring01', 'Ikan Segar', 'kg', 35000.00, 'aktif', NULL, 34, '2026-05-29 14:30:14', '2026-10-13 18:14:44', 0),
(21, 'Tampaksiring01', 'Sayuran', 'ikat', 0.00, 'aktif', NULL, NULL, '2026-05-29 14:30:14', '2026-05-29 14:30:14', 0),
(22, 'Tampaksiring01', 'Semangka', 'Kg', 0.00, 'aktif', NULL, NULL, '2026-05-29 14:30:14', '2026-06-27 19:01:49', 0),
(23, 'Tampaksiring01', 'Susu', 'liter', 35000.00, 'aktif', NULL, 34, '2026-05-29 14:30:14', '2026-10-09 20:28:12', 0),
(24, 'Tampaksiring01', 'Tepung Terigu', 'kg', 0.00, 'aktif', NULL, NULL, '2026-05-29 14:30:14', '2026-05-29 14:30:14', 0),
(25, 'Tampaksiring01', 'Tahu', 'potong', 0.00, 'aktif', NULL, NULL, '2026-05-29 14:30:14', '2026-05-29 14:30:14', 0),
(26, 'Tampaksiring01', 'Tempe', 'potong', 0.00, 'aktif', NULL, NULL, '2026-05-29 14:30:14', '2026-05-29 14:30:14', 0),
(27, 'Tampaksiring01', 'Kacang Hijau', 'kg', 120000.00, 'aktif', NULL, 34, '2026-05-29 14:30:14', '2026-10-22 20:54:29', 0),
(28, 'Tampaksiring01', 'Kacang Kedelai', 'kg', 0.00, 'aktif', NULL, NULL, '2026-05-29 14:30:14', '2026-05-29 14:30:14', 0),
(29, 'Pandak01', 'Beras', 'kg', 13500.00, 'aktif', NULL, 34, '2026-05-29 14:30:14', '2026-09-04 05:12:52', 0),
(30, 'Pandak01', 'Telur', 'butir', 0.00, 'aktif', NULL, NULL, '2026-05-29 14:30:14', '2026-05-29 14:30:14', 0),
(31, 'Pandak01', 'Minyak Goreng', 'liter', 0.00, 'aktif', NULL, NULL, '2026-05-29 14:30:14', '2026-05-29 14:30:14', 0),
(32, 'Pandak01', 'Gula Pasir', 'kg', 0.00, 'aktif', NULL, NULL, '2026-05-29 14:30:14', '2026-05-29 14:30:14', 0),
(33, 'Pandak01', 'Garam', 'kg', 0.00, 'aktif', NULL, NULL, '2026-05-29 14:30:14', '2026-05-29 14:30:14', 0),
(34, 'Pandak01', 'Daging Ayam', 'kg', 0.00, 'aktif', NULL, NULL, '2026-05-29 14:30:14', '2026-05-29 14:30:14', 0),
(35, 'Pandak01', 'Daging Sapi', 'kg', 0.00, 'aktif', NULL, NULL, '2026-05-29 14:30:14', '2026-05-29 14:30:14', 0),
(36, 'Pandak01', 'Ikan Segar', 'kg', 0.00, 'aktif', NULL, NULL, '2026-05-29 14:30:14', '2026-05-29 14:30:14', 0),
(37, 'Pandak01', 'Sayuran', 'ikat', 0.00, 'aktif', NULL, NULL, '2026-05-29 14:30:14', '2026-05-29 14:30:14', 0),
(38, 'Pandak01', 'Buah-buahan', 'Dus', 0.00, 'aktif', NULL, 34, '2026-05-29 14:30:14', '2026-09-06 16:53:45', 0),
(39, 'Pandak01', 'Susu', 'liter', 0.00, 'aktif', NULL, NULL, '2026-05-29 14:30:14', '2026-05-29 14:30:14', 0),
(40, 'Pandak01', 'Tepung Terigu', 'kg', 0.00, 'aktif', NULL, NULL, '2026-05-29 14:30:14', '2026-05-29 14:30:14', 0),
(41, 'Pandak01', 'Tahu', 'potong', 0.00, 'aktif', NULL, NULL, '2026-05-29 14:30:14', '2026-05-29 14:30:14', 0),
(42, 'Pandak01', 'Tempe', 'potong', 0.00, 'aktif', NULL, NULL, '2026-05-29 14:30:14', '2026-05-29 14:30:14', 0),
(43, 'Pandak01', 'Kacang Hijau', 'kg', 0.00, 'aktif', NULL, NULL, '2026-05-29 14:30:14', '2026-05-29 14:30:14', 0),
(44, 'Pandak01', 'Kacang Kedelai', 'kg', 0.00, 'aktif', NULL, NULL, '2026-05-29 14:30:14', '2026-05-29 14:30:14', 0),
(60, 'Ngaglik01', 'Beras', 'kg', 0.00, 'aktif', NULL, NULL, '2026-05-29 14:30:14', '2026-05-29 14:30:14', 0),
(61, 'Ngaglik01', 'Telur', 'butir', 0.00, 'aktif', NULL, NULL, '2026-05-29 14:30:14', '2026-05-29 14:30:14', 0),
(62, 'Ngaglik01', 'Minyak Goreng', 'liter', 0.00, 'aktif', NULL, NULL, '2026-05-29 14:30:14', '2026-05-29 14:30:14', 0),
(63, 'Ngaglik01', 'Gula Pasir', 'kg', 0.00, 'aktif', NULL, NULL, '2026-05-29 14:30:14', '2026-05-29 14:30:14', 0),
(64, 'Ngaglik01', 'Garam', 'kg', 0.00, 'aktif', NULL, NULL, '2026-05-29 14:30:14', '2026-05-29 14:30:14', 0),
(65, 'Ngaglik01', 'Daging Ayam', 'kg', 0.00, 'aktif', NULL, NULL, '2026-05-29 14:30:14', '2026-05-29 14:30:14', 0),
(66, 'Ngaglik01', 'Daging Sapi', 'kg', 0.00, 'aktif', NULL, NULL, '2026-05-29 14:30:14', '2026-05-29 14:30:14', 0),
(67, 'Ngaglik01', 'Ikan Segar', 'kg', 0.00, 'aktif', NULL, NULL, '2026-05-29 14:30:14', '2026-05-29 14:30:14', 0),
(68, 'Ngaglik01', 'Sayuran', 'ikat', 0.00, 'aktif', NULL, NULL, '2026-05-29 14:30:14', '2026-05-29 14:30:14', 0),
(69, 'Ngaglik01', 'Buah-buahan', 'kg', 0.00, 'aktif', NULL, NULL, '2026-05-29 14:30:14', '2026-05-29 14:30:14', 0),
(70, 'Ngaglik01', 'Susu', 'liter', 0.00, 'aktif', NULL, NULL, '2026-05-29 14:30:14', '2026-05-29 14:30:14', 0),
(71, 'Ngaglik01', 'Tepung Terigu', 'kg', 0.00, 'aktif', NULL, NULL, '2026-05-29 14:30:14', '2026-05-29 14:30:14', 0),
(72, 'Ngaglik01', 'Tahu', 'potong', 0.00, 'aktif', NULL, NULL, '2026-05-29 14:30:14', '2026-05-29 14:30:14', 0),
(73, 'Ngaglik01', 'Tempe', 'potong', 0.00, 'aktif', NULL, NULL, '2026-05-29 14:30:14', '2026-05-29 14:30:14', 0),
(74, 'Ngaglik01', 'Kacang Hijau', 'kg', 0.00, 'aktif', NULL, NULL, '2026-05-29 14:30:14', '2026-05-29 14:30:14', 0),
(75, 'Ngaglik01', 'Kacang Kedelai', 'kg', 0.00, 'aktif', NULL, NULL, '2026-05-29 14:30:14', '2026-05-29 14:30:14', 0),
(91, 'Semin01', 'Beras', 'kg', 0.00, 'aktif', NULL, NULL, '2026-05-29 14:30:14', '2026-05-29 14:30:14', 0),
(92, 'Semin01', 'Buah-buahan', 'kg', 0.00, 'aktif', NULL, NULL, '2026-05-29 14:30:14', '2026-05-29 14:30:14', 0),
(93, 'Semin01', 'Daging Ayam', 'kg', 0.00, 'aktif', NULL, NULL, '2026-05-29 14:30:14', '2026-05-29 14:30:14', 0),
(94, 'Semin01', 'Daging Sapi', 'kg', 0.00, 'aktif', NULL, NULL, '2026-05-29 14:30:14', '2026-05-29 14:30:14', 0),
(95, 'Semin01', 'Garam', 'kg', 0.00, 'aktif', NULL, NULL, '2026-05-29 14:30:14', '2026-05-29 14:30:14', 0),
(96, 'Semin01', 'Gula Pasir', 'kg', 0.00, 'aktif', NULL, NULL, '2026-05-29 14:30:14', '2026-05-29 14:30:14', 0),
(97, 'Semin01', 'Ikan Segar', 'kg', 0.00, 'aktif', NULL, NULL, '2026-05-29 14:30:14', '2026-05-29 14:30:14', 0),
(98, 'Semin01', 'Kacang Hijau', 'kg', 0.00, 'aktif', NULL, NULL, '2026-05-29 14:30:14', '2026-05-29 14:30:14', 0),
(99, 'Semin01', 'Kacang Kedelai', 'kg', 0.00, 'aktif', NULL, NULL, '2026-05-29 14:30:14', '2026-05-29 14:30:14', 0),
(100, 'Semin01', 'Minyak Goreng', 'liter', 0.00, 'aktif', NULL, NULL, '2026-05-29 14:30:14', '2026-05-29 14:30:14', 0),
(101, 'Semin01', 'Sayuran', 'ikat', 0.00, 'aktif', NULL, NULL, '2026-05-29 14:30:14', '2026-05-29 14:30:14', 0),
(102, 'Semin01', 'Susu', 'liter', 0.00, 'aktif', NULL, NULL, '2026-05-29 14:30:14', '2026-05-29 14:30:14', 0),
(103, 'Semin01', 'Tahu', 'potong', 0.00, 'aktif', NULL, NULL, '2026-05-29 14:30:14', '2026-05-29 14:30:14', 0),
(104, 'Semin01', 'Telur', 'butir', 0.00, 'aktif', NULL, NULL, '2026-05-29 14:30:14', '2026-05-29 14:30:14', 0),
(105, 'Semin01', 'Tempe', 'potong', 0.00, 'aktif', NULL, NULL, '2026-05-29 14:30:14', '2026-05-29 14:30:14', 0),
(106, 'Semin01', 'Tepung Terigu', 'kg', 0.00, 'aktif', NULL, NULL, '2026-05-29 14:30:14', '2026-05-29 14:30:14', 0),
(123, 'Tampaksiring01', 'Jagung', 'Kg', 20000.00, 'aktif', NULL, 34, '2026-06-07 03:48:45', '2026-10-22 20:54:29', 0),
(124, 'Tampaksiring01', 'Royco', 'Bungkus', 0.00, 'aktif', NULL, NULL, '2026-06-07 03:51:06', '2026-06-07 03:51:06', 0),
(125, 'Tampaksiring01', 'Ikan Teri', 'Kg', 15000.00, 'aktif', NULL, 34, '2026-06-21 21:18:05', '2026-10-22 20:54:29', 0),
(126, 'Tampaksiring01', 'Daging Kambing', 'Kg', 130000.00, 'aktif', 34, 34, '2026-09-04 05:14:19', '2026-09-04 05:14:19', NULL),
(127, 'Tampaksiring01', 'Telur Puyuh', 'Kg', 15000.00, 'aktif', 34, 34, '2026-09-04 05:15:10', '2026-09-04 05:15:10', NULL),
(128, 'Tampaksiring01', 'Keju Mozarella', 'Box', 36000.00, 'aktif', 34, 34, '2026-09-04 05:15:24', '2026-09-04 05:15:24', NULL),
(129, 'Pandak01', 'Telur Puyuh', 'Kg', 15000.00, 'aktif', 34, 34, '2026-09-04 07:07:46', '2026-09-04 07:07:46', NULL),
(130, 'Tampaksiring01', 'Ikan dori', 'Kg', 54000.00, 'aktif', 34, 34, '2026-09-09 20:53:38', '2026-09-09 20:58:33', NULL),
(131, 'Tampaksiring01', 'Jahe', 'Kg', 15000.00, 'aktif', 34, 34, '2026-10-13 18:14:44', '2026-10-13 18:14:44', NULL),
(132, 'Tampaksiring01', 'Daging Bebek', 'Kg', 43000.00, 'aktif', 34, 34, '2026-10-22 20:51:06', '2026-10-22 20:54:29', NULL),
(133, 'Pandak01', 'Daging Bebek', 'Kg', 0.00, 'aktif', 34, 34, '2026-10-22 21:43:34', '2026-10-22 21:43:34', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `master_bahan_harga`
--

CREATE TABLE `master_bahan_harga` (
  `id` int(11) NOT NULL,
  `bahan_id` int(11) NOT NULL,
  `harga_lama` decimal(15,2) NOT NULL DEFAULT 0.00,
  `harga_baru` decimal(15,2) NOT NULL DEFAULT 0.00,
  `diubah_oleh` int(11) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `master_bahan_harga`
--

INSERT INTO `master_bahan_harga` (`id`, `bahan_id`, `harga_lama`, `harga_baru`, `diubah_oleh`, `keterangan`, `created_at`) VALUES
(1, 29, 0.00, 13500.00, 34, 'Perubahan harga oleh Koperasi', '2026-09-04 05:12:52'),
(2, 13, 0.00, 15000.00, 34, 'Perubahan harga oleh Koperasi', '2026-09-04 05:13:12'),
(3, 13, 15000.00, 15500.00, 34, 'Perubahan harga oleh Koperasi', '2026-09-04 05:29:26'),
(4, 18, 0.00, 35000.00, 34, 'Perubahan harga oleh Koperasi', '2026-09-04 14:59:39'),
(5, 19, 0.00, 110000.00, 34, 'Perubahan harga oleh Koperasi', '2026-09-04 15:00:08'),
(6, 130, 0.00, 54000.00, 34, 'Perubahan harga oleh Koperasi', '2026-09-09 20:58:33'),
(7, 19, 110000.00, 95000.00, 34, 'Perubahan harga oleh Koperasi', '2026-09-09 20:59:23'),
(8, 23, 0.00, 35000.00, 34, 'Perubahan harga oleh Koperasi', '2026-10-09 20:28:12'),
(9, 17, 0.00, 5000.00, 34, 'Import Excel oleh Koperasi', '2026-10-13 18:14:44'),
(10, 16, 0.00, 12000.00, 34, 'Import Excel oleh Koperasi', '2026-10-13 18:14:44'),
(11, 20, 0.00, 35000.00, 34, 'Import Excel oleh Koperasi', '2026-10-13 18:14:44'),
(12, 132, 0.00, 40000.00, 34, 'Perubahan harga oleh Koperasi', '2026-10-22 20:51:51'),
(13, 132, 40000.00, 43000.00, 34, 'Import Excel oleh Koperasi', '2026-10-22 20:54:29'),
(14, 125, 0.00, 15000.00, 34, 'Import Excel oleh Koperasi', '2026-10-22 20:54:29'),
(15, 123, 0.00, 20000.00, 34, 'Import Excel oleh Koperasi', '2026-10-22 20:54:29'),
(16, 27, 0.00, 120000.00, 34, 'Import Excel oleh Koperasi', '2026-10-22 20:54:29'),
(17, 14, 0.00, 28000.00, 34, 'Import Excel oleh Koperasi', '2026-10-22 20:54:29');

-- --------------------------------------------------------

--
-- Struktur dari tabel `master_jenis_dokumen_supplier`
--

CREATE TABLE `master_jenis_dokumen_supplier` (
  `id` int(11) UNSIGNED NOT NULL,
  `nama_jenis` varchar(100) NOT NULL,
  `status` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `keterangan` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `master_jenis_dokumen_supplier`
--

INSERT INTO `master_jenis_dokumen_supplier` (`id`, `nama_jenis`, `status`, `keterangan`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'NIB', 'aktif', NULL, NULL, '2026-09-19 06:41:38', '2026-09-19 06:41:38'),
(2, 'NPWP', 'aktif', NULL, NULL, '2026-09-19 06:41:38', '2026-09-19 06:41:38'),
(3, 'KTP PIC', 'aktif', NULL, NULL, '2026-09-19 06:41:38', '2026-09-19 06:41:38'),
(4, 'Akta/Legalitas', 'aktif', NULL, NULL, '2026-09-19 06:41:38', '2026-09-19 06:41:38'),
(5, 'Surat Kerja Sama / MOU', 'aktif', NULL, NULL, '2026-09-19 06:41:38', '2026-09-19 06:41:38'),
(6, 'Sertifikat', 'aktif', NULL, NULL, '2026-09-19 06:41:38', '2026-09-19 06:41:38'),
(7, 'Dokumen Rekening', 'aktif', NULL, NULL, '2026-09-19 06:41:38', '2026-09-19 06:41:38'),
(8, 'Dokumen Lainnya', 'aktif', NULL, NULL, '2026-09-19 06:41:38', '2026-09-19 06:41:38');

-- --------------------------------------------------------

--
-- Struktur dari tabel `master_jenis_kegiatan`
--

CREATE TABLE `master_jenis_kegiatan` (
  `id` int(11) NOT NULL,
  `nama_kegiatan` varchar(100) NOT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `warna` varchar(20) NOT NULL DEFAULT 'primary',
  `urutan` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `master_jenis_kegiatan`
--

INSERT INTO `master_jenis_kegiatan` (`id`, `nama_kegiatan`, `icon`, `warna`, `urutan`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Perencanaan Menu', 'bi-calendar2-check', 'primary', 1, 1, '2026-06-27 14:30:45', '2026-06-27 14:57:09'),
(2, 'Penghitungan Kebutuhan Bahan', 'bi-calculator', 'secondary', 2, 1, '2026-06-27 14:30:45', '2026-06-27 14:59:43'),
(3, 'Monitoring Produksi', 'bi-clipboard-check', 'success', 3, 1, '2026-06-27 14:30:45', '2026-06-27 14:59:43'),
(4, 'Monitoring Distribusi', 'bi-truck', 'info', 4, 1, '2026-06-27 14:30:45', '2026-06-27 14:59:43'),
(5, 'Monitoring Konsumsi', 'bi-emoji-smile', 'warning', 5, 1, '2026-06-27 14:30:45', '2026-06-27 14:59:43'),
(6, 'Monitoring Higiene Sanitasi', 'bi-shield-check', 'dark', 6, 1, '2026-06-27 14:30:45', '2026-06-27 14:59:43'),
(7, 'Monitoring Sisa Makanan', 'bi-trash3', 'danger', 7, 1, '2026-06-27 14:30:45', '2026-06-27 14:59:43'),
(8, 'Konsultasi Gizi', 'bi-heart-pulse', 'danger', 8, 1, '2026-06-27 14:30:45', '2026-06-27 14:59:43'),
(9, 'Edukasi Gizi', 'bi-book', 'primary', 9, 1, '2026-06-27 14:30:45', '2026-06-27 14:57:09'),
(10, 'Pelatihan', 'bi-people', 'success', 10, 1, '2026-06-27 14:30:45', '2026-06-27 14:59:43'),
(11, 'Koordinasi', 'bi-chat-dots', 'secondary', 11, 1, '2026-06-27 14:30:45', '2026-06-27 14:59:43'),
(12, 'Monitoring & Evaluasi', 'bi-graph-up-arrow', 'warning', 12, 1, '2026-06-27 14:30:45', '2026-06-27 14:59:43'),
(13, 'Quality Control', 'bi-award', 'info', 13, 1, '2026-06-27 14:30:45', '2026-06-27 14:59:43'),
(14, 'Food Safety', 'bi-shield-fill-check', 'dark', 14, 1, '2026-06-27 14:30:45', '2026-06-27 14:59:43'),
(15, 'Lainnya', 'bi-three-dots', 'secondary', 99, 1, '2026-06-27 14:30:45', '2026-06-27 14:59:43');

-- --------------------------------------------------------

--
-- Struktur dari tabel `master_satuan`
--

CREATE TABLE `master_satuan` (
  `id` int(11) NOT NULL,
  `nama_satuan` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `menu_gizi`
--

CREATE TABLE `menu_gizi` (
  `id` int(11) NOT NULL,
  `menu_induk_id` int(11) DEFAULT NULL,
  `is_varian` tinyint(1) NOT NULL DEFAULT 0,
  `id_sppg` varchar(20) NOT NULL,
  `nama_menu` varchar(200) NOT NULL,
  `catatan` text DEFAULT NULL,
  `foto_menu` varchar(225) DEFAULT NULL,
  `kategori` varchar(50) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `menu_gizi`
--

INSERT INTO `menu_gizi` (`id`, `menu_induk_id`, `is_varian`, `id_sppg`, `nama_menu`, `catatan`, `foto_menu`, `kategori`, `created_by`, `created_at`, `updated_at`) VALUES
(13, NULL, 0, 'Tampaksiring01', 'Nasi Ayam Saus padang', 'Makanan Normal', '1787587890_e988be34539c5a4114ca.jpeg', 'makanan_utama', 15, '2026-08-24 15:37:17', '2026-08-24 16:16:24'),
(14, NULL, 0, 'Tampaksiring01', 'Nasi ikan kerapu saus tiram', 'Bagian menu selain ayam', NULL, 'makanan_utama', 15, '2026-08-25 02:44:47', '2026-08-25 02:44:47'),
(15, 13, 1, 'Tampaksiring01', 'Kentang Ayam Saus padang - Varian', 'Makanan Normal', '1787812360_d341fd2f438b2503508f.jpeg', 'makanan_utama', 15, '2026-08-27 13:31:45', '2026-08-27 13:32:40'),
(16, NULL, 0, 'Tampaksiring01', 'Sayur asem ikan asin', 'Menu sederhana', NULL, 'makanan_utama', 15, '2026-08-27 16:38:55', '2026-08-27 16:38:55'),
(17, NULL, 0, 'Tampaksiring01', 'Nasi Ayam Teriyaki', '', NULL, 'makanan_utama', 15, '2026-10-22 20:40:27', '2026-10-22 20:40:27'),
(18, 13, 1, 'Tampaksiring01', 'Nasi Ayam Goreng Suir', 'Makanan Alergi', 'a5c93384acc1ea3972b4.jpeg', 'makanan_utama', 15, '2026-10-22 20:41:56', '2026-10-22 20:41:56');

-- --------------------------------------------------------

--
-- Struktur dari tabel `menu_komposisi`
--

CREATE TABLE `menu_komposisi` (
  `id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `jenis` enum('karbohidrat','protein_nabati','protein_hewani','sayuran','buah','other') NOT NULL,
  `nama_item` varchar(200) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `menu_komposisi`
--

INSERT INTO `menu_komposisi` (`id`, `menu_id`, `jenis`, `nama_item`, `created_at`) VALUES
(89, 13, 'karbohidrat', 'Nasi Putih', '2026-08-24 16:16:24'),
(90, 13, 'protein_nabati', 'Tempe Orek', '2026-08-24 16:16:24'),
(91, 13, 'protein_hewani', 'Ayam bumbu saus padang', '2026-08-24 16:16:24'),
(92, 13, 'sayuran', 'Capcai', '2026-08-24 16:16:24'),
(93, 13, 'buah', 'Jeruk', '2026-08-24 16:16:24'),
(94, 13, 'other', 'Susu', '2026-08-24 16:16:24'),
(95, 14, 'karbohidrat', 'Nasi Putih', '2026-08-25 02:44:47'),
(96, 14, 'protein_nabati', 'Tahu Goreng Balado', '2026-08-25 02:44:47'),
(97, 14, 'protein_hewani', 'Ikan Kerapu Saus Tiram', '2026-08-25 02:44:47'),
(98, 14, 'sayuran', 'Sayur Sop', '2026-08-25 02:44:47'),
(99, 14, 'buah', 'Semangka', '2026-08-25 02:44:47'),
(100, 14, 'other', 'Kentang Krispi', '2026-08-25 02:44:47'),
(107, 15, 'karbohidrat', 'Kentang rebus', '2026-08-27 06:32:40'),
(108, 15, 'protein_nabati', 'Tempe Orek', '2026-08-27 06:32:40'),
(109, 15, 'protein_hewani', 'Ayam bumbu saus padang', '2026-08-27 06:32:40'),
(110, 15, 'sayuran', 'Capcai', '2026-08-27 06:32:40'),
(111, 15, 'buah', 'Jeruk', '2026-08-27 06:32:40'),
(112, 15, 'other', 'Susu', '2026-08-27 06:32:40'),
(113, 16, 'karbohidrat', 'Nasi putih', '2026-08-27 09:38:55'),
(114, 16, 'protein_nabati', 'Tahu', '2026-08-27 09:38:55'),
(115, 16, 'protein_hewani', 'Ikan asin', '2026-08-27 09:38:55'),
(116, 16, 'sayuran', 'Sayur asem', '2026-08-27 09:38:55'),
(117, 16, 'buah', 'Kelengkeng', '2026-08-27 09:38:55'),
(118, 16, 'other', 'Kerupuk', '2026-08-27 09:38:55'),
(119, 17, 'karbohidrat', 'Nasi Putih', '2026-10-22 13:40:27'),
(120, 17, 'protein_nabati', 'Tahu', '2026-10-22 13:40:27'),
(121, 17, 'protein_hewani', 'Ayam Bumbu Teriyaki', '2026-10-22 13:40:27'),
(122, 17, 'sayuran', 'wortel dan Jagung', '2026-10-22 13:40:27'),
(123, 17, 'buah', 'Pisang', '2026-10-22 13:40:27'),
(124, 17, 'other', 'Kerupuk', '2026-10-22 13:40:27'),
(125, 18, 'karbohidrat', 'Nasi Putih', '2026-10-22 13:41:56'),
(126, 18, 'protein_nabati', 'Tempe Orek', '2026-10-22 13:41:56'),
(127, 18, 'protein_hewani', 'Ayam Goreng Suir', '2026-10-22 13:41:56'),
(128, 18, 'sayuran', 'Kangkung', '2026-10-22 13:41:56'),
(129, 18, 'buah', 'Jeruk', '2026-10-22 13:41:56'),
(130, 18, 'other', 'Susu', '2026-10-22 13:41:56');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2026-06-10-162922', 'App\\Database\\Migrations\\CreateKegiatanAslap', 'default', 'App', 1781109168, 1),
(2, '2026-06-10-163158', 'App\\Database\\Migrations\\CreateKegiatanAslapFoto', 'default', 'App', 1781109168, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `penerima_manfaat`
--

CREATE TABLE `penerima_manfaat` (
  `id` int(11) NOT NULL,
  `id_sppg` varchar(20) NOT NULL,
  `sekolah_nama` varchar(200) NOT NULL,
  `sekolah_alamat` text NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `sub_kategori` varchar(100) DEFAULT NULL,
  `porsi_besar` int(11) DEFAULT 0,
  `porsi_kecil` int(11) DEFAULT 0,
  `total_siswa` int(11) DEFAULT 0,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `penerima_manfaat`
--

INSERT INTO `penerima_manfaat` (`id`, `id_sppg`, `sekolah_nama`, `sekolah_alamat`, `kategori`, `sub_kategori`, `porsi_besar`, `porsi_kecil`, `total_siswa`, `created_by`, `created_at`, `updated_at`) VALUES
(15, 'Tampaksiring01', 'Posyanu Matahari', 'Jl. Suka makmur', 'B3', NULL, 38, 23, 61, 17, '2026-08-23 13:17:32', '2026-08-23 13:21:59'),
(16, 'Tampaksiring01', 'Sekolah Al-Mukhlisin', 'Jl. Cilandak', 'Peserta Didik', NULL, 193, 223, 416, 17, '2026-08-23 13:22:54', '2026-08-23 13:48:44'),
(18, 'Tampaksiring01', 'SMA 123 Bojonegoro', 'Jalan Bojone', 'Peserta Didik', NULL, 49, 0, 49, 17, '2026-08-23 14:22:22', '2026-08-23 14:45:29'),
(19, 'Tampaksiring01', 'Pon-pes serbaguna', 'jl serbaguna', 'Peserta Didik', NULL, 200, 90, 290, 17, '2026-08-23 17:36:48', '2026-08-23 17:41:40'),
(20, 'Tampaksiring01', 'Yayasan bakti', 'jl bakti', 'Peserta Didik', NULL, 0, 30, 30, 17, '2026-08-23 19:37:08', '2026-08-23 19:39:48'),
(21, 'Pandak02', 'SMA 1 Purwakarta', 'Jl. Purwakarta Permai', 'Peserta Didik', NULL, 2, 2, 4, 32, '2026-09-01 10:41:28', '2026-09-01 10:42:11'),
(22, 'Tampaksiring01', 'SDN 2 Purbalingga', 'JL. saharjo', 'Peserta Didik', NULL, 195, 237, 432, 17, '2026-10-22 20:31:08', '2026-10-22 20:36:11');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengeluaran_aslap`
--

CREATE TABLE `pengeluaran_aslap` (
  `id` int(11) NOT NULL,
  `id_sppg` varchar(100) NOT NULL,
  `tanggal` date NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `uraian` text DEFAULT NULL,
  `nominal` decimal(15,2) NOT NULL DEFAULT 0.00,
  `metode_pembayaran` varchar(50) DEFAULT NULL,
  `foto_bukti` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengeluaran_aslap`
--

INSERT INTO `pengeluaran_aslap` (`id`, `id_sppg`, `tanggal`, `kategori`, `uraian`, `nominal`, `metode_pembayaran`, `foto_bukti`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Tampaksiring01', '2026-06-13', 'BBM', 'Bensin', 150000.00, 'Tunai', '6a2d59aa93917.jpg', 17, '2026-06-13 13:22:51', '2026-06-13 13:22:51'),
(2, 'Tampaksiring01', '2026-06-05', 'Parkir', 'Parkir di mall', 3000.00, 'Tunai', NULL, 17, '2026-06-17 20:52:25', '2026-06-17 20:52:25');

-- --------------------------------------------------------

--
-- Struktur dari tabel `petty_cash`
--

CREATE TABLE `petty_cash` (
  `id` int(11) NOT NULL,
  `id_sppg` varchar(20) NOT NULL,
  `tanggal` date NOT NULL,
  `jenis` enum('pemasukan','pengeluaran') NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `bukti_file` varchar(255) DEFAULT NULL,
  `jumlah` decimal(15,2) NOT NULL DEFAULT 0.00,
  `saldo_akhir` decimal(15,2) NOT NULL DEFAULT 0.00,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `petty_cash`
--

INSERT INTO `petty_cash` (`id`, `id_sppg`, `tanggal`, `jenis`, `kategori`, `deskripsi`, `bukti_file`, `jumlah`, `saldo_akhir`, `created_by`, `created_at`) VALUES
(1, 'Tampaksiring01', '2026-10-14', 'pemasukan', 'Uang Masuk', NULL, NULL, 5000000.00, 5000000.00, 16, '2026-10-14 08:53:44'),
(2, 'Tampaksiring01', '2026-10-14', 'pengeluaran', 'ATK', 'Kertas 1 rim, pensil 5, pulpen 5', NULL, 60000.00, 4940000.00, 16, '2026-10-14 10:10:24'),
(4, 'Tampaksiring01', '2026-10-14', 'pengeluaran', 'makanan', 'permen', NULL, 15000.00, 4925000.00, 16, '2026-10-14 10:11:38'),
(5, 'Tampaksiring01', '2026-10-15', 'pemasukan', 'Uang masuk', 'uang masuk', NULL, 4000000.00, 8925000.00, 16, '2026-10-14 10:12:33');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pm_jenjang`
--

CREATE TABLE `pm_jenjang` (
  `id` int(11) NOT NULL,
  `pm_id` int(11) NOT NULL,
  `jenjang` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pm_jenjang`
--

INSERT INTO `pm_jenjang` (`id`, `pm_id`, `jenjang`, `created_at`, `updated_at`) VALUES
(10, 15, 'Balita', '2026-08-23 13:17:52', '2026-08-23 13:17:52'),
(11, 15, 'Ibu Hamil', '2026-08-23 13:17:59', '2026-08-23 13:17:59'),
(12, 15, 'Ibu Menyusui', '2026-08-23 13:18:04', '2026-08-23 13:18:04'),
(13, 15, 'Sampel', '2026-08-23 13:18:17', '2026-08-23 13:18:17'),
(14, 16, 'PAUD', '2026-08-23 13:23:03', '2026-08-23 13:23:03'),
(15, 16, 'SD', '2026-08-23 13:24:00', '2026-08-23 13:24:00'),
(16, 16, 'Sampel', '2026-08-23 13:27:43', '2026-08-23 13:27:43'),
(18, 16, 'SMP', '2026-08-23 13:30:18', '2026-08-23 13:30:18'),
(21, 18, 'SMA/SMK', '2026-08-23 14:22:33', '2026-08-23 14:22:33'),
(22, 19, 'SD', '2026-08-23 17:36:57', '2026-08-23 17:36:57'),
(23, 19, 'SMP', '2026-08-23 17:37:03', '2026-08-23 17:37:03'),
(24, 19, 'SMA/SMK', '2026-08-23 17:37:10', '2026-08-23 17:37:10'),
(25, 20, 'SD', '2026-08-23 19:39:10', '2026-08-23 19:39:10'),
(26, 20, 'SMP', '2026-08-23 19:39:16', '2026-08-23 19:39:16'),
(27, 20, 'SMA/SMK', '2026-08-23 19:39:22', '2026-08-23 19:39:22'),
(28, 21, 'SMA/SMK', '2026-09-01 10:41:38', '2026-09-01 10:41:38'),
(29, 21, 'Sampel', '2026-09-01 10:41:48', '2026-09-01 10:41:48'),
(30, 22, 'SD', '2026-10-22 20:31:17', '2026-10-22 20:31:17'),
(31, 22, 'Sampel', '2026-10-22 20:35:53', '2026-10-22 20:35:53');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pm_kelas`
--

CREATE TABLE `pm_kelas` (
  `id` int(11) NOT NULL,
  `pm_id` int(11) NOT NULL,
  `jenjang_id` int(11) DEFAULT NULL,
  `nama_kelas` varchar(100) NOT NULL,
  `jumlah_siswa` int(11) NOT NULL DEFAULT 0,
  `jumlah_alergi` int(11) DEFAULT 0,
  `catatan_alergi` text DEFAULT NULL,
  `porsi` enum('besar','kecil') NOT NULL DEFAULT 'kecil',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pm_kelas`
--

INSERT INTO `pm_kelas` (`id`, `pm_id`, `jenjang_id`, `nama_kelas`, `jumlah_siswa`, `jumlah_alergi`, `catatan_alergi`, `porsi`, `created_at`) VALUES
(39, 15, 10, 'Penerima', 21, 2, '1 alergi telur, 1 alergi terasi', 'kecil', '2026-08-23 06:19:22'),
(40, 15, 11, 'Penerima', 5, 0, '', 'besar', '2026-08-23 06:20:16'),
(41, 15, 12, 'Penerima', 30, 3, '1 alergi ayam, 1 alergi kecap, 1 alergi kunyit', 'besar', '2026-08-23 06:21:33'),
(42, 15, 13, 'Porsi Besar', 3, 0, '', 'besar', '2026-08-23 06:21:52'),
(43, 15, 13, 'Porsi Kecil', 2, 0, '', 'kecil', '2026-08-23 06:21:59'),
(44, 16, 14, 'Penerima', 55, 0, '1 alergi udang', 'kecil', '2026-08-23 06:23:32'),
(45, 16, 14, 'Guru/Staf', 3, 0, '', 'besar', '2026-08-23 06:23:42'),
(46, 16, 15, 'Kelas 1', 60, 1, '1 alergi micin', 'kecil', '2026-08-23 06:24:39'),
(47, 16, 15, 'Kelas 2', 58, 0, '', 'kecil', '2026-08-23 06:24:51'),
(48, 16, 15, 'Kelas 3', 40, 2, '2 alergi udang', 'kecil', '2026-08-23 06:25:17'),
(49, 16, 15, 'Kelas 4', 50, 2, '2 alergi susu', 'besar', '2026-08-23 06:25:41'),
(50, 16, 15, 'Kelas 5', 40, 0, '', 'besar', '2026-08-23 06:26:00'),
(51, 16, 15, 'Kelas 6', 30, 3, '1 alergi kacang, 2 alergi jamur', 'besar', '2026-08-23 06:26:55'),
(52, 16, 15, 'Guru/Staf', 25, 0, '', 'besar', '2026-08-23 06:27:14'),
(53, 16, 16, 'Porsi Besar', 10, 0, '', 'besar', '2026-08-23 06:27:55'),
(54, 16, 16, 'Porsi Kecil', 10, 0, '', 'kecil', '2026-08-23 06:28:02'),
(57, 16, 18, 'Guru/Staf', 35, 0, '', 'besar', '2026-08-23 06:48:44'),
(61, 18, 21, 'Kelas 11', 24, 0, '', 'besar', '2026-08-23 07:41:19'),
(62, 18, 21, 'Kelas 12', 10, 0, '', 'besar', '2026-08-23 07:41:44'),
(63, 18, 21, 'Kelas 10', 15, 1, '1 alergi kue', 'besar', '2026-08-23 07:45:29'),
(64, 19, 22, 'Kelas 1', 30, 3, '3 Alergi Udang', 'kecil', '2026-08-23 10:37:39'),
(65, 19, 22, 'Kelas 2', 30, 1, '1 alergi susu', 'kecil', '2026-08-23 10:38:01'),
(66, 19, 22, 'Kelas 3', 30, 0, '', 'kecil', '2026-08-23 10:38:15'),
(67, 19, 22, 'Kelas 4', 30, 1, '1 alergi kunyit', 'besar', '2026-08-23 10:38:37'),
(69, 19, 22, 'Kelas 5', 30, 1, '1 Alergi susu', 'besar', '2026-08-23 10:39:07'),
(70, 19, 22, 'Kelas 6', 30, 0, '', 'besar', '2026-08-23 10:39:40'),
(71, 19, 22, 'Guru/Staf', 30, 0, '', 'besar', '2026-08-23 10:40:06'),
(72, 19, 24, 'Kelas 11', 30, 0, '', 'besar', '2026-08-23 10:40:39'),
(73, 19, 23, 'Kelas 9', 30, 0, '', 'besar', '2026-08-23 10:40:55'),
(74, 19, 23, 'Kelas 7', 20, 0, '', 'besar', '2026-08-23 10:41:40'),
(75, 20, 25, 'Kelas 1', 30, 1, '1 alergi susu', 'kecil', '2026-08-23 12:39:48'),
(76, 21, 29, 'Porsi Besar', 2, 0, '', 'besar', '2026-09-01 03:42:03'),
(77, 21, 29, 'Porsi Kecil', 2, 0, '', 'kecil', '2026-09-01 03:42:11'),
(78, 22, 30, 'Kelas 1', 90, 3, '1 susu, 2 kacang', 'kecil', '2026-10-22 13:31:59'),
(79, 22, 30, 'Kelas 2', 85, 5, '2 susu, 3 udang', 'kecil', '2026-10-22 13:32:25'),
(80, 22, 30, 'Kelas 3', 60, 0, '', 'kecil', '2026-10-22 13:32:38'),
(81, 22, 30, 'Kelas 4', 50, 3, '1 kedelai, 1 tepung, 1 nanas', 'besar', '2026-10-22 13:34:19'),
(82, 22, 30, 'Kelas 5', 70, 6, '3 susu, 3 udang', 'besar', '2026-10-22 13:35:02'),
(83, 22, 30, 'Kelas 6', 53, 0, '', 'besar', '2026-10-22 13:35:16'),
(84, 22, 30, 'Guru/Staf', 20, 0, '', 'besar', '2026-10-22 13:35:34'),
(85, 22, 31, 'Porsi Besar', 2, 0, '', 'besar', '2026-10-22 13:36:03'),
(86, 22, 31, 'Porsi Kecil', 2, 0, '', 'kecil', '2026-10-22 13:36:11');

-- --------------------------------------------------------

--
-- Struktur dari tabel `relawan`
--

CREATE TABLE `relawan` (
  `id` int(11) NOT NULL,
  `id_sppg` varchar(20) NOT NULL,
  `nama_lengkap` varchar(200) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `divisi` varchar(100) NOT NULL,
  `jabatan` varchar(100) NOT NULL,
  `salary_per_hari` decimal(15,2) NOT NULL DEFAULT 0.00,
  `tgl_mulai_kontrak` date NOT NULL,
  `tgl_akhir_kontrak` date NOT NULL,
  `status` enum('aktif','nonaktif','habis_kontrak') DEFAULT 'aktif',
  `foto_path` varchar(500) DEFAULT NULL,
  `pkwt_1_path` varchar(500) DEFAULT NULL,
  `pkwt_2_path` varchar(500) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `rencana_menu`
--

CREATE TABLE `rencana_menu` (
  `id` int(11) NOT NULL,
  `id_sppg` varchar(20) NOT NULL,
  `tanggal` date NOT NULL,
  `status` enum('draft','ditetapkan','dibatalkan') NOT NULL DEFAULT 'draft',
  `catatan` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `ditetapkan_at` timestamp NULL DEFAULT NULL,
  `ditetapkan_by` int(11) DEFAULT NULL,
  `dibatalkan_at` timestamp NULL DEFAULT NULL,
  `dibatalkan_by` int(11) DEFAULT NULL,
  `alasan_pembatalan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `rencana_menu`
--

INSERT INTO `rencana_menu` (`id`, `id_sppg`, `tanggal`, `status`, `catatan`, `created_by`, `ditetapkan_at`, `ditetapkan_by`, `dibatalkan_at`, `dibatalkan_by`, `alasan_pembatalan`, `created_at`, `updated_at`) VALUES
(1, 'Tampaksiring01', '2026-08-25', 'ditetapkan', NULL, 15, NULL, NULL, NULL, NULL, NULL, '2026-08-25 22:22:54', '2026-08-27 16:31:13'),
(2, 'Tampaksiring01', '2026-08-26', 'ditetapkan', 'buat menu pertama', 15, NULL, NULL, NULL, NULL, NULL, '2026-08-25 22:27:42', '2026-08-27 13:37:36'),
(3, 'Tampaksiring01', '2026-08-27', 'ditetapkan', NULL, 15, NULL, NULL, NULL, NULL, NULL, '2026-08-27 16:32:26', '2026-08-27 16:39:40'),
(4, 'Tampaksiring01', '2026-08-29', 'dibatalkan', 'Sayur asem', 15, NULL, NULL, '2026-08-30 20:50:39', 15, 'Karena ikan asinnya tidak asin', '2026-08-27 16:42:05', '2026-08-30 20:50:39'),
(5, 'Tampaksiring01', '2026-08-29', 'ditetapkan', 'Pengganti', 15, '2026-08-31 05:47:29', 15, NULL, NULL, NULL, '2026-08-31 05:43:50', '2026-08-31 05:47:29'),
(7, 'Tampaksiring01', '2026-10-26', 'ditetapkan', NULL, 15, '2026-10-22 20:46:55', 15, NULL, NULL, NULL, '2026-10-22 20:46:06', '2026-10-22 20:46:55');

-- --------------------------------------------------------

--
-- Struktur dari tabel `rencana_menu_detail`
--

CREATE TABLE `rencana_menu_detail` (
  `id` int(11) NOT NULL,
  `rencana_menu_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `jenis_penggunaan` enum('normal','alergi') NOT NULL DEFAULT 'normal',
  `catatan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `rencana_menu_detail`
--

INSERT INTO `rencana_menu_detail` (`id`, `rencana_menu_id`, `menu_id`, `jenis_penggunaan`, `catatan`, `created_at`, `updated_at`) VALUES
(1, 1, 13, 'normal', 'untuk yang tidak suka ikan', '2026-08-25 22:22:54', '2026-08-25 22:22:54'),
(2, 1, 14, 'alergi', 'untuk yang engga suka ayam', '2026-08-25 22:22:54', '2026-08-25 22:22:54'),
(3, 2, 13, 'alergi', 'normal', '2026-08-25 22:27:42', '2026-08-25 22:27:42'),
(4, 2, 14, 'normal', 'normal', '2026-08-25 22:27:42', '2026-08-25 22:27:42'),
(5, 2, 15, 'alergi', NULL, '2026-08-27 13:34:56', '2026-08-27 13:34:56'),
(6, 1, 15, 'alergi', NULL, '2026-08-27 16:30:40', '2026-08-27 16:30:40'),
(7, 3, 13, 'normal', NULL, '2026-08-27 16:32:26', '2026-08-27 16:32:26'),
(8, 3, 14, 'alergi', NULL, '2026-08-27 16:32:26', '2026-08-27 16:32:26'),
(9, 4, 16, 'normal', NULL, '2026-08-27 16:42:05', '2026-08-27 16:42:05'),
(10, 4, 13, 'alergi', NULL, '2026-08-27 16:42:05', '2026-08-27 16:42:05'),
(11, 4, 14, 'alergi', NULL, '2026-08-27 16:42:05', '2026-08-27 16:42:05'),
(12, 5, 13, 'normal', NULL, '2026-08-31 05:43:50', '2026-08-31 05:43:50'),
(13, 5, 16, 'alergi', NULL, '2026-08-31 05:43:50', '2026-08-31 05:43:50'),
(16, 7, 17, 'normal', NULL, '2026-10-22 20:46:06', '2026-10-22 20:46:06'),
(17, 7, 14, 'alergi', NULL, '2026-10-22 20:46:06', '2026-10-22 20:46:06'),
(18, 7, 16, 'alergi', NULL, '2026-10-22 20:46:06', '2026-10-22 20:46:06'),
(19, 7, 18, 'alergi', NULL, '2026-10-22 20:46:06', '2026-10-22 20:46:06');

-- --------------------------------------------------------

--
-- Struktur dari tabel `rencana_menu_penerima`
--

CREATE TABLE `rencana_menu_penerima` (
  `id` int(11) NOT NULL,
  `rencana_menu_id` int(11) NOT NULL,
  `pm_id` int(11) DEFAULT NULL,
  `sekolah_nama` varchar(200) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `sub_kategori` varchar(100) DEFAULT NULL,
  `porsi_besar` int(11) NOT NULL DEFAULT 0,
  `porsi_kecil` int(11) NOT NULL DEFAULT 0,
  `total_pm` int(11) NOT NULL DEFAULT 0,
  `jumlah_alergi` int(11) NOT NULL DEFAULT 0,
  `catatan_alergi` text DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `rencana_menu_penerima`
--

INSERT INTO `rencana_menu_penerima` (`id`, `rencana_menu_id`, `pm_id`, `sekolah_nama`, `kategori`, `sub_kategori`, `porsi_besar`, `porsi_kecil`, `total_pm`, `jumlah_alergi`, `catatan_alergi`, `catatan`, `created_at`, `updated_at`) VALUES
(1, 2, 19, 'Pon-pes serbaguna', 'Peserta Didik', NULL, 200, 90, 290, 6, 'Kelas 1: 3 Alergi Udang | Kelas 2: 1 alergi susu | Kelas 4: 1 alergi kunyit | Kelas 5: 1 Alergi susu', NULL, '2026-08-27 13:34:56', '2026-08-27 13:34:56'),
(2, 2, 15, 'Posyanu Matahari', 'B3', NULL, 38, 23, 61, 5, 'Penerima: 1 alergi telur, 1 alergi terasi | Penerima: 1 alergi ayam, 1 alergi kecap, 1 alergi kunyit', NULL, '2026-08-27 13:34:56', '2026-08-27 13:34:56'),
(3, 2, 16, 'Sekolah Al-Mukhlisin', 'Peserta Didik', NULL, 193, 223, 416, 8, 'Kelas 1: 1 alergi micin | Kelas 3: 2 alergi udang | Kelas 4: 2 alergi susu | Kelas 6: 1 alergi kacang, 2 alergi jamur', NULL, '2026-08-27 13:34:56', '2026-08-27 13:34:56'),
(4, 2, 18, 'SMA 123 Bojonegoro', 'Peserta Didik', NULL, 49, 0, 49, 1, 'Kelas 10: 1 alergi kue', NULL, '2026-08-27 13:34:56', '2026-08-27 13:34:56'),
(5, 2, 20, 'Yayasan bakti', 'Peserta Didik', NULL, 0, 30, 30, 1, 'Kelas 1: 1 alergi susu', NULL, '2026-08-27 13:34:56', '2026-08-27 13:34:56'),
(11, 1, 19, 'Pon-pes serbaguna', 'Peserta Didik', NULL, 200, 90, 290, 6, 'Kelas 1: 3 Alergi Udang | Kelas 2: 1 alergi susu | Kelas 4: 1 alergi kunyit | Kelas 5: 1 Alergi susu', NULL, '2026-08-27 16:30:40', '2026-08-27 16:30:40'),
(12, 1, 15, 'Posyanu Matahari', 'B3', NULL, 38, 23, 61, 5, 'Penerima: 1 alergi telur, 1 alergi terasi | Penerima: 1 alergi ayam, 1 alergi kecap, 1 alergi kunyit', NULL, '2026-08-27 16:30:40', '2026-08-27 16:30:40'),
(13, 1, 16, 'Sekolah Al-Mukhlisin', 'Peserta Didik', NULL, 193, 223, 416, 8, 'Kelas 1: 1 alergi micin | Kelas 3: 2 alergi udang | Kelas 4: 2 alergi susu | Kelas 6: 1 alergi kacang, 2 alergi jamur', NULL, '2026-08-27 16:30:40', '2026-08-27 16:30:40'),
(14, 1, 18, 'SMA 123 Bojonegoro', 'Peserta Didik', NULL, 49, 0, 49, 1, 'Kelas 10: 1 alergi kue', NULL, '2026-08-27 16:30:40', '2026-08-27 16:30:40'),
(15, 1, 20, 'Yayasan bakti', 'Peserta Didik', NULL, 0, 30, 30, 1, 'Kelas 1: 1 alergi susu', NULL, '2026-08-27 16:30:40', '2026-08-27 16:30:40'),
(16, 3, 19, 'Pon-pes serbaguna', 'Peserta Didik', NULL, 200, 90, 290, 6, 'Kelas 1: 3 Alergi Udang | Kelas 2: 1 alergi susu | Kelas 4: 1 alergi kunyit | Kelas 5: 1 Alergi susu', NULL, '2026-08-27 16:32:26', '2026-08-27 16:32:26'),
(17, 3, 15, 'Posyanu Matahari', 'B3', NULL, 38, 23, 61, 5, 'Penerima: 1 alergi telur, 1 alergi terasi | Penerima: 1 alergi ayam, 1 alergi kecap, 1 alergi kunyit', NULL, '2026-08-27 16:32:26', '2026-08-27 16:32:26'),
(18, 3, 16, 'Sekolah Al-Mukhlisin', 'Peserta Didik', NULL, 193, 223, 416, 8, 'Kelas 1: 1 alergi micin | Kelas 3: 2 alergi udang | Kelas 4: 2 alergi susu | Kelas 6: 1 alergi kacang, 2 alergi jamur', NULL, '2026-08-27 16:32:26', '2026-08-27 16:32:26'),
(19, 3, 18, 'SMA 123 Bojonegoro', 'Peserta Didik', NULL, 49, 0, 49, 1, 'Kelas 10: 1 alergi kue', NULL, '2026-08-27 16:32:26', '2026-08-27 16:32:26'),
(20, 3, 20, 'Yayasan bakti', 'Peserta Didik', NULL, 0, 30, 30, 1, 'Kelas 1: 1 alergi susu', NULL, '2026-08-27 16:32:26', '2026-08-27 16:32:26'),
(21, 4, 19, 'Pon-pes serbaguna', 'Peserta Didik', NULL, 200, 90, 290, 6, 'Kelas 1: 3 Alergi Udang | Kelas 2: 1 alergi susu | Kelas 4: 1 alergi kunyit | Kelas 5: 1 Alergi susu', NULL, '2026-08-27 16:42:05', '2026-08-27 16:42:05'),
(22, 4, 15, 'Posyanu Matahari', 'B3', NULL, 38, 23, 61, 5, 'Penerima: 1 alergi telur, 1 alergi terasi | Penerima: 1 alergi ayam, 1 alergi kecap, 1 alergi kunyit', NULL, '2026-08-27 16:42:05', '2026-08-27 16:42:05'),
(23, 4, 16, 'Sekolah Al-Mukhlisin', 'Peserta Didik', NULL, 193, 223, 416, 8, 'Kelas 1: 1 alergi micin | Kelas 3: 2 alergi udang | Kelas 4: 2 alergi susu | Kelas 6: 1 alergi kacang, 2 alergi jamur', NULL, '2026-08-27 16:42:05', '2026-08-27 16:42:05'),
(24, 4, 18, 'SMA 123 Bojonegoro', 'Peserta Didik', NULL, 49, 0, 49, 1, 'Kelas 10: 1 alergi kue', NULL, '2026-08-27 16:42:05', '2026-08-27 16:42:05'),
(25, 4, 20, 'Yayasan bakti', 'Peserta Didik', NULL, 0, 30, 30, 1, 'Kelas 1: 1 alergi susu', NULL, '2026-08-27 16:42:05', '2026-08-27 16:42:05'),
(31, 5, 19, 'Pon-pes serbaguna', 'Peserta Didik', NULL, 200, 90, 290, 6, 'Kelas 1: 3 Alergi Udang | Kelas 2: 1 alergi susu | Kelas 4: 1 alergi kunyit | Kelas 5: 1 Alergi susu', NULL, '2026-08-31 05:44:21', '2026-08-31 05:44:21'),
(32, 5, 15, 'Posyanu Matahari', 'B3', NULL, 38, 23, 61, 5, 'Penerima: 1 alergi telur, 1 alergi terasi | Penerima: 1 alergi ayam, 1 alergi kecap, 1 alergi kunyit', NULL, '2026-08-31 05:44:21', '2026-08-31 05:44:21'),
(33, 5, 16, 'Sekolah Al-Mukhlisin', 'Peserta Didik', NULL, 193, 223, 416, 8, 'Kelas 1: 1 alergi micin | Kelas 3: 2 alergi udang | Kelas 4: 2 alergi susu | Kelas 6: 1 alergi kacang, 2 alergi jamur', NULL, '2026-08-31 05:44:21', '2026-08-31 05:44:21'),
(34, 5, 18, 'SMA 123 Bojonegoro', 'Peserta Didik', NULL, 49, 0, 49, 1, 'Kelas 10: 1 alergi kue', NULL, '2026-08-31 05:44:21', '2026-08-31 05:44:21'),
(35, 5, 20, 'Yayasan bakti', 'Peserta Didik', NULL, 0, 30, 30, 1, 'Kelas 1: 1 alergi susu', NULL, '2026-08-31 05:44:21', '2026-08-31 05:44:21'),
(41, 7, 19, 'Pon-pes serbaguna', 'Peserta Didik', NULL, 200, 90, 290, 6, 'Kelas 1: 3 Alergi Udang | Kelas 2: 1 alergi susu | Kelas 4: 1 alergi kunyit | Kelas 5: 1 Alergi susu', NULL, '2026-10-22 20:46:06', '2026-10-22 20:46:06'),
(42, 7, 15, 'Posyanu Matahari', 'B3', NULL, 38, 23, 61, 5, 'Penerima: 1 alergi telur, 1 alergi terasi | Penerima: 1 alergi ayam, 1 alergi kecap, 1 alergi kunyit', NULL, '2026-10-22 20:46:06', '2026-10-22 20:46:06'),
(43, 7, 22, 'SDN 2 Purbalingga', 'Peserta Didik', NULL, 195, 237, 432, 17, 'Kelas 1: 1 susu, 2 kacang | Kelas 2: 2 susu, 3 udang | Kelas 4: 1 kedelai, 1 tepung, 1 nanas | Kelas 5: 3 susu, 3 udang', NULL, '2026-10-22 20:46:06', '2026-10-22 20:46:06'),
(44, 7, 16, 'Sekolah Al-Mukhlisin', 'Peserta Didik', NULL, 193, 223, 416, 8, 'Kelas 1: 1 alergi micin | Kelas 3: 2 alergi udang | Kelas 4: 2 alergi susu | Kelas 6: 1 alergi kacang, 2 alergi jamur', NULL, '2026-10-22 20:46:06', '2026-10-22 20:46:06'),
(45, 7, 18, 'SMA 123 Bojonegoro', 'Peserta Didik', NULL, 49, 0, 49, 1, 'Kelas 10: 1 alergi kue', NULL, '2026-10-22 20:46:06', '2026-10-22 20:46:06'),
(46, 7, 20, 'Yayasan bakti', 'Peserta Didik', NULL, 0, 30, 30, 1, 'Kelas 1: 1 alergi susu', NULL, '2026-10-22 20:46:06', '2026-10-22 20:46:06');

-- --------------------------------------------------------

--
-- Struktur dari tabel `rencana_menu_penerima_detail`
--

CREATE TABLE `rencana_menu_penerima_detail` (
  `id` int(11) NOT NULL,
  `rencana_menu_penerima_id` int(11) NOT NULL,
  `menu_id` int(11) DEFAULT NULL,
  `nama_menu` varchar(200) NOT NULL,
  `jenis_penggunaan` enum('normal','alergi') NOT NULL DEFAULT 'normal',
  `target_porsi_besar` int(11) NOT NULL DEFAULT 0,
  `target_porsi_kecil` int(11) NOT NULL DEFAULT 0,
  `total_target` int(11) NOT NULL DEFAULT 0,
  `catatan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `rencana_menu_penerima_detail`
--

INSERT INTO `rencana_menu_penerima_detail` (`id`, `rencana_menu_penerima_id`, `menu_id`, `nama_menu`, `jenis_penggunaan`, `target_porsi_besar`, `target_porsi_kecil`, `total_target`, `catatan`, `created_at`, `updated_at`) VALUES
(1, 1, 15, 'Kentang Ayam Saus padang - Varian', 'alergi', 0, 0, 3, NULL, '2026-08-27 13:34:56', '2026-08-27 13:34:56'),
(2, 1, 13, 'Nasi Ayam Saus padang', 'normal', 0, 0, 284, 'normal', '2026-08-27 13:34:56', '2026-08-27 13:34:56'),
(3, 1, 14, 'Nasi ikan kerapu saus tiram', 'alergi', 0, 0, 3, 'normal', '2026-08-27 13:34:56', '2026-08-27 13:34:56'),
(4, 2, 15, 'Kentang Ayam Saus padang - Varian', 'alergi', 0, 0, 2, NULL, '2026-08-27 13:34:56', '2026-08-27 13:34:56'),
(5, 2, 13, 'Nasi Ayam Saus padang', 'normal', 0, 0, 56, 'normal', '2026-08-27 13:34:56', '2026-08-27 13:34:56'),
(6, 2, 14, 'Nasi ikan kerapu saus tiram', 'alergi', 0, 0, 3, 'normal', '2026-08-27 13:34:56', '2026-08-27 13:34:56'),
(7, 3, 15, 'Kentang Ayam Saus padang - Varian', 'alergi', 0, 0, 2, NULL, '2026-08-27 13:34:56', '2026-08-27 13:34:56'),
(8, 3, 13, 'Nasi Ayam Saus padang', 'normal', 0, 0, 408, 'normal', '2026-08-27 13:34:56', '2026-08-27 13:34:56'),
(9, 3, 14, 'Nasi ikan kerapu saus tiram', 'alergi', 0, 0, 6, 'normal', '2026-08-27 13:34:56', '2026-08-27 13:34:56'),
(10, 4, 13, 'Nasi Ayam Saus padang', 'normal', 0, 0, 48, 'normal', '2026-08-27 13:34:56', '2026-08-27 13:34:56'),
(11, 4, 14, 'Nasi ikan kerapu saus tiram', 'alergi', 0, 0, 1, 'normal', '2026-08-27 13:34:56', '2026-08-27 13:34:56'),
(12, 5, 13, 'Nasi Ayam Saus padang', 'normal', 0, 0, 29, 'normal', '2026-08-27 13:34:56', '2026-08-27 13:34:56'),
(13, 5, 14, 'Nasi ikan kerapu saus tiram', 'alergi', 0, 0, 1, 'normal', '2026-08-27 13:34:56', '2026-08-27 13:34:56'),
(19, 11, 13, 'Nasi Ayam Saus padang', 'normal', 0, 0, 284, 'untuk yang tidak suka ikan', '2026-08-27 16:30:40', '2026-08-27 16:30:40'),
(20, 11, 14, 'Nasi ikan kerapu saus tiram', 'alergi', 0, 0, 5, 'untuk yang engga suka ayam', '2026-08-27 16:30:40', '2026-08-27 16:30:40'),
(21, 11, 15, 'Kentang Ayam Saus padang - Varian', 'alergi', 0, 0, 1, NULL, '2026-08-27 16:30:40', '2026-08-27 16:30:40'),
(22, 12, 13, 'Nasi Ayam Saus padang', 'normal', 0, 0, 56, 'untuk yang tidak suka ikan', '2026-08-27 16:30:40', '2026-08-27 16:30:40'),
(23, 12, 14, 'Nasi ikan kerapu saus tiram', 'alergi', 0, 0, 5, 'untuk yang engga suka ayam', '2026-08-27 16:30:40', '2026-08-27 16:30:40'),
(24, 13, 13, 'Nasi Ayam Saus padang', 'normal', 0, 0, 408, 'untuk yang tidak suka ikan', '2026-08-27 16:30:40', '2026-08-27 16:30:40'),
(25, 13, 14, 'Nasi ikan kerapu saus tiram', 'alergi', 0, 0, 3, 'untuk yang engga suka ayam', '2026-08-27 16:30:40', '2026-08-27 16:30:40'),
(26, 13, 15, 'Kentang Ayam Saus padang - Varian', 'alergi', 0, 0, 5, NULL, '2026-08-27 16:30:40', '2026-08-27 16:30:40'),
(27, 14, 13, 'Nasi Ayam Saus padang', 'normal', 0, 0, 48, 'untuk yang tidak suka ikan', '2026-08-27 16:30:40', '2026-08-27 16:30:40'),
(28, 14, 14, 'Nasi ikan kerapu saus tiram', 'alergi', 0, 0, 1, 'untuk yang engga suka ayam', '2026-08-27 16:30:40', '2026-08-27 16:30:40'),
(29, 15, 13, 'Nasi Ayam Saus padang', 'normal', 0, 0, 29, 'untuk yang tidak suka ikan', '2026-08-27 16:30:40', '2026-08-27 16:30:40'),
(30, 15, 14, 'Nasi ikan kerapu saus tiram', 'alergi', 0, 0, 1, 'untuk yang engga suka ayam', '2026-08-27 16:30:40', '2026-08-27 16:30:40'),
(31, 16, 13, 'Nasi Ayam Saus padang', 'normal', 0, 0, 284, NULL, '2026-08-27 16:32:26', '2026-08-27 16:32:26'),
(32, 16, 14, 'Nasi ikan kerapu saus tiram', 'alergi', 0, 0, 6, NULL, '2026-08-27 16:32:26', '2026-08-27 16:32:26'),
(33, 17, 13, 'Nasi Ayam Saus padang', 'normal', 0, 0, 56, NULL, '2026-08-27 16:32:26', '2026-08-27 16:32:26'),
(34, 17, 14, 'Nasi ikan kerapu saus tiram', 'alergi', 0, 0, 5, NULL, '2026-08-27 16:32:26', '2026-08-27 16:32:26'),
(35, 18, 13, 'Nasi Ayam Saus padang', 'normal', 0, 0, 408, NULL, '2026-08-27 16:32:26', '2026-08-27 16:32:26'),
(36, 18, 14, 'Nasi ikan kerapu saus tiram', 'alergi', 0, 0, 8, NULL, '2026-08-27 16:32:26', '2026-08-27 16:32:26'),
(37, 19, 13, 'Nasi Ayam Saus padang', 'normal', 0, 0, 48, NULL, '2026-08-27 16:32:26', '2026-08-27 16:32:26'),
(38, 19, 14, 'Nasi ikan kerapu saus tiram', 'alergi', 0, 0, 1, NULL, '2026-08-27 16:32:26', '2026-08-27 16:32:26'),
(39, 20, 13, 'Nasi Ayam Saus padang', 'normal', 0, 0, 29, NULL, '2026-08-27 16:32:26', '2026-08-27 16:32:26'),
(40, 20, 14, 'Nasi ikan kerapu saus tiram', 'alergi', 0, 0, 1, NULL, '2026-08-27 16:32:26', '2026-08-27 16:32:26'),
(41, 21, 16, 'Sayur asem ikan asin', 'normal', 0, 0, 284, NULL, '2026-08-27 16:42:05', '2026-08-27 16:42:05'),
(42, 21, 13, 'Nasi Ayam Saus padang', 'alergi', 0, 0, 6, NULL, '2026-08-27 16:42:05', '2026-08-27 16:42:05'),
(43, 22, 16, 'Sayur asem ikan asin', 'normal', 0, 0, 56, NULL, '2026-08-27 16:42:05', '2026-08-27 16:42:05'),
(44, 22, 13, 'Nasi Ayam Saus padang', 'alergi', 0, 0, 1, NULL, '2026-08-27 16:42:05', '2026-08-27 16:42:05'),
(45, 22, 14, 'Nasi ikan kerapu saus tiram', 'alergi', 0, 0, 4, NULL, '2026-08-27 16:42:05', '2026-08-27 16:42:05'),
(46, 23, 16, 'Sayur asem ikan asin', 'normal', 0, 0, 408, NULL, '2026-08-27 16:42:05', '2026-08-27 16:42:05'),
(47, 23, 13, 'Nasi Ayam Saus padang', 'alergi', 0, 0, 4, NULL, '2026-08-27 16:42:05', '2026-08-27 16:42:05'),
(48, 23, 14, 'Nasi ikan kerapu saus tiram', 'alergi', 0, 0, 4, NULL, '2026-08-27 16:42:05', '2026-08-27 16:42:05'),
(49, 24, 16, 'Sayur asem ikan asin', 'normal', 0, 0, 48, NULL, '2026-08-27 16:42:05', '2026-08-27 16:42:05'),
(50, 24, 14, 'Nasi ikan kerapu saus tiram', 'alergi', 0, 0, 1, NULL, '2026-08-27 16:42:05', '2026-08-27 16:42:05'),
(51, 25, 16, 'Sayur asem ikan asin', 'normal', 0, 0, 29, NULL, '2026-08-27 16:42:05', '2026-08-27 16:42:05'),
(52, 25, 14, 'Nasi ikan kerapu saus tiram', 'alergi', 0, 0, 1, NULL, '2026-08-27 16:42:05', '2026-08-27 16:42:05'),
(63, 31, 13, 'Nasi Ayam Saus padang', 'normal', 0, 0, 284, NULL, '2026-08-31 05:44:21', '2026-08-31 05:44:21'),
(64, 31, 16, 'Sayur asem ikan asin', 'alergi', 0, 0, 6, NULL, '2026-08-31 05:44:21', '2026-08-31 05:44:21'),
(65, 32, 13, 'Nasi Ayam Saus padang', 'normal', 0, 0, 56, NULL, '2026-08-31 05:44:21', '2026-08-31 05:44:21'),
(66, 32, 16, 'Sayur asem ikan asin', 'alergi', 0, 0, 5, NULL, '2026-08-31 05:44:21', '2026-08-31 05:44:21'),
(67, 33, 13, 'Nasi Ayam Saus padang', 'normal', 0, 0, 408, NULL, '2026-08-31 05:44:21', '2026-08-31 05:44:21'),
(68, 33, 16, 'Sayur asem ikan asin', 'alergi', 0, 0, 8, NULL, '2026-08-31 05:44:21', '2026-08-31 05:44:21'),
(69, 34, 13, 'Nasi Ayam Saus padang', 'normal', 0, 0, 48, NULL, '2026-08-31 05:44:21', '2026-08-31 05:44:21'),
(70, 34, 16, 'Sayur asem ikan asin', 'alergi', 0, 0, 1, NULL, '2026-08-31 05:44:21', '2026-08-31 05:44:21'),
(71, 35, 13, 'Nasi Ayam Saus padang', 'normal', 0, 0, 29, NULL, '2026-08-31 05:44:21', '2026-08-31 05:44:21'),
(72, 35, 16, 'Sayur asem ikan asin', 'alergi', 0, 0, 1, NULL, '2026-08-31 05:44:21', '2026-08-31 05:44:21'),
(83, 41, 17, 'Nasi Ayam Teriyaki', 'normal', 0, 0, 284, NULL, '2026-10-22 20:46:06', '2026-10-22 20:46:06'),
(84, 41, 14, 'Nasi ikan kerapu saus tiram', 'alergi', 0, 0, 3, NULL, '2026-10-22 20:46:06', '2026-10-22 20:46:06'),
(85, 41, 16, 'Sayur asem ikan asin', 'alergi', 0, 0, 3, NULL, '2026-10-22 20:46:06', '2026-10-22 20:46:06'),
(86, 42, 17, 'Nasi Ayam Teriyaki', 'normal', 0, 0, 56, NULL, '2026-10-22 20:46:06', '2026-10-22 20:46:06'),
(87, 42, 14, 'Nasi ikan kerapu saus tiram', 'alergi', 0, 0, 3, NULL, '2026-10-22 20:46:06', '2026-10-22 20:46:06'),
(88, 42, 16, 'Sayur asem ikan asin', 'alergi', 0, 0, 2, NULL, '2026-10-22 20:46:06', '2026-10-22 20:46:06'),
(89, 43, 17, 'Nasi Ayam Teriyaki', 'normal', 0, 0, 415, NULL, '2026-10-22 20:46:06', '2026-10-22 20:46:06'),
(90, 43, 14, 'Nasi ikan kerapu saus tiram', 'alergi', 0, 0, 15, NULL, '2026-10-22 20:46:06', '2026-10-22 20:46:06'),
(91, 43, 16, 'Sayur asem ikan asin', 'alergi', 0, 0, 2, NULL, '2026-10-22 20:46:06', '2026-10-22 20:46:06'),
(92, 44, 17, 'Nasi Ayam Teriyaki', 'normal', 0, 0, 408, NULL, '2026-10-22 20:46:06', '2026-10-22 20:46:06'),
(93, 44, 16, 'Sayur asem ikan asin', 'alergi', 0, 0, 4, NULL, '2026-10-22 20:46:06', '2026-10-22 20:46:06'),
(94, 44, 18, 'Nasi Ayam Goreng Suir', 'alergi', 0, 0, 4, NULL, '2026-10-22 20:46:06', '2026-10-22 20:46:06'),
(95, 45, 17, 'Nasi Ayam Teriyaki', 'normal', 0, 0, 48, NULL, '2026-10-22 20:46:06', '2026-10-22 20:46:06'),
(96, 45, 14, 'Nasi ikan kerapu saus tiram', 'alergi', 0, 0, 1, NULL, '2026-10-22 20:46:06', '2026-10-22 20:46:06'),
(97, 46, 17, 'Nasi Ayam Teriyaki', 'normal', 0, 0, 29, NULL, '2026-10-22 20:46:06', '2026-10-22 20:46:06'),
(98, 46, 16, 'Sayur asem ikan asin', 'alergi', 0, 0, 1, NULL, '2026-10-22 20:46:06', '2026-10-22 20:46:06');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sppg`
--

CREATE TABLE `sppg` (
  `id_sppg` varchar(20) NOT NULL,
  `sppg_name` varchar(100) NOT NULL,
  `address` text DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `established_date` date DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sppg`
--

INSERT INTO `sppg` (`id_sppg`, `sppg_name`, `address`, `phone`, `email`, `established_date`, `status`, `created_at`) VALUES
('Ngaglik01', 'SPPG Sleman Ngaglik Sukoharjo', 'Jl. Bandulan RT 04 RW 18, Kel. Sukoharjo Kec.Ngaglik, Kab. Sleman Provinsi D.I. Yogyakarta', '0274-234567', 'ngaglik@sigita-mbg.net', '2021-03-20', 'active', '2026-05-29 14:30:14'),
('Pandak01', 'SPPG Bantul Pandak Triharjo', 'Jl. Srandakan, Siyangan, Kel. Triharjo Kec. Pandak, Kab. Bantul Provinsi D.I. Yogyakarta', '0274-123456', 'pandak@sigita-mbg.net', '2020-06-15', 'active', '2026-05-29 14:30:14'),
('Pandak02', 'SPPG Bantal Apes', 'Jl. bantal Apes', '04552011', 'sppgba@sigita-mbg.net', '2026-09-01', 'active', '2026-09-01 03:34:44'),
('Semin01', 'SPPG Gunungkidul Semin Sumberejo', 'Jl. Pandanan RT 02 RW 012 Kel. Sumberejo Kec. Semin, Kab. Gunungkidul Provinsi D.I. Yogyakarta', '0274-345678', 'semin@sigita-mbg.net', '2021-08-10', 'active', '2026-05-29 14:30:14'),
('Tampaksiring01', 'SPPG Gianyar Tampaksiring', 'Jl. Uma, Br. Kelodan, Kel. Tampaksiring Kec. Tampaksiring, Kab. Gianyar Provinsi Bali', '0361-123456', 'tampaksiring@sigita-mbg.net', '2020-01-01', 'active', '2026-05-29 14:30:14');

-- --------------------------------------------------------

--
-- Struktur dari tabel `supplier_bahan`
--

CREATE TABLE `supplier_bahan` (
  `id` int(11) UNSIGNED NOT NULL,
  `supplier_id` int(11) UNSIGNED NOT NULL,
  `bahan_id` int(11) UNSIGNED NOT NULL,
  `harga_beli` decimal(18,2) NOT NULL DEFAULT 0.00,
  `minimum_order` decimal(18,2) DEFAULT NULL,
  `status` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `keterangan` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `supplier_bahan`
--

INSERT INTO `supplier_bahan` (`id`, `supplier_id`, `bahan_id`, `harga_beli`, `minimum_order`, `status`, `keterangan`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, 13, 13000.00, NULL, 'aktif', NULL, 34, 34, '2026-09-20 16:04:54', '2026-09-20 16:04:54'),
(2, 1, 18, 32000.00, NULL, 'aktif', NULL, 34, 34, '2026-09-20 16:04:54', '2026-09-20 16:04:54'),
(3, 2, 123, 10000.00, NULL, 'aktif', NULL, 34, 34, '2026-09-27 21:18:55', '2026-09-27 21:18:55'),
(4, 2, 17, 5500.00, NULL, 'aktif', NULL, 34, 34, '2026-09-27 21:18:55', '2026-09-28 15:55:33'),
(5, 2, 124, 2000.00, NULL, 'aktif', NULL, 34, 34, '2026-09-27 21:18:55', '2026-09-27 21:18:55'),
(6, 3, 19, 90000.00, NULL, 'aktif', NULL, 34, 34, '2026-09-28 15:40:34', '2026-10-09 20:29:32'),
(7, 3, 124, 3000.00, NULL, 'aktif', NULL, 34, 34, '2026-09-28 15:40:34', '2026-09-28 15:40:34'),
(8, 3, 26, 1500.00, NULL, 'aktif', NULL, 34, 34, '2026-09-28 15:40:34', '2026-09-28 15:40:34'),
(9, 3, 24, 10500.00, NULL, 'aktif', NULL, 34, 34, '2026-09-28 15:40:34', '2026-09-28 15:40:34'),
(10, 4, 130, 40000.00, NULL, 'aktif', NULL, 34, 34, '2026-10-09 20:19:20', '2026-10-09 20:19:20'),
(11, 5, 23, 30000.00, NULL, 'aktif', NULL, 34, 34, '2026-10-09 20:26:03', '2026-10-09 20:26:03'),
(12, 5, 21, 5000.00, NULL, 'aktif', NULL, 34, 34, '2026-10-09 20:26:03', '2026-10-09 20:26:03'),
(13, 6, 132, 35000.00, NULL, 'aktif', NULL, 34, 34, '2026-10-22 21:21:53', '2026-10-22 21:21:53'),
(14, 6, 14, 25000.00, NULL, 'aktif', NULL, 34, 34, '2026-10-22 21:21:53', '2026-10-22 21:21:53'),
(15, 7, 18, 30000.00, NULL, 'aktif', NULL, 34, 34, '2026-10-22 21:25:49', '2026-10-22 21:47:39'),
(16, 7, 20, 26000.00, NULL, 'aktif', NULL, 34, 34, '2026-10-22 21:25:49', '2026-10-22 21:25:49'),
(17, 7, 16, 12000.00, NULL, 'aktif', NULL, 34, 34, '2026-10-22 21:25:49', '2026-10-22 21:25:49'),
(18, 7, 13, 13500.00, NULL, 'aktif', NULL, 34, 34, '2026-10-22 21:25:49', '2026-10-22 21:25:49');

-- --------------------------------------------------------

--
-- Struktur dari tabel `supplier_bahan_harga`
--

CREATE TABLE `supplier_bahan_harga` (
  `id` int(11) UNSIGNED NOT NULL,
  `supplier_bahan_id` int(11) UNSIGNED NOT NULL,
  `harga_lama` decimal(18,2) NOT NULL DEFAULT 0.00,
  `harga_baru` decimal(18,2) NOT NULL DEFAULT 0.00,
  `berlaku_mulai` date DEFAULT NULL,
  `diubah_oleh` int(11) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `supplier_bahan_harga`
--

INSERT INTO `supplier_bahan_harga` (`id`, `supplier_bahan_id`, `harga_lama`, `harga_baru`, `berlaku_mulai`, `diubah_oleh`, `keterangan`, `created_at`) VALUES
(1, 1, 0.00, 13000.00, '2026-09-20', 34, 'Harga awal supplier', '2026-09-20 16:04:54'),
(2, 2, 0.00, 32000.00, '2026-09-20', 34, 'Harga awal supplier', '2026-09-20 16:04:54'),
(3, 3, 0.00, 10000.00, '2026-09-27', 34, 'Harga awal supplier', '2026-09-27 21:18:55'),
(4, 4, 0.00, 4000.00, '2026-09-27', 34, 'Harga awal supplier', '2026-09-27 21:18:55'),
(5, 5, 0.00, 2000.00, '2026-09-27', 34, 'Harga awal supplier', '2026-09-27 21:18:55'),
(6, 6, 0.00, 117000.00, '2026-09-28', 34, 'Harga awal supplier', '2026-09-28 15:40:34'),
(7, 7, 0.00, 3000.00, '2026-09-28', 34, 'Harga awal supplier', '2026-09-28 15:40:34'),
(8, 8, 0.00, 1500.00, '2026-09-28', 34, 'Harga awal supplier', '2026-09-28 15:40:34'),
(9, 9, 0.00, 10500.00, '2026-09-28', 34, 'Harga awal supplier', '2026-09-28 15:40:34'),
(10, 4, 4000.00, 40000.00, '2026-09-09', 34, 'Perubahan harga saat transaksi pembelian PB-20260909-00003', '2026-09-28 15:43:43'),
(11, 4, 40000.00, 5500.00, '2026-09-28', 34, 'Perubahan harga supplier oleh Koperasi', '2026-09-28 15:55:33'),
(12, 10, 0.00, 40000.00, '2026-10-09', 34, 'Harga awal supplier', '2026-10-09 20:19:20'),
(13, 6, 117000.00, 90000.00, '2026-09-29', 34, 'Perubahan harga saat transaksi pembelian PB-20260929-00004', '2026-10-09 20:29:32'),
(14, 15, 25000.00, 30000.00, '2026-09-29', 34, 'Perubahan harga saat transaksi pembelian PB-20260929-00004', '2026-10-22 21:47:39');

-- --------------------------------------------------------

--
-- Struktur dari tabel `supplier_koperasi`
--

CREATE TABLE `supplier_koperasi` (
  `id` int(11) NOT NULL,
  `koperasi_id` int(11) DEFAULT NULL,
  `kode_supplier` varchar(40) DEFAULT NULL,
  `id_sppg` varchar(20) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `nama_supplier` varchar(200) NOT NULL,
  `nama_pic` varchar(150) DEFAULT NULL,
  `no_hp` varchar(50) DEFAULT NULL,
  `alamat` text NOT NULL,
  `kabupaten_kota` varchar(100) DEFAULT NULL,
  `provinsi` varchar(100) DEFAULT NULL,
  `npwp_nik` varchar(50) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `tanggal_mou_mulai` date DEFAULT NULL,
  `tanggal_mou_akhir` date DEFAULT NULL,
  `status` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `catatan` text DEFAULT NULL,
  `bank` varchar(100) DEFAULT NULL,
  `nomor_rekening` varchar(50) DEFAULT NULL,
  `kontrak_path` varchar(500) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `supplier_koperasi`
--

INSERT INTO `supplier_koperasi` (`id`, `koperasi_id`, `kode_supplier`, `id_sppg`, `tanggal`, `nama_supplier`, `nama_pic`, `no_hp`, `alamat`, `kabupaten_kota`, `provinsi`, `npwp_nik`, `email`, `tanggal_mou_mulai`, `tanggal_mou_akhir`, `status`, `catatan`, `bank`, `nomor_rekening`, `kontrak_path`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 2, 'KOP21-SUP-0001', NULL, NULL, 'PT Wahana Nutrisi', 'Wawan Botak', '087738877332', 'Jl. Kebangbang dungo', 'babakan', 'Jogja', '66883992222', 'wanut@gmail.com', '2026-05-01', '2027-03-13', 'aktif', NULL, NULL, NULL, NULL, 34, '2026-09-20 16:04:54', '2026-10-11 12:08:01'),
(2, 2, 'KOP21-SUP-0002', NULL, NULL, 'CV. Murni Sehajtera', 'Bambang', '083766288222', 'Jl. Simpang 3', 'Sukomakmur', 'Jawa tengah', '773668342323', 'murni@gmail.com', '2026-09-27', '2026-12-31', 'aktif', NULL, NULL, NULL, NULL, 34, '2026-09-27 21:18:55', '2026-09-27 21:18:55'),
(3, 2, 'KOP21-SUP-0003', NULL, NULL, 'CV. Daging Nusantara', 'wawan golek', '0887993889', 'Jl. makan banyak', 'Jakarta Selatan', 'DKI Jakarta', '77623988233', 'danu@gmail.com', '2026-09-07', '2027-12-31', 'aktif', NULL, NULL, NULL, NULL, 34, '2026-09-28 15:40:34', '2026-10-11 12:07:39'),
(4, 2, 'KOP21-SUP-0004', NULL, NULL, 'CV. indah', 'Wanto', NULL, '', NULL, NULL, NULL, NULL, '2026-08-05', '2027-03-24', 'aktif', NULL, NULL, NULL, NULL, 34, '2026-10-09 20:18:08', '2026-10-09 20:18:58'),
(5, 2, 'KOP21-SUP-0005', NULL, NULL, 'Handoko', 'Handoko', NULL, '', NULL, NULL, NULL, NULL, '2026-10-09', '2027-07-09', 'aktif', NULL, NULL, NULL, NULL, 34, '2026-10-09 20:25:27', '2026-10-09 20:26:03'),
(6, 2, 'KOP21-SUP-0006', NULL, NULL, 'Jono', 'Jono', '8787897987', '', NULL, NULL, NULL, NULL, '2026-09-22', '2026-11-14', 'aktif', NULL, NULL, NULL, NULL, 34, '2026-10-22 21:21:53', '2026-10-22 21:21:53'),
(7, 2, 'KOP21-SUP-0007', NULL, NULL, 'CV makmur sentosa', 'ruslan', '87897998', '', NULL, NULL, NULL, NULL, '2026-09-02', '2026-12-31', 'aktif', NULL, NULL, NULL, NULL, 34, '2026-10-22 21:25:49', '2026-10-22 21:26:38');

-- --------------------------------------------------------

--
-- Struktur dari tabel `supplier_koperasi_berkas`
--

CREATE TABLE `supplier_koperasi_berkas` (
  `id` int(11) UNSIGNED NOT NULL,
  `supplier_id` int(11) UNSIGNED NOT NULL,
  `jenis_dokumen_id` int(11) UNSIGNED NOT NULL,
  `nama_berkas` varchar(200) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(500) NOT NULL,
  `file_type` varchar(100) DEFAULT NULL,
  `file_size` bigint(20) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `supplier_koperasi_berkas`
--

INSERT INTO `supplier_koperasi_berkas` (`id`, `supplier_id`, `jenis_dokumen_id`, `nama_berkas`, `file_name`, `file_path`, `file_type`, `file_size`, `keterangan`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 1, 5, 'Surat Kerja Sama / MOU', 'CetakMonitor-b0fddd65-e3b5-4e4f-9f46-0615cf78e209.pdf', 'uploads/supplier/1789895094_9ee82625231ac8e90a02.pdf', 'application/pdf', 141518, NULL, 34, '2026-09-20 16:04:54', '2026-09-20 16:04:54'),
(2, 2, 5, 'Surat Kerja Sama / MOU', 'CetakMerek4-JID2026100677.pdf', 'uploads/supplier/1790518735_6b63c4a26f451795da1a.pdf', 'application/pdf', 1065348, NULL, 34, '2026-09-27 21:18:55', '2026-09-27 21:18:55');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `id_sppg` varchar(20) DEFAULT NULL,
  `koperasi_id` int(11) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `user_level` enum('super_admin','admin','kepala','gizi','keuangan','aslap','koperasi') NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `id_sppg`, `koperasi_id`, `username`, `password`, `email`, `full_name`, `user_level`, `role`, `status`, `created_at`, `updated_at`) VALUES
(14, 'Tampaksiring01', NULL, 'kepala_tampaksiring', '$2y$12$bIr4NOrB8hAj0uBVLg/SKOKf7wWF6eHcYe0no7sDAYbf6UTiu68CK', 'komang.adi@sigita-mbg.net', 'I Komang Adi Wiguna, S.Pt', 'kepala', 'admin', 'active', '2026-05-29 14:30:14', '2026-05-29 14:36:50'),
(15, 'Tampaksiring01', NULL, 'gizi_tampaksiring', '$2y$12$bIr4NOrB8hAj0uBVLg/SKOKf7wWF6eHcYe0no7sDAYbf6UTiu68CK', 'widya.ayu@sigita-mbg.net', 'Widya Ayu Wijayanti, A.MdGz', 'gizi', 'user', 'active', '2026-05-29 14:30:14', '2026-05-29 14:36:04'),
(16, 'Tampaksiring01', NULL, 'keuangan_tampaksiring', '$2y$12$bIr4NOrB8hAj0uBVLg/SKOKf7wWF6eHcYe0no7sDAYbf6UTiu68CK', 'sri.gayatri@sigita-mbg.net', 'Ida Ayu Sri Gayatri, S.E.', 'keuangan', 'user', 'active', '2026-05-29 14:30:14', '2026-05-29 14:36:50'),
(17, 'Tampaksiring01', NULL, 'aslap_tampaksiring', '$2y$12$bIr4NOrB8hAj0uBVLg/SKOKf7wWF6eHcYe0no7sDAYbf6UTiu68CK', 'arini.anti@sigita-mbg.net', 'Ida Ayu Made Arini Anti', 'aslap', 'user', 'active', '2026-05-29 14:30:14', '2026-05-29 14:36:50'),
(18, 'Pandak01', NULL, 'kepala_pandak', '$2y$12$bIr4NOrB8hAj0uBVLg/SKOKf7wWF6eHcYe0no7sDAYbf6UTiu68CK', 'sarah@sigita-mbg.net', 'Sarah Desthiana, S.Pt., M.Sc', 'kepala', 'admin', 'active', '2026-05-29 14:30:14', '2026-05-29 14:36:50'),
(19, 'Pandak01', NULL, 'gizi_pandak', '$2y$12$bIr4NOrB8hAj0uBVLg/SKOKf7wWF6eHcYe0no7sDAYbf6UTiu68CK', 'adibah@sigita-mbg.net', 'Nurul Anisa Adibah, S.Gz', 'gizi', 'user', 'active', '2026-05-29 14:30:14', '2026-05-29 14:36:50'),
(20, 'Pandak01', NULL, 'keuangan_pandak', '$2y$12$bIr4NOrB8hAj0uBVLg/SKOKf7wWF6eHcYe0no7sDAYbf6UTiu68CK', 'aurisa@sigita-mbg.net', 'Aurisa Desanti, S.E.', 'keuangan', 'user', 'active', '2026-05-29 14:30:14', '2026-05-29 14:36:50'),
(21, 'Pandak01', NULL, 'aslap_pandak', '$2y$12$bIr4NOrB8hAj0uBVLg/SKOKf7wWF6eHcYe0no7sDAYbf6UTiu68CK', 'ririn@sigita-mbg.net', 'Rinrin Apriani', 'aslap', 'user', 'active', '2026-05-29 14:30:14', '2026-05-29 14:36:50'),
(22, 'Ngaglik01', NULL, 'kepala_ngaglik', '$2y$12$bIr4NOrB8hAj0uBVLg/SKOKf7wWF6eHcYe0no7sDAYbf6UTiu68CK', 'kurnia.diska@sigita-mbg.net', 'Kurnia Diska Rini W, S.Psi', 'kepala', 'admin', 'active', '2026-05-29 14:30:14', '2026-05-29 14:36:50'),
(23, 'Ngaglik01', NULL, 'gizi_ngaglik', '$2y$12$bIr4NOrB8hAj0uBVLg/SKOKf7wWF6eHcYe0no7sDAYbf6UTiu68CK', 'fayola@sigita-mbg.net', 'Fayola Candra Vita, S.Tr.Gz', 'gizi', 'user', 'active', '2026-05-29 14:30:14', '2026-05-29 14:36:50'),
(24, 'Ngaglik01', NULL, 'keuangan_ngaglik', '$2y$12$bIr4NOrB8hAj0uBVLg/SKOKf7wWF6eHcYe0no7sDAYbf6UTiu68CK', 'rahma.nk@sigita-mbg.net', 'Rahma Nur Khasanah, S.Ak', 'keuangan', 'user', 'active', '2026-05-29 14:30:14', '2026-05-29 14:36:50'),
(25, 'Ngaglik01', NULL, 'aslap_ngaglik', '$2y$12$bIr4NOrB8hAj0uBVLg/SKOKf7wWF6eHcYe0no7sDAYbf6UTiu68CK', 'erik.k@sigita-mbg.net', 'Erik Kurniyanto', 'aslap', 'user', 'active', '2026-05-29 14:30:14', '2026-05-29 14:36:50'),
(26, 'Semin01', NULL, 'kepala_semin', '$2y$12$bIr4NOrB8hAj0uBVLg/SKOKf7wWF6eHcYe0no7sDAYbf6UTiu68CK', 'ali.sodikin@sigita-mbg.net', 'Ali Sodikin, S.Sos', 'kepala', 'admin', 'inactive', '2026-05-29 14:30:14', '2026-09-02 09:43:26'),
(27, 'Semin01', NULL, 'gizi_semin', '$2y$12$bIr4NOrB8hAj0uBVLg/SKOKf7wWF6eHcYe0no7sDAYbf6UTiu68CK', 'diana@sigita-mbg.net', 'Diana, S.Gz', 'gizi', 'user', 'active', '2026-05-29 14:30:14', '2026-05-29 14:36:50'),
(28, 'Semin01', NULL, 'keuangan_semin', '$2y$12$bIr4NOrB8hAj0uBVLg/SKOKf7wWF6eHcYe0no7sDAYbf6UTiu68CK', 'herlisa.sari@sigita-mbg.net', 'Herlina Sari Indri Astuti, S.Ak', 'keuangan', 'user', 'active', '2026-05-29 14:30:14', '2026-05-29 14:36:50'),
(29, 'Semin01', NULL, 'aslap_semin', '$2y$12$bIr4NOrB8hAj0uBVLg/SKOKf7wWF6eHcYe0no7sDAYbf6UTiu68CK', 'anisa.r@sigita-mbg.net', 'Anisa Rahmawati', 'aslap', 'user', 'active', '2026-05-29 14:30:14', '2026-09-01 10:40:19'),
(31, NULL, NULL, 'superadmin', '$2y$12$puJzU8XNhkx6xrX.U9wV8eyWXnjl16O78blcFdDxi/boTq4kOJDui', 'superadmin@sigita-mbg.net', 'Super Administrator SIGITA', 'super_admin', 'admin', 'active', '2026-09-01 03:14:10', '2026-09-01 03:14:10'),
(32, 'Pandak02', NULL, 'sopian@sigita-mbg.net', '$2y$10$.VlYa473/UeR7lfIeKw9de2ifjZ9C.bxPIXD8qfloO.C9LbGdXNVS', 'sopian@sigita-mbg.net', 'Sopian', 'aslap', 'user', 'active', '2026-09-01 10:40:03', '2026-09-01 10:40:03'),
(33, NULL, NULL, 'admin', '$2y$10$y8We2EfMFRCUk/5Zl.mEfujs4j8AjcJVJpZhPdYPK66SEIB.z/yk2', 'admin@sigita-mbg.net', 'adminsppg01', 'admin', 'admin', 'active', '2026-09-01 10:49:16', '2026-09-02 07:34:25'),
(34, NULL, 2, 'kop01', '$2y$10$rJ9.N9NubWglJEBVNDl/N.X98HTlGfboyrozOyPXB7PxE9RkpWBrK', 'kop01@gmail.com', 'koperasi 01', 'koperasi', 'user', 'active', '2026-09-04 04:53:20', '2026-09-04 04:55:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_activity_logs`
--

CREATE TABLE `user_activity_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `id_sppg` varchar(20) DEFAULT NULL,
  `user_level` varchar(30) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `activity` varchar(255) NOT NULL,
  `module` varchar(100) NOT NULL,
  `method` varchar(10) NOT NULL,
  `uri` varchar(255) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(500) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `user_activity_logs`
--

INSERT INTO `user_activity_logs` (`id`, `user_id`, `id_sppg`, `user_level`, `username`, `activity`, `module`, `method`, `uri`, `ip_address`, `user_agent`, `created_at`) VALUES
(1, 31, NULL, 'super_admin', 'superadmin@sigita-mbg.net', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '103.150.169.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-02 09:40:52'),
(2, 31, NULL, 'super_admin', 'superadmin@sigita-mbg.net', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '103.150.169.6', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Mobile Safari/537.36', '2026-09-02 09:42:46'),
(3, 31, NULL, 'super_admin', 'superadmin@sigita-mbg.net', 'Logout', 'Autentikasi', 'GET', '/auth/logout', '103.150.169.6', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Mobile Safari/537.36', '2026-09-02 09:52:17'),
(4, 17, 'Tampaksiring01', 'aslap', 'arini.anti@sigita-mbg.net', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '103.150.169.6', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Mobile Safari/537.36', '2026-09-02 09:52:20'),
(5, 17, 'Tampaksiring01', 'aslap', 'arini.anti@sigita-mbg.net', 'Logout', 'Autentikasi', 'GET', '/auth/logout', '103.150.169.6', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Mobile Safari/537.36', '2026-09-02 09:52:26'),
(6, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '103.150.169.6', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Mobile Safari/537.36', '2026-09-02 09:52:28'),
(7, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '103.150.169.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-03 14:18:33'),
(8, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Logout', 'Autentikasi', 'GET', '/auth/logout', '103.150.169.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-03 14:18:52'),
(9, 31, NULL, 'super_admin', 'superadmin@sigita-mbg.net', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '103.150.169.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-03 14:18:56'),
(10, 31, NULL, 'super_admin', 'superadmin@sigita-mbg.net', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 04:18:18'),
(11, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 04:53:45'),
(12, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Logout', 'Autentikasi', 'GET', '/auth/logout', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 05:01:15'),
(13, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 05:01:21'),
(14, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Logout', 'Autentikasi', 'GET', '/auth/logout', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 05:11:38'),
(15, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 05:11:47'),
(16, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 05:11:47'),
(17, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 05:12:03'),
(18, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 05:12:17'),
(19, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/sppg/select', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 05:12:20'),
(20, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 05:12:20'),
(21, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 05:12:23'),
(22, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 05:12:26'),
(23, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/sppg/select', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 05:12:29'),
(24, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 05:12:29'),
(25, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 05:12:31'),
(26, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan/history/29', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 05:12:35'),
(27, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 05:12:39'),
(28, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/bahan/update-harga/29', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 05:12:52'),
(29, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 05:12:52'),
(30, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/sppg/select', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 05:12:59'),
(31, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 05:12:59'),
(32, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/bahan/update-harga/13', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 05:13:12'),
(33, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 05:13:12'),
(34, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/bahan/store', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 05:13:43'),
(35, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 05:13:43'),
(36, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/bahan/store', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 05:14:19'),
(37, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 05:14:19'),
(38, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 05:14:30'),
(39, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/request-bahan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 05:14:33'),
(40, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 05:14:40'),
(41, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/sppg/select', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 05:14:42'),
(42, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 05:14:42'),
(43, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/request-bahan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 05:14:44'),
(44, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/request-bahan/approve/2', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 05:15:10'),
(45, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/request-bahan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 05:15:10'),
(46, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/request-bahan/approve/1', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 05:15:24'),
(47, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/request-bahan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 05:15:24'),
(48, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 05:15:29'),
(49, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 05:15:32'),
(50, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/sppg/select', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 05:15:37'),
(51, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 05:15:37'),
(52, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/sppg/select', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 05:15:49'),
(53, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 05:15:49'),
(54, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/sppg/select', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 05:15:59'),
(55, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 05:15:59'),
(56, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/sppg/select', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 05:16:06'),
(57, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 05:16:06'),
(58, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 05:16:19'),
(59, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/request-bahan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 05:16:27'),
(60, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 05:16:39'),
(61, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 05:16:44'),
(62, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/bahan/update-harga/13', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 05:29:26'),
(63, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 05:29:26'),
(64, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan/history/13', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 05:29:29'),
(65, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 05:29:41'),
(66, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 07:04:30'),
(67, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/rencana-menu', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 07:04:33'),
(68, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 07:04:42'),
(69, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/create', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 07:04:44'),
(70, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/12', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 07:04:52'),
(71, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 07:04:54'),
(72, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/gizi/bahan-baku/store-detail', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 07:05:32'),
(73, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/12', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 07:05:32'),
(74, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 07:05:44'),
(75, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/gizi/bahan-baku/store-detail', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 07:05:57'),
(76, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/12', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 07:05:57'),
(77, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 07:06:10'),
(78, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 07:06:21'),
(79, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/sppg/select', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 07:06:48'),
(80, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 07:06:48'),
(81, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 07:06:55'),
(82, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 07:06:59'),
(83, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 07:07:03'),
(84, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/bahan/copy', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 07:07:20'),
(85, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 07:07:20'),
(86, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/bahan/copy', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 07:07:46'),
(87, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 07:07:46'),
(88, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 08:12:21'),
(89, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 08:12:23'),
(90, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 08:12:23'),
(91, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/sppg/select', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 08:12:31'),
(92, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 08:12:31'),
(93, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 08:14:16'),
(94, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan/history/29', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 08:14:33'),
(95, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 08:14:38'),
(96, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/sppg/select', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 08:14:41'),
(97, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 08:14:41'),
(98, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 08:14:57'),
(99, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 08:15:07'),
(100, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 08:15:52'),
(101, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 08:31:21'),
(102, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 08:31:22'),
(103, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan/template-excel', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-09-04 08:31:24'),
(104, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '2001:448a:20b0:e796:40a5:7e9b:5f54:b937', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-04 10:03:36'),
(105, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '2001:448a:20b0:e796:40a5:7e9b:5f54:b937', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-04 10:03:36'),
(106, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/request-bahan', '2001:448a:20b0:e796:40a5:7e9b:5f54:b937', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-04 10:13:10'),
(107, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '2001:448a:20b0:e796:40a5:7e9b:5f54:b937', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-04 10:13:15'),
(108, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '2001:448a:20b0:e796:40a5:7e9b:5f54:b937', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-04 10:13:25'),
(109, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '2001:448a:20b0:e796:40a5:7e9b:5f54:b937', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-04 10:24:57'),
(110, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Logout', 'Autentikasi', 'GET', '/auth/logout', '2001:448a:20b0:e796:40a5:7e9b:5f54:b937', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-04 10:25:06'),
(111, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '2001:448a:20b0:e796:40a5:7e9b:5f54:b937', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-04 10:25:32'),
(112, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku', '2001:448a:20b0:e796:40a5:7e9b:5f54:b937', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-04 10:25:44'),
(113, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/12', '2001:448a:20b0:e796:40a5:7e9b:5f54:b937', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-04 10:25:46'),
(114, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/delete-detail/39', '2001:448a:20b0:e796:40a5:7e9b:5f54:b937', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-04 10:25:55'),
(115, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/12', '2001:448a:20b0:e796:40a5:7e9b:5f54:b937', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-04 10:25:55'),
(116, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/delete-detail/40', '2001:448a:20b0:e796:40a5:7e9b:5f54:b937', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-04 10:25:59'),
(117, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/12', '2001:448a:20b0:e796:40a5:7e9b:5f54:b937', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-04 10:25:59'),
(118, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/delete-detail/41', '2001:448a:20b0:e796:40a5:7e9b:5f54:b937', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-04 10:26:02'),
(119, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/12', '2001:448a:20b0:e796:40a5:7e9b:5f54:b937', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-04 10:26:02'),
(120, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/gizi/bahan-baku/store-detail', '2001:448a:20b0:e796:40a5:7e9b:5f54:b937', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-04 10:33:37'),
(121, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/12', '2001:448a:20b0:e796:40a5:7e9b:5f54:b937', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-04 10:33:37'),
(122, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku', '180.242.129.77', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-04 11:22:03'),
(123, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/12', '180.242.129.77', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-04 11:22:05'),
(124, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/delete-detail/42', '180.242.129.77', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-04 11:22:09'),
(125, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/12', '180.242.129.77', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-04 11:22:09'),
(126, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/gizi/bahan-baku/store-detail', '180.242.129.77', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-04 11:22:19'),
(127, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/12', '180.242.129.77', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-04 11:22:19'),
(128, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/gizi/bahan-baku/store-detail', '180.242.129.77', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-04 11:22:34'),
(129, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/12', '180.242.129.77', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-04 11:22:34'),
(130, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '180.242.129.77', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-04 14:59:02'),
(131, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '180.242.129.77', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-04 14:59:02'),
(132, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/sppg/select', '180.242.129.77', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-04 14:59:11'),
(133, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '180.242.129.77', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-04 14:59:11'),
(134, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '180.242.129.77', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-04 14:59:19'),
(135, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/bahan/update-harga/18', '180.242.129.77', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-04 14:59:39'),
(136, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '180.242.129.77', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-04 14:59:39'),
(137, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/bahan/update-harga/19', '180.242.129.77', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-04 15:00:08'),
(138, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '180.242.129.77', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-04 15:00:09'),
(139, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 16:52:22'),
(140, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 16:52:23'),
(141, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 16:52:31'),
(142, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/bahan/update-unit/38', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 16:53:45'),
(143, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 16:53:45'),
(144, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 16:54:45'),
(145, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Logout', 'Autentikasi', 'GET', '/auth/logout', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 18:31:45'),
(146, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 18:57:58'),
(147, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 19:21:57'),
(148, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 19:22:04'),
(149, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan/detail/9', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 19:22:10'),
(150, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 19:22:16'),
(151, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan/detail/4', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 19:22:19'),
(152, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 19:22:21'),
(153, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan/detail/9', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 19:22:23'),
(154, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 19:22:25'),
(155, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 19:22:29'),
(156, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 19:22:31'),
(157, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 19:22:36'),
(158, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 19:22:40'),
(159, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 19:22:49'),
(160, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 19:55:20'),
(161, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan/detail/9', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 19:55:38'),
(162, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Logout', 'Autentikasi', 'GET', '/auth/logout', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 20:03:09'),
(163, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 20:03:17'),
(164, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/master/users', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 20:03:35'),
(165, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Logout', 'Autentikasi', 'GET', '/auth/logout', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 20:04:12'),
(166, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 20:06:00'),
(167, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 20:06:00'),
(168, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Logout', 'Autentikasi', 'GET', '/auth/logout', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 20:06:05'),
(169, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 20:06:12'),
(170, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 20:06:12'),
(171, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/laporan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 20:06:17'),
(172, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 20:06:30'),
(173, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 20:06:32'),
(174, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan/detail/8', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 20:06:35'),
(175, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/keuangan/pengadaan/approve/8', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 20:06:52'),
(176, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan/detail/8', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 20:06:52');
INSERT INTO `user_activity_logs` (`id`, `user_id`, `id_sppg`, `user_level`, `username`, `activity`, `module`, `method`, `uri`, `ip_address`, `user_agent`, `created_at`) VALUES
(177, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 20:06:57'),
(178, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Logout', 'Autentikasi', 'GET', '/auth/logout', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 20:07:06'),
(179, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 20:07:22'),
(180, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/master/users', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 20:07:29'),
(181, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Logout', 'Autentikasi', 'GET', '/auth/logout', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 20:07:37'),
(182, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 20:10:17'),
(183, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 20:10:17'),
(184, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 20:10:22'),
(185, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 20:17:51'),
(186, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Logout', 'Autentikasi', 'GET', '/auth/logout', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 20:19:31'),
(187, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 20:19:42'),
(188, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/kepala/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 20:19:47'),
(189, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/kepala/pengadaan/detail/8', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 20:19:50'),
(190, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/kepala/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 20:19:58'),
(191, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Logout', 'Autentikasi', 'GET', '/auth/logout', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 20:20:04'),
(192, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 20:20:13'),
(193, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/kepala/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 20:20:16'),
(194, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/kepala/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 20:25:22'),
(195, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Logout', 'Autentikasi', 'GET', '/auth/logout', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 20:25:33'),
(196, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 20:25:44'),
(197, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 20:25:44'),
(198, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 20:25:48'),
(199, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 20:25:53'),
(200, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 20:42:29'),
(201, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Logout', 'Autentikasi', 'GET', '/auth/logout', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 20:42:43'),
(202, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 20:42:52'),
(203, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/kepala/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 20:42:54'),
(204, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/kepala/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 20:43:02'),
(205, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/kepala/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 21:00:13'),
(206, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Logout', 'Autentikasi', 'GET', '/auth/logout', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 21:00:18'),
(207, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 21:00:44'),
(208, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 21:00:44'),
(209, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 21:00:46'),
(210, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 21:02:41'),
(211, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Logout', 'Autentikasi', 'GET', '/auth/logout', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 21:02:43'),
(212, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 21:02:57'),
(213, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/kepala/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 21:03:00'),
(214, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Logout', 'Autentikasi', 'GET', '/auth/logout', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 21:39:15'),
(215, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 21:39:27'),
(216, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 21:39:27'),
(217, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/laporan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 21:39:41'),
(218, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 21:46:40'),
(219, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 21:47:26'),
(220, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 21:47:30'),
(221, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan/detail/9', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 21:47:41'),
(222, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 21:48:20'),
(223, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Logout', 'Autentikasi', 'GET', '/auth/logout', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 21:48:24'),
(224, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 19:36:34'),
(225, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 19:36:34'),
(226, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 19:36:40'),
(227, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 19:36:41'),
(228, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Logout', 'Autentikasi', 'GET', '/auth/logout', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 19:36:43'),
(229, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 19:36:48'),
(230, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/rencana-menu', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 19:36:53'),
(231, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 19:37:06'),
(232, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/create', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 19:37:08'),
(233, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/gizi/bahan-baku/store', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 19:37:24'),
(234, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/13', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 19:37:24'),
(235, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/gizi/bahan-baku/store-detail', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 19:37:39'),
(236, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/13', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 19:37:39'),
(237, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/gizi/bahan-baku/store-detail', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 19:37:51'),
(238, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/13', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 19:37:51'),
(239, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/gizi/bahan-baku/store-detail', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 19:38:04'),
(240, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/13', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 19:38:04'),
(241, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/gizi/bahan-baku/store-detail', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 19:38:28'),
(242, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/13', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 19:38:28'),
(243, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Mengirim pengajuan pembelian bahan ke Keuangan', 'Pengadaan Bahan', 'POST', '/gizi/bahan-baku/ajukan/13', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 19:38:48'),
(244, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/ajukan/13', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 19:38:48'),
(245, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/13', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 19:38:48'),
(246, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 19:40:27'),
(247, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Logout', 'Autentikasi', 'GET', '/auth/logout', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 19:56:31'),
(248, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 19:56:40'),
(249, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 19:56:41'),
(250, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 19:56:43'),
(251, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan/detail/13', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 19:57:16'),
(252, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Menolak pengajuan pembelian dan mengembalikannya ke Gizi', 'Pengadaan Bahan', 'POST', '/keuangan/pengadaan/reject/13', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 20:30:58'),
(253, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/keuangan/pengadaan/reject/13', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 20:30:58'),
(254, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan/detail/13', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 20:30:58'),
(255, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 20:31:09'),
(256, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Logout', 'Autentikasi', 'GET', '/auth/logout', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 20:31:38'),
(257, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 20:31:48'),
(258, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 20:31:51'),
(259, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/13', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 20:31:54'),
(260, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/gizi/bahan-baku/update-detail/47', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 20:32:10'),
(261, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/13', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 20:32:10'),
(262, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/gizi/bahan-baku/update-detail/47', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 20:32:26'),
(263, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/13', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 20:32:26'),
(264, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Logout', 'Autentikasi', 'GET', '/auth/logout', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 20:34:02'),
(265, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 20:34:14'),
(266, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 20:34:14'),
(267, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 20:34:17'),
(268, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Logout', 'Autentikasi', 'GET', '/auth/logout', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 20:37:18'),
(269, 17, 'Tampaksiring01', 'aslap', 'arini.anti@sigita-mbg.net', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 20:37:29'),
(270, 17, 'Tampaksiring01', 'aslap', 'arini.anti@sigita-mbg.net', 'Logout', 'Autentikasi', 'GET', '/auth/logout', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 20:48:29'),
(271, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 20:48:56'),
(272, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 20:49:15'),
(273, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/13', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 20:49:20'),
(274, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/gizi/bahan-baku/update-detail/47', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 20:49:31'),
(275, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/13', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 20:49:31'),
(276, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/13', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:23:00'),
(277, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/gizi/bahan-baku/update-detail/46', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:23:25'),
(278, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/13', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:23:26'),
(279, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/gizi/bahan-baku/update-detail/47', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:23:35'),
(280, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/13', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:23:35'),
(281, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/gizi/bahan-baku/store-detail', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:23:59'),
(282, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/13', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:23:59'),
(283, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/delete-detail/49', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:24:06'),
(284, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/13', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:24:06'),
(285, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Merevisi dan mengajukan ulang pembelian bahan ke Keuangan', 'Pengadaan Bahan', 'POST', '/gizi/bahan-baku/ajukan/13', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:24:17'),
(286, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/ajukan/13', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:24:17'),
(287, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/13', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:24:17'),
(288, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:24:25'),
(289, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Logout', 'Autentikasi', 'GET', '/auth/logout', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:25:13'),
(290, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:25:30'),
(291, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:25:30'),
(292, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:25:35'),
(293, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan/detail/13', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:25:56'),
(294, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Menyetujui pengajuan pembelian dan meneruskan ke Kepala SPPG', 'Pengadaan Bahan', 'POST', '/keuangan/pengadaan/approve/13', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:26:12'),
(295, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/keuangan/pengadaan/approve/13', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:26:12'),
(296, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan/detail/13', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:26:12'),
(297, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:26:38'),
(298, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/kepala/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:26:41'),
(299, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:26:49'),
(300, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:27:21'),
(301, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/kepala/pengadaan/detail/8', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:27:57'),
(302, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Menolak pengadaan dan mengembalikannya ke Gizi', 'Pengadaan Bahan', 'POST', '/kepala/pengadaan/reject/8', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:28:10'),
(303, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/kepala/pengadaan/reject/8', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:28:10'),
(304, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/kepala/pengadaan/detail/8', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:28:10'),
(305, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/kepala/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:28:25'),
(306, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/kepala/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:28:37'),
(307, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/kepala/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:28:41'),
(308, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/kepala/pengadaan/detail/13', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:28:45'),
(309, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Menyetujui pengadaan dan meneruskan ke Koperasi', 'Pengadaan Bahan', 'POST', '/kepala/pengadaan/approve/13', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:28:53'),
(310, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/kepala/pengadaan/approve/13', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:28:53'),
(311, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/kepala/pengadaan/detail/13', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:28:53'),
(312, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/kepala/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:28:59'),
(313, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:30:37'),
(314, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan/detail/8', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:30:45'),
(315, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:30:56'),
(316, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/kepala/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:34:21'),
(317, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/kepala/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:34:26'),
(318, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/kepala/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:34:30'),
(319, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/kepala/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:34:35'),
(320, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/kepala/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:34:39'),
(321, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/kepala/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:44:02'),
(322, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/kepala/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:44:04'),
(323, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/kepala/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:44:05'),
(324, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/kepala/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:44:07'),
(325, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/kepala/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:44:08'),
(326, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/kepala/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:44:13'),
(327, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/kepala/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:44:31'),
(328, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/kepala/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:44:35'),
(329, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/kepala/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:44:37'),
(330, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:44:55'),
(331, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Logout', 'Autentikasi', 'GET', '/auth/logout', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:44:59'),
(332, 17, 'Tampaksiring01', 'aslap', 'arini.anti@sigita-mbg.net', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:45:17'),
(333, 17, 'Tampaksiring01', 'aslap', 'arini.anti@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/aslap/penerima-manfaat', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:45:22'),
(334, 17, 'Tampaksiring01', 'aslap', 'arini.anti@sigita-mbg.net', 'Logout', 'Autentikasi', 'GET', '/auth/logout', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:45:25'),
(335, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:45:29'),
(336, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:45:31'),
(337, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Logout', 'Autentikasi', 'GET', '/auth/logout', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:45:34'),
(338, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:45:38'),
(339, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:45:39'),
(340, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:45:40'),
(341, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/kepala/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:46:06'),
(342, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:53:04'),
(343, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan/detail/13', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:54:33'),
(344, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:54:36'),
(345, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:57:54'),
(346, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:57:56');
INSERT INTO `user_activity_logs` (`id`, `user_id`, `id_sppg`, `user_level`, `username`, `activity`, `module`, `method`, `uri`, `ip_address`, `user_agent`, `created_at`) VALUES
(347, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:57:59'),
(348, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/laporan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:58:00'),
(349, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:58:06'),
(350, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 21:58:11'),
(351, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 22:02:11'),
(352, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/kepala/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 22:02:24'),
(353, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/kepala/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 22:02:32'),
(354, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/kepala/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 22:02:35'),
(355, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/kepala/pengadaan/detail/11', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 22:02:49'),
(356, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/kepala/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 22:02:51'),
(357, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/kepala/pengadaan/detail/13', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 22:02:53'),
(358, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/kepala/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 22:02:56'),
(359, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/kepala/pengadaan/detail/8', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 22:02:58'),
(360, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/kepala/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 22:03:00'),
(361, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/kepala/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 22:03:06'),
(362, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Logout', 'Autentikasi', 'GET', '/auth/logout', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 22:04:52'),
(363, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 22:05:04'),
(364, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 22:05:04'),
(365, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 22:24:27'),
(366, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 22:24:34'),
(367, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 22:24:47'),
(368, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 22:37:45'),
(369, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan/detail/13', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 22:38:05'),
(370, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 22:38:15'),
(371, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 22:42:03'),
(372, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 22:42:27'),
(373, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 22:47:18'),
(374, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 22:47:26'),
(375, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 22:47:28'),
(376, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 22:48:08'),
(377, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 22:48:21'),
(378, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 22:48:23'),
(379, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 22:48:32'),
(380, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 22:48:33'),
(381, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 22:48:36'),
(382, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 22:48:38'),
(383, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 22:48:40'),
(384, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 22:48:43'),
(385, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/laporan-pembelian', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 22:48:47'),
(386, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 22:48:49'),
(387, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 22:48:55'),
(388, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 22:52:33'),
(389, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 22:52:34'),
(390, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 22:52:35'),
(391, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 22:53:09'),
(392, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 22:53:09'),
(393, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 22:53:10'),
(394, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 22:53:15'),
(395, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 22:53:18'),
(396, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 22:53:21'),
(397, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan/detail/13', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 22:53:36'),
(398, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 22:53:47'),
(399, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 22:57:02'),
(400, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 22:57:04'),
(401, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 23:02:58'),
(402, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 23:03:01'),
(403, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 23:03:06'),
(404, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 23:03:08'),
(405, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 23:03:08'),
(406, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 23:03:09'),
(407, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 23:03:13'),
(408, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan/detail/13', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 23:03:17'),
(409, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 23:03:22'),
(410, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Logout', 'Autentikasi', 'GET', '/auth/logout', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 23:03:48'),
(411, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 23:03:56'),
(412, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 23:03:56'),
(413, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 23:03:58'),
(414, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 23:06:24'),
(415, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan/detail/13', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 23:06:35'),
(416, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Menerima pengadaan dan memulai proses', 'Pengadaan Bahan', 'POST', '/koperasi/pengadaan/process/13', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 23:06:46'),
(417, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/pengadaan/process/13', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 23:06:46'),
(418, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian/detail/1', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 23:06:46'),
(419, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian/detail/1', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 23:08:54'),
(420, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 19:19:39'),
(421, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 19:19:40'),
(422, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 19:19:42'),
(423, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan/detail/13', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 19:19:47'),
(424, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 19:19:58'),
(425, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian/detail/1', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 19:20:04'),
(426, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/pembelian/update/1', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 19:21:18'),
(427, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian/detail/1', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 19:21:18'),
(428, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Pembelian bahan selesai dilakukan', 'Pembelian Koperasi', 'POST', '/index.php/koperasi/pembelian/dibeli/1', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 19:23:23'),
(429, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/pembelian/dibeli/1', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 19:23:23'),
(430, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian/detail/1', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 19:23:23'),
(431, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Pembelian bahan dikirim ke SPPG', 'Pembelian Koperasi', 'POST', '/index.php/koperasi/pembelian/kirim/1', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 19:23:28'),
(432, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/pembelian/kirim/1', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 19:23:28'),
(433, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian/detail/1', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 19:23:28'),
(434, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 19:23:33'),
(435, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian/detail/1', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 19:23:39'),
(436, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 19:23:42'),
(437, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/laporan-pembelian', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 19:25:24'),
(438, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/laporan-pembelian', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 19:25:37'),
(439, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/laporan-pembelian', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 19:25:41'),
(440, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 19:25:43'),
(441, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 19:25:46'),
(442, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 19:25:48'),
(443, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 19:25:52'),
(444, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan/detail/13', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 19:25:55'),
(445, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 19:25:57'),
(446, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 19:25:59'),
(447, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Logout', 'Autentikasi', 'GET', '/auth/logout', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 19:26:12'),
(448, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 19:26:22'),
(449, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 19:26:22'),
(450, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 19:26:27'),
(451, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan/detail/9', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 19:26:38'),
(452, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Menyetujui pengajuan pembelian dan meneruskan ke Kepala SPPG', 'Pengadaan Bahan', 'POST', '/keuangan/pengadaan/approve/9', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 19:26:52'),
(453, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/keuangan/pengadaan/approve/9', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 19:26:52'),
(454, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan/detail/9', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 19:26:52'),
(455, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 19:26:58'),
(456, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 19:27:09'),
(457, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Logout', 'Autentikasi', 'GET', '/auth/logout', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 19:27:11'),
(458, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 19:27:20'),
(459, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 19:27:24'),
(460, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 19:38:05'),
(461, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 20:58:18'),
(462, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/11', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 20:58:26'),
(463, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 20:58:30'),
(464, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/8', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 20:58:45'),
(465, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/gizi/bahan-baku/update-detail/30', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 20:59:04'),
(466, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/8', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 20:59:04'),
(467, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/delete-detail/30', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 20:59:12'),
(468, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/8', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 20:59:12'),
(469, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 20:59:46'),
(470, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 21:33:10'),
(471, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 21:33:18'),
(472, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Menghapus transaksi pembelian bahan baku Draft', 'Pengadaan Bahan', 'POST', '/gizi/bahan-baku/delete/10', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 21:33:23'),
(473, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/gizi/bahan-baku/delete/10', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 21:33:23'),
(474, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 21:33:23'),
(475, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Menghapus transaksi pembelian bahan baku Draft', 'Pengadaan Bahan', 'POST', '/gizi/bahan-baku/delete/11', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 21:33:37'),
(476, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/gizi/bahan-baku/delete/11', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 21:33:37'),
(477, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 21:33:37'),
(478, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Menghapus transaksi pembelian bahan baku Draft', 'Pengadaan Bahan', 'POST', '/gizi/bahan-baku/delete/12', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 21:33:40'),
(479, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/gizi/bahan-baku/delete/12', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 21:33:40'),
(480, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 21:33:40'),
(481, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/menu/list', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 21:33:50'),
(482, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/menu/create', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 21:33:54'),
(483, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/menu/list', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 21:34:01'),
(484, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/data-pm', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 21:34:07'),
(485, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/kegiatan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 21:34:20'),
(486, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/kegiatan/create', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 21:34:28'),
(487, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/gizi/kegiatan/store', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 21:34:59'),
(488, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/kegiatan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 21:34:59'),
(489, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/kegiatan/detail/5', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 21:35:06'),
(490, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 03:37:47'),
(491, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/kegiatan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 03:37:51'),
(492, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/kegiatan/detail/5', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 03:37:54'),
(493, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/kegiatan/edit/5', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 03:38:01'),
(494, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/gizi/kegiatan/update/5', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 03:38:17'),
(495, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/kegiatan/detail/5', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 03:38:17'),
(496, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/kegiatan', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 03:38:27'),
(497, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/rencana-menu', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 03:38:42'),
(498, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/rencana-menu/detail/5', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 03:39:01'),
(499, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/rencana-menu', '103.136.57.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 03:39:11'),
(500, 31, NULL, 'super_admin', 'superadmin@sigita-mbg.net', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 20:43:05'),
(501, 31, NULL, 'super_admin', 'superadmin@sigita-mbg.net', 'Logout', 'Autentikasi', 'GET', '/auth/logout', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 20:45:48'),
(502, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 20:48:30'),
(503, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/rencana-menu', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 20:48:40'),
(504, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/rencana-menu/detail/4', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 20:49:11'),
(505, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/rencana-menu/detail/4', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 20:49:23'),
(506, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/rencana-menu', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 20:49:39'),
(507, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/rencana-menu/create', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 20:49:58'),
(508, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/rencana-menu', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 20:50:06'),
(509, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 20:50:26'),
(510, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/create', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 20:50:32'),
(511, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/gizi/bahan-baku/store', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 20:50:49'),
(512, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/14', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 20:50:49'),
(513, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 20:50:53'),
(514, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan/request/create', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 20:51:03'),
(515, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/gizi/bahan/request/store', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 20:51:26'),
(516, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan/request', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 20:51:26'),
(517, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 20:51:36'),
(518, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/14', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 20:51:39'),
(519, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/gizi/bahan-baku/store-detail', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 20:52:07');
INSERT INTO `user_activity_logs` (`id`, `user_id`, `id_sppg`, `user_level`, `username`, `activity`, `module`, `method`, `uri`, `ip_address`, `user_agent`, `created_at`) VALUES
(520, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/14', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 20:52:07'),
(521, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/gizi/bahan-baku/store-detail', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 20:52:17'),
(522, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/14', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 20:52:17'),
(523, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/gizi/bahan-baku/store-detail', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 20:52:27'),
(524, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/14', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 20:52:27'),
(525, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 20:53:10'),
(526, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 20:53:10'),
(527, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/request-bahan', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 20:53:25'),
(528, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/request-bahan/approve/3', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 20:53:38'),
(529, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/request-bahan', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 20:53:38'),
(530, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 20:53:48'),
(531, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 20:53:59'),
(532, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan/template-excel', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 20:54:14'),
(533, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/sppg/select', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 20:55:00'),
(534, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 20:55:01'),
(535, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/bahan/import-excel', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 20:56:34'),
(536, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 20:56:34'),
(537, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/bahan/import-excel', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 20:57:06'),
(538, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 20:57:06'),
(539, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/bahan/import-excel', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 20:57:31'),
(540, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 20:57:32'),
(541, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/bahan/import-excel', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 20:58:04'),
(542, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 20:58:04'),
(543, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/bahan/update-harga/130', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 20:58:33'),
(544, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 20:58:33'),
(545, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/bahan/update-unit/13', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 20:58:42'),
(546, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 20:58:43'),
(547, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan/history/13', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 20:58:55'),
(548, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 20:59:00'),
(549, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan/history/130', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 20:59:06'),
(550, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 20:59:09'),
(551, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/bahan/update-harga/19', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 20:59:23'),
(552, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 20:59:24'),
(553, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan/history/19', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 20:59:27'),
(554, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 20:59:30'),
(555, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/14', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 20:59:50'),
(556, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/gizi/bahan-baku/store-detail', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:00:02'),
(557, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/14', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:00:03'),
(558, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Mengirim pengajuan pembelian bahan ke Keuangan', 'Pengadaan Bahan', 'POST', '/gizi/bahan-baku/ajukan/14', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:00:09'),
(559, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/ajukan/14', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:00:09'),
(560, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/14', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:00:09'),
(561, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Logout', 'Autentikasi', 'GET', '/auth/logout', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:00:37'),
(562, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:00:46'),
(563, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:00:46'),
(564, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:00:53'),
(565, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan/detail/14', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:01:16'),
(566, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Menolak pengajuan pembelian dan mengembalikannya ke Gizi', 'Pengadaan Bahan', 'POST', '/keuangan/pengadaan/reject/14', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:01:41'),
(567, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/keuangan/pengadaan/reject/14', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:01:41'),
(568, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan/detail/14', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:01:42'),
(569, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:01:53'),
(570, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/14', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:01:57'),
(571, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/delete-detail/52', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:02:07'),
(572, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/14', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:02:07'),
(573, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Merevisi dan mengajukan ulang pembelian bahan ke Keuangan', 'Pengadaan Bahan', 'POST', '/gizi/bahan-baku/ajukan/14', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:02:13'),
(574, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/ajukan/14', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:02:13'),
(575, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/14', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:02:13'),
(576, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:02:20'),
(577, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan/detail/14', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:02:25'),
(578, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Menyetujui pengajuan pembelian dan meneruskan ke Kepala SPPG', 'Pengadaan Bahan', 'POST', '/keuangan/pengadaan/approve/14', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:02:30'),
(579, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/keuangan/pengadaan/approve/14', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:02:30'),
(580, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan/detail/14', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:02:30'),
(581, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:02:34'),
(582, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Logout', 'Autentikasi', 'GET', '/auth/logout', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:02:36'),
(583, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:02:43'),
(584, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/kepala/pengadaan', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:02:51'),
(585, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/kepala/pengadaan/detail/9', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:02:57'),
(586, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Menolak pengadaan dan mengembalikannya ke Gizi', 'Pengadaan Bahan', 'POST', '/kepala/pengadaan/reject/9', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:03:08'),
(587, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/kepala/pengadaan/reject/9', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:03:08'),
(588, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/kepala/pengadaan/detail/9', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:03:09'),
(589, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/kepala/pengadaan', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:03:15'),
(590, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/kepala/pengadaan', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:03:21'),
(591, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/kepala/pengadaan/detail/14', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:03:23'),
(592, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Menyetujui pengadaan dan meneruskan ke Koperasi', 'Pengadaan Bahan', 'POST', '/kepala/pengadaan/approve/14', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:03:31'),
(593, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/kepala/pengadaan/approve/14', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:03:31'),
(594, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/kepala/pengadaan/detail/14', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:03:31'),
(595, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/kepala/pengadaan', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:03:33'),
(596, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Logout', 'Autentikasi', 'GET', '/auth/logout', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:03:35'),
(597, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:03:38'),
(598, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:03:39'),
(599, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:03:48'),
(600, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan/detail/14', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:03:50'),
(601, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Menerima pengadaan dan memulai proses', 'Pengadaan Bahan', 'POST', '/koperasi/pengadaan/process/14', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:04:14'),
(602, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/pengadaan/process/14', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:04:14'),
(603, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian/detail/2', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:04:14'),
(604, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/pembelian/update/2', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:05:11'),
(605, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian/detail/2', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:05:11'),
(606, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/pembelian/update/2', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:05:26'),
(607, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian/detail/2', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:05:26'),
(608, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Pembelian bahan selesai dilakukan', 'Pembelian Koperasi', 'POST', '/index.php/koperasi/pembelian/dibeli/2', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:06:18'),
(609, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/pembelian/dibeli/2', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:06:18'),
(610, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian/detail/2', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:06:18'),
(611, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Pembelian bahan dikirim ke SPPG', 'Pembelian Koperasi', 'POST', '/index.php/koperasi/pembelian/kirim/2', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:07:00'),
(612, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/pembelian/kirim/2', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:07:00'),
(613, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian/detail/2', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:07:00'),
(614, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:07:09'),
(615, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:07:50'),
(616, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan/detail/14', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:07:51'),
(617, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:08:04'),
(618, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/8', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:08:08'),
(619, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Merevisi dan mengajukan ulang pembelian bahan ke Keuangan', 'Pengadaan Bahan', 'POST', '/gizi/bahan-baku/ajukan/8', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:08:14'),
(620, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/ajukan/8', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:08:14'),
(621, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/8', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:08:14'),
(622, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Logout', 'Autentikasi', 'GET', '/auth/logout', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:08:21'),
(623, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:08:34'),
(624, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:08:34'),
(625, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:08:38'),
(626, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan/detail/8', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:08:43'),
(627, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Menyetujui pengajuan pembelian dan meneruskan ke Kepala SPPG', 'Pengadaan Bahan', 'POST', '/keuangan/pengadaan/approve/8', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:08:52'),
(628, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/keuangan/pengadaan/approve/8', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:08:52'),
(629, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan/detail/8', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:08:52'),
(630, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:08:55'),
(631, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan/detail/7', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:08:59'),
(632, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Menolak pengajuan pembelian dan mengembalikannya ke Gizi', 'Pengadaan Bahan', 'POST', '/keuangan/pengadaan/reject/7', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:09:11'),
(633, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/keuangan/pengadaan/reject/7', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:09:11'),
(634, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan/detail/7', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:09:11'),
(635, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:09:14'),
(636, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Logout', 'Autentikasi', 'GET', '/auth/logout', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:09:20'),
(637, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:09:25'),
(638, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/kepala/pengadaan', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:09:28'),
(639, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/kepala/pengadaan/detail/8', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:09:30'),
(640, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Menyetujui pengadaan dan meneruskan ke Koperasi', 'Pengadaan Bahan', 'POST', '/kepala/pengadaan/approve/8', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:09:33'),
(641, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/kepala/pengadaan/approve/8', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:09:33'),
(642, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/kepala/pengadaan/detail/8', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:09:33'),
(643, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:09:41'),
(644, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan/detail/8', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:09:46'),
(645, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:14:32'),
(646, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:14:39'),
(647, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:15:28'),
(648, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:15:32'),
(649, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan/detail/8', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:15:35'),
(650, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:19:17'),
(651, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:19:20'),
(652, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:19:33'),
(653, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:19:49'),
(654, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:22:24'),
(655, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:22:27'),
(656, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan/detail/8', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:23:02'),
(657, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Menerima pengadaan dan memulai proses', 'Pengadaan Bahan', 'POST', '/koperasi/pengadaan/process/8', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:23:10'),
(658, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/pengadaan/process/8', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:23:10'),
(659, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian/detail/3', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:23:10'),
(660, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:44:10'),
(661, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:44:13'),
(662, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/sppg/select', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:44:20'),
(663, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:44:20'),
(664, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/sppg/select', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:44:32'),
(665, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:44:32'),
(666, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan/history/29', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:44:38'),
(667, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:44:40'),
(668, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:45:39'),
(669, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:45:42'),
(670, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan/detail/8', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:45:49'),
(671, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:45:53'),
(672, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:45:58'),
(673, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:46:00'),
(674, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan/detail/8', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:46:02'),
(675, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:46:10'),
(676, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian/detail/3', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:46:13'),
(677, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:46:31'),
(678, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian/detail/2', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 21:46:32'),
(679, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-18 21:30:44'),
(680, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-18 21:30:44'),
(681, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-19 12:48:03'),
(682, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-19 12:48:03'),
(683, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-19 12:48:09'),
(684, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian/detail/3', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-19 12:48:11'),
(685, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian/detail/3', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-19 13:41:48'),
(686, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian/detail/3', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-19 13:59:58'),
(687, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian/detail/3', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-19 14:01:19'),
(688, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-19 14:02:15'),
(689, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian/detail/1', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-19 14:02:17');
INSERT INTO `user_activity_logs` (`id`, `user_id`, `id_sppg`, `user_level`, `username`, `activity`, `module`, `method`, `uri`, `ip_address`, `user_agent`, `created_at`) VALUES
(690, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-19 14:02:23'),
(691, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-19 14:02:30'),
(692, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-19 14:02:37'),
(693, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/create', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-19 14:02:39'),
(694, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-19 14:02:42'),
(695, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/create', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-19 15:34:36'),
(696, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-19 15:35:08'),
(697, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-19 15:35:12'),
(698, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-19 15:35:16'),
(699, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/create', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-19 15:35:18'),
(700, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-20 15:02:28'),
(701, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-20 15:02:28'),
(702, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-20 15:02:38'),
(703, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/create', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-20 15:02:39'),
(704, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/create', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-20 15:49:22'),
(705, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/create', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-20 15:58:33'),
(706, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/create', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-20 16:02:15'),
(707, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/supplier/store', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-20 16:04:54'),
(708, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/detail/1', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-20 16:04:54'),
(709, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/detail/1', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-20 16:05:18'),
(710, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/detail/1', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-20 16:05:29'),
(711, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/detail/1', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-20 16:05:35'),
(712, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-20 16:06:02'),
(713, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-20 16:06:15'),
(714, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-20 16:06:20'),
(715, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/sppg/select', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-20 16:06:34'),
(716, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-20 16:06:34'),
(717, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-20 16:06:39'),
(718, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-20 16:06:44'),
(719, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan/detail/8', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-20 16:06:51'),
(720, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-20 16:06:54'),
(721, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian/detail/3', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-20 16:06:57'),
(722, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-20 16:07:07'),
(723, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-20 16:27:12'),
(724, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-20 16:27:16'),
(725, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/create', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-20 16:27:20'),
(726, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-20 16:27:22'),
(727, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-20 16:27:23'),
(728, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-20 16:27:27'),
(729, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-27 20:16:31'),
(730, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-27 20:16:31'),
(731, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-27 20:18:12'),
(732, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/detail/1', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-27 20:18:19'),
(733, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-27 20:18:24'),
(734, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/create', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-27 20:18:26'),
(735, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-27 20:18:43'),
(736, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/create', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-27 20:18:47'),
(737, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-27 20:19:01'),
(738, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-27 20:19:08'),
(739, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/sppg/select', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-27 20:19:13'),
(740, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-27 20:19:13'),
(741, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-27 20:19:18'),
(742, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/create', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-27 20:19:23'),
(743, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-27 20:19:37'),
(744, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-27 20:20:12'),
(745, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-27 20:20:30'),
(746, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-27 20:20:32'),
(747, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-27 20:20:38'),
(748, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/sppg/select', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-27 20:20:47'),
(749, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-27 20:20:47'),
(750, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-27 20:20:55'),
(751, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-27 20:20:58'),
(752, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-27 20:21:02'),
(753, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-27 20:21:05'),
(754, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian/detail/3', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-27 20:21:08'),
(755, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian/detail/3', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-27 20:40:03'),
(756, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian/detail/3', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-27 21:10:28'),
(757, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-27 21:11:29'),
(758, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-27 21:11:29'),
(759, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-27 21:11:36'),
(760, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/create', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-27 21:11:41'),
(761, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/supplier/store', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-27 21:15:44'),
(762, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/create', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-27 21:15:44'),
(763, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/supplier/store', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-27 21:18:55'),
(764, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/detail/2', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-27 21:18:55'),
(765, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-27 21:19:07'),
(766, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian/detail/3', '103.136.57.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-27 21:19:18'),
(767, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '222.165.230.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-28 11:45:39'),
(768, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '222.165.230.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-28 11:45:39'),
(769, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '222.165.230.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-28 15:34:15'),
(770, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '222.165.230.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-28 15:34:15'),
(771, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian', '222.165.230.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-28 15:34:40'),
(772, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian/detail/3', '222.165.230.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-28 15:34:44'),
(773, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier', '222.165.230.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-28 15:34:57'),
(774, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/create', '222.165.230.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-28 15:35:03'),
(775, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/supplier/store', '222.165.230.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-28 15:40:34'),
(776, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/detail/3', '222.165.230.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-28 15:40:34'),
(777, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/detail/3', '222.165.230.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-28 15:40:57'),
(778, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian/detail/3', '222.165.230.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-28 15:41:27'),
(779, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian', '222.165.230.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-28 15:41:33'),
(780, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian/detail/3', '222.165.230.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-28 15:41:35'),
(781, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian/detail/3', '222.165.230.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-28 15:42:03'),
(782, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/edit/3', '222.165.230.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-28 15:42:14'),
(783, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/supplier/update/3', '222.165.230.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-28 15:42:25'),
(784, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/detail/3', '222.165.230.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-28 15:42:25'),
(785, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian/detail/3', '222.165.230.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-28 15:42:30'),
(786, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/detail/3', '222.165.230.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-28 15:42:58'),
(787, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/pembelian/update/3', '222.165.230.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-28 15:43:43'),
(788, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian/detail/3', '222.165.230.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-28 15:43:43'),
(789, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Pembelian bahan selesai dilakukan', 'Pembelian Koperasi', 'POST', '/index.php/koperasi/pembelian/dibeli/3', '222.165.230.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-28 15:43:57'),
(790, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/pembelian/dibeli/3', '222.165.230.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-28 15:43:57'),
(791, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian/detail/3', '222.165.230.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-28 15:43:58'),
(792, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier', '222.165.230.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-28 15:44:51'),
(793, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/detail/2', '222.165.230.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-28 15:44:55'),
(794, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/detail/2', '222.165.230.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-28 15:44:58'),
(795, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/detail/2', '222.165.230.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-28 15:54:03'),
(796, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/supplier/update-harga/4', '222.165.230.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-28 15:55:33'),
(797, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/detail/2', '222.165.230.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-28 15:55:33'),
(798, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier', '222.165.230.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-28 15:55:42'),
(799, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian/detail/3', '222.165.230.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-28 15:55:57'),
(800, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/detail/2', '222.165.230.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-28 15:56:16'),
(801, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/detail/2', '222.165.230.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-28 15:56:21'),
(802, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier', '222.165.230.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-28 15:56:43'),
(803, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '222.165.230.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-28 15:56:45'),
(804, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '222.165.230.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-28 15:56:56'),
(805, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/sppg/select', '222.165.230.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-28 15:57:00'),
(806, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '222.165.230.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-28 15:57:00'),
(807, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/sppg/select', '222.165.230.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-28 15:58:27'),
(808, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '222.165.230.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-28 15:58:27'),
(809, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 09:49:58'),
(810, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 09:49:58'),
(811, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 09:50:09'),
(812, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/sppg/select', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 09:50:25'),
(813, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 09:50:25'),
(814, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 09:53:30'),
(815, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 09:53:34'),
(816, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian/detail/3', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 09:53:36'),
(817, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 10:00:28'),
(818, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian/detail/3', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 11:36:25'),
(819, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian/detail/3', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 11:36:28'),
(820, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian/detail/3', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 11:36:43'),
(821, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 11:36:46'),
(822, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian/detail/3', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 11:36:48'),
(823, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 11:40:20'),
(824, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 11:40:23'),
(825, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 11:40:25'),
(826, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 11:40:29'),
(827, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan/detail/13', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 11:40:36'),
(828, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 11:40:43'),
(829, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan/detail/14', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 11:40:46'),
(830, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 11:40:49'),
(831, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan/detail/8', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 11:40:52'),
(832, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 11:41:07'),
(833, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian/detail/3', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 11:41:09'),
(834, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/sppg/select', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 11:41:22'),
(835, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian/detail/3', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 11:41:22'),
(836, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/sppg/select', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 11:41:30'),
(837, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian/detail/3', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 11:41:30'),
(838, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 11:41:38'),
(839, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 11:41:42'),
(840, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 11:41:45'),
(841, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan/history/13', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 11:42:01'),
(842, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 11:42:07'),
(843, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Pembelian bahan dikirim ke SPPG', 'Pembelian Koperasi', 'POST', '/index.php/koperasi/pembelian/kirim/3', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 11:42:20'),
(844, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/pembelian/kirim/3', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 11:42:20'),
(845, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian/detail/3', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 11:42:20'),
(846, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 11:42:26'),
(847, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/laporan-pembelian', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 11:42:33'),
(848, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian/detail/3', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 11:42:45'),
(849, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 11:42:50'),
(850, 17, 'Tampaksiring01', 'aslap', 'arini.anti@sigita-mbg.net', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 11:44:04'),
(851, 17, 'Tampaksiring01', 'aslap', 'arini.anti@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/aslap/penerima-manfaat', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 11:44:20'),
(852, 17, 'Tampaksiring01', 'aslap', 'arini.anti@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/aslap/penerima-manfaat/detail/19', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 11:44:24'),
(853, 17, 'Tampaksiring01', 'aslap', 'arini.anti@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/aslap/penerima-manfaat', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 11:44:30'),
(854, 17, 'Tampaksiring01', 'aslap', 'arini.anti@sigita-mbg.net', 'Logout', 'Autentikasi', 'GET', '/auth/logout', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 11:44:32'),
(855, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 11:44:39'),
(856, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 11:44:56'),
(857, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/create', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 11:45:02'),
(858, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/gizi/bahan-baku/store', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 11:45:13'),
(859, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/15', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 11:45:13'),
(860, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/gizi/bahan-baku/store-detail', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 11:45:31'),
(861, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/15', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 11:45:31'),
(862, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/gizi/bahan-baku/store-detail', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 11:45:46'),
(863, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/15', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 11:45:46'),
(864, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/gizi/bahan-baku/store-detail', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 11:46:00');
INSERT INTO `user_activity_logs` (`id`, `user_id`, `id_sppg`, `user_level`, `username`, `activity`, `module`, `method`, `uri`, `ip_address`, `user_agent`, `created_at`) VALUES
(865, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/15', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 11:46:00'),
(866, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/gizi/bahan-baku/store-detail', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 11:50:46'),
(867, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/15', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 11:50:46'),
(868, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 12:05:24'),
(869, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 13:59:56'),
(870, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 14:00:20'),
(871, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 14:00:24'),
(872, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/15', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 14:00:28'),
(873, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/delete-detail/57', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 14:00:32'),
(874, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/15', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 14:00:32'),
(875, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/gizi/bahan-baku/store-detail', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 14:00:51'),
(876, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/15', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 14:00:51'),
(877, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Mengirim pengajuan pembelian bahan ke Keuangan', 'Pengadaan Bahan', 'POST', '/gizi/bahan-baku/ajukan/15', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 14:01:12'),
(878, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/ajukan/15', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 14:01:12'),
(879, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/15', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 14:01:12'),
(880, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Logout', 'Autentikasi', 'GET', '/auth/logout', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 14:01:31'),
(881, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 14:01:43'),
(882, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 14:01:43'),
(883, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 14:01:56'),
(884, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan/detail/15', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 14:02:03'),
(885, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Menyetujui pengajuan pembelian dan meneruskan ke Kepala SPPG', 'Pengadaan Bahan', 'POST', '/keuangan/pengadaan/approve/15', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 14:02:42'),
(886, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/keuangan/pengadaan/approve/15', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 14:02:42'),
(887, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan/detail/15', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 14:02:42'),
(888, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 14:02:50'),
(889, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Logout', 'Autentikasi', 'GET', '/auth/logout', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 14:02:53'),
(890, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 14:03:04'),
(891, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/kepala/pengadaan', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 14:03:08'),
(892, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/kepala/pengadaan/detail/15', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 14:03:13'),
(893, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Menyetujui pengadaan dan meneruskan ke Koperasi', 'Pengadaan Bahan', 'POST', '/kepala/pengadaan/approve/15', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 14:03:40'),
(894, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/kepala/pengadaan/approve/15', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 14:03:40'),
(895, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/kepala/pengadaan/detail/15', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 14:03:40'),
(896, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/sppg/select', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 14:03:50'),
(897, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 14:03:50'),
(898, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 14:03:59'),
(899, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 14:04:01'),
(900, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 14:04:07'),
(901, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 14:04:15'),
(902, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/kepala/pengadaan', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 14:04:25'),
(903, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 14:04:35'),
(904, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan/detail/15', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 14:04:43'),
(905, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Menerima pengadaan dan memulai proses', 'Pengadaan Bahan', 'POST', '/koperasi/pengadaan/process/15', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 14:05:35'),
(906, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/pengadaan/process/15', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 14:05:35'),
(907, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian/detail/4', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 14:05:35'),
(908, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '111.68.121.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 14:06:18'),
(909, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 14:20:15'),
(910, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 14:20:15'),
(911, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 14:20:25'),
(912, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian/detail/4', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 14:20:30'),
(913, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 14:20:44'),
(914, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Logout', 'Autentikasi', 'GET', '/auth/logout', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 14:20:53'),
(915, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 14:20:58'),
(916, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 14:21:06'),
(917, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/15', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 14:21:11'),
(918, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 14:21:14'),
(919, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Logout', 'Autentikasi', 'GET', '/auth/logout', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 14:21:17'),
(920, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 14:21:31'),
(921, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 14:21:32'),
(922, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 14:24:12'),
(923, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan/detail/15', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 14:24:17'),
(924, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 14:24:20'),
(925, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian/detail/4', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 14:24:22'),
(926, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 14:24:25'),
(927, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian/detail/4', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 14:24:29'),
(928, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 14:25:09'),
(929, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/laporan-pembelian', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 14:25:12'),
(930, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 14:25:39'),
(931, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 14:25:52'),
(932, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/create', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 14:25:58'),
(933, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 14:26:06'),
(934, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/create', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 14:26:09'),
(935, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 14:26:39'),
(936, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 14:26:43'),
(937, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/sppg/select', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 14:26:47'),
(938, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 14:26:47'),
(939, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 14:26:49'),
(940, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/create', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 14:26:52'),
(941, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 14:27:07'),
(942, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 14:27:09'),
(943, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 14:27:15'),
(944, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/create', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 14:27:18'),
(945, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/supplier/store', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 14:28:15'),
(946, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/create', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 14:28:15'),
(947, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 14:28:24'),
(948, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 14:28:26'),
(949, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Logout', 'Autentikasi', 'GET', '/auth/logout', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 14:28:31'),
(950, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 14:28:39'),
(951, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 14:28:39'),
(952, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 14:28:46'),
(953, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/create', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 14:28:52'),
(954, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 17:17:28'),
(955, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 17:17:29'),
(956, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 17:17:32'),
(957, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/create', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 17:17:38'),
(958, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 17:17:42'),
(959, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 17:18:36'),
(960, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 17:18:56'),
(961, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Logout', 'Autentikasi', 'GET', '/auth/logout', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 17:19:01'),
(962, 31, NULL, 'super_admin', 'superadmin@sigita-mbg.net', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 17:19:09'),
(963, 31, NULL, 'super_admin', 'superadmin@sigita-mbg.net', 'Logout', 'Autentikasi', 'GET', '/auth/logout', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 17:20:02'),
(964, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 17:20:07'),
(965, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 17:20:07'),
(966, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 17:20:12'),
(967, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/create', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 17:20:13'),
(968, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/supplier/store', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 17:22:01'),
(969, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/create', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 17:22:01'),
(970, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/supplier/store', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 17:22:32'),
(971, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/create', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 17:22:32'),
(972, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/supplier/store', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 17:23:05'),
(973, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/create', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 17:23:05'),
(974, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/supplier/store', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 17:23:22'),
(975, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/create', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 17:23:22'),
(976, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 19:59:12'),
(977, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 19:59:12'),
(978, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 19:59:16'),
(979, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/create', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 19:59:25'),
(980, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/create', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 20:16:01'),
(981, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 20:16:04'),
(982, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/create', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 20:16:07'),
(983, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 20:16:33'),
(984, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 20:16:37'),
(985, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/create', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 20:16:38'),
(986, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/create', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 20:16:42'),
(987, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 20:16:45'),
(988, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/create', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 20:16:47'),
(989, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 20:17:33'),
(990, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 20:17:37'),
(991, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/sppg/select', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 20:17:41'),
(992, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 20:17:41'),
(993, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 20:17:43'),
(994, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/create', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 20:17:45'),
(995, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/supplier/store', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 20:18:08'),
(996, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/detail/4', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 20:18:08'),
(997, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/edit/4', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 20:18:12'),
(998, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 20:18:19'),
(999, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/edit/3', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 20:18:26'),
(1000, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 20:18:32'),
(1001, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/detail/1', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 20:18:34'),
(1002, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 20:18:37'),
(1003, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/edit/4', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 20:18:43'),
(1004, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/supplier/update/4', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 20:18:58'),
(1005, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/detail/4', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 20:18:58'),
(1006, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/supplier/link-bahan/4', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 20:19:20'),
(1007, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/detail/4', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 20:19:20'),
(1008, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/history-harga/10', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 20:19:30'),
(1009, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/detail/4', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 20:19:31'),
(1010, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 20:19:42'),
(1011, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/edit/1', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 20:19:47'),
(1012, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/edit/1', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 20:24:40'),
(1013, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 20:24:43'),
(1014, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/create', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 20:24:45'),
(1015, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/supplier/store', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 20:25:27'),
(1016, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/detail/5', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 20:25:27'),
(1017, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/edit/5', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 20:25:31'),
(1018, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/supplier/update/5', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 20:26:03'),
(1019, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/detail/5', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 20:26:03'),
(1020, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 20:26:16'),
(1021, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 20:26:18'),
(1022, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 20:26:24'),
(1023, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/sppg/select', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 20:26:41'),
(1024, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 20:26:41'),
(1025, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan/template-excel', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 20:27:09'),
(1026, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/bahan/update-harga/23', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 20:28:12'),
(1027, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 20:28:12'),
(1028, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 20:28:37'),
(1029, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 20:28:43'),
(1030, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan/detail/15', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 20:28:46'),
(1031, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 20:28:47'),
(1032, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian/detail/4', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 20:28:49'),
(1033, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/pembelian/update/4', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 20:29:32'),
(1034, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian/detail/4', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 20:29:32'),
(1035, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 12:06:31'),
(1036, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 12:06:32'),
(1037, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 12:06:36'),
(1038, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 12:06:45');
INSERT INTO `user_activity_logs` (`id`, `user_id`, `id_sppg`, `user_level`, `username`, `activity`, `module`, `method`, `uri`, `ip_address`, `user_agent`, `created_at`) VALUES
(1039, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/laporan-pembelian', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 12:06:51'),
(1040, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 12:07:04'),
(1041, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 12:07:07'),
(1042, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/edit/3', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 12:07:15'),
(1043, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/supplier/update/3', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 12:07:39'),
(1044, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/detail/3', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 12:07:39'),
(1045, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 12:07:45'),
(1046, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/edit/1', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 12:07:49'),
(1047, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/supplier/update/1', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 12:08:01'),
(1048, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/detail/1', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 12:08:02'),
(1049, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 12:08:04'),
(1050, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '103.136.57.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 12:08:10'),
(1051, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '103.150.169.9', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-13 09:28:07'),
(1052, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '103.150.169.9', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-13 09:28:08'),
(1053, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '103.150.169.9', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-13 09:28:28'),
(1054, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '103.150.169.9', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-13 09:28:35'),
(1055, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian', '103.150.169.9', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-13 09:28:38'),
(1056, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian/detail/4', '103.150.169.9', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-13 09:28:41'),
(1057, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian', '103.150.169.9', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-13 09:31:16'),
(1058, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '103.150.169.9', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-13 09:31:18'),
(1059, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '103.150.169.9', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-13 09:31:34'),
(1060, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '103.150.169.9', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-13 10:46:27'),
(1061, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '103.150.169.6', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-13 18:12:14'),
(1062, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '103.150.169.6', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-13 18:12:14'),
(1063, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '103.150.169.6', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-13 18:12:16'),
(1064, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan/template-excel', '103.150.169.6', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-13 18:12:22'),
(1065, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/sppg/select', '103.150.169.6', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-13 18:13:05'),
(1066, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '103.150.169.6', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-13 18:13:05'),
(1067, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan/template-excel', '103.150.169.6', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-13 18:13:11'),
(1068, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/bahan/import-excel', '103.150.169.6', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-13 18:14:44'),
(1069, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '103.150.169.6', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-13 18:14:44'),
(1070, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '103.150.169.6', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-13 18:15:51'),
(1071, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '103.150.169.6', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-13 18:16:14'),
(1072, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '103.150.169.6', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-13 18:16:17'),
(1073, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '103.150.169.6', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-13 18:16:19'),
(1074, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan', '103.150.169.6', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-13 18:16:23'),
(1075, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan/detail/15', '103.150.169.6', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-13 18:16:25'),
(1076, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian', '103.150.169.6', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-13 18:16:27'),
(1077, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian/detail/4', '103.150.169.6', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-13 18:16:28'),
(1078, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Logout', 'Autentikasi', 'GET', '/auth/logout', '103.150.169.6', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-13 18:16:51'),
(1079, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '103.150.169.6', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 07:23:10'),
(1080, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '103.150.169.6', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 07:23:10'),
(1081, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Logout', 'Autentikasi', 'GET', '/auth/logout', '103.150.169.6', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 07:23:14'),
(1082, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '103.150.169.6', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 07:23:19'),
(1083, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan', '103.150.169.6', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 07:23:25'),
(1084, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan', '103.150.169.6', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 07:23:36'),
(1085, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan', '103.150.169.6', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 07:29:08'),
(1086, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan', '103.150.169.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 08:12:29'),
(1087, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan', '103.150.169.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 08:12:33'),
(1088, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan/detail/15', '103.150.169.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 08:12:38'),
(1089, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan', '103.150.169.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 08:12:48'),
(1090, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan', '103.150.169.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 08:13:07'),
(1091, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/laporan', '103.150.169.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 08:13:53'),
(1092, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan', '103.150.169.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 08:13:59'),
(1093, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan', '103.150.169.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 08:14:01'),
(1094, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan', '103.150.169.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 08:21:14'),
(1095, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan/invoice/14', '103.150.169.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 08:22:24'),
(1096, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan/detail/14', '103.150.169.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 08:23:27'),
(1097, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan', '103.150.169.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 08:23:35'),
(1098, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '103.150.169.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 15:35:03'),
(1099, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan', '103.150.169.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 15:35:03'),
(1100, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/laporan', '103.150.169.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 15:35:07'),
(1101, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan', '103.150.169.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 15:35:21'),
(1102, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan', '103.150.169.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 15:35:22'),
(1103, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan/detail/15', '103.150.169.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 15:35:37'),
(1104, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan', '103.150.169.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 15:35:40'),
(1105, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan', '103.150.169.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 15:36:03'),
(1106, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan', '103.150.169.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 15:36:19'),
(1107, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan/invoice/14', '103.150.169.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 15:36:20'),
(1108, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan/invoice/14', '103.150.169.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 15:42:03'),
(1109, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan/invoice/14', '103.150.169.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 15:42:06'),
(1110, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan/detail/14', '103.150.169.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 15:42:29'),
(1111, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan', '103.150.169.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 15:42:33'),
(1112, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan', '103.150.169.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 15:43:02'),
(1113, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan', '103.150.169.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 15:47:34'),
(1114, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan', '103.150.169.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 15:47:38'),
(1115, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/laporan', '103.150.169.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 15:47:45'),
(1116, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan', '103.150.169.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 15:48:04'),
(1117, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan', '103.150.169.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 15:52:04'),
(1118, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/petty-cash', '103.150.169.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 15:52:09'),
(1119, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan', '103.150.169.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 15:52:12'),
(1120, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/petty-cash', '103.150.169.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 15:52:13'),
(1121, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/keuangan/petty-cash/store', '103.150.169.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 15:53:44'),
(1122, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/petty-cash', '103.150.169.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 15:53:44'),
(1123, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan', '103.150.169.6', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 17:07:02'),
(1124, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/petty-cash', '103.150.169.6', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 17:07:07'),
(1125, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan', '103.150.169.6', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 17:08:10'),
(1126, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/laporan', '103.150.169.6', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 17:08:12'),
(1127, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/petty-cash', '103.150.169.6', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 17:09:12'),
(1128, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/keuangan/petty-cash/store', '103.150.169.6', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 17:10:24'),
(1129, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/petty-cash', '103.150.169.6', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 17:10:24'),
(1130, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/petty-cash', '103.150.169.6', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 17:10:29'),
(1131, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/keuangan/petty-cash/update/2', '103.150.169.6', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 17:10:45'),
(1132, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/petty-cash', '103.150.169.6', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 17:10:45'),
(1133, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/keuangan/petty-cash/store', '103.150.169.6', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 17:11:22'),
(1134, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/petty-cash', '103.150.169.6', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 17:11:22'),
(1135, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/keuangan/petty-cash/store', '103.150.169.6', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 17:11:38'),
(1136, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/petty-cash', '103.150.169.6', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 17:11:38'),
(1137, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/keuangan/petty-cash/delete/3', '103.150.169.6', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 17:11:52'),
(1138, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/petty-cash', '103.150.169.6', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 17:11:52'),
(1139, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/keuangan/petty-cash/store', '103.150.169.6', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 17:12:33'),
(1140, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/petty-cash', '103.150.169.6', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 17:12:33'),
(1141, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan', '103.150.169.6', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 17:12:50'),
(1142, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/laporan', '103.150.169.6', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 17:14:34'),
(1143, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/laporan', '103.150.169.6', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 17:21:27'),
(1144, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan', '103.150.169.6', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 17:25:02'),
(1145, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan', '103.150.169.6', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 17:25:04'),
(1146, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan', '103.150.169.6', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 17:25:08'),
(1147, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/laporan', '103.150.169.6', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 17:25:09'),
(1148, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan', '103.150.169.6', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 17:25:10'),
(1149, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/petty-cash', '103.150.169.6', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 17:25:11'),
(1150, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan', '103.150.169.6', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 17:25:22'),
(1151, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '103.150.169.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-15 07:59:56'),
(1152, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan', '103.150.169.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-15 07:59:56'),
(1153, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 20:20:32'),
(1154, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 20:20:46'),
(1155, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 20:20:46'),
(1156, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:24:39'),
(1157, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Logout', 'Autentikasi', 'GET', '/auth/logout', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 20:24:42'),
(1158, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 20:24:53'),
(1159, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 20:24:53'),
(1160, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 20:26:29'),
(1161, 17, 'Tampaksiring01', 'aslap', 'arini.anti@sigita-mbg.net', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:30:05'),
(1162, 17, 'Tampaksiring01', 'aslap', 'arini.anti@sigita-mbg.net', 'Logout', 'Autentikasi', 'GET', '/auth/logout', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:30:14'),
(1163, 17, 'Tampaksiring01', 'aslap', 'arini.anti@sigita-mbg.net', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:30:17'),
(1164, 17, 'Tampaksiring01', 'aslap', 'arini.anti@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/aslap/penerima-manfaat', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:30:36'),
(1165, 17, 'Tampaksiring01', 'aslap', 'arini.anti@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/aslap/penerima-manfaat/store', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:31:08'),
(1166, 17, 'Tampaksiring01', 'aslap', 'arini.anti@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/aslap/penerima-manfaat/detail/22', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:31:08'),
(1167, 17, 'Tampaksiring01', 'aslap', 'arini.anti@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/aslap/penerima-manfaat/store-jenjang', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:31:17'),
(1168, 17, 'Tampaksiring01', 'aslap', 'arini.anti@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/aslap/penerima-manfaat/detail/22', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:31:17'),
(1169, 17, 'Tampaksiring01', 'aslap', 'arini.anti@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/aslap/penerima-manfaat/jenjang/30', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:31:23'),
(1170, 17, 'Tampaksiring01', 'aslap', 'arini.anti@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/aslap/penerima-manfaat/store-kelas', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:31:59'),
(1171, 17, 'Tampaksiring01', 'aslap', 'arini.anti@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/aslap/penerima-manfaat/jenjang/30', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:31:59'),
(1172, 17, 'Tampaksiring01', 'aslap', 'arini.anti@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/aslap/penerima-manfaat/store-kelas', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:32:25'),
(1173, 17, 'Tampaksiring01', 'aslap', 'arini.anti@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/aslap/penerima-manfaat/jenjang/30', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:32:25'),
(1174, 17, 'Tampaksiring01', 'aslap', 'arini.anti@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/aslap/penerima-manfaat/store-kelas', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:32:38'),
(1175, 17, 'Tampaksiring01', 'aslap', 'arini.anti@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/aslap/penerima-manfaat/jenjang/30', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:32:38'),
(1176, 17, 'Tampaksiring01', 'aslap', 'arini.anti@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/aslap/penerima-manfaat/store-kelas', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:33:09'),
(1177, 17, 'Tampaksiring01', 'aslap', 'arini.anti@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/aslap/penerima-manfaat/jenjang/30', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:33:09'),
(1178, 17, 'Tampaksiring01', 'aslap', 'arini.anti@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/aslap/penerima-manfaat/store-kelas', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:34:19'),
(1179, 17, 'Tampaksiring01', 'aslap', 'arini.anti@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/aslap/penerima-manfaat/jenjang/30', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:34:19'),
(1180, 17, 'Tampaksiring01', 'aslap', 'arini.anti@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/aslap/penerima-manfaat/store-kelas', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:35:02'),
(1181, 17, 'Tampaksiring01', 'aslap', 'arini.anti@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/aslap/penerima-manfaat/jenjang/30', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:35:02'),
(1182, 17, 'Tampaksiring01', 'aslap', 'arini.anti@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/aslap/penerima-manfaat/store-kelas', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:35:16'),
(1183, 17, 'Tampaksiring01', 'aslap', 'arini.anti@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/aslap/penerima-manfaat/jenjang/30', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:35:16'),
(1184, 17, 'Tampaksiring01', 'aslap', 'arini.anti@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/aslap/penerima-manfaat/store-kelas', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:35:34'),
(1185, 17, 'Tampaksiring01', 'aslap', 'arini.anti@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/aslap/penerima-manfaat/jenjang/30', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:35:34'),
(1186, 17, 'Tampaksiring01', 'aslap', 'arini.anti@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/aslap/penerima-manfaat/detail/22', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:35:41'),
(1187, 17, 'Tampaksiring01', 'aslap', 'arini.anti@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/aslap/penerima-manfaat/store-jenjang', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:35:53'),
(1188, 17, 'Tampaksiring01', 'aslap', 'arini.anti@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/aslap/penerima-manfaat/detail/22', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:35:53'),
(1189, 17, 'Tampaksiring01', 'aslap', 'arini.anti@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/aslap/penerima-manfaat/jenjang/31', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:35:55'),
(1190, 17, 'Tampaksiring01', 'aslap', 'arini.anti@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/aslap/penerima-manfaat/store-kelas', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:36:03'),
(1191, 17, 'Tampaksiring01', 'aslap', 'arini.anti@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/aslap/penerima-manfaat/jenjang/31', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:36:03'),
(1192, 17, 'Tampaksiring01', 'aslap', 'arini.anti@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/aslap/penerima-manfaat/store-kelas', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:36:11'),
(1193, 17, 'Tampaksiring01', 'aslap', 'arini.anti@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/aslap/penerima-manfaat/jenjang/31', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:36:11'),
(1194, 17, 'Tampaksiring01', 'aslap', 'arini.anti@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/aslap/penerima-manfaat/detail/22', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:36:15'),
(1195, 17, 'Tampaksiring01', 'aslap', 'arini.anti@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/aslap/penerima-manfaat/jenjang/30', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:36:48'),
(1196, 17, 'Tampaksiring01', 'aslap', 'arini.anti@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/aslap/penerima-manfaat/detail/22', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:36:56'),
(1197, 17, 'Tampaksiring01', 'aslap', 'arini.anti@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/aslap/penerima-manfaat', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:37:02'),
(1198, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/data-pm', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:37:25'),
(1199, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/menu/list', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:39:11'),
(1200, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/menu/create', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:39:14'),
(1201, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/gizi/menu/store', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:40:27'),
(1202, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/menu/list', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:40:27'),
(1203, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/menu/varian/13', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:40:50'),
(1204, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/gizi/menu/varian/store/13', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:41:56'),
(1205, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/menu/edit/18', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:41:56'),
(1206, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/menu/list', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:42:00');
INSERT INTO `user_activity_logs` (`id`, `user_id`, `id_sppg`, `user_level`, `username`, `activity`, `module`, `method`, `uri`, `ip_address`, `user_agent`, `created_at`) VALUES
(1207, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:42:28'),
(1208, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/rencana-menu', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:42:40'),
(1209, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/rencana-menu/create', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:42:55'),
(1210, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/gizi/rencana-menu/store', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:46:06'),
(1211, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/rencana-menu/edit/7', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:46:06'),
(1212, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/rencana-menu', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:46:18'),
(1213, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/rencana-menu/detail/7', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:46:23'),
(1214, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/rencana-menu/edit/7', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:46:39'),
(1215, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/rencana-menu', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:46:46'),
(1216, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/rencana-menu/detail/7', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:46:47'),
(1217, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/gizi/rencana-menu/tetapkan/7', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:46:55'),
(1218, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/rencana-menu/detail/7', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:46:55'),
(1219, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/rencana-menu', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:47:09'),
(1220, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:48:48'),
(1221, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/create', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:48:57'),
(1222, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/gizi/bahan-baku/store', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:49:16'),
(1223, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/16', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:49:16'),
(1224, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/gizi/bahan-baku/store-detail', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:49:37'),
(1225, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/16', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:49:38'),
(1226, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/gizi/bahan-baku/store-detail', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:49:51'),
(1227, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/16', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:49:52'),
(1228, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:50:04'),
(1229, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan/request/create', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:50:09'),
(1230, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/gizi/bahan/request/store', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:50:27'),
(1231, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan/request', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:50:27'),
(1232, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/request-bahan', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 20:50:56'),
(1233, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/request-bahan/approve/4', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 20:51:06'),
(1234, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/request-bahan', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 20:51:06'),
(1235, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 20:51:18'),
(1236, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 20:51:25'),
(1237, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/sppg/select', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 20:51:33'),
(1238, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 20:51:33'),
(1239, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/bahan/update-harga/132', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 20:51:51'),
(1240, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 20:51:51'),
(1241, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan/template-excel', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 20:52:01'),
(1242, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/bahan/import-excel', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 20:54:29'),
(1243, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 20:54:29'),
(1244, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan/history/14', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 20:54:39'),
(1245, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 20:54:43'),
(1246, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan/history/132', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 20:54:46'),
(1247, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 20:54:56'),
(1248, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 20:54:58'),
(1249, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/16', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:55:24'),
(1250, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/gizi/bahan-baku/store-detail', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:55:35'),
(1251, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/16', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:55:35'),
(1252, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/gizi/bahan-baku/store-detail', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:55:46'),
(1253, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/16', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:55:46'),
(1254, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Mengirim pengajuan pembelian bahan ke Keuangan', 'Pengadaan Bahan', 'POST', '/gizi/bahan-baku/ajukan/16', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:55:59'),
(1255, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/ajukan/16', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:55:59'),
(1256, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/16', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:55:59'),
(1257, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 20:56:10'),
(1258, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 20:56:17'),
(1259, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan/detail/16', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 20:56:25'),
(1260, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Menolak pengajuan pembelian dan mengembalikannya ke Gizi', 'Pengadaan Bahan', 'POST', '/keuangan/pengadaan/reject/16', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 20:56:45'),
(1261, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/keuangan/pengadaan/reject/16', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 20:56:45'),
(1262, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan/detail/16', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 20:56:45'),
(1263, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/16', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:57:00'),
(1264, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/gizi/bahan-baku/store-detail', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:57:15'),
(1265, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/16', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:57:15'),
(1266, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/gizi/bahan-baku/store-detail', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:57:35'),
(1267, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/16', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:57:35'),
(1268, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/gizi/bahan-baku/store-detail', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:57:47'),
(1269, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/16', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:57:47'),
(1270, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/gizi/bahan-baku/store-detail', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:57:59'),
(1271, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/16', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:57:59'),
(1272, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/gizi/bahan-baku/store-detail', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:58:13'),
(1273, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/16', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:58:13'),
(1274, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Merevisi dan mengajukan ulang pembelian bahan ke Keuangan', 'Pengadaan Bahan', 'POST', '/gizi/bahan-baku/ajukan/16', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:58:19'),
(1275, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/ajukan/16', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:58:19'),
(1276, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/16', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:58:19'),
(1277, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan/detail/16', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 20:58:25'),
(1278, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Menolak pengajuan pembelian dan mengembalikannya ke Gizi', 'Pengadaan Bahan', 'POST', '/keuangan/pengadaan/reject/16', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 20:58:35'),
(1279, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/keuangan/pengadaan/reject/16', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 20:58:35'),
(1280, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan/detail/16', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 20:58:35'),
(1281, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/16', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:58:45'),
(1282, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/delete-detail/67', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:58:51'),
(1283, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/16', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:58:51'),
(1284, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/gizi/bahan-baku/update-detail/63', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:59:03'),
(1285, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/16', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:59:03'),
(1286, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/gizi/bahan-baku/update-detail/65', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:59:15'),
(1287, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/16', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 20:59:15'),
(1288, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Merevisi dan mengajukan ulang pembelian bahan ke Keuangan', 'Pengadaan Bahan', 'POST', '/gizi/bahan-baku/ajukan/16', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 21:15:30'),
(1289, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/ajukan/16', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 21:15:30'),
(1290, 15, 'Tampaksiring01', 'gizi', 'widya.ayu@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/gizi/bahan-baku/detail/16', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-22 21:15:30'),
(1291, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan/detail/16', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:15:39'),
(1292, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Menyetujui pengajuan pembelian dan meneruskan ke Kepala SPPG', 'Pengadaan Bahan', 'POST', '/keuangan/pengadaan/approve/16', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:15:57'),
(1293, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/keuangan/pengadaan/approve/16', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:15:57'),
(1294, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan/detail/16', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:15:57'),
(1295, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Logout', 'Autentikasi', 'GET', '/auth/logout', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:17:43'),
(1296, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:157.0) Gecko/20100101 Firefox/157.0', '2026-10-22 21:18:12'),
(1297, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:18:19'),
(1298, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:18:19'),
(1299, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/kepala/pengadaan', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:157.0) Gecko/20100101 Firefox/157.0', '2026-10-22 21:18:27'),
(1300, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/kepala/pengadaan/detail/16', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:157.0) Gecko/20100101 Firefox/157.0', '2026-10-22 21:18:31'),
(1301, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Menyetujui pengadaan dan meneruskan ke Koperasi', 'Pengadaan Bahan', 'POST', '/kepala/pengadaan/approve/16', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:157.0) Gecko/20100101 Firefox/157.0', '2026-10-22 21:18:41'),
(1302, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Mengirim data', 'Index.php', 'POST', '/index.php/kepala/pengadaan/approve/16', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:157.0) Gecko/20100101 Firefox/157.0', '2026-10-22 21:18:41'),
(1303, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/kepala/pengadaan/detail/16', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:157.0) Gecko/20100101 Firefox/157.0', '2026-10-22 21:18:41'),
(1304, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/kepala/pengadaan', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:157.0) Gecko/20100101 Firefox/157.0', '2026-10-22 21:18:46'),
(1305, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:18:58'),
(1306, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:19:01'),
(1307, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:19:16'),
(1308, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:19:19'),
(1309, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:19:23'),
(1310, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan/detail/16', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:19:27'),
(1311, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Menerima pengadaan dan memulai proses', 'Pengadaan Bahan', 'POST', '/koperasi/pengadaan/process/16', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:19:38'),
(1312, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/pengadaan/process/16', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:19:38'),
(1313, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian/detail/5', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:19:38'),
(1314, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:19:54'),
(1315, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:19:56'),
(1316, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:19:59'),
(1317, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:20:04'),
(1318, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:20:09'),
(1319, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/create', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:20:18'),
(1320, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/supplier/store', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:21:53'),
(1321, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/detail/6', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:21:53'),
(1322, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/detail/6', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:22:13'),
(1323, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/history-harga/13', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:22:32'),
(1324, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/detail/6', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:22:34'),
(1325, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:23:18'),
(1326, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:23:22'),
(1327, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/sppg/select', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:23:36'),
(1328, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:23:36'),
(1329, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:23:39'),
(1330, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pengadaan/detail/16', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:23:41'),
(1331, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:23:44'),
(1332, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian/detail/5', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:23:48'),
(1333, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:23:58'),
(1334, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:24:02'),
(1335, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:24:05'),
(1336, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/create', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:24:06'),
(1337, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/supplier/store', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:25:49'),
(1338, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/detail/7', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:25:49'),
(1339, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:25:59'),
(1340, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:26:13'),
(1341, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian/detail/5', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:26:14'),
(1342, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/edit/7', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:26:29'),
(1343, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/supplier/update/7', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:26:38'),
(1344, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/detail/7', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:26:39'),
(1345, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian/detail/5', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:26:42'),
(1346, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/pembelian/update/5', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:28:56'),
(1347, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian/detail/5', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:28:56'),
(1348, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/pembelian/update/5', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:29:30'),
(1349, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian/detail/5', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:29:30'),
(1350, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Pembelian bahan selesai dilakukan', 'Pembelian Koperasi', 'POST', '/index.php/koperasi/pembelian/dibeli/5', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:29:37'),
(1351, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/pembelian/dibeli/5', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:29:37'),
(1352, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian/detail/5', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:29:37'),
(1353, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Pembelian bahan dikirim ke SPPG', 'Pembelian Koperasi', 'POST', '/index.php/koperasi/pembelian/kirim/5', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:29:51'),
(1354, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/pembelian/kirim/5', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:29:51'),
(1355, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian/detail/5', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:29:51'),
(1356, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:30:05'),
(1357, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan/invoice/16', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:30:11'),
(1358, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:32:15'),
(1359, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/pengadaan/detail/16', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:32:32'),
(1360, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/kepala/pengadaan', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:157.0) Gecko/20100101 Firefox/157.0', '2026-10-22 21:33:27'),
(1361, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/kepala/pengadaan/detail/16', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:157.0) Gecko/20100101 Firefox/157.0', '2026-10-22 21:33:34'),
(1362, 14, 'Tampaksiring01', 'kepala', 'komang.adi@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/kepala/pengadaan', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:157.0) Gecko/20100101 Firefox/157.0', '2026-10-22 21:33:38'),
(1363, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:34:18'),
(1364, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan/petty-cash', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:34:21'),
(1365, 16, 'Tampaksiring01', 'keuangan', 'sri.gayatri@sigita-mbg.net', 'Membuka halaman', 'Index.php', 'GET', '/index.php/keuangan', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:34:33'),
(1366, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:42:46'),
(1367, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:42:50'),
(1368, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/sppg/select', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:42:59'),
(1369, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:42:59'),
(1370, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/bahan/copy', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:43:34'),
(1371, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:43:34'),
(1372, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:44:16'),
(1373, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:44:22');
INSERT INTO `user_activity_logs` (`id`, `user_id`, `id_sppg`, `user_level`, `username`, `activity`, `module`, `method`, `uri`, `ip_address`, `user_agent`, `created_at`) VALUES
(1374, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/sppg/select', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:44:29'),
(1375, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:44:29'),
(1376, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan/history/132', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:44:37'),
(1377, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:44:45'),
(1378, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:44:50'),
(1379, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:44:54'),
(1380, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian/detail/4', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:44:56'),
(1381, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/pembelian/update/4', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:47:39'),
(1382, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian/detail/4', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:47:39'),
(1383, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/pembelian', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:47:46'),
(1384, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Logout', 'Autentikasi', 'GET', '/auth/logout', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:47:48'),
(1385, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:47:57'),
(1386, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:47:57'),
(1387, 34, 'Pandak01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:48:05'),
(1388, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Mengirim data', 'Index.php', 'POST', '/index.php/koperasi/sppg/select', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:48:09'),
(1389, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/bahan', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:48:09'),
(1390, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:48:25'),
(1391, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:48:28'),
(1392, 34, 'Tampaksiring01', 'koperasi', 'kop01@gmail.com', 'Membuka halaman', 'Index.php', 'GET', '/index.php/koperasi/supplier/detail/7', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 21:48:34'),
(1393, 34, NULL, 'koperasi', 'kop01@gmail.com', 'Logout', 'Autentikasi', 'GET', '/auth/logout', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 22:06:30'),
(1394, 31, NULL, 'super_admin', 'superadmin@sigita-mbg.net', 'Login berhasil', 'Autentikasi', 'POST', '/auth/processLogin', '43.245.186.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 22:06:42');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_sppg` (`id_sppg`),
  ADD KEY `created_by` (`created_by`);

--
-- Indeks untuk tabel `admin_sppg`
--
ALTER TABLE `admin_sppg`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_admin_sppg` (`user_id`,`id_sppg`),
  ADD KEY `idx_admin_sppg_user` (`user_id`),
  ADD KEY `idx_admin_sppg_sppg` (`id_sppg`);

--
-- Indeks untuk tabel `bahan_baku`
--
ALTER TABLE `bahan_baku`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_sppg` (`id_sppg`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `approved_by` (`approved_by`);

--
-- Indeks untuk tabel `bahan_baku_detail`
--
ALTER TABLE `bahan_baku_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `belanja_id` (`belanja_id`),
  ADD KEY `bahan_id` (`bahan_id`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indeks untuk tabel `bahan_request`
--
ALTER TABLE `bahan_request`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_bahan_request_sppg` (`id_sppg`),
  ADD KEY `idx_bahan_request_status` (`status`),
  ADD KEY `idx_bahan_request_master` (`master_bahan_id`),
  ADD KEY `idx_bahan_request_created` (`created_at`),
  ADD KEY `bahan_request_user_fk` (`requested_by`),
  ADD KEY `bahan_request_processed_user_fk` (`processed_by`);

--
-- Indeks untuk tabel `biaya_operasional`
--
ALTER TABLE `biaya_operasional`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_nomor_pengajuan` (`id_sppg`,`nomor_pengajuan`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `approved_by` (`approved_by`),
  ADD KEY `paid_by` (`paid_by`);

--
-- Indeks untuk tabel `biaya_operasional_detail`
--
ALTER TABLE `biaya_operasional_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pengajuan_id` (`pengajuan_id`);

--
-- Indeks untuk tabel `biaya_operasional_file`
--
ALTER TABLE `biaya_operasional_file`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pengajuan_id` (`pengajuan_id`);

--
-- Indeks untuk tabel `jadwal_relawan`
--
ALTER TABLE `jadwal_relawan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_sppg` (`id_sppg`),
  ADD KEY `relawan_id` (`relawan_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indeks untuk tabel `kegiatan_aslap`
--
ALTER TABLE `kegiatan_aslap`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kegiatan_aslap_foto`
--
ALTER TABLE `kegiatan_aslap_foto`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kegiatan_gizi`
--
ALTER TABLE `kegiatan_gizi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_kegiatan_jenis` (`jenis_kegiatan_id`);

--
-- Indeks untuk tabel `kegiatan_gizi_foto`
--
ALTER TABLE `kegiatan_gizi_foto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_kegiatan_foto` (`kegiatan_id`);

--
-- Indeks untuk tabel `koperasi`
--
ALTER TABLE `koperasi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_koperasi_kode` (`kode_koperasi`);

--
-- Indeks untuk tabel `koperasi_pembelian`
--
ALTER TABLE `koperasi_pembelian`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_koperasi_pembelian_no` (`no_pembelian`),
  ADD UNIQUE KEY `uq_koperasi_pembelian_belanja` (`belanja_id`),
  ADD KEY `idx_koperasi_pembelian_sppg_tanggal` (`id_sppg`,`tanggal_pembelian`),
  ADD KEY `idx_koperasi_pembelian_status` (`status`);

--
-- Indeks untuk tabel `koperasi_pembelian_detail`
--
ALTER TABLE `koperasi_pembelian_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_koperasi_pembelian_detail_parent` (`pembelian_id`);

--
-- Indeks untuk tabel `koperasi_sppg`
--
ALTER TABLE `koperasi_sppg`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_koperasi_sppg` (`koperasi_id`,`id_sppg`),
  ADD KEY `idx_koperasi_sppg_koperasi` (`koperasi_id`),
  ADD KEY `idx_koperasi_sppg_sppg` (`id_sppg`);

--
-- Indeks untuk tabel `master_bahan`
--
ALTER TABLE `master_bahan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_bahan_per_sppg` (`id_sppg`,`nama_bahan`);

--
-- Indeks untuk tabel `master_bahan_harga`
--
ALTER TABLE `master_bahan_harga`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bahan_id` (`bahan_id`),
  ADD KEY `diubah_oleh` (`diubah_oleh`);

--
-- Indeks untuk tabel `master_jenis_dokumen_supplier`
--
ALTER TABLE `master_jenis_dokumen_supplier`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_jenis_dokumen_supplier` (`nama_jenis`);

--
-- Indeks untuk tabel `master_jenis_kegiatan`
--
ALTER TABLE `master_jenis_kegiatan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `master_satuan`
--
ALTER TABLE `master_satuan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `menu_gizi`
--
ALTER TABLE `menu_gizi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_sppg` (`id_sppg`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `idx_menu_gizi_induk` (`menu_induk_id`);

--
-- Indeks untuk tabel `menu_komposisi`
--
ALTER TABLE `menu_komposisi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_id` (`menu_id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `penerima_manfaat`
--
ALTER TABLE `penerima_manfaat`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_sekolah_per_sppg` (`id_sppg`,`sekolah_nama`),
  ADD KEY `created_by` (`created_by`);

--
-- Indeks untuk tabel `pengeluaran_aslap`
--
ALTER TABLE `pengeluaran_aslap`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `petty_cash`
--
ALTER TABLE `petty_cash`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_sppg` (`id_sppg`),
  ADD KEY `created_by` (`created_by`);

--
-- Indeks untuk tabel `pm_jenjang`
--
ALTER TABLE `pm_jenjang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_pm_id` (`pm_id`);

--
-- Indeks untuk tabel `pm_kelas`
--
ALTER TABLE `pm_kelas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pm_id` (`pm_id`),
  ADD KEY `idx_jenjang_id` (`jenjang_id`);

--
-- Indeks untuk tabel `relawan`
--
ALTER TABLE `relawan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_sppg` (`id_sppg`),
  ADD KEY `created_by` (`created_by`);

--
-- Indeks untuk tabel `rencana_menu`
--
ALTER TABLE `rencana_menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_rencana_menu_sppg` (`id_sppg`),
  ADD KEY `idx_rencana_menu_tanggal` (`tanggal`),
  ADD KEY `idx_rencana_menu_status` (`status`),
  ADD KEY `idx_rencana_menu_created_by` (`created_by`);

--
-- Indeks untuk tabel `rencana_menu_detail`
--
ALTER TABLE `rencana_menu_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_rencana_menu_detail_rencana` (`rencana_menu_id`),
  ADD KEY `idx_rencana_menu_detail_menu` (`menu_id`);

--
-- Indeks untuk tabel `rencana_menu_penerima`
--
ALTER TABLE `rencana_menu_penerima`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_rencana_menu_id` (`rencana_menu_id`),
  ADD KEY `idx_pm_id` (`pm_id`);

--
-- Indeks untuk tabel `rencana_menu_penerima_detail`
--
ALTER TABLE `rencana_menu_penerima_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_rencana_menu_penerima_id` (`rencana_menu_penerima_id`),
  ADD KEY `idx_menu_id` (`menu_id`);

--
-- Indeks untuk tabel `sppg`
--
ALTER TABLE `sppg`
  ADD PRIMARY KEY (`id_sppg`);

--
-- Indeks untuk tabel `supplier_bahan`
--
ALTER TABLE `supplier_bahan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_supplier_bahan` (`supplier_id`,`bahan_id`),
  ADD KEY `idx_supplier_bahan_bahan` (`bahan_id`,`status`);

--
-- Indeks untuk tabel `supplier_bahan_harga`
--
ALTER TABLE `supplier_bahan_harga`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_supplier_bahan_harga_history` (`supplier_bahan_id`,`created_at`);

--
-- Indeks untuk tabel `supplier_koperasi`
--
ALTER TABLE `supplier_koperasi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_supplier_koperasi_kode` (`koperasi_id`,`kode_supplier`),
  ADD KEY `id_sppg` (`id_sppg`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `idx_supplier_koperasi_status` (`koperasi_id`,`status`);

--
-- Indeks untuk tabel `supplier_koperasi_berkas`
--
ALTER TABLE `supplier_koperasi_berkas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_supplier_koperasi_berkas_supplier_jenis` (`supplier_id`,`jenis_dokumen_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `unique_sppg_level` (`id_sppg`,`user_level`),
  ADD UNIQUE KEY `unique_email` (`email`);

--
-- Indeks untuk tabel `user_activity_logs`
--
ALTER TABLE `user_activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_activity_user` (`user_id`),
  ADD KEY `idx_activity_sppg` (`id_sppg`),
  ADD KEY `idx_activity_level` (`user_level`),
  ADD KEY `idx_activity_module` (`module`),
  ADD KEY `idx_activity_created` (`created_at`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `activities`
--
ALTER TABLE `activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `admin_sppg`
--
ALTER TABLE `admin_sppg`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `bahan_baku`
--
ALTER TABLE `bahan_baku`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `bahan_baku_detail`
--
ALTER TABLE `bahan_baku_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT untuk tabel `bahan_request`
--
ALTER TABLE `bahan_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `biaya_operasional`
--
ALTER TABLE `biaya_operasional`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `biaya_operasional_detail`
--
ALTER TABLE `biaya_operasional_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `biaya_operasional_file`
--
ALTER TABLE `biaya_operasional_file`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jadwal_relawan`
--
ALTER TABLE `jadwal_relawan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `kegiatan_aslap`
--
ALTER TABLE `kegiatan_aslap`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `kegiatan_aslap_foto`
--
ALTER TABLE `kegiatan_aslap_foto`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `kegiatan_gizi`
--
ALTER TABLE `kegiatan_gizi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `kegiatan_gizi_foto`
--
ALTER TABLE `kegiatan_gizi_foto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `koperasi`
--
ALTER TABLE `koperasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `koperasi_pembelian`
--
ALTER TABLE `koperasi_pembelian`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `koperasi_pembelian_detail`
--
ALTER TABLE `koperasi_pembelian_detail`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT untuk tabel `koperasi_sppg`
--
ALTER TABLE `koperasi_sppg`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `master_bahan`
--
ALTER TABLE `master_bahan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- AUTO_INCREMENT untuk tabel `master_bahan_harga`
--
ALTER TABLE `master_bahan_harga`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `master_jenis_dokumen_supplier`
--
ALTER TABLE `master_jenis_dokumen_supplier`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `master_jenis_kegiatan`
--
ALTER TABLE `master_jenis_kegiatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `master_satuan`
--
ALTER TABLE `master_satuan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `menu_gizi`
--
ALTER TABLE `menu_gizi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `menu_komposisi`
--
ALTER TABLE `menu_komposisi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `penerima_manfaat`
--
ALTER TABLE `penerima_manfaat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `pengeluaran_aslap`
--
ALTER TABLE `pengeluaran_aslap`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `petty_cash`
--
ALTER TABLE `petty_cash`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `pm_jenjang`
--
ALTER TABLE `pm_jenjang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT untuk tabel `pm_kelas`
--
ALTER TABLE `pm_kelas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT untuk tabel `relawan`
--
ALTER TABLE `relawan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `rencana_menu`
--
ALTER TABLE `rencana_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `rencana_menu_detail`
--
ALTER TABLE `rencana_menu_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `rencana_menu_penerima`
--
ALTER TABLE `rencana_menu_penerima`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT untuk tabel `rencana_menu_penerima_detail`
--
ALTER TABLE `rencana_menu_penerima_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT untuk tabel `supplier_bahan`
--
ALTER TABLE `supplier_bahan`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `supplier_bahan_harga`
--
ALTER TABLE `supplier_bahan_harga`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `supplier_koperasi`
--
ALTER TABLE `supplier_koperasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `supplier_koperasi_berkas`
--
ALTER TABLE `supplier_koperasi_berkas`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT untuk tabel `user_activity_logs`
--
ALTER TABLE `user_activity_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1395;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `activities`
--
ALTER TABLE `activities`
  ADD CONSTRAINT `activities_ibfk_1` FOREIGN KEY (`id_sppg`) REFERENCES `sppg` (`id_sppg`) ON DELETE CASCADE,
  ADD CONSTRAINT `activities_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `bahan_baku`
--
ALTER TABLE `bahan_baku`
  ADD CONSTRAINT `bahan_baku_ibfk_1` FOREIGN KEY (`id_sppg`) REFERENCES `sppg` (`id_sppg`) ON DELETE CASCADE,
  ADD CONSTRAINT `bahan_baku_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `bahan_baku_ibfk_3` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `bahan_baku_detail`
--
ALTER TABLE `bahan_baku_detail`
  ADD CONSTRAINT `bahan_baku_detail_ibfk_1` FOREIGN KEY (`belanja_id`) REFERENCES `bahan_baku` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bahan_baku_detail_ibfk_2` FOREIGN KEY (`bahan_id`) REFERENCES `master_bahan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bahan_baku_detail_ibfk_3` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `bahan_request`
--
ALTER TABLE `bahan_request`
  ADD CONSTRAINT `bahan_request_master_fk` FOREIGN KEY (`master_bahan_id`) REFERENCES `master_bahan` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `bahan_request_processed_user_fk` FOREIGN KEY (`processed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `bahan_request_user_fk` FOREIGN KEY (`requested_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `biaya_operasional`
--
ALTER TABLE `biaya_operasional`
  ADD CONSTRAINT `biaya_operasional_ibfk_1` FOREIGN KEY (`id_sppg`) REFERENCES `sppg` (`id_sppg`) ON DELETE CASCADE,
  ADD CONSTRAINT `biaya_operasional_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `biaya_operasional_ibfk_3` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `biaya_operasional_ibfk_4` FOREIGN KEY (`paid_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `biaya_operasional_detail`
--
ALTER TABLE `biaya_operasional_detail`
  ADD CONSTRAINT `biaya_operasional_detail_ibfk_1` FOREIGN KEY (`pengajuan_id`) REFERENCES `biaya_operasional` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `biaya_operasional_file`
--
ALTER TABLE `biaya_operasional_file`
  ADD CONSTRAINT `biaya_operasional_file_ibfk_1` FOREIGN KEY (`pengajuan_id`) REFERENCES `biaya_operasional` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `jadwal_relawan`
--
ALTER TABLE `jadwal_relawan`
  ADD CONSTRAINT `jadwal_relawan_ibfk_1` FOREIGN KEY (`id_sppg`) REFERENCES `sppg` (`id_sppg`) ON DELETE CASCADE,
  ADD CONSTRAINT `jadwal_relawan_ibfk_2` FOREIGN KEY (`relawan_id`) REFERENCES `relawan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `jadwal_relawan_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `kegiatan_gizi`
--
ALTER TABLE `kegiatan_gizi`
  ADD CONSTRAINT `fk_kegiatan_jenis` FOREIGN KEY (`jenis_kegiatan_id`) REFERENCES `master_jenis_kegiatan` (`id`);

--
-- Ketidakleluasaan untuk tabel `kegiatan_gizi_foto`
--
ALTER TABLE `kegiatan_gizi_foto`
  ADD CONSTRAINT `fk_kegiatan_foto` FOREIGN KEY (`kegiatan_id`) REFERENCES `kegiatan_gizi` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `master_bahan`
--
ALTER TABLE `master_bahan`
  ADD CONSTRAINT `master_bahan_ibfk_1` FOREIGN KEY (`id_sppg`) REFERENCES `sppg` (`id_sppg`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `master_bahan_harga`
--
ALTER TABLE `master_bahan_harga`
  ADD CONSTRAINT `master_bahan_harga_bahan_fk` FOREIGN KEY (`bahan_id`) REFERENCES `master_bahan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `master_bahan_harga_user_fk` FOREIGN KEY (`diubah_oleh`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `menu_gizi`
--
ALTER TABLE `menu_gizi`
  ADD CONSTRAINT `menu_gizi_ibfk_1` FOREIGN KEY (`id_sppg`) REFERENCES `sppg` (`id_sppg`) ON DELETE CASCADE,
  ADD CONSTRAINT `menu_gizi_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `menu_komposisi`
--
ALTER TABLE `menu_komposisi`
  ADD CONSTRAINT `menu_komposisi_ibfk_1` FOREIGN KEY (`menu_id`) REFERENCES `menu_gizi` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `penerima_manfaat`
--
ALTER TABLE `penerima_manfaat`
  ADD CONSTRAINT `penerima_manfaat_ibfk_1` FOREIGN KEY (`id_sppg`) REFERENCES `sppg` (`id_sppg`) ON DELETE CASCADE,
  ADD CONSTRAINT `penerima_manfaat_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `petty_cash`
--
ALTER TABLE `petty_cash`
  ADD CONSTRAINT `petty_cash_ibfk_1` FOREIGN KEY (`id_sppg`) REFERENCES `sppg` (`id_sppg`) ON DELETE CASCADE,
  ADD CONSTRAINT `petty_cash_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `pm_jenjang`
--
ALTER TABLE `pm_jenjang`
  ADD CONSTRAINT `fk_pm_jenjang_pm` FOREIGN KEY (`pm_id`) REFERENCES `penerima_manfaat` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pm_kelas`
--
ALTER TABLE `pm_kelas`
  ADD CONSTRAINT `fk_pm_kelas_jenjang` FOREIGN KEY (`jenjang_id`) REFERENCES `pm_jenjang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pm_kelas_ibfk_1` FOREIGN KEY (`pm_id`) REFERENCES `penerima_manfaat` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `relawan`
--
ALTER TABLE `relawan`
  ADD CONSTRAINT `relawan_ibfk_1` FOREIGN KEY (`id_sppg`) REFERENCES `sppg` (`id_sppg`) ON DELETE CASCADE,
  ADD CONSTRAINT `relawan_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `rencana_menu_detail`
--
ALTER TABLE `rencana_menu_detail`
  ADD CONSTRAINT `fk_rencana_menu_detail_menu` FOREIGN KEY (`menu_id`) REFERENCES `menu_gizi` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_rencana_menu_detail_rencana` FOREIGN KEY (`rencana_menu_id`) REFERENCES `rencana_menu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `rencana_menu_penerima`
--
ALTER TABLE `rencana_menu_penerima`
  ADD CONSTRAINT `fk_rencana_menu_penerima_pm` FOREIGN KEY (`pm_id`) REFERENCES `penerima_manfaat` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_rencana_menu_penerima_rencana` FOREIGN KEY (`rencana_menu_id`) REFERENCES `rencana_menu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `rencana_menu_penerima_detail`
--
ALTER TABLE `rencana_menu_penerima_detail`
  ADD CONSTRAINT `fk_rencana_menu_penerima_detail_menu` FOREIGN KEY (`menu_id`) REFERENCES `menu_gizi` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_rencana_menu_penerima_detail_parent` FOREIGN KEY (`rencana_menu_penerima_id`) REFERENCES `rencana_menu_penerima` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `supplier_koperasi`
--
ALTER TABLE `supplier_koperasi`
  ADD CONSTRAINT `supplier_koperasi_ibfk_1` FOREIGN KEY (`id_sppg`) REFERENCES `sppg` (`id_sppg`) ON DELETE CASCADE,
  ADD CONSTRAINT `supplier_koperasi_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`id_sppg`) REFERENCES `sppg` (`id_sppg`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
