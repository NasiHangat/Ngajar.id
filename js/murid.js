// Perbaikan MuridDashboard Class
class MuridDashboard {
    constructor() {
        this.init();
        this.bindEvents();
        this.loadUserToken();
        this.loadRecentModules();
        this.loadPremiumModules();
    }

    init() {
        this.initSidebar();
        this.initNotifications();
        this.initTooltips();
        this.initAnimations();
    }

    bindEvents() {
        const hamburgerBtn = document.getElementById('hamburgerButton');
        if (hamburgerBtn) hamburgerBtn.addEventListener('click', this.toggleSidebar.bind(this));

        const topupBtn = document.querySelector('.bg-white.bg-opacity-20');
        if (topupBtn) topupBtn.addEventListener('click', this.showTopupModal.bind(this));

        this.initSubjectCards();
        this.initModuleCards();
        this.initTabSwitching();
        this.initSearch();
        this.initRefreshButton();
    }

    initSidebar() {
        const sidebar = document.getElementById('sidebar');
        if (sidebar) sidebar.style.transition = 'transform 0.3s ease-in-out';
    }

    toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        if (sidebar) sidebar.classList.toggle('active');
        this.toggleOverlay();
    }

    toggleOverlay() {
        let overlay = document.getElementById('sidebar-overlay');
        if (!overlay) {
            overlay = document.createElement('div');
            overlay.id = 'sidebar-overlay';
            overlay.className = 'fixed inset-0 bg-black bg-opacity-50 z-20 lg:hidden';
            overlay.addEventListener('click', this.toggleSidebar.bind(this));
            document.body.appendChild(overlay);
        }
        overlay.classList.toggle('hidden');
    }

    initNotifications() {
        const notificationBtn = document.querySelector('.fa-bell')?.parentElement;
        if (notificationBtn) notificationBtn.addEventListener('click', this.showNotifications.bind(this));
    }

    showNotifications() {
        this.showToast('Tidak ada notifikasi baru', 'info');
    }

    initTooltips() {
        const tooltips = [
            { selector: '.fa-bell', text: 'Notifikasi' },
            { selector: '.fa-user-circle', text: 'Profil' },
            { selector: '.fa-plus', text: 'Top Up Token' }
        ];
        tooltips.forEach(tooltip => {
            const element = document.querySelector(tooltip.selector);
            if (element) element.parentElement.title = tooltip.text;
        });
    }

    initAnimations() {
        const cards = document.querySelectorAll('[class*=border-\\[\\#003F4A\\]]');
        cards.forEach((card, i) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            setTimeout(() => {
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, i * 100);
        });
    }

    initSubjectCards() {
        const cards = document.querySelectorAll('.grid-cols-2.md\\:grid-cols-4 a');
        cards.forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.transform = 'translateY(-5px) scale(1.02)';
                card.style.transition = 'transform 0.3s ease';
                card.style.boxShadow = '0 8px 25px rgba(0,0,0,0.15)';
            });
            card.addEventListener('mouseleave', () => {
                card.style.transform = 'translateY(0) scale(1)';
                card.style.boxShadow = '';
            });
            card.addEventListener('click', () => {
                const subject = card.querySelector('p')?.textContent;
                this.trackSubjectClick(subject);
            });
        });
    }

    initModuleCards() {
        const cards = document.querySelectorAll('section .flex.items-start.space-x-4');
        cards.forEach(card => {
            card.style.cursor = 'pointer';
            card.addEventListener('click', () => {
                const title = card.querySelector('p')?.textContent;
                this.handleModuleClick(title);
            });
            card.addEventListener('mouseenter', () => {
                card.style.backgroundColor = 'rgba(20,184,166,0.1)';
                card.style.borderRadius = '8px';
                card.style.transition = 'background-color 0.3s ease';
            });
            card.addEventListener('mouseleave', () => {
                card.style.backgroundColor = '';
            });
        });
    }

    initTabSwitching() {
        const tabs = document.querySelectorAll('.flex.space-x-3 a');
        tabs.forEach(tab => {
            tab.addEventListener('click', e => {
                e.preventDefault();
                tabs.forEach(t => t.classList.replace('bg-teal-500', 'bg-white'));
                tabs.forEach(t => t.classList.replace('text-white', 'text-teal-500'));
                tab.classList.replace('bg-white', 'bg-teal-500');
                tab.classList.replace('text-teal-500', 'text-white');
                this.loadTabContent(tab.textContent.trim());
            });
        });
    }

    initSearch() {
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('input', this.handleSearch.bind(this));
        }
    }

    initRefreshButton() {
        const header = document.querySelector('header .flex.items-center.space-x-2');
        if (header) {
            const btn = document.createElement('button');
            btn.innerHTML = '<i class="fas fa-sync-alt text-xl"></i>';
            btn.className = 'text-teal-500 hover:text-teal-600 p-2 rounded-full transition-colors';
            btn.title = 'Refresh Data';
            btn.addEventListener('click', this.refreshData.bind(this));
            header.insertBefore(btn, header.firstChild);
        }
    }

    // ... lanjutkan fungsi lainnya secara serupa dan pastikan tidak ada kesalahan sintaksis atau pemanggilan fungsi.
}

document.addEventListener('DOMContentLoaded', () => new MuridDashboard());
