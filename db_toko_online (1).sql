-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 31 Okt 2022 pada 02.31
-- Versi server: 10.4.21-MariaDB
-- Versi PHP: 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_toko_online`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `foto_produk`
--

CREATE TABLE `foto_produk` (
  `id_foto_produk` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `nama_foto_produk` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `foto_produk`
--

INSERT INTO `foto_produk` (`id_foto_produk`, `id_produk`, `nama_foto_produk`) VALUES
(61, 11, '3117_WhatsApp Image 2021-10-03 at 07.44.51 (2).jpeg'),
(65, 52, '4614_WhatsApp Image 2021-10-03 at 07.44.51 (3).jpeg'),
(67, 53, '5042_WhatsApp Image 2021-10-03 at 07.45.09.jpeg'),
(70, 51, '3108_kk.jpeg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis`
--

CREATE TABLE `jenis` (
  `id_jenis` int(11) NOT NULL,
  `jenis` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `jenis`
--

INSERT INTO `jenis` (`id_jenis`, `jenis`) VALUES
(1, 'Kerupuk'),
(2, 'Kerupuk Mentah'),
(14, 'Kerupuk BS'),
(15, 'Sehat');

-- --------------------------------------------------------

--
-- Struktur dari tabel `login`
--

CREATE TABLE `login` (
  `id_login` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tgl_login` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `login`
--

INSERT INTO `login` (`id_login`, `user_id`, `tgl_login`) VALUES
(1, 76, '2022-02-10 10:15:37'),
(2, 72, '2022-02-10 10:18:03'),
(3, 72, '2022-02-10 10:19:11'),
(4, 72, '2022-02-10 17:26:23'),
(5, 72, '2022-02-11 13:29:59'),
(6, 72, '2022-02-15 21:11:11'),
(7, 72, '2022-02-16 15:49:56'),
(8, 72, '2022-02-16 16:16:00'),
(9, 72, '2022-02-16 16:19:04'),
(10, 72, '2022-02-22 09:15:40'),
(11, 72, '2022-03-02 19:10:38'),
(12, 72, '2022-03-03 10:40:16'),
(13, 72, '2022-03-25 22:23:39'),
(14, 72, '2022-03-27 08:10:11'),
(15, 72, '2022-03-27 10:34:19'),
(16, 72, '2022-03-27 12:24:20'),
(17, 72, '2022-03-27 20:36:15'),
(18, 72, '2022-05-29 12:55:58'),
(19, 72, '2022-07-26 08:50:54'),
(20, 72, '2022-08-08 22:09:13');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int(11) NOT NULL,
  `id_pembelian` char(10) NOT NULL,
  `bank` varchar(100) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `tanggal` datetime NOT NULL,
  `bukti` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pembayaran`
--

INSERT INTO `pembayaran` (`id_pembayaran`, `id_pembelian`, `bank`, `jumlah`, `tanggal`, `bukti`) VALUES
(10, '0702220002', '2', 5023999, '2022-02-07 10:00:12', '62008b3cd896c.jpg'),
(11, '0702220003', '1', 1, '2022-02-07 10:48:53', '620096a5a3701.jpg'),
(12, '0702220004', 'BNI', 900000, '2022-02-07 13:53:55', '6200c2033052f.jpg'),
(13, '1002220001', 'BRI', 116000, '2022-02-10 17:56:35', '6204ef63e97f8.jpg'),
(14, '2202220003', 'BTN', 180000, '2022-02-22 09:14:56', '621447205f5f8.jpeg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembeli`
--

CREATE TABLE `pembeli` (
  `id_pembeli` int(11) NOT NULL,
  `username_pembeli` varchar(100) NOT NULL,
  `password_pembeli` varchar(100) NOT NULL,
  `nama_pembeli` varchar(150) NOT NULL,
  `jk_pembeli` varchar(10) NOT NULL,
  `alamat_pembeli` text NOT NULL,
  `telp_pembeli` varchar(15) NOT NULL,
  `foto_pembeli` varchar(100) NOT NULL,
  `email_pembeli` varchar(100) NOT NULL,
  `token_ganti_pass` varchar(50) DEFAULT NULL,
  `status_pendaftaran` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pembeli`
--

INSERT INTO `pembeli` (`id_pembeli`, `username_pembeli`, `password_pembeli`, `nama_pembeli`, `jk_pembeli`, `alamat_pembeli`, `telp_pembeli`, `foto_pembeli`, `email_pembeli`, `token_ganti_pass`, `status_pendaftaran`) VALUES
(1, 'fandi', '$2y$10$pV4f5r9rlZTGDX/2FCIeWeSUDD2AMFNE8wnX86U7LtMuSclk.qqbS', 'Fandi Aziz Pratama', 'Laki-laki', 'Bandar RT 01/06, Bandardawung, Tawangmangu, Karanganyar', '0895392618509', '61fd0ab6d2add.jpg', 'fankdiazizp@gmail.com', 'a8849b052492b5106526b2331e526138', '1'),
(8, 'fandiaziz', '$2y$10$fHmMFEu63EelFLtwg74GIOW9WEaPjQmvrvbCVTBq/Fist/mhuGx/.', 'fandi junior', 'Laki-laki', 'mana ada', '09', '61fd0b177abce.jpg', 'andiaziz@gmail.com', '', '1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembelian`
--

CREATE TABLE `pembelian` (
  `id_pembelian` char(10) NOT NULL,
  `id_pembeli` int(11) NOT NULL,
  `alamat_pengiriman` text NOT NULL,
  `tgl_pembelian` datetime NOT NULL,
  `status_pembelian` int(11) NOT NULL,
  `no_resi` varchar(50) NOT NULL,
  `totalberat` int(11) NOT NULL,
  `provinsi` varchar(50) NOT NULL,
  `distrik` varchar(50) NOT NULL,
  `tipe` varchar(50) NOT NULL,
  `kodepos` varchar(50) NOT NULL,
  `ekspedisi` varchar(50) NOT NULL,
  `paket` varchar(50) NOT NULL,
  `ongkir` int(11) NOT NULL,
  `estimasi` varchar(10) NOT NULL,
  `total_pembelian` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pembelian`
--

INSERT INTO `pembelian` (`id_pembelian`, `id_pembeli`, `alamat_pengiriman`, `tgl_pembelian`, `status_pembelian`, `no_resi`, `totalberat`, `provinsi`, `distrik`, `tipe`, `kodepos`, `ekspedisi`, `paket`, `ongkir`, `estimasi`, `total_pembelian`) VALUES
('0708220005', 1, 'Bandar RT 01/06, Bandardawung, Tawangmangu, Karanganyar', '2022-08-07 09:29:40', 0, '', 1000, 'Bali', 'Badung', 'Kabupaten', '80351', 'pos', 'Pos Reguler', 15000, '5 HARI', 65000),
('1002220001', 1, 'Bandar RT 01/06, Bandardawung, Tawangmangu, Karanganyar', '2022-02-10 17:56:04', 2, '12345678910', 2000, 'DI Yogyakarta', 'Yogyakarta', 'Kota', '55111', 'jne', 'OKE', 16000, '2-3', 116000),
('1903220004', 1, 'Bandar RT 01/06, Bandardawung, Tawangmangu, Karanganyar', '2022-03-19 18:37:20', 0, '', 1000, 'DI Yogyakarta', 'Gunung Kidul', 'Kabupaten', '55812', 'jne', 'YES', 18000, '1-1', 68000),
('2202220003', 1, 'Bandar RT 01/06, Bandardawung, Tawangmangu, Karanganyar', '2022-02-22 09:14:15', 6, '', 3000, 'Jawa Timur', 'Madiun', 'Kota', '63122', 'jne', 'OKE', 30000, '2-3', 180000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembelian_produk`
--

CREATE TABLE `pembelian_produk` (
  `id_pembelian_produk` int(11) NOT NULL,
  `id_pembelian` char(10) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `jml_pembelian` int(11) NOT NULL,
  `total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pembelian_produk`
--

INSERT INTO `pembelian_produk` (`id_pembelian_produk`, `id_pembelian`, `id_produk`, `jml_pembelian`, `total`) VALUES
(1, '1002220001', 53, 2, 100000),
(3, '2202220003', 53, 3, 150000),
(4, '1903220004', 53, 1, 50000),
(6, '0708220005', 53, 1, 50000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(11) NOT NULL,
  `nama_produk` varchar(100) NOT NULL,
  `id_jenis` int(11) NOT NULL,
  `tgl_post` datetime NOT NULL,
  `berat_produk` int(11) NOT NULL,
  `harga_produk` int(11) NOT NULL,
  `deskripsi_produk` text NOT NULL,
  `status_produk` varchar(20) NOT NULL,
  `foto_produk` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`id_produk`, `nama_produk`, `id_jenis`, `tgl_post`, `berat_produk`, `harga_produk`, `deskripsi_produk`, `status_produk`, `foto_produk`) VALUES
(11, 'Kerupuk Kulit Sapi 1 Kg', 1, '2022-01-30 19:12:56', 1000, 100000, '<p>Kerupuk kulit sapi 1 Kg, Halal renyah langsung dimakan</p>', 'Tersedia', '2937_WhatsApp Image 2021-10-03 at 07.44.51 (2).jpeg'),
(51, 'Kerupuk Kulit Sapi 100 Gram', 1, '2022-02-10 17:45:13', 100, 10000, '<p>Kerupuk Kulit sapi Rp 10,000 perbuah</p>', 'Tersedia', '3049_kk.jpeg'),
(52, 'Kerupuk Kulit Sapi 500 Gram', 1, '2022-02-10 17:46:14', 500, 50000, '<p>Kerupuk Kulit sapi 500 Gram, Halal renyah siap dimakan</p>', 'Tersedia', '4614_WhatsApp Image 2021-10-03 at 07.44.51 (3).jpeg'),
(53, 'Kerupuk Mentah', 2, '2022-02-10 17:50:42', 1000, 50000, '<p>Kerupuk Kulit Sapi Mentah Rp 50,000 Per Kg</p>', 'Tersedia', '5042_WhatsApp Image 2021-10-03 at 07.45.09.jpeg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ranting`
--

CREATE TABLE `ranting` (
  `id_ranting` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `id_pembeli` int(11) NOT NULL,
  `jml_ranting` int(11) NOT NULL,
  `komentar` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `toko`
--

CREATE TABLE `toko` (
  `id` int(11) NOT NULL,
  `tentang_kami` text NOT NULL,
  `telp` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `foto` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `toko`
--

INSERT INTO `toko` (`id`, `tentang_kami`, `telp`, `email`, `alamat`, `foto`) VALUES
(1, '<p>Ini adalah&nbsp; toko krupuk</p>', '62895392518509', 'andiazizp123@gmail.com', 'Dusun Bandar RT 01/06, Desa Bandardawung, Kec. Tawangmangu, Kab. Karanganyar', '6204ee6805f1e.jpeg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `nama_lengkap` varchar(150) NOT NULL,
  `telp_user` varchar(20) NOT NULL,
  `jk_user` varchar(10) NOT NULL,
  `alamat_user` text NOT NULL,
  `foto_user` varchar(100) NOT NULL,
  `email_user` varchar(100) NOT NULL,
  `token_ganti_pass` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `nama_lengkap`, `telp_user`, `jk_user`, `alamat_user`, `foto_user`, `email_user`, `token_ganti_pass`) VALUES
(71, 'junaidi', '$2y$10$ITc9AHE3r.I1cw.Abx0hSepa1PnwjTbygQt8oBLUOosBtYtmHsom.', 'rindaman', '1', 'Laki-laki', 'New York', 'default.svg', 'fandfi@gmail.com', ''),
(72, 'fandi', '$2y$10$pV4f5r9rlZTGDX/2FCIeWeSUDD2AMFNE8wnX86U7LtMuSclk.qqbS', 'Fandi Aziz Pratama', '0895392518509', 'Perempuan', 'bandardawung', '6200a3f93f085.png', 'fankdiazizp@gmail.com', NULL),
(75, 'fandiaz', '$2y$10$pV4f5r9rlZTGDX/2FCIeWeSUDD2AMFNE8wnX86U7LtMuSclk.qqbS', 'Fandi Aziz Pratama', '33', 'Laki-laki', 'fd', 'default.svg', 'fandfi@gmail.com', NULL),
(76, 'Fandis', '$2y$10$ji6an2rpgsbdlSadFoUP9OciaVTnh4uxC7/rZEBOSCV9T/Y0F.gwu', 'Smart', '123', 'Laki-laki', 'Bandardawung', '620bb51941066.jpg', 'andiazizp123@gmail.com', '5878a7ab84fb43402106c575658472fa');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `foto_produk`
--
ALTER TABLE `foto_produk`
  ADD PRIMARY KEY (`id_foto_produk`);

--
-- Indeks untuk tabel `jenis`
--
ALTER TABLE `jenis`
  ADD PRIMARY KEY (`id_jenis`);

--
-- Indeks untuk tabel `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id_login`);

--
-- Indeks untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`);

--
-- Indeks untuk tabel `pembeli`
--
ALTER TABLE `pembeli`
  ADD PRIMARY KEY (`id_pembeli`);

--
-- Indeks untuk tabel `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`id_pembelian`);

--
-- Indeks untuk tabel `pembelian_produk`
--
ALTER TABLE `pembelian_produk`
  ADD PRIMARY KEY (`id_pembelian_produk`);

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- Indeks untuk tabel `ranting`
--
ALTER TABLE `ranting`
  ADD PRIMARY KEY (`id_ranting`);

--
-- Indeks untuk tabel `toko`
--
ALTER TABLE `toko`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `foto_produk`
--
ALTER TABLE `foto_produk`
  MODIFY `id_foto_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT untuk tabel `jenis`
--
ALTER TABLE `jenis`
  MODIFY `id_jenis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `login`
--
ALTER TABLE `login`
  MODIFY `id_login` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `pembeli`
--
ALTER TABLE `pembeli`
  MODIFY `id_pembeli` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `pembelian_produk`
--
ALTER TABLE `pembelian_produk`
  MODIFY `id_pembelian_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT untuk tabel `ranting`
--
ALTER TABLE `ranting`
  MODIFY `id_ranting` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `toko`
--
ALTER TABLE `toko`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
