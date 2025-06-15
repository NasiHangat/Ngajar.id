<?php include '../Includes/DBkoneksi.php';?>
<?php
$namaPengguna = 'Pengguna';
$emailPengguna = 'user@email.com';
$rolePengguna = 'Guest';

if (isset($_SESSION['user_id']) && $conn) {
    $stmt = $conn->prepare("SELECT name, email, role FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $stmt->bind_result($nama, $email, $role);
    if ($stmt->fetch()) {
        $namaPengguna = htmlspecialchars($nama);
        $emailPengguna = htmlspecialchars($email);
        $rolePengguna = ucfirst(htmlspecialchars($role));
    }
    $stmt->close();
} else {
    $namaPengguna = htmlspecialchars($_SESSION['name'] ?? $namaPengguna);
    $emailPengguna = htmlspecialchars($_SESSION['email'] ?? $emailPengguna);
    $rolePengguna = ucfirst(htmlspecialchars($_SESSION['role'] ?? $rolePengguna));
}
?>
<!DOCTYPE html>
<html lang>
<?php
$rolePengguna = $_SESSION['role'] ?? 'murid';
$emailPengguna = "";

if (isset($_SESSION['user_id'])) {
    $stmt = $conn->prepare("SELECT email FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $stmt->bind_result($emailPengguna);
    $stmt->fetch();
    $stmt->close();
}

?>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://cdn.tailwindcss.com"></script>
<!--   <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script> -->
  <title>Popup Profil</title>
</head>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const toggleButton = document.getElementById("profileToggle");
    const popup = document.getElementById("profilePopup");

    if (toggleButton && popup) {
        // Toggle buka-tutup popup saat tombol diklik
        toggleButton.addEventListener("click", function (e) {
            e.stopPropagation();
            popup.classList.toggle("hidden");
        });

        // Tutup popup jika klik di luar elemen popup
        document.addEventListener("click", function (e) {
            if (!popup.contains(e.target) && !toggleButton.contains(e.target)) {
                popup.classList.add("hidden");
            }
        });
    }
}); 
</script>
<body class="bg-gray-900 min-h-screen flex items-center justify-center">
<div class="relative">
    <!-- Tombol profil -->
    <button id="profileToggle" class="text-teal-500 hover:text-teal-500 p-2 rounded-full focus:outline-none">
        <i class="fas fa-user-circle text-xl"></i>
    </button>

    <!-- Popup profil -->
    <div id="profilePopup" class="absolute right-0 mt-2 w-72 bg-white text-black shadow-lg rounded-lg p-4 z-50 hidden">
        <div class="flex flex-col items-center text-center">
            <h2 class="text-lg font-bold"><?php echo $namaPengguna; ?></h2>
            <span class="text-xs font-semibold text-teal-600 bg-teal-100 px-2 py-1 rounded-full mt-1">
                <?php echo ucfirst($rolePengguna); ?>
            </span>
            <p class="text-sm text-gray-700"><?php echo htmlspecialchars($emailPengguna); ?></p></div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('token-modal');
    const bukaBtn = document.getElementById('buka-token');
    const tutupBtn = document.getElementById('tutup-modal');
    const tokenContent = document.getElementById('token-content');

    bukaBtn.addEventListener('click', () => {
        fetch('token.php')
            .then(response => response.text())
            .then(html => {
                tokenContent.innerHTML = html;
                modal.classList.remove('hidden');

                const options = tokenContent.querySelectorAll('.topup-option');
                const beliSection = tokenContent.querySelector('#beli-section');
                let selectedToken = null;

                options.forEach(option => {
                    option.addEventListener('click', () => {
                        options.forEach(o => o.classList.remove('border-4', 'border-green-500'));
                        option.classList.add('border-4', 'border-green-500');
                        selectedToken = {
                            tokens: option.dataset.tokens,
                            price: option.dataset.price
                        };
                        beliSection.classList.remove('hidden');
                    });
                });

                const beliBtn = tokenContent.querySelector('#beli-button');
                beliBtn.addEventListener('click', () => {
                    if (selectedToken) {
                        alert(`Lanjut ke proses pembayaran...\n${selectedToken.tokens} Token berhasil dibeli!`);
                        modal.classList.add('hidden');
                    }
                });
            });
    });

    tutupBtn.addEventListener('click', () => {
        modal.classList.add('hidden');
    });
});
</script>

</body>
</html>