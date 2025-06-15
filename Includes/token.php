<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Footer Ngajar.ID</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100;300;400;500;600;700;900&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
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
<body>
    
    <div id="token-container" class="space-y-4">
        <p>Pilih jumlah token yang ingin dibeli:</p>
        <div class="grid grid-cols-2 gap-4">
            <button class="topup-option p-4 border-2 border-teal-500 rounded-lg hover:bg-teal-50 transition-colors" data-tokens="50" data-price="25000">
                <div class="font-bold text-teal-500">50 Token</div>
                <div class="text-sm text-gray-600">Rp 25.000</div>
            </button>
            <button class="topup-option p-4 border-2 border-teal-500 rounded-lg hover:bg-teal-50 transition-colors" data-tokens="100" data-price="45000">
                <div class="font-bold text-teal-500">100 Token</div>
                <div class="text-sm text-gray-600">Rp 45.000</div>
            </button>
            <button class="topup-option p-4 border-2 border-teal-500 rounded-lg hover:bg-teal-50 transition-colors" data-tokens="250" data-price="100000">
                <div class="font-bold text-teal-500">250 Token</div>
                <div class="text-sm text-gray-600">Rp 100.000</div>
            </button>
            <button class="topup-option p-4 border-2 border-teal-500 rounded-lg hover:bg-teal-50 transition-colors" data-tokens="500" data-price="180000">
                <div class="font-bold text-teal-500">500 Token</div>
                <div class="text-sm text-gray-600">Rp 180.000</div>
            </button>
        </div>
        
        <div id="beli-section" class="mt-4 hidden">
            <button id="beli-button" class="bg-teal-600 text-white px-4 py-2 rounded-lg hover:bg-teal-700 transition">Beli Sekarang</button>
        </div>
    </div>
    
    <div id="token-modal" class="fixed top-0 left-0 w-full h-full bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div id="token-content" class="bg-white p-8 rounded-lg w-96">
            <button id="tutup-modal" class="text-red-500 float-right cursor-pointer">&times;</button>
            <h2 class="text-2xl font-bold mb-4">Konfirmasi Pembelian</h2>
            <p id="konfirmasi-text" class="mb-4"></p>
            <button id="konfirmasi-beli" class="bg-teal-600 text-white px-4 py-2 rounded-lg hover:bg-teal-700 transition">Konfirmasi Pembelian</button>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const topupOptions = document.querySelectorAll(".topup-option");
            const beliButton = document.getElementById("beli-button");
            const tokenModal = document.getElementById("token-modal");
            const tutupModal = document.getElementById("tutup-modal");
            const konfirmasiText = document.getElementById("konfirmasi-text");
            const konfirmasiBeli = document.getElementById("konfirmasi-beli");
            
            topupOptions.forEach(function (option) {
                option.addEventListener("click", function () {
                    const tokens = option.getAttribute("data-tokens");
                    const price = option.getAttribute("data-price");
                    konfirmasiText.textContent = `Anda akan membeli ${tokens} token dengan total harga Rp ${price}`;
                    beliButton.dataset.tokens = tokens;
                    beliButton.dataset.price = price;
                    tokenModal.classList.remove("hidden");
                });
            });
            
            beliButton.addEventListener("click", function () {
                // Lakukan aksi pembelian di sini
                const tokens = beliButton.dataset.tokens;
                const price = beliButton.dataset.price;
                // Kirim data ke server untuk diproses
                // Contoh: Kirim data ke server menggunakan XMLHttpRequest
                const xhr = new XMLHttpRequest();
                xhr.open("POST", "proses_pembelian.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        // Proses pembelian berhasil, tutup modal
                        tokenModal.classList.add("hidden");
                        // Tampilkan pesan sukses
                        alert("Pembelian berhasil!");
                    }
                };
                xhr.send("tokens=" + tokens + "&price=" + price);
            });
            
            tutupModal.addEventListener("click", function () {
                tokenModal.classList.add("hidden");
            });
            konfirmasiBeli.addEventListener("click", function () {
                // Lakukan aksi konfirmasi pembelian di sini
                // Contoh: Kirim data ke server untuk konfirmasi pembelian
                const xhr = new XMLHttpRequest();
                xhr.open("POST", "konfirmasi_pembelian.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function () {
        }
        });
    </script>
</body>