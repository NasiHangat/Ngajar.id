<?php
include '../Includes/session_check.php';
include '../Includes/DBkoneksi.php';

// Query untuk mendapatkan statistik dashboard
$stats = [];

// Total Relawan (pengajar yang aktif)
$query_relawan = "SELECT COUNT(*) as total FROM users WHERE role = 'pengajar' AND status = 'aktif'";
$result_relawan = mysqli_query($conn, $query_relawan);
$stats['total_relawan'] = mysqli_fetch_assoc($result_relawan)['total'];

// Total Modul
$query_modul = "SELECT COUNT(*) as total FROM modul";
$result_modul = mysqli_query($conn, $query_modul);
$stats['total_modul'] = mysqli_fetch_assoc($result_modul)['total'];

// Total Materi
$query_materi = "SELECT COUNT(*) as total FROM materi";
$result_materi = mysqli_query($conn, $query_materi);
$stats['total_materi'] = mysqli_fetch_assoc($result_materi)['total'];

// Total Siswa (murid yang aktif)
$query_siswa = "SELECT COUNT(*) as total FROM users WHERE role = 'murid' AND status = 'aktif'";
$result_siswa = mysqli_query($conn, $query_siswa);
$stats['total_siswa'] = mysqli_fetch_assoc($result_siswa)['total'];

// Data untuk chart token (berdasarkan token yang di-update per bulan)
$monthly_token_update = [];
for ($i = 1; $i <= 12; $i++) {
    $query = "SELECT SUM(jumlah) as total FROM token WHERE MONTH(last_update) = $i AND YEAR(last_update) = YEAR(CURDATE())";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $monthly_token_update[] = $row['total'] ? (int)$row['total'] : 0;
}

// Data untuk chart donasi (berdasarkan donasi per bulan)
$monthly_donasi = [];
for ($i = 1; $i <= 12; $i++) {
    $query = "SELECT SUM(jumlah) as total FROM donasi WHERE MONTH(tanggal) = $i AND YEAR(tanggal) = YEAR(CURDATE())";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $monthly_donasi[] = $row['total'] ? (int)$row['total'] : 0;
}

// Data untuk chart topup token (berdasarkan topup per bulan)
$monthly_topup = [];
for ($i = 1; $i <= 12; $i++) {
    $query = "SELECT SUM(jumlah_token) as total FROM topup WHERE MONTH(tanggal) = $i AND YEAR(tanggal) = YEAR(CURDATE())";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $monthly_topup[] = $row['total'] ? (int)$row['total'] : 0;
}

// Query untuk Peringkat Teratas Topup Token
$top_murid = [];
$query_top_murid = "
    SELECT u.name, SUM(t.jumlah_token) as total_token
    FROM topup t
    JOIN users u ON t.user_id = u.user_id
    WHERE u.role = 'murid'
    GROUP BY t.user_id
    ORDER BY total_token DESC
    LIMIT 3
