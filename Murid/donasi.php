<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Relawan - Ngajar.ID</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
        font-family: 'Roboto Slab', serif;
        }
    </style>
</head>
<body class="bg-white">
    <div class="flex flex-col min-h-screen">
        <header class="bg-white shadow-sm sticky top-0 z-30">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <button id="hamburgerButton" class="text-teal-500 focus:outline-none mt-1">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <h1 class="text-xl font-bold text-teal-500 hidden sm:block">Donasi</h1>
                </div>
            </div>
        </header>
        <?php include "sidebar.php" ?>;
        <div class="max-w-6xl mx-auto p-6">
        <!-- Total Donasi -->
        <div class="bg-teal-600 text-white text-center py-10 rounded-lg mb-8">
            <h2 class="text-xl font-bold uppercase mb-2">Total Donasi</h2>
            <p class="text-4xl md:text-5xl font-bold">Rp <?php echo number_format($total_donasi, 0, ',', '.'); ?>,00</p>
        </div>
        <!-- Konten Dua Kolom: Riwayat & Form -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Riwayat Donasi -->
            <div>
            <h3 class="text-teal-600 text-2xl font-bold mb-3">Riwayat Donasi</h3>
            <div class="overflow-x-auto border border-teal-500 rounded-lg">
                <table class="w-full table-auto text-center text-sm">
                <thead class="bg-white text-teal-600 font-bold">
                    <tr>
                    <th class="border border-teal-500 px-4 py-2">Nama</th>
                    <th class="border border-teal-500 px-4 py-2">Jumlah</th>
                    <th class="border border-teal-500 px-4 py-2">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result_riwayat && $result_riwayat->num_rows > 0): ?>
                    <?php while($row = $result_riwayat->fetch_assoc()): ?>
                    <tr>
                        <td class="border border-teal-300 px-4 py-2"><?php echo htmlspecialchars($row['nama']); ?></td>
                        <td class="border border-teal-300 px-4 py-2">Rp <?php echo number_format($row['jumlah'], 0, ',', '.'); ?>,00</td>
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
            <!-- Form Donasi -->
            <div>
            <div class="bg-teal-500 rounded-lg p-6 shadow-md">
                <h3 class="text-white text-xl font-bold mb-4">Donasi</h3>
                <form action="donasi.php" method="POST" class="space-y-4">
                <input
                    type="text"
                    name="nama"
                    placeholder="Nama"
                    class="w-full p-2 rounded bg-white text-gray-700 placeholder-gray-400 focus:outline-none"
                    required
                />
                <input
                    type="number"
                    name="jumlah"
                    placeholder="Jumlah"
                    class="w-full p-2 rounded bg-white text-gray-700 placeholder-gray-400 focus:outline-none"
                    required
                />
                <button
                    type="submit"
                    class="bg-gray-900 text-white px-4 py-2 rounded hover:bg-gray-800 transition"
                >
                    DONASI
                </button>
                </form>
            </div>
            </div>
        </div>
    </div>
</body>
</html>
