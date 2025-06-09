<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modul - Ngajar.ID</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <header class="bg-white shadow-sm sticky top-0 z-30">
        <div class="max-w-6xl mx-auto px-4 sm:px-8 py-3 flex items-center space-x-3 sm:space-x-4">
            <div>
                <button id="hamburgerButton" class="text-teal-500">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
            <div class="flex-grow">
                <div class="relative">
                    <input type="text"
                            placeholder="Mau liat apa?"
                            class="bg-search border border-teal-500-lighter text-sm rounded-full py-2 px-4 pl-10
                                focus:outline-none focus:border-teal-500 block w-full transition-all">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-teal-500 opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <?php include "../Includes/sidebar.php"?>
    <div class="bg-teal-500 py-4">
        <div class="max-w-6xl mx-auto px-4 sm:px-8 flex items-start justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-white flex items-center justify-center">
                    <i class="fa-regular fa-user text-teal-500 text-3xl"></i>
                </div>
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
            <div class="flex items-center justify-between mb-3">
                <h1 class="text-xl font-bold text-teal-500 py-2">Materi</h1>
            </div>
            <div class="flex space-x-8 mb-5">
                <button class="bg-teal-500 text-white px-6 py-1 rounded-lg text-sm font-semibold shadow-[0px_4px_1px_0px_#003D4E]">Matematika</button>
                <button class="bg-white text-teal-500 px-6 py-1 rounded-lg text-sm font-semibold shadow-[0px_4px_1px_0px_#003D4E]">Fisika</button>
                <button class="bg-white text-teal-500 px-6 py-1 rounded-lg text-sm font-semibold shadow-[0px_4px_1px_0px_#003D4E]">Kimia</button>
                <button class="bg-white text-teal-500 px-6 py-1 rounded-lg text-sm font-semibold shadow-[0px_4px_1px_0px_#003D4E]">Biologi</button>
                <button class="bg-white text-teal-500 px-6 py-1 rounded-lg text-sm font-semibold shadow-[0px_4px_1px_0px_#003D4E]">B.indonesia</button>
                <button class="bg-white text-teal-500 px-6 py-1 rounded-lg text-sm font-semibold shadow-[0px_4px_1px_0px_#003D4E]">B.inggris</button>
                <button class="bg-white text-teal-500 px-6 py-1 rounded-lg text-sm font-semibold shadow-[0px_4px_1px_0px_#003D4E]">PPkn</button>
                <button class="bg-white text-teal-500 px-6 py-1 rounded-lg text-sm font-semibold shadow-[0px_4px_1px_0px_#003D4E]">Sejarah</button>
            </div>
        </section>
        <section class="mb-8">
            <div class="flex items-center justify-between mb-3">
                <h1 class="text-xl font-bold text-teal-500 py-2">Modul Pembelajaran</h1>
            </div>
            <div class="flex space-x-8 mb-5">
                <button class="bg-teal-500 text-white px-6 py-1 rounded-lg text-sm font-semibold shadow-[0px_4px_1px_0px_#003D4E]">Soal</button>
                <button class="bg-white text-teal-500 px-6 py-1 rounded-lg text-sm font-semibold shadow-[0px_4px_1px_0px_#003D4E]">PPT</button>
            </div>
            <!-- Modul Pembelajaran Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-14">
                <div class="relative w-50 h-70 bg-white shadow-[0px_4px_15px_0px_rgba(0,0,0,0.25)] rounded-xl">
                    <div class="absolute translate-x-[-8px] z-0 w-full h-9/10 bottom-0 left-0 bg-sky-900 rounded-tl-2xl rounded-bl-2xl"></div>
                    <div class="absolute translate-x-[-1px] w-full h-3 bottom-0 z-20 left-0 bg-sky-900 rounded-tr-2xl"></div>
                    <div class="relative w-full rounded-tl-3xl bg-white h-full p-4 z-10">
                        <img class="w-full h-28 object-cover rounded-tl-2xl rounded-tr-2xl" src="https://placehold.co/160x90" alt="Math">
                        <h3 class="text-emerald-500 text-lg font-bold mt-4 text-left">Aljabar Linear</h3>
                        <p class="text-emerald-500 text-sm font-light mt-2 text-left">Deskripsi Singkat</p>
                        <p class="text-emerald-500 py-5 text-sm font-light mt-2 text-right">8 Soal</p>
                    </div>
                </div>
                <div class="relative w-50 h-70 bg-white shadow-[0px_4px_15px_0px_rgba(0,0,0,0.25)] rounded-xl">
                    <div class="absolute translate-x-[-8px] z-0 w-full h-9/10 bottom-0 left-0 bg-sky-900 rounded-tl-2xl rounded-bl-2xl"></div>
                    <div class="absolute translate-x-[-1px] w-full h-3 bottom-0 z-20 left-0 bg-sky-900 rounded-tr-2xl"></div>
                    <div class="relative w-full rounded-tl-3xl bg-white h-full p-4 z-10">
                        <img class="w-full h-28 object-cover rounded-tl-2xl rounded-tr-2xl" src="https://placehold.co/160x90" alt="Math">
                        <h3 class="text-emerald-500 text-lg font-bold mt-4 text-left">Aljabar Linear</h3>
                        <p class="text-emerald-500 text-sm font-light mt-2 text-left">Deskripsi Singkat</p>
                        <p class="text-emerald-500 py-5 text-sm font-light mt-2 text-right">8 Soal</p>
                    </div>
                </div>
                <div class="relative w-50 h-70 bg-white shadow-[0px_4px_15px_0px_rgba(0,0,0,0.25)] rounded-xl">
                    <div class="absolute translate-x-[-8px] z-0 w-full h-9/10 bottom-0 left-0 bg-sky-900 rounded-tl-2xl rounded-bl-2xl"></div>
                    <div class="absolute translate-x-[-1px] w-full h-3 bottom-0 z-20 left-0 bg-sky-900 rounded-tr-2xl"></div>
                    <div class="relative w-full rounded-tl-3xl bg-white h-full p-4 z-10">
                        <img class="w-full h-28 object-cover rounded-tl-2xl rounded-tr-2xl" src="https://placehold.co/160x90" alt="Math">
                        <h3 class="text-emerald-500 text-lg font-bold mt-4 text-left">Aljabar Linear</h3>
                        <p class="text-emerald-500 text-sm font-light mt-2 text-left">Deskripsi Singkat</p>
                        <p class="text-emerald-500 py-5 text-sm font-light mt-2 text-right">8 Soal</p>
                    </div>
                </div>
                <div class="relative w-50 h-70 bg-white shadow-[0px_4px_15px_0px_rgba(0,0,0,0.25)] rounded-xl">
                    <div class="absolute translate-x-[-8px] z-0 w-full h-9/10 bottom-0 left-0 bg-sky-900 rounded-tl-2xl rounded-bl-2xl"></div>
                    <div class="absolute translate-x-[-1px] w-full h-3 bottom-0 z-20 left-0 bg-sky-900 rounded-tr-2xl"></div>
                    <div class="relative w-full rounded-tl-3xl bg-white h-full p-4 z-10">
                        <img class="w-full h-28 object-cover rounded-tl-2xl rounded-tr-2xl" src="https://placehold.co/160x90" alt="Math">
                        <h3 class="text-emerald-500 text-lg font-bold mt-4 text-left">Aljabar Linear</h3>
                        <p class="text-emerald-500 text-sm font-light mt-2 text-left">Deskripsi Singkat</p>
                        <p class="text-emerald-500 py-5 text-sm font-light mt-2 text-right">8 Soal</p>
                    </div>
                </div>
            </div>
            
        </section>

        <section class="mb-8">
            <div class="flex items-center justify-between mb-3">
                <h1 class="text-xl font-bold text-teal-500 py-2">Modul Pembelajaran Premium</h1>
            </div>
            <div class="flex space-x-8 mb-5">
                <button class="bg-teal-500 text-white px-6 py-1 rounded-lg text-sm font-semibold shadow-[0px_4px_1px_0px_#003D4E]">CPNS</button>
                <button class="bg-white text-teal-500 px-6 py-1 rounded-lg text-sm font-semibold shadow-[0px_4px_1px_0px_#003D4E]">UTBK</button>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-14">
                <div class="relative w-50 h-70 bg-white shadow-[0px_4px_15px_0px_rgba(0,0,0,0.25)] rounded-xl">
                    <div class="absolute translate-x-[-8px] z-0 w-full h-9/10 bottom-0 left-0 bg-sky-900 rounded-tl-2xl rounded-bl-2xl"></div>
                    <div class="absolute translate-x-[-1px] w-full h-3 bottom-0 z-20 left-0 bg-sky-900 rounded-tr-2xl"></div>
                    <div class="relative w-full rounded-tl-3xl bg-white h-full p-4 z-10">
                        <img class="w-full h-28 object-cover rounded-tl-2xl rounded-tr-2xl" src="https://placehold.co/160x90" alt="Math">
                        <h3 class="text-emerald-500 text-lg font-bold mt-4 text-left">Aljabar Linear</h3>
                        <p class="text-emerald-500 text-sm font-light mt-2 text-left">Deskripsi Singkat</p>
                        <p class="text-emerald-500 py-5 text-sm font-light mt-2 text-right">8 Soal</p>
                    </div>
                </div>
                <div class="relative w-50 h-70 bg-white shadow-[0px_4px_15px_0px_rgba(0,0,0,0.25)] rounded-xl">
                    <div class="absolute translate-x-[-8px] z-0 w-full h-9/10 bottom-0 left-0 bg-sky-900 rounded-tl-2xl rounded-bl-2xl"></div>
                    <div class="absolute translate-x-[-1px] w-full h-3 bottom-0 z-20 left-0 bg-sky-900 rounded-tr-2xl"></div>
                    <div class="relative w-full rounded-tl-3xl bg-white h-full p-4 z-10">
                        <img class="w-full h-28 object-cover rounded-tl-2xl rounded-tr-2xl" src="https://placehold.co/160x90" alt="Math">
                        <h3 class="text-emerald-500 text-lg font-bold mt-4 text-left">Aljabar Linear</h3>
                        <p class="text-emerald-500 text-sm font-light mt-2 text-left">Deskripsi Singkat</p>
                        <p class="text-emerald-500 py-5 text-sm font-light mt-2 text-right">8 Soal</p>
                    </div>
                </div>
                <div class="relative w-50 h-70 bg-white shadow-[0px_4px_15px_0px_rgba(0,0,0,0.25)] rounded-xl">
                    <div class="absolute translate-x-[-8px] z-0 w-full h-9/10 bottom-0 left-0 bg-sky-900 rounded-tl-2xl rounded-bl-2xl"></div>
                    <div class="absolute translate-x-[-1px] w-full h-3 bottom-0 z-20 left-0 bg-sky-900 rounded-tr-2xl"></div>
                    <div class="relative w-full rounded-tl-3xl bg-white h-full p-4 z-10">
                        <img class="w-full h-28 object-cover rounded-tl-2xl rounded-tr-2xl" src="https://placehold.co/160x90" alt="Math">
                        <h3 class="text-emerald-500 text-lg font-bold mt-4 text-left">Aljabar Linear</h3>
                        <p class="text-emerald-500 text-sm font-light mt-2 text-left">Deskripsi Singkat</p>
                        <p class="text-emerald-500 py-5 text-sm font-light mt-2 text-right">8 Soal</p>
                    </div>
                </div>
                <div class="relative w-50 h-70 bg-white shadow-[0px_4px_15px_0px_rgba(0,0,0,0.25)] rounded-xl">
                    <div class="absolute translate-x-[-8px] z-0 w-full h-9/10 bottom-0 left-0 bg-sky-900 rounded-tl-2xl rounded-bl-2xl"></div>
                    <div class="absolute translate-x-[-1px] w-full h-3 bottom-0 z-20 left-0 bg-sky-900 rounded-tr-2xl"></div>
                    <div class="relative w-full rounded-tl-3xl bg-white h-full p-4 z-10">
                        <img class="w-full h-28 object-cover rounded-tl-2xl rounded-tr-2xl" src="https://placehold.co/160x90" alt="Math">
                        <h3 class="text-emerald-500 text-lg font-bold mt-4 text-left">Aljabar Linear</h3>
                        <p class="text-emerald-500 text-sm font-light mt-2 text-left">Deskripsi Singkat</p>
                        <p class="text-emerald-500 py-5 text-sm font-light mt-2 text-right">8 Soal</p>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
