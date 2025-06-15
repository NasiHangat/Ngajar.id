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
    
</body>