<?php include '../includes/session_check.php' ?>
<?php include '../Includes/DBkoneksi.php'; ?>

<?php
$id_pengguna = $_SESSION['user_id'] ?? null;
$namaPengguna = "";

if ($id_pengguna) {
    $stmt = $conn->prepare("SELECT name FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $id_pengguna);
    $stmt->execute();
    $stmt->bind_result($namaPengguna);
    $stmt->fetch();
    $stmt->close();
}

$kelas = [];
$kelas_diikuti = [];

// Ambil kelas yang diikuti murid
$query_diikuti = "SELECT k.kelas_id, k.judul, k.deskripsi, u.name AS nama_pengajar 
FROM kelas_peserta kp
JOIN kelas k ON kp.kelas_id = k.kelas_id
JOIN users u ON k.pengajar_id = u.user_id
WHERE kp.siswa_id = ?";

$stmt = $conn->prepare($query_diikuti);
$stmt->bind_param("i", $id_pengguna);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $kelas_diikuti[] = $row;
}
$stmt->close();

// Ambil kelas yang belum diikuti murid
$query = "SELECT k.kelas_id, k.judul, u.name AS relawan 
FROM kelas k 
JOIN users u ON k.pengajar_id = u.user_id 
WHERE k.kelas_id NOT IN (
    SELECT kelas_id FROM kelas_peserta WHERE siswa_id = ?
)";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_pengguna);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $kelas[] = $row;
}
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ikuti'])) {
    $kelas_id_ikut = $_POST['kelas_id'];

    // Cegah duplikasi jika siswa sudah mengikuti kelas
    $stmt = $conn->prepare("SELECT * FROM kelas_peserta WHERE siswa_id = ? AND kelas_id = ?");
    $stmt->bind_param("ii", $id_pengguna, $kelas_id_ikut);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        // Jika belum, tambahkan
        $stmt = $conn->prepare("INSERT INTO kelas_peserta (siswa_id, kelas_id, tanggal_daftar) VALUES (?, ?, NOW())");
        $stmt->bind_param("ii", $id_pengguna, $kelas_id_ikut);
        $stmt->execute();
        $stmt->close();
    }

    // Refresh halaman agar data terbaru muncul
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
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
                        roboto: ['\"Roboto Slab\"', 'serif'],
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
                    <h1 class="text-xl font-bold text-teal-500 hidden sm:block">Kelas</h1>
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

        <main class="max-w-6xl mx-[250px] px-4 sm:px-6 py-6">
            <section class="mb-8">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-xl font-bold text-teal-500 py-2">Rekomendasi Kelas</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-14 gap-y-12">
                    <?php if (!empty($kelas)): ?>
                        <?php foreach ($kelas as $item): ?>
                            <div onclick="location.href='../pengajar/detail_kelas.php?id=<?= $item['kelas_id'] ?>'"
                                class="cursor-pointer w-full max-w-[361px] h-[220px] shadow-lg rounded-lg flex overflow-hidden transition-transform hover:scale-[1.02]">
                                <div class="w-3 bg-cyan-950 rounded-l-lg"></div>
                                <div class="flex-grow flex flex-col justify-between">

                                    <!-- Bagian Atas: Judul & Relawan -->
                                    <div class="bg-teal-600 h-[90px] p-4 flex justify-between items-start rounded-tr-lg">
                                        <div>
                                            <h3 class="font-roboto-slab font-bold text-white text-[13px] w-48 truncate">
                                                <?= htmlspecialchars($item['judul']) ?>
                                            </h3>
                                            <p class="font-roboto-slab text-white text-[10px] mt-8">
                                                <?= htmlspecialchars($item['relawan']) ?>
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Bagian Bawah: Tombol -->
                                    <div class="bg-white h-full p-4 rounded-br-lg flex items-end justify-end">
                                        <form action="" method="POST" onClick="event.stopPropagation();">

                                            <input type="hidden" name="kelas_id" value="<?= $item['kelas_id'] ?>">
                                            <button type="submit" name="ikuti"
                                                class="text-sm bg-teal-500 hover:bg-teal-600 text-white font-semibold px-4 py-1 rounded shadow">
                                                Ikuti
                                            </button>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-gray-500">Belum ada kelas yang tersedia untuk diikuti.</p>
                    <?php endif; ?>
                </div>
            </section>
            <section class="mb-8">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-xl font-bold text-teal-500 py-2">Kelas Yang Diikuti</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-14 gap-y-12">
                    <?php if (count($kelas_diikuti) > 0): ?>
                        <?php foreach ($kelas_diikuti as $kelas): ?>
                            <div class="cursor-pointer w-full max-w-[361px] h-[207px] shadow-lg rounded-lg flex transition-transform hover:scale-[1.02]">
                                <div class="w-3 bg-cyan-950 rounded-l-lg"></div>
                                <div class="flex-grow">
                                    <div class="bg-teal-600 h-[90px] rounded-tr-lg p-4 flex justify-between items-start">
                                        <div>
                                            <h3 class="font-roboto-slab font-bold text-white text-[12.3px] w-48 truncate">
                                                <?= htmlspecialchars($kelas['judul']) ?>
                                            </h3>
                                            <p class="font-roboto-slab text-white text-[10px] mt-8">
                                                <?= htmlspecialchars($kelas['nama_pengajar']) ?>
                                            </p>
                                        </div>
                                        <input type="hidden" name="kelas_id" value="<?= $item['kelas_id'] ?>">
                                            <button type="submit" name="keluar"
                                                class="text-sm bg-white hover:bg-teal-600 text-teal-500 font-semibold px-4 py-1 rounded shadow">
                                                Keluar
                                            </button>
                                        </input>
                                    </div>
                                    <div class="bg-white p-4 rounded-b-lg">
                                        <p class="font-roboto-slab font-bold text-cyan-950 text-[10px] line-clamp-3">
                                            <?= htmlspecialchars($kelas['deskripsi']) ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-sm text-gray-500">Belum mengikuti kelas apapun.</p>
                    <?php endif; ?>
                </div>
            </section>

        </main>

        <footer>
            <?php include '../Includes/Footer.php'; ?>
        </footer>
    </div>
</body>

</html>