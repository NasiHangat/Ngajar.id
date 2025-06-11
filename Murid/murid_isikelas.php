<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modul - Ngajar.ID</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100;300;400;500;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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

<body>

    <body class="bg-white-50 font-roboto">
        <div class="flex flex-col min-h-screen">
            <header class="bg-white shadow-sm sticky top-0 z-30">
                <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <button id="hamburgerButton" class="text-teal-500 focus:outline-none mt-1">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        <h1 class="text-xl font-bold text-teal-500 hidden sm:block">Modul</h1>
                    </div>
                    <div class="flex items-center space-x-2 sm:space-x-4">
                        <button class="text-teal-500 hover:text-teal-500 p-2 rounded-full"><i class="fas fa-bell text-xl"></i></button>
                        <button class="text-teal-500 hover:text-teal-500 p-2 rounded-full"><i class="fas fa-user-circle text-xl"></i></button>
                    </div>
                </div>
            </header>
            <?php include "../Includes/sidebar.php" ?>
            <div class="bg-teal-500 py-4">
                <div class="max-w-6xl mx-auto px-4 sm:px-8 flex items-start justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-white flex items-center justify-center">
                            <i class="fa-regular fa-user text-teal-500 text-3xl"></i>
                        </div>
                        <div class="text-white">
                            <h2 class="font-bold text-base sm:text-lg leading-tight "><?php echo $namaPengguna; ?></h2>
                            <p class="text-white-200 opacity-70 text-xs sm:text-sm leading-tight">Pelajar</p>
                            <!-- Token dan tombol tambah diletakkan di bawah -->
                            <div class="mt-2 flex items-center space-x-2">
                                <div class="bg-white text-teal-500 text-xs font-semibold px-2.5 py-1 rounded-lg flex items-center">
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

            <!-- Konten Kelas -->
            <div class="bg-white py-6">
                <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

                    <!-- Header Kelas -->
                    <div class="bg-teal-600 text-white p-6 rounded-xl relative">
                        <h1 class="text-2xl sm:text-3xl font-bold">perbaikan nilai bahasa indonesia</h1>
                        <p class="text-sm sm:text-base mt-1">Kelas XII MM TJA</p>
                        <div class="absolute top-6 right-6">
                            <div class="w-7 h-7 bg-white bg-opacity-20 rounded-full flex items-center justify-center text-white text-sm font-bold">i</div>
                        </div>
                    </div>

                    <!-- Tugas-tugas -->
                    <div class="mt-6 space-y-4">

                        <!-- Tugas: Semester 3 -->
                        <div class="bg-white p-4 shadow rounded-lg flex items-start justify-between">
                            <div class="flex gap-4">
                                <div class="bg-teal-500 text-white p-2 rounded-full">
                                    <i class="fas fa-clipboard text-lg"></i>
                                </div>
                                <div>
                                    <p><strong>Dian NFarida</strong> memposting tugas baru: <strong>semester 3</strong></p>
                                    <p class="text-sm text-gray-500">15 Nov 2022</p>
                                </div>
                            </div>
                            <button class="text-gray-500 hover:text-gray-700">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                        </div>

                        <!-- Tugas: Semester 2 -->
                        <div class="bg-white p-4 shadow rounded-lg flex items-start justify-between">
                            <div class="flex gap-4">
                                <div class="bg-teal-500 text-white p-2 rounded-full">
                                    <i class="fas fa-clipboard text-lg"></i>
                                </div>
                                <div>
                                    <p><strong>Dian NFarida</strong> memposting tugas baru: <strong>semester2</strong></p>
                                    <p class="text-sm text-gray-500">13 Okt 2022</p>
                                </div>
                            </div>
                            <button class="text-gray-500 hover:text-gray-700">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                        </div>

                    </div>
                </div>
            </div>
    </body>

</html>