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