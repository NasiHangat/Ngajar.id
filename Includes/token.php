<div id="popup" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50 transition-opacity duration-300">
  <div class="bg-white p-6 rounded-lg shadow-lg w-[90%] max-w-md border border-teal-500 relative animate-scale-in">
    <h2 class="text-teal-600 font-bold text-xl mb-4">Beli Token</h2>

    <div class="grid grid-cols-3 gap-2 mb-4" id="token-options">
      <?php
      $tokens = [
        ['jumlah' => '5 Token', 'harga' => 'Rp 1.500,00'],
        ['jumlah' => '10 Token', 'harga' => 'Rp 3.000,00'],
        ['jumlah' => '15 Token', 'harga' => 'Rp 4.500,00'],
      ];

      foreach ($tokens as $index => $token) {
        echo "<div class='token-option bg-emerald-500 text-white p-2 rounded text-center cursor-pointer transition hover:scale-105' data-index='{$index}' data-jumlah='{$token['jumlah']}' data-harga='{$token['harga']}'>";
        echo "<p class='font-bold'>{$token['jumlah']}</p>";
        echo "<p>{$token['harga']}</p>";
        echo "</div>";
      }
      ?>
    </div>

    <div class="text-center text-sm text-gray-600 mb-3" id="selected-token-info">Pilih paket token di atas</div>

    <div class="flex justify-between items-center">
      <button id="purchase-btn" class="bg-teal-800 text-white px-4 py-2 rounded opacity-50 cursor-not-allowed" disabled>BELI</button>
    </div>

    <button id="closePopup" class="absolute top-2 right-2 text-gray-500 hover:text-black">
      <i class="fas fa-times"></i>
    </button>
  </div>
</div>

<style>
  .animate-scale-in {
    animation: scaleIn 0.25s ease-out;
  }
  @keyframes scaleIn {
    from { transform: scale(0.9); opacity: 0; }
    to { transform: scale(1); opacity: 1; }
  }

  .token-option.selected {
    background-color: #0d9488 !important;
    box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.4);
  }
</style>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const options = document.querySelectorAll('.token-option');
    const info = document.getElementById('selected-token-info');
    const beliBtn = document.getElementById('purchase-btn');

    let selected = null;

    options.forEach(option => {
      option.addEventListener('click', () => {
        options.forEach(opt => opt.classList.remove('selected'));
        option.classList.add('selected');
        selected = {
          jumlah: option.getAttribute('data-jumlah'),
          harga: option.getAttribute('data-harga'),
        };
        info.textContent = `Kamu memilih: ${selected.jumlah} (${selected.harga})`;
        beliBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        beliBtn.disabled = false;
      });
    });

    document.getElementById('closePopup').addEventListener('click', () => {
      document.getElementById('popup').classList.add('hidden');
    });

    beliBtn.addEventListener('click', () => {
      if (selected) {
        alert(`Pembelian berhasil:\n${selected.jumlah} seharga ${selected.harga}`);
        document.getElementById('popup').classList.add('hidden');
      }
    });
  });
</script>
