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

    const topupBtn = document.getElementById('topupButton');
        if (topupBtn) {
            topupBtn.addEventListener('click', this.showTopuptoken.bind(this));
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

    async purchaseModule(moduleId) {
        try {
            const response = await fetch('../api/purchase_module.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ module_id: moduleId })
            });
            
            const data = await response.json();
            
            if (data.success) {
                this.showToast('Modul berhasil dibeli!', 'success');
                this.loadUserToken(); // Refresh token display
                this.closeModal();
                setTimeout(() => {
                    window.location.href = `module_detail.php?id=${moduleId}`;
                }, 1000);
            } else {
                this.showToast(data.message || 'Gagal membeli modul', 'error');
            }
        } catch (error) {
            console.error('Error purchasing module:', error);
            this.showToast('Terjadi kesalahan saat membeli modul', 'error');
        }
    }

    showInsufficientTokensModal() {
        const token = this.createModal(
            'Token Tidak Cukup',
            'Anda tidak memiliki cukup token untuk membeli modul ini. Lakukan top up terlebih dahulu.',
            [
                {
                    text: 'Batal',
                    class: 'bg-gray-500 hover:bg-gray-600',
                    onClick: () => this.closeModal()
                },
                {
                    text: 'Top Up',
                    class: 'bg-teal-500 hover:bg-teal-600',
                    onClick: () => {
                        this.closeModal();
                        this.showTopupModal();
                    }
                }
            ]
        );
        
        document.body.appendChild(modal);
    }

    showTopuptoken() {
        const token = this.createModal(
            'Top Up Token',
            `
                <div class="space-y-4">
                    <p>Pilih jumlah token yang ingin dibeli:</p>
                    <div class="grid grid-cols-2 gap-4">
                        <button class="topup-option p-4 border-2 border-teal-500 rounded-lg hover:bg-teal-50 transition-colors" data-tokens="50" data-price="25000">
                            <div class="font-bold text-teal-500">50 Token</div>
                            <div class="text-sm text-gray-600">Rp 25.000</div>
                        </button>
                        <button class="topup-option p-4 border-2 border-teal-500 rounded-lg hover:bg-teal-50 transition-colors" data-tokens="100" data-price="45000">
                            <div class="font-bold text-teal-500">100 Token</div>
                            <div class="text-sm text-gray-600">Rp 45.000</div>
                        </button>
                        <button class="topup-option p-4 border-2 border-teal-500 rounded-lg hover:bg-teal-50 transition-colors" data-tokens="250" data-price="100000">
                            <div class="font-bold text-teal-500">250 Token</div>
                            <div class="text-sm text-gray-600">Rp 100.000</div>
                        </button>
                        <button class="topup-option p-4 border-2 border-teal-500 rounded-lg hover:bg-teal-50 transition-colors" data-tokens="500" data-price="180000">
                            <div class="font-bold text-teal-500">500 Token</div>
                            <div class="text-sm text-gray-600">Rp 180.000</div>
                        </button>
                    </div>
                </div>
            `,
            [
                {
                    text: 'Tutup',
                    class: 'bg-gray-500 hover:bg-gray-600',
                    onClick: () => this.closeModal()
                }
            ]
        );
        
        // Add click events to topup options
        modal.querySelectorAll('.topup-option').forEach(option => {
            option.addEventListener('click', () => {
                option.classList.add('bg-teal-100', 'border-teal-600');
                // Remove selection from other options
                modal.querySelectorAll('.topup-option').forEach(other => {
                    if (other !== option) {
                        other.classList.remove('bg-teal-100', 'border-teal-600');
                    }
                });
                
                // Add purchase button if not exists
                let purchaseBtn = modal.querySelector('.purchase-btn');
                if (!purchaseBtn) {
                    purchaseBtn = document.createElement('button');
                    purchaseBtn.className = 'purchase-btn w-full mt-4 bg-teal-500 hover:bg-teal-600 text-white px-4 py-2 rounded-lg transition-colors';
                    purchaseBtn.textContent = 'Lanjutkan Pembayaran';
                    modal.querySelector('.space-y-4').appendChild(purchaseBtn);
                }
                
                purchaseBtn.onclick = () => {
                    const tokens = option.dataset.tokens;
                    const price = option.dataset.price;
                    this.processTopup(tokens, price);
                };
            });
        });
        
        document.body.appendChild(modal);
    }

    processTopup(tokens, price) {
        // Simulate payment process
        this.showToast('Mengalihkan ke halaman pembayaran...', 'info');
        this.closeModal();
        
        // In real implementation, this would redirect to payment gateway
        setTimeout(() => {
            this.showToast('Pembayaran berhasil! Token telah ditambahkan.', 'success');
            this.loadUserToken();
        }, 2000);
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

