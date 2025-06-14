<?php
session_start();
include "../Includes/DBkoneksi.php";

// Pastikan pengajar sudah login
$pengajar_id = $_SESSION['user_id'] ?? null;
$kelas = [];

if ($pengajar_id) {
    $stmt = $conn->prepare("
        SELECT 
            k.kelas_id,
            k.judul,
            k.deskripsi,
            (SELECT COUNT(*) FROM kelas_peserta kp WHERE kp.kelas_id = k.kelas_id) AS jumlah_siswa,
            (SELECT COUNT(*) FROM materi m WHERE m.kelas_id = k.kelas_id) AS jumlah_materi
        FROM kelas k
        WHERE k.pengajar_id = ?
    ");
    $stmt->bind_param("i", $pengajar_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $kelas[] = $row;
    }
    $stmt->close();
}

?>


<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Kelas - Ngajar.ID</title>
    <link rel="icon" type="image/png" href="../img/Logo.png">
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
                    <?php include "../includes/Profile.php"; ?>
                </div>
            </div>
        </header>
        <?php include "../Includes/sidebar.php" ?>
        <main class="flex-grow flex-col min-h-screen p-4 sm:p-8">
            <div class="max-w-6xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
                <div class="mb-6">
                    <button id="tambahKelasBtn" class="bg-teal-500 text-white px-4 py-2 rounded-lg font-bold flex items-center gap-2 hover:bg-teal-600 transition-colors shadow-md">
                        <i class="fas fa-plus"></i>
                        <span>Tambah Modul</span>
                    </button>
                </div>
                <div class="bg-white rounded-lg shadow-lg p-4 mb-8">
                    <header class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div>
                            <h2 class="text-2xl font-bold text-teal-500">Modul yang dibuat</h2>
                        </div>
                        <div class="flex flex-wrap items-center gap-4">
                            <button class="bg-teal-500 text-white px-4 py-2 rounded-lg font-bold flex items-center gap-2 hover:bg-teal-600 transition-colors text-sm">
                                <i class="fas fa-sort"></i>
                                <span>Urutkan</span>
                            </button>
                        </div>
                    </header>
                </div>

                <!-- Grid Kartu Kelas -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <?php if (!empty($kelas)): ?>
                        <?php foreach ($kelas as $item): ?>
                            <div class="bg-white rounded-xl shadow-md p-6 flex flex-col sm:flex-row items-center gap-6 border-l-8 border-teal-500">
                                <img class="w-28 h-28 rounded-md object-cover flex-shrink-0" src="https://hololive.hololivepro.com/wp-content/uploads/2024/03/melting.png" alt="<?= htmlspecialchars($item['judul']) ?>" />
                                <div class="flex-grow w-full">
                                    <h3 class="text-2xl font-bold mb-2 text-teal-600"><?= htmlspecialchars($item['judul']) ?></h3>
                                    <div class="space-y-1 text-base font-bold text-gray-600">
                                        <p>Jumlah siswa: <?= $item['jumlah_siswa'] ?></p>
                                        <p>Modul: <?= $item['jumlah_materi'] ?></p>
                                    </div>

                                    <div class="flex items-center gap-3 mt-4">
                                        <button class="editKelasBtn bg-teal-500 text-white px-3 py-1.5 rounded-md text-xs font-bold flex items-center gap-2 hover:bg-teal-600 transition-colors"
                                            data-id="<?= $item['kelas_id'] ?>"
                                            data-judul="<?= htmlspecialchars($item['judul']) ?>"
                                            data-deskripsi="<?= htmlspecialchars($item['deskripsi']) ?>">
                                            <i class="fas fa-pencil-alt"></i><span>Edit Kelas</span>
                                        </button>

                                        <button onclick="hapusKelas(<?= $item['kelas_id'] ?>)"
                                            class="bg-red-500 text-white px-3 py-1.5 rounded-md text-xs font-bold flex items-center gap-2 hover:bg-red-600 transition-colors">
                                            <i class="fas fa-trash-alt"></i><span>Delete Kelas</span>
                                        </button>

                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-gray-500 text-center col-span-full">Belum ada modul yang dibuat.</p>
                    <?php endif; ?>
                </div>

            </div>
        </main>
    </div>

    <div id="modalTambahKelas" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-md transform transition-all">
            <div class="bg-teal-500 text-white px-6 py-4 rounded-t-xl flex items-center justify-between">
                <h3 class="text-xl font-bold">Buat Kelas</h3>
                <button id="closeModalTambah" class="text-white hover:text-gray-200 text-2xl"><i class="fas fa-times"></i></button>
            </div>
            <div class="p-6">
                <form id="formTambahKelas" class="space-y-4">
                    <div><label class="block text-sm font-medium text-gray-700 mb-2">Nama</label><input type="text" id="namaKelasTambah" placeholder="Nama Kelas" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500" required></div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label><textarea id="deskripsiKelasTambah" placeholder="Deskripsi Kelas" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 resize-none"></textarea></div>
                    <div class="flex gap-3 pt-4"><button type="button" id="batalBtnTambah" class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition-colors font-medium">Batal</button><button type="submit" class="flex-1 px-4 py-2 bg-teal-500 text-white rounded-md hover:bg-teal-600 transition-colors font-medium">Buat</button></div>
                </form>
            </div>
        </div>
    </div>

    <div id="modalEditKelas" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-md transform transition-all">
            <div class="bg-teal-500 text-white px-6 py-4 rounded-t-xl flex items-center justify-between">
                <h3 class="text-xl font-bold">Edit Kelas</h3>
                <button id="closeModalEdit" class="text-white hover:text-gray-200 text-2xl"><i class="fas fa-times"></i></button>
            </div>
            <div class="p-6">
                <form id="formEditKelas" class="space-y-4">
                    <div><label class="block text-sm font-medium text-gray-700 mb-2">Nama</label><input type="text" id="namaKelasEdit" placeholder="Nama Kelas" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500" required></div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label><textarea id="deskripsiKelasEdit" placeholder="Deskripsi Kelas" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 resize-none"></textarea></div>
                    <div class="flex gap-3 pt-4"><button type="button" id="batalBtnEdit" class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition-colors font-medium">Batal</button><button type="submit" class="flex-1 px-4 py-2 bg-teal-500 text-white rounded-md hover:bg-teal-600 transition-colors font-medium">Simpan</button></div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // --- Modal Logic for Tambah Kelas ---
        const tambahKelasBtn = document.getElementById('tambahKelasBtn'); // Assuming you have a button with this ID to open the "add" modal
        const modalTambah = document.getElementById('modalTambahKelas');
        const closeModalTambahBtn = document.getElementById('closeModalTambah');
        const batalBtnTambah = document.getElementById('batalBtnTambah');
        const formTambah = document.getElementById('formTambahKelas');

        function openModalTambah() {
            modalTambah.classList.remove('hidden');
            modalTambah.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeModalTambahFunc() {
            modalTambah.classList.add('hidden');
            modalTambah.classList.remove('flex');
            document.body.style.overflow = 'auto';
            formTambah.reset();
        }

        if (tambahKelasBtn) { // Check if the button exists before adding event listener
            tambahKelasBtn.addEventListener('click', openModalTambah);
        }
        closeModalTambahBtn.addEventListener('click', closeModalTambahFunc);
        batalBtnTambah.addEventListener('click', closeModalTambahFunc);

        modalTambah.addEventListener('click', (e) => {
            if (e.target === modalTambah) {
                closeModalTambahFunc();
            }
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !modalTambah.classList.contains('hidden')) {
                closeModalTambahFunc();
            }
        });

        formTambah.addEventListener('submit', (e) => {
            e.preventDefault();
            const namaKelas = document.getElementById('namaKelasTambah').value;
            const deskripsiKelas = document.getElementById('deskripsiKelasTambah').value;

            // Kirim data ke PHP
            fetch('../proses_tambah_kelas.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: new URLSearchParams({
                        namaKelas: namaKelas,
                        deskripsiKelas: deskripsiKelas
                    })
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    if (data.status === 'success') {
                        closeModalTambahFunc();
                        // Optional: reload halaman agar kelas muncul
                        location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan!');
                });
        });

        // --- Modal Logic for Edit Kelas ---
        const modalEdit = document.getElementById('modalEditKelas');
        const closeModalEditBtn = document.getElementById('closeModalEdit');
        const batalBtnEdit = document.getElementById('batalBtnEdit');
        const formEdit = document.getElementById('formEditKelas');

        function openModalEdit() {
            modalEdit.classList.remove('hidden');
            modalEdit.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeModalEditFunc() {
            modalEdit.classList.add('hidden');
            modalEdit.classList.remove('flex');
            document.body.style.overflow = 'auto';
            formEdit.reset();
        }

        closeModalEditBtn.addEventListener('click', closeModalEditFunc);
        batalBtnEdit.addEventListener('click', closeModalEditFunc);

        modalEdit.addEventListener('click', (e) => {
            if (e.target === modalEdit) {
                closeModalEditFunc();
            }
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !modalEdit.classList.contains('hidden')) {
                closeModalEditFunc();
            }
        });
    </script>
    <script>
        document.querySelectorAll('.editKelasBtn').forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.dataset.id;
                const judul = btn.dataset.judul;
                const deskripsi = btn.dataset.deskripsi;

                document.getElementById('namaKelasEdit').value = judul;
                document.getElementById('deskripsiKelasEdit').value = deskripsi;
                formEdit.dataset.id = id;

                openModalEdit();
            });
        });

        formEdit.addEventListener('submit', (e) => {
            e.preventDefault();
            const namaKelas = document.getElementById('namaKelasEdit').value;
            const deskripsiKelas = document.getElementById('deskripsiKelasEdit').value;
            const kelasId = formEdit.dataset.id;

            fetch('../proses_edit_kelas.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: new URLSearchParams({
                        id: kelasId,
                        namaKelas: namaKelas,
                        deskripsiKelas: deskripsiKelas
                    })
                })
                .then(res => res.json())
                .then(data => {
                    alert(data.message);
                    if (data.status === 'success') {
                        closeModalEditFunc();
                        location.reload();
                    }
                })
                .catch(() => alert('Terjadi kesalahan saat mengedit!'));
        });
    </script>
    <script>
        function hapusKelas(kelasId) {
            if (!confirm('Yakin ingin menghapus kelas ini?')) return;

            fetch(`../hapus_kelas.php?id=${kelasId}`, {
                    method: 'GET'
                })
                .then(res => res.json())
                .then(data => {
                    alert(data.message);
                    if (data.status === 'success') location.reload();
                })
                .catch(() => alert('Terjadi kesalahan saat menghapus!'));
        }
    </script>

    <footer>
        <?php include '../Includes/Footer.php'; ?>
    </footer>
</body>

</html>