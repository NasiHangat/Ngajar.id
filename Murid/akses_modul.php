<?php
session_start();
include 'koneksi.php'; // File koneksi database

$user_id = $_SESSION['user_id']; // Ambil user_id dari session
$modul_id = $_GET['modul_id']; // Modul yang ingin diakses

// Ambil data modul
$query_modul = $conn->prepare("SELECT tipe, token_harga, file_url FROM modul WHERE modul_id = ?");
$query_modul->bind_param("i", $modul_id);
$query_modul->execute();
$result_modul = $query_modul->get_result();

if ($result_modul->num_rows == 0) {
    die("Modul tidak ditemukan.");
}

$modul = $result_modul->fetch_assoc();

if ($modul['tipe'] == 'gratis') {
    // Modul gratis, langsung akses
    header("Location: " . $modul['file_url']);
    exit();
} else {
    // Modul premium, cek token user
    $query_token = $conn->prepare("SELECT jumlah FROM token WHERE user_id = ?");
    $query_token->bind_param("i", $user_id);
    $query_token->execute();
    $result_token = $query_token->get_result();

    if ($result_token->num_rows == 0) {
        die("Saldo token tidak ditemukan. Silakan isi token terlebih dahulu.");
    }

    $token = $result_token->fetch_assoc();

    if ($token['jumlah'] < $modul['token_harga']) {
        die("Saldo token tidak mencukupi untuk mengakses modul ini.");
    }

    // Kurangi token sesuai harga modul
    $new_token = $token['jumlah'] - $modul['token_harga'];
    $update_token = $conn->prepare("UPDATE token SET jumlah = ?, last_update = NOW() WHERE user_id = ?");
    $update_token->bind_param("ii", $new_token, $user_id);
    $update_token->execute();

    // Berikan akses ke modul
    header("Location: " . $modul['file_url']);
    exit();
}
?>
