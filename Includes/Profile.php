<<<<<<< Updated upstream
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
<html lang="id" x-data="{ open: false }" xmlns="http://www.w3.org/1999/xhtml">
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
</body>
=======
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
<html lang="id" x-data="{ open: false }" xmlns="http://www.w3.org/1999/xhtml">
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
</body>
>>>>>>> Stashed changes
</html>