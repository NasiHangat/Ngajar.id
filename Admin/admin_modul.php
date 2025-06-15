<?php
session_start();
include "../Includes/DBkoneksi.php";

// Pastikan admin sudah login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = $_POST['judul'] ?? '';
    $tipe = $_POST['tipe'] ?? '';
    $deskripsi = $_POST['deskripsi'] ?? '';
    $token_harga = intval($_POST['token_harga'] ?? 0);
    $dibuat_oleh = $_SESSION['user_id'];

    // Penanganan upload file
    $uploadDir = '../uploads/modul/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

    $file_url = '';
    if (isset($_FILES['file']) && $_FILES['file']['error'] === 0) {
        $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
        $filename = time() . '_' . uniqid() . '.' . $ext;
        $targetPath = $uploadDir . $filename;

        if (move_uploaded_file($_FILES['file']['tmp_name'], $targetPath)) {
            $file_url = $targetPath;
        }
    }

    // Simpan ke database
    $stmt = $conn->prepare("INSERT INTO modul (judul, deskripsi, file_url, tipe, token_harga, dibuat_oleh) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssii", $judul, $deskripsi, $file_url, $tipe, $token_harga, $dibuat_oleh);

    if ($stmt->execute()) {
        echo "<script>alert('Modul berhasil ditambahkan!'); window.location.href=window.location.href;</script>";
    } else {
        echo "<script>alert('Gagal menambahkan modul.');</script>";
    }

    $stmt->close();
}
// Ambil data modul yang sudah ada
$modul = [];

if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'admin') {
    $stmt = $conn->prepare("
        SELECT 
            m.modul_id,
            m.judul,
            m.deskripsi,
            m.file_url,
            m.tipe,
            m.token_harga,
            u.name AS nama_pengajar
        FROM modul m
        LEFT JOIN users u ON m.dibuat_oleh = u.user_id
        ORDER BY m.created_at DESC
    ");
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $modul[] = $row;
    }
    $stmt->close();
} else {
    echo "<p class='text-red-500 text-center font-bold mt-10'>Akses ditolak. Halaman hanya untuk admin.</p>";
    exit;
}

?>


<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Modul Admin - Ngajar.ID</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="../js/admin.js"></script>
    <link rel="icon" type="image/png" href="../img/Logo.png">
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
                    <button class="text-teal-500 hover:text-teal-500 p-2 rounded-full"><i class="fas fa-bell text-xl"></i></button>
                    <?php include "../includes/Profile.php"; ?>
                </div>
            </div>
        </header>
        <?php include "../Includes/sidebar.php" ?>
        <main class="flex-grow flex-col min-h-screen p-4 sm:p-8">
            <div class="max-w-6xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
                <div class="mb-6">
                    <button id="tambahModulBtn" class="bg-teal-500 text-white px-4 py-2 rounded-lg font-bold flex items-center gap-2 hover:bg-teal-600 transition-colors shadow-md">
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

                <!-- Grid Kartu Modul -->
                 <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <?php if (!empty($modul)): ?>
        <?php foreach ($modul as $item): ?>
            <div class="relative bg-white border border-gray-200 shadow-sm rounded-xl p-4 hover:shadow-md transition-all duration-200 transform hover:-translate-y-1">
                
                <!-- Token / Harga di Pojok Kanan Atas -->
                <div class="absolute top-3 right-3">
                    <?php if ($item['token_harga'] > 0): ?>
                        <div class="flex items-center gap-1 bg-yellow-100 text-yellow-700 text-[11px] font-semibold px-2 py-0.5 rounded-full shadow-sm">
                            <img src="../img/coin.png" class="w-3 h-3" alt="Token">
                            <?= $item['token_harga'] ?>
                        </div>
                    <?php else: ?>
                        <span class="text-[11px] text-gray-400 italic">Gratis</span>
                    <?php endif; ?>
                </div>

                <!-- Judul -->
                <h3 class="text-base font-semibold text-teal-700 mb-1"><?= htmlspecialchars($item['judul']) ?></h3>

                <!-- Deskripsi -->
                <p class="text-xs text-gray-600 mb-3"><?= htmlspecialchars($item['deskripsi']) ?></p>

                <!-- Tipe -->
                <div class="mb-3">
                    <span class="inline-block px-1.5 py-0.5 bg-teal-100 text-teal-700 text-[11px] font-medium rounded-full">
                        <?= htmlspecialchars($item['tipe']) ?>
                    </span>
                </div>

                <!-- Aksi -->
                <div class="flex flex-col gap-2">
                    <a href="<?= $item['file_url'] ?>" target="_blank"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-teal-600 hover:bg-teal-700 text-white text-xs font-medium rounded transition">
                        <i class="fas fa-file-alt text-xs"></i> Lihat File
                    </a>
                    <p class="text-[10px] text-gray-400">Dibuat oleh: <?= htmlspecialchars($item['nama_pengajar']) ?></p>
                </div>

                <!-- Tombol Hapus -->
                <button onclick="hapusModul(<?= $item['modul_id'] ?>)"
                    class="mt-3 bg-red-100 hover:bg-red-200 text-red-600 px-2.5 py-1 text-xs font-semibold rounded flex items-center gap-1 transition">
                    <i class="fas fa-trash-alt text-xs"></i> Hapus
                </button>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="col-span-full text-center text-gray-500 text-sm italic">Belum ada modul yang dibuat.</p>
    <?php endif; ?>
