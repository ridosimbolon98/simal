-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 21 Nov 2022 pada 07.48
-- Versi server: 10.4.24-MariaDB
-- Versi PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `simal`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `ci_sessions`
--

INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('50kn41n466bqbm5tfen3gqssukfq7u0n', '192.168.10.30', 1669006914, 0x5f5f63695f6c6173745f726567656e65726174657c693a313636393030363730363b757365726e616d657c733a353a2261646d696e223b6c6576656c7c733a353a2241444d494e223b7569647c733a31313a223230323231313131303031223b7374617475737c733a363a226c6f67676564223b),
('esd32avq40dgv587grlcpf0kklfp265o', '192.168.10.30', 1669009897, 0x5f5f63695f6c6173745f726567656e65726174657c693a313636393030393631323b757365726e616d657c733a353a2261646d696e223b6c6576656c7c733a353a2241444d494e223b7569647c733a31313a223230323231313131303031223b7374617475737c733a363a226c6f67676564223b),
('9avgqh89uopkv92suj0bgfgapu3vgt1i', '192.168.10.30', 1669009953, 0x5f5f63695f6c6173745f726567656e65726174657c693a313636393030393933343b757365726e616d657c733a353a2261646d696e223b6c6576656c7c733a353a2241444d494e223b7569647c733a31313a223230323231313131303031223b7374617475737c733a363a226c6f67676564223b),
('keekl8ndc3tkabdjefoau15h7fd4r9nb', '192.168.10.30', 1669010032, 0x5f5f63695f6c6173745f726567656e65726174657c693a313636393031303032393b),
('9i7m5nsv5t1ff7hr5vb7ouqsfbdfifs5', '192.168.10.30', 1669013278, 0x5f5f63695f6c6173745f726567656e65726174657c693a313636393031333139333b757365726e616d657c733a353a2261646d696e223b6c6576656c7c733a353a2241444d494e223b7569647c733a31313a223230323231313131303031223b7374617475737c733a363a226c6f67676564223b);

-- --------------------------------------------------------

--
-- Struktur dari tabel `customer`
--

