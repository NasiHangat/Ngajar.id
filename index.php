<?php
include 'includes/DBkoneksi.php';

// Ambil jumlah pengguna berdasarkan role
$sql_pengajar = "SELECT COUNT(*) as total FROM users WHERE role = 'pengajar'";
$sql_murid    = "SELECT COUNT(*) as total FROM users WHERE role = 'murid'";

$jumlah_pengajar = 0;
$jumlah_murid    = 0;

if ($result = $conn->query($sql_pengajar)) {
    $row = $result->fetch_assoc();
    $jumlah_pengajar = $row['total'];
}
if ($result = $conn->query($sql_murid)) {
    $row = $result->fetch_assoc();
    $jumlah_murid = $row['total'];
}
?>


<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Ngajar.ID</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100;300;400;500;600;700;900&display=swap" rel="stylesheet">
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

<body class="bg-white text-gray-800 font-roboto">

  <header>
    <?php include 'includes/Header.php'; ?>
  </header>

  <section class="max-w-6xl mx-auto px-4 py-12 flex flex-col md:flex-row items-center gap-10 pt-20 mb-10">
    <div class="md:w-1/2">
      <h1 class="text-xl text-justify font-bold mb-6">
        Ngajar.id - Belajar dan Mengajar Tanpa Batas
      </h1>
      <p class="text-xl text-justify mb-6 pr-20">
        Bersama, kita bangun akses pendidikan yang setara
        dan inklusif bagi seluruh pelajar Indonesia.
      </p>
      <a href="Register.php" class="px-6 py-2 bg-teal-500 text-white rounded hover:bg-teal-600 text-sm font-medium inline-block mt-6">
        Daftar Sekarang
      </a>

    </div>
    <div class="md:w-1/2 flex justify-center md:justify-end pr-6">
      <img src="img/Asset 1.png" class="w-[370px] max-w-full h-auto" />
    </div>
  </section>


  <section class="max-w-6xl mx-auto px-4 py-12 text-center">
    <h2 class="text-lg font-semibold mb-8">
      <span class="text-teal-600">Ngajar.id</span> untuk Siapa? Ini Jawabannya
    </h2>
    <div class="flex flex-col md:flex-row justify-center gap-8">
      <div class="border p-6 rounded shadow-md w-full md:w-1/3">
        <img src="img/Group 67.png" class="mx-auto mb-4" />
        <h3 class="font-bold text-lg mb-2">Pengajar</h3>
        <p class="text-sm text-gray-700">
          Berkontribusi dari rumah, ajar pelajar yang membutuhkan, dan bangun portofolio sosialmu.
        </p>
      </div>
      <div class="border p-6 rounded shadow-md w-full md:w-1/3">
        <img src="img/Asset 1 1.png" class="mx-auto mt-5 mb-10" />
        <h3 class="font-bold text-lg mb-2">Murid</h3>
        <p class="text-sm text-gray-700">
          Akses materi belajar gratis, bimbingan online, dan kelas interaktif dari relawan ahli.
        </p>
      </div>
    </div>
  </section>

  <section class="bg-gray-100 py-10">
    <div class="max-w-6xl mx-auto flex flex-col md:flex-row justify-around items-center gap-8">

      <!-- Murid Terdaftar -->
      <div class="flex items-center gap-6">
        <img src="img/ic-student 1.png" class="w-16 h-16" />
        <div class="text-left">
          <p class="text-base">Murid Terdaftar</p>
          <h3 class="text-2xl font-bold"><?php echo number_format($jumlah_murid); ?></h3>
        </div>
      </div>

      <!-- Pengajar Terdaftar -->
      <div class="flex items-center gap-6">
        <img src="img/ic-parent 1.png" class="w-16 h-16" />
        <div class="text-left">
          <p class="text-base">Pengajar Terdaftar</p>
          <h3 class="text-2xl font-bold"><?php echo number_format($jumlah_pengajar); ?></h3>
        </div>
      </div>

    </div>
  </section>



  <section class="max-w-6xl mx-auto px-4 py-12">
    <h2 class="text-center text-lg font-semibold mb-8">Kata Mereka Tentang <span class="text-teal-600">Ngajar.ID</span></h2>
    <div class="grid md:grid-cols-3 gap-6">
      <div class="bg-teal-500 text-white p-4 rounded shadow">
        <p class="text-sm">"Berkat Ngajar.ID saya bisa belajar tanpa biaya dan mendapatkan bimbingan belajar yang menyenangkan!"</p>
        <p class="text-xs mt-4 font-semibold">Murid - Bandung, Aulika</p>
      </div>
      <div class="bg-teal-500 text-white p-4 rounded shadow">
        <p class="text-sm">"Di Ngajar.ID Memungkinkan Saya berbagi ilmu sekaligus menambah pengalaman mengajar berharga."</p>
        <p class="text-xs mt-4 font-semibold">Pengajar - Laras</p>
      </div>
      <div class="bg-teal-500 text-white p-4 rounded shadow">
        <p class="text-sm">"Ngajar.ID Memungkinkan Saya berbagi ilmu sekaligus menambah pengalaman mengajar berharga."</p>
        <p class="text-xs mt-4 font-semibold">Pengajar - Laras</p>
      </div>
    </div>
  </section>

  <section class="text-center py-12">
    <h2 class="text-lg font-semibold mb-2">TUNGGU APA LAGI</h2>
    <p class="text-sm mb-6">Belajar dan Mengajar Di Ngajar.ID</p>
    <a href="#" class="bg-teal-500 text-white px-6 py-2 rounded hover:bg-teal-600 text-sm font-medium">
      Gabung Sekarang
    </a>
  </section>

  <footer>
    <?php include 'includes/Footer.php'; ?>
  </footer>

</body>

</html>