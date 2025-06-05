<?php
$namaPengguna = "Kak Azis";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Ngajar.ID</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="warna.css">
    </style>
</head>
<body class="bg-white-50 font-sans">
    <div class="flex flex-col min-h-screen">
        <header class="bg-white shadow-sm sticky top-0 z-30">
            <div class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <button id="hamburgerButton" class="text-ngajar-green focus:outline-none">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <h1 class="text-xl font-bold text-ngajar-green hidden sm:block">Dashboard</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <input type="text" placeholder="Mau liat apa?" class="bg-search border border-ngajar-green-lighter text-sm rounded-full py-2 px-4 pl-10 focus:outline-none focus:border-ngajar-green w-40 sm:w-64 transition-all">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-ngajar-green opacity-75"></i>
                        </div>
                    </div>
                    <button class="text-ngajar-green hover:opacity-75 p-2">
                        <i class="fas fa-bell text-xl"></i>
                    </button>
                    <button class="text-ngajar-green hover:opacity-75 p-2">
                        <i class="fas fa-envelope text-xl"></i>
                    </button>
                    <button class="text-ngajar-green hover:opacity-75 p-2">
                        <i class="fas fa-user text xl"></i>
                    </button>
                </div>
            </div>
        </header>
        <?php include "sidebar.php" ?>;
        <main class="flex-grow">
            <div class="max-w-6xl mx-auto px-4 py-12">
                
                <!-- Banner Sambutan -->
                <div class="bg-ngajar-banner-teal text-white p-6 sm:p-8 rounded-xl shadow-lg mb-10 flex items-center space-x-4">
                    <div>
                        <i class="fas fa-user-circle text-6xl sm:text-7xl opacity-80"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-semibold mb-2">Terimakasih, John Doe</h2>
                        <p class="text-sm sm:text-base opacity-90">Idealisme adalah kemewahan terakhir yang hanya dimiliki oleh pemuda.</p>
                    </div>
                </div>

                <!-- Statistik Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                    <div class="bg-ngajar-stats-blue text-white p-6 rounded-xl shadow-md flex items-center space-x-4 hover:shadow-lg transition-shadow">
                        <div>
                            <i class="fas fa-graduation-cap text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium opacity-90">Total Kelas Dibina</p>
                            <p class="text-2xl sm:text-3xl font-bold">100</p>
                        </div>
                    </div>
                    <div class="bg-ngajar-stats-blue text-white p-6 rounded-xl shadow-md flex items-center space-x-4 hover:shadow-lg transition-shadow">
                        <div>
                            <i class="fas fa-book text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium opacity-90">Modul Yang Dibuat</p>
                            <p class="text-2xl sm:text-3xl font-bold">100</p>
                        </div>
                    </div>
                    <div class="bg-ngajar-stats-blue text-white p-6 rounded-xl shadow-md flex items-center space-x-4 hover:shadow-lg transition-shadow">
                        <div>
                            <i class="fas fa-clock text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium opacity-90">Jam Mengajar</p>
                            <p class="text-2xl sm:text-3xl font-bold">100</p>
                        </div>
                    </div>
                    <div class="bg-ngajar-stats-blue text-white p-6 rounded-xl shadow-md flex items-center space-x-4 hover:shadow-lg transition-shadow">
                        <div>
                            <i class="fas fa-users text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium opacity-90">Siswa Terbantu</p>
                            <p class="text-2xl sm:text-3xl font-bold">100</p>
                        </div>
                    </div>
                </div>

                <!-- Content Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Kegiatan Terbaru -->
                    <div class="lg:col-span-2 bg-white p-6 sm:p-8 rounded-xl shadow-md">
                        <h3 class="text-xl sm:text-2xl font-semibold text-ngajar-content-teal mb-6">Kegiatan Terbaru</h3>
                        <div class="space-y-5">
                            <div class="flex items-start space-x-4">
                                <p class="text-sm text-gray-500 whitespace-nowrap pt-1 min-w-16">23 Maret</p>
                                <p class="text-base text-gray-700">Mengunggah Modul "<span class="font-medium text-ngajar-content-teal">Belajar Cripto</span>"</p>
                            </div>
                            <div class="border-t border-gray-100"></div>
                            <div class="flex items-start space-x-4">
                                <p class="text-sm text-gray-500 whitespace-nowrap pt-1 min-w-16">22 Maret</p>
                                <p class="text-base text-gray-700">Membuat kelas baru "<span class="font-medium text-ngajar-content-teal">Matematika Dasar</span>"</p>
                            </div>
                            <div class="border-t border-gray-100"></div>
                            <div class="flex items-start space-x-4">
                                <p class="text-sm text-gray-500 whitespace-nowrap pt-1 min-w-16">21 Maret</p>
                                <p class="text-base text-gray-700">Menyelesaikan modul "<span class="font-medium text-ngajar-content-teal">Aljabar Linear</span>"</p>
                            </div>
                        </div>
                    </div>

                    <!-- Kelas Yang Dibina -->
                    <div class="bg-white p-6 sm:p-8 rounded-xl shadow-md">
                        <h3 class="text-xl sm:text-2xl font-semibold text-ngajar-content-teal mb-6">Kelas Yang Dibina</h3>
                        <div class="space-y-4">
                            <div class="border border-gray-200 rounded-lg p-4 flex items-center space-x-4 hover:shadow-sm transition-shadow">
                                <div class="p-3 bg-ngajar-content-teal bg-opacity-10 rounded-lg flex-shrink-0">
                                    <i class="fas fa-chalkboard-teacher text-2xl text-ngajar-content-teal"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-base text-gray-800">Aljabar Linear</h4>
                                    <p class="text-sm text-gray-500">25 siswa aktif</p>
                                </div>
                            </div>
                            <div class="border border-gray-200 rounded-lg p-4 flex items-center space-x-4 hover:shadow-sm transition-shadow">
                                <div class="p-3 bg-ngajar-content-teal bg-opacity-10 rounded-lg flex-shrink-0">
                                    <i class="fas fa-calculator text-2xl text-ngajar-content-teal"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-base text-gray-800">Matematika Dasar</h4>
                                    <p class="text-sm text-gray-500">18 siswa aktif</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
<script src="validasi_sidebar.js">
    
</script>
</body>
</html>