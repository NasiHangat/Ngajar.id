<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Ngajar.Id</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100;300;400;500;600;700;900&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
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

<body class="bg-white font-roboto">
  <header class="shadow-md">
    <div class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
      <a href="index.php" class="text-teal-500 font-bold text-xl">Ngajar.Id</a>

      <nav class="flex space-x-6 text-sm text-gray-900 font-medium">
        <a href='index.php' class="hover:text-teal-500">Home</a>
        <a href="donasi.php" class="hover:text-teal-500">Donasi</a>
        <a href="TentangKami.php" class="hover:text-teal-500">Tentang Kami</a>
      </nav>

      <div class="flex space-x-3">
        <a href="Login.php" class="px-4 py-1 border border-teal-500 text-teal-500 rounded hover:bg-teal-50 text-sm">Masuk</a>
        <a href="Register.php" class="px-4 py-1 bg-teal-500 text-white rounded hover:bg-teal-600 text-sm">Daftar</a>
      </div>
    </div>
  </header>
</body>

</html>