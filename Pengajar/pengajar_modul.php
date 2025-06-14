<?php
include '../Includes/session_check.php';
include '../Includes/DBkoneksi.php';

$pengajar_id = $_SESSION['user_id'] ?? null;
$pesan = null;
$kelas_options = [];

if ($pengajar_id) {
    $stmt = $conn->prepare("SELECT kelas_id, judul FROM kelas WHERE pengajar_id = ?");
    $stmt->bind_param("i", $pengajar_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $kelas_options[] = $row;
    }
    $stmt->close();
}

// Proses tambah materi
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['judul'], $_POST['kelas_id'], $_POST['tipe'])) {
    $judul     = $_POST['judul'];
    $kelas_id  = $_POST['kelas_id'];
    $tipe      = $_POST['tipe'];
    $file_url  = '';
    $deskripsi = $_POST['deskripsi'] ?? '';

    if (!empty($_FILES['file']['name'])) {
        $nama_file = time() . '_' . basename($_FILES['file']['name']);
        $tujuan = '../uploads/materi/' . $nama_file;

        if ($_FILES['file']['error'] === UPLOAD_ERR_OK) {
            if (move_uploaded_file($_FILES['file']['tmp_name'], $tujuan)) {
                $file_url = $tujuan;
            } else {
                echo "<script>alert('Gagal memindahkan file ke tujuan.');</script>";
            }
        } else {
            echo "<script>alert('Error saat upload file: " . $_FILES['file']['error'] . "');</script>";
        }
    }

    if ($file_url !== '') {
        $stmt = $conn->prepare("INSERT INTO materi (kelas_id, judul, tipe, deskripsi, file_url) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $kelas_id, $judul, $tipe, $deskripsi, $file_url);
        if ($stmt->execute()) {
            $pesan = "Materi berhasil ditambahkan!";
        } else {
            echo "<script>alert('Gagal menyimpan materi: " . $stmt->error . "');</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Upload file gagal. Materi tidak disimpan.');</script>";
    }
}

// Ambil semua materi dari pengajar
$materi_list = [];
if ($pengajar_id) {
    $stmt = $conn->prepare("
        SELECT m.*, k.judul AS nama_kelas 
        FROM materi m 
        JOIN kelas k ON m.kelas_id = k.kelas_id 
        WHERE k.pengajar_id = ? 
        ORDER BY m.created_at DESC
    ");
    $stmt->bind_param("i", $pengajar_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $materi_list[] = $row;
    }
    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../img/Logo.png">
    <title>Materi Relawan - Ngajar.ID</title>
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
                    <h1 class="text-xl font-bold text-teal-500 hidden sm:block">Materi</h1>
                </div>
                <div class="flex items-center space-x-2 sm:space-x-4">
                    <?php include "../includes/Profile.php"; ?>
                </div>
            </div>
        </header>
        <?php include "../Includes/sidebar.php" ?>
        <main class="flex-grow flex-col min-h-screen p-4 sm:p-8">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <!-- Pesan sukses -->
                <?php if ($pesan): ?>
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                        <?= htmlspecialchars($pesan) ?>
                    </div>
                <?php endif; ?>

                <!-- Tombol Tambah Materi -->
                <div class="mb-6">
                    <button id="tambahMateriBtn" class="bg-teal-500 text-white px-4 py-2 rounded-lg font-bold flex items-center gap-2 hover:bg-teal-600 transition-colors shadow-md">
                        <i class="fas fa-plus"></i>
                        <span>Tambah Materi</span>
                    </button>
                </div>
                
                <div class="bg-white rounded-lg shadow-lg p-4 mb-8">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div>
                            <h2 class="text-2xl font-bold text-teal-500">Materi Pembelajaran</h2>
                        </div>
                        <div class="flex flex-wrap items-center gap-4">
                            <button class="bg-teal-500 text-white px-4 py-2 rounded-lg font-bold flex items-center gap-2 hover:bg-teal-600 transition-colors text-sm">
                                <i class="fas fa-sort"></i>
                                <span id="urutkanBtn">Urutkan</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Grid Kartu Materi -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <?php foreach ($materi_list as $m): ?>
                        <div class="bg-teal-500 rounded-xl shadow-md p-5 flex flex-col sm:flex-row items-center gap-6">
                            <i class="fas fa-book text-white text-8xl opacity-100"></i>
                            <div class="flex-grow w-full">
                                <h3 class="text-2xl font-bold mb-2">
                                    <a href="detail_materi.php?materi_id=<?= $m['materi_id'] ?>&kelas_id=<?= $m['kelas_id'] ?>" class="text-white hover:underline">
                                        <?= htmlspecialchars($m['judul']) ?>
                                    </a>
                                </h3>

                                <div class="space-y-1 text-base font-light text-gray-100">
                                    <p>Kelas: <?= htmlspecialchars($m['nama_kelas']) ?></p>
                                    <p>Tipe: <?= $m['tipe'] ?></p>
                                    <p>Tanggal: <?= date('d M Y', strtotime($m['created_at'])) ?></p>
                                </div>
                                <div class="flex items-center gap-3 mt-4">
                                    <a href="<?= $m['file_url'] ?>" target="_blank" class="bg-white text-teal-500 px-3 py-1.5 rounded-md text-xs font-bold hover:bg-teal-100 transition">Lihat File</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

            </div>
        </main>
    </div>

    <!-- Modal Tambah Materi -->
    <div id="modalTambahMateri" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg transform transition-all">
            <div class="bg-teal-500 text-white px-6 py-4 rounded-t-xl flex items-center justify-between">
                <h3 class="text-xl font-bold">Tambah Materi Baru</h3>
                <button id="closeModal" class="text-white hover:text-gray-200 text-2xl">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-6">
                <form id="formTambahMateri" class="space-y-4" method="POST" enctype="multipart/form-data">
                    <div>
                        <label for="namaMateri" class="block text-sm font-medium text-teal-500 mb-2">Nama Materi</label>
                        <input name="judul" type="text" id="namaMateri" placeholder="Contoh: Pengenalan Vektor" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500" required>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="kelasInduk" class="block text-sm font-medium text-teal-500 mb-2">Untuk Kelas</label>
                            <select name="kelas_id" id="kelasInduk" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500" required>
                                <option value="">Pilih Kelas</option>
                                <?php foreach ($kelas_options as $k): ?>
                                    <option value="<?= $k['kelas_id'] ?>"><?= htmlspecialchars($k['judul']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label for="tipeMateri" class="block text-sm font-medium text-teal-500 mb-2">Tipe Materi</label>
                            <select name="tipe" id="tipeMateri" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500" required>
                                <option value="">Pilih Tipe</option>
                                <option value="Soal">Soal</option>
                                <option value="PDF">PDF</option>
                                <option value="Video">Video</option>
                            </select>
                        </div>
                    </div>
                    
                    <div>
                        <label for="deskripsiMateri" class="block text-sm font-medium text-teal-500 mb-2">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsiMateri" placeholder="Jelaskan isi singkat dari Materi ini" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500 resize-none"></textarea>
                    </div>
                    
                    <div>
                        <label for="fileMateri" class="block text-sm font-medium text-teal-500 mb-2">Upload File</label>
                        <input name="file" type="file" id="fileMateri" required class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100" />
                    </div>
                    
                    <div class="flex gap-3 pt-4">
                        <button type="button" id="batalBtn" class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition-colors font-medium">Batal</button>
                        <button type="submit" class="flex-1 px-4 py-2 bg-teal-500 text-white rounded-md hover:bg-teal-600 transition-colors font-medium">Tambah Materi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Elemen-elemen yang diperlukan
            const tambahMateriBtn = document.getElementById('tambahMateriBtn');
            const modalTambahMateri = document.getElementById('modalTambahMateri');
            const closeModal = document.getElementById('closeModal');
            const batalBtn = document.getElementById('batalBtn');
            
            // Fungsi untuk menampilkan modal
            function showModal() {
                modalTambahMateri.classList.remove('hidden');
                modalTambahMateri.classList.add('flex');
                document.body.style.overflow = 'hidden'; // Prevent scrolling
            }
            
            // Fungsi untuk menyembunyikan modal
            function hideModal() {
                modalTambahMateri.classList.add('hidden');
                modalTambahMateri.classList.remove('flex');
                document.body.style.overflow = 'auto'; // Allow scrolling
            }
            
            // Event listener untuk tombol tambah materi
            tambahMateriBtn.addEventListener('click', function(e) {
                e.preventDefault();
                showModal();
            });
            
            // Event listener untuk tombol close (X)
            closeModal.addEventListener('click', function(e) {
                e.preventDefault();
                hideModal();
            });
            
            // Event listener untuk tombol batal
            batalBtn.addEventListener('click', function(e) {
                e.preventDefault();
                hideModal();
            });
            
            // Event listener untuk klik di luar modal
            modalTambahMateri.addEventListener('click', function(e) {
                if (e.target === modalTambahMateri) {
                    hideModal();
                }
            });
            
            // Event listener untuk tombol ESC
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !modalTambahMateri.classList.contains('hidden')) {
                    hideModal();
                }
            });
        });

        // Fungsi untuk sorting
        document.getElementById('urutkanBtn').addEventListener('click', () => {
            const container = document.querySelector('.grid.grid-cols-1.md\\:grid-cols-2.gap-8');
            const materiCards = Array.from(container.children);

            // Toggle sorting order
            const isAscending = container.dataset.sortOrder !== 'asc';
            container.dataset.sortOrder = isAscending ? 'asc' : 'desc';

            // Update button text to show current action
            const sortBtn = document.getElementById('urutkanBtn');
            sortBtn.innerHTML = `<span>${isAscending ? 'A-Z ↑' : 'Z-A ↓'}</span>`;

            // Sort the cards based on material title
            materiCards.sort((a, b) => {
                const titleA = a.querySelector('h3').textContent.trim().toLowerCase();
                const titleB = b.querySelector('h3').textContent.trim().toLowerCase();

                if (isAscending) {
                    return titleA.localeCompare(titleB);
                } else {
                    return titleB.localeCompare(titleA);
                }
            });

            // Clear container and re-append sorted cards
            container.innerHTML = '';
            materiCards.forEach(card => container.appendChild(card));

            // Add visual feedback
            container.style.opacity = '0.7';
            setTimeout(() => {
                container.style.opacity = '1';
            }, 200);
        });
    </script>

    <footer>
        <?php include '../Includes/Footer.php'; ?>
    </footer>
</body>

</html>