</div>



            </div>
        </main>
    </div>
    
    <div id="modalTambahModul" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg transform transition-all">
            <div class="bg-teal-500 text-white px-6 py-4 rounded-t-xl flex items-center justify-between">
                <h3 class="text-xl font-bold">Tambah Modul Pengajar</h3>
                <button id="closeModal" class="text-white hover:text-gray-200 text-2xl"><i class="fas fa-times"></i></button>
            </div>
            <div class="p-6">
                <form id="formTambahModul" class="space-y-4" method="POST" enctype="multipart/form-data">
                    <div><label for="namaModul" class="block text-sm font-medium text-teal-500 mb-2">Nama Modul</label><input name="judul" type="text" id="namaModul" placeholder="Contoh: Pengenalan Vektor" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500" required></div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="tipeModul" class="block text-sm font-medium text-teal-500 mb-2">Tipe Modul</label>
                            <select name="tipe" id="tipeModul" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500">
                                <option>Soal</option>
                                <option>PDF</option>
                                <option>Video</option>
                            </select>
                        </div>
                        <div>
                            <label for="modul" class="block text-sm font-medium text-teal-500  mb-2">Harga Token</label>
                            <input
                            name="token_harga" type="number" id="tokenModul"
                            placeholder="Masukkan harga token untuk akses modul"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500"
                        >
                        </div>
                    </div>
                    <div><label for="deskripsiModul" class="block text-sm font-medium text-teal-500 mb-2">Deskripsi</label><textarea name="deskripsi" id="deskripsiModul" placeholder="Jelaskan isi singkat dari modul ini" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500 resize-none"></textarea></div>
                    <div>
                        <label for="fileModul" class="block text-sm font-medium text-teal-500 mb-2">Upload File</label>
                        <input name="file" type="file" id="fileModul" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100" />
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
            const token = document.getElementById('tokenModul').value;
            if (token < 0) {
                e.preventDefault();
                alert('Harga token tidak boleh negatif.');
                return false;
            }
        });

    </script>
    <script>
    function hapusModul(modulId) {
        if (confirm("Yakin ingin menghapus modul ini?")) {
            fetch(`hapus_modul.php?id=${modulId}`, {
                method: 'GET'
            })
            .then(res => res.json())
            .then(data => {
                alert(data.message);
                if (data.status === 'success') {
                    location.reload();
                }
            })
            .catch(() => alert('Terjadi kesalahan saat menghapus modul.'));
        }
    }
    </script>

    <footer>
        <?php include '../Includes/Footer.php'; ?>
    </footer>
</body>

</html>