<!-- Modal Topup -->
<div id="popup" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center hidden z-50 transition-opacity duration-300">
  <div class="bg-white p-6 rounded-2xl shadow-2xl w-[90%] max-w-md border border-emerald-600 relative animate-scale-in">
    
    <!-- Header -->
    <h2 class="text-emerald-700 font-extrabold text-2xl mb-6 text-center">Beli Token</h2>

    <!-- Token Options -->
    <div class="grid grid-cols-3 gap-3 mb-5" id="token-options">
      <?php
      $tokens = [
        ['jumlah' => 5, 'harga' => 1500],
        ['jumlah' => 10, 'harga' => 3000],
        ['jumlah' => 20, 'harga' => 5000],
        ['jumlah' => 50, 'harga' => 10000],
        ['jumlah' => 100, 'harga' => 20000],
        ['jumlah' => 200, 'harga' => 35000],
        ['jumlah' => 500, 'harga' => 75000],
        ['jumlah' => 1000, 'harga' => 150000],
        ['jumlah' => 2000, 'harga' => 300000],
      ];
      foreach ($tokens as $index => $token) {
        $hargaFormatted = 'Rp ' . number_format($token['harga'], 0, ',', '.');
        echo "<div class='token-option bg-emerald-500 hover:bg-emerald-600 text-white p-3 rounded-xl text-center cursor-pointer transition duration-150 ease-in-out shadow-md hover:shadow-lg' data-index='{$index}' data-jumlah='{$token['jumlah']}' data-harga='{$token['harga']}'>";
        echo "<p class='font-semibold text-lg'>{$token['jumlah']} Token</p>";
        echo "<p class='text-sm mt-1'>{$hargaFormatted}</p>";
        echo "</div>";
      }
      ?>
    </div>

    <!-- Info -->
    <div class="text-center text-sm text-gray-600 mb-4 font-medium" id="selected-token-info">Pilih paket token yang kamu inginkan</div>

    <!-- Tombol -->
    <div class="flex justify-center">
      <button id="purchase-btn" class="bg-emerald-700 hover:bg-emerald-800 text-white px-6 py-2 rounded-full font-semibold opacity-50 cursor-not-allowed transition duration-200 ease-in-out" disabled>
        BELI
      </button>
    </div>

    <!-- Tombol Close -->
    <button id="closePopup" class="absolute top-3 right-3 text-gray-400 hover:text-black transition">
      <i class="fas fa-times text-lg"></i>
    </button>
  </div>
</div>

<!-- Animasi & Style -->
<style>
  .animate-scale-in {
    animation: scaleIn 0.25s ease-out;
  }

  @keyframes scaleIn {
    from {
      transform: scale(0.95);
      opacity: 0;
    }
    to {
      transform: scale(1);
      opacity: 1;
    }
  }

  .token-option.selected {
    background-color: #0d9488 !important;
    box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.3);
    transform: scale(1.05);
  }
</style>

<!-- Script -->
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
        info.textContent = `Kamu memilih: ${selected.jumlah} token seharga Rp ${selected.harga}`;
        beliBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        beliBtn.disabled = false;
      });
    });

    document.getElementById('closePopup').addEventListener('click', () => {
      document.getElementById('popup').classList.add('hidden');
    });

    beliBtn.addEventListener('click', () => {
      if (selected) {
        fetch('../Includes/proses_topup.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: `jumlah=${selected.jumlah}&harga=${selected.harga}`
        })

        .then(response => response.json())
        .then(data => {
          if (data.status === 'success') {
            alert(`Pembelian berhasil:\n${selected.jumlah} token seharga Rp ${selected.harga}`);
            document.getElementById('popup').classList.add('hidden');
            location.reload();
          } else {
            alert(`Gagal topup: ${data.message}`);
          }
        })
        .catch(error => {
          alert('Terjadi kesalahan jaringan.');
        });

      }
    });
  });
</script>
