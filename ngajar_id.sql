-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 15 Jun 2025 pada 13.28
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

DELIMITER $$
--
-- Prosedur
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `get_pengajar_statistik` (IN `pengajarId` INT)   BEGIN
    
    SELECT COUNT(*) AS total_kelas
    FROM kelas
    WHERE pengajar_id = pengajarId;

    
    SELECT COUNT(*) AS total_materi
    FROM materi m
    JOIN kelas k ON m.kelas_id = k.kelas_id
    WHERE k.pengajar_id = pengajarId;

    
    SELECT COUNT(DISTINCT kp.siswa_id) AS total_siswa
    FROM kelas k
    JOIN kelas_peserta kp ON k.kelas_id = kp.kelas_id
    WHERE k.pengajar_id = pengajarId;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `donasi`
--

CREATE TABLE `donasi` (
  `donasi_id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `donasi`
--

INSERT INTO `donasi` (`donasi_id`, `nama`, `jumlah`, `tanggal`) VALUES
(3, 'asd', 1000000, '2025-06-14 20:03:46');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelas`
--

CREATE TABLE `kelas` (
  `kelas_id` int(11) NOT NULL,
  `pengajar_id` int(11) DEFAULT NULL,
  `judul` varchar(150) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `status` enum('aktif','selesai','ditolak') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kelas`
--

INSERT INTO `kelas` (`kelas_id`, `pengajar_id`, `judul`, `deskripsi`, `status`, `created_at`) VALUES
(5, 22, 'Pemrograman Web', 'PEMWEB 1', 'aktif', '2025-06-14 07:36:56'),
(6, 22, 'Anjay', 'mabar', 'aktif', '2025-06-14 08:48:15'),
(7, 20, 'Pemrograman Web', 'AWWWW', 'aktif', '2025-06-14 18:34:23'),
(8, 22, 'aaaa', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 'aktif', '2025-06-15 08:19:52');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelas_peserta`
--

CREATE TABLE `kelas_peserta` (
  `id` int(11) NOT NULL,
  `siswa_id` int(11) DEFAULT NULL,
  `kelas_id` int(11) DEFAULT NULL,
  `tanggal_daftar` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kelas_peserta`
--

INSERT INTO `kelas_peserta` (`id`, `siswa_id`, `kelas_id`, `tanggal_daftar`) VALUES
(1, 23, 5, NULL),
(2, 23, 6, NULL),
(3, 23, 7, '2025-06-15 12:10:32'),
(4, 23, 8, '2025-06-15 15:20:03');

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deskripsi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `materi`
--

INSERT INTO `materi` (`materi_id`, `kelas_id`, `judul`, `tipe`, `file_url`, `created_at`, `deskripsi`) VALUES
(10, 7, 'Tes Admin', '', '../uploads/materi/1749926083_1284821.jpg', '2025-06-14 18:34:43', NULL),
(11, 5, 'Tes Admin', 'pdf', '../uploads/materi/1749964307_1284821.jpg', '2025-06-15 05:11:47', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `modul`
--

CREATE TABLE `modul` (
  `modul_id` int(11) NOT NULL,
  `judul` varchar(150) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `file_url` varchar(255) DEFAULT NULL,
  `tipe` enum('gratis','premium') DEFAULT NULL,
  `token_harga` int(11) DEFAULT NULL,
  `dibuat_oleh` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `modul`
--

INSERT INTO `modul` (`modul_id`, `judul`, `deskripsi`, `file_url`, `tipe`, `token_harga`, `dibuat_oleh`, `created_at`) VALUES
(7, 'cihuy', 'aaaaa', '../uploads/modul/1749922966_684db4960d061.jpg', '', 1000, 21, '2025-06-14 17:42:46'),
(11, 'tess', 'aaaaa', '../uploads/modul/1749923051_684db4eb5cc85.docx', '', 2222, 21, '2025-06-14 17:44:11'),
(13, 'aw', 'hiyaaaaaaaaaa', '', '', 10, 21, '2025-06-15 05:56:11');

-- --------------------------------------------------------

--
-- Struktur dari tabel `token`
--

CREATE TABLE `token` (
  `user_id` int(11) NOT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `last_update` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `token_log`
--

CREATE TABLE `token_log` (
  `log_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `modul_id` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `topup`
--

CREATE TABLE `topup` (
  `topup_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `jumlah_token` int(11) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Trigger `topup`
--
DELIMITER $$
CREATE TRIGGER `update_token_after_topup` AFTER INSERT ON `topup` FOR EACH ROW BEGIN
  
  IF EXISTS (SELECT 1 FROM token WHERE user_id = NEW.user_id) THEN
    
    UPDATE token
    SET jumlah = jumlah + NEW.jumlah_token,
        last_update = NOW()
    WHERE user_id = NEW.user_id;
  ELSE
    
    INSERT INTO token (user_id, jumlah, last_update)
    VALUES (NEW.user_id, NEW.jumlah_token, NOW());
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('murid','pengajar','admin') DEFAULT NULL,
  `status` enum('aktif','nonaktif') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `role`, `status`, `created_at`) VALUES
(19, 'A', 'D@gmail.com', '$2y$10$5VffwNGmfK.BoouYo9.fRO9bHdTO5yVQVFPh8TfycncQuODsOknSq', 'murid', 'aktif', '2025-06-04 16:22:19'),
(20, 'asd', 'a@gmail.com', '$2y$10$JM5wbLRDkaxwFlxIkPIyaO7g36UbyieO5CVXjQwDTg48xKD7CUhm6', 'pengajar', 'aktif', '2025-06-11 07:30:53'),
(21, 'Azis', 'mamanganteng@gmail.com', '$2y$10$lLjwFbwBVqCxB1hObBrvzuVbyfyHfZPvECUQrAT9ygpe9zMaygXNa', 'admin', 'aktif', '2025-06-11 09:57:45'),
(22, 'Azis', 'muhammadabdulazis747@gmail.com', '$2y$10$oxto5WrwdXmoT.acFoXp.ubGJ9iS8IPQgxycpl.OVPKYvYRxXTQYq', 'pengajar', 'aktif', '2025-06-14 07:33:43'),
(23, 'Budi', 'anjing@gmail.com', '$2y$10$B0EpShwqRtiho0pXGIKa6OXPMkDluLQfkSW74Fjp.eUdDA11tclza', 'murid', 'aktif', '2025-06-14 07:53:30'),
(24, 'asep', 'asep@gmail.com', '$2y$10$OLRhD/ANnZfSsHZzXU3a/usFEulYM4V77WykIKH0gSHsC5Bqo.bDi', 'pengajar', 'aktif', '2025-06-14 13:03:57');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `donasi`
--
ALTER TABLE `donasi`
  ADD PRIMARY KEY (`donasi_id`);

--
-- Indeks untuk tabel `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`kelas_id`),
  ADD KEY `pengajar_id` (`pengajar_id`);

--
-- Indeks untuk tabel `kelas_peserta`
--
ALTER TABLE `kelas_peserta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `siswa_id` (`siswa_id`),
  ADD KEY `kelas_id` (`kelas_id`);

--
-- Indeks untuk tabel `materi`
--
ALTER TABLE `materi`
  ADD PRIMARY KEY (`materi_id`),
  ADD KEY `kelas_id` (`kelas_id`);

--
-- Indeks untuk tabel `modul`
--
ALTER TABLE `modul`
  ADD PRIMARY KEY (`modul_id`),
  ADD KEY `dibuat_oleh` (`dibuat_oleh`);

--
-- Indeks untuk tabel `token`
--
ALTER TABLE `token`
  ADD PRIMARY KEY (`user_id`);

--
-- Indeks untuk tabel `token_log`
--
ALTER TABLE `token_log`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `modul_id` (`modul_id`);

--
-- Indeks untuk tabel `topup`
--
ALTER TABLE `topup`
  ADD PRIMARY KEY (`topup_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `donasi`
--
ALTER TABLE `donasi`
  MODIFY `donasi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `kelas`
--
ALTER TABLE `kelas`
  MODIFY `kelas_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `kelas_peserta`
--
ALTER TABLE `kelas_peserta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `materi`
--
ALTER TABLE `materi`
  MODIFY `materi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `modul`
--
ALTER TABLE `modul`
  MODIFY `modul_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `token_log`
--
ALTER TABLE `token_log`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `topup`
--
ALTER TABLE `topup`
  MODIFY `topup_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `kelas`
--
ALTER TABLE `kelas`
  ADD CONSTRAINT `kelas_ibfk_1` FOREIGN KEY (`pengajar_id`) REFERENCES `users` (`user_id`);

--
-- Ketidakleluasaan untuk tabel `kelas_peserta`
--
ALTER TABLE `kelas_peserta`
  ADD CONSTRAINT `kelas_peserta_ibfk_1` FOREIGN KEY (`siswa_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `kelas_peserta_ibfk_2` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`kelas_id`);

--
-- Ketidakleluasaan untuk tabel `materi`
--
ALTER TABLE `materi`
  ADD CONSTRAINT `materi_ibfk_1` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`kelas_id`);

--
-- Ketidakleluasaan untuk tabel `modul`
--
ALTER TABLE `modul`
  ADD CONSTRAINT `modul_ibfk_1` FOREIGN KEY (`dibuat_oleh`) REFERENCES `users` (`user_id`);

--
-- Ketidakleluasaan untuk tabel `token`
--
ALTER TABLE `token`
  ADD CONSTRAINT `token_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Ketidakleluasaan untuk tabel `token_log`
--
ALTER TABLE `token_log`
  ADD CONSTRAINT `token_log_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `token_log_ibfk_2` FOREIGN KEY (`modul_id`) REFERENCES `modul` (`modul_id`);

--
-- Ketidakleluasaan untuk tabel `topup`
--
ALTER TABLE `topup`
  ADD CONSTRAINT `topup_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;