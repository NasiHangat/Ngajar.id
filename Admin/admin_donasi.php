<?php
include '../Includes/DBkoneksi.php';
include '../Includes/Session_check.php';

// Ambil total donasi
$sql_total = "SELECT SUM(jumlah) AS total FROM donasi";
$result_total = $conn->query($sql_total);
$total_donasi = 0;
if ($result_total && $row = $result_total->fetch_assoc()) {
    $total_donasi = $row['total'] ?? 0;
}

// Ambil riwayat donasi
$sql_riwayat = "SELECT nama, jumlah, tanggal FROM donasi ORDER BY tanggal DESC";
$result_riwayat = $conn->query($sql_riwayat);
?>


<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="../img/Logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100;300;400;500;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="min-h-screen font-roboto">
    <div class="flex flex-col">
        <header class="bg-white shadow-sm sticky top-0 z-30">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <button id="hamburgerButton" class="text-teal-500 focus:outline-none mt-1">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <h1 class="text-xl font-bold text-teal-500 hidden sm:block">Donasi</h1>
                </div>
                <div class="flex items-center space-x-2 sm:space-x-4">
                    <?php include "../includes/Profile.php"; ?>
                </div>
            </div>
        </header>
    </div>

    <?php include "../Includes/sidebar.php" ?>;

    <div class="max-w-6xl mx-auto px-4 py-4">
        <!-- Total Donasi -->
        <div class="bg-teal-600 text-white text-center py-10 rounded-lg mb-8">
            <h2 class="text-5xl font-bold uppercase mb-2">Total Donasi</h2>
            <p class="text-5xl md:text-7xl font-bold">Rp <?php echo number_format($total_donasi, 0, ',', '.'); ?></p>
        </div>

        <!-- Riwayat Donasi -->
        <h3 class="text-teal-600 text-2xl font-bold text-center mb-4">Riwayat Donasi</h3>

        <div class="mx-w-6xl overflow-x-auto">
            <table class="w-full table-auto border border-teal-500 text-center">
                <thead class="bg-white text-teal-600 font-bold">
                    <tr>
                        <th class="border border-teal-500 px-4 py-2">Nama</th>
                        <th class="border border-teal-500 px-4 py-2">Jumlah Donasi</th>
                        <th class="border border-teal-500 px-4 py-2">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result_riwayat && $result_riwayat->num_rows > 0): ?>
                        <?php while ($row = $result_riwayat->fetch_assoc()): ?>
                            <tr>
                                <td class="border border-teal-300 px-4 py-2"><?php echo htmlspecialchars($row['nama']); ?></td>
                                <td class="border border-teal-300 px-4 py-2">Rp <?php echo number_format($row['jumlah'], 0, ',', '.'); ?></td>
                                <td class="border border-teal-300 px-4 py-2"><?php echo date('d-m-Y H:i', strtotime($row['tanggal'])); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="border border-teal-300 px-4 py-2 text-gray-500">Belum ada donasi tercatat.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>

            </table>
        </div>
    </div>
    <footer>
        <?php include '../includes/Footer.php'; ?>
    </footer>
</body>

</html>