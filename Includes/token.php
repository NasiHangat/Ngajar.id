<div id="popup" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
  <div class="bg-white p-6 rounded-lg shadow-lg w-[90%] max-w-md border border-teal-500 relative">
    <h2 class="text-teal-600 font-bold text-xl mb-4">Beli Token</h2>

    <div class="grid grid-cols-3 gap-2 mb-4">
      <?php
      // Contoh daftar token
      $tokens = [
        ['jumlah' => '5 Token', 'harga' => 'Rp 1.500,00'],
        ['jumlah' => '10 Token', 'harga' => 'Rp 3.000,00'],
        ['jumlah' => '15 Token', 'harga' => 'Rp 4.500,00'],
        ['jumlah' => '5 Token', 'harga' => 'Rp 1.500,00'],
        ['jumlah' => '5 Token', 'harga' => 'Rp 1.500,00'],
        ['jumlah' => '5 Token', 'harga' => 'Rp 1.500,00'],
        ['jumlah' => '5 Token', 'harga' => 'Rp 1.500,00'],
        ['jumlah' => '5 Token', 'harga' => 'Rp 1.500,00'],
        ['jumlah' => '5 Token', 'harga' => 'Rp 1.500,00'],
      ];

      foreach ($tokens as $token) {
        echo "<div class='bg-emerald-500 text-white p-2 rounded text-center'>";
        echo "<p class='font-bold'>{$token['jumlah']}</p>";
        echo "<p>{$token['harga']}</p>";
        echo "</div>";
      }
      ?>
    </div>

    <div class="flex justify-between items-center">
      <button id="purchase-btn" class="bg-teal-800 text-white px-4 py-2 rounded">BELI</button>
    </div>

    <!-- Tombol Tutup -->
    <button id="closePopup" class="absolute top-2 right-2 text-gray-500 hover:text-black">
      <i class="fas fa-times"></i>
    </button>
  </div>
</div>
