-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 17, 2026 at 04:09 AM
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
-- Database: `lmsweb`
--

-- --------------------------------------------------------

--
-- Table structure for table `alumni`
--

CREATE TABLE `alumni` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL COMMENT 'Nama alumni/portofolio bisnis',
  `deskripsi` text DEFAULT NULL COMMENT 'Deskripsi bisnis atau portofolio',
  `kategori` varchar(100) DEFAULT NULL COMMENT 'Kategori: Percetakan & Desain, Teknologi, dll',
  `lokasi` varchar(255) DEFAULT NULL COMMENT 'Lokasi bisnis',
  `foto_profil` varchar(255) DEFAULT NULL COMMENT 'Foto profil opsional (uploads/alumni/profil/)',
  `gambar` varchar(255) DEFAULT NULL COMMENT 'Path gambar utama - auto generate',
  `folder_galeri` varchar(100) DEFAULT NULL COMMENT 'Folder galeri - auto generate',
  `gambar_pattern` varchar(255) DEFAULT NULL COMMENT 'Pattern penamaan file - auto generate',
  `facebook_url` varchar(255) DEFAULT NULL COMMENT 'URL Facebook',
  `tiktok_url` varchar(255) DEFAULT NULL COMMENT 'URL TikTok',
  `whatsapp_url` varchar(255) DEFAULT NULL COMMENT 'URL WhatsApp',
  `galeri` text DEFAULT NULL COMMENT 'JSON data galeri foto',
  `warna_tema` varchar(20) DEFAULT '#0056b3' COMMENT 'Warna tema UI',
  `status` enum('aktif','nonaktif') DEFAULT 'aktif' COMMENT 'Status alumni',
  `created_at` datetime DEFAULT current_timestamp() COMMENT 'Tanggal dibuat',
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'Tanggal diupdate'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Tabel Alumni untuk Portofolio dan Showcase';

--
-- Dumping data for table `alumni`
--

INSERT INTO `alumni` (`id`, `nama`, `deskripsi`, `kategori`, `lokasi`, `foto_profil`, `gambar`, `folder_galeri`, `gambar_pattern`, `facebook_url`, `tiktok_url`, `whatsapp_url`, `galeri`, `warna_tema`, `status`, `created_at`, `updated_at`) VALUES
(1, 'FLATO', 'Jasa Percetakan dan Desain\nCetak, Desain dan Kaos', 'Percetakan & Desain', 'Pekalongan, Jawa Tengah', NULL, 'pwk/flato/d(2).jpg', 'pwk/flato', 'pwk/flato/d({index}).jpg', 'https://www.facebook.com/rofiq.sugihtorwaras', 'https://tiktok.com/@flatopercetakan', 'https://wa.me/6285742809646', NULL, '#00695c', 'aktif', '2026-03-17 04:51:34', '2026-03-17 04:51:34'),
(2, 'Nusa Karya', 'Jasa Percetakan dan Desain\nCetak, Desain dan Kaos', 'Percetakan & Desain', 'Pekalongan, Jawa Tengah', NULL, 'pwk/nusa_karya/n(1).jpg', 'pwk/nusa_karya', 'pwk/nusa_karya/n({index}).jpg', 'https://www.facebook.com/nusa.karya.52', 'https://tiktok.com/@rizkymedia', 'https://wa.me/6281234567891', NULL, '#0d6efd', 'aktif', '2026-03-17 04:51:34', '2026-03-17 04:51:34'),
(3, 'DOOP', 'Jasa Percetakan dan Desain\nCetak, Desain dan Kaos', 'Percetakan & Desain', 'Pekalongan, Jawa Tengah', NULL, 'pwk/doop/k(1).jpg', 'pwk/doop', 'pwk/doop/k({index}).jpg', '', 'https://tiktok.com/@flatodesign', 'https://wa.me/6281234567892', NULL, '#0dcaf0', 'aktif', '2026-03-17 04:51:34', '2026-03-17 04:51:34');

-- --------------------------------------------------------

--
-- Table structure for table `bank`
--

