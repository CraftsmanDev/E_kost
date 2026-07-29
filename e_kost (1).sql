-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 28 Jul 2026 pada 15.39
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `e_kost`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `aturan_kost`
--

CREATE TABLE `aturan_kost` (
  `id_aturan` int(11) NOT NULL,
  `nama_aturan` varchar(255) DEFAULT NULL,
  `deskripsi_aturan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `aturan_kost`
--

INSERT INTO `aturan_kost` (`id_aturan`, `nama_aturan`, `deskripsi_aturan`) VALUES
(1, 'kost hanya khusus karyawan putra', 'Kost ini merupakan hunian yang dikhususkan bagi karyawan putra yang mengutamakan kenyamanan, keamanan, dan ketertiban'),
(13, 'Dilarang Masuk Kamar Lawan Jenis', 'Penghuni dilarang memasuki kamar lawan jenis. Pengecualian hanya berlaku bagi pasangan suami istri (pasutri)'),
(14, 'khusus karyawan putra', 'Kost ini diperuntukkan khusus bagi penyewa laki-laki yang berstatus sebagai karyawan.'),
(15, 'saling menjaga kenyamanan', 'Setiap penghuni wajib saling menghormati, menjaga sopan santun, serta menciptakan lingkungan kost yang aman, nyaman, dan kondusif bagi seluruh penghuni.'),
(16, 'Wajib Menjaga kebersihan', 'Setiap penghuni wajib menjaga kebersihan kamar, kamar mandi, dapur, serta seluruh area bersama. Sampah harus dibuang pada tempatnya dan kebersihan lingkungan kost harus selalu dijaga demi menciptakan suasana yang nyaman, sehat, dan kondusif bagi seluruh penghuni.'),
(17, 'kehilangan barang', 'Setiap penghuni bertanggung jawab atas keamanan barang pribadi masing-masing. Pengelola kost tidak bertanggung jawab atas kehilangan, kerusakan, atau tindak pencurian terhadap barang milik penghuni. Oleh karena itu, penghuni diimbau untuk selalu mengunci kamar dan menjaga barang berharga dengan baik.'),
(18, 'dilarang membawa obat terlarang', 'Penghuni dilarang memiliki, membawa, menggunakan, maupun mengedarkan narkotika, psikotropika, obat-obatan terlarang, dan zat adiktif lainnya di lingkungan kost. Pelanggaran terhadap aturan ini dapat dikenakan sanksi sesuai ketentuan yang berlaku.'),
(19, 'Wajib Menutup Kembali Gerbang', 'Setiap penghuni wajib menutup dan memastikan gerbang telah terkunci atau tertutup kembali setelah membuka gerbang. Hal ini bertujuan untuk menjaga keamanan dan ketertiban lingkungan kost.'),
(20, 'pembayaran uang kost tepat waktu', 'Penyewa membayar uang kost sesuai dengan waktu pembayaran yang telah ditentukan.'),
(21, 'tamu wajib patuhi jam berkunjung', 'etiap tamu wajib mengikuti jam berkunjung yang telah ditetapkan oleh pihak pe');

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_aturan_kost`
--

CREATE TABLE `detail_aturan_kost` (
  `id_detail` int(11) NOT NULL,
  `id_kost` int(11) NOT NULL,
  `id_aturan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `detail_aturan_kost`
--

INSERT INTO `detail_aturan_kost` (`id_detail`, `id_kost`, `id_aturan`) VALUES
(17, 15, 1),
(18, 15, 13),
(19, 15, 14),
(20, 15, 15),
(21, 16, 15),
(22, 16, 16),
(23, 16, 17),
(24, 17, 13),
(25, 17, 15),
(26, 17, 16),
(27, 17, 18),
(28, 18, 13),
(29, 18, 16),
(30, 18, 19),
(31, 19, 13),
(32, 19, 15),
(33, 19, 16),
(49, 20, 15),
(50, 20, 16),
(51, 20, 18),
(52, 20, 20),
(53, 20, 21),
(54, 21, 15),
(55, 21, 16),
(56, 21, 18),
(57, 21, 20),
(58, 21, 21),
(67, 22, 15),
(68, 22, 16);

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_fasilitas_kost`
--

CREATE TABLE `detail_fasilitas_kost` (
  `id_detail` int(11) NOT NULL,
  `id_kost` int(11) NOT NULL,
  `id_fasilitas_kost` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `detail_fasilitas_kost`
--

INSERT INTO `detail_fasilitas_kost` (`id_detail`, `id_kost`, `id_fasilitas_kost`) VALUES
(19, 15, 1),
(20, 15, 13),
(21, 15, 14),
(22, 15, 15),
(23, 15, 16),
(24, 16, 1),
(25, 16, 13),
(26, 16, 14),
(27, 16, 15),
(28, 17, 13),
(29, 17, 14),
(30, 17, 15),
(31, 17, 17),
(32, 18, 1),
(33, 18, 13),
(34, 18, 14),
(35, 18, 15),
(36, 19, 14),
(37, 19, 17),
(56, 20, 1),
(57, 20, 13),
(58, 20, 14),
(59, 20, 15),
(60, 20, 16),
(61, 20, 18),
(62, 21, 1),
(63, 21, 13),
(64, 21, 14),
(65, 21, 15),
(66, 21, 19),
(83, 22, 1),
(84, 22, 13),
(85, 22, 14),
(86, 22, 15);

-- --------------------------------------------------------

--
-- Struktur dari tabel `fasilitas_kamar`
--

CREATE TABLE `fasilitas_kamar` (
  `id_fasilitas_kamar` int(11) NOT NULL,
  `nama_fasilitas` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `fasilitas_kamar`
--

INSERT INTO `fasilitas_kamar` (`id_fasilitas_kamar`, `nama_fasilitas`, `deskripsi`) VALUES
(15, 'Kasur, Lemari, Set Meja, AC, Kamar Mandi Dalam', 'Kamar dilengkapi dengan kasur yang nyaman, lemari pakaian, set meja untuk belajar atau bekerja, AC yang menjaga ruangan tetap sejuk, serta kamar mandi dalam untuk memberikan kenyamanan dan privasi bagi penghuni.'),
(16, 'kasur, lemari', 'Setiap kamar telah dilengkapi dengan kasur yang nyaman untuk beristirahat serta lemari pakaian yang dapat digunakan untuk menyimpan pakaian dan barang pribadi. Fasilitas ini disediakan untuk menunjang kenyamanan, kerapian, dan kebutuhan penghuni selama masa tinggal.'),
(17, 'kasur, lemari, meja, kamar mandi dalam', '**Kasur, Lemari, Meja, dan Kamar Mandi Dalam**  Setiap kamar dilengkapi dengan kasur yang nyaman, lemari untuk menyimpan pakaian dan barang pribadi, meja untuk menunjang aktivitas penghuni, serta kamar mandi dalam untuk memberikan kenyamanan dan privasi selama tinggal di kost.'),
(18, 'kasur, AC, kamar mandi,', 'Setiap kamar dilengkapi dengan kasur yang nyaman untuk beristirahat, AC untuk menjaga suhu ruangan tetap sejuk, serta kamar mandi yang dapat digunakan untuk memenuhi kebutuhan penghuni selama tinggal di kost.'),
(19, 'kasur, kipas, kamar mandi dalam', 'Setiap kamar dilengkapi dengan kasur yang nyaman untuk beristirahat, kipas untuk membantu menjaga sirkulasi udara dan kesejukan ruangan, serta kamar mandi dalam yang memberikan kenyamanan dan privasi bagi penghuni.'),
(20, 'tempat tidur, lemari pakaian, meja belajar, kursi, kipas angin, stop kontak.', 'Setiap kamar telah dilengkapi dengan berbagai fasilitas untuk menunjang kenyamanan penghuni, seperti tempat tidur, lemari pakaian, meja belajar, kursi, kipas angin, dan stop kontak.'),
(21, 'tempat tidur, lemari pakaian, meja belajar, stop kontak, listrik, ac', 'Kamar dilengkapi dengan fasilitas yang menunjang kenyamanan penghuni, seperti tempat tidur, lemari pakaian, meja belajar, stop kontak, listrik, dan AC.');

-- --------------------------------------------------------

--
-- Struktur dari tabel `fasilitas_kost`
--

CREATE TABLE `fasilitas_kost` (
  `id_fasilitas_kost` int(11) NOT NULL,
  `nama_fasilitas` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `fasilitas_kost`
--

INSERT INTO `fasilitas_kost` (`id_fasilitas_kost`, `nama_fasilitas`, `deskripsi`) VALUES
(1, 'garasi', 'kost sangat strategis 3 menit keterminal pusat kota dekat alfamaret dan UMKM 5 menit pasar mimba\'an'),
(13, 'Dapur', 'Dapur bersama yang dapat digunakan oleh seluruh penghuni untuk memasak dan menyiapkan makanan, dilengkapi dengan area memasak yang bersih dan nyaman.'),
(14, 'Jemuran', 'Area khusus untuk menjemur pakaian yang aman, bersih, dan mendapatkan sinar matahari yang cukup sehingga pakaian cepat kering.'),
(15, 'Wifi', 'Akses internet WiFi yang tersedia bagi seluruh penghuni dengan koneksi yang stabil untuk belajar, bekerja, maupun hiburan.'),
(16, 'PDAM', 'Pasokan air bersih dari PDAM yang tersedia selama 24 jam untuk memenuhi kebutuhan sehari-hari penghuni.'),
(17, 'parkiran', 'Area parkir yang luas, aman, dan nyaman untuk kendaraan penghuni, sehingga memudahkan parkir motor maupun mobil.'),
(18, 'ruang tamu', 'Ruang tamu digunakan sesuai dengan peruntukannya serta tetap menjaga kebersihan dan ketertiban.'),
(19, 'kamar mandi umum', 'Kamar mandi umum disediakan untuk digunakan bersama oleh seluruh penghuni kost dengan tetap menjaga kebersihan dan kenyamanan.');

-- --------------------------------------------------------

--
-- Struktur dari tabel `galeri_kost`
--

CREATE TABLE `galeri_kost` (
  `id_foto` int(11) NOT NULL,
  `id_kost` int(11) NOT NULL,
  `nama_file` varchar(255) NOT NULL,
  `urutan` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `galeri_kost`
--

INSERT INTO `galeri_kost` (`id_foto`, `id_kost`, `nama_file`, `urutan`, `created_at`) VALUES
(19, 19, '1784961485_8dd81f1dc5700d56d47f.jpg', 7, '2026-07-25 13:38:05'),
(20, 19, '1784961485_2e8d79dea5028978f6f0.jpg', 8, '2026-07-25 13:38:05'),
(21, 20, '1785237237_1732714e8fdc66ab2236.jpg', 0, '2026-07-28 18:13:57'),
(22, 20, '1785237237_3f9c0506e3d9bb034f2c.jpg', 1, '2026-07-28 18:13:57'),
(23, 20, '1785237237_2c23d9da93794aa0be53.jpg', 2, '2026-07-28 18:13:57'),
(24, 20, '1785237237_65b7477a08e9ca5fe746.jpg', 3, '2026-07-28 18:13:57'),
(25, 21, '1785240953_6f636605ee5c1e5f24f3.jpg', 0, '2026-07-28 19:15:53'),
(26, 21, '1785240953_6692f718b5f15b350028.jpg', 1, '2026-07-28 19:15:53'),
(27, 21, '1785240953_c578d57f918e10c7a822.jpg', 2, '2026-07-28 19:15:53'),
(28, 21, '1785240953_d19db7f8960c88aa7449.jpg', 3, '2026-07-28 19:15:53'),
(29, 21, '1785240953_70b1e273655ac77e6c33.jpg', 4, '2026-07-28 19:15:53'),
(30, 21, '1785240953_0f5cae1daf27c69c53dd.jpg', 5, '2026-07-28 19:15:53'),
(31, 21, '1785240953_99a2c8c3a0a18b704ec5.jpg', 6, '2026-07-28 19:15:53'),
(32, 21, '1785240953_afad1b5cce55838c8637.jpg', 7, '2026-07-28 19:15:53'),
(33, 21, '1785240953_c6e9300cb4b5a00134e0.jpg', 8, '2026-07-28 19:15:53'),
(34, 21, '1785240953_714856e554c268457c09.jpg', 9, '2026-07-28 19:15:53'),
(67, 22, '1785244819_3dd6fdfadea56744437a.jpg', 0, '2026-07-28 20:20:19'),
(68, 22, '1785244819_222fa98f7468cf611ee0.jpg', 1, '2026-07-28 20:20:19'),
(69, 22, '1785244819_ee49bc5b274ac448b4d6.jpg', 2, '2026-07-28 20:20:19'),
(70, 22, '1785244819_13417288169aa94af771.jpg', 3, '2026-07-28 20:20:19'),
(71, 22, '1785244819_5c229c2f77a83c565cbc.jpg', 4, '2026-07-28 20:20:19'),
(72, 22, '1785244819_56870fa5207220aea3ec.jpg', 5, '2026-07-28 20:20:19'),
(73, 15, '1784548117_aaf0da6040bf5f19ae4b.jpg', 0, '2026-07-28 20:20:19'),
(74, 16, '1784551253_86e37340aa64b483f509.jpg', 0, '2026-07-28 20:20:19'),
(75, 17, 'default.png', 0, '2026-07-28 20:20:19'),
(76, 18, '1784960522_35aa71de8e267430e461.png', 0, '2026-07-28 20:20:19'),
(77, 19, '1784961484_12e0998ca0af1787ea08.jpg', 0, '2026-07-28 20:20:19');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kamar`
--

CREATE TABLE `kamar` (
  `id_kamar` int(11) NOT NULL,
  `id_kost` int(11) DEFAULT NULL,
  `id_tipe_kamar` int(11) DEFAULT NULL,
  `id_fasilitas_kamar` int(11) DEFAULT NULL,
  `harga_sewa` int(11) DEFAULT NULL,
  `status_ketersediaan` enum('Tersedia','Terisi','Dipesan') DEFAULT 'Tersedia',
  `nomor_kamar` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kamar`
--

INSERT INTO `kamar` (`id_kamar`, `id_kost`, `id_tipe_kamar`, `id_fasilitas_kamar`, `harga_sewa`, `status_ketersediaan`, `nomor_kamar`) VALUES
(30, 15, 1, 15, 800000, 'Tersedia', 'A1'),
(31, 17, 2, 16, 400000, 'Tersedia', 'A1'),
(32, 18, 1, 15, 800, 'Tersedia', 'A1'),
(33, 18, 2, 17, 550, 'Tersedia', 'A2'),
(34, 19, 1, 18, 800, 'Tersedia', 'A1'),
(35, 19, 2, 19, 500, 'Terisi', 'A2'),
(36, 20, 2, 20, 500, 'Terisi', 'A1'),
(37, 21, 1, 21, 800, 'Tersedia', 'A1'),
(38, 21, 2, 20, 500, 'Terisi', 'A2'),
(39, 22, 2, 17, 500, 'Tersedia', 'A1 ');

-- --------------------------------------------------------

--
-- Struktur dari tabel `konsumen`
--

CREATE TABLE `konsumen` (
  `id_konsumen` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `alamat` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `konsumen`
--

INSERT INTO `konsumen` (`id_konsumen`, `id_user`, `alamat`) VALUES
(5, 7, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kost`
--

CREATE TABLE `kost` (
  `id_kost` int(11) NOT NULL,
  `id_pemilik` int(11) DEFAULT NULL,
  `nama_kost` varchar(100) DEFAULT NULL,
  `alamat_kost` text DEFAULT NULL,
  `lokasi_kost` varchar(255) DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `foto_kost` varchar(255) DEFAULT NULL,
  `type_kost` enum('PUTRA','PUTRI','CAMPUR','') NOT NULL,
  `total_kamar` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kost`
--

INSERT INTO `kost` (`id_kost`, `id_pemilik`, `nama_kost`, `alamat_kost`, `lokasi_kost`, `latitude`, `longitude`, `foto_kost`, `type_kost`, `total_kamar`) VALUES
(15, 1, 'Kost Reagan', 'mimbaan barat, mimbaan panji situbondo', 'Mimbaan, Panji, Situbondo', -7.77411200, 114.14210500, '1784548117_aaf0da6040bf5f19ae4b.jpg', 'PUTRA', 10),
(16, 2, 'Mr Kost', 'jln argopuro No RT 03 RW 03 Mimba\'an barat, mimbaan kabupaten situbondo jawa timur', 'jln argopuro No RT 03 RW 03 Mimba\'an barat, mimbaan kabupaten situbondo jawa timur', -7.70457600, 114.01419100, '1784551253_86e37340aa64b483f509.jpg', 'CAMPUR', 15),
(17, 3, 'kost argopuro', 'jl.argopuro no.88, mimbaan barat, mimbaan, kec panji, kab situbondo, jawa timur 68323', 'mimbaan barat, kab situbondo, jawa timur', -7.70385600, 114.01464800, 'default.png', 'PUTRI', 10),
(18, 4, 'sumber barokah II', 'jl semeru no 19 mimbaan tengah, mimbaan, kec panji, kab situbondo, jawa timur 68323', 'mimbaan, kab situbondo, jawa timur', -7.70626100, 114.01800500, '1784960522_35aa71de8e267430e461.png', 'PUTRI', 14),
(19, 5, 'kost mas ghofur', 'jl argopuro gang v no 27 mimbaan tengah, mimbaan kec situbondo kab situbondo, jawa timur 68322', 'mimbaan tengah, situbondo, jawa timur', -7.70686140, 114.01520460, '1784961484_12e0998ca0af1787ea08.jpg', 'PUTRA', 13),
(20, 6, 'kost Buk Warto', 'jl argopuro no 102 mimbaan tengah kelurahan mimbaan kec panji kab situbondo jawa timur 68322', 'mimbaan tengah kab situbondo jawa timur', -7.71075540, 114.01518860, '1785237237_1732714e8fdc66ab2236.jpg', 'CAMPUR', 12),
(21, 7, 'kost putra aditya', 'jl argopuro, mimbaan barat, kelurahan mimbaan, kec panji, kabupaten situbondo jawa timur 68323', 'mimbaan barat, kec panji, situbondo', -7.70600000, 114.01240000, '1785240953_6f636605ee5c1e5f24f3.jpg', 'PUTRA', 12),
(22, 8, 'kost warung maju', 'jl semeru no 156, mimbaan tengah, mimbaan, kec panji kab situbondo, jawa timur 68322', 'mimbaan tengah, kab situbondo, jawa timur', -7.77428500, 114.14204400, '1785244819_3dd6fdfadea56744437a.jpg', 'CAMPUR', 17);

-- --------------------------------------------------------

--
-- Struktur dari tabel `notifikasi`
--

CREATE TABLE `notifikasi` (
  `id_notifikasi` int(11) UNSIGNED NOT NULL,
  `id_user` int(11) UNSIGNED DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL,
  `id_pemilik` int(11) UNSIGNED DEFAULT NULL,
  `judul` varchar(255) NOT NULL,
  `pesan` text NOT NULL,
  `tipe` varchar(50) NOT NULL DEFAULT 'info',
  `link` varchar(255) DEFAULT NULL,
  `status_baca` tinyint(1) NOT NULL DEFAULT 0,
  `data_terkait` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`data_terkait`)),
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `notifikasi`
--

INSERT INTO `notifikasi` (`id_notifikasi`, `id_user`, `role`, `id_pemilik`, `judul`, `pesan`, `tipe`, `link`, `status_baca`, `data_terkait`, `created_at`) VALUES
(42, NULL, 'admin', NULL, 'Pengguna Baru Terdaftar', 'Pengguna baru \'mila\' telah mendaftar di sistem.', 'user', 'dashboard/pengguna', 1, '{\"id_user\":7,\"nama\":\"mila\"}', '2026-07-27 16:47:22'),
(43, NULL, 'admin', NULL, 'Pengguna Baru Terdaftar', 'Pengguna baru \'warto wahyuni\' telah mendaftar di sistem.', 'user', 'dashboard/pengguna', 1, '{\"id_user\":8,\"nama\":\"warto wahyuni\"}', '2026-07-28 07:48:37'),
(44, NULL, 'admin', NULL, 'Pengguna Baru Terdaftar', 'Pengguna baru \'aditya\' telah mendaftar di sistem.', 'user', 'dashboard/pengguna', 1, '{\"id_user\":9,\"nama\":\"aditya\"}', '2026-07-28 11:23:28'),
(45, NULL, 'admin', NULL, 'Pengguna Baru Terdaftar', 'Pengguna baru \'suliswati\' telah mendaftar di sistem.', 'user', 'dashboard/pengguna', 0, '{\"id_user\":10,\"nama\":\"suliswati\"}', '2026-07-28 12:45:08');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int(11) NOT NULL,
  `id_pemesanan` int(11) DEFAULT NULL,
  `tanggal_pembayaran` date DEFAULT NULL,
  `jumlah_pembayaran` int(11) DEFAULT NULL,
  `bukti_pembayaran` varchar(255) DEFAULT NULL,
  `status_pembayaran` enum('Disetujui','Ditolak','Menunggu','') DEFAULT 'Menunggu'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemesanan`
--

CREATE TABLE `pemesanan` (
  `id_pemesanan` int(11) NOT NULL,
  `id_konsumen` int(11) DEFAULT NULL,
  `id_kost` int(11) DEFAULT NULL,
  `id_kamar` int(11) NOT NULL,
  `tanggal_pemesanan` date DEFAULT NULL,
  `status_pemesanan` enum('Disetujui','Ditolak','Menunggu','Berhenti_Sewa') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemilik_kost`
--

CREATE TABLE `pemilik_kost` (
  `id_pemilik` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `alamat` text DEFAULT NULL,
  `nama_bank` varchar(50) DEFAULT NULL,
  `nomor_rekening` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pemilik_kost`
--

INSERT INTO `pemilik_kost` (`id_pemilik`, `id_user`, `alamat`, `nama_bank`, `nomor_rekening`) VALUES
(1, 2, 'mimbaan barat kabupaten situbondo jawa timur', 'BRI', '009001029043533'),
(2, 3, 'jln argopuro No RT 03 RW 03 Mimba\'an barat, mimbaan kabupaten situbondo jawa timur', 'Seabank', '901241403046'),
(3, 4, 'jl argopuro, No.88 Mimbaan Barat, Mimbaan keb Panji, mimbaan, Kabupaten Situbondo, Jawa Timur', 'BCA', '1210721106'),
(4, 5, 'jl semeru no 19 mimbaan tengah, mimbaan, kec panji, kab situbondo, jawa timur 68323', 'BRI', '009001-093992502'),
(5, 6, 'jl argopuro gang v no 27 mimbaan tengah, mimbaan kec situbondo kab situbondo, jawa timur 68322', 'BCA', '1210695091'),
(6, 8, 'jl argopuro no 102 mimbaan tengah kelurahan mimbaan kec panji kab situbondo jawa timur 68322', 'BNI', '821848572'),
(7, 9, 'jl argopuro, mimbaan barat kelurahan mimbaan, kecamatan panji, kabupaten situbondo jawa timur 68323', 'Seabank', '901146401798'),
(8, 10, 'jl semeru no 156, mimbaan tengah, mimbaan, kec panji kab situbondo, jawa timur 68322', 'Mandiri', '1400020235108');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengajuan_berhenti_sewa`
--

CREATE TABLE `pengajuan_berhenti_sewa` (
  `id_pengajuan` int(11) NOT NULL,
  `id_pemesanan` int(11) NOT NULL,
  `id_konsumen` int(11) NOT NULL,
  `id_kost` int(11) NOT NULL,
  `id_kamar` int(11) NOT NULL,
  `tanggal_pengajuan` date NOT NULL,
  `tanggal_berhenti` date NOT NULL,
  `alasan` text DEFAULT NULL,
  `status_pengajuan` enum('Menunggu','Disetujui','Ditolak') DEFAULT 'Menunggu',
  `catatan_admin` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tipe_kamar`
--

CREATE TABLE `tipe_kamar` (
  `id_tipe_kamar` int(11) NOT NULL,
  `nama_tipe_kamar` varchar(100) DEFAULT NULL,
  `deskripsi_type` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tipe_kamar`
--

INSERT INTO `tipe_kamar` (`id_tipe_kamar`, `nama_tipe_kamar`, `deskripsi_type`) VALUES
(1, 'VIP', 'Kamar VIP dengan ukuran yang lebih luas dan fasilitas premium, dirancang untuk memberikan kenyamanan maksimal bagi penghuni selama masa sewa.'),
(2, 'standar', 'Kamar Standard menawarkan fasilitas dasar yang lengkap, cocok bagi penghuni yang mengutamakan kenyamanan dan efisiensi.');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `no_hp` varchar(15) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `status` enum('Aktif','Nonaktif') DEFAULT 'Nonaktif',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_user`, `role_id`, `nama`, `username`, `password`, `no_hp`, `foto`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'jihan', 'jihan', '$2y$10$lUyB3Q5sNtO3aE0NVcKIv.xWQOthACTZgvOpIhX0vaNit41ZKbRiy', NULL, '', 'Aktif', '2026-06-25 19:22:28', '2026-07-01 10:50:10'),
(2, 2, 'Diyah fauziah ulfa', 'Diyah', '$2y$10$2xPePtOayTcuWm6xwBNoCOEvT/Cystof8saBulsyz2eYFwiigTqYW', '081252550055', NULL, 'Aktif', '2026-07-20 03:07:33', '2026-07-20 04:46:36'),
(3, 2, 'Ratna Farida Wati', 'Ratna', '$2y$10$g3zL7iI2H67IU55gK0c5i.v3dlwdNea821QZvFiwk4g5i96g0ZXOS', '085259399966', NULL, 'Aktif', '2026-07-20 05:21:35', '2026-07-20 05:25:51'),
(4, 2, 'sri berlianti ', 'berlianti', '$2y$10$cqQUHzwBZi3vRE.HHKLXI.FPnXatnK45VOWwYlpU9OOoMbO1E3KHi', '085236746265', NULL, 'Aktif', '2026-07-20 05:46:32', '2026-07-20 05:55:02'),
(5, 2, 'nur imamah', 'imamah', '$2y$10$gzl6F1xIwbyfIQ6cBANYVe4L4Y6BkT/RWgEzIV2QPvC1Vj8RQO3Xm', '081929773812', NULL, 'Aktif', '2026-07-24 23:01:05', '2026-07-24 23:03:56'),
(6, 2, 'muhammad ghofur', 'muhammad', '$2y$10$8O3CoLIPAeGfPuPbl3nWe.hIjcNmLl29Wp0ZsZsRilVKukeNFf0E2', '085334008484', NULL, 'Aktif', '2026-07-24 23:28:53', '2026-07-24 23:32:10'),
(7, 3, 'mila', 'mila', '$2y$10$8msojekTELAk2ffQAPvNb.yA3oWXLVD/d5cF70dpT.hq6PtHzQ1hK', '098765432123', NULL, 'Aktif', '2026-07-27 09:47:22', '2026-07-27 09:47:57'),
(8, 2, 'warto wahyuni', 'warto', '$2y$10$YzJwEi9ldIo0QClBGPQcuOLNGaDczX.RvKcd35a2OD9XfbNEZoW4i', '082308232264', NULL, 'Aktif', '2026-07-28 00:48:37', '2026-07-28 00:51:45'),
(9, 2, 'aditya', 'aditya', '$2y$10$mlRHoWb96GevatTeSzhlwuxLL1hh9IFKY6HgJIryBTVfrym/5glZe', '081234553121', NULL, 'Aktif', '2026-07-28 04:23:28', '2026-07-28 04:42:57'),
(10, 2, 'suliswati', 'suliswati', '$2y$10$S3HZgXUrB7nIQ0.K7HBEuuhc15OABDmwMlxqxTkQjkjEZnczhWiXq', '081259120658', NULL, 'Aktif', '2026-07-28 05:45:08', '2026-07-28 05:47:23');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_role`
--

CREATE TABLE `user_role` (
  `role_id` int(11) NOT NULL,
  `role` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user_role`
--

INSERT INTO `user_role` (`role_id`, `role`) VALUES
(1, 'admin'),
(2, 'pemilik'),
(3, 'konsumen');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `aturan_kost`
--
ALTER TABLE `aturan_kost`
  ADD PRIMARY KEY (`id_aturan`);

--
-- Indeks untuk tabel `detail_aturan_kost`
--
ALTER TABLE `detail_aturan_kost`
  ADD PRIMARY KEY (`id_detail`),
  ADD UNIQUE KEY `id_kost` (`id_kost`,`id_aturan`),
  ADD KEY `detail_aturan_kost_ibfk_2` (`id_aturan`);

--
-- Indeks untuk tabel `detail_fasilitas_kost`
--
ALTER TABLE `detail_fasilitas_kost`
  ADD PRIMARY KEY (`id_detail`),
  ADD UNIQUE KEY `id_kost` (`id_kost`,`id_fasilitas_kost`),
  ADD KEY `detail_fasilitas_kost_ibfk_2` (`id_fasilitas_kost`);

--
-- Indeks untuk tabel `fasilitas_kamar`
--
ALTER TABLE `fasilitas_kamar`
  ADD PRIMARY KEY (`id_fasilitas_kamar`);

--
-- Indeks untuk tabel `fasilitas_kost`
--
ALTER TABLE `fasilitas_kost`
  ADD PRIMARY KEY (`id_fasilitas_kost`);

--
-- Indeks untuk tabel `galeri_kost`
--
ALTER TABLE `galeri_kost`
  ADD PRIMARY KEY (`id_foto`),
  ADD KEY `id_kost` (`id_kost`);

--
-- Indeks untuk tabel `kamar`
--
ALTER TABLE `kamar`
  ADD PRIMARY KEY (`id_kamar`),
  ADD KEY `kamar_ibfk_1` (`id_kost`),
  ADD KEY `kamar_ibfk_2` (`id_tipe_kamar`),
  ADD KEY `kamar_ibfk_3` (`id_fasilitas_kamar`);

--
-- Indeks untuk tabel `konsumen`
--
ALTER TABLE `konsumen`
  ADD PRIMARY KEY (`id_konsumen`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `kost`
--
ALTER TABLE `kost`
  ADD PRIMARY KEY (`id_kost`),
  ADD KEY `kost_ibfk_4` (`id_pemilik`);

--
-- Indeks untuk tabel `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD PRIMARY KEY (`id_notifikasi`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_pemilik` (`id_pemilik`),
  ADD KEY `role` (`role`),
  ADD KEY `status_baca` (`status_baca`);

--
-- Indeks untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD KEY `pembayaran_ibfk_1` (`id_pemesanan`);

--
-- Indeks untuk tabel `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD PRIMARY KEY (`id_pemesanan`),
  ADD KEY `id_kost` (`id_kost`),
  ADD KEY `fk_pemesanan_konsumen` (`id_konsumen`),
  ADD KEY `fk_pemesanan_kamar` (`id_kamar`);

--
-- Indeks untuk tabel `pemilik_kost`
--
ALTER TABLE `pemilik_kost`
  ADD PRIMARY KEY (`id_pemilik`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `pengajuan_berhenti_sewa`
--
ALTER TABLE `pengajuan_berhenti_sewa`
  ADD PRIMARY KEY (`id_pengajuan`),
  ADD KEY `fk_pengajuan_pemesanan` (`id_pemesanan`),
  ADD KEY `fk_pengajuan_kost` (`id_kost`),
  ADD KEY `kost_ibfk_users` (`id_konsumen`),
  ADD KEY `kamar_ibfk` (`id_kamar`);

--
-- Indeks untuk tabel `tipe_kamar`
--
ALTER TABLE `tipe_kamar`
  ADD PRIMARY KEY (`id_tipe_kamar`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `fk_users_role` (`role_id`);

--
-- Indeks untuk tabel `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`role_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `aturan_kost`
--
ALTER TABLE `aturan_kost`
  MODIFY `id_aturan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `detail_aturan_kost`
--
ALTER TABLE `detail_aturan_kost`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT untuk tabel `detail_fasilitas_kost`
--
ALTER TABLE `detail_fasilitas_kost`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT untuk tabel `fasilitas_kamar`
--
ALTER TABLE `fasilitas_kamar`
  MODIFY `id_fasilitas_kamar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `fasilitas_kost`
--
ALTER TABLE `fasilitas_kost`
  MODIFY `id_fasilitas_kost` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `galeri_kost`
--
ALTER TABLE `galeri_kost`
  MODIFY `id_foto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT untuk tabel `kamar`
--
ALTER TABLE `kamar`
  MODIFY `id_kamar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT untuk tabel `konsumen`
--
ALTER TABLE `konsumen`
  MODIFY `id_konsumen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `kost`
--
ALTER TABLE `kost`
  MODIFY `id_kost` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `notifikasi`
--
ALTER TABLE `notifikasi`
  MODIFY `id_notifikasi` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT untuk tabel `pemilik_kost`
--
ALTER TABLE `pemilik_kost`
  MODIFY `id_pemilik` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `tipe_kamar`
--
ALTER TABLE `tipe_kamar`
  MODIFY `id_tipe_kamar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `user_role`
--
ALTER TABLE `user_role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `galeri_kost`
--
ALTER TABLE `galeri_kost`
  ADD CONSTRAINT `fk_kost` FOREIGN KEY (`id_kost`) REFERENCES `kost` (`id_kost`);

--
-- Ketidakleluasaan untuk tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_role` FOREIGN KEY (`role_id`) REFERENCES `user_role` (`role_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
