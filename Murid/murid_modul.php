<?php
include '../Includes/session_check.php';
include '../Includes/DBkoneksi.php';

if ($_SESSION['role'] !== 'murid') {
    header("Location: unauthorized.php");
    exit;
}

$id_pengguna = $_SESSION['user_id'] ?? null;
$namaPengguna = "";
$token = 0;

// Ambil nama & token
if ($id_pengguna) {
    $stmt = $conn->prepare("SELECT name FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $id_pengguna);
    $stmt->execute();
    $stmt->bind_result($namaPengguna);
    $stmt->fetch();
    $stmt->close();

    $stmt = $conn->prepare("SELECT jumlah FROM token WHERE user_id = ?");
    $stmt->bind_param("i", $id_pengguna);
    $stmt->execute();
    $stmt->bind_result($token);
    $stmt->fetch();
    $stmt->close();
}

// Ambil semua materi dari kelas yang diikuti murid
$materiList = [
    'soal' => [],
    'pdf' => [],
    'video' => [],
];

$kelasIds = [];
$stmt = $conn->prepare("SELECT kelas_id FROM kelas_peserta WHERE siswa_id = ?");
$stmt->bind_param("i", $id_pengguna);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $kelasIds[] = $row['kelas_id'];
}
$stmt->close();

if (!empty($kelasIds)) {
    $placeholders = implode(',', array_fill(0, count($kelasIds), '?'));
    $types = str_repeat('i', count($kelasIds));

    $sql = "
        SELECT m.materi_id, m.judul, m.tipe, m.file_url, m.kelas_id, k.judul AS nama_kelas
        FROM materi m
        JOIN kelas k ON m.kelas_id = k.kelas_id
        WHERE m.kelas_id IN ($placeholders)
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$kelasIds);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $tipe = strtolower($row['tipe']);
        if (isset($materiList[$tipe])) {
            $materiList[$tipe][] = $row;
        }
    }
    $stmt->close();
}

// Ambil modul yang dibuat oleh admin
$modul_admin = [];
$stmt = $conn->prepare("
    SELECT modul_id, judul, deskripsi, tipe, token_harga 
    FROM modul 
    WHERE dibuat_oleh IN (SELECT user_id FROM users WHERE role = 'admin')
");
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $modul_admin[] = $row;
}
$stmt->close();

// Ambil modul yang sudah dibeli
$modul_dibeli = [];
$stmt = $conn->prepare("SELECT modul_id FROM token_log WHERE user_id = ?");
$stmt->bind_param("i", $id_pengguna);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $modul_dibeli[] = $row['modul_id'];
}
$stmt->close();


