-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 17, 2025 at 05:21 AM
-- Server version: 5.7.44
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `montecarlo_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `guru`
--

CREATE TABLE `guru` (
  `id_guru` int(12) NOT NULL,
  `kecamatan_id` int(12) NOT NULL,
  `tahun` int(50) NOT NULL,
  `jumlah` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `guru`
--

INSERT INTO `guru` (`id_guru`, `kecamatan_id`, `tahun`, `jumlah`) VALUES
(58, 25, 2025, 266),
(59, 1, 2025, 107),
(60, 2, 2025, 65),
(61, 3, 2025, 48),
(62, 4, 2025, 21),
(63, 5, 2025, 120),
(64, 6, 2025, 61),
(65, 7, 2025, 41),
(66, 8, 2025, 40),
(67, 9, 2025, 29),
(68, 10, 2025, 11),
(69, 11, 2025, 37),
(70, 12, 2025, 98),
(71, 13, 2025, 42),
(72, 14, 2025, 85),
(73, 15, 2025, 44),
(74, 16, 2025, 47),
(75, 17, 2025, 39),
(76, 18, 2025, 32),
(77, 19, 2025, 106),
(78, 20, 2025, 69),
(79, 21, 2025, 25),
(80, 22, 2025, 77),
(83, 25, 2025, 266);

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(12) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `foto` varchar(255) DEFAULT 'default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `username`, `password`, `nama_lengkap`, `email`, `foto`) VALUES
(1, 'badri', '$2y$10$aGsFtH9X6xLpdTvawseSsOY.yUB0m4uzXhBbc99bmpiLSt0qoSBii', 'khbadri', 'khbadri22@gmail.com', '1752518107_7f5aab5a5443007dd64e.png'),
(2, 'indonesia', '$2y$10$nNpjHIYxL8YtCSTB.ie9GOquR0mV1Ah9m6JWOt17eNKrpEPAveWOK', 'khbadri', 'khbadri1100@gmail.com', '1752598480_3c7c8bd7d898aee23c0e.png'),
(3, 'cekcek', '$2y$10$2dNFzhiXRtCETTUTZhE0Ne.aDfa3d9Y4JrWwvnbZuECDKFKmDiiA2', 'cek cekkk', 'cekcek22@gmail.com', '1752672569_b3d5bb1dcaf984bcf3c5.png'),
(4, 'cici', '$2y$10$WLQZuSdpuUtuxRIH7y9sVuEne7xhiGyLV7HAKEYmZBng.7vHkkH9G', 'ciciii', 'cici55@gmail.com', '1752722757_1e1897ac7712c99671d6.png');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2025-07-14-135008', 'App\\Database\\Migrations\\CreateWilayahTable', 'default', 'App', 1752501035, 1);

-- --------------------------------------------------------

--
-- Table structure for table `prediksi`
--

CREATE TABLE `prediksi` (
  `id_prediksi` int(11) NOT NULL,
  `tahun` int(11) NOT NULL,
  `kecamatan` varchar(100) NOT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `probabilitas` decimal(12,9) DEFAULT NULL,
  `cdf` decimal(12,9) DEFAULT NULL,
  `batas` varchar(50) DEFAULT NULL,
  `angka_acak` decimal(12,9) DEFAULT NULL,
  `hasil_prediksi` varchar(255) DEFAULT NULL,
  `total_keseluruhan` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prediksi`
--

