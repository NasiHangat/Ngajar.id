<?php
session_start();
include 'Includes/DBkoneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        echo "<script>alert('Semua field wajib diisi!'); window.history.back();</script>";
        exit;
    }

    // Ambil data user dari DB
    $stmt = $conn->prepare("SELECT user_id, name, email, password, role, status FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Cek jika user ditemukan
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            // Cek status aktif
            if ($user['status'] !== 'aktif') {
                echo "<script>alert('Akun Anda tidak aktif.'); window.history.back();</script>";
                exit;
            }

            // Set session
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['name']    = $user['name'];
            $_SESSION['role']    = $user['role'];

            // Redirect berdasarkan role
            switch ($user['role']) {
                case 'murid':
                    header("Location: Murid/dashboard.php");
                    break;
                case 'pengajar':
                    header("Location: Pengajar/dashboard.php");
                    break;
                case 'admin':
                    header("Location: Admin/dashboard.php");
                    break;
                default:
                    echo "<script>alert('Role tidak dikenali.');</script>";
                    break;
            }
            exit;

        } else {
            echo "<script>alert('Password salah.'); window.history.back();</script>";
            exit;
        }

    } else {
        echo "<script>alert('Email tidak ditemukan.'); window.history.back();</script>";
        exit;
    }
}
?>


<!DOCTYPE html>
<html lang="id">
<?php include 'Includes/DBkoneksi.php'; ?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100;300;400;500;600;700;900&display=swap" rel="stylesheet">
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            roboto: ['"Roboto Slab"', 'serif'],
          }
        }
      }
    }
  </script>
</head>

<body class="flex flex-col min-h-screen justify-between font-roboto">

  <header>
    <?php include 'includes/Header.php'; ?>
  </header>

  <div class="flex flex-col items-center justify-start pt-20 mb-20 px-4">
    <h1 class="text-3xl font-bold mb-2">Masuk</h1>
    <p class="mb-6 text-center text-gray-600">Silahkan Masukkan Akun Ngajar.ID</p>

    <form class="w-full max-w-sm space-y-4" method="POST" action="">
      <div>
        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">E-Mail</label>
        <input type="email" id="email" placeholder="" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500" />
      </div>

      <div>
        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
        <input type="password" id="password" placeholder="" name="password" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500" />
      </div>

      <button type="submit" class="w-full py-2 bg-teal-600 text-white rounded hover:bg-teal-700">Masuk</button>

      <p class="text-center text-sm">Belum memiliki akun? <a href="Register.php" class="text-teal-600 font-medium">Daftar</a></p>
    </form>
  </div>

  <footer>
    <?php include 'includes/Footer.php'; ?>
  </footer>

</body>

</html>