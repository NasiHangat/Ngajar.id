<?php
include '../Includes/session_check.php';
include '../Includes/DBkoneksi.php';


$_SESSION['pesan'] = "Modul berhasil dibeli!";
header("Location: murid_dashboard.php");
exit;


if ($_SESSION['role'] !== 'murid') {
    header("Location: unauthorized.php");
    exit;
}

$user_id = $_SESSION['user_id'] ?? null;
$modul_id = $_POST['modul_id'] ?? null;
$harga = $_POST['harga'] ?? 0;

if (!$user_id || !$modul_id) {
    die("Data tidak valid.");
}

// 1. Ambil token user
$stmt = $conn->prepare("SELECT jumlah FROM token WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($token_saat_ini);
$stmt->fetch();
$stmt->close();

if ($token_saat_ini < $harga) {
    echo "<script>alert('Token tidak cukup. Silakan topup terlebih dahulu.'); window.location.href='murid_dashboard.php';</script>";
    exit;
}

// 2. Kurangi token
$stmt = $conn->prepare("UPDATE token SET jumlah = jumlah - ?, last_update = NOW() WHERE user_id = ?");
$stmt->bind_param("ii", $harga, $user_id);
$stmt->execute();
$stmt->close();

// 3. Catat ke log pembelian
$stmt = $conn->prepare("INSERT INTO token_log (user_id, modul_id, jumlah, tanggal) VALUES (?, ?, ?, NOW())");
$stmt->bind_param("iii", $user_id, $modul_id, $harga);
$stmt->execute();
$stmt->close();

// 4. Redirect ke halaman isi modul
header("Location: murid_isimodul.php?id=$modul_id");
exit;
?>
