<?php include '../Includes/session_check.php'; ?>
<?php include '../Includes/DBkoneksi.php'; ?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Relawan - Ngajar.ID</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
        font-family: 'Roboto Slab', serif;
        }
    </style>
</head>
<body class="bg-white">
    <div class="flex flex-col min-h-screen">
        <header class="bg-white shadow-sm sticky top-0 z-30">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <button id="hamburgerButton" class="text-teal-500 focus:outline-none">
                        <i class="fas fa-bars text-xl mt-1"></i>
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
        <main class="flex-grow flex-col min-h-screen p-4 sm:p-8">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <!-- Tombol Tambah Kelas -->
                <div class="mb-6">
                    <button id="tambahModulBtn" class="bg-teal-500 text-white px-4 py-2 rounded-lg font-bold flex items-center gap-2 hover:bg-teal-600 transition-colors shadow-md">
                        <i class="fas fa-plus"></i>
                        <span>Tambah Modul</span>
                    </button>
                </div>
                <div class="bg-white rounded-lg shadow-lg  p-4 mb-8">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div>
                            <h2 class="text-2xl font-bold text-teal-500">Modul Pembelajaran</h2>
                        </div>
                        <div class="flex flex-wrap items-center gap-4">
                            <button class="border-2 border-teal-500 text-teal-600 px-4 py-2 rounded-lg font-bold flex items-center gap-2 hover:bg-teal-50 transition-colors text-sm">
                                <span>Modul Saya</span>
                                <i class="fas fa-chevron-down ml-1"></i>
                            </button>
                            <button class="bg-teal-500 text-white px-4 py-2 rounded-lg font-bold flex items-center gap-2 hover:bg-teal-600 transition-colors text-sm">
                                <i class="fas fa-sort"></i>
                                <span>Urutkan</span>
                            </button>
                        </div>
                    </div>
                </div>
        
                <!-- Grid Kartu Kelas -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Kartu 1 -->
                    <div class="bg-teal-500 rounded-xl shadow-md p-6 flex flex-col sm:flex-row items-center gap-6">
                        <img class="w-28 h-28 rounded-md object-cover flex-shrink-0" src="https://placehold.co/109x109/EEEEEE/333333?text=Crypto" alt="Fundamental Crypto" />
                        <div class="flex-grow w-full">
                            <h3 class="text-2xl font-bold mb-2 text-white">Pengantar ATH</h3>
                            <div class="space-y-1 text-base font-light text-gray-100">
                                <p>Deskripsi</p>
                                <p>kategori soal</p>
                                <p>ksna</p>
                            </div>
                            <div class="flex items-center gap-3 mt-4">
                                <button class="bg-white text-teal-500 px-3 py-1.5 rounded-md text-xs font-bold flex items-center gap-2 hover:bg-blue-200 transition-colors">
                                    <i class="fas fa-pencil-alt"></i>
                                    <span>Edit Kelas</span>
                                </button>
                                <button class="bg-white text-teal-500 px-3 py-1.5 rounded-md text-xs font-bold flex items-center gap-2 hover:bg-red-200 transition-colors">
                                    <i class="fas fa-trash-alt"></i>
                                    <span>Delete Kelas</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="bg-teal-500 rounded-xl shadow-md p-6 flex flex-col sm:flex-row items-center gap-6">
                        <img class="w-28 h-28 rounded-md object-cover flex-shrink-0" src="https://placehold.co/109x109/EEEEEE/333333?text=Crypto" alt="Fundamental Crypto" />
                        <div class="flex-grow w-full">
                            <h3 class="text-2xl font-bold mb-2 text-white">Pengantar ATH</h3>
                            <div class="space-y-1 text-base font-light text-gray-100">
                                <p>Deskripsi</p>
                                <p>kategori soal</p>
                                <p>ksna</p>
                            </div>
                            <div class="flex items-center gap-3 mt-4">
                                <button class="bg-white text-teal-500 px-3 py-1.5 rounded-md text-xs font-bold flex items-center gap-2 hover:bg-blue-200 transition-colors">
                                    <i class="fas fa-pencil-alt"></i>
                                    <span>Edit Kelas</span>
                                </button>
                                <button class="bg-white text-teal-500 px-3 py-1.5 rounded-md text-xs font-bold flex items-center gap-2 hover:bg-red-200 transition-colors">
                                    <i class="fas fa-trash-alt"></i>
                                    <span>Delete Kelas</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <div id="modalTambahModul" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg transform transition-all">
            <div class="bg-teal-500 text-white px-6 py-4 rounded-t-xl flex items-center justify-between">
                <h3 class="text-xl font-bold">Tambah Modul Baru</h3>
                <button id="closeModal" class="text-white hover:text-gray-200 text-2xl"><i class="fas fa-times"></i></button>
            </div>
            <div class="p-6">
                <form id="formTambahModul" class="space-y-4">
                    <div><label for="namaModul" class="block text-sm font-medium text-teal-500 mb-2">Nama Modul</label><input type="text" id="namaModul" placeholder="Contoh: Pengenalan Vektor" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500" required></div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="kelasInduk" class="block text-sm font-medium text-teal-500  mb-2">Untuk Kelas</label>
                            <select id="kelasInduk" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500">
                                <option>Fundamental Crypto</option>
                                <option>Aljabar Linear</option>
                                <option>Matematika Dasar</option>
                            </select>
                        </div>
                        <div>
                            <label for="tipeModul" class="block text-sm font-medium text-teal-500 mb-2">Tipe Modul</label>
                            <select id="tipeModul" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500">
                                <option>Soal</option>
                                <option>PPT</option>
                            </select>
                        </div>
                    </div>
                    <div><label for="deskripsiModul" class="block text-sm font-medium text-teal-500 mb-2">Deskripsi</label><textarea id="deskripsiModul" placeholder="Jelaskan isi singkat dari modul ini" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500 resize-none"></textarea></div>
                    <div>
                        <label for="fileModul" class="block text-sm font-medium text-teal-500 mb-2">Upload File</label>
                        <input type="file" id="fileModul" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100"/>
                    </div>
                    <div class="flex gap-3 pt-4"><button type="button" id="batalBtn" class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition-colors font-medium">Batal</button><button type="submit" class="flex-1 px-4 py-2 bg-teal-500 text-white rounded-md hover:bg-teal-600 transition-colors font-medium">Tambah Modul</button></div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // --- Modal Logic ---
        const tambahModulBtn = document.getElementById('tambahModulBtn');
        const modal = document.getElementById('modalTambahModul');
        const closeModalBtn = document.getElementById('closeModal');
        const batalBtn = document.getElementById('batalBtn');
        const form = document.getElementById('formTambahModul');

        function openModal() {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeModalFunc() {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto';
            form.reset();
        }

        tambahModulBtn.addEventListener('click', openModal);
        closeModalBtn.addEventListener('click', closeModalFunc);
        batalBtn.addEventListener('click', closeModalFunc);

        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                closeModalFunc();
            }
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                closeModalFunc();
            }
        });

        form.addEventListener('submit', (e) => {
            e.preventDefault();
            const namaModul = document.getElementById('namaModul').value;
            const kelasInduk = document.getElementById('kelasInduk').value;
            // ... get other form values
            
            console.log('Nama Modul:', namaModul);
            console.log('Kelas Induk:', kelasInduk);
            
            // Menggunakan alert sementara, di dunia nyata ini akan diganti dengan notifikasi yang lebih baik
            alert('Modul "' + namaModul + '" berhasil ditambahkan!');
            
            closeModalFunc();
        });
    </script>
</script>
</body>
</html>