CREATE TABLE `bank` (
  `id_bank` int(11) UNSIGNED NOT NULL,
  `sesi_user` varchar(255) NOT NULL,
  `nama_bank` varchar(255) NOT NULL,
  `no_rek` varchar(50) NOT NULL,
  `a_n` varchar(255) NOT NULL COMMENT 'Atas Nama',
  `deleted_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bank`
--

INSERT INTO `bank` (`id_bank`, `sesi_user`, `nama_bank`, `no_rek`, `a_n`, `deleted_at`, `created_at`, `updated_at`) VALUES
(2, '1', 'BNI', '2345678901', 'INASABA', '2026-03-14 09:05:52', '2025-08-12 03:09:13', '2026-03-14 02:44:12'),
(3, '1', 'Mandiri', '3456789012', 'INASABA', '0000-00-00 00:00:00', '2025-08-12 03:09:13', '2026-03-14 02:44:19'),
(4, '1', 'BRI', '4567890123', 'INASABA', '0000-00-00 00:00:00', '2025-08-12 03:09:13', '2026-03-14 02:44:26'),
(5, '1', 'Permata', '5678901234', 'INASABA', '0000-00-00 00:00:00', '2025-08-12 03:09:13', '2026-03-14 02:44:34'),
(6, '1', 'BCA', '6789012345', 'INASABA', '0000-00-00 00:00:00', '2025-08-12 03:09:13', '2026-03-14 02:45:00');

-- --------------------------------------------------------

--
-- Table structure for table `banner_program`
--

CREATE TABLE `banner_program` (
  `id_banner` int(11) NOT NULL,
  `judul_banner` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `gambar_banner` varchar(255) DEFAULT NULL,
  `program_type` enum('a','b') DEFAULT 'a',
  `urutan` int(11) DEFAULT 0,
  `status` enum('aktif','nonaktif') DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `banner_program`
--

INSERT INTO `banner_program` (`id_banner`, `judul_banner`, `deskripsi`, `gambar_banner`, `program_type`, `urutan`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Program Sekretaris & Administrasi', 'Pelatihan profesional untuk karir sekretaris dan administrasi perkantoran', 'program-a-1.jpg', 'a', 1, 'aktif', '2026-03-16 22:01:03', '2026-03-16 22:01:03'),
(2, 'Program Desain Grafis', 'Kursus desain grafis profesional dengan software terkini', 'program-b-1.jpg', 'b', 1, 'aktif', '2026-03-16 22:01:03', '2026-03-16 22:01:03');

-- --------------------------------------------------------

--
-- Table structure for table `detail_kursus`
--

CREATE TABLE `detail_kursus` (
  `id_detail` int(11) NOT NULL,
  `id_kursus` int(11) NOT NULL,
  `gambar_detail_a` varchar(255) DEFAULT NULL,
  `gambar_detail_b` varchar(255) DEFAULT NULL,
  `gambar_detail_c` varchar(255) DEFAULT NULL,
  `materi_yang_dipelajari` text NOT NULL,
  `syarat_pendaftaran` text DEFAULT NULL,
  `id_pemilik` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `detail_kursus`
--

INSERT INTO `detail_kursus` (`id_detail`, `id_kursus`, `gambar_detail_a`, `gambar_detail_b`, `gambar_detail_c`, `materi_yang_dipelajari`, `syarat_pendaftaran`, `id_pemilik`) VALUES
(11, 15, '1771469653_6febd7232086d33722a2.png', '', '', 'Materi Microsoft Word\r\nMateri Microsoft Excel\r\nMateri Microsoft PowerPoint', 'a. Mengisi formulir pendaftaran\r\nb. 1 Lembar fotocopy ijazah terakhir\r\nc. 2 Lembar pas foto ukuran 4x6 warna\r\nd. Biaya pendaftaran Rp.100.000\r\ne. Menyerahkan uang muka 50% dan biaya pendaftaran\r\nf. 1 Lembar fotocopy KK & KTP', 0),
(12, 16, '1771473638_c82f3ec5ac76d267ca06.png', '', '', 'Adobe Photoshop\r\nIllustrator\r\nCorelDRAW ', 'a. Mengisi formulir pendaftaran\r\nb. 1 Lembar fotocopy ijazah terakhir\r\nc. 2 Lembar pas foto ukuran 4x6 warna\r\nd. Biaya pendaftaran Rp.100.000\r\ne. Menyerahkan uang muka 50% dan biaya pendaftaran\r\nf. 1 Lembar fotocopy KK & KTP', 0),
(13, 17, '1771473975_a996ccbf42b8548cd5e1.png', '', '', 'Menggunakan Perangkat Komputer\r\nMenggunakan Sistem Operasi (Mengelola file dan folder: membuat, menyimpan, menyalin, menghapus\r\nPengaturan dasar melalui Control Panel\r\nManajemen jendela aplikasi (minimize, maximize, close))\r\nMenggunakan Perangkat Peripheral (Menghubungkan dan menggunakan printer, scanner, flashdisk\r\nMengoperasikan proyektor dan perangkat eksternal lainnya\r\nProsedur aman dalam memasang dan melepas perangkat)', 'a. Mengisi formulir pendaftaran\r\nb. 1 Lembar fotocopy ijazah terakhir\r\nc. 2 Lembar pas foto ukuran 4x6 warna\r\nd. Biaya pendaftaran Rp.100.000\r\ne. Menyerahkan uang muka 50% dan biaya pendaftaran\r\nf. 1 Lembar fotocopy KK & KTP', 0),
(14, 18, '1771474196_48980f214d1988d3a319.png', '', '', 'Penjelasan rumus microsoft excel\r\nPenggunaan rumus microsoft excel', 'a. Mengisi formulir pendaftaran\r\nb. 1 Lembar fotocopy ijazah terakhir\r\nc. 2 Lembar pas foto ukuran 4x6 warna\r\nd. Biaya pendaftaran Rp.100.000\r\ne. Menyerahkan uang muka 50% dan biaya pendaftaran\r\nf. 1 Lembar fotocopy KK & KTP', 0),
(15, 19, '1771474442_d1adc5fda46dc310c1d7.png', '', '', 'HTML\r\nCSS\r\nJavaScript\r\nPHP\r\nMySQL', 'a. Mengisi formulir pendaftaran\r\nb. 1 Lembar fotocopy ijazah terakhir\r\nc. 2 Lembar pas foto ukuran 4x6 warna\r\nd. Biaya pendaftaran Rp.100.000\r\ne. Menyerahkan uang muka 50% dan biaya pendaftaran\r\nf. 1 Lembar fotocopy KK & KTP', 0),
(16, 20, '1771474600_520ba7e50b27493c5e97.png', '', '', 'Desain teknik 2D dan 3D ', 'a. Mengisi formulir pendaftaran\r\nb. 1 Lembar fotocopy ijazah terakhir\r\nc. 2 Lembar pas foto ukuran 4x6 warna\r\nd. Biaya pendaftaran Rp.100.000\r\ne. Menyerahkan uang muka 50% dan biaya pendaftaran\r\nf. 1 Lembar fotocopy KK & KTP', 0),
(17, 21, '1771474827_a7d783ab9d5baa40053e.png', '', '', 'Basic editing video menggunakan Adobe Premiere.\r\nExpert editing video menggunakan Adobe Premiere.', 'a. Mengisi formulir pendaftaran\r\nb. 1 Lembar fotocopy ijazah terakhir\r\nc. 2 Lembar pas foto ukuran 4x6 warna\r\nd. Biaya pendaftaran Rp.100.000\r\ne. Menyerahkan uang muka 50% dan biaya pendaftaran\r\nf. 1 Lembar fotocopy KK & KTP', 0),
(18, 22, '1771474999_78efa69ce6337977a6d7.png', '', '', 'Penggunaan Google Ads\r\nPenggunaan Traffic Ads', 'a. Mengisi formulir pendaftaran\r\nb. 1 Lembar fotocopy ijazah terakhir\r\nc. 2 Lembar pas foto ukuran 4x6 warna\r\nd. Biaya pendaftaran Rp.100.000\r\ne. Menyerahkan uang muka 50% dan biaya pendaftaran\r\nf. 1 Lembar fotocopy KK & KTP', 0),
(19, 23, '1771475602_4a29e3af5713269ea0aa.png', '', '', 'Microsoft Word', 'a. Mengisi formulir pendaftaran\r\nb. 1 Lembar fotocopy ijazah terakhir\r\nc. 2 Lembar pas foto ukuran 4x6 warna\r\nd. Biaya pendaftaran Rp.100.000\r\ne. Menyerahkan uang muka 50% dan biaya pendaftaran\r\nf. 1 Lembar fotocopy KK & KTP', 0),
(20, 24, '1771475932_dd76e6067c2214a0385b.png', '', '', 'Microsoft Office', 'a. Mengisi formulir pendaftaran\r\nb. 1 Lembar fotocopy ijazah terakhir\r\nc. 2 Lembar pas foto ukuran 4x6 warna\r\nd. Biaya pendaftaran Rp.100.000\r\ne. Menyerahkan uang muka 50% dan biaya pendaftaran\r\nf. 1 Lembar fotocopy KK & KTP', 0),
(21, 25, '1771476110_543603429064894f2bf3.png', '', '', 'Penggunaan Microsoft Powerpoin\r\nPenggunaan AI untuk Presentasi', 'a. Mengisi formulir pendaftaran\r\nb. 1 Lembar fotocopy ijazah terakhir\r\nc. 2 Lembar pas foto ukuran 4x6 warna\r\nd. Biaya pendaftaran Rp.100.000\r\ne. Menyerahkan uang muka 50% dan biaya pendaftaran\r\nf. 1 Lembar fotocopy KK & KTP', 0),
(24, 30, '1771904558_83422bbdac7267b14344.jpg', '1771904558_fa308f60a7e65e8dd5c0.jpg', '1771904558_3a516794843283ef7600.jpg', 'Materi Komputer yang disesuaikan dengan umur anak dan paket yang dipilih', 'a. Mengisi formulir pendaftaran\r\nb. 1 Lembar fotocopy ijazah terakhir\r\nc. 2 Lembar pas foto ukuran 4x6 warna\r\nd. Biaya pendaftaran Rp.100.000\r\ne. Menyerahkan uang muka 50% dan biaya pendaftaran\r\nf. 1 Lembar fotocopy KK & KTP', 0),
(25, 31, NULL, NULL, NULL, 'Desain Grafis\r\nApklikasi Perkantoran\r\nAplikasi Akuntasi\r\nVideo Editing\r\nDigital Marketing\r\nAutoCAD\r\nWeb Programming\r\nComputer Basic Skill', 'a. Mengisi formulir pendaftaran\r\nb. 1 Lembar fotocopy ijazah terakhir\r\nc. 2 Lembar pas foto ukuran 4x6 warna\r\nd. Biaya pendaftaran Rp.100.000\r\ne. Menyerahkan uang muka 50% dan biaya pendaftaran\r\nf. 1 Lembar fotocopy KK & KTP', 0),
(26, 32, '1773215325_659f712c84daf984a7df.png', NULL, NULL, 'Materi Logo\r\nMateri Banner,\r\nMateri MMT', 'a. Mengisi formulir pendaftaran\r\nb. 1 Lembar fotocopy ijazah terakhir\r\nc. 2 Lembar pas foto ukuran 4x6 warna\r\nd. Biaya pendaftaran Rp.100.000\r\ne. Menyerahkan uang muka 50% dan biaya pendaftaran\r\nf. 1 Lembar fotocopy KK & KTP', 1),
(27, 33, '1771469653_4518dd3e814f6b634718.jpg', NULL, NULL, 'Materi Microsoft Word\r\nMateri Microsoft Excel\r\nMateri Microsoft PowerPoint', 'a. Mengisi formulir pendaftaran\r\nb. 1 Lembar fotocopy ijazah terakhir\r\nc. 2 Lembar pas foto ukuran 4x6 warna\r\nd. Biaya pendaftaran Rp.100.000\r\ne. Menyerahkan uang muka 50% dan biaya pendaftaran\r\nf. 1 Lembar fotocopy KK & KTP', 0),
(28, 34, '1771473638_0055d1c0897d885425a1.jpg', NULL, NULL, 'Adobe Photoshop\r\nIllustrator\r\nCorelDRAW', 'a. Mengisi formulir pendaftaran\r\nb. 1 Lembar fotocopy ijazah terakhir\r\nc. 2 Lembar pas foto ukuran 4x6 warna\r\nd. Biaya pendaftaran Rp.100.000\r\ne. Menyerahkan uang muka 50% dan biaya pendaftaran\r\nf. 1 Lembar fotocopy KK & KTP', 0),
(29, 35, '1771473975_0f66a72ba47dd63fc764.jpg', NULL, NULL, 'Menggunakan Perangkat Komputer\r\nMenggunakan Sistem Operasi (Mengelola file dan folder: membuat, menyimpan, menyalin, menghapus)\r\nPengaturan dasar melalui Control Panel\r\nManajemen jendela aplikasi (minimize, maximize, close)\r\nMenggunakan Perangkat Peripheral (Menghubungkan dan menggunakan printer, scanner, flashdisk)\r\nMengoperasikan proyektor dan perangkat eksternal lainnya\r\nProsedur aman dalam memasang dan melepas perangkat', 'a. Mengisi formulir pendaftaran\r\nb. 1 Lembar fotocopy ijazah terakhir\r\nc. 2 Lembar pas foto ukuran 4x6 warna\r\nd. Biaya pendaftaran Rp.100.000\r\ne. Menyerahkan uang muka 50% dan biaya pendaftaran\r\nf. 1 Lembar fotocopy KK & KTP', 0),
(30, 36, '1771474196_5a26783cbeab23720842.jpg', NULL, NULL, 'Penjelasan rumus microsoft excel\r\nPenggunaan rumus microsoft excel untuk akuntansi\r\nAplikasi akuntansi dasar', 'a. Mengisi formulir pendaftaran\r\nb. 1 Lembar fotocopy ijazah terakhir\r\nc. 2 Lembar pas foto ukuran 4x6 warna\r\nd. Biaya pendaftaran Rp.100.000\r\ne. Menyerahkan uang muka 50% dan biaya pendaftaran\r\nf. 1 Lembar fotocopy KK & KTP', 0),
(31, 37, '1771474442_d798472020335c94045e.jpg', NULL, NULL, 'HTML\r\nCSS\r\nJavaScript\r\nPHP\r\nMySQL', 'a. Mengisi formulir pendaftaran\r\nb. 1 Lembar fotocopy ijazah terakhir\r\nc. 2 Lembar pas foto ukuran 4x6 warna\r\nd. Biaya pendaftaran Rp.100.000\r\ne. Menyerahkan uang muka 50% dan biaya pendaftaran\r\nf. 1 Lembar fotocopy KK & KTP', 0),
(32, 38, '1771474600_1108d94e6490a245fb97.jpg', NULL, NULL, 'Desain teknik 2D dan 3D dengan AutoCAD\r\nPenggunaan tools dasar AutoCAD\r\nPembuatan gambar teknik', 'a. Mengisi formulir pendaftaran\r\nb. 1 Lembar fotocopy ijazah terakhir\r\nc. 2 Lembar pas foto ukuran 4x6 warna\r\nd. Biaya pendaftaran Rp.100.000\r\ne. Menyerahkan uang muka 50% dan biaya pendaftaran\r\nf. 1 Lembar fotocopy KK & KTP', 0),
(33, 39, '1771474827_8f508fdc05ad15f9cd00.jpg', NULL, NULL, 'Basic editing video menggunakan Adobe Premiere\r\nExpert editing video menggunakan Adobe Premiere\r\nTeknik transisi, efek, dan color grading', 'a. Mengisi formulir pendaftaran\r\nb. 1 Lembar fotocopy ijazah terakhir\r\nc. 2 Lembar pas foto ukuran 4x6 warna\r\nd. Biaya pendaftaran Rp.100.000\r\ne. Menyerahkan uang muka 50% dan biaya pendaftaran\r\nf. 1 Lembar fotocopy KK & KTP', 0),
(34, 40, '1771474999_a4a973ec62fdeeb0ad49.jpg', NULL, NULL, 'Penggunaan Google Ads\r\nPenggunaan Traffic Ads\r\nStrategi pemasaran digital & media sosial', 'a. Mengisi formulir pendaftaran\r\nb. 1 Lembar fotocopy ijazah terakhir\r\nc. 2 Lembar pas foto ukuran 4x6 warna\r\nd. Biaya pendaftaran Rp.100.000\r\ne. Menyerahkan uang muka 50% dan biaya pendaftaran\r\nf. 1 Lembar fotocopy KK & KTP', 0);

-- --------------------------------------------------------

--
-- Table structure for table `diskusi`
--

CREATE TABLE `diskusi` (
  `id_diskusi` int(11) NOT NULL,
  `id_kursus` int(11) NOT NULL,
  `id_modul` int(11) DEFAULT 0,
  `id_user` int(11) NOT NULL,
  `user_role` enum('siswa','mentor','admin') NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `konten` text NOT NULL,
  `kategori` enum('pertanyaan','diskusi','pengumuman') DEFAULT 'pertanyaan',
  `komentar_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT '[]' CHECK (json_valid(`komentar_json`)),
  `total_views` int(11) DEFAULT 0,
  `is_pinned` tinyint(1) DEFAULT 0,
  `is_locked` tinyint(1) DEFAULT 0,
  `status` enum('open','answered','closed') DEFAULT 'open',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `diskusi`
--

INSERT INTO `diskusi` (`id_diskusi`, `id_kursus`, `id_modul`, `id_user`, `user_role`, `user_name`, `judul`, `konten`, `kategori`, `komentar_json`, `total_views`, `is_pinned`, `is_locked`, `status`, `created_at`, `updated_at`) VALUES
(1, 15, 0, 1, 'siswa', 'Budi Saputra', 'Cara mail merge di Word?', 'Saya bingung cara menghubungkan data Excel ke Word untuk mail merge. Ada tutorial?', 'pertanyaan', '[{\"id\":1,\"user_name\":\"Ahmad Fauzi\",\"role\":\"mentor\",\"konten\":\"Halo Budi! Langkahnya: 1) Siapkan data di Excel, 2) Di Word: Mailings > Select Recipients, 3) Insert Merge Field. Nanti saya kirim video tutorialnya 😊\",\"is_solution\":true,\"created_at\":\"2026-02-27 11:00:00\",\"replies\":[{\"user_name\":\"Budi Saputra\",\"konten\":\"Makasih kak! 🙏\",\"created_at\":\"2026-02-27 11:05:00\"}]}]', 45, 0, 0, 'answered', '2026-02-27 14:47:58', '2026-02-27 14:47:58');

-- --------------------------------------------------------

--
-- Table structure for table `instruktur`
--

CREATE TABLE `instruktur` (
  `id_instruktur` int(11) NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `keahlian` text NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `no_telepon` varchar(20) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `pendidikan` varchar(255) DEFAULT NULL,
  `pengalaman` text DEFAULT NULL,
  `urutan` int(11) DEFAULT 1,
  `status` enum('aktif','nonaktif') DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `instruktur`
--

INSERT INTO `instruktur` (`id_instruktur`, `nama_lengkap`, `keahlian`, `foto`, `facebook`, `twitter`, `linkedin`, `instagram`, `email`, `no_telepon`, `deskripsi`, `pendidikan`, `pengalaman`, `urutan`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'M. Zainul Arifin, M.Kom', 'Administrasi Perkantoran & Jaringan Komputer', '14-1.jpg', 'zainul.arifin', 'zainul_inasaba', 'muhammad-zainul-arifin', '@zainul_inasaba', 'zainul@inasaba.com', '08123456780', 'Pengajar senior dengan spesialisasi dalam administrasi perkantoran dan jaringan komputer. Memiliki pengalaman lebih dari 10 tahun di bidang teknologi informasi.', 'S.Kom, M.Kom', 'Pengalaman mengajar lebih dari 10 tahun di berbagai lembaga pelatihan komputer. Ahli dalam troubleshooting jaringan dan aplikasi perkantoran.', 1, 'aktif', '2026-03-17 03:01:28', '2026-03-17 03:05:43', NULL),
(2, 'M. Bachtiar', 'Administrasi Perkantoran & Web Pemrograman', '1645288087032.jpg', 'muhammad.bachtiar', 'bachtiar_inasaba', 'muhammad-bachtiar', '@bachtiar_inasaba', 'bachtiar@inasaba.com', '08123456781', 'Spesialis dalam administrasi perkantoran dan pemrograman web. Menguasai berbagai bahasa pemrograman dan aplikasi perkantoran modern.', 'S.Kom', 'Pengalaman mengajar selama 8 tahun di bidang administrasi dan web programming. Telah menghasilkan ratusan lulusan yang berkualitas.', 2, 'aktif', '2026-03-17 03:01:28', '2026-03-17 03:05:44', NULL),
(3, 'Ayu Tri Kurnianingsih, S.Kom', 'Administrasi Perkantoran Bahasa Inggris & Digital Marketing', 'Pas-foto-Fairus.jpeg', 'ayu.trikurnianingsih', 'ayu_inasaba', 'ayu-tri-kurnianingsih', '@ayu_inasaba', 'ayu@inasaba.com', '08123456782', 'Pengajar dengan keahlian ganda: administrasi perkantoran dengan fokus bahasa Inggris dan digital marketing modern.', 'S.Kom', 'Pengalaman mengajar 6 tahun di bidang administrasi dan digital marketing. Mahir dalam bahasa Inggris dan strategi pemasaran digital.', 3, 'aktif', '2026-03-17 03:01:28', '2026-03-17 03:05:44', NULL),
(4, 'Nurul Hidayah', 'Administrasi Perkantoran & Desain Grafis', 'kkk.png', 'nurul.hidayah', 'nurul_inasaba', 'nurul-hidayah', '@nurul_inasaba', 'nurul@inasaba.com', '08123456783', 'Pengajar muda dengan keahlian dalam administrasi perkantoran dan desain grafis menggunakan software modern.', 'A.Md', 'Pengalaman mengajar 4 tahun di bidang administrasi dan desain grafis. Mahir menggunakan Adobe Creative Suite dan aplikasi desain lainnya.', 4, 'aktif', '2026-03-17 03:01:28', '2026-03-17 03:05:44', NULL),
(5, 'Yafi\' Atha Sababila', 'Administrasi Perkantoran & Jaringan Komputer', 'Untitled31.jpg', 'yafi.atha', 'yafi_inasaba', 'yafi-atha-sababila', '@yafi_inasaba', 'yafi@inasaba.com', '08123456784', 'Pengajar muda dengan passion dalam administrasi perkantoran dan jaringan komputer. Aktif dalam pengembangan kurikulum.', 'S.Kom', 'Pengalaman mengajar 3 tahun di bidang administrasi dan jaringan komputer. Aktif mengikuti perkembangan teknologi terkini.', 5, 'aktif', '2026-03-17 03:01:28', '2026-03-17 03:05:44', NULL),
(6, 'Dawam Abdul Hanif, M.Pd', 'Desain Grafis', 'Untitled12.jpg', 'dawam.hanif', 'dawam_inasaba', 'dawam-abdul-hanif', '@dawam_inasaba', 'dawam@inasaba.com', '08123456785', 'Pengajar senior dengan spesialisasi dalam desain grafis dan multimedia. Memiliki sertifikasi internasional di bidang desain.', 'S.Pd, M.Pd', 'Pengalaman mengajar lebih dari 12 tahun di bidang desain grafis. Telah menerima berbagai penghargaan di bidang desain kreatif.', 6, 'aktif', '2026-03-17 03:01:28', '2026-03-17 03:05:44', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id_simpan` int(11) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `deskripsi` varchar(100) NOT NULL,
  `jumlah_barang` int(11) NOT NULL,
  `tanggal_masuk` datetime DEFAULT NULL,
  `tanggal_keluar` datetime DEFAULT NULL,
  `tanggal_perbaikan` datetime DEFAULT NULL,
  `tanggal_pengecekan` datetime NOT NULL,
  `kondisi` varchar(100) NOT NULL,
  `id_karyawan` int(11) NOT NULL,
  `id_pemilik` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id_simpan`, `nama_barang`, `deskripsi`, `jumlah_barang`, `tanggal_masuk`, `tanggal_keluar`, `tanggal_perbaikan`, `tanggal_pengecekan`, `kondisi`, `id_karyawan`, `id_pemilik`) VALUES
(1, 'Laptop Dell', 'i3 gen 12', 5, NULL, NULL, NULL, '2024-02-09 10:30:00', 'baik', 1, 1),
(2, 'Prokyektor Epson', 'Proyektor Epson', 2, NULL, NULL, NULL, '2024-02-09 10:35:00', 'rusak_ringan', 2, 1),
(3, 'Meja  Komputer', '12x12', 10, NULL, NULL, NULL, '2024-02-09 10:40:00', 'baik', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `karyawan`
--

CREATE TABLE `karyawan` (
  `id_karyawan` int(11) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `nip` varchar(100) NOT NULL,
  `kata_sandi` varchar(255) NOT NULL,
  `level` varchar(100) DEFAULT 'pengajar',
  `foto_profil` varchar(255) DEFAULT 'default.jpg',
  `no_telepon` varchar(15) DEFAULT NULL,
  `alamat` text NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'Aktif',
  `tanggal_daftar` datetime DEFAULT current_timestamp(),
  `last_login` datetime DEFAULT NULL,
  `id_pemilik` int(11) NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `karyawan`
--

INSERT INTO `karyawan` (`id_karyawan`, `nama_lengkap`, `email`, `nip`, `kata_sandi`, `level`, `foto_profil`, `no_telepon`, `alamat`, `status`, `tanggal_daftar`, `last_login`, `id_pemilik`, `deleted_at`, `updated_at`) VALUES
(8, 'Miftahudin', 'hh@gmail.com', '090909', 'ninja150', 'pengajar', '1769413849_d9d71fe292f97ff108bd.png', '0878789798799', 'Jln.Raya Tanjung Tirto Kabupaten Pekalongan', 'aktif', '2026-01-23 13:48:23', '2026-03-14 12:50:16', 0, NULL, '2026-03-14 12:50:16'),
(9, 'Hamdi Hatu', 'haidarhandanovic@gmail.com', '090900', 'ninja150', 'staf_admin', 'karyawan_1773095170_1773095170_8d10c6c862e9d608156b.jpg', '085228666119', 'Perum Tanjung, Tirto, Kabupaten Pekalongan', 'aktif', '2026-02-05 08:48:15', '2026-03-16 05:41:50', 0, NULL, '2026-03-16 05:41:50'),
(10, 'Manfaar Syafaat', 'manfaar@gmail.com', '0909010', 'ninja150', 'teknisi', '1770512001_e61df49f3cd7c136b12c.jpg', '0888787977979', 'Jln.Raya Tanjung Tirto Kabupaten Pekalongan', 'aktif', '2026-02-08 00:52:54', '2026-02-12 07:01:11', 0, NULL, '2026-03-11 14:38:18');

-- --------------------------------------------------------

--
-- Table structure for table `keranjang`
--

CREATE TABLE `keranjang` (
  `id_keranjang` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `id_kursus` int(11) NOT NULL,
  `id_paket` int(11) DEFAULT NULL,
  `nama_paket` varchar(255) DEFAULT NULL,
  `harga_kursus` decimal(15,2) NOT NULL DEFAULT 0.00,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kursus`
--

CREATE TABLE `kursus` (
  `id_kursus` int(11) NOT NULL,
  `id_program` int(11) NOT NULL,
  `id_karyawan` int(11) DEFAULT NULL,
  `nama_kursus` varchar(150) NOT NULL,
  `slug` varchar(150) NOT NULL,
  `gambar_utama` varchar(255) DEFAULT NULL,
  `deskripsi_singkat` text DEFAULT NULL,
  `status` enum('aktif','nonaktif') DEFAULT 'aktif',
  `tanggal_dibuat` datetime DEFAULT current_timestamp(),
  `id_pemilik` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kursus`
--

INSERT INTO `kursus` (`id_kursus`, `id_program`, `id_karyawan`, `nama_kursus`, `slug`, `gambar_utama`, `deskripsi_singkat`, `status`, `tanggal_dibuat`, `id_pemilik`, `created_at`, `updated_at`, `deleted_at`) VALUES
(15, 3, 8, 'Materi Aplikasi Perkantoran', 'Materi_Aplikasi_Perkantoran', '1771469653_4518dd3e814f6b634718.jpg', 'Pelajari Microsoft Office (Word, Excel, PowerPoint) untuk kebutuhan administrasi dan bisnis.', 'aktif', '2026-02-19 02:54:13', 0, NULL, NULL, NULL),
(16, 3, 8, 'Materi Desain Grafis', 'Materi_Desain_Grafis', '1771473638_0055d1c0897d885425a1.jpg', 'Kuasai Adobe Photoshop, Illustrator, CorelDRAW untuk membuat desain profesional.', 'aktif', '2026-02-19 04:00:38', 0, NULL, NULL, NULL),
(17, 3, 8, 'Materi Computer Basic Skill', 'Materi_Computer_Basic_Skill', '1771473975_0f66a72ba47dd63fc764.jpg', 'Belajar komputer dasar untuk pemula dan profesional.', 'aktif', '2026-02-19 04:06:15', 0, NULL, NULL, NULL),
(18, 3, 8, 'Materi Accounting', 'Materi_Accounting', '1771474196_5a26783cbeab23720842.jpg', 'Pelajari aplikasi akuntansi untuk bisnis dan keuangan.', 'aktif', '2026-02-19 04:09:56', 0, NULL, NULL, NULL),
(19, 3, 8, 'Materi Web Progaming', 'Materi_Web_Progaming', '1771474442_d798472020335c94045e.jpg', 'Kuasai HTML, CSS, JavaScript, PHP & MySQL untuk membuat website profesional.', 'aktif', '2026-02-19 04:14:02', 0, NULL, NULL, NULL),
(20, 3, 8, 'Materi Desain AutoCad', 'MateriDesainAutoCad', '1771474600_1108d94e6490a245fb97.jpg', 'Pelajari desain teknik 2D dan 3D dengan AutoCAD.', 'aktif', '2026-02-19 04:16:40', 0, NULL, NULL, NULL),
(21, 3, 8, 'Materi Video Editing', 'Materi_Video_Editing', '1771474827_8f508fdc05ad15f9cd00.jpg', 'Belajar editing video profesional dengan Adobe Premiere.', 'aktif', '2026-02-19 04:20:27', 0, NULL, NULL, NULL),
(22, 3, 8, 'Materi Digital Marketing', 'Materi_Digital_Marketing', '1771474999_a4a973ec62fdeeb0ad49.jpg', 'Kuasai strategi pemasaran digital untuk bisnis online Anda.', 'aktif', '2026-02-19 04:23:19', 0, NULL, NULL, NULL),
(23, 2, 8, 'Menyusun surat dengan MS Word untuk sekretaris', 'MS_word_sekretaris', '1771475602_98592a77b76d4d528972.jpg', 'Menyusun surat baik dan benar dengan MS Word untuk sekretaris', 'aktif', '2026-02-19 04:33:22', 0, NULL, NULL, NULL),
(24, 2, 8, 'Rahasia surat massal & Daftar isi otomatis', 'Rahasiasuratmassal_Daftarisiotomatis', '1771475932_7087909a9908ff668948.jpg', 'Menbongkar rahasia surat massal & Daftar isi otomatis', 'aktif', '2026-02-19 04:38:52', 0, NULL, NULL, NULL),
(25, 2, 8, 'Memanfaatkan AI untuk pembuatan presentasi', 'MemanfaatkanAIuntukpembuatanpresentasi', '1771476110_d4cdc35989aa781765cf.jpg', 'AI selain bikin gambar, animasi, video pendek juga dapat digunakan untuk membuat presentasi', 'aktif', '2026-02-19 04:41:50', 0, NULL, NULL, NULL),
(29, 4, 8, 'Sekretaris & Administrasi Perkantoran', 'Sekretaris_administrasi_perkantoran', '1771904433_41217136b6b1920d7a1c.jpg', 'Jurusan Sekretaris Administrasi Perkantoran dirancang untuk lulusan SMA/SMK/sederajat serta masyarakat umum yang ingin berkarier di bidang administrasi perkantoran. Program ini membekali peserta dengan keterampilan profesional seperti pengelolaan dokumen, korespondensi, pengarsipan, pelayanan administrasi, serta komunikasi perkantoran. Lulusan dipersiapkan untuk siap kerja sebagai sekretaris atau staf administrasi di berbagai instansi dan perusahaan.', 'aktif', '2026-02-24 03:40:33', 0, NULL, '2026-03-11 14:44:02', NULL),
(30, 5, 8, 'Computer For Kid', 'CFK', '1771904558_cf608cf81f3b2510f584.png', 'Pilihan Program CFK Kami', 'aktif', '2026-02-24 03:42:38', 0, NULL, '2026-03-16 20:53:40', '2026-03-16 20:53:40'),
(31, 6, 8, 'Kelas Offline', 'Program_Kursus', '1771904907_cc6a257ed31b555176a5.jpg', 'Program kursus yang ditentukan jadwal, dan pengajar dari INASABA dab dilaksanakan di tempat kursus ', 'aktif', '2026-02-24 03:48:27', 0, NULL, NULL, NULL),
(32, 4, 8, 'DKV _ Desain Komunikasi Visual', 'DKV', '1773215325_b193125967ae101d1c9f.jpg', 'DKV merupakan program profesi yang dilaksanakan 1 tahun', 'aktif', '2026-03-11 14:48:45', 1, '2026-03-11 14:48:45', '2026-03-11 14:50:21', NULL),
(33, 6, 8, 'Materi Aplikasi Perkantoran', 'Materi_Aplikasi_Perkantoran_v6', '1771469653_4518dd3e814f6b634718.jpg', 'Pelajari Microsoft Office (Word, Excel, PowerPoint) untuk kebutuhan administrasi dan bisnis.', 'aktif', '2026-02-19 02:54:13', 0, NULL, NULL, NULL),
(34, 6, 8, 'Materi Desain Grafis', 'Materi_Desain_Grafis_v6', '1771473638_0055d1c0897d885425a1.jpg', 'Kuasai Adobe Photoshop, Illustrator, CorelDRAW untuk membuat desain profesional.', 'aktif', '2026-02-19 04:00:38', 0, NULL, NULL, NULL),
(35, 6, 8, 'Materi Computer Basic Skill', 'Materi_Computer_Basic_Skill_v6', '1771473975_0f66a72ba47dd63fc764.jpg', 'Belajar komputer dasar untuk pemula dan profesional.', 'aktif', '2026-02-19 04:06:15', 0, NULL, NULL, NULL),
(36, 6, 8, 'Materi Accounting', 'Materi_Accounting_v6', '1771474196_5a26783cbeab23720842.jpg', 'Pelajari aplikasi akuntansi untuk bisnis dan keuangan.', 'aktif', '2026-02-19 04:09:56', 0, NULL, NULL, NULL),
(37, 6, 8, 'Materi Web Progaming', 'Materi_Web_Progaming_v6', '1771474442_d798472020335c94045e.jpg', 'Kuasai HTML, CSS, JavaScript, PHP & MySQL untuk membuat website profesional.', 'aktif', '2026-02-19 04:14:02', 0, NULL, NULL, NULL),
(38, 6, 8, 'Materi Desain AutoCad', 'MateriDesainAutoCad_v6', '1771474600_1108d94e6490a245fb97.jpg', 'Pelajari desain teknik 2D dan 3D dengan AutoCAD.', 'aktif', '2026-02-19 04:16:40', 0, NULL, NULL, NULL),
(39, 6, 8, 'Materi Video Editing', 'Materi_Video_Editing_v6', '1771474827_8f508fdc05ad15f9cd00.jpg', 'Belajar editing video profesional dengan Adobe Premiere.', 'aktif', '2026-02-19 04:20:27', 0, NULL, NULL, NULL),
(40, 6, 8, 'Materi Digital Marketing', 'Materi_Digital_Marketing_v6', '1771474999_a4a973ec62fdeeb0ad49.jpg', 'Kuasai strategi pemasaran digital untuk bisnis online Anda.', 'aktif', '2026-02-19 04:23:19', 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lulusan`
--

CREATE TABLE `lulusan` (
  `id_lulusan` int(11) NOT NULL,
  `nama_lulusan` varchar(255) NOT NULL COMMENT 'Nama lengkap lulusan',
  `nisn` varchar(20) DEFAULT NULL COMMENT 'Nomor Induk Siswa Nasional',
  `nik` varchar(20) DEFAULT NULL COMMENT 'Nomor Induk Kependudukan',
  `tempat_lahir` varchar(100) DEFAULT NULL COMMENT 'Tempat lahir',
  `tanggal_lahir` date DEFAULT NULL COMMENT 'Tanggal lahir',
  `jenis_kelamin` enum('L','P') DEFAULT NULL COMMENT 'Jenis kelamin',
  `agama` varchar(50) DEFAULT NULL COMMENT 'Agama',
  `alamat` text DEFAULT NULL COMMENT 'Alamat lengkap',
  `no_hp` varchar(20) DEFAULT NULL COMMENT 'Nomor telepon',
  `email` varchar(100) DEFAULT NULL COMMENT 'Email',
  `nama_kursus` varchar(255) DEFAULT NULL COMMENT 'Nama kursus yang diambil',
  `tahun_lulus` int(4) DEFAULT NULL COMMENT 'Tahun kelulusan',
  `predikat` varchar(50) DEFAULT NULL COMMENT 'Predikat kelulusan',
  `nilai_akhir` decimal(5,2) DEFAULT NULL COMMENT 'Nilai akhir',
  `foto_lulusan` varchar(255) DEFAULT NULL COMMENT 'Foto resmi lulusan',
  `status_pekerjaan` varchar(100) DEFAULT NULL COMMENT 'Status pekerjaan saat ini',
  `nama_perusahaan` varchar(255) DEFAULT NULL COMMENT 'Nama perusahaan',
  `jabatan` varchar(100) DEFAULT NULL COMMENT 'Jabatan saat ini',
  `kategori` enum('Terbaik','Berprestasi','Biasa') DEFAULT 'Biasa' COMMENT 'Kategori prestasi',
  `created_at` datetime DEFAULT current_timestamp() COMMENT 'Tanggal dibuat',
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL COMMENT 'Soft delete timestamp'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Tabel Lulusan untuk Data Akademik Resmi LPK';

--
-- Dumping data for table `lulusan`
--

INSERT INTO `lulusan` (`id_lulusan`, `nama_lulusan`, `nisn`, `nik`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `agama`, `alamat`, `no_hp`, `email`, `nama_kursus`, `tahun_lulus`, `predikat`, `nilai_akhir`, `foto_lulusan`, `status_pekerjaan`, `nama_perusahaan`, `jabatan`, `kategori`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Ahmad Rizki', '1234567890', '3201011234567890', 'Pekalongan', '2000-05-15', 'L', 'Islam', 'Jl. Merdeka No. 123 Pekalongan', '08123456789', 'ahmad@email.com', 'Desain Grafis', 2023, 'Cumlaude', 95.50, NULL, 'Bekerja', 'PT. Creative Design', 'Senior Designer', 'Terbaik', '2026-03-17 04:51:34', '2026-03-17 04:51:34', NULL),
(2, 'Siti Nurhaliza', '0987654321', '3201010987654321', 'Batang', '2001-03-20', 'P', 'Islam', 'Jl. Sudirman No. 45 Batang', '08234567890', 'siti@email.com', 'Multimedia', 2023, 'Baik', 88.75, NULL, 'Bekerja', 'CV. Media Kreatif', 'Graphic Designer', 'Berprestasi', '2026-03-17 04:51:34', '2026-03-17 04:51:34', NULL),
(3, 'Budi Santoso', '1122334455', '3201011122334455', 'Pekalongan', '2000-08-10', 'L', 'Islam', 'Jl. Pahlawan No. 78 Pekalongan', '08345678901', 'budi@email.com', 'Percetakan', 2022, 'Baik', 85.00, NULL, 'Bekerja', 'PT. Percetakan Jaya', 'Production Supervisor', 'Biasa', '2026-03-17 04:51:34', '2026-03-17 04:51:34', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `manajemen`
--

CREATE TABLE `manajemen` (
  `id_manajemen` int(11) NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `jabatan` varchar(255) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `no_telepon` varchar(20) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `urutan` int(11) DEFAULT 1,
  `status` enum('aktif','nonaktif') DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `manajemen`
--

INSERT INTO `manajemen` (`id_manajemen`, `nama_lengkap`, `jabatan`, `foto`, `facebook`, `twitter`, `linkedin`, `instagram`, `email`, `no_telepon`, `deskripsi`, `urutan`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Rina Arsiyanti, M.Kom', 'Pimpinan', 'fotorina.jpg', 'rina.arsiyanti', 'rina_inasaba', 'rina-arsiyanti', '@rina_inasaba', 'rina@inasaba.com', '08123456789', 'Memimpin LPK INASABA dengan visi dan misi yang jelas untuk mencetak lulusan berkualitas.', 1, 'aktif', '2026-03-17 03:01:28', '2026-03-17 03:05:43', NULL),
(2, 'Durratul Fainiyah', 'Kesiswaan', '42.jpg', 'durrot.fainiyah', 'durrot_inasaba', 'durrot-fainiyah', '@durrot_inasaba', 'durrot@inasaba.com', '08123456790', 'Mengurus segala kegiatan dan administrasi kesiswaan LPK INASABA.', 2, 'aktif', '2026-03-17 03:01:28', '2026-03-17 03:05:43', NULL),
(3, 'Mulky Billalina, SE', 'Keuangan', '342.jpg', 'mulky.billalina', 'mulky_inasaba', 'mulky-billalina', '@mulky_inasaba', 'mulky@inasaba.com', '08123456791', 'Mengelola keuangan LPK INASABA dengan transparansi dan akuntabilitas.', 3, 'aktif', '2026-03-17 03:01:28', '2026-03-17 03:05:43', NULL),
(4, 'M. Lutfi Maulana', 'Desain & Marketing', 'lo-scaled.jpg', 'muhammad.lutfi', 'lutfi_inasaba', 'muhammad-lutfi-maulana', '@lutfi_inasaba', 'lutfi@inasaba.com', '08123456792', 'Bertanggung jawab atas desain grafis dan pemasaran LPK INASABA.', 4, 'aktif', '2026-03-17 03:01:28', '2026-03-17 03:05:43', NULL),
(5, 'Muhammad Syafiat', 'Teknisi', 'syafaat.jpg', 'muhammad.syafiat', 'syafiat_inasaba', 'muhammad-syafiat', '@syafiat_inasaba', 'syafiat@inasaba.com', '08123456793', 'Mengelola maintenance dan teknisi peralatan komputer LPK INASABA.', 5, 'aktif', '2026-03-17 03:01:28', '2026-03-17 03:05:43', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `materi`
--

CREATE TABLE `materi` (
  `id_materi` int(11) NOT NULL,
  `id_modul` int(11) NOT NULL COMMENT 'Relasi ke tabel_modul.id_modul',
  `id_kursus` int(11) NOT NULL COMMENT 'Relasi ke tabel_kursus.id_kursus',
  `judul_materi` varchar(255) NOT NULL,
  `tipe_materi` enum('youtube','zoom','text','quiz') DEFAULT 'youtube',
  `url_youtube` varchar(255) DEFAULT NULL,
  `konten_text` text DEFAULT NULL,
  `deskripsi_materi` text DEFAULT NULL,
  `urutan` int(11) DEFAULT 0,
  `is_preview` tinyint(1) DEFAULT 0 COMMENT '1=Gratis/Preview, 0=Berbayar',
  `status` enum('aktif','nonaktif') DEFAULT 'aktif',
  `tanggal_dibuat` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `materi`
--

INSERT INTO `materi` (`id_materi`, `id_modul`, `id_kursus`, `judul_materi`, `tipe_materi`, `url_youtube`, `konten_text`, `deskripsi_materi`, `urutan`, `is_preview`, `status`, `tanggal_dibuat`) VALUES
(1, 1, 15, 'Pengenalan Interface Microsoft Word', 'youtube', 'https://www.youtube.com/watch?v=J5zNsJs9G2c', NULL, 'Video tutorial pengenalan interface Microsoft Word 2021', 1, 1, 'aktif', '2026-03-16 13:36:00'),
(2, 1, 15, 'Membuat Dokumen Baru', 'youtube', 'https://www.youtube.com/watch?v=7V_2g6Q7J7w', NULL, 'Cara membuat dokumen baru di Microsoft Word', 2, 1, 'aktif', '2026-03-16 13:36:00'),
(3, 1, 15, 'Format Text dan Paragraph', 'youtube', 'https://www.youtube.com/watch?v=8Xg9kV0vQ6k', NULL, 'Tutorial formatting text dan paragraph di Word', 3, 0, 'aktif', '2026-03-16 13:36:00'),
(4, 2, 15, 'Pengenalan Interface Excel', 'youtube', 'https://www.youtube.com/watch?v=9Y9mV0s0X0c', NULL, 'Video tutorial pengenalan Microsoft Excel 2021', 1, 1, 'aktif', '2026-03-16 13:36:00'),
(5, 2, 15, 'Formula Dasar Excel', 'youtube', 'https://www.youtube.com/watch?v=A0B6s0Q0YQ0', NULL, 'Belajar formula dasar Excel (SUM, AVERAGE, COUNT)', 2, 0, 'aktif', '2026-03-16 13:36:00'),
(6, 2, 15, 'Chart dan Grafik', 'youtube', 'https://www.youtube.com/watch?v=B1C1C1C1C1C', NULL, 'Membuat chart dan grafik di Excel', 3, 0, 'aktif', '2026-03-16 13:36:00'),
(7, 3, 15, 'Pengenalan PowerPoint', 'youtube', 'https://www.youtube.com/watch?v=C2D2D2D2D2D', NULL, 'Tutorial dasar Microsoft PowerPoint', 1, 1, 'aktif', '2026-03-16 13:36:00'),
(8, 3, 15, 'Membuat Slide Presentasi', 'youtube', 'https://www.youtube.com/watch?v=D3E3E3E3E3E', NULL, 'Cara membuat slide presentasi yang menarik', 2, 0, 'aktif', '2026-03-16 13:36:00'),
(9, 3, 15, 'Animasi dan Transisi', 'youtube', 'https://www.youtube.com/watch?v=F4F4F4F4F4F', NULL, 'Menambahkan animasi dan transisi di PowerPoint', 3, 0, 'aktif', '2026-03-16 13:36:00'),
(10, 4, 16, 'Pengenalan Photoshop', 'youtube', 'https://www.youtube.com/watch?v=G5G5G5G5G5G', NULL, 'Tutorial pengenalan Adobe Photoshop', 1, 1, 'aktif', '2026-03-16 13:36:00'),
(11, 4, 16, 'Tools Dasar Photoshop', 'youtube', 'https://www.youtube.com/watch?v=H6H6H6H6H6H', NULL, 'Pengenalan tools dasar Photoshop', 2, 0, 'aktif', '2026-03-16 13:36:00'),
(12, 5, 16, 'Photo Retouching', 'youtube', 'https://www.youtube.com/watch?v=I7I7I7I7I7I', NULL, 'Teknik photo retouching dasar', 1, 0, 'aktif', '2026-03-16 13:36:00'),
(13, 5, 16, 'Color Correction', 'youtube', 'https://www.youtube.com/watch?v=J8J8J8J8J8J', NULL, 'Teknik color correction di Photoshop', 2, 0, 'aktif', '2026-03-16 13:36:00'),
(14, 6, 16, 'Membuat Poster', 'youtube', 'https://www.youtube.com/watch?v=K9K9K9K9K9K', NULL, 'Tutorial membuat poster dengan Photoshop', 1, 0, 'aktif', '2026-03-16 13:36:00'),
(15, 7, 17, 'Pengenalan Komputer', 'youtube', 'https://www.youtube.com/watch?v=L0L0L0L0L0L', NULL, 'Dasar-dasar penggunaan komputer', 1, 1, 'aktif', '2026-03-16 13:36:00'),
(16, 7, 17, 'Hardware dan Software', 'youtube', 'https://www.youtube.com/watch?v=M1M1M1M1M1M', NULL, 'Pengenalan hardware dan software komputer', 2, 0, 'aktif', '2026-03-16 13:36:00'),
(17, 8, 17, 'Windows 10 Dasar', 'youtube', 'https://www.youtube.com/watch?v=N2N2N2N2N2N', NULL, 'Tutorial dasar Windows 10', 1, 1, 'aktif', '2026-03-16 13:36:00'),
(18, 8, 17, 'File Management', 'youtube', 'https://www.youtube.com/watch?v=O3O3O3O3O3O', NULL, 'Manajemen file dan folder di Windows', 2, 0, 'aktif', '2026-03-16 13:36:00'),
(19, 9, 17, 'Internet Basics', 'youtube', 'https://www.youtube.com/watch?v=P4P4P4P4P4P', NULL, 'Pengenalan internet dan browsing', 1, 1, 'aktif', '2026-03-16 13:36:00'),
(20, 9, 17, 'Email Dasar', 'youtube', 'https://www.youtube.com/watch?v=Q5Q5Q5Q5Q5Q', NULL, 'Tutorial penggunaan email', 2, 0, 'aktif', '2026-03-16 13:36:00'),
(21, 10, 18, 'Pengenalan Akuntansi', 'youtube', 'https://www.youtube.com/watch?v=R6R6R6R6R6R', NULL, 'Konsep dasar akuntansi', 1, 1, 'aktif', '2026-03-16 13:36:00'),
(22, 10, 18, 'Debit dan Kredit', 'youtube', 'https://www.youtube.com/watch?v=S7S7S7S7S7S', NULL, 'Prinsip debit dan kredit', 2, 0, 'aktif', '2026-03-16 13:36:00'),
(23, 11, 18, 'Software Akuntansi', 'youtube', 'https://www.youtube.com/watch?v=T8T8T8T8T8T', NULL, 'Pengenalan software akuntansi', 1, 0, 'aktif', '2026-03-16 13:36:00'),
(24, 12, 18, 'Laporan Keuangan', 'youtube', 'https://www.youtube.com/watch?v=U9U9U9U9U9U', NULL, 'Membuat laporan keuangan', 1, 0, 'aktif', '2026-03-16 13:36:00'),
(25, 13, 19, 'HTML Dasar', 'youtube', 'https://www.youtube.com/watch?v=V0V0V0V0V0V', NULL, 'Tutorial HTML5 untuk pemula', 1, 1, 'aktif', '2026-03-16 13:36:00'),
(26, 13, 19, 'CSS Dasar', 'youtube', 'https://www.youtube.com/watch?v=W1W1W1W1W1W', NULL, 'Tutorial CSS3 untuk styling web', 2, 0, 'aktif', '2026-03-16 13:36:00'),
(27, 14, 19, 'JavaScript Fundamentals', 'youtube', 'https://www.youtube.com/watch?v=X2X2X2X2X2X', NULL, 'Tutorial JavaScript dasar', 1, 0, 'aktif', '2026-03-16 13:36:00'),
(28, 15, 19, 'PHP Dasar', 'youtube', 'https://www.youtube.com/watch?v=Y3Y3Y3Y3Y3Y', NULL, 'Tutorial PHP untuk backend', 1, 0, 'aktif', '2026-03-16 13:36:00'),
(29, 15, 19, 'MySQL Dasar', 'youtube', 'https://www.youtube.com/watch?v=Z4Z4Z4Z4Z4Z', NULL, 'Tutorial MySQL untuk database', 2, 0, 'aktif', '2026-03-16 13:36:00'),
(30, 16, 20, 'Pengenalan AutoCAD', 'youtube', 'https://www.youtube.com/watch?v=A5A5A5A5A5A', NULL, 'Tutorial dasar AutoCAD', 1, 1, 'aktif', '2026-03-16 13:36:00'),
(31, 17, 20, 'Drawing 2D', 'youtube', 'https://www.youtube.com/watch?v=B6B6B6B6B6B', NULL, 'Membuat gambar 2D di AutoCAD', 1, 0, 'aktif', '2026-03-16 13:36:00'),
(32, 18, 20, 'Modeling 3D', 'youtube', 'https://www.youtube.com/watch?v=C7C7C7C7C7C', NULL, 'Modeling 3D dasar AutoCAD', 1, 0, 'aktif', '2026-03-16 13:36:00'),
(33, 19, 21, 'Video Editing Basics', 'youtube', 'https://www.youtube.com/watch?v=D8D8D8D8D8D', NULL, 'Dasar-dasar video editing', 1, 1, 'aktif', '2026-03-16 13:36:00'),
(34, 20, 21, 'Premiere Pro Tutorial', 'youtube', 'https://www.youtube.com/watch?v=E9E9E9E9E9E', NULL, 'Tutorial Adobe Premiere Pro', 1, 0, 'aktif', '2026-03-16 13:36:00'),
(35, 21, 21, 'Video Effects', 'youtube', 'https://www.youtube.com/watch?v=F0F0F0F0F0F', NULL, 'Menambahkan efek video', 1, 0, 'aktif', '2026-03-16 13:36:00'),
(36, 22, 22, 'Digital Marketing Intro', 'youtube', 'https://www.youtube.com/watch?v=G1G1G1G1G1G', NULL, 'Pengenalan digital marketing', 1, 1, 'aktif', '2026-03-16 13:36:00'),
(37, 23, 22, 'SEO Tutorial', 'youtube', 'https://www.youtube.com/watch?v=H2H2H2H2H2H', NULL, 'Tutorial SEO untuk pemula', 1, 0, 'aktif', '2026-03-16 13:36:00'),
(38, 24, 22, 'Social Media Marketing', 'youtube', 'https://www.youtube.com/watch?v=I3I3I3I3I3I', NULL, 'Strategi social media marketing', 1, 0, 'aktif', '2026-03-16 13:36:00'),
(39, 25, 23, 'Format Surat Resmi', 'youtube', 'https://www.youtube.com/watch?v=J4J4J4J4J4J', NULL, 'Tutorial format surat resmi', 1, 1, 'aktif', '2026-03-16 13:36:00'),
(40, 26, 23, 'Mail Merge Word', 'youtube', 'https://www.youtube.com/watch?v=K5K5K5K5K5K', NULL, 'Tutorial mail merge di Word', 1, 0, 'aktif', '2026-03-16 13:36:00'),
(41, 27, 23, 'Template Surat', 'youtube', 'https://www.youtube.com/watch?v=L6L6L6L6L6L', NULL, 'Membuat template surat profesional', 1, 0, 'aktif', '2026-03-16 13:36:00'),
(42, 28, 24, 'Surat Massal Lanjutan', 'youtube', 'https://www.youtube.com/watch?v=M7M7M7M7M7M', NULL, 'Teknik advanced surat massal', 1, 1, 'aktif', '2026-03-16 13:36:00'),
(43, 29, 24, 'Daftar Isi Otomatis', 'youtube', 'https://www.youtube.com/watch?v=N8N8N8N8N8N', NULL, 'Membuat daftar isi otomatis', 1, 0, 'aktif', '2026-03-16 13:36:00'),
(44, 30, 25, 'AI untuk Presentasi', 'youtube', 'https://www.youtube.com/watch?v=O9O9O9O9O9O', NULL, 'Menggunakan AI untuk presentasi', 1, 1, 'aktif', '2026-03-16 13:36:00'),
(45, 31, 29, 'Administrasi Perkantoran', 'youtube', 'https://www.youtube.com/watch?v=P10P10P10P10', NULL, 'Dasar-dasar administrasi perkantoran', 1, 1, 'aktif', '2026-03-16 13:36:00'),
(46, 32, 29, 'Manajemen Dokumen', 'youtube', 'https://www.youtube.com/watch?v=Q11Q11Q11Q11', NULL, 'Pengelolaan dokumen kantor', 1, 0, 'aktif', '2026-03-16 13:36:00'),
(47, 33, 29, 'Komunikasi Kantor', 'youtube', 'https://www.youtube.com/watch?v=R12R12R12R12', NULL, 'Etika komunikasi di kantor', 1, 0, 'aktif', '2026-03-16 13:36:00'),
(48, 34, 30, 'Komputer untuk Anak', 'youtube', 'https://www.youtube.com/watch?v=S13S13S13S13', NULL, 'Pengenalan komputer untuk anak', 1, 1, 'aktif', '2026-03-16 13:36:00'),
(49, 35, 30, 'Games Edukatif', 'youtube', 'https://www.youtube.com/watch?v=T14T14T14T14', NULL, 'Games edukatif untuk pembelajaran', 1, 0, 'aktif', '2026-03-16 13:36:00'),
(50, 36, 31, 'Materi Offline 1', 'text', NULL, 'Materi pertemuan pertama kelas offline meliputi pengenalan dan ice breaking', NULL, 1, 1, 'aktif', '2026-03-16 13:36:00'),
(51, 37, 31, 'Materi Offline 2', 'text', NULL, 'Materi pertemuan kedua kelas offline meliputi praktikum dan diskusi', NULL, 1, 1, 'aktif', '2026-03-16 13:36:00'),
(52, 38, 32, 'Pengenalan DKV', 'youtube', 'https://www.youtube.com/watch?v=U15U15U15U15', NULL, 'Konsep dasar Desain Komunikasi Visual', 1, 1, 'aktif', '2026-03-16 13:36:00'),
(53, 39, 32, 'Tipografi', 'youtube', 'https://www.youtube.com/watch?v=V16V16V16V16', NULL, 'Prinsip tipografi dalam desain', 1, 0, 'aktif', '2026-03-16 13:36:00'),
(54, 40, 32, 'Layout dan Komposisi', 'youtube', 'https://www.youtube.com/watch?v=W17W17W17W17', NULL, 'Prinsip layout dan komposisi visual', 1, 0, 'aktif', '2026-03-16 13:36:00'),
(55, 42, 33, 'Pengenalan Interface Microsoft Word', 'youtube', 'https://www.youtube.com/watch?v=J5zNsJs9G2c', NULL, 'Video tutorial pengenalan interface Microsoft Word 2021', 1, 1, 'aktif', '2026-03-16 21:20:20'),
(56, 42, 33, 'Membuat Dokumen Baru', 'youtube', 'https://www.youtube.com/watch?v=7V_2g6Q7J7w', NULL, 'Cara membuat dokumen baru di Microsoft Word', 2, 1, 'aktif', '2026-03-16 21:20:20'),
(57, 42, 33, 'Format Text dan Paragraph', 'youtube', 'https://www.youtube.com/watch?v=8Xg9kV0vQ6k', NULL, 'Tutorial formatting text dan paragraph di Word', 3, 0, 'aktif', '2026-03-16 21:20:20'),
(58, 43, 33, 'Pengenalan Interface Excel', 'youtube', 'https://www.youtube.com/watch?v=9Y9mV0s0X0c', NULL, 'Video tutorial pengenalan Microsoft Excel 2021', 1, 1, 'aktif', '2026-03-16 21:20:20'),
(59, 43, 33, 'Formula Dasar Excel', 'youtube', 'https://www.youtube.com/watch?v=A0B6s0Q0YQ0', NULL, 'Belajar formula dasar Excel (SUM, AVERAGE, COUNT)', 2, 0, 'aktif', '2026-03-16 21:20:20'),
(60, 43, 33, 'Chart dan Grafik', 'youtube', 'https://www.youtube.com/watch?v=B1C1C1C1C1C', NULL, 'Membuat chart dan grafik di Excel', 3, 0, 'aktif', '2026-03-16 21:20:20'),
(61, 44, 33, 'Pengenalan PowerPoint', 'youtube', 'https://www.youtube.com/watch?v=C2D2D2D2D2D', NULL, 'Tutorial dasar Microsoft PowerPoint', 1, 1, 'aktif', '2026-03-16 21:20:20'),
(62, 44, 33, 'Membuat Slide Presentasi', 'youtube', 'https://www.youtube.com/watch?v=D3E3E3E3E3E', NULL, 'Cara membuat slide presentasi yang menarik', 2, 0, 'aktif', '2026-03-16 21:20:20'),
(63, 44, 33, 'Animasi dan Transisi', 'youtube', 'https://www.youtube.com/watch?v=F4F4F4F4F4F', NULL, 'Menambahkan animasi dan transisi di PowerPoint', 3, 0, 'aktif', '2026-03-16 21:20:20'),
(64, 45, 34, 'Pengenalan Photoshop', 'youtube', 'https://www.youtube.com/watch?v=G5G5G5G5G5G', NULL, 'Tutorial pengenalan Adobe Photoshop', 1, 1, 'aktif', '2026-03-16 21:20:20'),
(65, 45, 34, 'Tools Dasar Photoshop', 'youtube', 'https://www.youtube.com/watch?v=H6H6H6H6H6H', NULL, 'Pengenalan tools dasar Photoshop', 2, 0, 'aktif', '2026-03-16 21:20:20'),
(66, 46, 34, 'Photo Retouching', 'youtube', 'https://www.youtube.com/watch?v=I7I7I7I7I7I', NULL, 'Teknik photo retouching dasar', 1, 0, 'aktif', '2026-03-16 21:20:20'),
(67, 46, 34, 'Color Correction', 'youtube', 'https://www.youtube.com/watch?v=J8J8J8J8J8J', NULL, 'Teknik color correction di Photoshop', 2, 0, 'aktif', '2026-03-16 21:20:20'),
(68, 47, 34, 'Membuat Poster', 'youtube', 'https://www.youtube.com/watch?v=K9K9K9K9K9K', NULL, 'Tutorial membuat poster dengan Photoshop', 1, 0, 'aktif', '2026-03-16 21:20:20'),
(69, 47, 34, 'Membuat Logo', 'youtube', 'https://www.youtube.com/watch?v=L0L0L0L0L0L', NULL, 'Tutorial membuat logo profesional', 2, 0, 'aktif', '2026-03-16 21:20:20'),
(70, 48, 35, 'Pengenalan Komputer', 'youtube', 'https://www.youtube.com/watch?v=M1M1M1M1M1M', NULL, 'Dasar-dasar penggunaan komputer', 1, 1, 'aktif', '2026-03-16 21:20:20'),
(71, 48, 35, 'Hardware dan Software', 'youtube', 'https://www.youtube.com/watch?v=N2N2N2N2N2N', NULL, 'Pengenalan hardware dan software komputer', 2, 0, 'aktif', '2026-03-16 21:20:20'),
(72, 49, 35, 'Windows 10 Dasar', 'youtube', 'https://www.youtube.com/watch?v=O3O3O3O3O3O', NULL, 'Tutorial dasar Windows 10', 1, 1, 'aktif', '2026-03-16 21:20:20'),
(73, 49, 35, 'File Management', 'youtube', 'https://www.youtube.com/watch?v=P4P4P4P4P4P', NULL, 'Manajemen file dan folder di Windows', 2, 0, 'aktif', '2026-03-16 21:20:20'),
(74, 50, 35, 'Internet Basics', 'youtube', 'https://www.youtube.com/watch?v=Q5Q5Q5Q5Q5Q', NULL, 'Pengenalan internet dan browsing', 1, 1, 'aktif', '2026-03-16 21:20:20'),
(75, 50, 35, 'Email Dasar', 'youtube', 'https://www.youtube.com/watch?v=R6R6R6R6R6R', NULL, 'Tutorial penggunaan email', 2, 0, 'aktif', '2026-03-16 21:20:20'),
(76, 51, 36, 'Pengenalan Akuntansi', 'youtube', 'https://www.youtube.com/watch?v=S7S7S7S7S7S', NULL, 'Konsep dasar akuntansi', 1, 1, 'aktif', '2026-03-16 21:20:20'),
(77, 51, 36, 'Debit dan Kredit', 'youtube', 'https://www.youtube.com/watch?v=T8T8T8T8T8T', NULL, 'Prinsip debit dan kredit', 2, 0, 'aktif', '2026-03-16 21:20:20'),
(78, 52, 36, 'Software Akuntansi', 'youtube', 'https://www.youtube.com/watch?v=U9U9U9U9U9U', NULL, 'Pengenalan software akuntansi', 1, 0, 'aktif', '2026-03-16 21:20:20'),
(79, 52, 36, 'Jurnal Umum', 'youtube', 'https://www.youtube.com/watch?v=V0V0V0V0V0V', NULL, 'Membuat jurnal umum akuntansi', 2, 0, 'aktif', '2026-03-16 21:20:20'),
(80, 53, 36, 'Laporan Keuangan', 'youtube', 'https://www.youtube.com/watch?v=W1W1W1W1W1W', NULL, 'Membuat laporan keuangan', 1, 0, 'aktif', '2026-03-16 21:20:20'),
(81, 53, 36, 'Analisa Laporan', 'youtube', 'https://www.youtube.com/watch?v=X2X2X2X2X2X', NULL, 'Analisa rasio keuangan', 2, 0, 'aktif', '2026-03-16 21:20:20'),
(82, 54, 37, 'HTML Dasar', 'youtube', 'https://www.youtube.com/watch?v=Y3Y3Y3Y3Y3Y', NULL, 'Tutorial HTML5 untuk pemula', 1, 1, 'aktif', '2026-03-16 21:20:20'),
(83, 54, 37, 'CSS Dasar', 'youtube', 'https://www.youtube.com/watch?v=Z4Z4Z4Z4Z4Z', NULL, 'Tutorial CSS3 untuk styling web', 2, 0, 'aktif', '2026-03-16 21:20:20'),
(84, 55, 37, 'JavaScript Fundamentals', 'youtube', 'https://www.youtube.com/watch?v=A5A5A5A5A5A', NULL, 'Tutorial JavaScript dasar', 1, 0, 'aktif', '2026-03-16 21:20:20'),
(85, 55, 37, 'DOM Manipulation', 'youtube', 'https://www.youtube.com/watch?v=B6B6B6B6B6B', NULL, 'Manipulasi DOM dengan JavaScript', 2, 0, 'aktif', '2026-03-16 21:20:20'),
(86, 56, 37, 'PHP Dasar', 'youtube', 'https://www.youtube.com/watch?v=C7C7C7C7C7C', NULL, 'Tutorial PHP untuk backend', 1, 0, 'aktif', '2026-03-16 21:20:20'),
(87, 56, 37, 'MySQL Dasar', 'youtube', 'https://www.youtube.com/watch?v=D8D8D8D8D8D', NULL, 'Tutorial MySQL untuk database', 2, 0, 'aktif', '2026-03-16 21:20:20'),
(88, 57, 38, 'Pengenalan AutoCAD', 'youtube', 'https://www.youtube.com/watch?v=E9E9E9E9E9E', NULL, 'Tutorial dasar AutoCAD', 1, 1, 'aktif', '2026-03-16 21:20:20'),
(89, 57, 38, 'Tools Dasar AutoCAD', 'youtube', 'https://www.youtube.com/watch?v=F0F0F0F0F0F', NULL, 'Pengenalan tools dan command AutoCAD', 2, 0, 'aktif', '2026-03-16 21:20:20'),
(90, 58, 38, 'Drawing 2D', 'youtube', 'https://www.youtube.com/watch?v=G1G1G1G1G1G', NULL, 'Membuat gambar 2D di AutoCAD', 1, 0, 'aktif', '2026-03-16 21:20:20'),
(91, 58, 38, 'Dimensioning & Annotation', 'youtube', 'https://www.youtube.com/watch?v=H2H2H2H2H2H', NULL, 'Menambahkan dimensi dan anotasi', 2, 0, 'aktif', '2026-03-16 21:20:20'),
(92, 59, 38, 'Modeling 3D', 'youtube', 'https://www.youtube.com/watch?v=I3I3I3I3I3I', NULL, 'Modeling 3D dasar AutoCAD', 1, 0, 'aktif', '2026-03-16 21:20:20'),
(93, 59, 38, 'Rendering 3D', 'youtube', 'https://www.youtube.com/watch?v=J4J4J4J4J4J', NULL, 'Teknik rendering 3D di AutoCAD', 2, 0, 'aktif', '2026-03-16 21:20:20'),
(94, 60, 39, 'Video Editing Basics', 'youtube', 'https://www.youtube.com/watch?v=K5K5K5K5K5K', NULL, 'Dasar-dasar video editing', 1, 1, 'aktif', '2026-03-16 21:20:20'),
(95, 60, 39, 'Import & Organize Footage', 'youtube', 'https://www.youtube.com/watch?v=L6L6L6L6L6L', NULL, 'Mengimpor dan mengorganisir footage', 2, 0, 'aktif', '2026-03-16 21:20:20'),
(96, 61, 39, 'Premiere Pro Tutorial', 'youtube', 'https://www.youtube.com/watch?v=M7M7M7M7M7M', NULL, 'Tutorial Adobe Premiere Pro', 1, 0, 'aktif', '2026-03-16 21:20:20'),
(97, 61, 39, 'Cutting & Trimming', 'youtube', 'https://www.youtube.com/watch?v=N8N8N8N8N8N', NULL, 'Teknik cutting dan trimming video', 2, 0, 'aktif', '2026-03-16 21:20:20'),
(98, 62, 39, 'Video Effects', 'youtube', 'https://www.youtube.com/watch?v=O9O9O9O9O9O', NULL, 'Menambahkan efek video', 1, 0, 'aktif', '2026-03-16 21:20:20'),
(99, 62, 39, 'Color Grading', 'youtube', 'https://www.youtube.com/watch?v=P10P10P10P10', NULL, 'Teknik color grading profesional', 2, 0, 'aktif', '2026-03-16 21:20:20'),
(100, 63, 40, 'Digital Marketing Intro', 'youtube', 'https://www.youtube.com/watch?v=Q11Q11Q11Q11', NULL, 'Pengenalan digital marketing', 1, 1, 'aktif', '2026-03-16 21:20:20'),
(101, 63, 40, 'Marketing Funnel', 'youtube', 'https://www.youtube.com/watch?v=R12R12R12R12', NULL, 'Memahami marketing funnel', 2, 0, 'aktif', '2026-03-16 21:20:20'),
(102, 64, 40, 'SEO Tutorial', 'youtube', 'https://www.youtube.com/watch?v=S13S13S13S13', NULL, 'Tutorial SEO untuk pemula', 1, 0, 'aktif', '2026-03-16 21:20:20'),
(103, 64, 40, 'Google Ads Basics', 'youtube', 'https://www.youtube.com/watch?v=T14T14T14T14', NULL, 'Dasar-dasar Google Ads', 2, 0, 'aktif', '2026-03-16 21:20:20'),
(104, 65, 40, 'Social Media Marketing', 'youtube', 'https://www.youtube.com/watch?v=U15U15U15U15', NULL, 'Strategi social media marketing', 1, 0, 'aktif', '2026-03-16 21:20:20'),
(105, 65, 40, 'Content Strategy', 'youtube', 'https://www.youtube.com/watch?v=V16V16V16V16', NULL, 'Membuat strategi konten yang efektif', 2, 0, 'aktif', '2026-03-16 21:20:20'),
(106, 42, 33, 'Pengenalan Interface Microsoft Word', 'youtube', 'https://www.youtube.com/watch?v=J5zNsJs9G2c', NULL, 'Video tutorial pengenalan interface Microsoft Word 2021', 1, 1, 'aktif', '2026-03-16 21:23:40'),
(107, 42, 33, 'Membuat Dokumen Baru', 'youtube', 'https://www.youtube.com/watch?v=7V_2g6Q7J7w', NULL, 'Cara membuat dokumen baru di Microsoft Word', 2, 1, 'aktif', '2026-03-16 21:23:40'),
(108, 42, 33, 'Format Text dan Paragraph', 'youtube', 'https://www.youtube.com/watch?v=8Xg9kV0vQ6k', NULL, 'Tutorial formatting text dan paragraph di Word', 3, 0, 'aktif', '2026-03-16 21:23:40'),
(109, 43, 33, 'Pengenalan Interface Excel', 'youtube', 'https://www.youtube.com/watch?v=9Y9mV0s0X0c', NULL, 'Video tutorial pengenalan Microsoft Excel 2021', 1, 1, 'aktif', '2026-03-16 21:23:40'),
(110, 43, 33, 'Formula Dasar Excel', 'youtube', 'https://www.youtube.com/watch?v=A0B6s0Q0YQ0', NULL, 'Belajar formula dasar Excel', 2, 0, 'aktif', '2026-03-16 21:23:40'),
(111, 43, 33, 'Chart dan Grafik', 'youtube', 'https://www.youtube.com/watch?v=B1C1C1C1C1C', NULL, 'Membuat chart dan grafik di Excel', 3, 0, 'aktif', '2026-03-16 21:23:40'),
(112, 44, 33, 'Pengenalan PowerPoint', 'youtube', 'https://www.youtube.com/watch?v=C2D2D2D2D2D', NULL, 'Tutorial dasar Microsoft PowerPoint', 1, 1, 'aktif', '2026-03-16 21:23:40'),
(113, 44, 33, 'Membuat Slide Presentasi', 'youtube', 'https://www.youtube.com/watch?v=D3E3E3E3E3E', NULL, 'Cara membuat slide presentasi yang menarik', 2, 0, 'aktif', '2026-03-16 21:23:40'),
(114, 44, 33, 'Animasi dan Transisi', 'youtube', 'https://www.youtube.com/watch?v=F4F4F4F4F4F', NULL, 'Menambahkan animasi dan transisi di PowerPoint', 3, 0, 'aktif', '2026-03-16 21:23:40'),
(115, 45, 34, 'Pengenalan Photoshop', 'youtube', 'https://www.youtube.com/watch?v=G5G5G5G5G5G', NULL, 'Tutorial pengenalan Adobe Photoshop', 1, 1, 'aktif', '2026-03-16 21:23:40'),
(116, 45, 34, 'Tools Dasar Photoshop', 'youtube', 'https://www.youtube.com/watch?v=H6H6H6H6H6H', NULL, 'Pengenalan tools dasar Photoshop', 2, 0, 'aktif', '2026-03-16 21:23:40'),
(117, 46, 34, 'Photo Retouching', 'youtube', 'https://www.youtube.com/watch?v=I7I7I7I7I7I', NULL, 'Teknik photo retouching dasar', 1, 0, 'aktif', '2026-03-16 21:23:40'),
(118, 46, 34, 'Color Correction', 'youtube', 'https://www.youtube.com/watch?v=J8J8J8J8J8J', NULL, 'Teknik color correction di Photoshop', 2, 0, 'aktif', '2026-03-16 21:23:40'),
(119, 47, 34, 'Membuat Poster', 'youtube', 'https://www.youtube.com/watch?v=K9K9K9K9K9K', NULL, 'Tutorial membuat poster dengan Photoshop', 1, 0, 'aktif', '2026-03-16 21:23:40'),
(120, 47, 34, 'Membuat Logo', 'youtube', 'https://www.youtube.com/watch?v=L0L0L0L0L0L', NULL, 'Tutorial membuat logo profesional', 2, 0, 'aktif', '2026-03-16 21:23:40'),
(121, 48, 35, 'Pengenalan Komputer', 'youtube', 'https://www.youtube.com/watch?v=M1M1M1M1M1M', NULL, 'Dasar-dasar penggunaan komputer', 1, 1, 'aktif', '2026-03-16 21:23:40'),
(122, 48, 35, 'Hardware dan Software', 'youtube', 'https://www.youtube.com/watch?v=N2N2N2N2N2N', NULL, 'Pengenalan hardware dan software komputer', 2, 0, 'aktif', '2026-03-16 21:23:40'),
(123, 49, 35, 'Windows 10 Dasar', 'youtube', 'https://www.youtube.com/watch?v=O3O3O3O3O3O', NULL, 'Tutorial dasar Windows 10', 1, 1, 'aktif', '2026-03-16 21:23:40'),
(124, 49, 35, 'File Management', 'youtube', 'https://www.youtube.com/watch?v=P4P4P4P4P4P', NULL, 'Manajemen file dan folder di Windows', 2, 0, 'aktif', '2026-03-16 21:23:40'),
(125, 50, 35, 'Internet Basics', 'youtube', 'https://www.youtube.com/watch?v=Q5Q5Q5Q5Q5Q', NULL, 'Pengenalan internet dan browsing', 1, 1, 'aktif', '2026-03-16 21:23:40'),
(126, 50, 35, 'Email Dasar', 'youtube', 'https://www.youtube.com/watch?v=R6R6R6R6R6R', NULL, 'Tutorial penggunaan email', 2, 0, 'aktif', '2026-03-16 21:23:40'),
(127, 51, 36, 'Pengenalan Akuntansi', 'youtube', 'https://www.youtube.com/watch?v=S7S7S7S7S7S', NULL, 'Konsep dasar akuntansi', 1, 1, 'aktif', '2026-03-16 21:23:40'),
(128, 51, 36, 'Debit dan Kredit', 'youtube', 'https://www.youtube.com/watch?v=T8T8T8T8T8T', NULL, 'Prinsip debit dan kredit', 2, 0, 'aktif', '2026-03-16 21:23:40'),
(129, 52, 36, 'Software Akuntansi', 'youtube', 'https://www.youtube.com/watch?v=U9U9U9U9U9U', NULL, 'Pengenalan software akuntansi', 1, 0, 'aktif', '2026-03-16 21:23:40'),
(130, 52, 36, 'Jurnal Umum', 'youtube', 'https://www.youtube.com/watch?v=V0V0V0V0V0V', NULL, 'Membuat jurnal umum akuntansi', 2, 0, 'aktif', '2026-03-16 21:23:40'),
(131, 53, 36, 'Laporan Keuangan', 'youtube', 'https://www.youtube.com/watch?v=W1W1W1W1W1W', NULL, 'Membuat laporan keuangan', 1, 0, 'aktif', '2026-03-16 21:23:40'),
(132, 53, 36, 'Analisa Laporan', 'youtube', 'https://www.youtube.com/watch?v=X2X2X2X2X2X', NULL, 'Analisa rasio keuangan', 2, 0, 'aktif', '2026-03-16 21:23:40'),
(133, 54, 37, 'HTML Dasar', 'youtube', 'https://www.youtube.com/watch?v=Y3Y3Y3Y3Y3Y', NULL, 'Tutorial HTML5 untuk pemula', 1, 1, 'aktif', '2026-03-16 21:23:40'),
(134, 54, 37, 'CSS Dasar', 'youtube', 'https://www.youtube.com/watch?v=Z4Z4Z4Z4Z4Z', NULL, 'Tutorial CSS3 untuk styling web', 2, 0, 'aktif', '2026-03-16 21:23:40'),
(135, 55, 37, 'JavaScript Fundamentals', 'youtube', 'https://www.youtube.com/watch?v=A5A5A5A5A5A', NULL, 'Tutorial JavaScript dasar', 1, 0, 'aktif', '2026-03-16 21:23:40'),
(136, 55, 37, 'DOM Manipulation', 'youtube', 'https://www.youtube.com/watch?v=B6B6B6B6B6B', NULL, 'Manipulasi DOM dengan JavaScript', 2, 0, 'aktif', '2026-03-16 21:23:40'),
(137, 56, 37, 'PHP Dasar', 'youtube', 'https://www.youtube.com/watch?v=C7C7C7C7C7C', NULL, 'Tutorial PHP untuk backend', 1, 0, 'aktif', '2026-03-16 21:23:40'),
(138, 56, 37, 'MySQL Dasar', 'youtube', 'https://www.youtube.com/watch?v=D8D8D8D8D8D', NULL, 'Tutorial MySQL untuk database', 2, 0, 'aktif', '2026-03-16 21:23:40'),
(139, 57, 38, 'Pengenalan AutoCAD', 'youtube', 'https://www.youtube.com/watch?v=E9E9E9E9E9E', NULL, 'Tutorial dasar AutoCAD', 1, 1, 'aktif', '2026-03-16 21:23:40'),
(140, 57, 38, 'Tools Dasar AutoCAD', 'youtube', 'https://www.youtube.com/watch?v=F0F0F0F0F0F', NULL, 'Pengenalan tools dan command AutoCAD', 2, 0, 'aktif', '2026-03-16 21:23:40'),
(141, 58, 38, 'Drawing 2D', 'youtube', 'https://www.youtube.com/watch?v=G1G1G1G1G1G', NULL, 'Membuat gambar 2D di AutoCAD', 1, 0, 'aktif', '2026-03-16 21:23:40'),
(142, 58, 38, 'Dimensioning & Annotation', 'youtube', 'https://www.youtube.com/watch?v=H2H2H2H2H2H', NULL, 'Menambahkan dimensi dan anotasi', 2, 0, 'aktif', '2026-03-16 21:23:40'),
(143, 59, 38, 'Modeling 3D', 'youtube', 'https://www.youtube.com/watch?v=I3I3I3I3I3I', NULL, 'Modeling 3D dasar AutoCAD', 1, 0, 'aktif', '2026-03-16 21:23:40'),
(144, 59, 38, 'Rendering 3D', 'youtube', 'https://www.youtube.com/watch?v=J4J4J4J4J4J', NULL, 'Teknik rendering 3D di AutoCAD', 2, 0, 'aktif', '2026-03-16 21:23:40'),
(145, 60, 39, 'Video Editing Basics', 'youtube', 'https://www.youtube.com/watch?v=K5K5K5K5K5K', NULL, 'Dasar-dasar video editing', 1, 1, 'aktif', '2026-03-16 21:23:40'),
(146, 60, 39, 'Import & Organize Footage', 'youtube', 'https://www.youtube.com/watch?v=L6L6L6L6L6L', NULL, 'Mengimpor dan mengorganisir footage', 2, 0, 'aktif', '2026-03-16 21:23:40'),
(147, 61, 39, 'Premiere Pro Tutorial', 'youtube', 'https://www.youtube.com/watch?v=M7M7M7M7M7M', NULL, 'Tutorial Adobe Premiere Pro', 1, 0, 'aktif', '2026-03-16 21:23:40'),
(148, 61, 39, 'Cutting & Trimming', 'youtube', 'https://www.youtube.com/watch?v=N8N8N8N8N8N', NULL, 'Teknik cutting dan trimming video', 2, 0, 'aktif', '2026-03-16 21:23:40'),
(149, 62, 39, 'Video Effects', 'youtube', 'https://www.youtube.com/watch?v=O9O9O9O9O9O', NULL, 'Menambahkan efek video', 1, 0, 'aktif', '2026-03-16 21:23:40'),
(150, 62, 39, 'Color Grading', 'youtube', 'https://www.youtube.com/watch?v=P10P10P10P10', NULL, 'Teknik color grading profesional', 2, 0, 'aktif', '2026-03-16 21:23:40'),
(151, 63, 40, 'Digital Marketing Intro', 'youtube', 'https://www.youtube.com/watch?v=Q11Q11Q11Q11', NULL, 'Pengenalan digital marketing', 1, 1, 'aktif', '2026-03-16 21:23:40'),
(152, 63, 40, 'Marketing Funnel', 'youtube', 'https://www.youtube.com/watch?v=R12R12R12R12', NULL, 'Memahami marketing funnel', 2, 0, 'aktif', '2026-03-16 21:23:40'),
(153, 64, 40, 'SEO Tutorial', 'youtube', 'https://www.youtube.com/watch?v=S13S13S13S13', NULL, 'Tutorial SEO untuk pemula', 1, 0, 'aktif', '2026-03-16 21:23:40'),
(154, 64, 40, 'Google Ads Basics', 'youtube', 'https://www.youtube.com/watch?v=T14T14T14T14', NULL, 'Dasar-dasar Google Ads', 2, 0, 'aktif', '2026-03-16 21:23:40'),
(155, 65, 40, 'Social Media Marketing', 'youtube', 'https://www.youtube.com/watch?v=U15U15U15U15', NULL, 'Strategi social media marketing', 1, 0, 'aktif', '2026-03-16 21:23:40'),
(156, 65, 40, 'Content Strategy', 'youtube', 'https://www.youtube.com/watch?v=V16V16V16V16', NULL, 'Membuat strategi konten yang efektif', 2, 0, 'aktif', '2026-03-16 21:23:40');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
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

-- --------------------------------------------------------

--
-- Table structure for table `mitra_kerja`
--

CREATE TABLE `mitra_kerja` (
  `id_mitra` int(11) NOT NULL,
  `nama_mitra` varchar(255) NOT NULL,
  `logo_mitra` varchar(255) DEFAULT NULL,
  `url_website` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `status` enum('aktif','tidak_aktif') NOT NULL DEFAULT 'aktif',
  `urutan` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mitra_kerja`
--

INSERT INTO `mitra_kerja` (`id_mitra`, `nama_mitra`, `logo_mitra`, `url_website`, `deskripsi`, `status`, `urutan`, `created_at`, `updated_at`, `deleted_at`) VALUES
(9, 'Partner 1', 'bc.png', 'http://localhost/web_lms/public/home_website/index', 'Description for Partner 1', 'aktif', 1, '2026-03-12 16:16:51', '2026-03-15 15:38:39', NULL),
(10, 'Partner 2', 'bd.png', 'http://localhost/web_lms/public/home_website/index', 'Description for Partner 2', 'aktif', 2, '2026-03-12 16:16:51', '2026-03-15 15:38:51', NULL),
(11, 'Partner 3', 'bf.png', 'http://localhost/web_lms/public/home_website/index', 'Description for Partner 3', 'aktif', 3, '2026-03-12 16:16:51', '2026-03-15 15:39:16', NULL),
(12, 'Partner 4', 'd.png', 'http://localhost/web_lms/public/home_website/index', 'Description for Partner 4', 'aktif', 4, '2026-03-12 16:16:51', '2026-03-15 15:39:23', NULL),
(13, 'Partner 5', 'dd.png', 'http://localhost/web_lms/public/home_website/index', 'Description for Partner 5', 'aktif', 5, '2026-03-12 16:16:51', '2026-03-15 15:39:32', NULL),
(14, 'Partner 6', 'dfv.png', 'http://localhost/web_lms/public/home_website/index', 'Description for Partner 6', 'aktif', 6, '2026-03-12 16:16:51', '2026-03-15 15:39:41', NULL),
(15, 'Partner 7', 'j.png', 'http://localhost/web_lms/public/home_website/index', 'Description for Partner 7', 'aktif', 7, '2026-03-12 16:16:51', '2026-03-15 15:39:50', NULL),
(16, 'Partner 8', 'jj.png', 'http://localhost/web_lms/public/home_website/index', 'Description for Partner 8', 'aktif', 8, '2026-03-12 16:16:51', '2026-03-15 15:39:58', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `modul`
--

CREATE TABLE `modul` (
  `id_modul` int(11) NOT NULL,
  `id_kursus` int(11) NOT NULL COMMENT 'Relasi ke tabel_kursus.id_kursus',
  `nama_modul` varchar(255) NOT NULL COMMENT 'Nama bab/chapter',
  `deskripsi` text DEFAULT NULL,
  `urutan` int(11) DEFAULT 0 COMMENT 'Urutan tampilan',
  `tanggal_dibuat` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `modul`
--

INSERT INTO `modul` (`id_modul`, `id_kursus`, `nama_modul`, `deskripsi`, `urutan`, `tanggal_dibuat`) VALUES
(1, 15, 'Modul 1: Pengenalan Microsoft Word', 'Pengenalan dasar-dasar Microsoft Word untuk pemula', 1, '2026-03-16 13:36:00'),
(2, 15, 'Modul 2: Pengenalan Microsoft Excel', 'Belajar dasar-dasar Microsoft Excel untuk perhitungan', 2, '2026-03-16 13:36:00'),
(3, 15, 'Modul 3: Pengenalan Microsoft PowerPoint', 'Membuat presentasi profesional dengan PowerPoint', 3, '2026-03-16 13:36:00'),
(4, 16, 'Modul 1: Dasar-dasar Adobe Photoshop', 'Pengenalan tools dan interface Photoshop', 1, '2026-03-16 13:36:00'),
(5, 16, 'Modul 2: Teknik Editing Foto', 'Belajar teknik editing foto profesional', 2, '2026-03-16 13:36:00'),
(6, 16, 'Modul 3: Desain Grafis Dasar', 'Membuat desain grafis untuk kebutuhan bisnis', 3, '2026-03-16 13:36:00'),
(7, 17, 'Modul 1: Pengenalan Komputer', 'Dasar-dasar penggunaan komputer untuk pemula', 1, '2026-03-16 13:36:00'),
(8, 17, 'Modul 2: Sistem Operasi Windows', 'Menggunakan Windows 10/11 secara efektif', 2, '2026-03-16 13:36:00'),
(9, 17, 'Modul 3: Internet dan Email', 'Belajar menggunakan internet dan email', 3, '2026-03-16 13:36:00'),
(10, 18, 'Modul 1: Pengenalan Akuntansi', 'Konsep dasar akuntansi dan prinsip-prinsipnya', 1, '2026-03-16 13:36:00'),
(11, 18, 'Modul 2: Software Akuntansi', 'Menggunakan software akuntansi untuk bisnis', 2, '2026-03-16 13:36:00'),
(12, 18, 'Modul 3: Laporan Keuangan', 'Membuat dan menganalisis laporan keuangan', 3, '2026-03-16 13:36:00'),
(13, 19, 'Modul 1: HTML & CSS Dasar', 'Belajar HTML5 dan CSS3 untuk pemula', 1, '2026-03-16 13:36:00'),
(14, 19, 'Modul 2: JavaScript Fundamental', 'Pemrograman JavaScript untuk interaksi web', 2, '2026-03-16 13:36:00'),
(15, 19, 'Modul 3: PHP & MySQL', 'Backend development dengan PHP dan database MySQL', 3, '2026-03-16 13:36:00'),
(16, 20, 'Modul 1: Pengenalan AutoCAD', 'Interface dan tools dasar AutoCAD', 1, '2026-03-16 13:36:00'),
(17, 20, 'Modul 2: Drawing 2D', 'Membuat gambar teknik 2D dengan AutoCAD', 2, '2026-03-16 13:36:00'),
(18, 20, 'Modul 3: Modeling 3D', 'Pemodelan 3D dasar dengan AutoCAD', 3, '2026-03-16 13:36:00'),
(19, 21, 'Modul 1: Pengenalan Video Editing', 'Konsep dasar editing video', 1, '2026-03-16 13:36:00'),
(20, 21, 'Modul 2: Adobe Premiere Pro', 'Menggunakan Adobe Premiere Pro untuk editing', 2, '2026-03-16 13:36:00'),
(21, 21, 'Modul 3: Efek dan Transisi', 'Menambahkan efek dan transisi profesional', 3, '2026-03-16 13:36:00'),
(22, 22, 'Modul 1: Pengenalan Digital Marketing', 'Konsep dasar pemasaran digital', 1, '2026-03-16 13:36:00'),
(23, 22, 'Modul 2: SEO dan SEM', 'Optimasi mesin pencari dan iklan berbayar', 2, '2026-03-16 13:36:00'),
(24, 22, 'Modul 3: Social Media Marketing', 'Pemasaran melalui media sosial', 3, '2026-03-16 13:36:00'),
(25, 23, 'Modul 1: Format Surat Resmi', 'Struktur dan format surat dinas', 1, '2026-03-16 13:36:00'),
(26, 23, 'Modul 2: Mail Merge Word', 'Teknik surat massal dengan Word', 2, '2026-03-16 13:36:00'),
(27, 23, 'Modul 3: Template Surat', 'Membuat template surat profesional', 3, '2026-03-16 13:36:00'),
(28, 24, 'Modul 1: Surat Massal Lanjutan', 'Teknik advanced surat massal', 1, '2026-03-16 13:36:00'),
(29, 24, 'Modul 2: Daftar Isi Otomatis', 'Membuat daftar isi otomatis di Word', 2, '2026-03-16 13:36:00'),
(30, 25, 'Modul 1: AI untuk Presentasi', 'Menggunakan AI untuk membuat presentasi', 1, '2026-03-16 13:36:00'),
(31, 29, 'Modul 1: Administrasi Perkantoran Dasar', 'Konsep dasar administrasi perkantoran', 1, '2026-03-16 13:36:00'),
(32, 29, 'Modul 2: Manajemen Dokumen', 'Pengelolaan dokumen dan arsip', 2, '2026-03-16 13:36:00'),
(33, 29, 'Modul 3: Komunikasi Kantor', 'Etika dan komunikasi di lingkungan kantor', 3, '2026-03-16 13:36:00'),
(34, 30, 'Modul 1: Komputer untuk Anak', 'Pengenalan komputer untuk anak-anak', 1, '2026-03-16 13:36:00'),
(35, 30, 'Modul 2: Games Edukatif', 'Menggunakan games untuk pembelajaran', 2, '2026-03-16 13:36:00'),
(36, 31, 'Modul 1: Materi Offline Kelas 1', 'Materi pertemuan pertama kelas offline', 1, '2026-03-16 13:36:00'),
(37, 31, 'Modul 2: Materi Offline Kelas 2', 'Materi pertemuan kedua kelas offline', 2, '2026-03-16 13:36:00'),
(38, 32, 'Modul 1: Pengenalan DKV', 'Konsep dasar Desain Komunikasi Visual', 1, '2026-03-16 13:36:00'),
(39, 32, 'Modul 2: Tipografi', 'Prinsip tipografi dalam desain', 2, '2026-03-16 13:36:00'),
(40, 32, 'Modul 3: Layout dan Komposisi', 'Prinsip layout dan komposisi visual', 3, '2026-03-16 13:36:00'),
(41, 30, 'Modul 1: Add', 'Test', 0, '2026-03-16 19:36:11'),
(42, 33, 'Modul 1: Pengenalan Microsoft Word', 'Pengenalan dasar-dasar Microsoft Word untuk pemula', 1, '2026-03-16 21:20:20'),
(43, 33, 'Modul 2: Pengenalan Microsoft Excel', 'Belajar dasar-dasar Microsoft Excel untuk perhitungan', 2, '2026-03-16 21:20:20'),
(44, 33, 'Modul 3: Pengenalan Microsoft PowerPoint', 'Membuat presentasi profesional dengan PowerPoint', 3, '2026-03-16 21:20:20'),
(45, 34, 'Modul 1: Dasar-dasar Adobe Photoshop', 'Pengenalan tools dan interface Photoshop', 1, '2026-03-16 21:20:20'),
(46, 34, 'Modul 2: Teknik Editing Foto', 'Belajar teknik editing foto profesional', 2, '2026-03-16 21:20:20'),
(47, 34, 'Modul 3: Desain Grafis Dasar', 'Membuat desain grafis untuk kebutuhan bisnis', 3, '2026-03-16 21:20:20'),
(48, 35, 'Modul 1: Pengenalan Komputer', 'Dasar-dasar penggunaan komputer untuk pemula', 1, '2026-03-16 21:20:20'),
(49, 35, 'Modul 2: Sistem Operasi Windows', 'Menggunakan Windows 10/11 secara efektif', 2, '2026-03-16 21:20:20'),
(50, 35, 'Modul 3: Internet dan Email', 'Belajar menggunakan internet dan email', 3, '2026-03-16 21:20:20'),
(51, 36, 'Modul 1: Pengenalan Akuntansi', 'Konsep dasar akuntansi dan prinsip-prinsipnya', 1, '2026-03-16 21:20:20'),
(52, 36, 'Modul 2: Software Akuntansi', 'Menggunakan software akuntansi untuk bisnis', 2, '2026-03-16 21:20:20'),
(53, 36, 'Modul 3: Laporan Keuangan', 'Membuat dan menganalisis laporan keuangan', 3, '2026-03-16 21:20:20'),
(54, 37, 'Modul 1: HTML & CSS Dasar', 'Belajar HTML5 dan CSS3 untuk pemula', 1, '2026-03-16 21:20:20'),
(55, 37, 'Modul 2: JavaScript Fundamental', 'Pemrograman JavaScript untuk interaksi web', 2, '2026-03-16 21:20:20'),
(56, 37, 'Modul 3: PHP & MySQL', 'Backend development dengan PHP dan database MySQL', 3, '2026-03-16 21:20:20'),
(57, 38, 'Modul 1: Pengenalan AutoCAD', 'Interface dan tools dasar AutoCAD', 1, '2026-03-16 21:20:20'),
(58, 38, 'Modul 2: Drawing 2D', 'Membuat gambar teknik 2D dengan AutoCAD', 2, '2026-03-16 21:20:20'),
(59, 38, 'Modul 3: Modeling 3D', 'Pemodelan 3D dasar dengan AutoCAD', 3, '2026-03-16 21:20:20'),
(60, 39, 'Modul 1: Pengenalan Video Editing', 'Konsep dasar editing video', 1, '2026-03-16 21:20:20'),
(61, 39, 'Modul 2: Adobe Premiere Pro', 'Menggunakan Adobe Premiere Pro untuk editing', 2, '2026-03-16 21:20:20'),
(62, 39, 'Modul 3: Efek dan Transisi', 'Menambahkan efek dan transisi profesional', 3, '2026-03-16 21:20:20'),
(63, 40, 'Modul 1: Pengenalan Digital Marketing', 'Konsep dasar pemasaran digital', 1, '2026-03-16 21:20:20'),
(64, 40, 'Modul 2: SEO dan SEM', 'Optimasi mesin pencari dan iklan berbayar', 2, '2026-03-16 21:20:20'),
(65, 40, 'Modul 3: Social Media Marketing', 'Pemasaran melalui media sosial', 3, '2026-03-16 21:20:20'),
(66, 33, 'Modul 1: Pengenalan Microsoft Word', 'Pengenalan dasar-dasar Microsoft Word untuk pemula', 1, '2026-03-16 21:23:40'),
(67, 33, 'Modul 2: Pengenalan Microsoft Excel', 'Belajar dasar-dasar Microsoft Excel untuk perhitungan', 2, '2026-03-16 21:23:40'),
(68, 33, 'Modul 3: Pengenalan Microsoft PowerPoint', 'Membuat presentasi profesional dengan PowerPoint', 3, '2026-03-16 21:23:40'),
(69, 34, 'Modul 1: Dasar-dasar Adobe Photoshop', 'Pengenalan tools dan interface Photoshop', 1, '2026-03-16 21:23:40'),
(70, 34, 'Modul 2: Teknik Editing Foto', 'Belajar teknik editing foto profesional', 2, '2026-03-16 21:23:40'),
(71, 34, 'Modul 3: Desain Grafis Dasar', 'Membuat desain grafis untuk kebutuhan bisnis', 3, '2026-03-16 21:23:40'),
(72, 35, 'Modul 1: Pengenalan Komputer', 'Dasar-dasar penggunaan komputer untuk pemula', 1, '2026-03-16 21:23:40'),
(73, 35, 'Modul 2: Sistem Operasi Windows', 'Menggunakan Windows 10/11 secara efektif', 2, '2026-03-16 21:23:40'),
(74, 35, 'Modul 3: Internet dan Email', 'Belajar menggunakan internet dan email', 3, '2026-03-16 21:23:40'),
(75, 36, 'Modul 1: Pengenalan Akuntansi', 'Konsep dasar akuntansi dan prinsip-prinsipnya', 1, '2026-03-16 21:23:40'),
(76, 36, 'Modul 2: Software Akuntansi', 'Menggunakan software akuntansi untuk bisnis', 2, '2026-03-16 21:23:40'),
(77, 36, 'Modul 3: Laporan Keuangan', 'Membuat dan menganalisis laporan keuangan', 3, '2026-03-16 21:23:40'),
(78, 37, 'Modul 1: HTML & CSS Dasar', 'Belajar HTML5 dan CSS3 untuk pemula', 1, '2026-03-16 21:23:40'),
(79, 37, 'Modul 2: JavaScript Fundamental', 'Pemrograman JavaScript untuk interaksi web', 2, '2026-03-16 21:23:40'),
(80, 37, 'Modul 3: PHP & MySQL', 'Backend development dengan PHP dan database MySQL', 3, '2026-03-16 21:23:40'),
(81, 38, 'Modul 1: Pengenalan AutoCAD', 'Interface dan tools dasar AutoCAD', 1, '2026-03-16 21:23:40'),
(82, 38, 'Modul 2: Drawing 2D', 'Membuat gambar teknik 2D dengan AutoCAD', 2, '2026-03-16 21:23:40'),
(83, 38, 'Modul 3: Modeling 3D', 'Pemodelan 3D dasar dengan AutoCAD', 3, '2026-03-16 21:23:40'),
(84, 39, 'Modul 1: Pengenalan Video Editing', 'Konsep dasar editing video', 1, '2026-03-16 21:23:40'),
(85, 39, 'Modul 2: Adobe Premiere Pro', 'Menggunakan Adobe Premiere Pro untuk editing', 2, '2026-03-16 21:23:40'),
(86, 39, 'Modul 3: Efek dan Transisi', 'Menambahkan efek dan transisi profesional', 3, '2026-03-16 21:23:40'),
(87, 40, 'Modul 1: Pengenalan Digital Marketing', 'Konsep dasar pemasaran digital', 1, '2026-03-16 21:23:40'),
(88, 40, 'Modul 2: SEO dan SEM', 'Optimasi mesin pencari dan iklan berbayar', 2, '2026-03-16 21:23:40'),
(89, 40, 'Modul 3: Social Media Marketing', 'Pemasaran melalui media sosial', 3, '2026-03-16 21:23:40');

-- --------------------------------------------------------

--
-- Table structure for table `paket_kursus`
--

CREATE TABLE `paket_kursus` (
  `id_paket` int(11) NOT NULL,
  `id_kursus` int(11) NOT NULL,
  `nama_paket` varchar(255) NOT NULL,
  `paket_a` varchar(100) DEFAULT NULL COMMENT 'Nama Paket A (Reguler)',
  `paket_b` varchar(100) DEFAULT NULL COMMENT 'Nama Paket B (Intensive)',
  `paket_c` varchar(100) DEFAULT NULL COMMENT 'Nama Paket C (Private)',
  `jadwal_pelatihan` varchar(100) NOT NULL,
  `total_pertemuan` int(11) DEFAULT NULL,
  `durasi_per_pertemuan_jam` int(11) DEFAULT NULL,
  `harga_reguler` decimal(15,2) DEFAULT NULL,
  `harga_intensive` decimal(15,2) DEFAULT NULL,
  `harga_private` decimal(15,2) DEFAULT NULL,
  `deskripsi_a` text DEFAULT NULL COMMENT 'Deskripsi Paket A',
  `deskripsi_b` text DEFAULT NULL COMMENT 'Deskripsi Paket B',
  `deskripsi_c` text DEFAULT NULL COMMENT 'Deskripsi Paket C',
  `id_pemilik` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `paket_kursus`
--

INSERT INTO `paket_kursus` (`id_paket`, `id_kursus`, `nama_paket`, `paket_a`, `paket_b`, `paket_c`, `jadwal_pelatihan`, `total_pertemuan`, `durasi_per_pertemuan_jam`, `harga_reguler`, `harga_intensive`, `harga_private`, `deskripsi_a`, `deskripsi_b`, `deskripsi_c`, `id_pemilik`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 15, 'Materi Aplikasi Perkantoran - 25 Pertemuan', 'Kelas Reguler', 'Kelas Intensive', 'Kelas Private', '08.00 - 12.00', 25, 2, 700000.00, 900000.00, 1600000.00, 'Minimal 5 Peserta+ /kelas\nDurasi Pertemuan 25x (Durasi 2 jam/pertemuan)\nMateri (Microsoft Word, Excel & PowerPoint)\nPraktik 70% Materi 30%\nFree Modul Pembelajaran\nFree Toolkits\nJadwal Kursus (menyesuaikan lembaga)', 'Minimal 2 Peserta Max 4 Peserta /kelas\nDurasi Pertemuan 25x (Durasi 2 jam/pertemuan)\nMateri (Microsoft Word, Excel & PowerPoint)\nPraktik 70% Materi 30%\nFree Modul Pembelajaran\nFree Toolkits\nJadwal Kursus (menyesuaikan lembaga)', '1 Mentor 1 Peserta\nDurasi Pertemuan 25x (Durasi 2 jam/pertemuan)\nMateri (Microsoft Word, Excel & PowerPoint)\nPraktik 70% Materi 30%\nFree Modul Pembelajaran\nFree Toolkits\nJadwal Kursus (menyesuaikan lembaga)', 0, '2026-02-20 04:29:43', '2026-03-09 11:56:44', NULL),
(3, 16, 'Materi Desain Grafis - 25 Pertemuan', 'Kelas Reguler', 'Kelas Intensive', 'Kelas Private', '08.00 - 12.00', 25, 2, 800000.00, 1000000.00, 1600000.00, 'Minimal 5 Peserta+ /kelas\nDurasi Pertemuan 25x (@2jam/pertemuan)\nMateri (Coreldraw & Adobe Photoshop)\nPraktik 70% Materi 30%\nFree Modul Pembelajaran\nFree Toolkits\nJadwal Kursus (menyesuaikan lembaga)', 'Peserta /kelas\nDurasi Pertemuan 25x (@2jam/pertemuan)\nMateri (Coreldraw & Adobe Photoshop)\nPraktik 70% Materi 30%\nFree Modul Pembelajaran\nFree Toolkits\nJadwal Kursus (menyesuaikan lembaga)', '1 Mentor 1 Peserta\nDurasi Pertemuan 25x (@2jam/pertemuan)\nMateri (Coreldraw & Adobe Photoshop)\nPraktik 70% Materi 30%\nFree Modul Pembelajaran\nFree Toolkits\nJadwal Kursus (menyesuaikan lembaga)', 0, '2026-02-20 02:08:03', '2026-03-09 11:56:41', NULL),
(4, 17, 'Materi Computer Basic Skill - 25 Pertemuan', 'Kelas Reguler', 'Kelas Intensive', 'Kelas Private', '08.00 - 12.00', 25, 2, 250000.00, 300000.00, 600000.00, 'Minimal 5 Peserta+ /kelas\nDurasi Pertemuan 25x (@2jam/pertemuan)\nMateri Computer Bacis Skill\nPraktik 70% Materi 30%\nFree Modul Pembelajaran\nFree Toolkits\nJadwal Kursus (menyesuaikan lembaga)', 'Minimal 2 Peserta Max 4 Peserta /kelas\nDurasi Pertemuan 25x (@2jam/pertemuan)\nMateri Computer Bacis Skill\nPraktik 70% Materi 30%\nFree Modul Pembelajaran\nFree Toolkits\nJadwal Kursus (menyesuaikan lembaga)', '1 Mentor 1 Peserta\nDurasi Pertemuan 25x (@2jam/pertemuan)\nMateri Computer Bacis Skill\nPraktik 70% Materi 30%\nFree Modul Pembelajaran\nFree Toolkits\nJadwal Kursus (menyesuaikan lembaga)', 0, '2026-02-20 02:10:52', '2026-03-09 11:56:38', NULL),
(5, 18, 'Materi Accounting - 25 Pertemuan', 'Kelas Reguler', 'Kelas Intensive', 'Kelas Private', '08.00 - 12.00', 25, 2, 600000.00, 700000.00, 1200000.00, 'Untitled-1\nMinimal 5 Peserta+ /kelas\nUntitled-1\nDurasi Pertemuan 12x (@2jam/pertemuan)\nUntitled-1\nMateri Accounting\nUntitled-1\nPraktik 70% Materi 30%\nUntitled-1\nFree Modul Pembelajaran\nUntitled-1\nFree Toolkits\nUntitled-1\nJadwal Kursus (menyesuaikan lembaga)', 'Minimal 2 Peserta Max 4 Peserta /kelas\nUntitled-1\nDurasi Pertemuan 12x (@2jam/pertemuan)\nUntitled-1\nMateri Accounting\nUntitled-1\nPraktik 70% Materi 30%\nUntitled-1\nFree Modul Pembelajaran\nUntitled-1\nFree Toolkits\nUntitled-1\nJadwal Kursus (menyesuaikan lembaga)', 'Untitled-1\n1 Mentor 1 Peserta\nUntitled-1\nDurasi Pertemuan 12x (@2jam/pertemuan)\nUntitled-1\nMateri Accounting\nUntitled-1\nPraktik 70% Materi 30%\nUntitled-1\nFree Modul Pembelajaran\nUntitled-1\nFree Toolkits\nUntitled-1\nJadwal Kursus (menyesuaikan lembaga)', 0, '2026-02-20 02:12:48', '2026-03-09 11:56:35', NULL),
(6, 19, 'Materi Web Progaming - 25 Pertemuan', 'Kelas Reguler', 'Kelas Intensive', 'Kelas Private', '08.00 - 12.00', 25, 2, 1300000.00, 1400000.00, 2400000.00, 'Minimal 5 Peserta+ /kelas\nDurasi Pertemuan 25x (@2jam/pertemuan)\nMateri Web Progaming\nPraktik 70% Materi 30%\nFree Modul Pembelajaran\nFree Toolkits\nJadwal Kursus (menyesuaikan lembaga)', 'Minimal 2 Peserta Max 4 Peserta /kelas\nDurasi Pertemuan 25x (@2jam/pertemuan)\nMateri Web Progaming\nPraktik 70% Materi 30%\nFree Modul Pembelajaran\nFree Toolkits\nJadwal Kursus (menyesuaikan lembaga)', '1 Mentor 1 Peserta\nDurasi Pertemuan 25x (@2jam/pertemuan)\nMateri Web Progaming\nPraktik 70% Materi 30%\nFree Modul Pembelajaran\nFree Toolkits\nJadwal Kursus (menyesuaikan lembaga)', 0, '2026-02-20 02:14:46', '2026-03-09 11:56:31', NULL),
(7, 20, 'Materi Desain AutoCad - 25 Pertemuan', 'Kelas Reguler', 'Kelas Intensive', 'Kelas Private', '08.00 - 12.00', 25, 2, 1300000.00, 1600000.00, 2200000.00, 'Minimal 5 Peserta+ /kelas\nDurasi Pertemuan 25x (@2jam/pertemuan)\nMateri AutoCAD\nPraktik 70% Materi 30%\nFree Modul Pembelajaran\nFree Toolkits\nJadwal Kursus (menyesuaikan lembaga)', 'Minimal 2 Peserta Max 4 Peserta /kelas\nDurasi Pertemuan 25x (@2jam/pertemuan)\nMateri AutoCAD\nPraktik 70% Materi 30%\nFree Modul Pembelajaran\nFree Toolkits\nJadwal Kursus', '1 Mentor 1 Peserta\nDurasi Pertemuan 25x (@2jam/pertemuan)\nMateri AutoCAD\nPraktik 70% Materi 30%\nFree Modul Pembelajaran\nFree Toolkits\nJadwal Kursus (menyesuaikan lembaga)', 0, '2026-02-20 02:16:33', '2026-03-09 11:56:28', NULL),
(8, 21, 'Materi Video Editing - 25 Pertemuan', 'Kelas Reguler', 'Kelas Intensive', 'Kelas Private', '08.00 - 12.00', 25, 2, 1300000.00, 1700000.00, 2000000.00, 'Minimal 5 Peserta+ /kelas\nDurasi Pertemuan 25x (@2jam/pertemuan)\nMateri (Adobe Premiere)\nPraktik 70% Materi 30%\nFree Modul Pembelajaran\nFree Toolkits\nJadwal Kursus (menyesuaikan lembaga)', 'Minimal 2 Peserta Max 4 Peserta /kelas\nDurasi Pertemuan 25x (@2jam/pertemuan)\nMateri (Adobe Premiere)\nPraktik 70% Materi 30%\nFree Modul Pembelajaran\nFree Toolkits\nJadwal Kursus (menyesuaikan lembaga)', '1 Mentor 1 Peserta\nDurasi Pertemuan 25x (@2jam/pertemuan)\nMateri (Adobe Premiere)\nPraktik 70% Materi 30%\nFree Modul Pembelajaran\nFree Toolkits\nJadwal Kursus (menyesuaikan lembaga)', 0, '2026-02-20 02:17:43', '2026-03-09 11:56:26', NULL),
(9, 22, 'Materi Digital Marketing - 25 Pertemuan', 'Kelas Reguler', 'Kelas Intensive', 'Kelas Private', '08.00 - 12.00', 25, 2, 900000.00, 1100000.00, 1600000.00, 'Minimal 5 Peserta+ /kelas\nDurasi Pertemuan 25x (@2jam/pertemuan)\nMateri Digital Marketing\nPraktik 70% Materi 30%\nFree Modul Pembelajaran\nFree Toolkits\nJadwal Kursus (menyesuaikan lembaga)', 'Minimal 2 Peserta Max 4 Peserta /kelas\nDurasi Pertemuan 25x (@2jam/pertemuan)\nMateri Digital Marketing\nPraktik 70% Materi 30%\nFree Modul Pembelajaran\nFree Toolkits\nJadwal Kursus (menyesuaikan lembaga)', '1 Mentor 1 Peserta\nDurasi Pertemuan 25x (@2jam/pertemuan)\nMateri Digital Marketing\nPraktik 70% Materi 30%\nFree Modul Pembelajaran\nFree Toolkits\nJadwal Kursus (menyesuaikan lembaga)', 0, '2026-02-20 02:18:48', '2026-03-09 11:56:17', NULL),
(10, 23, 'Menyusun surat dengan MS Word untuk sekretaris - 25 Pertemuan', 'Kelas Reguler', 'Kelas Intensive', 'Kelas Private', '08.00 -12.00', 25, 2, 790000.00, 0.00, 0.00, 'Minimal 5 Peserta+ /kelas\nDurasi Pertemuan 25x (@2jam/pertemuan)\nMateri Digital Marketing\nPraktik 70% Materi 30%\nFree Modul Pembelajaran\nFree Toolkits', 'Minimal 2 Peserta Max 4 Peserta /kelas\nDurasi Pertemuan 25x (@2jam/pertemuan)\nMateri Digital Marketing\nPraktik 70% Materi 30%\nFree Modul Pembelajaran\nFree Toolkits\nJadwal Kursus', '1 Mentor 1 Peserta\nDurasi Pertemuan 25x (@2jam/pertemuan)\nMateri Digital Marketing\nPraktik 70% Materi 30%\nFree Modul Pembelajaran\nFree Toolkits', 0, '2026-02-20 02:21:03', '2026-03-09 10:47:45', NULL),
(11, 24, 'Rahasia surat massal & Daftar isi otomatis - 25 Pertemuan', 'Kelas Reguler', 'Kelas Intensive', 'Kelas Private', '08.00 -12.00', 25, 2, 780000.00, 0.00, 0.00, 'Minimal 5 Peserta+ /kelas\nDurasi Pertemuan 25x (@2jam/pertemuan)\nMateri Digital Marketing\nPraktik 70% Materi 30%\nFree Modul Pembelajaran\nFree Toolkits', 'Minimal 2 Peserta Max 4 Peserta /kelas\nDurasi Pertemuan 25x (@2jam/pertemuan)\nMateri Digital Marketing\nPraktik 70% Materi 30%\nFree Modul Pembelajaran\nFree Toolkits', '1 Mentor 1 Peserta\nDurasi Pertemuan 25x (@2jam/pertemuan)\nMateri Digital Marketing\nPraktik 70% Materi 30%\nFree Modul Pembelajaran\nFree Toolkits', 0, '2026-02-20 02:21:57', '2026-03-09 10:46:00', NULL),
(12, 25, 'Memanfaatkan AI untuk pembuatan presentasi - 25 Pertemuan', 'Kelas Reguler', 'Kelas Intensive', 'Kelas Private', '08.00 - 12.00', 25, 2, 650000.00, 0.00, 0.00, 'Minimal 5 Peserta+ /kelas\nDurasi Pertemuan 25x (@2jam/pertemuan)\nMateri Digital Marketing\nPraktik 70% Materi 30%\nFree Modul Pembelajaran\nFree Toolkits', 'Minimal 2 Peserta Max 4 Peserta /kelas\nDurasi Pertemuan 25x (@2jam/pertemuan)\nMateri Digital Marketing\nPraktik 70% Materi 30%\nFree Modul Pembelajaran\nFree Toolkits', '1 Mentor 1 Peserta\nDurasi Pertemuan 25x (@2jam/pertemuan)\nMateri Digital Marketing\nPraktik 70% Materi 30%\nFree Modul Pembelajaran\nFree Toolkits', 0, '2026-02-20 02:22:33', '2026-03-09 11:56:03', NULL),
(13, 28, 'DKV (DESAIN KOMUNIKASI VISUAL) - 144 Pertemuan', 'Kelas Reguler', 'Kelas Intensive', 'Kelas Private', '08.00 - 12.00', 144, 6, 5600000.00, 0.00, 0.00, 'Program profesional 1 tahun', '0', '0', 0, '2026-02-23 21:03:59', '2026-03-09 10:52:24', NULL),
(15, 30, 'Computer For Kid - 25 Pertemuan', 'Reguler', 'null', 'null', '08.00 - 12.00', 25, 2, 670000.00, 0.00, 0.00, 'paket cfk', '0', '0', 0, '2026-02-24 18:26:44', '2026-03-09 11:55:59', NULL),
(16, 29, 'Sekretaris & Administrasi Perkantoran - 144 Pertemuan', 'Reguler', 'null', 'mull', '08.00 -12.00', 144, 4, 4500000.00, 0.00, 0.00, 'Program profesional 1 tahun', '0', '0', 0, '2026-02-24 18:46:51', '2026-03-09 10:49:24', NULL),
(18, 33, 'Materi Aplikasi Perkantoran - 25 Pertemuan', 'Kelas Reguler', 'Kelas Intensive', 'Kelas Private', '08.00 - 12.00', 25, 2, 700000.00, 900000.00, 1600000.00, 'Minimal 5 Peserta+ /kelas\nDurasi Pertemuan 25x (Durasi 2 jam/pertemuan)\nMateri (Microsoft Word, Excel & PowerPoint)\nPraktik 70% Materi 30%\nFree Modul Pembelajaran\nFree Toolkits\nJadwal Kursus (menyesuaikan lembaga)', 'Minimal 2 Peserta Max 4 Peserta /kelas\nDurasi Pertemuan 25x (Durasi 2 jam/pertemuan)\nMateri (Microsoft Word, Excel & PowerPoint)\nPraktik 70% Materi 30%\nFree Modul Pembelajaran\nFree Toolkits\nJadwal Kursus (menyesuaikan lembaga)', '1 Mentor 1 Peserta\nDurasi Pertemuan 25x (Durasi 2 jam/pertemuan)\nMateri (Microsoft Word, Excel & PowerPoint)\nPraktik 70% Materi 30%\nFree Modul Pembelajaran\nFree Toolkits\nJadwal Kursus (menyesuaikan lembaga)', 0, '2026-03-16 21:32:04', NULL, NULL),
(19, 34, 'Materi Desain Grafis - 25 Pertemuan', 'Kelas Reguler', 'Kelas Intensive', 'Kelas Private', '08.00 - 12.00', 25, 2, 800000.00, 1000000.00, 1600000.00, 'Minimal 5 Peserta+ /kelas\nDurasi Pertemuan 25x (@2jam/pertemuan)\nMateri (Coreldraw & Adobe Photoshop)\nPraktik 70% Materi 30%\nFree Modul Pembelajaran\nFree Toolkits\nJadwal Kursus (menyesuaikan lembaga)', 'Peserta /kelas\nDurasi Pertemuan 25x (@2jam/pertemuan)\nMateri (Coreldraw & Adobe Photoshop)\nPraktik 70% Materi 30%\nFree Modul Pembelajaran\nFree Toolkits\nJadwal Kursus (menyesuaikan lembaga)', '1 Mentor 1 Peserta\nDurasi Pertemuan 25x (@2jam/pertemuan)\nMateri (Coreldraw & Adobe Photoshop)\nPraktik 70% Materi 30%\nFree Modul Pembelajaran\nFree Toolkits\nJadwal Kursus (menyesuaikan lembaga)', 0, '2026-03-16 21:32:04', NULL, NULL),
(20, 35, 'Materi Computer Basic Skill - 25 Pertemuan', 'Kelas Reguler', 'Kelas Intensive', 'Kelas Private', '08.00 - 12.00', 25, 2, 250000.00, 300000.00, 600000.00, 'Minimal 5 Peserta+ /kelas\nDurasi Pertemuan 25x (@2jam/pertemuan)\nMateri Computer Basic Skill\nPraktik 70% Materi 30%\nFree Modul Pembelajaran\nFree Toolkits\nJadwal Kursus (menyesuaikan lembaga)', 'Minimal 2 Peserta Max 4 Peserta /kelas\nDurasi Pertemuan 25x (@2jam/pertemuan)\nMateri Computer Basic Skill\nPraktik 70% Materi 30%\nFree Modul Pembelajaran\nFree Toolkits\nJadwal Kursus (menyesuaikan lembaga)', '1 Mentor 1 Peserta\nDurasi Pertemuan 25x (@2jam/pertemuan)\nMateri Computer Basic Skill\nPraktik 70% Materi 30%\nFree Modul Pembelajaran\nFree Toolkits\nJadwal Kursus (menyesuaikan lembaga)', 0, '2026-03-16 21:32:04', NULL, NULL),
(21, 36, 'Materi Accounting - 25 Pertemuan', 'Kelas Reguler', 'Kelas Intensive', 'Kelas Private', '08.00 - 12.00', 25, 2, 600000.00, 700000.00, 1200000.00, 'Minimal 5 Peserta+ /kelas\nDurasi Pertemuan 25x (@2jam/pertemuan)\nMateri Accounting\nPraktik 70% Materi 30%\nFree Modul Pembelajaran\nFree Toolkits\nJadwal Kursus (menyesuaikan lembaga)', 'Minimal 2 Peserta Max 4 Peserta /kelas\nDurasi Pertemuan 25x (@2jam/pertemuan)\nMateri Accounting\nPraktik 70% Materi 30%\nFree Modul Pembelajaran\nFree Toolkits\nJadwal Kursus (menyesuaikan lembaga)', '1 Mentor 1 Peserta\nDurasi Pertemuan 25x (@2jam/pertemuan)\nMateri Accounting\nPraktik 70% Materi 30%\nFree Modul Pembelajaran\nFree Toolkits\nJadwal Kursus (menyesuaikan lembaga)', 0, '2026-03-16 21:32:04', NULL, NULL),
(22, 37, 'Materi Web Programming - 25 Pertemuan', 'Kelas Reguler', 'Kelas Intensive', 'Kelas Private', '08.00 - 12.00', 25, 2, 1300000.00, 1400000.00, 2400000.00, 'Minimal 5 Peserta+ /kelas\nDurasi Pertemuan 25x (@2jam/pertemuan)\nMateri Web Programming\nPraktik 70% Materi 30%\nFree Modul Pembelajaran\nFree Toolkits\nJadwal Kursus (menyesuaikan lembaga)', 'Minimal 2 Peserta Max 4 Peserta /kelas\nDurasi Pertemuan 25x (@2jam/pertemuan)\nMateri Web Programming\nPraktik 70% Materi 30%\nFree Modul Pembelajaran\nFree Toolkits\nJadwal Kursus (menyesuaikan lembaga)', '1 Mentor 1 Peserta\nDurasi Pertemuan 25x (@2jam/pertemuan)\nMateri Web Programming\nPraktik 70% Materi 30%\nFree Modul Pembelajaran\nFree Toolkits\nJadwal Kursus (menyesuaikan lembaga)', 0, '2026-03-16 21:32:04', NULL, NULL),
(23, 38, 'Materi Desain AutoCad - 25 Pertemuan', 'Kelas Reguler', 'Kelas Intensive', 'Kelas Private', '08.00 - 12.00', 25, 2, 1300000.00, 1600000.00, 2200000.00, 'Minimal 5 Peserta+ /kelas\nDurasi Pertemuan 25x (@2jam/pertemuan)\nMateri AutoCAD\nPraktik 70% Materi 30%\nFree Modul Pembelajaran\nFree Toolkits\nJadwal Kursus (menyesuaikan lembaga)', 'Minimal 2 Peserta Max 4 Peserta /kelas\nDurasi Pertemuan 25x (@2jam/pertemuan)\nMateri AutoCAD\nPraktik 70% Materi 30%\nFree Modul Pembelajaran\nFree Toolkits\nJadwal Kursus', '1 Mentor 1 Peserta\nDurasi Pertemuan 25x (@2jam/pertemuan)\nMateri AutoCAD\nPraktik 70% Materi 30%\nFree Modul Pembelajaran\nFree Toolkits\nJadwal Kursus (menyesuaikan lembaga)', 0, '2026-03-16 21:32:04', NULL, NULL),
(24, 39, 'Materi Video Editing - 25 Pertemuan', 'Kelas Reguler', 'Kelas Intensive', 'Kelas Private', '08.00 - 12.00', 25, 2, 1300000.00, 1700000.00, 2000000.00, 'Minimal 5 Peserta+ /kelas\nDurasi Pertemuan 25x (@2jam/pertemuan)\nMateri (Adobe Premiere)\nPraktik 70% Materi 30%\nFree Modul Pembelajaran\nFree Toolkits\nJadwal Kursus (menyesuaikan lembaga)', 'Minimal 2 Peserta Max 4 Peserta /kelas\nDurasi Pertemuan 25x (@2jam/pertemuan)\nMateri (Adobe Premiere)\nPraktik 70% Materi 30%\nFree Modul Pembelajaran\nFree Toolkits\nJadwal Kursus (menyesuaikan lembaga)', '1 Mentor 1 Peserta\nDurasi Pertemuan 25x (@2jam/pertemuan)\nMateri (Adobe Premiere)\nPraktik 70% Materi 30%\nFree Modul Pembelajaran\nFree Toolkits\nJadwal Kursus (menyesuaikan lembaga)', 0, '2026-03-16 21:32:04', NULL, NULL),
(25, 40, 'Materi Digital Marketing - 25 Pertemuan', 'Kelas Reguler', 'Kelas Intensive', 'Kelas Private', '08.00 - 12.00', 25, 2, 900000.00, 1100000.00, 1600000.00, 'Minimal 5 Peserta+ /kelas\nDurasi Pertemuan 25x (@2jam/pertemuan)\nMateri Digital Marketing\nPraktik 70% Materi 30%\nFree Modul Pembelajaran\nFree Toolkits\nJadwal Kursus (menyesuaikan lembaga)', 'Minimal 2 Peserta Max 4 Peserta /kelas\nDurasi Pertemuan 25x (@2jam/pertemuan)\nMateri Digital Marketing\nPraktik 70% Materi 30%\nFree Modul Pembelajaran\nFree Toolkits\nJadwal Kursus (menyesuaikan lembaga)', '1 Mentor 1 Peserta\nDurasi Pertemuan 25x (@2jam/pertemuan)\nMateri Digital Marketing\nPraktik 70% Materi 30%\nFree Modul Pembelajaran\nFree Toolkits\nJadwal Kursus (menyesuaikan lembaga)', 0, '2026-03-16 21:32:04', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int(11) NOT NULL,
  `kode_invoice` varchar(50) DEFAULT NULL,
  `kode_transaksi` varchar(50) NOT NULL,
  `jumlah_bayar` decimal(12,2) NOT NULL,
  `metode_pembayaran` enum('transfer_bank','ewallet','qris','tunai') NOT NULL,
  `bank_tujuan` varchar(50) DEFAULT '',
  `nama_pengirim` varchar(100) DEFAULT '',
  `bukti_bayar` varchar(255) DEFAULT '',
  `status_pembayaran` enum('pending','processing','success','failed','refunded') DEFAULT 'pending',
  `tanggal_transaksi` datetime DEFAULT current_timestamp(),
  `tanggal_konfirmasi` datetime DEFAULT NULL,
  `dikonfirmasi_oleh` int(11) DEFAULT 0,
  `alasan_penolakan` text DEFAULT NULL,
  `refund_amount` decimal(12,2) DEFAULT 0.00,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id_pembayaran`, `kode_invoice`, `kode_transaksi`, `jumlah_bayar`, `metode_pembayaran`, `bank_tujuan`, `nama_pengirim`, `bukti_bayar`, `status_pembayaran`, `tanggal_transaksi`, `tanggal_konfirmasi`, `dikonfirmasi_oleh`, `alasan_penolakan`, `refund_amount`, `created_at`, `updated_at`) VALUES
(15, 'INV-20260311-9901', 'TRX-20260311-0001', 780000.00, 'transfer_bank', 'BCA', 'Haidar Hussein', '1773179102_1773179102_bc70741398e0e018932e.jpg', 'success', '2026-03-11 04:45:02', '2026-03-11 05:05:19', 9, NULL, 0.00, '2026-03-11 04:45:02', '2026-03-11 05:05:19');

-- --------------------------------------------------------

--
-- Table structure for table `pendaftaran`
--

CREATE TABLE `pendaftaran` (
  `id_pendaftaran` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `kode_invoice` varchar(50) DEFAULT NULL,
  `id_kursus` int(11) NOT NULL,
  `nama_paket` varchar(100) NOT NULL,
  `harga_kursus` decimal(10,2) DEFAULT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'terdaftar',
  `tanggal_pendaftaran` datetime DEFAULT current_timestamp(),
  `tanggal_konfirmasi` datetime DEFAULT NULL,
  `tanggal_aktif` datetime DEFAULT NULL,
  `progress` float DEFAULT 0 COMMENT 'Persentase penyelesaian (0-100)',
  `tanggal_selesai` datetime DEFAULT NULL COMMENT 'Tanggal kursus selesai',
  `last_accessed` datetime DEFAULT NULL COMMENT 'Waktu terakhir akses materi',
  `nilai_akhir` decimal(5,2) DEFAULT NULL COMMENT 'Nilai evaluasi akhir',
  `sertifikat_dikirim` tinyint(1) DEFAULT 0 COMMENT 'Status pengiriman sertifikat',
  `tanggal_sertifikat` datetime DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `nama_lengkap` varchar(100) DEFAULT NULL,
  `tempat_lahir` varchar(50) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` enum('Laki - laki','Perempuan') DEFAULT NULL,
  `agama` varchar(20) DEFAULT NULL,
  `no_telepon` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `foto_profil` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pendaftaran`
--

INSERT INTO `pendaftaran` (`id_pendaftaran`, `id_siswa`, `kode_invoice`, `id_kursus`, `nama_paket`, `harga_kursus`, `status`, `tanggal_pendaftaran`, `tanggal_konfirmasi`, `tanggal_aktif`, `progress`, `tanggal_selesai`, `last_accessed`, `nilai_akhir`, `sertifikat_dikirim`, `tanggal_sertifikat`, `email`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `agama`, `no_telepon`, `alamat`, `foto_profil`) VALUES
(51, 28, 'INV-20260311-9901', 24, 'Rahasia surat massal & Daftar isi otomatis - 25 Pertemuan', 780000.00, 'selesai', '2026-03-11 04:10:26', '2026-03-15 04:20:50', NULL, 33, '2026-03-14 11:30:17', '2026-03-16 16:26:24', 80.00, 1, '2026-03-14 12:57:19', 'haidar.handanovic@gmail.com', 'Haidar Hussein', 'Pekalongan', '2026-03-10', 'Perempuan', 'Kristen', '085213035225', 'Jln.Raya Tanjung Tirto Kabupaten Pekalongan', 'foto_profil_20260310220449_7022.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `pengumpulan_tugas`
--

CREATE TABLE `pengumpulan_tugas` (
  `id_kumpul` int(11) NOT NULL,
  `id_tugas` int(11) NOT NULL,
  `id_karyawan` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `file_tugas` varchar(255) NOT NULL,
  `nama_file_asli` varchar(255) DEFAULT '',
  `ukuran_file_kb` int(11) DEFAULT 0,
  `catatan_siswa` text DEFAULT NULL,
  `nilai` decimal(5,2) DEFAULT 0.00,
  `catatan_pengajar` text DEFAULT NULL,
  `status_penilaian` enum('belum_dinilai','sudah_dinilai','revisi','lulus') DEFAULT 'belum_dinilai',
  `tanggal_kirim` datetime DEFAULT current_timestamp(),
  `tanggal_penilaian` datetime DEFAULT NULL,
  `dinilai_oleh` int(11) DEFAULT 0,
  `id_pemilik` int(11) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengumpulan_tugas`
--

INSERT INTO `pengumpulan_tugas` (`id_kumpul`, `id_tugas`, `id_karyawan`, `id_siswa`, `file_tugas`, `nama_file_asli`, `ukuran_file_kb`, `catatan_siswa`, `nilai`, `catatan_pengajar`, `status_penilaian`, `tanggal_kirim`, `tanggal_penilaian`, `dinilai_oleh`, `id_pemilik`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 0, 1, 'uploads/tugas/2026/02/tugas_budi_word.pdf', 'Surat_Resmi_Budi.pdf', 245, 'Berikut tugas dokumen Word saya kak, mohon dikoreksi 🙏', 95.00, 'Format sudah benar, table rapi, hanya perhatikan margin halaman', 'lulus', '2026-02-20 14:30:00', '2026-02-21 09:15:00', 8, 0, '2026-02-27 14:50:41', '2026-02-27 14:50:41', NULL),
(2, 1, 0, 2, 'uploads/tugas/2026/02/tugas_siti_word.docx', 'Tugas_Word_Siti.docx', 189, 'Tugas Word modul 1, ada yang kurang kak?', 75.00, 'Formatting sudah bagus, tapi table belum rata. Silakan revisi bagian table lalu submit ulang', 'revisi', '2026-02-21 10:00:00', '2026-02-22 08:30:00', 8, 0, '2026-02-27 14:50:41', '2026-02-27 14:50:41', NULL),
(3, 2, 0, 1, 'uploads/tugas/2026/02/tugas_budi_excel.xlsx', 'Latihan_Formula_Budi.xlsx', 512, 'Tugas Excel dengan 5 formula: SUM, AVERAGE, IF, VLOOKUP, COUNT', 100.00, 'Sempurna! Semua formula berfungsi dengan benar, chart juga rapi 🎉', 'lulus', '2026-02-25 16:45:00', '2026-02-26 10:00:00', 8, 0, '2026-02-27 14:50:41', '2026-02-27 14:50:41', NULL),
(4, 2, 0, 2, 'uploads/tugas/2026/02/tugas_siti_excel.xlsx', 'Formula_Excel_Siti.xlsx', 387, 'Berikut tugas Excel saya kak, mohon penilaiannya', 0.00, NULL, 'belum_dinilai', '2026-02-27 11:20:00', NULL, 0, 0, '2026-02-27 14:50:41', '2026-02-27 14:50:41', NULL),
(5, 1, 0, 2, 'uploads/tugas/2026/02/tugas_siti_word_revisi.docx', 'Tugas_Word_Siti_Revisi.docx', 195, 'Sudah saya perbaiki bagian table-nya kak, mohon dicek lagi', 90.00, 'Sudah bagus! Table sudah rata, formatting konsisten. Lulus ✅', 'lulus', '2026-02-23 15:00:00', '2026-02-24 09:00:00', 8, 0, '2026-02-27 14:50:41', '2026-02-27 14:50:41', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `postingan`
--

CREATE TABLE `postingan` (
  `id_postingan` int(11) NOT NULL,
  `judul_postingan` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `konten` text NOT NULL,
  `excerpt` text DEFAULT NULL,
  `gambar_postingan` varchar(255) DEFAULT NULL,
  `kategori` varchar(100) NOT NULL DEFAULT 'Umum',
  `status` enum('draft','published','archived') NOT NULL DEFAULT 'draft',
  `penulis` varchar(100) NOT NULL DEFAULT 'Admin INASABA',
  `meta_description` text DEFAULT NULL,
  `meta_keywords` varchar(255) DEFAULT NULL,
  `views` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `postingan`
--

INSERT INTO `postingan` (`id_postingan`, `judul_postingan`, `slug`, `konten`, `excerpt`, `gambar_postingan`, `kategori`, `status`, `penulis`, `meta_description`, `meta_keywords`, `views`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Tips Sukses Karir di Bidang IT', 'tips-sukses-karir-di-bidang-it', '<h2>Tips Sukses Karir di Bidang IT</h2><p>Pelajari strategi untuk mengembangkan karir Anda di industri teknologi...</p>', 'Pelajari strategi untuk mengembangkan karir Anda di industri teknologi...', '1773452157_4b79bfc19db3e00dd641.webp', 'Tips Karir', 'published', 'Admin INASABA', 'Tips sukses karir di bidang IT untuk profesional muda', 'tips, karir, IT, teknologi, sukses', 11, '2026-03-11 13:15:32', '2026-03-14 11:16:41', NULL),
(2, '5 Skill Digital yang Wajib Dimiliki', '5-skill-digital-yang-wajib-dimiliki', '<h2>5 Skill Digital yang Wajib Dimiliki</h2><p>Di era digital ini, berikut skill yang harus Anda kuasai...</p>', 'Di era digital ini, berikut skill yang harus Anda kuasai untuk bersaing...', '1773452145_568c9d35a6e73873ab62.webp', 'Teknologi', 'published', 'Admin INASABA', '5 skill digital wajib dimiliki di era modern', 'skill, digital, teknologi, future', 1, '2026-03-11 13:15:32', '2026-03-14 08:35:45', NULL),
(3, 'Cara Belajar Efektif di INASABA', 'cara-belajar-efektif-di-inasaba', '<h2>Cara Belajar Efektif di INASABA</h2><p>Temukan metode pembelajaran terbaik...</p>', 'Temukan metode pembelajaran terbaik untuk memaksimalkan potensi Anda...', '1773452168_39a0a70687a4b18bb611.webp', 'Pendidikan', 'published', 'Admin INASABA', 'Cara belajar efektif di LPK INASABA', 'belajar, efektif, inasaba, pendidikan', 0, '2026-03-11 13:15:32', '2026-03-14 08:36:08', NULL),
(4, 'Testimoni Alumni Sukses', 'testimoni-alumni-sukses', '<h2>Testimoni Alumni Sukses</h2><p>Kisah inspiratif dari alumni INASABA...</p>', 'Kisah inspiratif dari alumni INASABA yang berhasil berkarir...', '1773452303_33a88f9e759ee8d10790.webp', 'Alumni', 'published', 'Admin INASABA', 'Testimoni alumni sukses LPK INASABA', 'alumni, testimoni, sukses, karir', 1, '2026-03-11 13:15:32', '2026-03-14 09:33:23', NULL),
(5, 'Halo', 'halo', 'halo ini adalah contoh konten', 'halo ini adalah contoh konten', '1773452552_3198d106d18b819f5b43.png', 'Umum', 'published', 'Admin INASABA', 'halo-semua', 'halo,konten', 2, '2026-03-14 08:42:32', '2026-03-16 12:35:57', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `profil_lpk`
--

CREATE TABLE `profil_lpk` (
  `id_profil` int(11) NOT NULL,
  `judul_header` varchar(255) NOT NULL,
  `subjudul_header` varchar(255) DEFAULT NULL,
  `video_url` text DEFAULT NULL,
  `video_title` varchar(255) DEFAULT NULL,
  `sejarah_singkat` text DEFAULT NULL,
  `tahun_berdiri` int(4) DEFAULT NULL,
  `tanggal_resmi` date DEFAULT NULL,
  `tanggal_izin` date DEFAULT NULL,
  `status_akreditasi` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `profil_lpk`
--

INSERT INTO `profil_lpk` (`id_profil`, `judul_header`, `subjudul_header`, `video_url`, `video_title`, `sejarah_singkat`, `tahun_berdiri`, `tanggal_resmi`, `tanggal_izin`, `status_akreditasi`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Sejarah LPK INASABA', 'Berikut adalah sejarah berdirinya LPK INASABA', 'https://www.youtube.com/embed/dQw4w9WgXcQ', 'Profil LPK INASABA', 'Cikal bakal LPK INASABA bermula dari pendirian sebuah warnet pada tahun 2000 dengan memiliki peralatan sebanyak: 5 unit komputer. Melihat perkembangan akan warnet dan semakin banyaknya pula permintaan kursus privat pada saat itu, muncul ide untuk membuka kursus kecil-kecilan. Dengan berbekal keberanian, tekad dan keseriusan yang tinggi, maka usaha membesarkan kegiatan kursus ini dilakukan. Sehingga sejak tanggal 1 November 2001 resmi Lembaga Pelatihan Komputer (INASABA) berdiri. Pada tanggal 25 Oktober 2007, LPK INASABA juga telah memiliki ijin operasional dari Disnaker Kota Pekalongan. LPK INASABA kini sudah memiliki sarana dan prasarana yang memadai, serta status Terakreditasi oleh Badan Akreditasi Nasional.', 2000, '2001-11-01', '2007-10-25', 'Terakreditasi', '2026-03-17 02:14:49', '2026-03-17 02:14:49', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `program_kursus`
--

CREATE TABLE `program_kursus` (
  `id_program` int(11) NOT NULL,
  `nama_program` varchar(150) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `id_pemilik` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `program_kursus`
--

INSERT INTO `program_kursus` (`id_program`, `nama_program`, `deskripsi`, `id_pemilik`) VALUES
(2, 'Kelas Online', 'Kelas untuk calon siswa yang tidak memiliki banyak waktu untuk datang ke kursus karena kelas ini dapat diakses dimana saja dan kapan saja', 0),
(3, 'Kelas Offline', 'Kelas untuk calon siswa yang memliki waktu untuk datang ke kursus dimana jadwal, pengajar dan kelas ditentukan INASABA', 0),
(4, 'Program Profesi 1 Tahun', 'Program untuk kalangan umum yang ingin menambah atau meningkatan pengetahuan dan pengalaman yang dilaksanaka 1 tahun', 0),
(5, 'Computer For Kids', 'Program untuk untuk anak anak yang berminat pada bidang komputer ', 0),
(6, 'Program kursus singkat', 'Program untuk kalangan umum yang dilaksanakan kurang dari 1 tahun', 0);

-- --------------------------------------------------------

--
-- Table structure for table `progres_materi`
--

CREATE TABLE `progres_materi` (
  `id_progres` int(11) NOT NULL,
  `id_pendaftaran` int(11) NOT NULL,
  `id_materi` int(11) NOT NULL,
  `last_position` int(11) DEFAULT 0,
  `is_completed` tinyint(4) DEFAULT 0,
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `progres_materi`
--

INSERT INTO `progres_materi` (`id_progres`, `id_pendaftaran`, `id_materi`, `last_position`, `is_completed`, `updated_at`) VALUES
(1, 51, 14, 6, 1, '2026-03-13 15:18:11'),
(2, 51, 15, 0, 1, '2026-03-13 15:18:24'),
(3, 51, 16, 0, 1, '2026-03-13 16:23:03'),
(4, 51, 44, 2, 1, '2026-03-13 15:30:07'),
(5, 51, 45, 1, 1, '2026-03-13 15:30:26'),
(6, 51, 46, 2, 1, '2026-03-14 11:30:17'),
(7, 51, 107, 100, 1, '2026-03-13 05:11:39'),
(8, 51, 108, 100, 1, '2026-03-13 05:11:39'),
(9, 51, 109, 0, 1, '2026-03-13 15:50:38'),
(10, 51, 110, 100, 1, '2026-03-13 05:11:39'),
(11, 51, 111, 100, 1, '2026-03-13 05:11:39'),
(12, 51, 112, 0, 1, '2026-03-13 18:08:07'),
(13, 51, 113, 0, 1, '2026-03-13 15:51:55'),
(14, 51, 114, 100, 1, '2026-03-13 05:11:39'),
(15, 51, 115, 0, 1, '2026-03-13 15:50:19');

-- --------------------------------------------------------

--
-- Table structure for table `quiz`
--

CREATE TABLE `quiz` (
  `id_quiz` int(11) NOT NULL,
  `id_kursus` int(11) NOT NULL,
  `id_modul` int(11) DEFAULT 0 COMMENT 'Opsional: quiz per modul',
  `judul_quiz` varchar(255) NOT NULL,
  `slug_quiz` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `durasi_menit` int(11) NOT NULL DEFAULT 60 COMMENT 'Durasi pengerjaan dalam menit',
  `passing_grade` int(11) NOT NULL DEFAULT 70 COMMENT 'Nilai minimal untuk lulus',
  `max_attempt` int(11) NOT NULL DEFAULT 3 COMMENT 'Maksimal percobaan',
  `soal_json` longtext NOT NULL COMMENT 'JSON array of questions',
  `status` enum('draft','aktif','nonaktif') NOT NULL DEFAULT 'draft',
  `tanggal_mulai` datetime DEFAULT NULL COMMENT 'Waktu mulai quiz aktif',
  `tanggal_selesai` datetime DEFAULT NULL COMMENT 'Waktu selesai quiz aktif',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Tabel Quiz/Ujian';

--
-- Dumping data for table `quiz`
--

INSERT INTO `quiz` (`id_quiz`, `id_kursus`, `id_modul`, `judul_quiz`, `slug_quiz`, `deskripsi`, `durasi_menit`, `passing_grade`, `max_attempt`, `soal_json`, `status`, `tanggal_mulai`, `tanggal_selesai`, `created_at`, `updated_at`) VALUES
(1, 15, 1, 'Quiz Microsoft Word Dasar', 'quiz-microsoft-word-dasar', 'Quiz untuk menguji pemahaman dasar Microsoft Word', 30, 70, 3, '[{\"pertanyaan\": \"Apa fungsi utama Microsoft Word?\", \"pilihan\": [\"A) Spreadsheet\", \"B) Presentasi\", \"C) Pengolah kata\", \"D) Database\"], \"jawaban_benar\": \"C\", \"bobot\": 1}, {\"pertanyaan\": \"Shortcut untuk menyimpan dokumen di Word adalah?\", \"pilihan\": [\"A) Ctrl + S\", \"B) Ctrl + C\", \"C) Ctrl + V\", \"D) Ctrl + X\"], \"jawaban_benar\": \"A\", \"bobot\": 1}, {\"pertanyaan\": \"Bagaimana cara membuat teks tebal di Word?\", \"pilihan\": [\"A) Ctrl + B\", \"B) Ctrl + I\", \"C) Ctrl + U\", \"D) Ctrl + P\"], \"jawaban_benar\": \"A\", \"bobot\": 1}, {\"pertanyaan\": \"Apa itu Mail Merge?\", \"pilihan\": [\"A) Menggabungkan email\", \"B) Menggabungkan dokumen dengan data\", \"C) Menggabungkan gambar\", \"D) Menggabungkan tabel\"], \"jawaban_benar\": \"B\", \"bobot\": 1}, {\"pertanyaan\": \"Format file default untuk Word adalah?\", \"pilihan\": [\"A) .txt\", \"B) .pdf\", \"C) .docx\", \"D) .xls\"], \"jawaban_benar\": \"C\", \"bobot\": 1}]', 'aktif', '2026-03-16 13:36:00', '2026-12-31 23:59:59', '2026-03-16 13:36:00', '2026-03-16 13:36:00'),
(2, 15, 2, 'Quiz Microsoft Excel Dasar', 'quiz-microsoft-excel-dasar', 'Quiz untuk menguji pemahaman dasar Microsoft Excel', 30, 70, 3, '[{\"pertanyaan\": \"Apa fungsi utama Microsoft Excel?\", \"pilihan\": [\"A) Pengolah kata\", \"B) Spreadsheet\", \"C) Presentasi\", \"D) Database\"], \"jawaban_benar\": \"B\", \"bobot\": 1}, {\"pertanyaan\": \"Formula untuk menjumlahkan nilai di Excel adalah?\", \"pilihan\": [\"A) =SUM()\", \"B) =AVERAGE()\", \"C) =COUNT()\", \"D) =MAX()\"], \"jawaban_benar\": \"A\", \"bobot\": 1}, {\"pertanyaan\": \"Referensi sel absolut menggunakan simbol?\", \"pilihan\": [\"A) !\", \"B) @\", \"C) $\", \"D) #\"], \"jawaban_benar\": \"C\", \"bobot\": 1}, {\"pertanyaan\": \"Apa fungsi VLOOKUP?\", \"pilihan\": [\"A) Mencari nilai vertikal\", \"B) Mencari nilai horizontal\", \"C) Menjumlahkan nilai\", \"D) Mengurutkan data\"], \"jawaban_benar\": \"A\", \"bobot\": 1}, {\"pertanyaan\": \"Format file default untuk Excel adalah?\", \"pilihan\": [\"A) .txt\", \"B) .pdf\", \"C) .xlsx\", \"D) .docx\"], \"jawaban_benar\": \"C\", \"bobot\": 1}]', 'aktif', '2026-03-16 13:36:00', '2026-12-31 23:59:59', '2026-03-16 13:36:00', '2026-03-16 13:36:00'),
(3, 16, 4, 'Quiz Photoshop Dasar', 'quiz-photoshop-dasar', 'Quiz untuk menguji pemahaman dasar Adobe Photoshop', 30, 70, 3, '[{\"pertanyaan\": \"Apa fungsi utama Adobe Photoshop?\", \"pilihan\": [\"A) Video editing\", \"B) Photo editing\", \"C) Audio editing\", \"D) 3D modeling\"], \"jawaban_benar\": \"B\", \"bobot\": 1}, {\"pertanyaan\": \"Tool untuk memilih area bebas bentuk adalah?\", \"pilihan\": [\"A) Marquee Tool\", \"B) Lasso Tool\", \"C) Magic Wand\", \"D) Crop Tool\"], \"jawaban_benar\": \"B\", \"bobot\": 1}, {\"pertanyaan\": \"Layer yang digunakan untuk menyesuaikan warna adalah?\", \"pilihan\": [\"A) Adjustment Layer\", \"B) Text Layer\", \"C) Shape Layer\", \"D) Background Layer\"], \"jawaban_benar\": \"A\", \"bobot\": 1}, {\"pertanyaan\": \"Format file yang mendukung transparansi adalah?\", \"pilihan\": [\"A) .jpg\", \"B) .bmp\", \"C) .png\", \"D) .gif\"], \"jawaban_benar\": \"C\", \"bobot\": 1}, {\"pertanyaan\": \"Shortcut untuk Brush Tool adalah?\", \"pilihan\": [\"A) B\", \"B) E\", \"C) G\", \"D) H\"], \"jawaban_benar\": \"A\", \"bobot\": 1}]', 'aktif', '2026-03-16 13:36:00', '2026-12-31 23:59:59', '2026-03-16 13:36:00', '2026-03-16 13:36:00'),
(4, 19, 13, 'Quiz HTML & CSS Dasar', 'quiz-html-css-dasar', 'Quiz untuk menguji pemahaman dasar HTML dan CSS', 30, 70, 3, '[{\"pertanyaan\": \"Apa kepanjangan dari HTML?\", \"pilihan\": [\"A) Hyper Text Markup Language\", \"B) High Tech Modern Language\", \"C) Home Tool Markup Language\", \"D) Hyperlink and Text Markup Language\"], \"jawaban_benar\": \"A\", \"bobot\": 1}, {\"pertanyaan\": \"Tag untuk membuat link di HTML adalah?\", \"pilihan\": [\"A) <link>\", \"B) <a>\", \"C) <href>\", \"D) <url>\"], \"jawaban_benar\": \"B\", \"bobot\": 1}, {\"pertanyaan\": \"Apa kepanjangan dari CSS?\", \"pilihan\": [\"A) Computer Style Sheets\", \"B) Creative Style Sheets\", \"C) Cascading Style Sheets\", \"D) Colorful Style Sheets\"], \"jawaban_benar\": \"C\", \"bobot\": 1}, {\"pertanyaan\": \"Property CSS untuk mengubah warna teks adalah?\", \"pilihan\": [\"A) text-color\", \"B) font-color\", \"C) color\", \"D) text-style\"], \"jawaban_benar\": \"C\", \"bobot\": 1}, {\"pertanyaan\": \"Tag untuk membuat paragraf di HTML adalah?\", \"pilihan\": [\"A) <p>\", \"B) <paragraph>\", \"C) <para>\", \"D) <text>\"], \"jawaban_benar\": \"A\", \"bobot\": 1}]', 'aktif', '2026-03-16 13:36:00', '2026-12-31 23:59:59', '2026-03-16 13:36:00', '2026-03-16 13:36:00'),
(5, 23, 25, 'Quiz Surat Resmi', 'quiz-surat-resmi', 'Quiz untuk menguji pemahaman format surat resmi', 20, 70, 3, '[{\"pertanyaan\": \"Bagian surat yang berisi tanggal pembuatan adalah?\", \"pilihan\": [\"A) Kop surat\", \"B) Tanggal surat\", \"C) Alamat surat\", \"D) Isi surat\"], \"jawaban_benar\": \"B\", \"bobot\": 1}, {\"pertanyaan\": \"Siapa yang menandatangani surat resmi?\", \"pilihan\": [\"A) Penerima surat\", \"B) Pengirim surat\", \"C) Saksi\", \"D) Notaris\"], \"jawaban_benar\": \"B\", \"bobot\": 1}, {\"pertanyaan\": \"Apa fungsi dari kop surat?\", \"pilihan\": [\"A) Menyampaikan pesan\", \"B) Identitas instansi\", \"C) Penutup surat\", \"D) Lampiran surat\"], \"jawaban_benar\": \"B\", \"bobot\": 1}, {\"pertanyaan\": \"Bagian surat yang berisi salam pembuka adalah?\", \"pilihan\": [\"A) Isi surat\", \"B) Penutup\", \"C) Salam\", \"D) Tanda tangan\"], \"jawaban_benar\": \"C\", \"bobot\": 1}, {\"pertanyaan\": \"Format surat yang benar menggunakan spasi?\", \"pilihan\": [\"A) 1.5\", \"B) 2\", \"C) 1\", \"D) 3\"], \"jawaban_benar\": \"B\", \"bobot\": 1}]', 'aktif', '2026-03-16 13:36:00', '2026-12-31 23:59:59', '2026-03-16 13:36:00', '2026-03-16 13:36:00'),
(6, 24, 28, 'Quiz Surat Massal', 'quiz-surat-massal', 'Quiz untuk menguji pemahaman teknik surat massal', 25, 70, 3, '[{\"pertanyaan\": \"Apa fungsi utama mail merge?\", \"pilihan\": [\"A) Mengirim email\", \"B) Membuat surat massal\", \"C) Mencetak dokumen\", \"D) Mengarsipkan surat\"], \"jawaban_benar\": \"B\", \"bobot\": 1}, {\"pertanyaan\": \"Data source untuk mail merge bisa berupa?\", \"pilihan\": [\"A) Excel\", \"B) Word\", \"C) PowerPoint\", \"D) PDF\"], \"jawaban_benar\": \"A\", \"bobot\": 1}, {\"pertanyaan\": \"Menu mail merge terdapat di tab?\", \"pilihan\": [\"A) Home\", \"B) Insert\", \"C) Mailings\", \"D) Review\"], \"jawaban_benar\": \"C\", \"bobot\": 1}, {\"pertanyaan\": \"Field untuk nama penerima di mail merge adalah?\", \"pilihan\": [\"A) <<Name>>\", \"B) <<Nama>>\", \"C) <<Recipient>>\", \"D) <<Penerima>>\"], \"jawaban_benar\": \"B\", \"bobot\": 1}, {\"pertanyaan\": \"Setelah mail merge, hasil bisa disimpan sebagai?\", \"pilihan\": [\"A) Satu file Word\", \"B) Banyak file Word\", \"C) File PDF\", \"D) File Excel\"], \"jawaban_benar\": \"B\", \"bobot\": 1}]', 'aktif', '2026-03-16 13:36:00', '2026-12-31 23:59:59', '2026-03-16 13:36:00', '2026-03-16 13:36:00'),
(7, 25, 30, 'Quiz AI Presentasi', 'quiz-ai-presentasi', 'Quiz untuk menguji pemahaman penggunaan AI untuk presentasi', 20, 70, 3, '[{\"pertanyaan\": \"AI yang populer untuk membuat presentasi adalah?\", \"pilihan\": [\"A) ChatGPT\", \"B) DALL-E\", \"C) Beautiful.ai\", \"D) Midjourney\"], \"jawaban_benar\": \"C\", \"bobot\": 1}, {\"pertanyaan\": \"Manfaat menggunakan AI untuk presentasi?\", \"pilihan\": [\"A) Menghemat waktu\", \"B) Meningkatkan kualitas\", \"C) Memberikan ide\", \"D) Semua benar\"], \"jawaban_benar\": \"D\", \"bobot\": 1}, {\"pertanyaan\": \"AI dapat membantu membuat?\", \"pilihan\": [\"A) Slide design\", \"B) Konten slide\", \"C) Animasi\", \"D) Semua benar\"], \"jawaban_benar\": \"D\", \"bobot\": 1}, {\"pertanyaan\": \"Tool AI untuk membuat gambar presentasi adalah?\", \"pilihan\": [\"A) DALL-E\", \"B) Midjourney\", \"C) Stable Diffusion\", \"D) Semua benar\"], \"jawaban_benar\": \"D\", \"bobot\": 1}, {\"pertanyaan\": \"AI dapat membantu dalam hal berikut KECUALI?\", \"pilihan\": [\"A) Membuat outline\", \"B) Design slide\", \"C) Presentasi langsung\", \"D) Membuat konten\"], \"jawaban_benar\": \"C\", \"bobot\": 1}]', 'aktif', '2026-03-16 13:36:00', '2026-12-31 23:59:59', '2026-03-16 13:36:00', '2026-03-16 13:36:00'),
(8, 29, 31, 'Quiz Administrasi Perkantoran', 'quiz-administrasi-perkantoran', 'Quiz untuk menguji pemahaman administrasi perkantoran', 30, 70, 3, '[{\"pertanyaan\": \"Tugas utama sekretaris adalah?\", \"pilihan\": [\"A) Mengarsipkan dokumen\", \"B) Membantu atasan\", \"C) Menerima telepon\", \"D) Semua benar\"], \"jawaban_benar\": \"D\", \"bobot\": 1}, {\"pertanyaan\": \"Sistem pengarsipan yang baik menggunakan?\", \"pilihan\": [\"A) Abjad\", \"B) Tanggal\", \"C) Kategori\", \"D) Semua benar\"], \"jawaban_benar\": \"D\", \"bobot\": 1}, {\"pertanyaan\": \"Etika dalam berkomunikasi di kantor?\", \"pilihan\": [\"A) Sopan\", \"B) Jelas\", \"C) Tepat waktu\", \"D) Semua benar\"], \"jawaban_benar\": \"D\", \"bobot\": 1}, {\"pertanyaan\": \"Dokumen yang harus disimpan adalah?\", \"pilihan\": [\"A) Surat masuk\", \"B) Surat keluar\", \"C) Laporan\", \"D) Semua benar\"], \"jawaban_benar\": \"D\", \"bobot\": 1}, {\"pertanyaan\": \"Alat kantor yang penting adalah?\", \"pilihan\": [\"A) Komputer\", \"B) Telepon\", \"C) Printer\", \"D) Semua benar\"], \"jawaban_benar\": \"D\", \"bobot\": 1}]', 'aktif', '2026-03-16 13:36:00', '2026-12-31 23:59:59', '2026-03-16 13:36:00', '2026-03-16 13:36:00'),
(9, 32, 38, 'Quiz Desain Komunikasi Visual', 'quiz-desain-komunikasi-visual', 'Quiz untuk menguji pemahaman dasar DKV', 30, 70, 3, '[{\"pertanyaan\": \"Apa tujuan utama DKV?\", \"pilihan\": [\"A) Membuat gambar indah\", \"B) Menyampaikan pesan visual\", \"C) Menghasilkan uang\", \"D) Mengikuti trend\"], \"jawaban_benar\": \"B\", \"bobot\": 1}, {\"pertanyaan\": \"Prinsip desain yang paling penting adalah?\", \"pilihan\": [\"A) Keseimbangan\", \"B) Kontras\", \"C) Hierarki\", \"D) Semua penting\"], \"jawaban_benar\": \"D\", \"bobot\": 1}, {\"pertanyaan\": \"Tipografi yang baik harus?\", \"pilihan\": [\"A) Mudah dibaca\", \"B) Konsisten\", \"C) Sesuai konteks\", \"D) Semua benar\"], \"jawaban_benar\": \"D\", \"bobot\": 1}, {\"pertanyaan\": \"Warna yang cocok untuk desain profesional adalah?\", \"pilihan\": [\"A) Biru\", \"B) Merah\", \"C) Hijau\", \"D) Tergantung konteks\"], \"jawaban_benar\": \"D\", \"bobot\": 1}, {\"pertanyaan\": \"Software yang umum digunakan untuk DKV adalah?\", \"pilihan\": [\"A) Photoshop\", \"B) Illustrator\", \"C) CorelDRAW\", \"D) Semua benar\"], \"jawaban_benar\": \"D\", \"bobot\": 1}]', 'aktif', '2026-03-16 13:36:00', '2026-12-31 23:59:59', '2026-03-16 13:36:00', '2026-03-16 13:36:00'),
(10, 17, 7, 'Quiz Komputer Dasar', 'quiz-komputer-dasar', 'Quiz untuk menguji pemahaman dasar komputer', 20, 70, 3, '[{\"pertanyaan\": \"Apa fungsi utama CPU?\", \"pilihan\": [\"A) Menyimpan data\", \"B) Memproses data\", \"C) Menampilkan data\", \"D) Input data\"], \"jawaban_benar\": \"B\", \"bobot\": 1}, {\"pertanyaan\": \"RAM berfungsi untuk?\", \"pilihan\": [\"A) Penyimpanan permanen\", \"B) Penyimpanan sementara\", \"C) Memproses data\", \"D) Menampilkan gambar\"], \"jawaban_benar\": \"B\", \"bobot\": 1}, {\"pertanyaan\": \"Hardware untuk input adalah?\", \"pilihan\": [\"A) Monitor\", \"B) Printer\", \"C) Keyboard\", \"D) Speaker\"], \"jawaban_benar\": \"C\", \"bobot\": 1}, {\"pertanyaan\": \"Software sistem operasi contohnya?\", \"pilihan\": [\"A) Windows\", \"B) Microsoft Office\", \"C) Photoshop\", \"D) Chrome\"], \"jawaban_benar\": \"A\", \"bobot\": 1}, {\"pertanyaan\": \"Unit penyimpanan data adalah?\", \"pilihan\": [\"A) CPU\", \"B) RAM\", \"C) Harddisk\", \"D) Monitor\"], \"jawaban_benar\": \"C\", \"bobot\": 1}]', 'aktif', '2026-03-16 13:36:00', '2026-12-31 23:59:59', '2026-03-16 13:36:00', '2026-03-16 13:36:00');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_hasil`
--

CREATE TABLE `quiz_hasil` (
  `id_quiz_hasil` int(11) NOT NULL,
  `id_quiz` int(11) NOT NULL,
  `id_pendaftaran` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `attempt_ke` int(11) NOT NULL DEFAULT 1 COMMENT 'Percobaan ke-',
  `jawaban_json` longtext NOT NULL COMMENT 'JSON array of student answers',
  `total_nilai` decimal(5,2) NOT NULL DEFAULT 0.00 COMMENT 'Total nilai 0-100',
  `total_benar` int(11) NOT NULL DEFAULT 0 COMMENT 'Jumlah jawaban benar',
  `total_salah` int(11) NOT NULL DEFAULT 0 COMMENT 'Jumlah jawaban salah',
  `total_soal` int(11) NOT NULL DEFAULT 0,
  `is_lulus` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1=lulus, 0=belum lulus',
  `waktu_mulai` datetime NOT NULL COMMENT 'Waktu mulai pengerjaan',
  `waktu_selesai` datetime NOT NULL COMMENT 'Waktu selesai pengerjaan',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Tabel Hasil Quiz Siswa';

--
-- Dumping data for table `quiz_hasil`
--

INSERT INTO `quiz_hasil` (`id_quiz_hasil`, `id_quiz`, `id_pendaftaran`, `id_siswa`, `attempt_ke`, `jawaban_json`, `total_nilai`, `total_benar`, `total_salah`, `total_soal`, `is_lulus`, `waktu_mulai`, `waktu_selesai`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 1, '[{\"jawaban\": \"C\"}, {\"jawaban\": \"A\"}, {\"jawaban\": \"A\"}, {\"jawaban\": \"B\"}, {\"jawaban\": \"C\"}]', 100.00, 5, 0, 5, 1, '2026-03-16 10:00:00', '2026-03-16 10:15:00', '2026-03-16 10:15:00', '2026-03-16 10:15:00'),
(2, 1, 2, 2, 1, '[{\"jawaban\": \"B\"}, {\"jawaban\": \"A\"}, {\"jawaban\": \"A\"}, {\"jawaban\": \"B\"}, {\"jawaban\": \"C\"}]', 80.00, 4, 1, 5, 1, '2026-03-16 11:00:00', '2026-03-16 11:20:00', '2026-03-16 11:20:00', '2026-03-16 11:20:00'),
(3, 2, 1, 1, 1, '[{\"jawaban\": \"B\"}, {\"jawaban\": \"A\"}, {\"jawaban\": \"C\"}, {\"jawaban\": \"A\"}, {\"jawaban\": \"C\"}]', 100.00, 5, 0, 5, 1, '2026-03-16 12:00:00', '2026-03-16 12:25:00', '2026-03-16 12:25:00', '2026-03-16 12:25:00'),
(4, 2, 2, 2, 1, '[{\"jawaban\": \"A\"}, {\"jawaban\": \"B\"}, {\"jawaban\": \"C\"}, {\"jawaban\": \"A\"}, {\"jawaban\": \"C\"}]', 60.00, 3, 2, 5, 0, '2026-03-16 13:00:00', '2026-03-16 13:30:00', '2026-03-16 13:30:00', '2026-03-16 13:30:00'),
(5, 2, 2, 2, 2, '[{\"jawaban\": \"B\"}, {\"jawaban\": \"A\"}, {\"jawaban\": \"C\"}, {\"jawaban\": \"A\"}, {\"jawaban\": \"C\"}]', 80.00, 4, 1, 5, 1, '2026-03-16 14:00:00', '2026-03-16 14:28:00', '2026-03-16 14:28:00', '2026-03-16 14:28:00'),
(6, 3, 3, 3, 1, '[{\"jawaban\": \"B\"}, {\"jawaban\": \"B\"}, {\"jawaban\": \"A\"}, {\"jawaban\": \"C\"}, {\"jawaban\": \"A\"}]', 80.00, 4, 1, 5, 1, '2026-03-16 15:00:00', '2026-03-16 15:22:00', '2026-03-16 15:22:00', '2026-03-16 15:22:00'),
(7, 4, 4, 4, 1, '[{\"jawaban\": \"A\"}, {\"jawaban\": \"B\"}, {\"jawaban\": \"C\"}, {\"jawaban\": \"C\"}, {\"jawaban\": \"A\"}]', 100.00, 5, 0, 5, 1, '2026-03-16 16:00:00', '2026-03-16 16:18:00', '2026-03-16 16:18:00', '2026-03-16 16:18:00'),
(8, 5, 5, 5, 1, '[{\"jawaban\": \"B\"}, {\"jawaban\": \"B\"}, {\"jawaban\": \"B\"}, {\"jawaban\": \"C\"}, {\"jawaban\": \"B\"}]', 100.00, 5, 0, 5, 1, '2026-03-16 17:00:00', '2026-03-16 17:12:00', '2026-03-16 17:12:00', '2026-03-16 17:12:00'),
(9, 6, 6, 6, 1, '[{\"jawaban\": \"B\"}, {\"jawaban\": \"A\"}, {\"jawaban\": \"C\"}, {\"jawaban\": \"B\"}, {\"jawaban\": \"B\"}]', 80.00, 4, 1, 5, 1, '2026-03-16 18:00:00', '2026-03-16 18:20:00', '2026-03-16 18:20:00', '2026-03-16 18:20:00'),
(10, 7, 7, 7, 1, '[{\"jawaban\": \"C\"}, {\"jawaban\": \"D\"}, {\"jawaban\": \"D\"}, {\"jawaban\": \"D\"}, {\"jawaban\": \"C\"}]', 100.00, 5, 0, 5, 1, '2026-03-16 19:00:00', '2026-03-16 19:15:00', '2026-03-16 19:15:00', '2026-03-16 19:15:00'),
(11, 8, 8, 8, 1, '[{\"jawaban\": \"D\"}, {\"jawaban\": \"D\"}, {\"jawaban\": \"D\"}, {\"jawaban\": \"D\"}, {\"jawaban\": \"D\"}]', 100.00, 5, 0, 5, 1, '2026-03-16 20:00:00', '2026-03-16 20:16:00', '2026-03-16 20:16:00', '2026-03-16 20:16:00'),
(12, 9, 9, 9, 1, '[{\"jawaban\": \"B\"}, {\"jawaban\": \"D\"}, {\"jawaban\": \"D\"}, {\"jawaban\": \"D\"}, {\"jawaban\": \"D\"}]', 100.00, 5, 0, 5, 1, '2026-03-16 21:00:00', '2026-03-16 21:19:00', '2026-03-16 21:19:00', '2026-03-16 21:19:00'),
(13, 10, 10, 10, 1, '[{\"jawaban\": \"B\"}, {\"jawaban\": \"B\"}, {\"jawaban\": \"C\"}, {\"jawaban\": \"A\"}, {\"jawaban\": \"C\"}]', 80.00, 4, 1, 5, 1, '2026-03-16 22:00:00', '2026-03-16 22:17:00', '2026-03-16 22:17:00', '2026-03-16 22:17:00'),
(22, 6, 51, 28, 2, '[{\"soal_id\":1,\"jawaban\":\"1\"},{\"soal_id\":2,\"jawaban\":\"0\"},{\"soal_id\":3,\"jawaban\":\"2\"},{\"soal_id\":4,\"jawaban\":\"1\"},{\"soal_id\":5,\"jawaban\":\"2\"}]', 80.00, 4, 1, 5, 1, '2026-03-16 16:11:20', '2026-03-16 16:11:20', '2026-03-16 09:11:20', '2026-03-16 09:11:20');

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `id_review` int(11) NOT NULL,
  `id_pendaftaran` int(11) NOT NULL,
  `id_kursus` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `rating_overall` tinyint(4) NOT NULL CHECK (`rating_overall` between 1 and 5),
  `rating_materi` tinyint(4) DEFAULT 0 CHECK (`rating_materi` between 1 and 5),
  `rating_mentor` tinyint(4) DEFAULT 0 CHECK (`rating_mentor` between 1 and 5),
  `review_title` varchar(255) DEFAULT '',
  `review_text` text DEFAULT NULL,
  `pros` text DEFAULT NULL,
  `cons` text DEFAULT NULL,
  `is_verified` tinyint(1) DEFAULT 1,
  `is_visible` tinyint(1) DEFAULT 1,
  `helpful_count` int(11) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`id_review`, `id_pendaftaran`, `id_kursus`, `id_siswa`, `rating_overall`, `rating_materi`, `rating_mentor`, `review_title`, `review_text`, `pros`, `cons`, `is_verified`, `is_visible`, `helpful_count`, `created_at`, `updated_at`) VALUES
(1, 2, 15, 2, 5, 5, 5, 'Kursus Sangat Membantu!', 'Materi mudah dipahami, mentor responsif, progress tracking jelas. Anak saya jadi lebih percaya diri menggunakan komputer.', 'Materi visual menarik, mentor ramah, harga terjangkau', 'Mungkin bisa ditambah latihan interaktif', 1, 1, 0, '2026-02-27 14:48:11', '2026-02-27 14:48:11'),
(2, 51, 24, 28, 5, 5, 5, 'sangat bagus', 'sangat bagus dalam penyampaian materi dan merasa puas', 'pengajar ramah baik ', 'dalam penyampaian materi tidak bisa pelan', 1, 1, 0, '2026-03-14 12:00:11', '2026-03-14 12:00:11');

-- --------------------------------------------------------

--
-- Table structure for table `saran`
--

CREATE TABLE `saran` (
  `id_saran` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `pesan` text NOT NULL,
  `tanggal` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `saran`
--

INSERT INTO `saran` (`id_saran`, `nama`, `email`, `pesan`, `tanggal`) VALUES
(1, 'Ahmad Fauzi', 'ahmad.fauzi@email.com', 'Saya sangat senang dengan materi pelatihan desain grafis. Namun, saya harap ada tambahan jam praktik agar lebih mahir.', '2026-01-15 09:30:00'),
(2, 'Siti Nurhaliza', 'siti.nurhaliza@email.com', 'Pengajarnya sangat sabar dan mudah dimengerti. Terima kasih LPK INASABA!', '2026-01-18 14:20:00'),
(3, 'Budi Santoso', 'budi.s@email.com', 'Fasilitas komputernya sudah bagus, tapi mungkin bisa ditambah jumlahnya karena kadang harus antri.', '2026-01-20 10:45:00'),
(4, 'Dewi Lestari', 'dewi.lestari@email.com', 'Kurikulumnya sangat terstruktur dan mudah diikuti. Sangat membantu untuk pemula seperti saya.', '2026-01-22 16:10:00'),
(5, 'Rudi Hartono', 'rudi.h@email.com', 'Saran saya, mungkin bisa ditambahkan materi tentang software terbaru di bidang desain.', '2026-01-25 11:25:00'),
(6, 'Anisa Wijaya', 'anisa.w@email.com', 'Pelayanan administrasinya cepat dan ramah. Sangat memuaskan!', '2026-01-28 13:50:00'),
(7, 'Eko Prasetyo', 'eko.p@email.com', 'Tempatnya strategis dan mudah diakses. Parkirnya juga luas.', '2026-01-30 09:15:00'),
(8, 'Maya Sari', 'maya.sari@email.com', 'Saya harap ada kelas lanjutan untuk yang sudah menguasai dasar-dasar.', '2026-02-01 15:30:00'),
(9, 'hjhj', 'fs@gmail.com', 'dfgfgcncncfhnccvcdffgb', '2026-02-02 02:57:57'),
(10, 'hjhj', 'hjhjs@gmail.com', 'dsdsssdfffgfgfdddg', '2026-02-02 03:58:07');

-- --------------------------------------------------------

--
-- Table structure for table `sertifikat`
--

CREATE TABLE `sertifikat` (
  `id_sertifikat` int(11) NOT NULL,
  `id_pendaftaran` int(11) NOT NULL,
  `id_kursus` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `nomor_sertifikat` varchar(100) NOT NULL,
  `qr_code` varchar(255) DEFAULT '',
  `verification_url` varchar(255) DEFAULT '',
  `nama_peserta` varchar(150) NOT NULL,
  `nama_kursus` varchar(255) NOT NULL,
  `nama_paket` varchar(100) DEFAULT '',
  `nilai_akhir` decimal(5,2) DEFAULT 0.00,
  `predikat` enum('Excellent','Very Good','Good','Pass','Need Improvement') DEFAULT 'Pass',
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `tanggal_terbit` datetime DEFAULT current_timestamp(),
  `file_pdf` varchar(255) DEFAULT '',
  `file_thumb` varchar(255) DEFAULT '',
  `is_active` tinyint(1) DEFAULT 1,
  `is_verified` tinyint(1) DEFAULT 1,
  `issued_by` int(11) DEFAULT 0,
  `notes` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sertifikat`
--

INSERT INTO `sertifikat` (`id_sertifikat`, `id_pendaftaran`, `id_kursus`, `id_siswa`, `nomor_sertifikat`, `qr_code`, `verification_url`, `nama_peserta`, `nama_kursus`, `nama_paket`, `nilai_akhir`, `predikat`, `tanggal_mulai`, `tanggal_selesai`, `tanggal_terbit`, `file_pdf`, `file_thumb`, `is_active`, `is_verified`, `issued_by`, `notes`, `created_at`, `updated_at`) VALUES
(1, 2, 15, 2, 'CERT/2026/OFFICE/000002', 'qr_a1b2c3d4e5f6g7h8i9j0', 'https://lpkinasaba.com/verify/CERT/2026/OFFICE/000002', 'Siti Rahayu', 'Materi Aplikasi Perkantoran', 'Kelas Intensive', 92.50, 'Excellent', '2026-01-11', '2026-02-18', '2026-02-27 14:47:14', 'certificates/2026/CERT_OFFICE_000002.pdf', 'certificates/2026/thumbs/CERT_OFFICE_000002_thumb.jpg', 1, 1, 8, 'Sertifikat diterbitkan otomatis', '2026-02-27 15:38:55', '2026-03-15 04:28:06'),
(2, 1, 15, 1, 'CERT/2026/OFFICE/000001', 'qr_z9y8x7w6v5u4t3s2r1q0', 'https://lpkinasaba.com/verify/CERT/2026/OFFICE/000001', 'Budi Saputra', 'Materi Aplikasi Perkantoran', 'Kelas Reguler', 85.00, 'Very Good', '2026-02-16', NULL, '2026-02-27 15:00:00', '', '', 1, 1, 8, 'Sertifikat diterbitkan otomatis', '2026-02-27 15:38:55', '2026-03-15 04:28:06'),
(4, 51, 24, 28, 'CERT/2026/RAHASIASURATMASSAL_DAFTARISIOTOMATIS/000001', 'http://localhost/web_lms/public/sertifikat/verify/CERT/2026/RAHASIASURATMASSAL_DAFTARISIOTOMATIS/000001', 'http://localhost/web_lms/public/sertifikat/verify/CERT/2026/RAHASIASURATMASSAL_DAFTARISIOTOMATIS/000001', 'Haidar Hussein', 'Rahasia surat massal & Daftar isi otomatis', 'Rahasia surat massal & Daftar isi otomatis - 25 Pertemuan', 0.00, 'Need Improvement', '2026-03-11', '2026-03-14', '2026-03-14 12:57:19', '2026/CERT_CERT_2026_RAHASIASURATMASSAL_DAFTARISIOTOMATIS_000001.pdf', 'certificates/thumbs/CERT_CERT_2026_RAHASIASURATMASSAL_DAFTARISIOTOMATIS_000001_thumb.jpg', 1, 1, 8, 'Sertifikat diterbitkan otomatis setelah penyelesaian kursus', '2026-03-14 12:57:19', '2026-03-15 04:29:00');

-- --------------------------------------------------------

--
-- Table structure for table `setting_web`
--

CREATE TABLE `setting_web` (
  `id_setting` int(11) NOT NULL,
  `id_pemilik` int(11) NOT NULL,
  `nama_website` varchar(100) NOT NULL DEFAULT 'LMSWeb',
  `logo` varchar(255) DEFAULT 'logo.png',
  `gambar_a` varchar(255) DEFAULT NULL,
  `gambar_b` varchar(255) NOT NULL,
  `url_yt` varchar(255) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `no_telepon` varchar(15) DEFAULT NULL,
  `email_kontak` varchar(100) DEFAULT NULL,
  `jam_kerja` varchar(100) NOT NULL DEFAULT 'Senin - Sabtu, 08:00 - 17:00',
  `sejarah_lengkap` text DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_keywords` text DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `id_siswa` int(11) NOT NULL,
  `nis` varchar(100) DEFAULT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `kata_sandi` varchar(255) NOT NULL,
  `foto_profil` varchar(255) DEFAULT 'default.jpg',
  `no_telepon` varchar(15) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `tempat_lahir` varchar(100) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` enum('Laki - laki','Perempuan') DEFAULT NULL,
  `agama` enum('Islam','Kristen','Katolik','Hindu') DEFAULT NULL,
  `level` enum('siswa') NOT NULL DEFAULT 'siswa',
  `tanggal_daftar` datetime DEFAULT current_timestamp(),
  `last_login` datetime DEFAULT NULL,
  `status_aktif` enum('aktif','nonaktif') DEFAULT 'aktif',
  `id_pemilik` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`id_siswa`, `nis`, `nama_lengkap`, `email`, `kata_sandi`, `foto_profil`, `no_telepon`, `alamat`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `agama`, `level`, `tanggal_daftar`, `last_login`, `status_aktif`, `id_pemilik`, `created_at`, `updated_at`) VALUES
(28, 'NIS20260310220449', 'Haidar Husseiny', 'haidarhusseinmovic@gmail.com', 'ninja150', 'siswa_1773368894_1773368894_fc275a548012839d2bd7.jpg', '085213035225', 'Jln.Raya Tanjung Tirto Kabupaten Pekalongan', 'Pekalongan', '2026-03-10', 'Laki - laki', 'Islam', 'siswa', '2026-03-10 22:04:49', '2026-03-16 12:45:59', 'aktif', 0, '2026-03-10 22:04:49', '2026-03-16 12:45:59');

-- --------------------------------------------------------

--
-- Table structure for table `slider_promo`
--

CREATE TABLE `slider_promo` (
  `id_slider` int(11) NOT NULL,
  `judul_slider` varchar(150) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `gambar_slider` varchar(255) DEFAULT NULL,
  `link_url` varchar(255) DEFAULT NULL,
  `urutan` int(11) DEFAULT 0,
  `status` enum('aktif','tidak_aktif') DEFAULT 'aktif',
  `id_pemilik` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `slider_promo`
--

INSERT INTO `slider_promo` (`id_slider`, `judul_slider`, `deskripsi`, `gambar_slider`, `link_url`, `urutan`, `status`, `id_pemilik`, `created_at`, `updated_at`) VALUES
(1, 'Promo PC Hardware', 'Diskon 20% bulan  ini\r\n', '1773585436_edb82e59cb4fdc7a3183.png', 'http://localhost/web_lms/public/home_siswa/index', 1, 'aktif', 1, NULL, '2026-03-15 21:37:16'),
(2, 'Kursus Digital Marketing', 'Mulai karir di dunia digital', '1773585448_d2bba8c14ec3c93e1605.png', 'http://localhost/web_lms/public/home_siswa/index', 1, 'aktif', 2, NULL, '2026-03-15 21:37:28');

-- --------------------------------------------------------

--
-- Table structure for table `slider_web`
--

CREATE TABLE `slider_web` (
  `id_slider` int(11) NOT NULL,
  `judul_slider` varchar(150) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `gambar_slider` varchar(255) DEFAULT NULL,
  `link_url` varchar(255) DEFAULT NULL,
  `urutan` int(11) DEFAULT 0,
  `status` enum('aktif','tidak_aktif') DEFAULT 'aktif',
  `id_pemilik` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `slider_web`
--

INSERT INTO `slider_web` (`id_slider`, `judul_slider`, `deskripsi`, `gambar_slider`, `link_url`, `urutan`, `status`, `id_pemilik`, `created_at`, `updated_at`) VALUES
(1, 'Computer for kid', 'Computer for kid', '1773586020_f758ae2a29004a802c30.png', 'http://localhost/web_lms/public/home_website/index', 1, 'aktif', 1, NULL, '2026-03-15 22:42:28'),
(2, 'Penerimaan pserta didik', 'Penerimaan pserta didik', '1773586285_515e40e5829a930f0f17.jpg', 'http://localhost/web_lms/public/home_website/index', 2, 'aktif', 2, NULL, '2026-03-15 22:42:52');

-- --------------------------------------------------------

--
-- Table structure for table `stats`
--

CREATE TABLE `stats` (
  `id_stats` int(11) NOT NULL,
  `judul_stats` varchar(255) NOT NULL,
  `nilai_stats` int(11) NOT NULL DEFAULT 0,
  `suffix_stats` varchar(50) DEFAULT NULL,
  `urutan_stats` int(11) NOT NULL DEFAULT 0,
  `baris_stats` int(11) NOT NULL DEFAULT 1,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stats`
--

INSERT INTO `stats` (`id_stats`, `judul_stats`, `nilai_stats`, `suffix_stats`, `urutan_stats`, `baris_stats`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Peserta Program', 10000, '+', 1, 1, 1, '2026-03-17 02:07:03', '2026-03-17 02:07:03'),
(2, 'Mendidik & mengedukasi Indonesia', 25, ' Tahun', 2, 1, 1, '2026-03-17 02:07:03', '2026-03-17 02:07:03'),
(3, 'Mitra', 100, '+', 3, 1, 1, '2026-03-17 02:07:03', '2026-03-17 02:07:03'),
(4, 'Praktek', 70, '%', 4, 1, 1, '2026-03-17 02:07:03', '2026-03-17 02:07:03'),
(5, 'Teori', 30, '%', 5, 1, 1, '2026-03-17 02:07:03', '2026-03-17 02:07:03'),
(6, 'Alumni Terserap Kerja', 95, '%', 6, 1, 1, '2026-03-17 02:07:03', '2026-03-17 02:07:03'),
(7, 'Instruktur Bersertifikat', 20, '+', 1, 2, 1, '2026-03-17 02:07:03', '2026-03-17 02:07:03'),
(8, 'Program Pelatihan', 15, '+', 2, 2, 1, '2026-03-17 02:07:03', '2026-03-17 02:07:03'),
(9, 'Sertifikasi Resmi', 0, NULL, 3, 2, 1, '2026-03-17 02:07:03', '2026-03-17 02:07:03');

-- --------------------------------------------------------

--
-- Table structure for table `superadmin`
--

CREATE TABLE `superadmin` (
  `id_superadmin` int(11) NOT NULL,
  `id_pemilik` int(11) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `no_telepon` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `kata_sandi` varchar(255) NOT NULL,
  `foto_profil` varchar(255) DEFAULT 'default.jpg',
  `level` enum('superadmin') NOT NULL,
  `tanggal_daftar` datetime DEFAULT current_timestamp(),
  `last_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `superadmin`
--

INSERT INTO `superadmin` (`id_superadmin`, `id_pemilik`, `nama_lengkap`, `username`, `email`, `no_telepon`, `alamat`, `kata_sandi`, `foto_profil`, `level`, `tanggal_daftar`, `last_login`) VALUES
(1, 1, 'Ahmad', 'ff', 'ahmad@inasaba.id', '088798999797', '', 'ninja150', 'superadmin_1772957372_1772957372_9221d2563f71b0a8098b.jpg', 'superadmin', '2026-01-22 10:50:40', '2026-03-17 09:20:09'),
(2, 2, 'Budi', 'ml', 'budi@cerdas.id', '', '', 'ninja150', 'default.jpg', 'superadmin', '2026-01-22 10:50:40', '2026-02-03 13:36:53');

-- --------------------------------------------------------

--
-- Table structure for table `tugas`
--

CREATE TABLE `tugas` (
  `id_tugas` int(11) NOT NULL,
  `id_kursus` int(11) NOT NULL,
  `id_modul` int(11) DEFAULT 0,
  `id_materi` int(11) DEFAULT 0,
  `judul_tugas` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `tipe_tugas` enum('upload_file','text_input','link_url') DEFAULT 'upload_file',
  `format_file` varchar(100) DEFAULT 'pdf,doc,docx,zip',
  `max_file_mb` int(11) DEFAULT 10,
  `deadline` datetime DEFAULT NULL,
  `nilai_maks` decimal(5,2) DEFAULT 100.00,
  `rubrik` text DEFAULT NULL,
  `status` enum('draft','aktif','closed') DEFAULT 'draft',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tugas`
--

INSERT INTO `tugas` (`id_tugas`, `id_kursus`, `id_modul`, `id_materi`, `judul_tugas`, `deskripsi`, `tipe_tugas`, `format_file`, `max_file_mb`, `deadline`, `nilai_maks`, `rubrik`, `status`, `created_at`, `updated_at`) VALUES
(1, 15, 1, 0, 'Tugas 1: Dokumen Word', 'Buat surat resmi dengan formatting benar (bold, italic, table)', 'upload_file', 'pdf,doc,docx,zip', 10, '2026-03-15 23:59:59', 100.00, NULL, 'draft', '2026-02-27 14:45:59', '2026-02-27 14:45:59'),
(2, 15, 2, 0, 'Tugas 2: Formula Excel', 'Buat spreadsheet dengan minimal 5 formula (SUM, AVERAGE, IF, VLOOKUP, COUNT)', 'upload_file', 'pdf,doc,docx,zip', 10, '2026-03-22 23:59:59', 100.00, NULL, 'draft', '2026-02-27 14:45:59', '2026-02-27 14:45:59');

-- --------------------------------------------------------

--
-- Table structure for table `uji_kompetensi`
--

CREATE TABLE `uji_kompetensi` (
  `id_uji_kompetensi` int(11) NOT NULL,
  `nama_uji_kompetensi` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `durasi` varchar(100) NOT NULL,
  `tipe_pembelajaran` varchar(50) NOT NULL,
  `sertifikat` varchar(255) NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `status` enum('aktif','tidak_aktif') DEFAULT 'aktif',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `uji_kompetensi`
--

INSERT INTO `uji_kompetensi` (`id_uji_kompetensi`, `nama_uji_kompetensi`, `deskripsi`, `durasi`, `tipe_pembelajaran`, `sertifikat`, `harga`, `gambar`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Google LCP Certification', 'Sertifikasi Google untuk meningkatkan performa website dengan Largest Contentful Paint. Program ini dirancang untuk mengajarkan best practices dalam web performance optimization.', '3 Bulan', 'Online & Offline', 'Sertifikat Google', 450000.00, 'clcp.png', 'aktif', '2026-03-12 03:42:07', '2026-03-12 03:42:07'),
(2, 'Oracle Accounting Cloud Series', 'Sertifikasi untuk menguasai akuntansi berbasis cloud dengan software modern. Mencakup implementasi Oracle Cloud Financials dan best practices.', '4 Bulan', 'Online & Offline', 'Sertifikat Oracle', 450000.00, 'oa.png', 'aktif', '2026-03-12 03:42:07', '2026-03-12 03:42:07'),
(3, 'Digital Marketing Professional', 'Program sertifikasi digital marketing comprehensive dari SEO hingga social media marketing dengan focus pada practical implementation.', '2 Bulan', 'Online & Offline', 'Sertifikat Digital Marketing', 350000.00, 'dm.png', 'aktif', '2026-03-12 03:42:07', '2026-03-12 03:42:07'),
(4, 'Web Development Full Stack', 'Sertifikasi pengembangan web lengkap dari frontend hingga backend dengan modern frameworks dan best practices.', '6 Bulan', 'Online & Offline', 'Sertifikat Web Developer', 750000.00, 'wd.png', 'aktif', '2026-03-12 03:42:07', '2026-03-12 03:42:07'),
(5, 'Graphic Design Master', 'Program sertifikasi desain grafis profesional dengan tools terkini dan portfolio development.', '3 Bulan', 'Online & Offline', 'Sertifikat Graphic Designer', 400000.00, 'gd.png', 'aktif', '2026-03-12 03:42:07', '2026-03-12 03:42:07'),
(6, 'Data Science Foundation', 'Sertifikasi dasar-dasar data science dengan Python, machine learning fundamentals, dan data visualization.', '5 Bulan', 'Online & Offline', 'Sertifikat Data Scientist', 650000.00, 'ds.png', 'aktif', '2026-03-12 03:42:07', '2026-03-12 03:42:07'),
(7, 'Mobile App Development', 'Program sertifikasi pengembangan aplikasi mobile cross-platform dengan React Native dan Flutter.', '4 Bulan', 'Online & Offline', 'Sertifikat Mobile Developer', 550000.00, 'mad.png', 'aktif', '2026-03-12 03:42:07', '2026-03-12 03:42:07'),
(8, 'Cloud Computing Essentials', 'Sertifikasi cloud computing fundamentals dengan AWS, Azure, dan Google Cloud Platform.', '3 Bulan', 'Online & Offline', 'Sertifikat Cloud Architect', 500000.00, 'cc.png', 'aktif', '2026-03-12 03:42:07', '2026-03-12 03:42:07');

-- --------------------------------------------------------

--
-- Table structure for table `visi_misi`
--

CREATE TABLE `visi_misi` (
  `id_visimisi` int(11) NOT NULL,
  `jenis` enum('visi','misi') NOT NULL,
  `konten` text NOT NULL,
  `urutan` int(11) NOT NULL DEFAULT 1,
  `status` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `visi_misi`
--

INSERT INTO `visi_misi` (`id_visimisi`, `jenis`, `konten`, `urutan`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'visi', 'Menjadi lembaga pelatihan komputer unggulan di Indonesia yang menghasilkan SDM berkualitas, siap kerja, dan berdaya saing global.', 1, 'aktif', '2026-03-17 02:14:49', '2026-03-17 02:14:49', NULL),
(2, 'misi', 'Menyelenggarakan pelatihan berbasis kompetensi yang relevan dengan kebutuhan industri.', 1, 'aktif', '2026-03-17 02:14:49', '2026-03-17 02:14:49', NULL),
(3, 'misi', 'Mengembangkan instruktur profesional dan berpengalaman di bidangnya.', 2, 'aktif', '2026-03-17 02:14:49', '2026-03-17 02:14:49', NULL),
(4, 'misi', 'Membangun kerja sama strategis dengan dunia industri dan pemerintah.', 3, 'aktif', '2026-03-17 02:14:49', '2026-03-17 02:14:49', NULL),
(5, 'misi', 'Memberdayakan masyarakat melalui pendidikan vokasi berkualitas.', 4, 'aktif', '2026-03-17 02:14:49', '2026-03-17 02:14:49', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alumni`
--
ALTER TABLE `alumni`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_kategori` (`kategori`),
  ADD KEY `idx_nama` (`nama`);

--
-- Indexes for table `bank`
--
ALTER TABLE `bank`
  ADD PRIMARY KEY (`id_bank`);

--
-- Indexes for table `banner_program`
--
ALTER TABLE `banner_program`
  ADD PRIMARY KEY (`id_banner`);

--
-- Indexes for table `detail_kursus`
--
ALTER TABLE `detail_kursus`
  ADD PRIMARY KEY (`id_detail`),
  ADD UNIQUE KEY `id_kursus` (`id_kursus`);

--
-- Indexes for table `diskusi`
--
ALTER TABLE `diskusi`
  ADD PRIMARY KEY (`id_diskusi`),
  ADD KEY `idx_kursus` (`id_kursus`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `instruktur`
--
ALTER TABLE `instruktur`
  ADD PRIMARY KEY (`id_instruktur`),
  ADD KEY `idx_instruktur_status` (`status`),
  ADD KEY `idx_instruktur_urutan` (`urutan`),
  ADD KEY `idx_instruktur_deleted` (`deleted_at`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id_simpan`);

--
-- Indexes for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id_karyawan`);

--
-- Indexes for table `keranjang`
--
ALTER TABLE `keranjang`
  ADD PRIMARY KEY (`id_keranjang`);

--
-- Indexes for table `kursus`
--
ALTER TABLE `kursus`
  ADD PRIMARY KEY (`id_kursus`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `lulusan`
--
ALTER TABLE `lulusan`
  ADD PRIMARY KEY (`id_lulusan`),
  ADD KEY `idx_tahun_lulus` (`tahun_lulus`),
  ADD KEY `idx_kategori` (`kategori`),
  ADD KEY `idx_status_pekerjaan` (`status_pekerjaan`),
  ADD KEY `idx_deleted_at` (`deleted_at`);

--
-- Indexes for table `manajemen`
--
ALTER TABLE `manajemen`
  ADD PRIMARY KEY (`id_manajemen`),
  ADD KEY `idx_manajemen_status` (`status`),
  ADD KEY `idx_manajemen_urutan` (`urutan`),
  ADD KEY `idx_manajemen_deleted` (`deleted_at`);

--
-- Indexes for table `materi`
--
ALTER TABLE `materi`
  ADD PRIMARY KEY (`id_materi`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mitra_kerja`
--
ALTER TABLE `mitra_kerja`
  ADD PRIMARY KEY (`id_mitra`);

--
-- Indexes for table `modul`
--
ALTER TABLE `modul`
  ADD PRIMARY KEY (`id_modul`);

--
-- Indexes for table `paket_kursus`
--
ALTER TABLE `paket_kursus`
  ADD PRIMARY KEY (`id_paket`),
  ADD KEY `id_kursus` (`id_kursus`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD UNIQUE KEY `kode_transaksi` (`kode_transaksi`),
  ADD KEY `idx_transaksi` (`kode_transaksi`);

--
-- Indexes for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD PRIMARY KEY (`id_pendaftaran`);

--
-- Indexes for table `pengumpulan_tugas`
--
ALTER TABLE `pengumpulan_tugas`
  ADD PRIMARY KEY (`id_kumpul`),
  ADD KEY `idx_tugas` (`id_tugas`),
  ADD KEY `idx_siswa` (`id_siswa`),
  ADD KEY `idx_status` (`status_penilaian`),
  ADD KEY `idx_tanggal` (`tanggal_kirim`),
  ADD KEY `id_karyawan` (`id_karyawan`);

--
-- Indexes for table `postingan`
--
ALTER TABLE `postingan`
  ADD PRIMARY KEY (`id_postingan`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_kategori` (`kategori`),
  ADD KEY `idx_created_at` (`created_at`),
  ADD KEY `idx_views` (`views`);

--
-- Indexes for table `profil_lpk`
--
ALTER TABLE `profil_lpk`
  ADD PRIMARY KEY (`id_profil`),
  ADD KEY `idx_profil_lpk_deleted` (`deleted_at`);

--
-- Indexes for table `program_kursus`
--
ALTER TABLE `program_kursus`
  ADD PRIMARY KEY (`id_program`);

--
-- Indexes for table `progres_materi`
--
ALTER TABLE `progres_materi`
  ADD PRIMARY KEY (`id_progres`),
  ADD KEY `id_pendaftaran` (`id_pendaftaran`),
  ADD KEY `id_materi` (`id_materi`);

--
-- Indexes for table `quiz`
--
ALTER TABLE `quiz`
  ADD PRIMARY KEY (`id_quiz`),
  ADD KEY `idx_quiz_kursus` (`id_kursus`),
  ADD KEY `idx_quiz_modul` (`id_modul`);

--
-- Indexes for table `quiz_hasil`
--
ALTER TABLE `quiz_hasil`
  ADD PRIMARY KEY (`id_quiz_hasil`),
  ADD KEY `idx_hasil_quiz` (`id_quiz`),
  ADD KEY `idx_hasil_pendaftaran` (`id_pendaftaran`),
  ADD KEY `idx_hasil_siswa` (`id_siswa`),
  ADD KEY `idx_hasil_lulus` (`is_lulus`),
  ADD KEY `idx_hasil_created` (`created_at`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id_review`),
  ADD UNIQUE KEY `id_pendaftaran` (`id_pendaftaran`),
  ADD KEY `idx_kursus` (`id_kursus`,`rating_overall`),
  ADD KEY `idx_visible` (`is_visible`,`created_at`);

--
-- Indexes for table `saran`
--
ALTER TABLE `saran`
  ADD PRIMARY KEY (`id_saran`);

--
-- Indexes for table `sertifikat`
--
ALTER TABLE `sertifikat`
  ADD PRIMARY KEY (`id_sertifikat`),
  ADD UNIQUE KEY `id_pendaftaran` (`id_pendaftaran`),
  ADD UNIQUE KEY `nomor_sertifikat` (`nomor_sertifikat`),
  ADD KEY `idx_pendaftaran` (`id_pendaftaran`),
  ADD KEY `idx_nomor` (`nomor_sertifikat`),
  ADD KEY `idx_siswa` (`id_siswa`),
  ADD KEY `idx_verify` (`qr_code`,`verification_url`);

--
-- Indexes for table `setting_web`
--
ALTER TABLE `setting_web`
  ADD PRIMARY KEY (`id_setting`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id_siswa`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `slider_promo`
--
ALTER TABLE `slider_promo`
  ADD PRIMARY KEY (`id_slider`);

--
-- Indexes for table `slider_web`
--
ALTER TABLE `slider_web`
  ADD PRIMARY KEY (`id_slider`);

--
-- Indexes for table `stats`
--
ALTER TABLE `stats`
  ADD PRIMARY KEY (`id_stats`);

--
-- Indexes for table `superadmin`
--
ALTER TABLE `superadmin`
  ADD PRIMARY KEY (`id_superadmin`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `tugas`
--
ALTER TABLE `tugas`
  ADD PRIMARY KEY (`id_tugas`),
  ADD KEY `idx_kursus` (`id_kursus`),
  ADD KEY `idx_deadline` (`deadline`);

--
-- Indexes for table `uji_kompetensi`
--
ALTER TABLE `uji_kompetensi`
  ADD PRIMARY KEY (`id_uji_kompetensi`);

--
-- Indexes for table `visi_misi`
--
ALTER TABLE `visi_misi`
  ADD PRIMARY KEY (`id_visimisi`),
  ADD KEY `idx_visimisi_jenis` (`jenis`),
  ADD KEY `idx_visimisi_status` (`status`),
  ADD KEY `idx_visimisi_urutan` (`urutan`),
  ADD KEY `idx_visimisi_deleted` (`deleted_at`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alumni`
--
ALTER TABLE `alumni`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `bank`
--
ALTER TABLE `bank`
  MODIFY `id_bank` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `banner_program`
--
ALTER TABLE `banner_program`
  MODIFY `id_banner` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `detail_kursus`
--
ALTER TABLE `detail_kursus`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `diskusi`
--
ALTER TABLE `diskusi`
  MODIFY `id_diskusi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `instruktur`
--
ALTER TABLE `instruktur`
  MODIFY `id_instruktur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id_simpan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `karyawan`
--
ALTER TABLE `karyawan`
  MODIFY `id_karyawan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `keranjang`
--
ALTER TABLE `keranjang`
  MODIFY `id_keranjang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `kursus`
--
ALTER TABLE `kursus`
  MODIFY `id_kursus` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `lulusan`
--
ALTER TABLE `lulusan`
  MODIFY `id_lulusan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `manajemen`
--
ALTER TABLE `manajemen`
  MODIFY `id_manajemen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `materi`
--
ALTER TABLE `materi`
  MODIFY `id_materi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=157;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mitra_kerja`
--
ALTER TABLE `mitra_kerja`
  MODIFY `id_mitra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `modul`
--
ALTER TABLE `modul`
  MODIFY `id_modul` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `paket_kursus`
--
ALTER TABLE `paket_kursus`
  MODIFY `id_paket` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  MODIFY `id_pendaftaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `pengumpulan_tugas`
--
ALTER TABLE `pengumpulan_tugas`
  MODIFY `id_kumpul` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `postingan`
--
ALTER TABLE `postingan`
  MODIFY `id_postingan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `profil_lpk`
--
ALTER TABLE `profil_lpk`
  MODIFY `id_profil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `program_kursus`
--
ALTER TABLE `program_kursus`
  MODIFY `id_program` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `progres_materi`
--
ALTER TABLE `progres_materi`
  MODIFY `id_progres` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `quiz`
--
ALTER TABLE `quiz`
  MODIFY `id_quiz` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `quiz_hasil`
--
ALTER TABLE `quiz_hasil`
  MODIFY `id_quiz_hasil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `id_review` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `saran`
--
ALTER TABLE `saran`
  MODIFY `id_saran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `sertifikat`
--
ALTER TABLE `sertifikat`
  MODIFY `id_sertifikat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `setting_web`
--
ALTER TABLE `setting_web`
  MODIFY `id_setting` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id_siswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `slider_promo`
--
ALTER TABLE `slider_promo`
  MODIFY `id_slider` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `slider_web`
--
ALTER TABLE `slider_web`
  MODIFY `id_slider` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `stats`
--
ALTER TABLE `stats`
  MODIFY `id_stats` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `superadmin`
--
ALTER TABLE `superadmin`
  MODIFY `id_superadmin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tugas`
--
ALTER TABLE `tugas`
  MODIFY `id_tugas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `uji_kompetensi`
--
ALTER TABLE `uji_kompetensi`
  MODIFY `id_uji_kompetensi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `visi_misi`
--
ALTER TABLE `visi_misi`
  MODIFY `id_visimisi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
