<?php
$namaPengguna = $_SESSION['name'] ?? 'Pengguna';
$emailPengguna = $_SESSION['email'] ?? 'user@email.com';
$rolePengguna = ucfirst($_SESSION['role'] ?? 'guest'); // Menjadi "Admin", "Pengajar", atau "Murid"
?>
<!DOCTYPE html>
<html lang="id" x-data="{ open: false }" xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <title>Popup Profil</title>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">

  <div class="relative" x-data="{ showProfile: false }">
    <!-- Tombol ikon user -->
    <button @click="showProfile = !showProfile" class="text-teal-600 hover:text-teal-700 p-2 rounded-full focus:outline-none">
      <i class="fas fa-user-circle text-3xl"></i>
    </button>

    <!-- Popup Profil -->
    <div x-show="showProfile"
      @click.outside="showProfile = false"
      x-transition
      class="absolute right-0 mt-2 w-72 bg-white text-black shadow-lg rounded-lg p-4 z-50">
      <div class="flex flex-col items-center text-center space-y-1">
        <div class="text-teal-600 font-bold text-lg"><?php echo htmlspecialchars($namaPengguna); ?></div>
        <div class="text-xs px-3 py-0.5 bg-teal-100 text-teal-700 rounded-full mt-1 uppercase tracking-wide"><?php echo htmlspecialchars($rolePengguna); ?></div>
        <div class="text-sm text-gray-500"><?php echo htmlspecialchars($emailPengguna); ?></div>
      </div>
    </div>
  </div>

</body>
</html>