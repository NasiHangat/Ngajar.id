<?php include '../Includes/session_check.php'; ?>
<?php include '../Includes/DBkoneksi.php'; ?>
<?php
if ($_SESSION['role'] !== 'murid') {
    header("Location: unauthorized.php");
    exit;
}

$id_pengguna = $_SESSION['user_id'] ?? null;
$namaPengguna = "";

if ($id_pengguna) {
    $stmt = $conn->prepare("SELECT name FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $id_pengguna);
    $stmt->execute();
    $stmt->bind_result($namaPengguna);
    $stmt->fetch();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modul - Ngajar.ID</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="../img/Logo.png">
    <script src="../js/murid.js"></script>
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
                        <button id="hamburgerButton" class="text-teal-500 focus:outline-none">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        <h1 class="text-xl font-bold text-teal-500 hidden sm:block">Modul</h1>
                    </div>
                    <div class="flex items-center space-x-2 sm:space-x-4">
                        <button class="text-teal-500 hover:text-teal-500 p-2 rounded-full"><i class="fas fa-bell text-xl"></i></button>
                        <?php include "../includes/Profile.php"; ?>
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

            <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <section class="mb-8">
                    <div class="flex items-center justify-between mb-3">
                        <h1 class="text-xl font-bold text-teal-500 py-2">Modul Pembelajaran</h1>
                    </div>
                    <div class="flex space-x-8 mb-5">
                        <!-- <button class="bg-teal-500 text-white px-6 py-1 rounded-lg text-sm font-semibold shadow-[0px_4px_1px_0px_#003D4E]">Soal</button>
                        <button class="bg-white text-teal-500 px-6 py-1 rounded-lg text-sm font-semibold shadow-[0px_4px_1px_0px_#003D4E]">PDF</button>
                        <button class="bg-white text-teal-500 px-6 py-1 rounded-lg text-sm font-semibold shadow-[0px_4px_1px_0px_#003D4E]">Video</button> -->
                          <button id="btnSoal" data-target="soal" onclick="modul.toggleModul(this)" class="toggle-modul bg-teal-500 text-white px-6 py-1 rounded-lg text-sm font-semibold shadow-[0px_4px_1px_0px_#003D4E]">Soal</button>
                            <button id="btnPDF" data-target="pdf" onclick="modul.toggleModul(this)" class="toggle-modul bg-white text-teal-500 px-6 py-1 rounded-lg text-sm font-semibold shadow-[0px_4px_1px_0px_#003D4E]">PDF</button>
                            <button id="btnVideo" data-target="video" onclick="modul.toggleModul(this)" class="toggle-modul bg-white text-teal-500 px-6 py-1 rounded-lg text-sm font-semibold shadow-[0px_4px_1px_0px_#003D4E]">Video</button>
                    </div>
                    <!-- Modul Pembelajaran Cards -->
                <div id="modul-soal" class="tab-modul">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-14">
                        <div class="relative w-50 h-70 bg-white shadow-[0px_4px_15px_0px_rgba(0,0,0,0.25)] rounded-xl">
                            <div class="absolute translate-x-[-15px] z-0 w-full h-[90%] bottom-0 left-0 bg-sky-900 rounded-tl-2xl rounded-bl-2xl"></div>
                            <div class="absolute translate-x-[-1px] w-full h-3 bottom-0 z-20 left-0 bg-sky-900 rounded-tr-2xl"></div>
                             <div class="relative w-full rounded-tl-3xl bg-white h-full p-4 z-10">
                                <a href = "murid_isimodul.php">
                                <img class="w-full h-28 object-cover rounded-tl-2xl rounded-tr-2xl" src="https://placehold.co/160x90" alt="Math">
                                <h3 class="text-emerald-500 text-lg font-bold mt-4 text-left">Aljabar Linear</h3>
                                <p class="text-emerald-500 text-sm font-light mt-2 text-left">Deskripsi Singkat</p>
                                <p class="text-emerald-500 py-5 text-sm font-light mt-2 text-right">8 Soal</p>
                            </a>                        
                            </div>
                        </div>
                        <div class="relative w-50 h-70 bg-white shadow-[0px_4px_15px_0px_rgba(0,0,0,0.25)] rounded-xl">
                            <div class="absolute translate-x-[-15px] z-0 w-full h-[90%] bottom-0 left-0 bg-sky-900 rounded-tl-2xl rounded-bl-2xl"></div>
                            <div class="absolute translate-x-[-1px] w-full h-3 bottom-0 z-20 left-0 bg-sky-900 rounded-tr-2xl"></div>
                            <div class="relative w-full rounded-tl-3xl bg-white h-full p-4 z-10">
                                <img class="w-full h-28 object-cover rounded-tl-2xl rounded-tr-2xl" src="https://placehold.co/160x90" alt="Math">
                                <h3 class="text-emerald-500 text-lg font-bold mt-4 text-left">Aljabar Linear</h3>
                                <p class="text-emerald-500 text-sm font-light mt-2 text-left">Deskripsi Singkat</p>
                                <p class="text-emerald-500 py-5 text-sm font-light mt-2 text-right">8 Soal</p>
                            </div>
                        </div>
                        <div class="relative w-50 h-70 bg-white shadow-[0px_4px_15px_0px_rgba(0,0,0,0.25)] rounded-xl">
                            <div class="absolute translate-x-[-15px] z-0 w-full h-[90%] bottom-0 left-0 bg-sky-900 rounded-tl-2xl rounded-bl-2xl"></div>
                            <div class="absolute translate-x-[-1px] w-full h-3 bottom-0 z-20 left-0 bg-sky-900 rounded-tr-2xl"></div>
                            <div class="relative w-full rounded-tl-3xl bg-white h-full p-4 z-10">
                                <img class="w-full h-28 object-cover rounded-tl-2xl rounded-tr-2xl" src="https://placehold.co/160x90" alt="Math">
                                <h3 class="text-emerald-500 text-lg font-bold mt-4 text-left">Aljabar Linear</h3>
                                <p class="text-emerald-500 text-sm font-light mt-2 text-left">Deskripsi Singkat</p>
                                <p class="text-emerald-500 py-5 text-sm font-light mt-2 text-right">8 Soal</p>
                            </div>
                        </div>
                        <div class="relative w-50 h-70 bg-white shadow-[0px_4px_15px_0px_rgba(0,0,0,0.25)] rounded-xl">
                            <div class="absolute translate-x-[-15px] z-0 w-full h-[90%] bottom-0 left-0 bg-sky-900 rounded-tl-2xl rounded-bl-2xl"></div>
                            <div class="absolute translate-x-[-1px] w-full h-3 bottom-0 z-20 left-0 bg-sky-900 rounded-tr-2xl"></div>
                            <div class="relative w-full rounded-tl-3xl bg-white h-full p-4 z-10">
                                <img class="w-full h-28 object-cover rounded-tl-2xl rounded-tr-2xl" src="https://placehold.co/160x90" alt="Math">
                                <h3 class="text-emerald-500 text-lg font-bold mt-4 text-left">Aljabar Linear</h3>
                                <p class="text-emerald-500 text-sm font-light mt-2 text-left">Deskripsi Singkat</p>
                                <p class="text-emerald-500 py-5 text-sm font-light mt-2 text-right">8 Soal</p>
                            </div>
                        </div>
                        <div class="relative w-50 h-70 bg-white shadow-[0px_4px_15px_0px_rgba(0,0,0,0.25)] rounded-xl">
                            <div class="absolute translate-x-[-15px] z-0 w-full h-[90%] bottom-0 left-0 bg-sky-900 rounded-tl-2xl rounded-bl-2xl"></div>
                            <div class="absolute translate-x-[-1px] w-full h-3 bottom-0 z-20 left-0 bg-sky-900 rounded-tr-2xl"></div>
                            <div class="relative w-full rounded-tl-3xl bg-white h-full p-4 z-10">
                                <img class="w-full h-28 object-cover rounded-tl-2xl rounded-tr-2xl" src="https://placehold.co/160x90" alt="Math">
                                <h3 class="text-emerald-500 text-lg font-bold mt-4 text-left">Aljabar Linear</h3>
                                <p class="text-emerald-500 text-sm font-light mt-2 text-left">Deskripsi Singkat</p>
                                <p class="text-emerald-500 py-5 text-sm font-light mt-2 text-right">8 Soal</p>
                            </div>
                        </div>
                    </div>
                </div>

                    <!-- PDF -->
                    <div id="modul-pdf" class="tab-modul hidden">
                          <p class="text-gray-500 ">Belum ada konten PDF.</p>
                    </div>

                    <!-- Video -->
                    <div id="modul-video" class="tab-modul hidden">
                          <p class="text-gray-500 ">Belum ada konten untuk Video.</p>
                    </div>

                </section>

                <section class="mb-8">
                    <div class="flex items-center justify-between mb-3">
                        <h1 class="text-xl font-bold text-teal-500 py-2">Modul Pembelajaran Premium</h1>
                    </div>

                    <div class="flex space-x-8 mb-5">
                        <button id="btnCPNS" data-target="CPNS" onclick="modul.togglePremium(this)" class="toggle-tab bg-teal-500 text-white px-6 py-1 rounded-lg text-sm font-semibold shadow-[0px_4px_1px_0px_#003D4E]">CPNS</button>
                            <button id="btnUTBk" data-target="UTBK" onclick="modul.togglePremium(this)" class="toggle-tab bg-white text-teal-500 px-6 py-1 rounded-lg text-sm font-semibold shadow-[0px_4px_1px_0px_#003D4E]">UTBK</button>
                    </div>
                    <div id="tab-CPNS" class="tab-content">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-14">
                        <div class="relative w-50 h-70 bg-white shadow-[0px_4px_15px_0px_rgba(0,0,0,0.25)] rounded-xl">
                            <div class="absolute translate-x-[-15px] z-0 w-full h-[90%] bottom-0 left-0 bg-sky-900 rounded-tl-2xl rounded-bl-2xl"></div>
                            <div class="absolute translate-x-[-1px] w-full h-3 bottom-0 z-20 left-0 bg-sky-900 rounded-tr-2xl"></div>
                            <div class="relative w-full rounded-tl-3xl bg-white h-full p-4 z-10">
                                <img class="w-full h-28 object-cover rounded-tl-2xl rounded-tr-2xl" src="https://placehold.co/160x90" alt="Math">
                                <h3 class="text-emerald-500 text-lg font-bold mt-4 text-left">Aljabar Linear</h3>
                                <p class="text-emerald-500 text-sm font-light mt-2 text-left">Deskripsi Singkat</p>
                                <p class="text-emerald-500 py-5 text-sm font-light mt-2 text-right">8 Soal</p>
                            </div>
                        </div>
                        <div class="relative w-50 h-70 bg-white shadow-[0px_4px_15px_0px_rgba(0,0,0,0.25)] rounded-xl">
                            <div class="absolute translate-x-[-15px] z-0 w-full h-[90%] bottom-0 left-0 bg-sky-900 rounded-tl-2xl rounded-bl-2xl"></div>
                            <div class="absolute translate-x-[-1px] w-full h-3 bottom-0 z-20 left-0 bg-sky-900 rounded-tr-2xl"></div>
                            <div class="relative w-full rounded-tl-3xl bg-white h-full p-4 z-10">
                                <img class="w-full h-28 object-cover rounded-tl-2xl rounded-tr-2xl" src="https://placehold.co/160x90" alt="Math">
                                <h3 class="text-emerald-500 text-lg font-bold mt-4 text-left">Aljabar Linear</h3>
                                <p class="text-emerald-500 text-sm font-light mt-2 text-left">Deskripsi Singkat</p>
                                <p class="text-emerald-500 py-5 text-sm font-light mt-2 text-right">8 Soal</p>
                            </div>
                        </div>
                        <div class="relative w-50 h-70 bg-white shadow-[0px_4px_15px_0px_rgba(0,0,0,0.25)] rounded-xl">
                            <div class="absolute translate-x-[-15px] z-0 w-full h-[90%] bottom-0 left-0 bg-sky-900 rounded-tl-2xl rounded-bl-2xl"></div>
                            <div class="absolute translate-x-[-1px] w-full h-3 bottom-0 z-20 left-0 bg-sky-900 rounded-tr-2xl"></div>
                            <div class="relative w-full rounded-tl-3xl bg-white h-full p-4 z-10">
                                <img class="w-full h-28 object-cover rounded-tl-2xl rounded-tr-2xl" src="https://placehold.co/160x90" alt="Math">
                                <h3 class="text-emerald-500 text-lg font-bold mt-4 text-left">Aljabar Linear</h3>
                                <p class="text-emerald-500 text-sm font-light mt-2 text-left">Deskripsi Singkat</p>
                                <p class="text-emerald-500 py-5 text-sm font-light mt-2 text-right">8 Soal</p>
                            </div>
                        </div>
                        <div class="relative w-50 h-70 bg-white shadow-[0px_4px_15px_0px_rgba(0,0,0,0.25)] rounded-xl">
                            <div class="absolute translate-x-[-15px] z-0 w-full h-[90%] bottom-0 left-0 bg-sky-900 rounded-tl-2xl rounded-bl-2xl"></div>
                            <div class="absolute translate-x-[-1px] w-full h-3 bottom-0 z-20 left-0 bg-sky-900 rounded-tr-2xl"></div>
                            <div class="relative w-full rounded-tl-3xl bg-white h-full p-4 z-10">
                                <img class="w-full h-28 object-cover rounded-tl-2xl rounded-tr-2xl" src="https://placehold.co/160x90" alt="Math">
                                <h3 class="text-emerald-500 text-lg font-bold mt-4 text-left">Aljabar Linear</h3>
                                <p class="text-emerald-500 text-sm font-light mt-2 text-left">Deskripsi Singkat</p>
                                <p class="text-emerald-500 py-5 text-sm font-light mt-2 text-right">8 Soal</p>
                            </div>
                        </div>
                        <div class="relative w-50 h-70 bg-white shadow-[0px_4px_15px_0px_rgba(0,0,0,0.25)] rounded-xl">
                            <div class="absolute translate-x-[-15px] z-0 w-full h-[90%] bottom-0 left-0 bg-sky-900 rounded-tl-2xl rounded-bl-2xl"></div>
                            <div class="absolute translate-x-[-1px] w-full h-3 bottom-0 z-20 left-0 bg-sky-900 rounded-tr-2xl"></div>
                            <div class="relative w-full rounded-tl-3xl bg-white h-full p-4 z-10">
                                <img class="w-full h-28 object-cover rounded-tl-2xl rounded-tr-2xl" src="https://placehold.co/160x90" alt="Math">
                                <h3 class="text-emerald-500 text-lg font-bold mt-4 text-left">Aljabar Linear</h3>
                                <p class="text-emerald-500 text-sm font-light mt-2 text-left">Deskripsi Singkat</p>
                                <p class="text-emerald-500 py-5 text-sm font-light mt-2 text-right">8 Soal</p>
                            </div>
                        </div>
                    </div>
    </div>

                    <!-- Video -->
                    <div id="tab-UTBK" class="tab-content hidden">
                        <p class="text-gray-500">Konten Video akan ditampilkan di sini.</p>
                    </div>
        
                    
                </section>
            </main>
        <footer>
            <?php include '../includes/Footer.php'; ?>
        </footer>
</body>

</html>