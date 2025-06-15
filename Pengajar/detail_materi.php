<?php include '../Includes/session_check.php'; ?>
<?php include '../Includes/DBkoneksi.php'; ?>
<?php
if ($_SESSION['role'] !== 'pengajar') {
    header("Location: unauthorized.php");
    exit;
}

$id_pengguna = $_SESSION['user_id'] ?? null;
$namaPengguna = "";
$kelas_id = $_GET['kelas_id'] ?? null;

if (!$kelas_id) {
    echo "<p class='text-red-500 text-center font-bold mt-10'>Kelas tidak ditemukan.</p>";
    exit;
}
$materi_id = $_GET['id'] ?? null;

// Validasi apakah kelas memang milik pengajar
$judulKelas = "";
$stmt = $conn->prepare("SELECT judul FROM kelas WHERE kelas_id = ? AND pengajar_id = ?");
$stmt->bind_param("ii", $kelas_id, $id_pengguna);
$stmt->execute();
$stmt->bind_result($judulKelas);
if (!$stmt->fetch()) {
    echo "<p class='text-red-500 text-center font-bold mt-10'>Kelas tidak ditemukan atau bukan milik Anda.</p>";
    exit;
}
$stmt->close();


if ($id_pengguna) {
    $stmt = $conn->prepare("SELECT name FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $id_pengguna);
    $stmt->execute();
    $stmt->bind_result($namaPengguna);
    $stmt->fetch();
    $stmt->close();
}

// Ambil data materi spesifik
$judulMateri = '';
$deskripsiMateri = '';
$fileUrl = '';
$createdAt = '';

$stmt = $conn->prepare("SELECT judul, deskripsi, file_url, created_at FROM materi WHERE materi_id = ? AND kelas_id = ?");
$stmt->bind_param("ii", $materi_id, $kelas_id);
$stmt->execute();
$stmt->bind_result($judulMateri, $deskripsiMateri, $fileUrl, $createdAt);

if (!$stmt->fetch()) {
    echo "<p class='text-red-500 text-center font-bold mt-10'>Materi tidak ditemukan.</p>";
    exit;
}
$stmt->close();


?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Ngajar.ID</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
                    <h1 class="text-xl font-bold text-teal-500 hidden sm:block">Materi</h1>
                </div>
                <div class="flex items-center space-x-2 sm:space-x-4">
                    <button class="text-teal-500 hover:text-teal-500 p-2 rounded-full"><i class="fas fa-bell text-xl"></i></button>
                    <?php include "../includes/Profile.php"; ?>
                </div>
            </div>
        </header>

        <?php include "../Includes/sidebar.php" ?>
        

        <main class="flex-grow">
            <div class="max-w-6xl mx-auto p-4 sm:p-6 lg:p-8">
                <div class="bg-teal-500 text-white p-6 rounded-t-lg shadow-md">
                    <h1 class="text-2xl md:text-3xl font-medium"><?= htmlspecialchars($judulKelas) ?></h1>
                    <p class="text-sm text-white-500">Diunggah pada: <?= date('d M Y H:i', strtotime($createdAt)) ?></p>
                </div>

                <div class="bg-white rounded-b-lg shadow-md mb-6">
                    <div class="p-6 sm:p-8">
                        <h2 class="text-2xl font-normal text-black"><?= htmlspecialchars($judulMateri) ?></h2>
                        <p class="mt-2 font-light text-gray-800"><?= nl2br(htmlspecialchars($deskripsiMateri)) ?></p>
                        <div class="mt-4">
                            <a href="<?= htmlspecialchars($fileUrl) ?>" target="_blank"
                            class="inline-block bg-teal-500 text-white font-medium py-2 px-5 rounded-lg hover:bg-teal-600 transition-colors shadow">
                                Lihat / Unduh File Materi
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </main>


        <footer>
            <?php include '../includes/Footer.php'; ?>
        </footer>
</body>
</html>