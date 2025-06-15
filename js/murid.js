// Dashboard Murid JavaScript
class MuridDashboard {
    constructor() {
        this.init();
        this.bindEvents();
        this.loadUserToken();
        this.loadRecentModules();
        this.loadPremiumModules();
    }

    init() {
        // Initialize sidebar toggle
        this.initSidebar();
        
        // Initialize notifications
        this.initNotifications();
        
        // Initialize tooltips
        this.initTooltips();
        
        // Initialize animations
        this.initAnimations();
    }

    bindEvents() {
        // Hamburger menu toggle
        const hamburgerBtn = document.getElementById('hamburgerButton');
        if (hamburgerBtn) {
            hamburgerBtn.addEventListener('click', this.toggleSidebar.bind(this));
        }

        // Token top-up button
        const topupBtn = document.querySelector('.bg-white.bg-opacity-20');
        if (topupBtn) {
            topupBtn.addEventListener('click', this.showTopupModal.bind(this));
        }

        // Subject cards hover effects
        this.initSubjectCards();

        // Module cards click events
        this.initModuleCards();

        // Tab switching
        this.initTabSwitching();

        // Search functionality
        this.initSearch();

        // Refresh button
        this.initRefreshButton();
    }

    initSidebar() {
        const sidebar = document.getElementById('sidebar');
        if (sidebar) {
            // Add smooth transition
            sidebar.style.transition = 'transform 0.3s ease-in-out';
        }
    }

    toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        if (sidebar) {
            sidebar.classList.toggle('active');
            
            // Add overlay when sidebar is open on mobile
            this.toggleOverlay();
        }
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
        const notificationBtn = document.querySelector('.fa-bell').parentElement;
        if (notificationBtn) {
            notificationBtn.addEventListener('click', this.showNotifications.bind(this));
        }
    }

    showNotifications() {
        // Create and show notification dropdown
        this.showToast('Tidak ada notifikasi baru', 'info');
    }

    initTooltips() {
        // Add tooltips to buttons
        const tooltips = [
            { selector: '.fa-bell', text: 'Notifikasi' },
            { selector: '.fa-user-circle', text: 'Profil' },
            { selector: '.fa-plus', text: 'Top Up Token' }
        ];

        tooltips.forEach(tooltip => {
            const element = document.querySelector(tooltip.selector);
            if (element) {
                element.parentElement.title = tooltip.text;
            }
        });
    }

    initAnimations() {
        // Fade in animation for cards
        const cards = document.querySelectorAll('.border-\\[\\#003F4A\\]');
        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            
            setTimeout(() => {
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 100);
        });
    }

    initSubjectCards() {
        const subjectCards = document.querySelectorAll('.grid-cols-2.md\\:grid-cols-4 a');
        
        subjectCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px) scale(1.02)';
                this.style.transition = 'transform 0.3s ease';
                this.style.boxShadow = '0 8px 25px rgba(0, 0, 0, 0.15)';
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
                this.style.boxShadow = '';
            });

            card.addEventListener('click', (e) => {
                const subject = card.querySelector('p').textContent;
                this.trackSubjectClick(subject);
            });
        });
    }

    initModuleCards() {
        const moduleCards = document.querySelectorAll('section .flex.items-start.space-x-4');
        
        moduleCards.forEach(card => {
            card.style.cursor = 'pointer';
            card.addEventListener('click', function() {
                const moduleTitle = this.querySelector('p').textContent;
                this.handleModuleClick(moduleTitle);
            }.bind(this));

            // Add hover effect
            card.addEventListener('mouseenter', function() {
                this.style.backgroundColor = 'rgba(20, 184, 166, 0.1)';
                this.style.borderRadius = '8px';
                this.style.transition = 'background-color 0.3s ease';
            });

            card.addEventListener('mouseleave', function() {
                this.style.backgroundColor = '';
            });
        });
    }

    initTabSwitching() {
        const tabs = document.querySelectorAll('.flex.space-x-3 a');
        
        tabs.forEach(tab => {
            tab.addEventListener('click', (e) => {
                e.preventDefault();
                
                // Remove active class from all tabs
                tabs.forEach(t => {
                    t.classList.remove('bg-teal-500', 'text-white');
                    t.classList.add('bg-white', 'text-teal-500');
                });
                
                // Add active class to clicked tab
                tab.classList.remove('bg-white', 'text-teal-500');
                tab.classList.add('bg-teal-500', 'text-white');
                
                // Load content based on tab
                const tabName = tab.textContent.trim();
                this.loadTabContent(tabName);
            });
        });
    }

    z

    initRefreshButton() {
        // Add refresh button to header
        const headerButtons = document.querySelector('header .flex.items-center.space-x-2');
        if (headerButtons) {
            const refreshBtn = document.createElement('button');
            refreshBtn.innerHTML = '<i class="fas fa-sync-alt text-xl"></i>';
            refreshBtn.className = 'text-teal-500 hover:text-teal-600 p-2 rounded-full transition-colors';
            refreshBtn.title = 'Refresh Data';
            refreshBtn.addEventListener('click', this.refreshData.bind(this));
            
            headerButtons.insertBefore(refreshBtn, headerButtons.firstChild);
        }
    }

    async loadUserToken() {
        try {
            const response = await fetch('../api/get_user_token.php');
            const data = await response.json();
            
            if (data.success) {
                this.updateTokenDisplay(data.token);
            }
        } catch (error) {
            console.error('Error loading user token:', error);
        }
    }

    updateTokenDisplay(tokenAmount) {
        const tokenDisplay = document.querySelector('.bg-white.text-teal-500.text-xs.font-semibold');
        if (tokenDisplay) {
            tokenDisplay.innerHTML = `<img src="../img/coin.png" class="mr-1.5 w-4"> ${tokenAmount}`;
        }
    }

    async loadRecentModules() {
        try {
            const response = await fetch('../api/get_recent_modules.php');
            const data = await response.json();
            
            if (data.success && data.modules) {
                this.updateRecentModulesDisplay(data.modules);
            }
        } catch (error) {
            console.error('Error loading recent modules:', error);
        }
    }

    updateRecentModulesDisplay(modules) {
        const container = document.querySelector('section:last-child .space-y-3');
        if (container && modules.length > 0) {
            container.innerHTML = '';
            
            modules.forEach(module => {
                const moduleHTML = `
                    <a href="module_detail.php?id=${module.modul_id}" 
                        class="flex items-center space-x-4 p-3 rounded-lg hover:bg-gray-100 transition-colors module-item" 
                        data-module-id="${module.modul_id}">
                        <div class="flex-shrink-0 w-12 h-16 rounded-lg bg-teal-500 text-white flex items-center justify-center border-l-4 border-[#003F4A]">
                            <i class="fa-solid fa-book text-2xl"></i>
                        </div>
                        <div class="flex-grow">
                            <h5 class="text-m font-bold text-teal-500">${module.judul}</h5>
                            <p class="text-xs text-teal-500">${module.deskripsi || 'Deskripsi tidak tersedia'}</p>
                        </div>
                        <div class="text-right">
                            <span class="text-xs font-bold text-teal-500">${module.tipe}</span>
                            ${module.token_harga ? `
                                <div class="flex items-center justify-end mt-1">
                                    <img src="../img/coin.png" class="mr-1 w-3"> ${module.token_harga}
                                </div>
                            ` : ''}
                        </div>
                    </a>
                `;
                container.insertAdjacentHTML('beforeend', moduleHTML);
            });
        }
    }

    async loadPremiumModules() {
        try {
            const response = await fetch('../api/get_premium_modules.php');
            const data = await response.json();
            
            if (data.success && data.modules) {
                this.updatePremiumModulesDisplay(data.modules);
            }
        } catch (error) {
            console.error('Error loading premium modules:', error);
        }
    }

    updatePremiumModulesDisplay(modules) {
        const container = document.querySelector('.grid.grid-cols-1.sm\\:grid-cols-2.gap-5');
        if (container && modules.length > 0) {
            container.innerHTML = '';
            
            modules.forEach(module => {
                const moduleHTML = `
                    <div class="flex items-start space-x-4 premium-module" data-module-id="${module.modul_id}">
                        <div class="bg-teal-500 text-white font-bold p-4 py-10 border-l-8 border-[#003F4A] rounded-lg shadow-md cursor-pointer hover:bg-teal-600 transition-colors">
                            ${module.judul.substring(0, 6).toUpperCase()}
                        </div>
                        <div>
                            <p class="text-teal-500 font-bold">${module.judul}</p>
                            <div class="flex items-center text-sm mt-1">
                                <img src="../img/coin.png" class="mr-1.5 w-4"> ${module.token_harga || 0}
                            </div>
                        </div>
                    </div>
                `;
                container.insertAdjacentHTML('beforeend', moduleHTML);
            });

            // Add click events to premium modules
            this.initPremiumModuleClicks();
        }
    }

    initPremiumModuleClicks() {
        const premiumModules = document.querySelectorAll('.premium-module');
        premiumModules.forEach(module => {
            module.addEventListener('click', () => {
                const moduleId = module.dataset.moduleId;
                this.handlePremiumModuleClick(moduleId);
            });
        });
    }

    handlePremiumModuleClick(moduleId) {
        // Check if user has enough tokens
        this.checkTokenAndPurchase(moduleId);
    }

    async checkTokenAndPurchase(moduleId) {
        try {
            const response = await fetch('../api/check_module_access.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ module_id: moduleId })
            });
            
            const data = await response.json();
            
            if (data.hasAccess) {
                window.location.href = `module_detail.php?id=${moduleId}`;
            } else if (data.hasEnoughTokens) {
                this.showPurchaseConfirmation(moduleId, data.modulePrice);
            } else {
                this.showInsufficientTokensModal();
            }
        } catch (error) {
            console.error('Error checking module access:', error);
        }
    }

    showPurchaseConfirmation(moduleId, price) {
        const modal = this.createModal(
            'Konfirmasi Pembelian',
            `Apakah Anda yakin ingin membeli modul ini dengan ${price} token?`,
            [
                {
                    text: 'Batal',
                    class: 'bg-gray-500 hover:bg-gray-600',
                    onClick: () => this.closeModal()
                },
                {
                    text: 'Beli',
                    class: 'bg-teal-500 hover:bg-teal-600',
                    onClick: () => this.purchaseModule(moduleId)
                }
            ]
        );
        
        document.body.appendChild(modal);
    }

    createModal(title, content, buttons = []) {
        const modal = document.createElement('div');
        modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
        modal.id = 'modal';
        
        const modalContent = `
            <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
                <h3 class="text-xl font-bold text-teal-500 mb-4">${title}</h3>
                <div class="mb-6">${content}</div>
                <div class="flex space-x-3 justify-end">
                    ${buttons.map(btn => `
                        <button class="${btn.class} text-white px-4 py-2 rounded-lg transition-colors">${btn.text}</button>
                    `).join('')}
                </div>
            </div>
        `;
        
        modal.innerHTML = modalContent;
        
        // Add event listeners to buttons
        const buttonElements = modal.querySelectorAll('button');
        buttonElements.forEach((btn, index) => {
            if (buttons[index] && buttons[index].onClick) {
                btn.addEventListener('click', buttons[index].onClick);
            }
        });
        
        return modal;
    }

    closeModal() {
        const modal = document.getElementById('modal');
        if (modal) {
            modal.remove();
        }
    }

    handleSearch(event) {
        const searchTerm = event.target.value.toLowerCase();
        const modules = document.querySelectorAll('.module-item, .premium-module');
        
        modules.forEach(module => {
            const title = module.querySelector('.text-teal-500.font-bold').textContent.toLowerCase();
            const description = module.querySelector('.text-xs.text-teal-500')?.textContent.toLowerCase() || '';
            
            if (title.includes(searchTerm) || description.includes(searchTerm)) {
                module.style.display = '';
            } else {
                module.style.display = 'none';
            }
        });
        
        // Also search subject cards
        const subjectCards = document.querySelectorAll('.grid-cols-2.md\\:grid-cols-4 a');
        subjectCards.forEach(card => {
            const subject = card.querySelector('p').textContent.toLowerCase();
            const cardContainer = card.parentElement;
            
            if (subject.includes(searchTerm)) {
                cardContainer.style.display = '';
            } else {
                cardContainer.style.display = searchTerm === '' ? '' : 'none';
            }
        });
    }

    loadTabContent(tabName) {
        // Simulate loading different content based on tab
        this.showToast(`Memuat konten ${tabName}...`, 'info');
        
        // In real implementation, this would make AJAX calls to load different content
        if (tabName === 'Modul') {
            this.loadRecentModules();
            this.loadPremiumModules();
        } else if (tabName === 'Kelas') {
            this.loadUserClasses();
        }
    }

    async loadUserClasses() {
        try {
            const response = await fetch('../Murid/murid_class.php');
            const data = await response.json();
            
            if (data.success) {
                // Update UI with user classes
                this.showToast('Kelas berhasil dimuat', 'success');
            }
        } catch (error) {
            console.error('Error loading user classes:', error);
        }
    }

    trackSubjectClick(subject) {
        // Track subject clicks for analytics
        console.log(`Subject clicked: ${subject}`);
        
        // Send to analytics endpoint
        fetch('../api/track_activity.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                action: 'subject_click',
                subject: subject,
                timestamp: new Date().toISOString()
            })
        }).catch(error => console.error('Error tracking activity:', error));
    }

    handleModuleClick(moduleTitle) {
        this.showToast(`Membuka modul: ${moduleTitle}`, 'info');
    }

    async refreshData() {
        const refreshBtn = document.querySelector('.fa-sync-alt');
        if (refreshBtn) {
            refreshBtn.classList.add('animate-spin');
        }
        
        try {
            await Promise.all([
                this.loadUserToken(),
                this.loadRecentModules(),
                this.loadPremiumModules()
            ]);
            
            this.showToast('Data berhasil diperbarui', 'success');
        } catch (error) {
            this.showToast('Gagal memperbarui data', 'error');
        } finally {
            if (refreshBtn) {
                refreshBtn.classList.remove('animate-spin');
            }
        }
    }

    showToast(message, type = 'info') {
        // Remove existing toast
        const existingToast = document.getElementById('toast');
        if (existingToast) {
            existingToast.remove();
        }
        
        const toast = document.createElement('div');
        toast.id = 'toast';
        toast.className = `fixed top-4 right-4 px-6 py-3 rounded-lg text-white z-50 transform transition-transform duration-300 ${
            type === 'success' ? 'bg-green-500' :
            type === 'error' ? 'bg-red-500' :
            type === 'warning' ? 'bg-yellow-500' :
            'bg-blue-500'
        }`;
        toast.textContent = message;
        toast.style.transform = 'translateX(100%)';
        
        document.body.appendChild(toast);
        
        // Animate in
        setTimeout(() => {
            toast.style.transform = 'translateX(0)';
        }, 100);
        
        // Auto remove after 3 seconds
        setTimeout(() => {
            toast.style.transform = 'translateX(100%)';
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.remove();
                }
            }, 300);
        }, 3000);
    }
}

