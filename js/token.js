document.addEventListener("DOMContentLoaded", () => {
  // === Popup Functionality ===
  const openBtn = document.getElementById("openPopup");
  const closeBtn = document.getElementById("closePopup");
  const popup = document.getElementById("popup");

  if (openBtn && popup) {
    openBtn.addEventListener("click", () => {
      popup.classList.remove("hidden");
    });
  }

  if (closeBtn && popup) {
    closeBtn.addEventListener("click", () => {
      popup.classList.add("hidden");
    });
  }

  if (popup) {
    popup.addEventListener("click", (e) => {
      if (e.target === popup) {
        popup.classList.add("hidden");
      }
    });
  }

  // === Sidebar Toggle Functionality ===
  const hamburgerButton = document.getElementById("hamburgerButton");
  const sidebar = document.getElementById("sidebar");
  const overlay = document.getElementById("overlay");

  if (hamburgerButton) {
    hamburgerButton.addEventListener("click", () => {
      if (sidebar) {
        sidebar.classList.toggle("-translate-x-full");
      }
      if (overlay) {
        overlay.classList.toggle("hidden");
      }
    });
  }

  if (overlay) {
    overlay.addEventListener("click", () => {
      if (sidebar) {
        sidebar.classList.add("-translate-x-full");
      }
      overlay.classList.add("hidden");
    });
  }

  // === Escape Key for Closing Popup/Sidebar ===
  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") {
      if (sidebar && !sidebar.classList.contains("-translate-x-full")) {
        sidebar.classList.add("-translate-x-full");
        if (overlay) {
          overlay.classList.add("hidden");
        }
      }

      if (popup && !popup.classList.contains("hidden")) {
        popup.classList.add("hidden");
      }
    }
  });

  // === Hover Effect for Class Cards ===
  const classCards = document.querySelectorAll('[onclick*="detail_kelas.php"]');
  classCards.forEach(card => {
    card.addEventListener('mouseenter', () => {
      card.style.transform = 'scale(1.02)';
      card.style.transition = 'transform 0.2s ease-in-out';
    });

    card.addEventListener('mouseleave', () => {
      card.style.transform = 'scale(1)';
    });
  });

  // === Transition for Buttons ===
  const buttons = document.querySelectorAll('button, .bg-teal-500, .bg-white');
  buttons.forEach(button => {
    button.style.transition = 'all 0.2s ease-in-out';
  });

  // === Form Enrollment Handler ===
  const enrollmentForms = document.querySelectorAll('form[action=""] input[name="ikuti"]');
  enrollmentForms.forEach(form => {
    form.closest('form').addEventListener('submit', (e) => {
      formHandler.handleEnrollment(e.target);
    });
  });

  // === Module Purchase Handler ===
  const purchaseForms = document.querySelectorAll('form[action="murid_beli_modul.php"]');
  purchaseForms.forEach(form => {
    form.addEventListener('submit', (e) => {
      if (!formHandler.handleModulePurchase(e.target)) {
        e.preventDefault();
      }
    });
  });
});
// Object untuk mengelola semua fungsi modul
const modul = {
    // Toggle untuk Modul Pembelajaran (Soal, PDF, Video)
    toggleModul: function(button) {
        const target = button.getAttribute('data-target');
        
        // Update button states
        this.updateButtonStates('.toggle-modul', button);
        
        // Show/hide modul content
        this.showModulContent(target);
    },

    // Toggle untuk tab Premium/Gratis
    togglePremium: function(button) {
        const target = button.getAttribute('data-target');
        
        // Update button states
        this.updateButtonStates('.toggle-tab', button);
        
        // Show/hide premium content
        this.showPremiumContent(target);
    },

    // Toggle untuk sub-tabs dalam Premium/Gratis (Soal, PDF, Video)
    toggleNgajar: function(button, parentType) {
        const target = button.getAttribute('data-target');
        
        // Update button states within the parent container
        const parentContainer = document.getElementById(parentType);
        if (parentContainer) {
            this.updateButtonStatesInContainer(parentContainer, '.toggle-ngajar', button);
        }
        
        // Show/hide ngajar content
        this.showNgajarContent(target, parentType);
    },

    // Helper function to update button states
    updateButtonStates: function(selector, activeButton) {
        const buttons = document.querySelectorAll(selector);
        
        buttons.forEach(btn => {
            if (btn === activeButton) {
                // Active button styling
                btn.classList.remove('bg-white', 'text-teal-500');
                btn.classList.add('bg-teal-500', 'text-white');
            } else {
                // Inactive button styling
                btn.classList.remove('bg-teal-500', 'text-white');
                btn.classList.add('bg-white', 'text-teal-500');
            }
        });
    },

    // Helper function to update button states within a specific container
    updateButtonStatesInContainer: function(container, selector, activeButton) {
        const buttons = container.querySelectorAll(selector);
        
        buttons.forEach(btn => {
            if (btn === activeButton) {
                // Active button styling
                btn.classList.remove('bg-white', 'text-teal-500');
                btn.classList.add('bg-teal-500', 'text-white');
            } else {
                // Inactive button styling
                btn.classList.remove('bg-teal-500', 'text-white');
                btn.classList.add('bg-white', 'text-teal-500');
            }
        });
    },

    // Show modul content (Soal, PDF, Video dari kelas)
    showModulContent: function(target) {
        // Hide all modul content
        const allModulContent = document.querySelectorAll('.tab-modul');
        allModulContent.forEach(content => {
            content.classList.add('hidden');
        });
        
        // Show target content
        const targetContent = document.getElementById('modul-' + target);
        if (targetContent) {
            targetContent.classList.remove('hidden');
        }
    },

    // Show premium/gratis content
    showPremiumContent: function(target) {
        // Hide all sub-tab groups
        const allSubTabGroups = document.querySelectorAll('.sub-tab-group');
        allSubTabGroups.forEach(group => {
            group.classList.add('hidden');
            group.classList.remove('block');
        });
        
        // Show target group
        const targetGroup = document.getElementById(target);
        if (targetGroup) {
            targetGroup.classList.remove('hidden');
            targetGroup.classList.add('block');
            
            // Reset to first tab when switching premium/gratis
            const firstButton = targetGroup.querySelector('.toggle-ngajar');
            if (firstButton) {
                this.toggleNgajar(firstButton, target);
            }
        }
    },

    // Show ngajar content (sub-tabs dalam premium/gratis)
    showNgajarContent: function(target, parentType) {
        // Hide all ngajar content within the parent type
        const allNgajarContent = document.querySelectorAll(`#ngajar-${parentType}-soal, #ngajar-${parentType}-pdf, #ngajar-${parentType}-video`);
        allNgajarContent.forEach(content => {
            content.classList.add('hidden');
        });
    }
};

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    console.log('Modul navigation system initialized');
    
    // Set default active states
    // Default: Soal tab active for Modul Pembelajaran
    const defaultModulButton = document.getElementById('btnSoal');
    if (defaultModulButton) {
        modul.toggleModul(defaultModulButton);
    }
    
    // Default: Gratis tab active for Modul Ngajar.id
    const defaultPremiumButton = document.getElementById('btnGratis');
    if (defaultPremiumButton) {
        modul.togglePremium(defaultPremiumButton);
    }
});

// Alternative standalone functions (jika tidak ingin menggunakan object)
function toggleModul(button) {
    modul.toggleModul(button);
}

function togglePremium(button) {
    modul.togglePremium(button);
}

function toggleNgajar(button, parentType) {
    modul.toggleNgajar(button, parentType);
}

// Hamburger menu functionality (bonus)
document.addEventListener('DOMContentLoaded', function() {
    const hamburgerButton = document.getElementById('hamburgerButton');
    const sidebar = document.getElementById('sidebar'); // Assuming sidebar has this ID
    
    if (hamburgerButton) {
        hamburgerButton.addEventListener('click', function() {
            if (sidebar) {
                sidebar.classList.toggle('hidden');
                sidebar.classList.toggle('block');
            }
        });
    }
});

// Smooth scrolling for better UX
function smoothScrollToSection(element) {
    if (element) {
        element.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    }
}

// Add loading animation (optional enhancement)
function addLoadingAnimation(button) {
    const originalText = button.innerHTML;
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    button.disabled = true;
    
    setTimeout(() => {
        button.innerHTML = originalText;
        button.disabled = false;
    }, 300);
}
// === Window Bindings ===
window.modul = modul;
window.utils = utils;
window.formHandler = formHandler;
