<?php
// Mulai sesi
session_start();

// Hapus semua variabel sesi
$_SESSION = array();

// Hancurkan sesi
session_destroy();

// Arahkan ke halaman login atau beranda
echo "<script>alert('Anda telah berhasil logout.');</script>";
header("Location: ../login.php");
exit();
?>
