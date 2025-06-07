<?php
session_start();
include 'includes/DBkoneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        echo "<script>alert('Semua field wajib diisi!'); window.location.href='login.php';</script>";
        exit;
    }

    // Ambil data user
    $stmt = $conn->prepare("SELECT user_id, name, email, password, role, status FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            if ($user['status'] !== 'aktif') {
                echo "<script>alert('Akun Anda tidak aktif.'); window.location.href='login.php';</script>";
                exit;
            }

            // SET SESSION
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['name']    = $user['name'];
            $_SESSION['role']    = $user['role'];

            // Redirect sesuai role
            switch ($user['role']) {
                case 'murid':
                    header("Location: Murid/murid_dashboard.php");
                    break;
                case 'pengajar':
                    header("Location: Pengajar/pengajar_dashboard.php");
                    break;
                case 'admin':
                    header("Location: Admin/admin_dashboard.php");
                    break;
                default:
                    echo "<script>alert('Role tidak dikenali.'); window.location.href='login.php';</script>";
                    break;
            }
            exit;
        } else {
            echo "<script>alert('Password salah.'); window.location.href='login.php';</script>";
            exit;
        }

    } else {
        echo "<script>alert('Email tidak ditemukan.'); window.location.href='login.php';</script>";
        exit;
    }
} else {
    header("Location: login.php");
    exit;
}
