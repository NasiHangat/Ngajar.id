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
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-white-50 font-roboto">
    <header class="bg-white shadow-sm sticky top-0 z-30">
    <div class="max-w-6xl mx-auto px-4 py-3 flex items-center space-x-3 sm:space-x-4">
        <div>
            <button id="hamburgerButton" class="text-teal-500">
                <i class="fas fa-bars text-xl"></i>
            </button>
        </div>
        <div class="flex-grow">
            <div class="flex-grow"> <div class="relative">
                        <input type="text" placeholder="Belajar Apa hari ini?"
                            class="bg-search border border-teal=500-lighter text-sm rounded-full 
                                    py-2 px-4 pl-10 focus:outline-none focus:border-teal=500 
                                    block w-full transition-all">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-teal-500 opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </header>
    <?php include "sidebar.php"?>
    <div class="bg-white py-4">
    <div class="bg-teal-500 py-4">
        <div class="max-w-6xl mx-auto px-4 flex items-start justify-between">
            <div class="flex items-center space-x-4">
                <img src="https://via.placeholder.com/56" alt="Foto Profil Danul"
                    class="w-14 h-14 sm:w-16 sm:h-16 rounded-full border-2 border-white object-cover">
                <div class="text-white">
                    <h2 class="font-bold text-base sm:text-lg leading-tight ">Danul</h2>
                    <p class="text-white-200 opacity-70 text-xs sm:text-sm leading-tight">Pelajar</p>
                    <!-- Token dan tombol tambah diletakkan di bawah -->
                    <div class="mt-2 flex items-center space-x-2">
                        <div class="bg-white text-teal-500 text-xs font-semibold px-2.5 py-1 rounded-lg flex items-center">
                            <img src="coin.png" class="mr-1.5 w-4"></img> 20
                        </div>
                        <button class="bg-white bg-opacity-20 hover:bg-opacity-30 text-white rounded-full w-5 h-5 sm:w-6 sm:h-6 flex items-center justify-center">
                            <i class="fas fa-plus text-sm"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <section class="mb-8">
                <h3 class="text-2xl font-bold text-teal-500 py-2">Pembelajaran</h3>
                <div class="flex space-x-3 my-4">
                    <a href="modul.php" class="bg-teal-500 text-white px-6 py-2 rounded-lg text-sm font-bold border-l-2 border-r-2 border-b-4 border-[var(--border-blue-dark)] shadow-md" style="--border-blue-dark: #003D4E;">Modul</a>
                    <a href="class.php" class="bg-white text-teal-500 px-7 py-2 rounded-lg text-sm font-bold border-l-2 border-r-2 border-b-4 border-[var(--border-blue-dark)] shadow-md" style="--border-blue-dark: #003D4E;">Kelas</a>
                </div>
                <div>
                    <div class="mb-3">
                        <a href="#" class="inline-flex items-center text-xl font-bold text-teal-500 hover:text-opacity-80 transition-colors">
                            <span>Modul Pembelajaran</span>
                            <i class="fas fa-chevron-right ml-2 text-base"></i>
                        </a>
                    </div>
                    <div class="border-l-4 border-r-4 border-b-4 border-[#003F4A] shadow-lg rounded-xl p-4 bg-white">
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <a href="#" class="block bg-white p-3 rounded-lg border-l-4 border-b-2 border-t-2 border-[#003F4A] shadow-sm hover:shadow-md transition-shadow text-center">
                                <p class="text-sm font-bold text-teal-500">Matematika</p>
                            </a>
                            <a href="#" class="block bg-gray-50 p-3 rounded-lg border-l-4 border-b-2 border-t-2 border-[#003F4A] shadow-sm hover:shadow-md transition-shadow text-center">
                                <p class="text-sm font-bold text-teal-500">Fisika</p>
                            </a>
                            <a href="#" class="block bg-gray-50 p-3 rounded-lg border-l-4 border-b-2 border-t-2 border-[#003F4A] shadow-sm hover:shadow-md transition-shadow text-center">
                                <p class="text-sm font-bold text-teal-500">Kimia</p>
                            </a>
                            <a href="#" class="block bg-gray-50 p-3 rounded-lg border-l-4 border-b-2 border-t-2 border-[#003F4A] shadow-sm hover:shadow-md transition-shadow text-center">
                                <p class="text-sm font-bold text-teal-500">Biologi</p>
                            </a>
                            <a href="#" class="block bg-gray-50 p-3 rounded-lg border-l-4 border-b-2 border-t-2 border-[#003F4A] shadow-sm hover:shadow-md transition-shadow text-center">
                                <p class="text-sm font-bold text-teal-500">Bahasa Indonesia</p>
                            </a>
                            <a href="#" class="block bg-gray-50 p-3 rounded-lg border-l-4 border-b-2 border-t-2 border-[#003F4A] shadow-sm hover:shadow-md transition-shadow text-center">
                                <p class="text-sm font-bold text-teal-500">Bahasa Inggris</p>
                            </a>
                            <a href="#" class="block bg-gray-50 p-3 rounded-lg border-l-4 border-b-2 border-t-2 border-[#003F4A] shadow-sm hover:shadow-md transition-shadow text-center">
                                <p class="text-sm font-bold text-teal-500">Pendidikan Kewarganegaraan</p>
                            </a>
                            <a href="#" class="block bg-gray-50 p-3 rounded-lg border-l-4 border-b-2 border-t-2 border-[#003F4A] shadow-sm hover:shadow-md transition-shadow text-center">
                                <p class="text-sm font-bold text-teal-500">Sejarah</p>
                            </a>
                        </div>
                    </div>
            </section>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Modul Premium -->
                <section>
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-bold tteal-500">Modul Premium</h3>
                        <a href="#" class="text-teal-500 text-sm font-bold flex items-center"><i class="fas fa-chevron-right ml-2 text-xs"></i></a>
                    </div>
                    <div class="relative">
                        <div class="absolute top-2 right-2 w-full h-full bg-[#003F4A] rounded-lg z-0"></div>
                        <div class="relative w-full bg-white border-4 border-[#003F4A] rounded-lg z-10 p-5">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div class="flex items-center space-x-4"><div class="bg-teal-500 text-white font-bold p-4 py-8 border-l-8 border-[#003F4A] rounded-lg shadow-md">UTBK</div><div><p class="text-teal-500 font-bold">Tes soal UTBK</p><div class="flex items-center text-sm mt-1"><img src="coin.png" class="mr-1.5"></img><p class="text-teal-500 font-bold">100</p></div></div></div>
                                <div class="flex items-center space-x-4"><div class="bg-teal-500 text-white font-bold p-4 py-8 border-l-8 border-[#003F4A] rounded-lg shadow-md">CPNS</div><div><p class="text-teal-500 font-bold">Tes soal CPNS</p><div class="flex items-center text-sm mt-1"><img src="coin.png" class="mr-1.5"></img><p class="text-teal-500 font-bold">100</p></div></div></div>
                                <div class="flex items-center space-x-4"><div class="bg-teal-500 text-white font-bold p-4 py-8 border-l-8 border-[#003F4A] rounded-lg shadow-md">BUMN</div><div><p class="text-teal-500 font-bold">Tes soal BUMN</p><div class="flex items-center text-sm mt-1"><img src="coin.png" class="mr-1.5"></img></i><p class="text-teal-500 font-bold">100</p></div></div></div>
                                <div class="flex items-center space-x-4"><div class="bg-teal-500 text-white font-bold p-4 py-8 border-l-8 border-[#003F4A] rounded-lg shadow-md">AKPOL</div><div><p class="text-teal-500 font-bold">Tes soal AKPOL</p><div class="flex items-center text-sm mt-1"><img src="coin.png" class="mr-1.5"></img></i><p class="text-teal-500 font-bold">100</p></div></div></div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Terakhir Dipelajari -->
                <section>
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-bold text-teal-500">Terakhir Dipelajari</h3>
                        <a href="#" class="text-teal-500 text-sm font-bold flex items-center"><i class="fas fa-chevron-right ml-2 text-xs"></i></a>
                    </div>
                    <div class="relative">
                        <div class="absolute top-2 right-2 w-full h-full bg-[#003F4A] rounded-lg z-0"></div>
                        <div class="relative w-full h-full bg-white border-4 border-[#003F4A] rounded-lg z-10 p-5 space-y-3">
                            <a href="#" class="flex items-center space-x-4 p-3 rounded-lg hover:bg-gray-100 transition-colors"><div class="flex-shrink-0 w-12 h-12 rounded-lg bg-teal-500 text-white flex items-center justify-center border-l-4 border-[#003F4A]"><i class="fa-solid fa-calculator text-2xl"></i></div><div class="flex-grow"><h5 class="text-m font-bold text-teal-500">Aljabar Linear</h5><p class="text-xs text-teal-500">Deskripsi Singkat</p></div><span class="text-xs font-bold text-teal-500">12 Soal</span></a>
                            <a href="#" class="flex items-center space-x-4 p-3 rounded-lg hover:bg-gray-100 transition-colors"><div class="flex-shrink-0 w-12 h-12 rounded-lg bg-teal-500 text-white flex items-center justify-center border-l-4 border-[#003F4A]"><i class="fa-solid fa-calculator text-2xl"></i></div><div class="flex-grow"><h5 class="text-m font-bold text-teal-500">Aljabar Linear</h5><p class="text-xs text-teal-500">Deskripsi Singkat</p></div><span class="text-xs font-bold text-teal-500">12 Soal</span></a>
                            <a href="#" class="flex items-center space-x-4 p-3 rounded-lg hover:bg-gray-100 transition-colors"><div class="flex-shrink-0 w-12 h-12 rounded-lg bg-teal-500 text-white flex items-center justify-center border-l-4 border-[#003F4A]"><i class="fa-solid fa-calculator text-2xl"></i></div><div class="flex-grow"><h5 class="text-m font-bold text-teal-500">Aljabar Linear</h5><p class="text-xs text-teal-500">Deskripsi Singkat</p></div><span class="text-xs font-bold text-teal-500">12 Soal</span></a>
                            <a href="#" class="flex items-center space-x-4 p-3 rounded-lg hover:bg-gray-100 transition-colors"><div class="flex-shrink-0 w-12 h-12 rounded-lg bg-teal-500 text-white flex items-center justify-center border-l-4 border-[#003F4A]"><i class="fa-solid fa-calculator text-2xl"></i></div><div class="flex-grow"><h5 class="text-m font-bold text-teal-500">Aljabar Linear</h5><p class="text-xs text-teal-500">Deskripsi Singkat</p></div><span class="text-xs font-bold text-teal-500">12 Soal</span></a>
                        </div>
                    </div>
                </section>
            </div>
    </main>
</body>
</html>