class MuridModul {
     constructor() {
        this.activeTab = "soal"; // hanya satu tab global (soal, pdf, video)
    }


    toggleModul(button) {
        const allButtons = document.querySelectorAll(".toggle-modul");
        const allTabs = document.querySelectorAll(".tab-modul");

        allButtons.forEach(btn => {
            btn.classList.remove("bg-teal-500", "text-white");
            btn.classList.add("bg-white", "text-teal-500");
        });

        allTabs.forEach(tab => {
            tab.classList.add("hidden");
        });

        const target = button.getAttribute("data-target");
        const activeTab = document.getElementById("modul-" + target);
        if (activeTab) {
            activeTab.classList.remove("hidden");
        }

        button.classList.remove("bg-white", "text-teal-500");
        button.classList.add("bg-teal-500", "text-white");
    }

     togglePremium(button) {
        const allButtons = document.querySelectorAll(".toggle-tab");
        const allGroups = document.querySelectorAll(".sub-tab-group");

        allButtons.forEach(btn => {
            btn.classList.remove("bg-teal-500", "text-white");
            btn.classList.add("bg-white", "text-teal-500");
        });

        allGroups.forEach(group => group.classList.add("hidden"));

        const target = button.getAttribute("data-target");
        const tabGroup = document.getElementById(target);
        if (tabGroup) {
            tabGroup.classList.remove("hidden");
        }

        button.classList.remove("bg-white", "text-teal-500");
        button.classList.add("bg-teal-500", "text-white");

        // Tampilkan sub-tab yang sama di grup yang baru
        this.setActiveNgajarTab(target, this.activeTab);
    }

