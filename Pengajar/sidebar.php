<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        robotoSlab: ['"Roboto Slab"', 'serif'],
                    }
                }
            }
        }
    </script>
</head>
<body>
<div id="sidebar" class="w-64 h-screen bg-teal-600 text-white flex flex-col fixed z-50 transform -translate-x-full sidebar-transition">
    <div class="flex items-center justify-center px-6 py-6 border-b border-white/20">
        <h1 class="text-2xl font-bold font-robotoSlab text-center">Ngajar.Id</h1>
    </div>

    <nav class="mt-6 flex-1 space-y-4 px-6">
        <a href="dashboard.php" class="flex items-center space-x-4 hover:text-white/80">
            <i class="fas fa-home text-lg"></i>
            <span class="text-base">Dashboard</span>
        </a>
        <a href="class.php" class="flex items-center space-x-4 hover:text-white/80">
            <i class="fas fa-book-open text-lg"></i>
            <span class="text-base">Kelas Saya</span>
        </a>
        <a href="modul.php" class="flex items-center space-x-4 hover:text-white/80">
            <i class="fas fa-book text-lg"></i>
            <span class="text-base">Modul</span>
        </a>
        <a href="calender.php" class="flex items-center space-x-4 hover:text-white/80">
            <i class="fas fa-calendar-alt text-lg"></i>
            <span class="text-base ml-14">Kalender</span>
        </a>
        <a href="donasi.php" class="flex items-center space-x-4 hover:text-white/80">
            <i class="fas fa-donate text-lg"></i>
            <span class="text-base">Donasi</span>
        </a>
    </nav>
</div>

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

</body>
</html>
