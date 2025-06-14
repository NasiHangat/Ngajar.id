-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 14 Jun 2025 pada 15.07
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
-- Database: `ngajar_id`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `materi`
--

CREATE TABLE `materi` (
  `materi_id` int(11) NOT NULL,
  `kelas_id` int(11) DEFAULT NULL,
  `judul` varchar(150) DEFAULT NULL,
  `tipe` enum('video','pdf','soal') DEFAULT NULL,
  `file_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `materi`
--

INSERT INTO `materi` (`materi_id`, `kelas_id`, `judul`, `tipe`, `file_url`, `created_at`) VALUES
(1, 1, 'cihuy', 'soal', 'https://drive.google.com/file/d/1S7h2FPhcJ_U612atYy0RziEE9b7QsG9d/view?usp=sharing', '2025-06-11 11:25:20'),
(2, 1, 'tes', 'soal', '../uploads/materi/1749641334_Firefly 20250522003112.png', '2025-06-11 11:28:54'),
(3, 1, 'tes', 'soal', '../uploads/materi/1749641431_Firefly 20250522003112.png', '2025-06-11 11:30:31'),
(4, 5, 'Java', '', '../uploads/materi/1749886738_1363443.jpeg', '2025-06-14 07:38:58'),
(5, 5, 'tes', 'soal', '../uploads/materi/1749889106_baru.png', '2025-06-14 08:18:26'),
(6, 5, 'tes', 'soal', '../uploads/materi/1749889144_baru.png', '2025-06-14 08:19:04'),
(7, 5, 'tes', 'soal', '../uploads/materi/1749889681_baru.png', '2025-06-14 08:28:01');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `materi`
--
ALTER TABLE `materi`
  ADD PRIMARY KEY (`materi_id`),
  ADD KEY `kelas_id` (`kelas_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `materi`
--
ALTER TABLE `materi`
  MODIFY `materi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `materi`
--
ALTER TABLE `materi`
  ADD CONSTRAINT `materi_ibfk_1` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`kelas_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;