    toggleNgajar(button, tipe) {
        const allButtons = document.querySelectorAll(`#${tipe} .toggle-ngajar`);
        const allTabs = document.querySelectorAll(`#${tipe} .tab-ngajar`);

        allButtons.forEach(btn => {
            btn.classList.remove("bg-teal-500", "text-white");
            btn.classList.add("bg-white", "text-teal-500");
        });

        allTabs.forEach(tab => {
            tab.classList.add("hidden");
        });

        const target = button.getAttribute("data-target");
        const activeTab = document.getElementById(`ngajar-${tipe}-${target}`);
        if (activeTab) {
            activeTab.classList.remove("hidden");
        }

        button.classList.remove("bg-white", "text-teal-500");
        button.classList.add("bg-teal-500", "text-white");

        // Simpan tab aktif global (soal, pdf, video)
        this.activeTab = target;
    }

    setActiveNgajarTab(tipe, target) {
        const buttons = document.querySelectorAll(`#${tipe} .toggle-ngajar`);
        buttons.forEach(btn => {
            if (btn.getAttribute("data-target") === target) {
                this.toggleNgajar(btn, tipe);
            }
        });
    }



    
}

// ✅ Buat instance global
window.modul = new MuridModul();
document.addEventListener('DOMContentLoaded', function() {
    new MuridDashboard();
});

// Add CSS animations
const style = document.createElement('style');
style.textContent = `
    .animate-spin {
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    
    .module-item:hover {
        transform: translateX(5px);
        transition: transform 0.3s ease;
    }
    
    .premium-module:hover {
        transform: scale(1.02);
        transition: transform 0.3s ease;
    }
    
    .topup-option:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    
    @media (max-width: 1024px) {
        #sidebar.active {
            transform: translateX(0);
        }
        
        #sidebar {
            transform: translateX(-100%);
        }
    }
`;

document.head.appendChild(style);

// Animasi untuk Dashboard Kelas Ngajar.ID - VERSI PERBAIKAN
console.log('JavaScript animasi dimuat!'); // Debug log

