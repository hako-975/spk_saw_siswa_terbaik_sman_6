-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 28 Sep 2025 pada 13.16
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spk_saw_siswa_terbaik_sman_6`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `alternatif`
--

CREATE TABLE `alternatif` (
  `id_alternatif` int(11) NOT NULL,
  `nama_siswa` varchar(100) NOT NULL,
  `id_kelas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `alternatif`
--

INSERT INTO `alternatif` (`id_alternatif`, `nama_siswa`, `id_kelas`) VALUES
(1, 'Andi', 1),
(2, 'Budi', 1),
(3, 'Eka', 1),
(4, 'Mulyono', 1),
(5, 'Gibran', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `hasil_saw`
--

CREATE TABLE `hasil_saw` (
  `id_hasil_saw` int(11) NOT NULL,
  `id_alternatif` int(11) DEFAULT NULL,
  `id_kelas` int(11) NOT NULL,
  `nilai_preferensi_tertinggi` float DEFAULT NULL,
  `dibuat_pada` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `hasil_saw`
--

INSERT INTO `hasil_saw` (`id_hasil_saw`, `id_alternatif`, `id_kelas`, `nilai_preferensi_tertinggi`, `dibuat_pada`) VALUES
(1, 5, 1, 0.94746, '2025-09-28 18:01:08');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelas`
--

CREATE TABLE `kelas` (
  `id_kelas` int(11) NOT NULL,
  `kelas` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kelas`
--

INSERT INTO `kelas` (`id_kelas`, `kelas`) VALUES
(1, 12);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kriteria`
--

CREATE TABLE `kriteria` (
  `id_kriteria` int(11) NOT NULL,
  `kriteria` varchar(100) NOT NULL,
  `bobot` float NOT NULL,
  `atribut` enum('Benefit','Cost') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kriteria`
--

INSERT INTO `kriteria` (`id_kriteria`, `kriteria`, `bobot`, `atribut`) VALUES
(1, 'Nilai Raport', 0.4, 'Benefit'),
(2, 'Ekstrakurikuler', 0.3, 'Benefit'),
(3, 'Sikap dan Perilaku', 0.2, 'Benefit'),
(4, 'Kehadiran', 0.1, 'Benefit');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penilaian`
--

CREATE TABLE `penilaian` (
  `id_penilaian` int(11) NOT NULL,
  `id_kriteria` int(11) NOT NULL,
  `id_alternatif` int(11) NOT NULL,
  `nilai` float NOT NULL,
  `nilai_preferensi` float DEFAULT NULL,
  `id_hasil_saw` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `penilaian`
--

INSERT INTO `penilaian` (`id_penilaian`, `id_kriteria`, `id_alternatif`, `nilai`, `nilai_preferensi`, `id_hasil_saw`) VALUES
(1, 1, 1, 88, 0, 1),
(2, 2, 1, 80, 0, 1),
(3, 3, 1, 90, 0, 1),
(4, 4, 1, 95, 0, 1),
(5, 1, 2, 92, 0, 1),
(6, 2, 2, 70, 0, 1),
(7, 3, 2, 85, 0, 1),
(8, 4, 2, 90, 0, 1),
(9, 1, 3, 75, 0, 1),
(10, 2, 3, 95, 0, 1),
(11, 3, 3, 80, 0, 1),
(12, 4, 3, 85, 0, 1),
(13, 1, 5, 85, 0, 1),
(14, 2, 5, 88, 0, 1),
(15, 3, 5, 92, 0, 1),
(16, 4, 5, 98, 0, 1),
(17, 1, 4, 90, 0, 1),
(18, 2, 4, 78, 0, 1),
(19, 3, 4, 88, 0, 1),
(20, 4, 4, 92, 0, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jabatan` enum('Admin','Petugas') NOT NULL,
  `dibuat_pada` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `nama`, `jabatan`, `dibuat_pada`) VALUES
(1, 'admin', '$2y$10$eZTNeQSWW9FOS8H21khtIuyQaNf7DMQXtGSzm6RI5CrNz.rilbPoi', 'Administrator', 'Admin', '2025-02-10 14:27:42'),
(6, 'guru', '$2y$10$pLR21DQbjBSz6cJaAhgMauHXvTR5R75AezGOGk..LastENFKOMKgq', 'guru', 'Petugas', '2025-02-22 15:16:52');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `alternatif`
--
ALTER TABLE `alternatif`
  ADD PRIMARY KEY (`id_alternatif`),
  ADD KEY `id_kelas` (`id_kelas`);

--
-- Indeks untuk tabel `hasil_saw`
--
ALTER TABLE `hasil_saw`
  ADD PRIMARY KEY (`id_hasil_saw`),
  ADD KEY `id_alternatif` (`id_alternatif`),
  ADD KEY `id_kelas` (`id_kelas`);

--
-- Indeks untuk tabel `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id_kelas`);

--
-- Indeks untuk tabel `kriteria`
--
ALTER TABLE `kriteria`
  ADD PRIMARY KEY (`id_kriteria`);

--
-- Indeks untuk tabel `penilaian`
--
ALTER TABLE `penilaian`
  ADD PRIMARY KEY (`id_penilaian`),
  ADD KEY `id_kriteria` (`id_kriteria`),
  ADD KEY `id_hasil_saw` (`id_hasil_saw`),
  ADD KEY `id_alternatif` (`id_alternatif`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `alternatif`
--
ALTER TABLE `alternatif`
  MODIFY `id_alternatif` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `hasil_saw`
--
ALTER TABLE `hasil_saw`
  MODIFY `id_hasil_saw` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id_kelas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `kriteria`
--
ALTER TABLE `kriteria`
  MODIFY `id_kriteria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `penilaian`
--
ALTER TABLE `penilaian`
  MODIFY `id_penilaian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
