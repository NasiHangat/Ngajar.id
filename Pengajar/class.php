<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Ngajar.ID</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="warna.css">
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
<body class="bg-white-50 font-roboto">
    <div class="flex flex-col min-h-screen">
        <header class="bg-white shadow-sm sticky top-0 z-30">
            <div class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <button id="hamburgerButton" class="text-ngajar-green focus:outline-none">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <h1 class="text-xl font-bold text-ngajar-green hidden sm:block">My Class</h1>
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
        <?php include "sidebar.php" ?>;
        <main class="flex-grow gradient-bg">
            <div class="max-w-6xl mx-auto px-4 py-6">
                <!-- Add Class Button -->
                <div class="mb-6">
                    <button class="bg-ngajar-green text-white px-4 py-2 rounded-lg font-medium flex items-center space-x-2 hover:opacity-90 transition-opacity">
                        <i class="fas fa-plus"></i>
                        <span>Tambah Kelas</span>
                    </button>
                </div>
                <?php ?>
                <!-- Section Title -->
                <div class="mb-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Kelas Yang Dibina</h2>
                    
                    <!-- Filter Buttons -->
                    <div class="flex justify-end space-x-2 mb-4">
                        <button class="bg-white px-4 py-2 rounded-lg text-sm font-medium text-gray-700 border border-gray-200 hover:bg-gray-50">
                            Kelas Saya
                            <i class="fas fa-chevron-down ml-2"></i>
                        </button>
                        <button class="bg-ngajar-green text-white px-4 py-2 rounded-lg text-sm font-medium hover:opacity-90">
                            <i class="fas fa-sort-amount-down mr-2"></i>
                            Urutkan kelas
                        </button>
                    </div>
                </div>

                <!-- Class Cards Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Fundamental Crypto Card -->
                    <div class="bg-ngajar-green rounded-2xl p-6 text-white relative overflow-hidden">
                        <div class="flex items-start justify-between mb-4">
                            <div class="bg-white bg-opacity-20 rounded-lg p-3">
                                <i class="fas fa-bitcoin text-2xl"></i>
                            </div>
                            <div class="flex space-x-2">
                                <button class="bg-white bg-opacity-20 rounded-lg p-2 hover:bg-opacity-30 transition-colors">
                                    <i class="fas fa-edit text-sm"></i>
                                </button>
                                <button class="bg-white bg-opacity-20 rounded-lg p-2 hover:bg-opacity-30 transition-colors">
                                    <i class="fas fa-archive text-sm"></i>
                                </button>
                            </div>
                        </div>
                        
                        <h3 class="text-lg font-bold mb-2">Fundamental Crypto</h3>
                        <div class="space-y-1 text-sm opacity-90">
                            <p>20 siswa</p>
                            <p>100 jam</p>
                            <p>5 Modul</p>
                        </div>

                        <!-- Decorative elements -->
                        <div class="absolute -bottom-4 -right-4 w-20 h-20 bg-white bg-opacity-10 rounded-full"></div>
                        <div class="absolute -top-8 -right-8 w-16 h-16 bg-white bg-opacity-5 rounded-full"></div>
                    </div>

                    <!-- Empty Card Placeholder -->
                    <div class="bg-ngajar-green rounded-2xl p-6 text-white relative overflow-hidden opacity-50">
                        <div class="flex items-center justify-center h-full min-h-[200px]">
                            <div class="text-center">
                                <i class="fas fa-plus text-4xl mb-4 opacity-50"></i>
                                <p class="text-lg opacity-75">Tambah Kelas Baru</p>
                            </div>
                        </div>
                        <!-- Decorative elements -->
                        <div class="absolute -bottom-4 -right-4 w-20 h-20 bg-white bg-opacity-10 rounded-full"></div>
                        <div class="absolute -top-8 -right-8 w-16 h-16 bg-white bg-opacity-5 rounded-full"></div>
                    </div>

                    <!-- Web Development Card (if needed) -->
                    <div class="bg-blue-500 rounded-2xl p-6 text-white relative overflow-hidden">
                        <div class="flex items-start justify-between mb-4">
                            <div class="bg-white bg-opacity-20 rounded-lg p-3">
                                <i class="fas fa-laptop-code text-2xl"></i>
                            </div>
                            <div class="flex space-x-2">
                                <button class="bg-white bg-opacity-20 rounded-lg p-2 hover:bg-opacity-30 transition-colors">
                                    <i class="fas fa-edit text-sm"></i>
                                </button>
                                <button class="bg-white bg-opacity-20 rounded-lg p-2 hover:bg-opacity-30 transition-colors">
                                    <i class="fas fa-archive text-sm"></i>
                                </button>
                            </div>
                        </div>
                        
                        <h3 class="text-lg font-bold mb-2">Web Development Dasar</h3>
                        <div class="space-y-1 text-sm opacity-90">
                            <p>35 siswa</p>
                            <p>120 jam</p>
                            <p>8 Modul</p>
                        </div>

                        <!-- Decorative elements -->
                        <div class="absolute -bottom-4 -right-4 w-20 h-20 bg-white bg-opacity-10 rounded-full"></div>
                        <div class="absolute -top-8 -right-8 w-16 h-16 bg-white bg-opacity-5 rounded-full"></div>
                        
                    </div>
                </div>
            </div>
        </main>
    </div>
<script src="validasi_sidebar,js">
</script>
</body>
</html>