document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM sudah siap, memulai animasi...'); // Debug log
    
    // Inject CSS animations first
    injectAnimationStyles();
    
    // 1. ANIMASI HAMBURGER MENU
    const hamburgerButton = document.getElementById('hamburgerButton');
    if (hamburgerButton) {
        console.log('Hamburger button ditemukan');
        hamburgerButton.addEventListener('click', function() {
            const icon = this.querySelector('i');
            if (icon) {
                icon.style.transform = icon.style.transform === 'rotate(90deg)' ? 'rotate(0deg)' : 'rotate(90deg)';
                icon.style.transition = 'transform 0.3s ease';
            }
        });
    }

    // 2. ANIMASI FADE IN UNTUK HEADER
    setTimeout(() => {
        const header = document.querySelector('header');
        if (header) {
            console.log('Header ditemukan, menjalankan animasi');
            header.style.opacity = '0';
            header.style.transform = 'translateY(-20px)';
            header.style.transition = 'all 0.8s ease';
            
            setTimeout(() => {
                header.style.opacity = '1';
                header.style.transform = 'translateY(0)';
            }, 100);
        }
    }, 100);

    // 3. ANIMASI PROFILE SECTION (background hijau)
    setTimeout(() => {
        const profileSection = document.querySelector('.bg-teal-500');
        if (profileSection) {
            console.log('Profile section ditemukan');
            profileSection.style.opacity = '0';
            profileSection.style.transform = 'translateY(30px)';
            profileSection.style.transition = 'all 1s ease';
            
            setTimeout(() => {
                profileSection.style.opacity = '1';
                profileSection.style.transform = 'translateY(0)';
            }, 200);
        }
    }, 300);

    // 4. ANIMASI UNTUK CARD KELAS - MENGGUNAKAN SELECTOR YANG LEBIH SPESIFIK
    setTimeout(() => {
        // Cari semua div yang memiliki onclick dengan detail_kelas.php
        const kelasCards = document.querySelectorAll('div[onclick*="detail_kelas.php"]');
        console.log(`Ditemukan ${kelasCards.length} card kelas`);
        
        kelasCards.forEach((card, index) => {
            // Set initial state
            card.style.opacity = '0';
            card.style.transform = 'translateY(50px) scale(0.8)';
            card.style.transition = 'all 0.8s cubic-bezier(0.4, 0, 0.2, 1)';
            
            // Staggered animation dengan delay
            setTimeout(() => {
                card.style.opacity = '1';
                card.style.transform = 'translateY(0) scale(1)';
            }, index * 150);

            // Hover effects
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-10px) scale(1.03)';
                this.style.boxShadow = '0 25px 50px rgba(0, 0, 0, 0.2)';
                this.style.transition = 'all 0.3s ease';
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
                this.style.boxShadow = '0 4px 8px rgba(0, 0, 0, 0.1)';
            });
        });
    }, 500);

    // 5. ANIMASI UNTUK COIN/TOKEN
    setTimeout(() => {
        const coinElements = document.querySelectorAll('img[src*="coin.png"]');
        coinElements.forEach(coin => {
            const coinContainer = coin.closest('.bg-white.text-teal-500');
            if (coinContainer) {
                console.log('Coin container ditemukan');
                coinContainer.addEventListener('mouseenter', function() {
                    coin.style.transform = 'rotate(360deg) scale(1.2)';
                    coin.style.transition = 'transform 0.5s ease';
                    this.style.transform = 'scale(1.05)';
                    this.style.transition = 'transform 0.3s ease';
                });
                
                coinContainer.addEventListener('mouseleave', function() {
                    coin.style.transform = 'rotate(0deg) scale(1)';
                    this.style.transform = 'scale(1)';
                });
            }
        });
    }, 800);

    // 6. ANIMASI UNTUK TOMBOL IKUTI
    setTimeout(() => {
        const ikutiButtons = document.querySelectorAll('button[name="ikuti"]');
        console.log(`Ditemukan ${ikutiButtons.length} tombol ikuti`);
        
        ikutiButtons.forEach(button => {
            // Hover effect
            button.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-3px) scale(1.05)';
                this.style.boxShadow = '0 8px 15px rgba(0, 0, 0, 0.3)';
                this.style.transition = 'all 0.2s ease';
            });

            button.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
                this.style.boxShadow = '0 2px 4px rgba(0, 0, 0, 0.1)';
            });

            // Click effect
            button.addEventListener('click', function(e) {
                // Animasi ripple effect
                const ripple = document.createElement('span');
                ripple.classList.add('ripple-effect');
                this.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 600);
                

            });
        });
    }, 1000);

    // 7. ANIMASI UNTUK SECTION TITLES
    setTimeout(() => {
        const sectionTitles = document.querySelectorAll('h3');
        console.log(`Ditemukan ${sectionTitles.length} section titles`);
        
        sectionTitles.forEach((title, index) => {
            if (title.textContent.includes('Rekomendasi') || title.textContent.includes('Diikuti')) {
                title.style.opacity = '0';
                title.style.transform = 'translateX(-50px)';
                title.style.transition = 'all 0.8s ease';
                
                setTimeout(() => {
                    title.style.opacity = '1';
                    title.style.transform = 'translateX(0)';
                }, index * 300);
            }
        });
    }, 1200);

    // 8. ANIMASI NOTIFICATION BELL
    const bellButton = document.querySelector('.fa-bell');
    if (bellButton) {
        bellButton.parentElement.addEventListener('click', function() {
            bellButton.classList.add('bell-ring');
            setTimeout(() => {
                bellButton.classList.remove('bell-ring');
            }, 1000);
        });
    }

    // 9. ANIMASI SAAT SCROLL
    let isScrolling = false;
    window.addEventListener('scroll', () => {
        if (!isScrolling) {
            window.requestAnimationFrame(() => {
                const scrolled = window.pageYOffset;
                const header = document.querySelector('header');
                if (header && scrolled > 50) {
                    header.style.backdropFilter = 'blur(10px)';
                    header.style.backgroundColor = 'rgba(255, 255, 255, 0.9)';
                } else if (header) {
                    header.style.backdropFilter = 'none';
                    header.style.backgroundColor = 'white';
                }
                isScrolling = false;
            });
            isScrolling = true;
        }
    });

    console.log('Semua animasi telah diinisialisasi!');
});

