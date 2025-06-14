<?php include '../Includes/DBkoneksi.php'; ?>

<?php
session_start();
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'ngajar_id';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$id_pengguna = $_SESSION['user_id'] ?? null;

$query = "
    SELECT 
        k.kelas_id AS id,
        k.judul,
        k.deskripsi,
        u.name AS relawan
    FROM kelas k
    JOIN users u ON k.pengajar_id = u.user_id
    WHERE k.kelas_id NOT IN (
        SELECT kelas_id FROM kelas_peserta WHERE siswa_id = ?
    )
    AND k.status = 'aktif'
";

$namaPengguna = "";

if ($id_pengguna) {
    $stmt = $conn->prepare("SELECT name FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $id_pengguna);
    $stmt->execute();
    $stmt->bind_result($namaPengguna);
    $stmt->fetch();
    $stmt->close();
}
?>


$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_pengguna);
$stmt->execute();
$result = $stmt->get_result();

$kelas = [];
while ($row = $result->fetch_assoc()) {
    $kelas[] = $row;
}


if ($id_pengguna) {
    $stmt = $conn->prepare("SELECT name FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $id_pengguna);
    $stmt->execute();
    $stmt->bind_result($namaPengguna);
    $stmt->fetch();
    $stmt->close();
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Ngajar.ID</title>
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
                    <h1 class="text-xl font-bold text-teal-500 hidden sm:block">Kelas</h1>
                </div>
                <div class="flex items-center space-x-2 sm:space-x-4">
                    <button class="text-teal-500 hover:text-teal-500 p-2 rounded-full"><i class="fas fa-bell text-xl"></i></button>
                    <button class="text-teal-500 hover:text-teal-500 p-2 rounded-full"><i class="fas fa-user-circle text-xl"></i></button>
                </div>
            </div>
        </header>
        <?php include "../Includes/sidebar.php" ?>
        <div class="bg-teal-500 py-4">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 flex items-start justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-white flex items-center justify-center">
                        <i class="fa-regular fa-user text-teal-500 text-3xl"></i>
                    </div>
                    <div class="text-white">
                        <h2 class="font-bold text-base sm:text-lg leading-tight "><?php echo $namaPengguna; ?></h2>
                        <p class="text-white-200 opacity-70 text-xs sm:text-sm leading-tight">Pelajar</p>
                        <!-- Token dan tombol tambah diletakkan di bawah -->
                        <div class="mt-2 flex items-center space-x-2">
                            <div class="bg-white text-teal-500 text-xs font-semibold px-2.5 py-1 rounded-lg flex items-center">
                                <img src="../img/coin.png" class="mr-1.5 w-4"></img> 20
                            </div>
                            <button class="bg-white bg-opacity-20 hover:bg-opacity-30 text-white rounded-full w-5 h-5 sm:w-6 sm:h-6 flex items-center justify-center">
                                <i class="fas fa-plus text-sm"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <main class="max-w-6xl mx-auto px-4 sm:px-6 py-6">
    <section class="mb-8">
        <div class="flex items-center justify-between mb-3">
            <h3 class="text-xl font-bold text-teal-500 py-2">Kelas</h3>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-14 gap-y-12">
            <?php if (!empty($kelas)): ?>
                <?php foreach ($kelas as $item): ?>
                    <div class="w-full max-w-[361px] h-[207px] shadow-lg rounded-lg flex">
                        <div class="w-3 bg-cyan-950 rounded-l-lg"></div>
                        <div class="flex-grow">
                            <div class="bg-teal-600 h-[90px] rounded-tr-lg p-4 flex justify-between items-start">
                                <div>
                                    <h3 class="font-roboto-slab font-bold text-white text-[12.3px] w-48">
                                        <?= htmlspecialchars($item['judul']) ?>
                                    </h3>
                                    <p class="font-roboto-slab text-white text-[10px] mt-8">
                                        <?= htmlspecialchars($item['relawan']) ?>
                                    </p>
                                </div>
                                <div class="w-14 h-14 bg-white rounded-full flex justify-center items-center shrink-0">
                                    <img class="w-6 h-8" src="<?= $item['icon'] ?? 'img/vector-default.svg' ?>" alt="Icon Kelas" />
                                </div>
                            </div>
                           
                        </div>
                        <a href="murid_isikelas.php?id=<?= $item['id'] ?>" class="w-4 bg-white flex flex-col items-center py-2 space-y-1.5 rounded-r-lg hover:bg-gray-100">
                            <div class="w-1.5 h-1.5 bg-cyan-950 rounded-full"></div>
                            <div class="w-1.5 h-1.5 bg-cyan-950 rounded-full"></div>
                            <div class="w-1.5 h-1.5 bg-cyan-950 rounded-full"></div>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-gray-500">Belum ada kelas yang tersedia untuk diikuti.</p>
            <?php endif; ?>
        </div>
    </section>
</main>
        <footer>
            <?php include '../Includes/Footer.php'; ?>
        </footer>
</body>

</html>