$token = 0;
if ($id_pengguna) {
    // Ambil nama
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
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modul - Ngajar.ID</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="../img/Logo.png">
    <script src="../js/token.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100;300;400;500;600;700;900&display=swap"
        rel="stylesheet">
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
                        <h1 class="text-xl font-bold text-teal-500 hidden sm:block">Materi</h1>
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
                            <h2 class="font-bold text-base sm:text-lg leading-tight"><?php echo $namaPengguna; ?></h2>
                            <div class="text-white-200 opacity-70 text-xs sm:text-sm leading-tight">
                                <?php echo htmlspecialchars(ucfirst($rolePengguna)); ?>
                            </div>
                            <div class="mt-2 flex items-center space-x-2">
                                <div
                                    class="flex items-center gap-1 bg-yellow-100 text-yellow-700 text-[11px] font-semibold px-2 py-0.5 rounded-full shadow-sm">
                                    <img src="../img/coin.png" class="w-3 h-3" alt="Token">
                                    <?php echo htmlspecialchars($token); ?>
                                </div>
                                <button id="openPopup"
                                    class="bg-white bg-opacity-20 hover:bg-opacity-30 text-white rounded-full w-5 h-5 sm:w-6 sm:h-6 flex items-center justify-center">
                                    <i class="fas fa-plus text-sm"></i>
                                </button>
                                <?php include "../Includes/token.php"; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <main class="max-w-6xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8">

                <section class="mb-8">
                    <div class="flex items-start justify-between mb-3">
                        <h1 class="text-start text-xl font-bold text-teal-500 py-2">Modul Pembelajaran</h1>
                    </div>
                    <div class="items-start flex space-x-8 mb-5">
                        <button id="btnSoal" data-target="soal" onclick="modul.toggleModul(this)"
                            class="toggle-modul bg-teal-500 text-white px-6 py-1 rounded-lg text-sm font-semibold shadow-[0px_4px_1px_0px_#003D4E]">Soal</button>
                        <button id="btnPDF" data-target="pdf" onclick="modul.toggleModul(this)"
                            class="toggle-modul bg-white text-teal-500 px-6 py-1 rounded-lg text-sm font-semibold shadow-[0px_4px_1px_0px_#003D4E]">PDF</button>
                        <button id="btnVideo" data-target="video" onclick="modul.toggleModul(this)"
                            class="toggle-modul bg-white text-teal-500 px-6 py-1 rounded-lg text-sm font-semibold shadow-[0px_4px_1px_0px_#003D4E]">Video</button>
                    </div>

                    <!-- SOAL -->
                    <div id="modul-soal" class="tab-modul">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                            <?php if (empty($materiList['soal'])): ?>
                                <p class="text-center col-span-full text-gray-500">Belum ada soal dari kelas yang Anda
                                    ikuti.</p>
                            <?php else: ?>
                                <?php foreach ($materiList['soal'] as $materi): ?>
                                    <a href="../Pengajar/detail_materi.php?materi_id=<?= htmlspecialchars($materi['materi_id']) ?>&kelas_id=<?= htmlspecialchars($materi['kelas_id']) ?>"
                                        class="block hover:shadow-lg transition-shadow">
                                        <div
                                            class="relative w-50 h-70 bg-white shadow-[0px_4px_15px_0px_rgba(0,0,0,0.25)] rounded-xl">
                                            <!-- Layer biru di kiri bawah -->
                                            <div
                                                class="absolute translate-x-[-15px] z-0 w-full h-[90%] bottom-0 left-0 bg-[#003F4A] rounded-tl-2xl rounded-bl-2xl">
                                            </div>

                                            <!-- Strip biru di bawah -->
                                            <div
                                                class="absolute translate-x-[-1px] w-full h-3 bottom-0 z-20 left-0 bg-[#003F4A] rounded-tr-2xl">
                                            </div>

                                            <!-- Isi Card -->
                                            <div class="relative w-full rounded-tl-3xl bg-white h-full p-4 z-10">
                                                <img class="w-full h-28 object-cover rounded-tl-2xl rounded-tr-2xl"
                                                    src="../img/Logo.png" alt="<?= htmlspecialchars($materi['judul']) ?>">

                                                <h2 class="text-emerald-500 text-lg font-bold mt-4 text-left">
                                                    <?= htmlspecialchars($materi['judul']) ?>
                                                </h2>

                                                <p class="text-emerald-500 text-sm font-light mt-2 text-left">
                                                    <?= htmlspecialchars($materi['nama_kelas']) ?>
                                                </p>

                                                <p class="text-emerald-500 py-5 text-sm font-light mt-2 text-right">
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- PDF -->
                    <div id="modul-pdf" class="tab-modul hidden">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                            <?php if (empty($materiList['pdf'])): ?>
                                <p class="text-center col-span-full text-gray-500">Belum ada PDF dari kelas yang Anda
                                    ikuti.</p>
                            <?php else: ?>
                                <?php foreach ($materiList['pdf'] as $materi): ?>
                                    <a href="../Pengajar/detail_materi.php?materi_id=<?= htmlspecialchars($materi['materi_id']) ?>&kelas_id=<?= htmlspecialchars($materi['kelas_id']) ?>"
                                        class="block hover:shadow-lg transition-shadow">
                                        <div
                                            class="relative w-50 h-70 bg-white shadow-[0px_4px_15px_0px_rgba(0,0,0,0.25)] rounded-xl">
                                            <!-- Layer biru di kiri bawah -->
                                            <div
                                                class="absolute translate-x-[-15px] z-0 w-full h-[90%] bottom-0 left-0 bg-[#003F4A] rounded-tl-2xl rounded-bl-2xl">
                                            </div>

                                            <!-- Strip biru di bawah -->
                                            <div
                                                class="absolute translate-x-[-1px] w-full h-3 bottom-0 z-20 left-0 bg-[#003F4A] rounded-tr-2xl">
                                            </div>

                                            <!-- Isi Card -->
                                            <div class="relative w-full rounded-tl-3xl bg-white h-full p-4 z-10">
                                                <img class="w-full h-28 object-cover rounded-tl-2xl rounded-tr-2xl"
                                                    src="../img/Logo.png" alt="<?= htmlspecialchars($materi['judul']) ?>">

                                                <h2 class="text-emerald-500 text-lg font-bold mt-4 text-left">
                                                    <?= htmlspecialchars($materi['judul']) ?>
                                                </h2>

                                                <p class="text-emerald-500 text-sm font-light mt-2 text-left">
                                                    <?= htmlspecialchars($materi['nama_kelas']) ?>
                                                </p>

                                                <p class="text-emerald-500 py-5 text-sm font-light mt-2 text-right">
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- VIDEO -->
                    <div id="modul-video" class="tab-modul hidden">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                            <?php if (empty($materiList['video'])): ?>
                                <p class="text-center col-span-full text-gray-500">Belum ada video dari kelas yang Anda
                                    ikuti.</p>
                            <?php else: ?>
                                <?php foreach ($materiList['video'] as $materi): ?>
                                    <a href="../Pengajar/detail_materi.php?materi_id=<?= htmlspecialchars($materi['materi_id']) ?>&kelas_id=<?= htmlspecialchars($materi['kelas_id']) ?>"
                                        class="block hover:shadow-lg transition-shadow">
                                        <div
                                            class="relative w-50 h-70 bg-white shadow-[0px_4px_15px_0px_rgba(0,0,0,0.25)] rounded-xl">
                                            <!-- Layer biru di kiri bawah -->
                                            <div
                                                class="absolute translate-x-[-15px] z-0 w-full h-[90%] bottom-0 left-0 bg-[#003F4A]  rounded-tl-2xl rounded-bl-2xl">
                                            </div>

                                            <!-- Strip biru di bawah -->
                                            <div
                                                class="absolute translate-x-[-1px] w-full h-3 bottom-0 z-20 left-0 bg-[#003F4A]  rounded-tr-2xl">
                                            </div>

                                            <!-- Isi Card -->
                                            <div class="relative w-full rounded-tl-3xl bg-white h-full p-4 z-10">
                                                <img class="w-full h-28 object-cover rounded-tl-2xl rounded-tr-2xl"
                                                    src="https://placehold.co/160x90"
                                                    alt="<?= htmlspecialchars($materi['judul']) ?>">

                                                <h2 class="text-emerald-500 text-lg font-bold mt-4 text-left">
                                                    <?= htmlspecialchars($materi['judul']) ?>
                                                </h2>

                                                <p class="text-emerald-500 text-sm font-light mt-2 text-left">
                                                    <?= htmlspecialchars($materi['nama_kelas']) ?>
                                                </p>

                                                <p class="text-emerald-500 py-5 text-sm font-light mt-2 text-right">
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </section>
                <section class="mb-8">
                    <div class="flex items-center justify-between mb-3">
                        <h1 class="text-xl font-bold text-teal-500 py-2">Modul Ngajar.id</h1>
                    </div>

                    <!-- Tombol toggle utama -->
                    <div class="flex space-x-8 mb-5">
                        <button id="btnBelumDibeli" data-target="BelumDibeli" onclick="modul.togglePremium(this)"
                            class="toggle-tab bg-teal-500 text-white px-6 py-1 rounded-lg text-sm font-semibold shadow-[0px_4px_1px_0px_#003D4E]">
                            Belum Dibeli
                        </button>
                        <button id="btnSudahDibeli" data-target="SudahDibeli" onclick="modul.togglePremium(this)"
                            class="toggle-tab bg-white text-teal-500 px-6 py-1 rounded-lg text-sm font-semibold shadow-[0px_4px_1px_0px_#003D4E]">
                            Sudah Dibeli
                        </button>
                    </div>

                    <!-- Konten tab -->
                    <div id="tabContent">
                        <!-- Belum Dibeli -->
                        <div id="BelumDibeli" class="sub-tab-group block">
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                                <?php
                                $adaBelumDibeli = false;
                                if (!empty($modul_admin)):
                                    foreach ($modul_admin as $modul):
                                        if (!in_array($modul['modul_id'], $modul_dibeli)):
                                            $adaBelumDibeli = true;
                                            ?>
                                            <div
                                                class="rounded-xl shadow-md border border-teal-500 hover:shadow-lg transition duration-300">
                                                <div class="bg-white rounded-xl p-5 relative group">
                                                    <h2 class="text-lg font-bold text-teal-700 mb-1">
                                                        <?= htmlspecialchars($modul['judul']) ?>
                                                    </h2>
                                                    <p class="text-gray-600 text-sm mb-3 line-clamp-3">
                                                        <?= htmlspecialchars($modul['deskripsi']) ?>
                                                    </p>
                                                    <form action="murid_beli_modul.php" method="POST"
                                                        onsubmit="return confirm('Yakin ingin membeli modul ini seharga <?= (int) $modul['token_harga'] ?> token?')">
                                                        <input type="hidden" name="modul_id" value="<?= $modul['modul_id'] ?>">
                                                        <input type="hidden" name="harga"
                                                            value="<?= (int) $modul['token_harga'] ?>">
                                                        <button type="submit"
                                                            class="flex items-center gap-2 bg-yellow-100 text-yellow-800 text-xs font-semibold px-3 py-1 rounded-full hover:bg-yellow-200">
                                                            <img src="../img/coin.png" alt="Token" class="w-4 h-4">
                                                            Beli <?= (int) $modul['token_harga'] ?> Token
                                                        </button>
                                                    </form>
                                                    <div
                                                        class="absolute top-2 right-2 bg-teal-500 text-white text-xs font-bold px-2 py-1 rounded-lg opacity-90 group-hover:opacity-100 transition">
                                                        MODUL
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        endif;
                                    endforeach;
                                endif;
                                if (!$adaBelumDibeli):
                                    ?>
                                    <p class="text-gray-500 col-span-full">Semua modul telah dibeli.</p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Sudah Dibeli -->
                        <div id="SudahDibeli" class="sub-tab-group hidden">
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                                <?php
                                $adaSudahDibeli = false;
                                if (!empty($modul_admin)):
                                    foreach ($modul_admin as $modul):
                                        if (in_array($modul['modul_id'], $modul_dibeli)):
                                            $adaSudahDibeli = true;
                                            ?>
                                            <div
                                                class="rounded-xl shadow-md border border-teal-500 hover:shadow-lg transition duration-300">
                                                <div class="bg-white rounded-xl p-5 relative group">
                                                    <h2 class="text-lg font-bold text-teal-700 mb-1">
                                                        <?= htmlspecialchars($modul['judul']) ?>
                                                    </h2>
                                                    <p class="text-gray-600 text-sm mb-3 line-clamp-3">
                                                        <?= htmlspecialchars($modul['deskripsi']) ?>
                                                    </p>
                                                    <a href="../pengajar/detail_materi.php?modul_id=<?= $modul['modul_id'] ?>"
                                                        class="inline-block bg-green-100 text-green-700 text-xs font-semibold px-3 py-1 rounded-full hover:bg-green-200">
                                                        Sudah Dibeli - Klik untuk Buka
                                                    </a>
                                                    <div
                                                        class="absolute top-2 right-2 bg-teal-500 text-white text-xs font-bold px-2 py-1 rounded-lg opacity-90 group-hover:opacity-100 transition">
                                                        MODUL
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        endif;
                                    endforeach;
                                endif;
                                if (!$adaSudahDibeli):
                                    ?>
                                    <p class="text-sm text-gray-500 col-span-full">Belum ada modul yang dibeli.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </section>
            </main>
            <footer>
                <?php include '../includes/Footer.php'; ?>
            </footer>
    </body>

</html>