// Function untuk inject CSS styles
function injectAnimationStyles() {
    const style = document.createElement('style');
    style.id = 'kelas-animations-styles';
    style.textContent = `
        /* Keyframe animations */
        @keyframes bell-ring {
            0%, 100% { transform: rotate(0deg); }
            10%, 30%, 50%, 70%, 90% { transform: rotate(-10deg); }
            20%, 40%, 60%, 80% { transform: rotate(10deg); }
        }
        
        @keyframes ripple {
            0% {
                transform: scale(0);
                opacity: 1;
            }
            100% {
                transform: scale(4);
                opacity: 0;
            }
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translate3d(0, 40px, 0);
            }
            to {
                opacity: 1;
                transform: translate3d(0, 0, 0);
            }
        }
        
        @keyframes bounceIn {
            0%, 20%, 40%, 60%, 80%, 100% {
                transition-timing-function: cubic-bezier(0.215, 0.610, 0.355, 1.000);
            }
            0% {
                opacity: 0;
                transform: scale3d(.3, .3, .3);
            }
            20% {
                transform: scale3d(1.1, 1.1, 1.1);
            }
            40% {
                transform: scale3d(.9, .9, .9);
            }
            60% {
                opacity: 1;
                transform: scale3d(1.03, 1.03, 1.03);
            }
            80% {
                transform: scale3d(.97, .97, .97);
            }
            100% {
                opacity: 1;
                transform: scale3d(1, 1, 1);
            }
        }
        
        /* Utility classes */
        .bell-ring {
            animation: bell-ring 1s ease-in-out;
        }
        
        .ripple-effect {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.6);
            transform: scale(0);
            animation: ripple 0.6s linear;
            pointer-events: none;
            top: 50%;
            left: 50%;
            width: 20px;
            height: 20px;
            margin-left: -10px;
            margin-top: -10px;
        }
        
        .loading-spinner {
            border: 2px solid transparent;
            border-top: 2px solid currentColor;
            border-radius: 50%;
            width: 12px;
            height: 12px;
            animation: spin 1s linear infinite;
            display: inline-block;
            margin-right: 5px;
        }
        
        /* Smooth transitions */
        * {
            transition: transform 0.2s ease, box-shadow 0.2s ease, opacity 0.2s ease;
        }
        
        /* Hover effects enhancement */
        button:hover {
            cursor: pointer;
        }
        
        .cursor-pointer:hover {
            cursor: pointer;
        }
        
        /* Enhanced shadows */
        .shadow-lg {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease;
        }
        
        .shadow-lg:hover {
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }
    `;
    
    // Remove existing styles if any
    const existingStyle = document.getElementById('kelas-animations-styles');
    if (existingStyle) {
        existingStyle.remove();
    }
    
    document.head.appendChild(style);
    console.log('CSS animasi berhasil diinjeksi!');
}

