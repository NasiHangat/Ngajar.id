<?php
include 'Includes/DBkoneksi.php';
session_start();

$pengajar_id = $_SESSION['user_id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $pengajar_id) {
    $judul     = $_POST['namaKelas'] ?? '';
    $deskripsi = $_POST['deskripsiKelas'] ?? '';

    if ($judul === '') {
        echo json_encode(['status' => 'error', 'message' => 'Judul tidak boleh kosong']);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO kelas (pengajar_id, judul, deskripsi, status, created_at) VALUES (?, ?, ?, 'aktif', NOW())");
    $stmt->bind_param("iss", $pengajar_id, $judul, $deskripsi);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Kelas berhasil ditambahkan!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan kelas']);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Akses tidak valid']);
}
?>
