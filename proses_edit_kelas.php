<?php
session_start();
header('Content-Type: application/json');
include "Includes/DBkoneksi.php";

// Pastikan pengguna login
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Tidak ada sesi login.']);
    exit;
}

$pengajar_id = $_SESSION['user_id'];
$id = $_POST['id'] ?? null;
$nama = $_POST['namaKelas'] ?? '';
$deskripsi = $_POST['deskripsiKelas'] ?? '';

if (!$id || empty($nama)) {
    echo json_encode(['status' => 'error', 'message' => 'Data tidak lengkap.']);
    exit;
}

// Update kelas hanya jika milik pengajar yang sedang login
$stmt = $conn->prepare("UPDATE kelas SET judul = ?, deskripsi = ? WHERE kelas_id = ? AND pengajar_id = ?");
$stmt->bind_param("ssii", $nama, $deskripsi, $id, $pengajar_id);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Kelas berhasil diupdate!']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Gagal mengupdate kelas.']);
}

$stmt->close();
$conn->close();
?>
