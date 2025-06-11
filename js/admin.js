document.addEventListener("DOMContentLoaded", function () {
    const tokenCtx = document.getElementById("tokenChart");

    if (tokenCtx) {
        const tokenData = JSON.parse(localStorage.getItem("tokenChartData")) || [];

        new Chart(tokenCtx, {
            type: 'line',
            data: {
                labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
                datasets: [{
                    label: 'Token Terupdate',
                    data: tokenData,
                    fill: true,
                    borderColor: 'rgba(59, 130, 246, 1)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const ctx = document.getElementById("donasiChart")?.getContext("2d");
    if (ctx) {
        const data = JSON.parse(localStorage.getItem("donasiChartData") || "[]");

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
                datasets: [{
                    label: 'Total Donasi',
                    data: data,
                    fill: true,
                    borderColor: 'rgba(16, 185, 129, 1)', // teal-500
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }
});