INSERT INTO `prediksi` (`id_prediksi`, `tahun`, `kecamatan`, `jumlah`, `probabilitas`, `cdf`, `batas`, `angka_acak`, `hasil_prediksi`, `total_keseluruhan`, `created_at`) VALUES
(1299, 2025, 'Bandar Pasir Mandoge', 1720, 0.067000000, 0.067000000, '0.000 - 0.067', 0.093750000, '904', 41161, '2025-07-17 03:13:23'),
(1300, 2025, 'Bandar Pulau', 904, 0.035000000, 0.103000000, '0.067 - 0.103', 0.632812500, '299', 41161, '2025-07-17 03:13:23'),
(1301, 2025, 'Aek Songsongan', 545, 0.021000000, 0.124000000, '0.103 - 0.124', 0.875000000, '4149', 41161, '2025-07-17 03:13:23'),
(1302, 2025, 'Rahuning', 297, 0.012000000, 0.136000000, '0.124 - 0.136', 0.476562500, '524', 41161, '2025-07-17 03:13:23'),
(1303, 2025, 'Pulau Rakyat', 2045, 0.080000000, 0.216000000, '0.136 - 0.216', 0.906250000, '4149', 41161, '2025-07-17 03:13:23'),
(1304, 2025, 'Aek Kuasan', 644, 0.025000000, 0.241000000, '0.216 - 0.241', 0.070312500, '904', 41161, '2025-07-17 03:13:23'),
(1305, 2025, 'Aek Ledong', 587, 0.023000000, 0.264000000, '0.241 - 0.264', 0.187500000, '2045', 41161, '2025-07-17 03:13:23'),
(1306, 2025, 'Sei Kepayang', 414, 0.016000000, 0.281000000, '0.264 - 0.281', 0.414062500, '1300', 41161, '2025-07-17 03:13:23'),
(1307, 2025, 'Sei Kepayang Barat', 441, 0.017000000, 0.298000000, '0.281 - 0.298', 0.718750000, '824', 41161, '2025-07-17 03:13:23'),
(1308, 2025, 'Sei Kepayang Timur', 97, 0.004000000, 0.302000000, '0.298 - 0.302', 0.507812500, '666', 41161, '2025-07-17 03:13:23'),
(1309, 2025, 'Tanjung Balai', 468, 0.018000000, 0.320000000, '0.302 - 0.320', 0.500000000, '666', 41161, '2025-07-17 03:13:23'),
(1310, 2025, 'Simpang Empat', 1445, 0.057000000, 0.377000000, '0.320 - 0.377', 0.351562500, '1445', 41161, '2025-07-17 03:13:23'),
(1311, 2025, 'Teluk Dalam', 356, 0.014000000, 0.391000000, '0.377 - 0.391', 0.531250000, '415', 41161, '2025-07-17 03:13:23'),
(1312, 2025, 'Air Batu', 1300, 0.051000000, 0.441000000, '0.391 - 0.441', 0.945312500, '4149', 41161, '2025-07-17 03:13:23'),
(1313, 2025, 'Sei Dadap', 767, 0.030000000, 0.472000000, '0.441 - 0.472', 0.812500000, '3000', 41161, '2025-07-17 03:13:23'),
(1314, 2025, 'Buntu Pane', 524, 0.021000000, 0.492000000, '0.472 - 0.492', 0.289062500, '441', 41161, '2025-07-17 03:13:23'),
(1315, 2025, 'Tinggi Raja', 666, 0.026000000, 0.518000000, '0.492 - 0.518', 0.343750000, '1445', 41161, '2025-07-17 03:13:23'),
(1316, 2025, 'Setia Janji', 415, 0.016000000, 0.534000000, '0.518 - 0.534', 0.382812500, '356', 41161, '2025-07-17 03:13:23'),
(1317, 2025, 'Meranti', 1452, 0.057000000, 0.591000000, '0.534 - 0.591', 0.125000000, '297', 41161, '2025-07-17 03:13:23'),
(1318, 2025, 'Pulo Bandring', 946, 0.037000000, 0.628000000, '0.591 - 0.628', 0.226562500, '644', 41161, '2025-07-17 03:13:23'),
(1319, 2025, 'Rawang Panca Arga', 299, 0.012000000, 0.640000000, '0.628 - 0.640', 0.156250000, '2045', 41161, '2025-07-17 03:13:23'),
(1320, 2025, 'Air Joman', 1206, 0.047000000, 0.687000000, '0.640 - 0.687', 0.820312500, '3000', 41161, '2025-07-17 03:13:23'),
(1321, 2025, 'Silau Laut', 824, 0.032000000, 0.720000000, '0.687 - 0.720', 0.437500000, '1300', 41161, '2025-07-17 03:13:23'),
(1322, 2025, 'Kota Kisaran Barat', 3000, 0.118000000, 0.837000000, '0.720 - 0.837', 0.164062500, '2045', 41161, '2025-07-17 03:13:23'),
(1323, 2025, 'Kota Kisaran Timur', 4149, 0.163000000, 1.000000000, '0.837 - 1.000', 0.968750000, '4149', 41161, '2025-07-17 03:13:23');

-- --------------------------------------------------------

--
-- Table structure for table `selisih`
--

CREATE TABLE `selisih` (
  `id_selisih` int(11) NOT NULL,
  `tahun` int(11) NOT NULL,
  `kecamatan_id` int(11) NOT NULL,
  `hasil_prediksi_id` int(11) NOT NULL,
  `jumlah_guru_id` int(11) NOT NULL,
  `kebutuhan` int(50) NOT NULL,
  `nilai_selisih` varchar(50) NOT NULL,
  `keterangan` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `selisih`
--

INSERT INTO `selisih` (`id_selisih`, `tahun`, `kecamatan_id`, `hasil_prediksi_id`, `jumlah_guru_id`, `kebutuhan`, `nilai_selisih`, `keterangan`, `created_at`, `updated_at`) VALUES
(6, 2025, 1309, 666, 37, 33, '-3.7', 'kekurangan', '2025-07-16 16:45:11', '2025-07-17 03:21:09'),
(12, 2025, 1303, 4149, 41, 207, '166.45', 'kelebihan', '2025-07-17 02:59:37', '2025-07-17 03:21:18'),
(13, 2025, 1323, 4149, 37, 207, '170.45', 'kelebihan', '2025-07-17 03:11:54', '2025-07-17 03:49:21');

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `id_siswa` int(12) NOT NULL,
  `tahun` varchar(50) DEFAULT NULL,
  `kecamatan_id` int(12) NOT NULL,
  `jumlah` varchar(50) NOT NULL,
  `probabilitas` double DEFAULT NULL,
  `cdf` double DEFAULT NULL,
  `batas` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`id_siswa`, `tahun`, `kecamatan_id`, `jumlah`, `probabilitas`, `cdf`, `batas`) VALUES
