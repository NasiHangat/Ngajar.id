<?php
session_start();
header('Content-Type: application/json');
include "../Includes/DBkoneksi.php";

if ($_SESSION['role'] !== 'admin') {
    echo json_encode(['status' => 'error', 'message' => 'Akses ditolak']);
    exit;
}

$id = $_GET['id'] ?? null;

if (!$id) {
    echo json_encode(['status' => 'error', 'message' => 'ID modul tidak valid']);
    exit;
}

// Ambil file URL sebelum hapus
$stmt = $conn->prepare("SELECT file_url FROM modul WHERE modul_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($file_url);
$stmt->fetch();
$stmt->close();

if ($file_url && file_exists($file_url)) {
    unlink($file_url); // Hapus file fisik
}

// Hapus data dari DB
$stmt = $conn->prepare("DELETE FROM modul WHERE modul_id = ?");
$stmt->bind_param("i", $id);
if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Modul berhasil dihapus']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus modul']);
}
$stmt->close();
