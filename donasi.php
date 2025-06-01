<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="flex flex-col min-h-screen justify-between">

    <header>
        <?php include 'includes/Header.php'; ?>
    </header>

    <div class="max-w-6xl mx-auto p-6">
        <!-- Total Donasi -->
        <div class="bg-teal-600 text-white text-center py-10 rounded-lg mb-8">
            <h2 class="text-xl font-bold uppercase mb-2">Total Donasi</h2>
            <p class="text-4xl md:text-5xl font-bold">Rp 000.000,00</p>
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
                    <!-- Data donasi di sini -->
                    <tr>
                        <td class="border border-teal-300 px-4 py-2">-</td>
                        <td class="border border-teal-300 px-4 py-2">-</td>
                        <td class="border border-teal-300 px-4 py-2">-</td>
                    </tr>
                    <!-- Tambahkan baris baru sesuai kebutuhan -->
                </tbody>
            </table>
        </div>
    </div>



    <footer>
        <?php include 'includes/Footer.php'; ?>
    </footer>

</body>

</html>