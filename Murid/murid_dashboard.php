<?php include '../Includes/session_check.php'; ?>
<?php include '../Includes/DBkoneksi.php'; ?>
<?php
if ($_SESSION['role'] !== 'murid') {
    header("Location: unauthorized.php");
    exit;
}

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
                    <h1 class="text-xl font-bold text-teal-500 hidden sm:block">Dashboard</h1>
                </div>
                <div class="flex items-center space-x-2 sm:space-x-4">
                    <button class="text-teal-500 hover:text-teal-500 p-2 rounded-full"><i class="fas fa-bell text-xl"></i></button>
                    <button class="text-teal-500 hover:text-teal-500 p-2 rounded-full"><i class="fas fa-user-circle text-xl"></i></button>
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
                        <p class="text-white-200 opacity-70 text-xs sm:text-sm leading-tight">Pelajar</p>
                        <div class="mt-2 flex items-center space-x-2">
                            <div class="bg-white text-teal-500 text-xs font-semibold px-2.5 py-1 rounded-lg flex items-center">
                                <img src="../img/coin.png" class="mr-1.5 w-4"> 20
                            </div>
                            <button id="tambahToken" class="bg-white bg-opacity-20 hover:bg-opacity-30 text-white rounded-full w-5 h-5 sm:w-6 sm:h-6 flex items-center justify-center">
                                <i class="fas fa-plus text-sm"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <section class="mb-8">
                <h3 class="text-2xl font-bold text-teal-500 py-2">Pembelajaran</h3>
                <div class="flex space-x-3 my-4">
                    <!-- jadiin hover button,buat dua daunya putih terus hover jadi hijau -->
                    <a href="murid_modul.php" class="bg-white text-teal-500 px-6 py-2 rounded-lg text-sm font-bold border-l-2 border-r-2 border-b-4 border-[var(--border-blue-dark)] shadow-md " style="--border-blue-dark: #003D4E;">Modul</a>
                    <a href="murid_class.php" class="bg-white text-teal-500 px-7 py-2 rounded-lg text-sm font-bold border-l-2 border-r-2 border-b-4 border-[var(--border-blue-dark)] shadow-md " style="--border-blue-dark: #003D4E;">Kelas</a>
                </div>
                <div>
                    <div class="mb-3">
                        <h3 class="inline-flex items-center text-xl font-bold text-teal-500">
                            <span>Modul Pembelajaran<span>
                    </div>
                    <div class="border-l-4 border-r-4 border-b-4 border-[#003F4A] shadow-lg rounded-xl p-4 bg-white">
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <a href="murid_modul.php" class="block bg-white p-3 rounded-lg border-l-4 border-b-2 border-t-2 border-[#003F4A] shadow-sm hover:shadow-md transition-shadow text-center">
                                <p class="text-sm font-bold text-teal-500">Matematika</p>
                            </a>
                            <a href="#" class="block bg-gray-50 p-3 rounded-lg border-l-4 border-b-2 border-t-2 border-[#003F4A] shadow-sm hover:shadow-md transition-shadow text-center">
                                <p class="text-sm font-bold text-teal-500">Fisika</p>
                            </a>
                            <a href="#" class="block bg-gray-50 p-3 rounded-lg border-l-4 border-b-2 border-t-2 border-[#003F4A] shadow-sm hover:shadow-md transition-shadow text-center">
                                <p class="text-sm font-bold text-teal-500">Kimia</p>
                            </a>
                            <a href="#" class="block bg-gray-50 p-3 rounded-lg border-l-4 border-b-2 border-t-2 border-[#003F4A] shadow-sm hover:shadow-md transition-shadow text-center">
                                <p class="text-sm font-bold text-teal-500">Biologi</p>
                            </a>
                            <a href="#" class="block bg-gray-50 p-3 rounded-lg border-l-4 border-b-2 border-t-2 border-[#003F4A] shadow-sm hover:shadow-md transition-shadow text-center">
                                <p class="text-sm font-bold text-teal-500">Bahasa Indonesia</p>
                            </a>
                            <a href="#" class="block bg-gray-50 p-3 rounded-lg border-l-4 border-b-2 border-t-2 border-[#003F4A] shadow-sm hover:shadow-md transition-shadow text-center">
                                <p class="text-sm font-bold text-teal-500">Bahasa Inggris</p>
                            </a>
                            <a href="#" class="block bg-gray-50 p-3 rounded-lg border-l-4 border-b-2 border-t-2 border-[#003F4A] shadow-sm hover:shadow-md transition-shadow text-center">
                                <p class="text-sm font-bold text-teal-500">Pendidikan Kewarganegaraan</p>
                            </a>
                            <a href="#" class="block bg-gray-50 p-3 rounded-lg border-l-4 border-b-2 border-t-2 border-[#003F4A] shadow-sm hover:shadow-md transition-shadow text-center">
                                <p class="text-sm font-bold text-teal-500">Sejarah</p>
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <section>
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-bold text-teal-500">Modul Premium</h3>
                        <a href="murid_modul.php" class="text-teal-500 text-sm font-bold flex items-center">Lihat Semua <i class="fas fa-chevron-right ml-2 text-xs"></i></a>
                    </div>
                    <div class="relative">
                        <div class="absolute top-2 right-2 w-full h-full bg-[#003F4A] rounded-lg z-0"></div>
                        <div class="relative w-full h-full bg-white border-4 border-[#003F4A] rounded-lg z-10 p-5 space-y-3">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div class="flex items-start space-x-4">
                                    <div class="bg-teal-500 text-white font-bold p-4 py-10 border-l-8 border-[#003F4A] rounded-lg shadow-md">UTBK</div>
                                    <div>
                                        <p class="text-teal-500 font-bold">Tes soal UTBK</p>
                                        <div class="flex items-center text-sm tex mt-1">
                                            <img src="../img/coin.png" class="mr-1.5 w-4"> 20
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-start space-x-4">
                                    <div class="bg-teal-500 text-white font-bold p-4 py-10 border-l-8 border-[#003F4A] rounded-lg shadow-md">CPNS</div>
                                    <div>
                                        <p class="text-teal-500 font-bold">Tes soal CPNS</p>
                                        <div class="flex items-center text-sm mt-1">
                                            <img src="../img/coin.png" class="mr-1.5 w-4"> 20
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-start space-x-4">
                                    <div class="bg-teal-500 text-white font-bold p-3.5 py-10 border-l-8 border-[#003F4A] rounded-lg shadow-md">BUMN</div>
                                    <div>
                                        <p class="text-teal-500 font-bold">Tes soal BUMN</p>
                                        <div class="flex items-center text-sm mt-1">
                                            <img src="../img/coin.png" class="mr-1.5 w-4"> 20
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-start space-x-4">
                                    <div class="bg-teal-500 text-white font-bold p-3 py-10 border-l-8 border-[#003F4A] rounded-lg shadow-md">AKPOL</div>
                                    <div>
                                        <p class="text-teal-500 font-bold">Tes soal AKPOL</p>
                                        <div class="flex items-center text-sm mt-1">
                                            <img src="../img/coin.png" class="mr-1.5 w-4"> 20
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section>
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-bold text-teal-500">Terakhir Dipelajari</h3>
                        <a href="murid_modul.php" class="text-teal-500 text-sm font-bold flex items-center">Lihat Semua <i class="fas fa-chevron-right ml-2 text-xs"></i></a>
                    </div>
                    <div class="relative">
                        <div class="absolute top-2 right-2 w-full h-full bg-[#003F4A] rounded-lg z-0"></div>
                        <div class="relative w-full h-full bg-white border-4 border-[#003F4A] rounded-lg z-10 p-5 space-y-3">
                            <a href="#" class="flex items-center space-x-4 p-3 rounded-lg hover:bg-gray-100 transition-colors">
                                <div class="flex-shrink-0 w-12 h-16 rounded-lg bg-teal-500 text-white flex items-center justify-center border-l-4 border-[#003F4A]">
                                    <i class="fa-solid fa-calculator text-2xl"></i>
                                </div>
                                <div class="flex-grow">
                                    <h5 class="text-m font-bold text-teal-500">Aljabar Linear</h5>
                                    <p class="text-xs text-teal-500">Deskripsi Singkat</p>
                                </div>
                                <span class="text-xs font-bold text-teal-500">12 Soal</span>
                            </a>
                            <a href="#" class="flex items-center space-x-4 p-3 rounded-lg hover:bg-gray-100 transition-colors">
                                <div class="flex-shrink-0 w-12 h-16 rounded-lg bg-teal-500 text-white flex items-center justify-center border-l-4 border-[#003F4A]">
                                    <i class="fa-solid fa-calculator text-2xl"></i>
                                </div>
                                <div class="flex-grow">
                                    <h5 class="text-m font-bold text-teal-500">Aljabar Linear</h5>
                                    <p class="text-xs text-teal-500">Deskripsi Singkat</p>
                                </div>
                                <span class="text-xs font-bold text-teal-500">12 Soal</span>
                            </a>
                            <a href="#" class="flex items-center space-x-4 p-3 rounded-lg hover:bg-gray-100 transition-colors">
                                <div class="flex-shrink-0 w-12 h-16 rounded-lg bg-teal-500 text-white flex items-center justify-center border-l-4 border-[#003F4A]">
                                    <i class="fa-solid fa-calculator text-2xl"></i>
                                </div>
                                <div class="flex-grow">
                                    <h5 class="text-m font-bold text-teal-500">Aljabar Linear</h5>
                                    <p class="text-xs text-teal-500">Deskripsi Singkat</p>
                                </div>
                                <span class="text-xs font-bold text-teal-500">12 Soal</span>
                            </a>
                            <a href="#" class="flex items-center space-x-4 p-3 rounded-lg hover:bg-gray-100 transition-colors">
                                <div class="flex-shrink-0 w-12 h-16 rounded-lg bg-teal-500 text-white flex items-center justify-center border-l-4 border-[#003F4A]">
                                    <i class="fa-solid fa-calculator text-2xl"></i>
                                </div>
                                <div class="flex-grow">
                                    <h5 class="text-m font-bold text-teal-500">Aljabar Linear</h5>
                                    <p class="text-xs text-teal-500">Deskripsi Singkat</p>
                                </div>
                                <span class="text-xs font-bold text-teal-500">12 Soal</span>
                            </a>
                        </div>
                    </div>
                </section>
            </div>
        </main>
        <div id="modalTambahToken" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-md transform transition-all">
                <div class="bg-teal-500 text-white px-6 py-4 rounded-t-xl flex items-center justify-between">
                    <h3 class="text-xl font-bold">Tambah Token</h3>
                    <button id="closeModalTambah" class="text-white hover:text-gray-200 text-2xl"><i class="fas fa-times"></i></button>
                </div>
                <div class="p-6">
                    <form id="formTambahToken" class="space-y-4">
                        <div class="grid grid-cols-3 gap-3">
                            <div class="token-option cursor-pointer p-3 rounded-lg border border-gray-300 text-center transition-all hover:bg-teal-50 selected:bg-teal-500 selected:text-white" data-tokens="5" data-price="1500">
                                <p class="font-semibold">5 Token</p>
                                <p class="text-sm">Rp. 1.500</p>
                            </div>
                            <div class="token-option cursor-pointer p-3 rounded-lg border border-gray-300 text-center transition-all hover:bg-teal-50 selected:bg-teal-500 selected:text-white" data-tokens="5" data-price="1500">
                                <p class="font-semibold">10 Token</p>
                                <p class="text-sm">Rp. 3.000</p>
                            </div>
                            <div class="token-option cursor-pointer p-3 rounded-lg border border-gray-300 text-center transition-all hover:bg-teal-50 selected:bg-teal-500 selected:text-white" data-tokens="5" data-price="1500">
                                <p class="font-semibold">15 Token</p>
                                <p class="text-sm">Rp. 4.500</p>
                            </div>
                            <div class="token-option cursor-pointer p-3 rounded-lg border border-gray-300 text-center transition-all hover:bg-teal-50 selected:bg-teal-500 selected:text-white" data-tokens="5" data-price="1500">
                                <p class="font-semibold">20 Token</p>
                                <p class="text-sm">Rp. 6.000</p>
                            </div>
                            <div class="token-option cursor-pointer p-3 rounded-lg border border-gray-300 text-center transition-all hover:bg-teal-50 selected:bg-teal-500 selected:text-white" data-tokens="5" data-price="1500">
                                <p class="font-semibold">25 Token</p>
                                <p class="text-sm">Rp. 7.500</p>
                            </div>
                            <div class="token-option cursor-pointer p-3 rounded-lg border border-gray-300 text-center transition-all hover:bg-teal-50 selected:bg-teal-500 selected:text-white" data-tokens="5" data-price="1500">
                                <p class="font-semibold">30 Token</p>
                                <p class="text-sm">Rp. 9.000</p>
                            </div>
                            <div class="token-option cursor-pointer p-3 rounded-lg border border-gray-300 text-center transition-all hover:bg-teal-50 selected:bg-teal-500 selected:text-white" data-tokens="5" data-price="1500">
                                <p class="font-semibold">35 Token</p>
                                <p class="text-sm">Rp. 10.500</p>
                            </div>
                            <div class="token-option cursor-pointer p-3 rounded-lg border border-gray-300 text-center transition-all hover:bg-teal-50 selected:bg-teal-500 selected:text-white" data-tokens="5" data-price="1500">
                                <p class="font-semibold">40 Token</p>
                                <p class="text-sm">Rp. 12.000</p>
                            </div>
                            <div class="token-option cursor-pointer p-3 rounded-lg border border-gray-300 text-center transition-all hover:bg-teal-50 selected:bg-teal-500 selected:text-white" data-tokens="5" data-price="1500">
                                <p class="font-semibold">45 Token</p>
                                <p class="text-sm">Rp. 13.500</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-between pt-4">
                            <p class="text-lg font-bold" id="totalPrice">Rp 0,00</p>
                            <button type="submit" class="px-6 py-3 bg-teal-500 text-white rounded-md hover:bg-teal-600 transition-colors font-semibold">Beli</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <footer>
            <?php include '../includes/Footer.php'; ?>
        </footer>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('modalTambahToken');
        const openModalBtn = document.getElementById('tambahToken');
        const closeModalBtn = document.getElementById('closeModalTambah');
        const tokenOptions = document.querySelectorAll('.token-option');
        const totalPriceDisplay = document.getElementById('totalPrice');
        const formTambahToken = document.getElementById('formTambahToken');
        let selectedPrice = 0; // To store the currently selected price

        // Function to format price to Rupiah
        function formatRupiah(amount) {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(amount);
        }

        // Open modal
        openModalBtn.addEventListener('click', function() {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            // Reset selection and price when opening the modal
            tokenOptions.forEach(option => {
                option.classList.remove('bg-teal-500', 'text-white');
            });
            selectedPrice = 0;
            totalPriceDisplay.textContent = formatRupiah(selectedPrice);
        });

        // Close modal
        closeModalBtn.addEventListener('click', function() {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        });

        // Close modal when clicking outside of it
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        });

        // Token option selection logic
        tokenOptions.forEach(option => {
            option.addEventListener('click', function() {
                // Remove selected class from all options
                tokenOptions.forEach(opt => {
                    opt.classList.remove('bg-teal-500', 'text-white');
                });

                // Add selected class to the clicked option
                this.classList.add('bg-teal-500', 'text-white');

                // Update the total price
                selectedPrice = parseInt(this.dataset.price);
                totalPriceDisplay.textContent = formatRupiah(selectedPrice);
            });
        });

        // Handle form submission (e.g., to process the purchase)
        formTambahToken.addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent default form submission

            if (selectedPrice > 0) {
                const selectedTokens = document.querySelector('.token-option.bg-teal-500');
                if (selectedTokens) {
                    const tokens = selectedTokens.dataset.tokens;
                    const price = selectedPrice;
                    alert(`Anda akan membeli ${tokens} Token seharga ${formatRupiah(price)}. (Simulasi Pembelian)`);
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                } else {
                    alert('Silakan pilih jumlah token terlebih dahulu.');
                }
            } else {
                alert('Silakan pilih jumlah token terlebih dahulu.');
            }
        });
    });
    </script>
</body>

</html>
