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
  <div class="max-w-6xl mx-auto px-4 py-10">
    <h2 class="text-3xl font-bold text-center mb-10">Meet the Team</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
      <div class="text-center">
        <img src="img/azis.jpg" class="rounded-md mx-auto mb-4 w-48 h-auto">
        <h3 class="font-semibold text-lg">Muhammad Abdul Azis</h3>
        <p class="text-sm text-gray-500">2308937</p>
        </div>
      <div class="text-center">
        <img src="img/Maman.jpg" class="rounded-md mx-auto mb-4 w-48 h-auto">
        <h3 class="font-semibold text-lg">Muhammad Naufal Fadhlurrahman</h3>
        <p class="text-sm text-gray-500">2310837</p>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
      <div class="text-center">
        <img src="imG/ihsan.jpg" class="rounded-md mx-auto mb-4 w-48 h-auto">
        <h3 class="font-semibold text-lg">Ihsan Abdurrahman Bi Amrillah</h3>
        <p class="text-sm text-gray-500">2301308</p>
        </div>
      <div class="text-center">
        <img src="img/Syahdan.jpg" class="rounded-md mx-auto mb-4 w-48 h-auto">
        <h3 class="font-semibold text-lg"> Syahdan Alfiansyah</h3>
        <p class="text-sm text-gray-500">2305929</p>
        </div>
      <div class="text-center">
        <img src="img/Pujma.jpg" class="rounded-md mx-auto mb-4 w-48 h-auto">
        <h3 class="font-semibold text-lg">Pujma Rizqy Fadetra</h3>
        <p class="text-sm text-gray-500">2301130</p>
        </div>
    </div>
  </div>

  <section class="text-center py-12">
    <h2 class="text-2xl md:text-3xl font-bold text-teal-600 mb-10">Tentang Ngajar.Id</h2>
    <p class="max-w-4xl mx-auto text-sm md:text-base text-gray-700">
      Ngajar.id adalah platform edukasi berbasis relawan yang menghubungkan pelajar dengan pengajar sukarelawan secara gratis.
      Relawan bisa berbagi ilmu lewat course, modul, dan kelas online, demi akses pendidikan yang setara dan inklusif.
    </p>
  </section>

  <section class="py-12 flex justify-center px-4">
    <img src="img/Group 170.png" alt="Monitor dan Laptop" class="w-full max-w-6xl" />
  </section>

  <section class="text-center py-4">
    <h3 class="text-xl md:text-2xl font-bold text-teal-600 mb-4">Visi Kami</h3>
    <p class="max-w-4xl mx-auto text-gray-700">
      Mewujudkan akses pendidikan yang inklusif, berkualitas, dan dapat dijangkau oleh semua pelajar Indonesia melalui kolaborasi relawan dan teknologi.
    </p>
  </section>

  <section class="text-center py-8">
    <h3 class="text-xl md:text-2xl font-bold text-teal-600 mb-4">Misi Kami</h3>
    <p class="max-w-4xl mx-auto text-gray-700 mb-auto">
      Menghubungkan pelajar dengan relawan pengajar, menyediakan materi belajar gratis dan premium, serta mendorong donasi transparan untuk mendukung pendidikan yang merata.
    </p>
  </section>


  <footer>
    <?php include 'includes/Footer.php'; ?>
  </footer>

</body>

</html>
