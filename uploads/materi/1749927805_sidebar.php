<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$role = $_SESSION['role'] ?? '';

$menus = [
    'pengajar' => [
        ['label' => 'Dashboard', 'icon' => 'fa-home', 'url' => '../pengajar/pengajar_dashboard.php'],
        ['label' => 'Kelas Saya', 'icon' => 'fa-book-open', 'url' => '../pengajar/pengajar_class.php'],
        ['label' => 'Modul', 'icon' => 'fa-book', 'url' => '../pengajar/pengajar_modul.php'],
        ['label' => 'Donasi', 'icon' => 'fa-donate', 'url' => 'form_donasi.php'],
    ],
    'murid' => [
        ['label' => 'Dashboard', 'icon' => 'fa-home', 'url' => '../murid/murid_dashboard.php'],
        ['label' => 'Kelas Saya', 'icon' => 'fa-book-open', 'url' => '../murid/murid_class.php'],
        ['label' => 'Modul', 'icon' => 'fa-book', 'url' => '../murid/murid_modul.php'],
        ['label' => 'Donasi', 'icon' => 'fa-donate', 'url' => 'form_donasi.php'],
    ],
    'admin' => [
        ['label' => 'Dashboard', 'icon' => 'fa-home', 'url' => '../admin/admin_dashboard.php'],
        ['label' => 'Modul', 'icon' => 'fa-chalkboard-teacher', 'url' => '../admin/admin_modul.php'],
        ['label' => 'Donasi', 'icon' => 'fa-donate', 'url' => '../admin/admin_donasi.php'],
        
    ]
];

$menuItems = $menus[$role] ?? [];
?>
<style>
    body {
    font-family: 'Roboto Slab', serif;
    }
</style>
<aside id="sidebar" class="fixed top-0 left-0 w-64 h-screen bg-teal-600 text-white flex flex-col z-50 transform -translate-x-full transition-transform duration-300 ease-in-out">
    <div class="flex items-center justify-center px-6 py-6 border-b border-white/20">
        <h1 class="text-2xl font-bold font-robotoSlab text-center">Ngajar.Id</h1>
    </div>

    <nav class="mt-6 flex-1 space-y-4 px-6">
        <?php foreach ($menuItems as $menu): ?>
            <a href="<?= $menu['url'] ?>" class="flex items-center space-x-4 hover:text-white/80">
                <i class="fas <?= $menu['icon'] ?> text-lg w-5"></i>
                <span class="text-base"><?= $menu['label'] ?></span>
            </a>
        <?php endforeach; ?>
    </nav>

    <div class="px-6 py-4 mt-auto border-t border-white/20">
        <a href="../Includes/proses_logout.php" class="flex items-center space-x-4 text-white hover:text-white/80">
            <i class="fas fa-sign-out-alt text-lg"></i>
            <span class="text-base">Logout</span>
        </a>
    </div>
</aside>

<div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden"></div>
<script src="../js/validasi_sidebar.js"></script>
