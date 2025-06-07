<?php include '../Includes/session_check.php'; ?>
<?php include '../Includes/DBkoneksi.php'; ?>
<?php
if ($_SESSION['role'] !== 'murid') {
   header("Location: unauthorized.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Ngajar.ID</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../styles/warna.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'ngajar-green': '#2c7a7b',
                        'ngajar-green-lighter': '#4fd1c5',
                        'search': '#f7fafc',
                    },
                },
            }
        }
    </script>
</head>
<body class="bg-white-50 font-sans">

<header class="bg-white shadow-sm sticky top-0 z-30">
    <div class="max-w-6xl mx-auto px-4 py-3 flex items-center space-x-3 sm:space-x-4">
        <div>
            <button id="hamburgerButton" class="text-ngajar-green">
                <i class="fas fa-bars text-xl"></i>
            </button>
        </div>
        <div class="flex-grow">
            <div class="relative">
                <input type="text" placeholder="Mau liat apa?" 
                    class="bg-search border border-ngajar-green-lighter text-sm rounded-full 
                    py-2 px-4 pl-10 focus:outline-none focus:border-ngajar-green 
                    block w-full transition-all"> 
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-ngajar-green opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
</header>

<?php include '../Includes/sidebar.php'; ?>

<div class="bg-ngajar-green py-4">
    <div class="max-w-6xl mx-auto px-4 flex items-start justify-between">
        <div class="flex items-center space-x-4">
            <img src="https://via.placeholder.com/56" alt="Foto Profil"
                class="w-14 h-14 sm:w-16 sm:h-16 rounded-full border-2 border-white object-cover">
            <div class="text-white">
                <h2 class="font-bold text-base sm:text-lg leading-tight">
                    <?= htmlspecialchars($_SESSION['nama']) ?>
                </h2>
                <p class="text-gray-200 text-xs sm:text-sm leading-tight">
                    <?= ucfirst($_SESSION['role']) ?>
                </p>
                <div class="mt-2 flex items-center space-x-2">
                    <div class="bg-yellow-400 text-black text-xs font-semibold px-2.5 py-1 rounded-full flex items-center">
                        <i class="fas fa-coins mr-1.5 text-yellow-700"></i> 20
                    </div>
                    <button class="bg-white bg-opacity-20 hover:bg-opacity-30 text-white rounded-full w-7 h-7 sm:w-8 sm:h-8 flex items-center justify-center focus:outline-none transition-colors duration-150">
                        <i class="fas fa-plus text-sm"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<main class="flex-1">
    <!-- Konten dashboard murid di sini -->
</main>

<!-- Overlay dan Script Sidebar -->
<div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden"></div>

<script>
    const hamburgerButton = document.getElementById('hamburgerButton');
    const sidebar = document.getElementById('sidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');

    if (hamburgerButton && sidebar && sidebarOverlay) {
        function toggleSidebar() {
            sidebar.classList.toggle('-translate-x-full');
            sidebar.classList.toggle('translate-x-0');
            sidebarOverlay.classList.toggle('hidden');
        }

        hamburgerButton.addEventListener('click', toggleSidebar);
        sidebarOverlay.addEventListener('click', toggleSidebar);
    }
</script>
<script src="js/validasi_sidebar.js"></script>

</body>
</html>
