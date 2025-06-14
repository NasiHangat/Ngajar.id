<?php
header('Content-Type: application/json');
include "Includes/DBkoneksi.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $kelas_id = $_GET['id'];

    // Mulai transaksi agar aman
    $conn->begin_transaction();

    try {
        // Hapus materi terlebih dahulu
        $stmt1 = $conn->prepare("DELETE FROM materi WHERE kelas_id = ?");
        $stmt1->bind_param("i", $kelas_id);
        $stmt1->execute();
        $stmt1->close();

        // Hapus peserta dari kelas
        $stmt2 = $conn->prepare("DELETE FROM kelas_peserta WHERE kelas_id = ?");
        $stmt2->bind_param("i", $kelas_id);
        $stmt2->execute();
        $stmt2->close();

        // Hapus kelas itu sendiri
        $stmt3 = $conn->prepare("DELETE FROM kelas WHERE kelas_id = ?");
        $stmt3->bind_param("i", $kelas_id);
        $stmt3->execute();
        $stmt3->close();

        $conn->commit();

        echo json_encode(['status' => 'success', 'message' => 'Kelas dan data terkait berhasil dihapus']);
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus kelas: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Permintaan tidak valid']);
}
?>
