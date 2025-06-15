<?php include '../Includes/session_check.php'; ?>
<?php include '../Includes/DBkoneksi.php'; ?>

<?php
if ($_SESSION['role'] !== 'murid') {
    header("Location: unauthorized.php");
    exit;
}

$id_pengguna = $_SESSION['user_id'] ?? null;
$namaPengguna = "";
$token = 0;

// Ambil data pengguna
if ($id_pengguna) {
    $stmt = $conn->prepare("SELECT name FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $id_pengguna);
    $stmt->execute();
    $stmt->bind_result($namaPengguna);
    $stmt->fetch();
    $stmt->close();

    // Ambil token
    $stmt = $conn->prepare("SELECT jumlah FROM token WHERE user_id = ?");
    $stmt->bind_param("i", $id_pengguna);
    $stmt->execute();
    $stmt->bind_result($token);
    $stmt->fetch();
    $stmt->close();
}

// Ambil modul berdasarkan ID
$modul_id = $_GET['id'] ?? null;
$judul = $deskripsi = $file_url = $tanggal_upload = "";
$tanggal_akses = "-";

if ($modul_id) {
    $stmt = $conn->prepare("SELECT judul, deskripsi, file_url, created_at FROM modul WHERE modul_id = ?");
    $stmt->bind_param("i", $modul_id);
    $stmt->execute();
    $stmt->bind_result($judul, $deskripsi, $file_url, $tanggal_upload);
    if ($stmt->fetch()) {
        $tanggal_akses = date("d-m-Y H:i", strtotime($tanggal_upload));
    } else {
        $judul = "Modul tidak ditemukan";
        $deskripsi = "-";
    }
    $stmt->close();
} else {
    $judul = "Modul tidak ditemukan";
    $deskripsi = "-";
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($judul) ?> - Ngajar.ID</title>
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
                <h1 class="text-xl font-bold text-teal-500 hidden sm:block">Modul</h1>
            </div>
            <div class="flex items-center space-x-2 sm:space-x-4">
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
                    <h2 class="font-bold text-base sm:text-lg leading-tight"><?= $namaPengguna ?></h2>
                    <p class="text-white-200 opacity-70 text-xs sm:text-sm leading-tight">Pelajar</p>
                    <div class="mt-2 flex items-center space-x-2">
                        <div class="bg-white text-teal-500 text-xs font-semibold px-2.5 py-1 rounded-lg flex items-center">
                            <img src="../img/coin.png" class="mr-1.5 w-4"> <?= $token ?>
                        </div>
                        <button class="bg-white bg-opacity-20 hover:bg-opacity-30 text-white rounded-full w-5 h-5 sm:w-6 sm:h-6 flex items-center justify-center">
                            <i class="fas fa-plus text-sm"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <main class="flex-grow">
        <div class="max-w-6xl mx-auto p-4 sm:p-6 lg:p-8">
            <div class="bg-teal-500 text-white p-6 rounded-t-lg shadow-md">
                <h1 class="text-2xl md:text-3xl font-medium"><?= htmlspecialchars($judul) ?></h1>
                <p class="text-normal text-white mt-1">Diupload Pada: <?= $tanggal_akses ?></p>
            </div>
            <div class="bg-white rounded-b-lg shadow-md">
                <div class="p-6 sm:p-8">
                    <p class="mt-2 font-light text-gray-800"><?= nl2br(htmlspecialchars($deskripsi)) ?></p>
                    <?php if (!empty($file_url)): ?>
                        <div class="mt-4">
                            <a href="<?= htmlspecialchars($file_url) ?>" target="_blank"
                                class="inline-block bg-teal-500 text-white font-medium py-2 px-5 rounded-lg hover:bg-teal-600 transition-colors shadow">
                                Download File Materi
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <?php include '../includes/Footer.php'; ?>
    </footer>
</div>
</body>
</html>
