<!DOCTYPE html>
<html lang="id" x-data="{ open: false }" xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <title>Popup Profil</title>
</head>

<body class="bg-gray-900 min-h-screen flex items-center justify-center">
  <div class="relative" x-data="{ showProfile: false }">
    <!-- Tombol ikon user -->
    <button @click="showProfile = !showProfile" class="text-teal-500 hover:text-teal-500 p-2 rounded-full focus:outline-none">
      <i class="fas fa-user-circle text-xl"></i>
    </button>

    <!-- Popup Profil -->
    <div
      x-show="showProfile"
      @click.outside="showProfile = false"
      x-transition
      class="absolute right-0 mt-2 w-72 bg-white text-black shadow-lg rounded-lg p-4 z-50">
      <div class="flex flex-col items-center text-center">
        <h2 class="text-lg font-bold"><?php echo $namaPengguna; ?></h2>
        <p class="text-white-200 opacity-70 text-xs sm:text-sm leading-tight">Pelajar</p>
        <p class="text-sm text-gray-500"><?php echo $_SESSION['email'] ?? 'murid@email.com'; ?></p>
        </a>
      </div>
    </div>
  </div>
</body>
</html>