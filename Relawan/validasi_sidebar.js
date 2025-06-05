const HamburgerButton = document.getElementById('hamburgerButton'); // Tombol di header utama
const sidebar = document.getElementById('sidebar'); // Dari navbar.php
const sidebarOverlay = document.getElementById('sidebarOverlay'); // Dari navbar.php

function toggleSidebar() {
    if (sidebar && sidebarOverlay) {
        sidebar.classList.toggle('-translate-x-full');
        sidebar.classList.toggle('translate-x-0');
        sidebarOverlay.classList.toggle('hidden');
    }
}

// Event listener tombol hamburger
if (HamburgerButton) {
    HamburgerButton.addEventListener('click', (event) => {
        event.stopPropagation();
        toggleSidebar();
    });
}

// Event listener overlay
if (sidebarOverlay) {
    sidebarOverlay.addEventListener('click', () => {
        toggleSidebar();
    });
}

// ✅ Event listener untuk klik di luar sidebar (diperbaiki)
if (sidebar && HamburgerButton) {
    document.addEventListener('click', (event) => {
        const isSidebarVisible = sidebar.classList.contains('translate-x-0');
        if (isSidebarVisible) {
            const isClickInsideSidebar = sidebar.contains(event.target);
            const isClickOnHamburger = HamburgerButton.contains(event.target);

            if (!isClickInsideSidebar && !isClickOnHamburger) {
                toggleSidebar();
            }
        }
    });
}

// Event listener untuk tutup sidebar saat klik link
if (sidebar) {
    const navLinks = sidebar.querySelectorAll('a');
    navLinks.forEach(link => {
        link.addEventListener('click', () => {
            if (sidebar.classList.contains('translate-x-0')) {
                toggleSidebar();
            }
        });
    });
}
