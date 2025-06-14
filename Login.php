<!-- login.php -->

<!-- akun admin: mamanganteng@gmail.com
password: 123 -->
<!DOCTYPE html>
<html lang="id">
<head>
  <title>Login</title>
  <link rel="icon" type="image/png" href="../img/Logo.png">
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

    <form class="w-full max-w-sm space-y-4" method="POST" action="login_proses.php">
      <div>
        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">E-Mail</label>
        <input type="email" id="email" name="email" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500" />
      </div>

      <div>
        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
        <input type="password" id="password" name="password" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500" />
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
