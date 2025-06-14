<?php
$namaPengguna = $_SESSION['name'] ?? 'Pengguna';
$emailPengguna = $_SESSION['email'] ?? 'user@email.com';
$rolePengguna = ucfirst($_SESSION['role'] ?? 'guest'); // Menjadi "Admin", "Pengajar", atau "Murid"
?>
<!DOCTYPE html>
<<<<<<< Updated upstream
<html lang="id" x-data="{ open: false }">
=======
<html lang="id" x-data="{ open: false }" xmlns="http://www.w3.org/1999/xhtml">
<?php
if (!isset($conn)) {
    include __DIR__ . '/DBkoneksi.php';
}

$namaPengguna = '';
$emailPengguna = '';
$rolePengguna = $_SESSION['role'] ?? 'murid';

if (isset($_SESSION['user_id']) && $conn) {
    $stmt = $conn->prepare("SELECT name, email, role FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $stmt->bind_result($namaPengguna, $emailPengguna, $rolePengguna);
    $stmt->fetch();
    $stmt->close();
}
?>

>>>>>>> Stashed changes

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://cdn.tailwindcss.com"></script>
<<<<<<< Updated upstream
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
=======
<!--   <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script> -->
>>>>>>> Stashed changes
  <title>Popup Profil</title>
</head>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const toggleButton = document.getElementById("profileToggle");
    const popup = document.getElementById("profilePopup");

<<<<<<< Updated upstream
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

  <div class="relative" x-data="{ showProfile: false }">
    <!-- Tombol ikon user -->
    <button @click="showProfile = !showProfile" class="text-teal-600 hover:text-teal-700 p-2 rounded-full focus:outline-none">
      <i class="fas fa-user-circle text-3xl"></i>
    </button>

    <!-- Popup Profil -->
    <div
      x-show="showProfile"
      @click.outside="showProfile = false"
      x-transition
      class="absolute right-0 mt-2 w-72 bg-white text-black shadow-lg rounded-lg p-4 z-50">
      
      <div class="flex flex-col items-center text-center space-y-1">
        <div class="text-teal-600 font-bold text-lg"><?php echo htmlspecialchars($namaPengguna); ?></div>
        <div class="text-sm text-gray-500"><?php echo htmlspecialchars($emailPengguna); ?></div>
        <div class="text-xs px-3 py-0.5 bg-teal-100 text-teal-700 rounded-full mt-1 uppercase tracking-wide"><?php echo htmlspecialchars($rolePengguna); ?></div>
      </div>

      
    </div>
  </div>

=======
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
>>>>>>> Stashed changes
</body>
</html>
