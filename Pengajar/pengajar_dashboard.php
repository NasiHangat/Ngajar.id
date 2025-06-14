<?php include '../Includes/session_check.php'; ?>
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
// Pemanggilan prosedur untuk mendapatkan statistik pengajar
$stmt = $conn->prepare("CALL get_pengajar_statistik(?)");
$stmt->bind_param("i", $id_pengguna);
$stmt->execute();

$stmt->store_result();
$stmt->bind_result($total_kelas);
$stmt->fetch();
// Pindah ke hasil ke-2
$stmt->next_result();
$stmt->store_result();
$stmt->bind_result($total_materi);
$stmt->fetch();
// Pindah ke hasil ke-3
$stmt->next_result();
$stmt->store_result();
$stmt->bind_result($total_siswa);
$stmt->fetch();

$stmt->close();

// Ambil daftar kelas yang dibina oleh pengajar
$kelasList = [];
if ($id_pengguna) {
    $query = "
        SELECT k.kelas_id, k.judul, COUNT(kp.siswa_id) AS total_siswa
        FROM kelas k
        LEFT JOIN kelas_peserta kp ON k.kelas_id = kp.kelas_id
        WHERE k.pengajar_id = ?
        GROUP BY k.kelas_id, k.judul
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_pengguna);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $kelasList[] = $row;
    }

    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Relawan - Ngajar.ID</title>
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
                    <h1 class="text-xl font-bold text-teal-500 hidden sm:block">Dashboard</h1>
                </div>
                <div class="flex items-center space-x-2 sm:space-x-4">
                    <button class="text-teal-500 hover:text-teal-500 p-2 rounded-full"><i class="fas fa-bell text-xl"></i></button>
                    <?php include "../includes/Profile.php"; ?>
                </div>
            </div>
        </header>

        <?php include "../includes/sidebar.php" ?>

        <main class="flex-grow">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="bg-teal-500 text-white p-6 sm:p-8 rounded-xl shadow-lg mb-10 flex items-center space-x-6">
                    <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-white flex items-center justify-center">
                        <i class="fa-regular fa-user text-teal-500 text-3xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-semibold mb-1">Terimakasih, <?php echo $namaPengguna; ?></h2>
                        <p class="text-sm sm:text-base opacity-90">Idealisme adalah kemewahan terakhir yang hanya dimiliki oleh pemuda.</p>
                    </div>
                </div>
                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                    <div class="bg-teal-500 text-white p-5 rounded-xl shadow-md flex items-center space-x-4 hover:shadow-lg hover:-translate-y-1 transition-all">
                        <i class="fas fa-graduation-cap text-3xl opacity-80"></i>
                        <div>
                            <p class="text-sm font-medium opacity-90">Total Kelas Dibina</p>
                            <p class="text-2xl font-bold"><?php echo $total_kelas; ?></p>
                        </div>
                    </div>
                    <div class="bg-teal-500 text-white p-5 rounded-xl shadow-md flex items-center space-x-4 hover:shadow-lg hover:-translate-y-1 transition-all">
                        <i class="fas fa-book text-3xl opacity-80"></i>
                        <div>
                            <p class="text-sm font-medium opacity-90">Modul Yang Dibuat</p>
                            <p class="text-2xl font-bold"><?php echo $total_materi; ?></p>
                        </div>
                    </div>
                    <div class="bg-teal-500 text-white p-5 rounded-xl shadow-md flex items-center space-x-4 hover:shadow-lg hover:-translate-y-1 transition-all">
                        <i class="fas fa-users text-3xl opacity-80"></i>
                        <div>
                            <p class="text-sm font-medium opacity-90">Siswa Yang Mengikuti Kelas</p>
                            <p class="text-2xl font-bold"><?php echo $total_siswa; ?></p>
                        </div>
                    </div>
                </div>

                    <div class="bg-white p-6 sm:p-7 rounded-xl shadow-md">
                        <h3 class="text-xl font-semibold text-teal-500 mb-6">Kelas Yang Dibina</h3>
                        <div class="space-y-4">
                            <?php if (count($kelasList) > 0): ?>
                                <?php foreach ($kelasList as $kelas): ?>
                                    <div class="border border-gray-200 rounded-lg p-4 flex items-center space-x-4 hover:shadow-sm hover:border-teal-500 transition-all">
                                        <div class="p-3 bg-teal-100 rounded-lg flex-shrink-0"><i class="fas fa-chalkboard-teacher text-2xl text-teal-600"></i></div>
                                        <div>
                                            <h4 class="font-semibold text-base text-gray-800"><?php echo htmlspecialchars($kelas['judul']); ?></h4>
                                            <p class="text-sm text-gray-500"><?php echo $kelas['total_siswa']; ?> siswa aktif</p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p class="text-gray-500">Belum ada kelas yang dibina.</p>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
            </div>
        </main>
    </div>

    <footer>
        <?php include '../Includes/Footer.php'; ?>
    </footer>
</body>

</html>