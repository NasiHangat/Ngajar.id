<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    header('Location: ../Login.php'); // sesuaikan path jika file ada di subfolder
    exit;
}

