<?php
session_start();
header('Content-Type: application/json');
include "../includes/DBkoneksi.php";

// Validasi request POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'] ?? null;
    $jumlah_token = (int)($_POST['jumlah'] ?? 0);
    $harga = (int)($_POST['harga'] ?? 0);

    if ($user_id && $jumlah_token > 0 && $harga > 0) {
        try {
            $conn->begin_transaction();

            $stmt = $conn->prepare("
                INSERT INTO topup (user_id, jumlah_token, harga, tanggal) 
                VALUES (?, ?, ?, NOW())
            ");
            $stmt->bind_param("iii", $user_id, $jumlah_token, $harga);
            $stmt->execute();

            $conn->commit();

            echo json_encode(['status' => 'success']);
        } catch (Exception $e) {
            $conn->rollback();
            echo json_encode([
                'status' => 'error',
                'message' => 'Gagal melakukan topup. Silakan coba lagi.'
            ]);
        }
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Data tidak valid atau sesi login habis.'
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Metode tidak diizinkan.'
    ]);
}
?>
