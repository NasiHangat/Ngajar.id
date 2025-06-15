<?php include '../includes/session_check.php'; ?>
<?php include '../includes/DBkoneksi.php'; ?>

<?php
include '../Includes/session_check.php';
include '../Includes/DBkoneksi.php';

// Tangani tombol "Ikuti" hanya jika murid yang mengklik
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ikuti']) && $_SESSION['role'] === 'murid') {
    $kelas_id = $_POST['kelas_id'];
    $siswa_id = $_SESSION['user_id'];

    // Cek apakah murid sudah mengikuti kelas
    $cek = $conn->prepare("SELECT id FROM kelas_peserta WHERE siswa_id = ? AND kelas_id = ?");
    $cek->bind_param("ii", $siswa_id, $kelas_id);
    $cek->execute();
    $cek->store_result();

    if ($cek->num_rows == 0) {
        // Insert jika belum terdaftar
        $stmt = $conn->prepare("INSERT INTO kelas_peserta (siswa_id, kelas_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $siswa_id, $kelas_id);
        $stmt->execute();
        $stmt->close();
    }

    $cek->close();

    // Hindari submit ulang saat refresh
    header("Location: detail_kelas.php?id=" . $kelas_id);
    exit;
}

$id_pengguna = $_SESSION['user_id'] ?? null;
$role = $_SESSION['role'] ?? null;
$kelas_id = $_GET['id'] ?? null;

if (!$kelas_id || !$id_pengguna) {
    echo "<p class='text-red-500 text-center font-bold mt-10'>Data tidak valid atau tidak ditemukan.</p>";
    exit;
}

$aksesDiizinkan = false;

// Jika murid, cek apakah sudah mengikuti kelas
if ($role === 'murid') {
    $cek = $conn->prepare("SELECT id FROM kelas_peserta WHERE siswa_id = ? AND kelas_id = ?");
    $cek->bind_param("ii", $id_pengguna, $kelas_id);
    $cek->execute();
    $cek->store_result();

    if ($cek->num_rows > 0) {
        $aksesDiizinkan = true;
    }
    $cek->close();
}

// Jika pengajar, cek apakah kelas ini miliknya
if ($role === 'pengajar') {
    $cek = $conn->prepare("SELECT kelas_id FROM kelas WHERE kelas_id = ? AND pengajar_id = ?");
    $cek->bind_param("ii", $kelas_id, $id_pengguna);
    $cek->execute();
    $cek->store_result();

    if ($cek->num_rows > 0) {
        $aksesDiizinkan = true;
    }
    $cek->close();
}

if (!$aksesDiizinkan) {
    echo "<p class='text-red-500 text-center font-bold mt-10'>Anda tidak memiliki akses ke kelas ini.</p>";
    exit;
}

// Ambil nama pengguna
$namaPengguna = '';
$stmt = $conn->prepare("SELECT name FROM users WHERE user_id = ?");
$stmt->bind_param("i", $id_pengguna);
$stmt->execute();
$stmt->bind_result($namaPengguna);
$stmt->fetch();
$stmt->close();

// Ambil info kelas (tanpa filter pengajar_id)
$judulKelas = '';
$deskripsiKelas = '';

$stmt = $conn->prepare("SELECT judul, deskripsi FROM kelas WHERE kelas_id = ?");
$stmt->bind_param("i", $kelas_id);
$stmt->execute();
$stmt->bind_result($judulKelas, $deskripsiKelas);
if (!$stmt->fetch()) {
    echo "<p class='text-red-500 text-center font-bold mt-10'>Kelas tidak ditemukan.</p>";
    exit;
}
$stmt->close();

// Ambil data materi
$materi = [];
$stmt = $conn->prepare("SELECT materi_id, judul, tipe, created_at, file_url FROM materi WHERE kelas_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $kelas_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $materi[] = $row;
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelas Pengajar - Ngajar.ID</title>
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
                <button id="hamburgerButton" class="text-teal-500 focus:outline-none">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <h1 class="text-xl font-bold text-teal-500 hidden sm:block">Kelas Saya</h1>
            </div>
            <div class="flex items-center space-x-2 sm:space-x-4">
                <button class="text-teal-500 hover:text-teal-500 p-2 rounded-full"><i class="fas fa-bell text-xl"></i></button>
                <?php include "../includes/Profile.php"; ?>
            </div>
        </div>
    </header>

    <?php include "../includes/sidebar.php" ?>

    <div class="bg-white py-6">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-teal-500 text-white p-16 rounded-xl relative min-h-[220px]">
                <h1 class="text-3xl sm:text-4xl font-bold"><?= htmlspecialchars($judulKelas) ?></h1>
                <p class="text-base sm:text-lg mt-2"><?= htmlspecialchars($deskripsiKelas) ?></p>
            </div>

            <div class="mt-6 space-y-4">
                <?php if (!empty($materi)): ?>
                    <?php foreach ($materi as $m): ?>
                    <a href="detail_materi.php?id=<?= $m['materi_id'] ?>&kelas_id=<?= $kelas_id ?>" class="block hover:shadow-lg transition-shadow">
                    <div class="bg-white p-4 shadow rounded-lg flex items-start gap-4">
                        <div class="w-10 h-10 bg-teal-500 text-white p-2 rounded-full flex items-center justify-center">
                            <i class="fas fa-clipboard text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-teal-600"><?= htmlspecialchars($m['judul']) ?></h3>
                            <p class="text-sm text-gray-700">Tipe: <?= htmlspecialchars($m['tipe']) ?></p>
                            <p class="text-sm text-gray-500 mb-2"><?= date('d M Y', strtotime($m['created_at'])) ?></p>
                        </div>
                    </div>
                    </a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-gray-500 text-center">Belum ada materi yang diunggah untuk kelas ini.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <footer>
        <?php include '../includes/Footer.php'; ?>
    </footer>
</div>
</body>
</html>