// Enhanced Modul JavaScript with Smooth Animations
const modul = {
    // Initialize the module system
    init() {
        this.setupEventListeners();
        this.initializeDefaultTabs();
        this.addTransitionStyles();
    },

    // Add CSS transition styles dynamically
    addTransitionStyles() {
        const style = document.createElement('style');
        style.textContent = `
            .tab-modul, .tab-ngajar, .sub-tab-group {
                transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                transform-origin: top;
            }
            
            .tab-modul.hidden, .tab-ngajar.hidden, .sub-tab-group.hidden {
                opacity: 0;
                transform: translateY(-10px) scale(0.98);
                max-height: 0;
                overflow: hidden;
                padding: 0;
                margin: 0;
            }
            
            .tab-modul:not(.hidden), .tab-ngajar:not(.hidden), .sub-tab-group:not(.hidden) {
                opacity: 1;
                transform: translateY(0) scale(1);
                max-height: 1000px;
            }
            
            .toggle-modul, .toggle-tab, .toggle-ngajar {
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                transform: translateY(0);
            }
            
            .toggle-modul:hover, .toggle-tab:hover, .toggle-ngajar:hover {
                transform: translateY(-2px);
                box-shadow: 0px 6px 8px rgba(0, 61, 78, 0.3);
            }
            
            .toggle-modul:active, .toggle-tab:active, .toggle-ngajar:active {
                transform: translateY(0);
                transition: all 0.1s ease;
            }
            
            .fade-in {
                animation: fadeInUp 0.5s cubic-bezier(0.4, 0, 0.2, 1) forwards;
            }
            
            .fade-out {
                animation: fadeOutDown 0.3s cubic-bezier(0.4, 0, 0.2, 1) forwards;
            }
            
            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            
            @keyframes fadeOutDown {
                from {
                    opacity: 1;
                    transform: translateY(0);
                }
                to {
                    opacity: 0;
                    transform: translateY(-10px);
                }
            }
            
            .loading-shimmer {
                background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
                background-size: 200% 100%;
                animation: shimmer 1.5s infinite;
            }
            
            @keyframes shimmer {
                0% { background-position: -200% 0; }
                100% { background-position: 200% 0; }
            }
        `;
        document.head.appendChild(style);
    },

    // Setup event listeners
    setupEventListeners() {
        // Smooth scroll for page navigation
        document.addEventListener('DOMContentLoaded', () => {
            this.addScrollToTopOnLoad();
        });
    },

    // Initialize default tabs
    initializeDefaultTabs() {
        // Set default active states
        setTimeout(() => {
            const defaultModulButton = document.getElementById('btnSoal');
            const defaultPremiumButton = document.getElementById('btnGratis');
            
            if (defaultModulButton) {
                this.showModulContent('soal');
            }
            
            if (defaultPremiumButton) {
                this.showTabContent('Gratis');
                this.showNgajarContent('soal', 'Gratis');
            }
        }, 100);
    },

    // Enhanced toggle function for modul pembelajaran
    toggleModul(button) {
        const target = button.getAttribute('data-target');
        
        // Add loading state
        this.setLoadingState(button, true);
        
        setTimeout(() => {
            // Update button states with animation
            this.updateButtonStates('.toggle-modul', button);
            
            // Show content with animation
            this.showModulContent(target);
            
            // Remove loading state
            this.setLoadingState(button, false);
        }, 200);
    },

    // Enhanced toggle function for premium/gratis
    togglePremium(button) {
        const target = button.getAttribute('data-target');
        
        // Add loading state
        this.setLoadingState(button, true);
        
        setTimeout(() => {
            // Update button states
            this.updateButtonStates('.toggle-tab', button);
            
            // Show content with animation
            this.showTabContent(target);
            
            // Reset ngajar buttons to first option
            this.resetNgajarButtons(target);
            this.showNgajarContent('soal', target);
            
            // Remove loading state
            this.setLoadingState(button, false);
        }, 200);
    },

    // Enhanced toggle function for ngajar content
    toggleNgajar(button, parentTab) {
        const target = button.getAttribute('data-target');
        
        // Add loading state
        this.setLoadingState(button, true);
        
        setTimeout(() => {
            // Update button states within the parent tab
            const parentElement = document.getElementById(parentTab);
            if (parentElement) {
                const buttons = parentElement.querySelectorAll('.toggle-ngajar');
                this.updateButtonStatesInParent(buttons, button);
            }
            
            // Show content with animation
            this.showNgajarContent(target, parentTab);
            
            // Remove loading state
            this.setLoadingState(button, false);
        }, 200);
    },

    // Set loading state for buttons
    setLoadingState(button, isLoading) {
        if (isLoading) {
            button.classList.add('loading-shimmer');
            button.style.pointerEvents = 'none';
        } else {
            button.classList.remove('loading-shimmer');
            button.style.pointerEvents = 'auto';
        }
    },

    // Update button states with smooth transitions
    updateButtonStates(selector, activeButton) {
        const buttons = document.querySelectorAll(selector);
        buttons.forEach(btn => {
            btn.classList.remove('bg-teal-500', 'text-white');
            btn.classList.add('bg-white', 'text-teal-500');
        });
        
        // Add active state to clicked button
        activeButton.classList.remove('bg-white', 'text-teal-500');
        activeButton.classList.add('bg-teal-500', 'text-white');
    },

    // Update button states within a parent element
    updateButtonStatesInParent(buttons, activeButton) {
        buttons.forEach(btn => {
            btn.classList.remove('bg-teal-500', 'text-white');
            btn.classList.add('bg-white', 'text-teal-500');
        });
        
        activeButton.classList.remove('bg-white', 'text-teal-500');
        activeButton.classList.add('bg-teal-500', 'text-white');
    },

    // Show modul content with smooth animation
    showModulContent(target) {
        const contents = document.querySelectorAll('.tab-modul');
        const targetContent = document.getElementById(`modul-${target}`);
        
        // Hide all contents
        contents.forEach(content => {
            if (!content.classList.contains('hidden')) {
                content.classList.add('fade-out');
                setTimeout(() => {
                    content.classList.add('hidden');
                    content.classList.remove('fade-out');
                }, 300);
            }
        });
        
        // Show target content
        if (targetContent) {
            setTimeout(() => {
                targetContent.classList.remove('hidden');
                targetContent.classList.add('fade-in');
                setTimeout(() => {
                    targetContent.classList.remove('fade-in');
                }, 500);
            }, 300);
        }
    },

    // Show tab content with smooth animation
    showTabContent(target) {
        const contents = document.querySelectorAll('.sub-tab-group');
        const targetContent = document.getElementById(target);
        
        // Hide all contents
        contents.forEach(content => {
            if (!content.classList.contains('hidden')) {
                content.classList.add('fade-out');
                setTimeout(() => {
                    content.classList.add('hidden');
                    content.classList.remove('fade-out');
                }, 300);
            }
        });
        
        // Show target content
        if (targetContent) {
            setTimeout(() => {
                targetContent.classList.remove('hidden');
                targetContent.classList.add('fade-in');
                setTimeout(() => {
                    targetContent.classList.remove('fade-in');
                }, 500);
            }, 300);
        }
    },

    // Show ngajar content with smooth animation
    showNgajarContent(target, parentTab) {
        const contents = document.querySelectorAll(`#${parentTab} .tab-ngajar`);
        const targetContent = document.getElementById(`ngajar-${parentTab}-${target}`);
        
        // Hide all contents in this parent tab
        contents.forEach(content => {
            if (!content.classList.contains('hidden')) {
                content.classList.add('fade-out');
                setTimeout(() => {
                    content.classList.add('hidden');
                    content.classList.remove('fade-out');
                }, 300);
            }
        });
        
        // Show target content
        if (targetContent) {
            setTimeout(() => {
                targetContent.classList.remove('hidden');
                targetContent.classList.add('fade-in');
                setTimeout(() => {
                    targetContent.classList.remove('fade-in');
                }, 500);
            }, 300);
        }
    },

    // Reset ngajar buttons to default state
    resetNgajarButtons(parentTab) {
        const parentElement = document.getElementById(parentTab);
        if (parentElement) {
            const buttons = parentElement.querySelectorAll('.toggle-ngajar');
            buttons.forEach((btn, index) => {
                btn.classList.remove('bg-teal-500', 'text-white');
                btn.classList.add('bg-white', 'text-teal-500');
                
                // Set first button as active
                if (index === 0) {
                    btn.classList.remove('bg-white', 'text-teal-500');
                    btn.classList.add('bg-teal-500', 'text-white');
                }
            });
        }
    },

    // Add smooth scroll to top on page load
    addScrollToTopOnLoad() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    },

    // Utility function for smooth scrolling to elements
    scrollToElement(elementId) {
        const element = document.getElementById(elementId);
        if (element) {
            element.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    },

    // Add pulse animation to buttons
    addPulseAnimation(button) {
        button.style.animation = 'pulse 0.6s cubic-bezier(0.4, 0, 0.6, 1)';
        setTimeout(() => {
            button.style.animation = '';
        }, 600);
    }
};

// Initialize the module system when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    modul.init();
});

// Add global styles for better UX
const globalStyles = `
    .pulse {
        animation: pulse 0.6s cubic-bezier(0.4, 0, 0.6, 1);
    }
    
    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.05);
        }
    }
    
    .smooth-transition {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .content-enter {
        animation: contentEnter 0.4s cubic-bezier(0.4, 0, 0.2, 1) forwards;
    }
    
    @keyframes contentEnter {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
`;

// Add global styles to document
const styleSheet = document.createElement('style');
styleSheet.textContent = globalStyles;
document.head.appendChild(styleSheet);