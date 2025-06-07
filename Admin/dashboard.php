<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Ngajar.ID</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../Relawan/warna.css">
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
<body class="bg-white-50 font roboto">
    <div class="flex flex-col min-h-screen">
        <header class="bg-white shadow-sm sticky top-0 z-30">
            <div class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <h1 class="text-xl font-bold text-ngajar-green hidden sm:block">Dashboard</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <button class="text-ngajar-green hover:opacity-75 p-2">
                        <i class="fas fa-bell text-xl"></i>
                    </button>
                    <button class="text-ngajar-green hover:opacity-75 p-2">
                        <i class="fas fa-envelope text-xl"></i>
                    </button>
                    <button class="text-ngajar-green hover:opacity-75 p-2">
                        <i class="fas fa-user text-xl"></i>
                    </button>
                </div>
            </div>
        </header>
        <div class="bg-dashboard-section">
            <div class="max-w-6xl mx-auto px-4 py-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="bg-ngajar-stats-blue text-white p-5 rounded-lg shadow-md">
                        <p class="text-base font-semibold">Total Relawan</p>
                        <p class="text-3xl font-bold mt-1">100</p>
                    </div>
                    <div class="bg-ngajar-stats-blue text-white p-5 rounded-lg shadow-md">
                        <p class="text-base font-semibold">Total Modul</p>
                        <p class="text-3xl font-bold mt-1">100</p>
                    </div>
                    <div class="bg-ngajar-stats-blue text-white p-5 rounded-lg shadow-md">
                        <p class="text-base font-semibold">Total Materi</p>
                        <p class="text-3xl font-bold mt-1">100</p>
                    </div>
                    <div class="bg-ngajar-stats-blue text-white p-5 rounded-lg shadow-md">
                        <p class="text-base font-semibold">Total Siswa</p>
                        <p class="text-3xl font-bold mt-1">100</p>
                    </div>
                </div> </div> </div> <div class="bg-white shadow-sm"> <div class="max-w-6xl mx-auto px-4 py-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-6">
                    
                    <div class="flex flex-col items-start">
                        <h3 class="text-lg font-semibold text-ngajar-green leading-tight">Statistik Top Up Token</h3>
                    </div>
                    <div class="flex flex-col items-start">
                        <h3 class="text-lg font-semibold text-ngajar-green leading-tight">Statistik Total Donasi</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script></script>
</body>
</html>