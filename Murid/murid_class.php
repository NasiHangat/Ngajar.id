<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Ngajar.ID</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="../font.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'roboto-slab': ['"Roboto Slab"', 'serif'],
                        'roboto': ['"Roboto"', 'sans-serif'],
                    },
                    colors: {
                        'ngajar-green': '#00af81',
                        'ngajar-dark-blue': '#003d4e',
                        'ngajar-light-blue': '#32859f',
                        'ngajar-orange': '#fea832',
                        'ngajar-yellow': '#fecd3d',
                        'ngajar-cyan': '#009a99',
                    }
                }
            }
        }
    </script>
</head>
<body >
    <?php include "../Includes/sidebar.php"?>
</body>
    <header class="bg-white shadow-sm sticky top-0 z-30">
    <div class="max-w-6xl mx-auto px-4 py-3 flex items-center space-x-3 sm:space-x-4">
        <div>
            <button class="text-ngajar-green">
                <i class="fas fa-bars text-xl"></i>
            </button>
        </div>
        <div class="flex-grow">
            <div class="flex-grow"> <div class="relative">
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
    </div>
    </header>

<div class="bg-ngajar-green py-4">
    <div class="max-w-6xl mx-auto px-4 flex items-start justify-between">
        <div class="flex items-center space-x-4">
            <img src="https://via.placeholder.com/56" alt="Foto Profil Danul"
                class="w-14 h-14 sm:w-16 sm:h-16 rounded-full border-2 border-white object-cover">
            <div class="text-white">
                <h2 class="font-bold text-base sm:text-lg leading-tight ">Danul</h2>
                <p class="text-white-200 opacity-70 text-xs sm:text-sm leading-tight">Pelajar</p>

                <!-- Token dan tombol tambah diletakkan di bawah -->
                <div class="mt-2 flex items-center space-x-2">
                    <div class="bg-white text-ngajar-green text-xs font-semibold px-2.5 py-1 rounded-lg flex items-center">
                        <img src="../img/coin.png" class="mr-1.5 w-4"></img> 20
                    </div>
                    <button class="bg-white bg-opacity-20 hover:bg-opacity-30 text-white rounded-full w-5 h-5 sm:w-6 sm:h-6 flex items-center justify-center">
                        <i class="fas fa-plus text-sm"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<main class="max-w-6xl mx-auto px-4 py-6">
        <section class="mb-8">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-xl font-bold text-ngajar-green py-2">Kelas</h3>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-14 gap-y-12">
                <div class="w-full max-w-[361px] h-[207px] shadow-lg rounded-lg flex">
                    <div class="w-3 bg-ngajar-dark-blue rounded-l-lg"></div>
                    <div class="flex-grow">
                        <div class="bg-ngajar-cyan h-[90px] rounded-tr-lg p-4 flex justify-between items-start">
                        <div>
                                <h3 class="font-roboto-slab font-bold text-white text-[12.3px] w-48">Kelas Pemrograman Web</h3>
                                <p class="font-roboto-slab text-white text-[10px] mt-8">Nama Relawan</p>
                        </div>
                            <div class="w-14 h-14 bg-white rounded-full flex justify-center items-center shrink-0">
                                <img class="w-6 h-8" src="img/vector-10.svg" alt="Web Programming Icon" />
                            </div>
                        </div>
                        <div class="bg-white p-4 rounded-b-lg">
                            <p class="font-roboto-slab font-bold text-ngajar-dark-blue text-[10px]">Jadwal :</p>
                            <p class="font-roboto-slab font-bold text-ngajar-dark-blue text-[10px] mt-1">Presentasi - 23 Juni 2025</p>
                        </div>
                    </div>
                    <div class="w-4 bg-white flex flex-col items-center py-2 space-y-1.5 rounded-r-lg">
                        <div class="w-1.5 h-1.5 bg-ngajar-dark-blue rounded-full"></div>
                        <div class="w-1.5 h-1.5 bg-ngajar-dark-blue rounded-full"></div>
                        <div class="w-1.5 h-1.5 bg-ngajar-dark-blue rounded-full"></div>
                    </div>
                </div>
                <div class="w-full max-w-[361px] h-[207px] shadow-lg rounded-lg flex">
                    <div class="w-3 bg-ngajar-dark-blue rounded-l-lg"></div>
                    <div class="flex-grow">
                        <div class="bg-ngajar-cyan h-[90px] rounded-tr-lg p-4 flex justify-between items-start">
                            <div>
                                <h3 class="font-roboto-slab font-bold text-white text-[12.3px] w-48">Kelas Pemrograman Web</h3>
                                <p class="font-roboto-slab text-white text-[10px] mt-8">Nama Relawan</p>
                            </div>
                            <div class="w-14 h-14 bg-white rounded-full flex justify-center items-center shrink-0">
                                <img class="w-6 h-8" src="img/vector-8.svg" alt="Web Programming Icon" />
                            </div>
                        </div>
                        <div class="bg-white p-4 rounded-b-lg">
                            <p class="font-roboto-slab font-bold text-ngajar-dark-blue text-[10px]">Jadwal :</p>
                            <p class="font-roboto-slab font-bold text-ngajar-dark-blue text-[10px] mt-1">Presentasi - 23 Juni 2025</p>
                        </div>
                    </div>
                    <div class="w-4 bg-white flex flex-col items-center py-2 space-y-1.5 rounded-r-lg">
                        <div class="w-1.5 h-1.5 bg-ngajar-dark-blue rounded-full"></div>
                        <div class="w-1.5 h-1.5 bg-ngajar-dark-blue rounded-full"></div>
                        <div class="w-1.5 h-1.5 bg-ngajar-dark-blue rounded-full"></div>
                    </div>
                </div>
                <div class="w-full max-w-[361px] h-[207px] shadow-lg rounded-lg flex">
                    <div class="w-3 bg-ngajar-dark-blue rounded-l-lg"></div>
                    <div class="flex-grow">
                        <div class="bg-ngajar-cyan h-[90px] rounded-tr-lg p-4 flex justify-between items-start">
                            <div>
                                <h3 class="font-roboto-slab font-bold text-white text-[12.3px] w-48">Kelas Pemrograman Web</h3>
                                <p class="font-roboto-slab text-white text-[10px] mt-8">Nama Relawan</p>
                            </div>
                            <div class="w-14 h-14 bg-white rounded-full flex justify-center items-center shrink-0">
                                <img class="w-6 h-8" src="img/vector-4.svg" alt="Web Programming Icon" />
                            </div>
                        </div>
                        <div class="bg-white p-4 rounded-b-lg">
                            <p class="font-roboto-slab font-bold text-ngajar-dark-blue text-[10px]">Jadwal :</p>
                            <p class="font-roboto-slab font-bold text-ngajar-dark-blue text-[10px] mt-1">Presentasi - 23 Juni 2025</p>
                        </div>
                    </div>
                    <div class="w-4 bg-white flex flex-col items-center py-2 space-y-1.5 rounded-r-lg">
                        <div class="w-1.5 h-1.5 bg-ngajar-dark-blue rounded-full"></div>
                        <div class="w-1.5 h-1.5 bg-ngajar-dark-blue rounded-full"></div>
                        <div class="w-1.5 h-1.5 bg-ngajar-dark-blue rounded-full"></div>
                    </div>
                </div>
                </div>
        </main>