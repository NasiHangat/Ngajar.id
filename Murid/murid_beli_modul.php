<?php
session_start();
include "../Includes/DBkoneksi.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_SESSION['user_id'], $_POST['modul_id'], $_POST['harga'])) {
    $user_id  = (int) $_SESSION['user_id'];
    $modul_id = (int) $_POST['modul_id'];
    $harga    = (int) $_POST['harga'];

    // Cek apakah sudah dibeli
    $stmt = $conn->prepare("SELECT COUNT(*) FROM token_log WHERE user_id = ? AND modul_id = ?");
    $stmt->bind_param("ii", $user_id, $modul_id);
    $stmt->execute();
    $stmt->bind_result($sudah_dibeli);
    $stmt->fetch();
    $stmt->close();

    if ($sudah_dibeli > 0) {
        header("Location: murid_dashboard.php?status=already_purchased");
        exit;
    }

    // Cek token cukup
    $stmt = $conn->prepare("SELECT jumlah FROM token WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($jumlah_token);
    $stmt->fetch();
    $stmt->close();

    if ($jumlah_token < $harga) {
        header("Location: murid_dashboard.php?status=not_enough_token");
        exit;
    }

    // Proses transaksi
    $conn->begin_transaction();

    try {
        // Kurangi token
        $stmt = $conn->prepare("UPDATE token SET jumlah = jumlah - ? WHERE user_id = ?");
        $stmt->bind_param("ii", $harga, $user_id);
        $stmt->execute();

        // Catat pembelian
        $stmt = $conn->prepare("INSERT INTO token_log (user_id, modul_id, jumlah, tanggal) VALUES (?, ?, ?, NOW())");
        $stmt->bind_param("iii", $user_id, $modul_id, $harga);
        $stmt->execute();

        $conn->commit();
        header("Location: murid_dashboard.php?status=success");
        exit;
    } catch (Exception $e) {
        $conn->rollback();
        header("Location: murid_dashboard.php?status=failed");
        exit;
    }
} else {
    header("Location: murid_dashboard.php");
    exit;
}
