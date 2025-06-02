<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
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
    <h1 class="text-3xl font-bold mb-2">Daftar</h1>
    <p class="mb-6 text-center text-gray-600">Silahkan Isi Form untuk Membuat Akun Ngajar.ID</p>

    <form class="w-full max-w-sm space-y-4">
      <div>
        <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
        <input type="text" id="nama" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500" />
      </div>

      <div>
        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">E-Mail</label>
        <input type="email" id="email" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500" />
      </div>

      <div>
        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
        <input type="password" id="password" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500" />
      </div>

      <div>
        <label for="konfirmasi" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
        <input type="password" id="konfirmasi" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500" />
      </div>

      <div>
        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
        <select id="status" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500">
          <option value="" disabled selected></option>
          <option value="pengajar">Pengajar</option>
          <option value="murid">Murid</option>
        </select>
      </div>

      <button type="submit" class="w-full py-2 bg-teal-600 text-white rounded hover:bg-teal-700">Daftar</button>

      <p class="text-center text-sm">Sudah memiliki akun? <a href="login.php" class="text-teal-600 font-medium">Masuk</a></p>

      <p class="text-xs text-center text-gray-500">Dengan membuat akun, saya setuju dengan <a href="#" class="underline">Syarat dan Ketentuan</a>, dan <a href="#" class="underline">Kebijakan Privasi</a> Ngajar.ID.</p>
    </form>
  </div>

  <footer>
    <?php include 'includes/Footer.php'; ?>
  </footer>

</body>

</html>