CREATE TABLE `customer` (
  `cid` varchar(20) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `alamat` text NOT NULL,
  `griya_id` varchar(20) NOT NULL,
  `golongan` varchar(100) NOT NULL,
  `stand_meter` varchar(100) NOT NULL,
  `input_by` varchar(20) NOT NULL,
  `inserted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `customer`
--

INSERT INTO `customer` (`cid`, `nama`, `alamat`, `griya_id`, `golongan`, `stand_meter`, `input_by`, `inserted_at`) VALUES
('123345346', 'ZAENAL ABIDIN', 'B-5', '20221123322', 'PERUMAHAN', '', '20221111001', '2022-11-01 05:21:07'),
('1667382929', 'RIDO', 'JL. Melati Gg Mawar', '1667392963', 'PERUMAHAN', '1234', '20221111001', '2022-11-02 12:11:35'),
('2134235546', 'CONTOH', 'B-4', '20221123012', 'PERUMAHAN', '', '2334545', '2022-11-01 07:04:58');

-- --------------------------------------------------------

--
-- Struktur dari tabel `griya`
--

CREATE TABLE `griya` (
  `id` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `biaya_mtc` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `griya`
--

INSERT INTO `griya` (`id`, `nama`, `alamat`, `biaya_mtc`) VALUES
('1667392963', 'GRIYA UTAMA CONTOH', 'JL. Melati', '4500'),
('20221123012', 'GRIYA UTAMA BANJARDOWO BARU', 'JL. Kudu Raya, Kota Semarang, Jawa Tengah', '4000'),
('20221123322', 'GRIYA UTAMA KUDU ASRI', 'Kudu, Kec. Genuk, Kota Semarang, Jawa Tengah 50116', '3500');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kartu_meter`
--

CREATE TABLE `kartu_meter` (
  `id` varchar(20) NOT NULL,
  `cid` varchar(20) NOT NULL,
  `bulan` varchar(2) NOT NULL,
  `periode` year(4) NOT NULL,
  `aka_lalu` double NOT NULL,
  `aka_akhir` double NOT NULL,
  `jlh_pakai` double NOT NULL,
  `jlh_biaya` bigint(20) NOT NULL,
  `biaya_per_meter` bigint(20) NOT NULL,
  `inserted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `kartu_meter`
--

INSERT INTO `kartu_meter` (`id`, `cid`, `bulan`, `periode`, `aka_lalu`, `aka_akhir`, `jlh_pakai`, `jlh_biaya`, `biaya_per_meter`, `inserted_at`) VALUES
('1667911752', '123345346', '11', 2022, 125, 150, 25, 106000, 4000, '2022-11-08 12:49:12'),
('1667968333', '123345346', '12', 2022, 150, 345, 195, 786000, 4000, '2022-11-09 04:32:13'),
('1667975829', '123345346', '01', 2023, 345, 360, 15, 66000, 4000, '2022-11-09 06:37:09'),
('20221101001', '123345346', '01', 2022, 17, 29, 12, 50000, 4000, '2022-11-01 08:00:32'),
('20221101002', '123345346', '02', 2022, 29, 40, 11, 46000, 4000, '2022-11-01 08:00:32'),
('20221101003', '123345346', '03', 2022, 40, 48, 8, 34000, 4000, '2022-11-01 08:00:32'),
('20221101004', '123345346', '04', 2022, 48, 59, 11, 46000, 4000, '2022-11-01 08:00:32'),
('20221101005', '123345346', '05', 2022, 59, 72, 13, 54000, 4000, '2022-11-01 08:00:32'),
('20221101006', '123345346', '06', 2022, 72, 79, 7, 30000, 4000, '2022-11-01 08:00:32'),
('20221101007', '123345346', '07', 2022, 79, 88, 9, 38000, 4000, '2022-11-01 08:00:32'),
('20221101008', '123345346', '08', 2022, 88, 100, 12, 50000, 4000, '2022-11-01 08:00:32'),
('20221101009', '123345346', '09', 2022, 100, 115, 15, 62000, 4000, '2022-11-01 08:00:32'),
('20221101010', '123345346', '10', 2022, 115, 125, 10, 42000, 4000, '2022-11-01 08:00:32');

-- --------------------------------------------------------

--
-- Struktur dari tabel `setup`
--

CREATE TABLE `setup` (
  `sid` int(11) NOT NULL,
  `trx` varchar(100) NOT NULL,
  `tipe` varchar(100) NOT NULL,
  `nilai` varchar(200) NOT NULL,
  `updated_by` varchar(20) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `setup`
--

INSERT INTO `setup` (`sid`, `trx`, `tipe`, `nilai`, `updated_by`, `updated_at`) VALUES
(1, 'BIAYA', 'M3', '4000', '20221111001', '2022-11-02 08:35:05'),
(2, 'BIAYA', 'ADMIN', '2500', '20221111001', '2022-11-01 09:08:05'),
(3, 'NAMA', 'USAHA', 'CV. GRIYA UTAMA WATER', '20221111001', '2022-11-21 06:47:28');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `uid` varchar(20) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(500) NOT NULL,
  `level` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`uid`, `nama`, `username`, `password`, `level`, `created_at`, `updated_at`) VALUES
('1667909645', 'Rido', 'admin2', 'e10adc3949ba59abbe56e057f20f883e', 'admin', '2022-11-08 19:11:05', '2022-11-08 19:11:05'),
('20221111001', 'Admin', 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'ADMIN', '2022-11-01 08:22:14', '2022-11-01 02:22:14');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indeks untuk tabel `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`cid`);

--
-- Indeks untuk tabel `griya`
--
ALTER TABLE `griya`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kartu_meter`
--
ALTER TABLE `kartu_meter`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `setup`
--
ALTER TABLE `setup`
  ADD PRIMARY KEY (`sid`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`uid`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `setup`
--
ALTER TABLE `setup`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
