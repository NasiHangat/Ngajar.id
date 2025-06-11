<?php
include '../Includes/session_check.php';
include '../Includes/DBkoneksi.php';

$monthly_token_update = [];
for ($i = 1; $i <= 12; $i++) {
    $query = "SELECT SUM(jumlah) as total FROM token WHERE MONTH(last_update) = $i";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $monthly_token_update[] = $row['total'] ? (int)$row['total'] : 0;
}
$monthly_donasi = [];
for ($i = 1; $i <= 12; $i++) {
    $query = "SELECT SUM(jumlah) as total FROM donasi WHERE MONTH(tanggal) = $i";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $monthly_donasi[] = $row['total'] ? (int)$row['total'] : 0;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Ngajar.ID</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../js/admin.js" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
        font-family: 'Roboto Slab', serif;
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
                    <button class="text-teal-500 hover:text-teal-500 p-2 rounded-full"><i class="fas fa-bell text-xl"></i></button>
                    <button class="text-teal-500 hover:text-teal-500 p-2 rounded-full"><i class="fas fa-user-circle text-xl"></i></button>
                </div>
            </div>
        </header>
        <?php include "../Includes/sidebar.php"?>
        <div class="bg-dashboard-section">
            <div class="max-w-6xl mx-auto px-4 py-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="bg-teal-500 text-white p-5 rounded-lg shadow-md">
                        <p class="text-base font-semibold">Total Relawan</p>
                        <p class="text-3xl font-bold mt-1">100</p>
                    </div>
                    <div class="bg-teal-500 text-white p-5 rounded-lg shadow-md">
                        <p class="text-base font-semibold">Total Modul</p>
                        <p class="text-3xl font-bold mt-1">100</p>
                    </div>
                    <div class="bg-teal-500 text-white p-5 rounded-lg shadow-md">
                        <p class="text-base font-semibold">Total Materi</p>
                        <p class="text-3xl font-bold mt-1">100</p>
                    </div>
                    <div class="bg-teal-500 text-white p-5 rounded-lg shadow-md">
                        <p class="text-base font-semibold">Total Siswa</p>
                        <p class="text-3xl font-bold mt-1">100</p>
                    </div>
                </div> </div> </div> <div class="bg-white shadow-sm"> <div class="max-w-6xl mx-auto px-4 py-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-6">
                    <div class="flex flex-col items-start h-[300px]">
                        <h3 class="text-lg font-semibold text-teal-500 leading-tight">Statistik Top Up Token</h3>
                        <script>
                            const tokenData = <?php echo json_encode($monthly_token_update); ?>;
                            localStorage.setItem("tokenChartData", JSON.stringify(tokenData));
                        </script>
                        <canvas id="tokenChart" class="w-full h-full"></canvas>
                    </div>
                    <div class="flex flex-col items-start h-[300px]">
                        <h3 class="text-lg font-semibold text-teal-500 leading-tight">Statistik Total Donasi</h3>
                        <script>
                            const donasiData = <?php echo json_encode($monthly_donasi); ?>;
                            localStorage.setItem("donasiChartData", JSON.stringify(donasiData));
                        </script>
                        <canvas id="donasiChart" class="w-full h-[300px]"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <?php include '../includes/Footer.php'; ?>
    </footer>
</body>
</html>