(38, '2025', 1, '1720', 0.067, 0.067, '0.000 - 0.067'),
(39, '2025', 2, '904', 0.035, 0.103, '0.067 - 0.103'),
(40, '2025', 3, '545', 0.021, 0.124, '0.103 - 0.124'),
(41, '2025', 4, '297', 0.012, 0.136, '0.124 - 0.136'),
(42, '2025', 5, '2045', 0.08, 0.216, '0.136 - 0.216'),
(43, '2025', 6, '644', 0.025, 0.241, '0.216 - 0.241'),
(44, '2025', 7, '587', 0.023, 0.264, '0.241 - 0.264'),
(45, '2025', 8, '414', 0.016, 0.281, '0.264 - 0.281'),
(46, '2025', 9, '441', 0.017, 0.298, '0.281 - 0.298'),
(47, '2025', 10, '97', 0.004, 0.302, '0.298 - 0.302'),
(48, '2025', 11, '468', 0.018, 0.32, '0.302 - 0.320'),
(49, '2025', 12, '1445', 0.057, 0.377, '0.320 - 0.377'),
(50, '2025', 13, '356', 0.014, 0.391, '0.377 - 0.391'),
(51, '2025', 14, '1300', 0.051, 0.441, '0.391 - 0.441'),
(52, '2025', 15, '767', 0.03, 0.472, '0.441 - 0.472'),
(53, '2025', 16, '524', 0.021, 0.492, '0.472 - 0.492'),
(54, '2025', 17, '666', 0.026, 0.518, '0.492 - 0.518'),
(55, '2025', 18, '415', 0.016, 0.534, '0.518 - 0.534'),
(56, '2025', 19, '1452', 0.057, 0.591, '0.534 - 0.591'),
(57, '2025', 20, '946', 0.037, 0.628, '0.591 - 0.628'),
(58, '2025', 21, '299', 0.012, 0.64, '0.628 - 0.640'),
(59, '2025', 22, '1206', 0.047, 0.687, '0.640 - 0.687'),
(60, '2025', 23, '824', 0.032, 0.72, '0.687 - 0.720'),
(61, '2025', 24, '3000', 0.118, 0.837, '0.720 - 0.837'),
(64, '2025', 26, '4149', 0.163, 1, '0.837 - 1.000');

-- --------------------------------------------------------

--
-- Table structure for table `wilayah`
--

CREATE TABLE `wilayah` (
  `id` int(5) UNSIGNED NOT NULL,
  `kecamatan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `wilayah`
--

INSERT INTO `wilayah` (`id`, `kecamatan`) VALUES
(1, 'Bandar Pasir Mandoge'),
(2, 'Bandar Pulau'),
(3, 'Aek Songsongan'),
(4, 'Rahuning'),
(5, 'Pulau Rakyat'),
(6, 'Aek Kuasan'),
(7, 'Aek Ledong'),
(8, 'Sei Kepayang'),
(9, 'Sei Kepayang Barat'),
(10, 'Sei Kepayang Timur'),
(11, 'Tanjung Balai'),
(12, 'Simpang Empat'),
(13, 'Teluk Dalam'),
(14, 'Air Batu'),
(15, 'Sei Dadap'),
(16, 'Buntu Pane'),
(17, 'Tinggi Raja'),
(18, 'Setia Janji'),
(19, 'Meranti'),
(20, 'Pulo Bandring'),
(21, 'Rawang Panca Arga'),
(22, 'Air Joman'),
(23, 'Silau Laut'),
(24, 'Kota Kisaran Barat'),
(26, 'Kota Kisaran Timur');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`id_guru`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prediksi`
--
ALTER TABLE `prediksi`
  ADD PRIMARY KEY (`id_prediksi`);

--
-- Indexes for table `selisih`
--
ALTER TABLE `selisih`
  ADD PRIMARY KEY (`id_selisih`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id_siswa`);

--
-- Indexes for table `wilayah`
--
ALTER TABLE `wilayah`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `guru`
--
ALTER TABLE `guru`
  MODIFY `id_guru` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `prediksi`
--
ALTER TABLE `prediksi`
  MODIFY `id_prediksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1324;

--
-- AUTO_INCREMENT for table `selisih`
--
ALTER TABLE `selisih`
  MODIFY `id_selisih` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id_siswa` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `wilayah`
--
ALTER TABLE `wilayah`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