";
$result_top_murid = mysqli_query($conn, $query_top_murid);
while ($row = mysqli_fetch_assoc($result_top_murid)) {
    $top_murid[] = $row;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Ngajar.ID</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="icon" type="image/png" href="../img/Logo.png">
    <script src="../js/admin.js" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Roboto Slab', serif;
        }
        .counter-animation {
            transition: all 0.5s ease-in-out;
        }
        .stat-card {
            transition: transform 0.2s ease-in-out;
        }
        .stat-card:hover {
            transform: translateY(-2px);
        }
    </style>
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
                    <button class="text-teal-500 hover:text-teal-600 p-2 rounded-full transition-colors">
                        <i class="fas fa-bell text-xl"></i>
                    </button>
                    <?php include "../includes/Profile.php"; ?>
                </div>
            </div>
        </header>
        <?php include "../Includes/sidebar.php"?>
        <div class="bg-dashboard-section">
            <div class="max-w-6xl mx-auto px-4 py-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="bg-teal-500 text-white p-5 rounded-lg shadow-md stat-card">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-base font-semibold">Total Relawan</p>
                                <p class="text-3xl font-bold mt-1 counter-animation" id="totalRelawan" data-target="<?php echo $stats['total_relawan']; ?>">0</p>
                            </div>
                            <i class="fas fa-chalkboard-teacher text-3xl opacity-80"></i>
                        </div>
                    </div>
                    
                    <div class="bg-blue-500 text-white p-5 rounded-lg shadow-md stat-card">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-base font-semibold">Total Modul</p>
                                <p class="text-3xl font-bold mt-1 counter-animation" id="totalModul" data-target="<?php echo $stats['total_modul']; ?>">0</p>
                            </div>
                            <i class="fas fa-book text-3xl opacity-80"></i>
                        </div>
                    </div>
                    
                    <div class="bg-green-500 text-white p-5 rounded-lg shadow-md stat-card">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-base font-semibold">Total Materi</p>
                                <p class="text-3xl font-bold mt-1 counter-animation" id="totalMateri" data-target="<?php echo $stats['total_materi']; ?>">0</p>
                            </div>
                            <i class="fas fa-file-alt text-3xl opacity-80"></i>
                        </div>
                    </div>
                    
                    <div class="bg-purple-500 text-white p-5 rounded-lg shadow-md stat-card">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-base font-semibold">Total Siswa</p>
                                <p class="text-3xl font-bold mt-1 counter-animation" id="totalSiswa" data-target="<?php echo $stats['total_siswa']; ?>">0</p>
                            </div>
                            <i class="fas fa-user-graduate text-3xl opacity-80"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-white shadow-sm">
            <div class="max-w-6xl mx-auto px-4 py-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-8 gap-y-6">
                    <div class="flex flex-col items-start h-[400px]">
                        <h3 class="text-lg font-semibold text-teal-500 leading-tight mb-4">Statistik Update Token Bulanan</h3>
                        <div class="w-full h-full">
                            <canvas id="tokenChart" class="w-full h-full"></canvas>
                        </div>
                    </div>
                    <div class="flex flex-col items-start h-[400px]">
                        <h3 class="text-lg font-semibold text-teal-500 leading-tight mb-4">Statistik Total Donasi Bulanan</h3>
                        <div class="w-full h-full">
                            <canvas id="donasiChart" class="w-full h-full"></canvas>
                        </div>
                    </div>
                </div>
        </div>
    </div>
    
    <section class="py-10 px-4">
                <div class="max-w-4xl mx-auto">
                    <h2 class="text-2xl font-bold text-center text-gray-800 mb-8">Peringkat Teratas Pembelian Token</h2>
                    <div class="flex justify-center items-end gap-4 md:gap-6">
                        <!-- Peringkat 2 -->
                        <div class="text-center w-1/3">
                            <img src="https://placehold.co/80x80/c0c0c0/FFFFFF?text=2nd" alt="Peringkat 2" class="w-20 h-20 rounded-full mx-auto border-4 border-gray-300">
                            <h4 class="font-bold mt-2 text-gray-700"><?php echo htmlspecialchars($top_murid[1]['name'] ?? 'N/A'); ?></h4>
                            <div class="flex items-center justify-center text-yellow-500 font-bold"><i class="fas fa-star mr-1"></i><span><?php echo $top_murid[1]['total_token'] ?? 0; ?></span></div>
                            <div class="bg-gray-200 rounded-t-lg p-6 mt-2 h-32 flex items-center justify-center">
                                <i class="fas fa-trophy text-5xl text-gray-400"></i>
                                <span class="text-6xl font-black text-gray-400">2</span>
                            </div>
                        </div>
                        <!-- Peringkat 1 -->
                        <div class="text-center w-1/3">
                            <div class="relative inline-block">
                                <img src="https://placehold.co/96x96/ffd700/FFFFFF?text=1st" alt="Peringkat 1" class="w-24 h-24 rounded-full mx-auto border-4 border-yellow-400">
                                <i class="fas fa-crown text-3xl text-yellow-500 absolute -top-4 right-0 transform rotate-12"></i>
                            </div>
                            <h4 class="font-bold mt-2 text-gray-800"><?php echo htmlspecialchars($top_murid[0]['name'] ?? 'N/A'); ?></h4>
                            <div class="flex items-center justify-center text-yellow-500 font-bold"><i class="fas fa-star mr-1"></i><span><?php echo $top_murid[0]['total_token'] ?? 0; ?></span></div>
                            <div class="bg-yellow-300 rounded-t-lg p-6 mt-2 h-48 flex items-center justify-center">
                                <i class="fas fa-trophy text-6xl text-yellow-500"></i>
                                <span class="text-7xl font-black text-yellow-600">1</span>
                            </div>
                        </div>
                        <!-- Peringkat 3 -->
                        <div class="text-center w-1/3">
                            <img src="https://placehold.co/80x80/cd7f32/FFFFFF?text=3rd" alt="Peringkat 3" class="w-20 h-20 rounded-full mx-auto border-4 border-orange-300">
                            <h4 class="font-bold mt-2 text-gray-700"><?php echo htmlspecialchars($top_murid[2]['name'] ?? 'N/A'); ?></h4>
                            <div class="flex items-center justify-center text-yellow-500 font-bold"><i class="fas fa-star mr-1"></i><span><?php echo $top_murid[2]['total_token'] ?? 0; ?></span></div>
                            <div class="bg-orange-200 rounded-t-lg p-6 mt-2 h-24 flex items-center justify-center">
                                <i class="fas fa-trophy text-4xl text-orange-400"></i>
                                <span class="text-5xl font-black text-orange-500">3</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

    <!-- Pass data ke JavaScript -->
    <script>
        // Data untuk charts
        const chartData = {
            tokenData: <?php echo json_encode($monthly_token_update); ?>,
            donasiData: <?php echo json_encode($monthly_donasi); ?>,
            topupData: <?php echo json_encode($monthly_topup); ?>
        };
        
        // Simpan data ke localStorage untuk digunakan di admin.js
        localStorage.setItem("chartData", JSON.stringify(chartData));
        
        // Data statistik untuk counter animation
        const statsData = {
            totalRelawan: <?php echo $stats['total_relawan']; ?>,
            totalModul: <?php echo $stats['total_modul']; ?>,
            totalMateri: <?php echo $stats['total_materi']; ?>,
            totalSiswa: <?php echo $stats['total_siswa']; ?>
        };
        
        localStorage.setItem("statsData", JSON.stringify(statsData));
    </script>
    
    <footer>
        <?php include '../includes/Footer.php'; ?>
    </footer>
</body>
</html>