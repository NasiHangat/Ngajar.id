<?php include '../Includes/session_check.php'; ?>
<?php include '../Includes/DBkoneksi.php'; ?>
<?php
if ($_SESSION['role'] !== 'murid') {
    header("Location: unauthorized.php");
    exit;
}

$id_pengguna = $_SESSION['user_id'] ?? null;
$namaPengguna = "";
$rolePengguna = $_SESSION['role'] ?? '';
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

// Ambil materi dari kelas yang diikuti murid
$materiList = [];
if ($id_pengguna) {
    $stmt = $conn->prepare("
        SELECT m.materi_id, m.judul AS materi_judul, m.kelas_id, k.judul AS kelas_judul
        FROM kelas_peserta kp
        JOIN kelas k ON kp.kelas_id = k.kelas_id
        JOIN materi m ON m.kelas_id = k.kelas_id
        WHERE kp.siswa_id = ?
    ");
    $stmt->bind_param("i", $id_pengguna);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $materiList[] = $row;
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

// Ambil materi dari kelas yang diikuti murid
$materiList = [];
$seen = [];

if ($id_pengguna) {
    $stmt = $conn->prepare("
        SELECT m.materi_id, m.judul AS materi_judul, m.deskripsi AS materi_deskripsi, m.kelas_id, k.judul AS kelas_judul
        FROM kelas_peserta kp
        JOIN kelas k ON kp.kelas_id = k.kelas_id
        JOIN materi m ON k.kelas_id = m.kelas_id
        WHERE kp.siswa_id = ?
    ");
    $stmt->bind_param("i", $id_pengguna);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        if (!in_array($row['materi_id'], $seen)) {
            $materiList[] = $row;
            $seen[] = $row['materi_id'];
        }
    }
    $stmt->close();

}

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
    <title>Dashboard - Ngajar.ID</title>
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

<body class="bg-white-50 font-roboto">
    <?php
    // ALERT HANDLER
    if (isset($_GET['error'])) {
        $errorMsg = '';
        switch ($_GET['error']) {
            case 'not_enough_token':
                $errorMsg = 'Token kamu tidak cukup untuk membeli modul ini.';
                break;
            case 'already_purchased':
                $errorMsg = 'Kamu sudah membeli modul ini sebelumnya.';
                break;
            case 'transaction_failed':
                $errorMsg = 'Terjadi kesalahan saat memproses pembelian.';
                break;
            default:
                $errorMsg = 'Terjadi kesalahan yang tidak diketahui.';
                break;
        }
        echo '<div class="bg-red-100 text-red-700 px-4 py-3 rounded relative max-w-2xl mx-auto mt-4" role="alert">
                <strong class="font-bold">Gagal! </strong>
                <span class="block sm:inline">' . htmlspecialchars($errorMsg) . '</span>
              </div>';
    } elseif (isset($_GET['status']) && $_GET['status'] === 'success') {
        echo '<div class="bg-green-100 text-green-700 px-4 py-3 rounded relative max-w-2xl mx-auto mt-4" role="alert">
                <strong class="font-bold">Berhasil! </strong>
                <span class="block sm:inline">Modul berhasil dibeli.</span>
              </div>';
    }
    ?>

    <!-- Optional: Bersihkan URL setelah 3 detik -->
    <script>
        setTimeout(() => {
            const url = new URL(window.location.href);
            url.search = "";
            window.history.replaceState({}, document.title, url);
        }, 3000);
    </script>
    <div class="flex flex-col min-h-screen">
        <header class="bg-white shadow-sm sticky top-0 z-30">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <button id="hamburgerButton" class="text-teal-500 focus:outline-none mt-1">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <h1 class="text-xl font-bold text-teal-500 hidden sm:block">Dashboard</h1>
                </div>
                <div class="flex items-center space-x-2 sm:space-x-4">
                    <?php include "../includes/Profile.php" ?>
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

        <main class="mx-w-6xl mx-[250px] px-4 sm:px-6 lg:px-8 py-8">
            <section class="mb-8">
                <div>
                    <div class="mb-3">
                        <h3 class="inline-flex items-center text-3xl font-bold text-teal-500">
                            <span>Materi Pembelajaran<span>
                    </div>
                    <div class="border-l-4 border-r-4 border-b-4 border-[#003F4A] shadow-lg rounded-xl p-4 bg-white">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            <?php if (!empty($materiList)): ?>
                                <?php foreach ($materiList as $materi): ?>
                                    <a href="../Pengajar/detail_materi.php?materi_id=<?= htmlspecialchars($materi['materi_id']) ?>&kelas_id=<?= htmlspecialchars($materi['kelas_id']) ?>"
                                        class="block hover:shadow-lg transition-shadow mb-4 p-4 border border-gray-200 rounded-lg">
                                        <p class="text-sm font-bold text-teal-500">
                                            <?= htmlspecialchars($materi['materi_judul']) ?>
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            Kelas: <?= htmlspecialchars($materi['kelas_judul']) ?>
                                        </p>
                                    </a>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p class="text-sm text-gray-500 col-span-full">Belum ada materi yang tersedia.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </section>
            <section>
                <div class="mb-3">
                    <h3 class="text-3xl font-bold text-teal-500 mb-6 "> Modul Ngajar.ID</h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php if (!empty($modul_admin)): ?>
                            <?php foreach ($modul_admin as $modul): ?>
                                <div
                                    class="rounded-xl shadow-md border border-teal-500 hover:shadow-lg transition duration-300">
                                    <div class="bg-white rounded-xl p-5 relative group">
                                        <h2 class="text-lg font-bold text-teal-700 mb-1">
                                            <?= htmlspecialchars($modul['judul']) ?>
                                        </h2>
                                        <p class="text-gray-600 text-sm mb-3 line-clamp-3">
                                            <?= htmlspecialchars($modul['deskripsi']) ?>
                                        </p>

                                        <?php if (in_array($modul['modul_id'], $modul_dibeli)): ?>
                                            <a href="../pengajar/detail_materi.php?modul_id=<?= $modul['modul_id'] ?>"
                                                class="inline-block bg-green-100 text-green-700 text-xs font-semibold px-3 py-1 rounded-full hover:bg-green-200">
                                                Sudah Dibeli - Klik untuk Buka
                                            </a>
                                        <?php else: ?>
                                            <form action="murid_beli_modul.php" method="POST"
                                                onsubmit="return confirm('Yakin ingin membeli modul ini seharga <?= (int) $modul['token_harga'] ?> token?')">
                                                <input type="hidden" name="modul_id" value="<?= $modul['modul_id'] ?>">
                                                <input type="hidden" name="harga" value="<?= (int) $modul['token_harga'] ?>">
                                                <button type="submit"
                                                    class="flex items-center gap-2 bg-yellow-100 text-yellow-800 text-xs font-semibold px-3 py-1 rounded-full hover:bg-yellow-200">
                                                    <img src="../img/coin.png" alt="Token" class="w-4 h-4"> Beli
                                                    <?= (int) $modul['token_harga'] ?> Token
                                                </button>
                                            </form>
                                        <?php endif; ?>

                                        <div
                                            class="absolute top-2 right-2 bg-teal-500 text-white text-xs font-bold px-2 py-1 rounded-lg opacity-90 group-hover:opacity-100 transition">
                                            MODUL
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-gray-500">Belum ada modul yang tersedia.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </section>
    </div>
    </main>
    <footer>
        <?php include '../includes/Footer.php'; ?>
    </footer>
</body>

</html>