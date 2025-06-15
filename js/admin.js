document.addEventListener('DOMContentLoaded', function() {
    initializeCounterAnimations();
    initializeCharts();
    initializeSidebar();
    
    setInterval(refreshDashboardData, 300000);
});

function initializeCounterAnimations() {
    const counters = document.querySelectorAll('[data-target]');
    
    counters.forEach(counter => {
        const target = parseInt(counter.getAttribute('data-target'));
        const duration = 2000;
        const start = 0;
        const increment = target / (duration / 16);
        
        animateCounter(counter, start, target, increment);
    });
}

function animateCounter(element, current, target, increment) {
    if (current < target) {
        element.textContent = Math.ceil(current);
        setTimeout(() => {
            animateCounter(element, current + increment, target, increment);
        }, 16);
    } else {
        element.textContent = target;
    }
}
function initializeCharts() {
    const chartData = JSON.parse(localStorage.getItem('chartData') || '{}');
    
    if (Object.keys(chartData).length > 0) {
        createTokenChart(chartData.tokenData || []);
        createDonasiChart(chartData.donasiData || []);
    }
}

function createTokenChart(data) {
    const ctx = document.getElementById('tokenChart');
    if (!ctx) return;
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Token Update',
                data: data,
                borderColor: '#14b8a6',
                backgroundColor: 'rgba(20, 184, 166, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#14b8a6',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        color: '#374151',
                        font: {
                            family: 'Roboto Slab'
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: '#14b8a6',
                    borderWidth: 1,
                    displayColors: true,
                    callbacks: {
                        label: function(context) {
                            return 'Token: ' + context.parsed.y.toLocaleString('id-ID');
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    },
                    ticks: {
                        color: '#6b7280',
                        font: {
                            family: 'Roboto Slab'
                        },
                        callback: function(value) {
                            return value.toLocaleString('id-ID');
                        }
                    }
                },
                x: {
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    },
                    ticks: {
                        color: '#6b7280',
                        font: {
                            family: 'Roboto Slab'
                        }
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            }
        }
    });
}

function createDonasiChart(data) {
    const ctx = document.getElementById('donasiChart');
    if (!ctx) return;
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Total Donasi',
                data: data,
                backgroundColor: 'rgba(34, 197, 94, 0.8)',
                borderColor: '#22c55e',
                borderWidth: 2,
                borderRadius: 6,
                borderSkipped: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        color: '#374151',
                        font: {
                            family: 'Roboto Slab'
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: '#22c55e',
                    borderWidth: 1,
                    displayColors: true,
                    callbacks: {
                        label: function(context) {
                            return 'Donasi: Rp ' + context.parsed.y.toLocaleString('id-ID');
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    },
                    ticks: {
                        color: '#6b7280',
                        font: {
                            family: 'Roboto Slab'
                        },
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                },
                x: {
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    },
                    ticks: {
                        color: '#6b7280',
                        font: {
                            family: 'Roboto Slab'
                        }
                    }
                }
            }
        }
    });
}

function refreshDashboardData() {
    fetch(window.location.href, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.text())
    .then(html => {
        const parser = new DOMParser();
        const newDoc = parser.parseFromString(html, 'text/html');
        
        const counters = document.querySelectorAll('[data-target]');
        counters.forEach(counter => {
            const id = counter.id;
            const newCounter = newDoc.getElementById(id);
            if (newCounter) {
                const newTarget = parseInt(newCounter.getAttribute('data-target'));
                const currentValue = parseInt(counter.textContent);
                
                if (newTarget !== currentValue) {
                    counter.setAttribute('data-target', newTarget);
                    animateCounter(counter, currentValue, newTarget, (newTarget - currentValue) / 60);
                }
            }
        });
    })
    .catch(error => {
        console.log('Auto refresh failed:', error);
    });
}

function formatNumber(num) {
    return num.toLocaleString('id-ID');
}

function formatCurrency(num) {
    return 'Rp ' + num.toLocaleString('id-ID');
}

function showLoading() {
}

function hideLoading() {
}

function handleError(error) {
    console.error('Dashboard Error:', error);
}

if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        initializeCounterAnimations,
        initializeCharts,
        formatNumber,
        formatCurrency
    };
}

document.addEventListener("DOMContentLoaded", () => {
  const cards = document.querySelectorAll('.animate-on-scroll');
  const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.remove('opacity-0', 'translate-y-4');
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.1 });

  cards.forEach(card => observer.observe(card));
});
