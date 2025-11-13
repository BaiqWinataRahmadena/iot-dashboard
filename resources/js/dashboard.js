// resources/js/dashboard.js
import Chart from 'chart.js/auto';

document.addEventListener('DOMContentLoaded', () => {
    // === Data Dummy ===
    const dataVolume = [650, 590, 800, 810, 560, 550, 400];
    const labelsVolume = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
    
    const dataStatus = [25, 5, 70]; // Akurat, Tidak Akurat, Normalisasi
    const labelsStatus = ['Akurat (>95%)', 'Tidak Akurat (<95%)', 'Normalisasi'];

    // === Fungsi Render Grafik ===

    // 1. Grafik Volume Mingguan (Garis)
    const ctxVolume = document.getElementById('volumeChart');
    if (ctxVolume) {
        new Chart(ctxVolume, {
            type: 'line',
            data: {
                labels: labelsVolume,
                datasets: [{
                    label: 'Rata-rata Volume Harian (L)',
                    data: dataVolume,
                    borderColor: '#4299e1',
                    backgroundColor: 'rgba(66, 153, 225, 0.2)',
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    // 2. Grafik Status Akurasi (Donut)
    const ctxStatus = document.getElementById('statusChart');
    if (ctxStatus) {
        new Chart(ctxStatus, {
            type: 'doughnut',
            data: {
                labels: labelsStatus,
                datasets: [{
                    label: 'Status Akurasi Data',
                    data: dataStatus,
                    backgroundColor: [
                        '#48BB78', // Hijau (Akurat)
                        '#F56565', // Merah (Tidak Akurat)
                        '#ECC94B'  // Kuning (Normalisasi)
                    ],
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Distribusi Akurasi Data Mingguan'
                    }
                }
            }
        });
    }
});