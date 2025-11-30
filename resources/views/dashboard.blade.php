@extends('layouts.app', ['noHeader' => true]) 

@section('pageTitle', 'Dashboard')
@section('pageSubtitle', 'Selamat datang di Sistem Informasi Magang')

@section('content')

<!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-center text-white p-7 rounded-2xl shadow-lg gap-6 mb-8"
        style="background: linear-gradient(135deg, #5a6de0 0%, #6c3fb0 100%);">
        <div>
            <h2 class="text-2xl font-bold flex items-center gap-5 leading-tight">
                <i class="fas fa-graduation-cap text-4xl"></i> Dashboard Admin
            </h2>
            <p class="text-m text-white-100 mt-2">Selamat datang di Sistem Informasi Magang</p>
        </div>
        <button class="px-5 py-2 bg-white/20 hover:bg-white/30 rounded-lg text-white font-medium flex items-center gap-2 transition-all duration-200 hover:scale-[1.03]">
            <i class="fas fa-bell"></i> Reminder
        </button>
    </div>

    <!-- Sisanya isi dashboard kamu -->
            <!-- Dashboard Content -->
                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <!-- Card 1 -->
                    <div class="stat-card bg-blue-50 rounded-xl p-6 shadow-lg animate-slide-in relative overflow-hidden" style="animation-delay: 0.1s">
                        <!-- Icon besar sebagai dekorasi background -->
                        <div class="absolute right-4 bottom-4 text-blue-400 text-8xl opacity-20">
                            <i class="fas fa-users"></i>
                        </div>

                        <!-- Konten utama -->
                        <div class="relative z-10 flex flex-col h-full">
                            <!-- Header -->
                            <p class="text-sm font-medium text-gray-600">Total Mahasiswa</p>

                            <!-- Body -->
                            <p class="text-5xl font-extrabold text-gray-900 mt-2">60</p>

                            <!-- Footer -->
                            <p class="text-sm text-green-600 flex items-center mt-3">
                            <i class="fas fa-arrow-up mr-1"></i> +10 vs Bulan Lalu
                            </p>
                        </div>
                        </div>

                    
                    
                    <!-- Card 2 -->
                    <div class="stat-card bg-green-50 rounded-xl p-6 shadow-lg animate-slide-in relative overflow-hidden" style="animation-delay: 0.2s">
                    <!-- Icon besar sebagai dekorasi background -->
                    <div class="absolute right-4 bottom-4 text-green-400 text-8xl opacity-20">
                        <i class="fas fa-calendar-check"></i>
                    </div>

                    <!-- Konten utama -->
                    <div class="relative z-10 flex flex-col h-full">
                        <!-- Header -->
                        <p class="text-sm font-medium text-gray-600">Hadir Hari Ini</p>

                        <!-- Body -->
                        <p class="text-5xl font-extrabold text-gray-900 mt-2">54</p>

                        <!-- Footer -->
                        <p class="text-sm text-green-600 flex items-center mt-3">
                        <i class="fas fa-check mr-1"></i> 90% dari total
                        </p>
                    </div>
                    </div>

                    
                    <!-- Card 3 -->
                    <div class="stat-card bg-purple-50 rounded-xl p-6 shadow-lg animate-slide-in relative overflow-hidden" style="animation-delay: 0.2s">
                    <!-- Icon besar -->
                    <div class="absolute right-4 bottom-4 text-purple-400 text-8xl opacity-20">
                        <i class="fas fa-chart-line"></i>
                    </div>

                    <!-- Konten utama -->
                    <div class="relative z-10 flex flex-col h-full">
                        <p class="text-sm font-medium text-gray-600">Tingkat Kehadiran</p>
                        <p class="text-5xl font-extrabold text-gray-900 mt-2">90%</p>
                        <p class="text-sm text-red-600 flex items-center mt-3">
                        <i class="fas fa-arrow-down mr-1"></i> 10% vs Kemarin
                        </p>
                    </div>
                    </div>

                    <!-- Card 4 -->
                    <div class="stat-card bg-yellow-50 rounded-xl p-6 shadow-lg animate-slide-in relative overflow-hidden" style="animation-delay: 0.3s">
                    <!-- Icon besar -->
                    <div class="absolute right-4 bottom-4 text-yellow-400 text-8xl opacity-20">
                        <i class="fas fa-star"></i>
                    </div>

                    <!-- Konten utama -->
                    <div class="relative z-10 flex flex-col h-full">
                        <p class="text-sm font-medium text-gray-600">Penilaian Pending</p>
                        <p class="text-5xl font-extrabold text-gray-900 mt-2">3</p>
                        <p class="text-sm text-orange-600 flex items-center mt-3">
                        <i class="fas fa-clock mr-1"></i> Perlu Review
                        </p>
                    </div>
                    </div>

                </div>
                
                <!-- 📊 Charts Section -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

                <!-- Card Statistik Absensi Harian -->
                <!-- Card Statistik Absensi Harian -->
                <div class="stat-card bg-white rounded-xl p-6 shadow-lg animate-slide-in relative overflow-hidden">
                <!-- Header -->
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-800">Statistik Absensi Mahasiswa</h3>

                    <!-- Dropdown Bulan -->
                    <select class="text-sm border border-gray-200 rounded-lg px-3 py-1 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option>Januari 2025</option>
                    <option>Februari 2025</option>
                    <option>Maret 2025</option>
                    <option>April 2025</option>
                    <option>Mei 2025</option>
                    <option>Juni 2025</option>
                    <option>Juli 2025</option>
                    <option>Agustus 2025</option>
                    <option>September 2025</option>
                    <option>Oktober 2025</option>
                    <option>November 2025</option>
                    <option>Desember 2025</option>
                    </select>
                </div>

                <!-- Chart -->
                <div class="h-72">
                    <canvas id="lineChart"></canvas>
                </div>
                </div>




                <!-- Bar Chart: Penilaian -->
                <div class="stat-card bg-white rounded-xl p-6 shadow-lg animate-slide-in">
                    <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-800">Penilaian Rata-rata</h3>
                    
                    </div>
                    <div class="h-72">
                    <canvas id="barChart"></canvas>
                    </div>
                </div>

                <!-- Card Statistik Status Magang -->
                <div class="stat-card bg-white rounded-xl p-6 shadow-lg animate-slide-in">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-800">Status Mahasiswa Magang</h3>
                    </div>
                    <div class="h-72 flex items-center justify-center">
                        <canvas id="statusMagangChart"></canvas>
                    </div>
                </div>

                <!-- Bar Chart: Status Permohonan Perpanjangan Magang -->
                <div class="stat-card bg-white rounded-xl p-6 shadow-lg animate-slide-in">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-800">Status Permohonan Perpanjangan</h3>
                        <button class="text-sm text-indigo-600 hover:text-indigo-700" onclick="window.location.href='{{ route('admin.mahasiswa.index') }}'">
                        <i class="fas fa-search mr-1"></i> Lihat detail
                    </button>
                    </div>
                    <div class="h-72">
                        <canvas id="statusPerpanjanganChart"></canvas>
                    </div>
                </div>

<script>
const statusPerpanjanganCtx = document.getElementById('statusPerpanjanganChart').getContext('2d');

new Chart(statusPerpanjanganCtx, {
    type: 'bar',
    data: {
        labels: ['Menunggu Persetujuan', 'Disetujui', 'Ditolak'],
        datasets: [{
            label: 'Jumlah Permohonan',
            data: [4, 10, 2], // TODO: nanti ambil data dari DB
            backgroundColor: [
                'rgb(234, 179, 8)',  // Pending
                'rgb(34, 197, 94)',  // Approved
                'rgb(239, 68, 68)'   // Rejected
            ],
            borderRadius: 10,
            barThickness: 22
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        indexAxis: 'y', // Horizontal
        plugins: {
            legend: { display: false }
        },
        scales: {
            x: {
                beginAtZero: true,
                ticks: { precision: 0 }
            },
            y: {
                grid: { display: false }
            }
        }
    }
});
</script>


</div>

                
                <!-- Wrapper -->
                <div class="flex flex-col md:flex-row gap-6">
                    <!-- Recent Activities -->
                    <div class="md:w-2/3 bg-white rounded-xl shadow-lg animate-slide-in" style="animation-delay: 0.6s">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-800">Aktivitas Terbaru</h3>
                        </div>
                        <div class="p-6 space-y-4">
                            <div class="flex items-start space-x-4">
                                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-user-plus text-blue-600 text-sm"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-800">Mahasiswa baru terdaftar</p>
                                    <p class="text-xs text-gray-500">Ahmad Fauzi - 5 menit yang lalu</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start space-x-4">
                                <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-check text-green-600 text-sm"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-800">Laporan akhir disetujui</p>
                                    <p class="text-xs text-gray-500">Sarah Wijaya - 1 jam yang lalu</p>
                                </div>
                            </div>
                            
                
                            
                            <div class="flex items-start space-x-4">
                                <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-bell text-yellow-600 text-sm"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-800">Reminder deadline laporan</p>
                                    <p class="text-xs text-gray-500">Sistem - 5 jam yang lalu</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="md:w-1/3 bg-white rounded-xl shadow-lg animate-slide-in" style="animation-delay: 0.8s">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="font-semibold text-lg text-gray-800">Aksi Cepat</h3>
                        </div>
                        <div class="p-6 space-y-3">
                            <button class="w-full flex items-center justify-between p-3 text-left bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-user-plus text-blue-600"></i>
                                    <span class="font-medium text-blue-600">Tambah Mahasiswa</span>
                                </div>
                                <i class="fas fa-arrow-right text-blue-600"></i>
                            </button>
                            <button class="w-full flex items-center justify-between p-3 text-left bg-green-50 hover:bg-green-100 rounded-lg transition-colors">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-file-export text-green-600"></i>
                                    <span class="font-medium text-green-600">Export Laporan</span>
                                </div>
                                <i class="fas fa-arrow-right text-green-600"></i>
                            </button>
                            <button class="w-full flex items-center justify-between p-3 text-left bg-purple-50 hover:bg-purple-100 rounded-lg transition-colors">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-cog text-purple-600"></i>
                                    <span class="font-medium text-purple-600">Pengaturan</span>
                                </div>
                                <i class="fas fa-arrow-right text-purple-600"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- End Wrapper -->

            </main>
        </div>
    </div>
    
    
    <script>
        // Toggle Sidebar for Mobile
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('-translate-x-full');
        }
        
    /* 🥧 Pie Chart — Status Absensi Mahasiswa */
    const pieStatusCtx = document.getElementById('lineChart').getContext('2d');
    
    new Chart(pieStatusCtx, {
        type: 'pie',
        data: {
            labels: ['Hadir', 'Izin', 'Sakit', 'Alpha'],
            datasets: [{
                data: [280, 12, 9, 3], // contoh dummy → bisa disesuaikan dari DB
                backgroundColor: [
                    '#22c55e', // Green hadir
                    '#eab308', // Yellow izin
                    '#3b82f6', // Blue sakit
                    '#ef4444', // Red alpha
                ],
                borderColor: '#ffffff',
                borderWidth: 2,
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 15,
                        usePointStyle: true,
                        font: { size: 12 }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(ctx) {
                            const total = ctx.dataset.data.reduce((a,b)=>a+b,0);
                            const value = ctx.raw;
                            const percent = ((value / total) * 100).toFixed(1);
                            return ` ${ctx.label}: ${value} (${percent}%)`;
                        }
                    },
                    padding: 12,
                    backgroundColor: '#111827',
                    bodyColor: '#fff',
                    titleColor: '#fff',
                    cornerRadius: 6
                }
            }
        }
    });





    // Bar Chart Configuration (Revisi Penilaian Rata-rata)
    const barCtx = document.getElementById('barChart').getContext('2d');
    new Chart(barCtx, {
        type: 'bar',
        data: {
            labels: [
                'Integritas',
                'Ketepatan Waktu',
                'Keahlian Bidang Ilmu',
                'Kerjasama Tim',
                'Komunikasi',
                'Teknologi Informasi',
                'Pengembangan Diri'
            ],
            datasets: [{
                label: 'Nilai Rata-rata',
                data: [88, 90, 92, 87, 89, 91, 90], // contoh data dinamis nanti dari DB
                backgroundColor: [
                    'rgba(99, 102, 241, 0.8)', // Integritas - Indigo
                    'rgba(34, 197, 94, 0.8)', // Tepat Waktu - Green
                    'rgba(251, 191, 36, 0.8)', // Keahlian - Amber
                    'rgba(168, 85, 247, 0.8)', // Kerjasama - Purple
                    'rgba(59, 130, 246, 0.8)', // Komunikasi - Blue
                    'rgba(20, 184, 166, 0.8)', // TI - Teal
                    'rgba(239, 68, 68, 0.8)' // Pengembangan Diri - Red
                ],
                borderRadius: 10,
                barPercentage: 0.55,
                categoryPercentage: 0.7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: {
                duration: 800
            },
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    grid: {
                        drawBorder: false
                    }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });


    </script>

<script>
const statusMagangCtx = document.getElementById('statusMagangChart').getContext('2d');

new Chart(statusMagangCtx, {
    type: 'doughnut',
    data: {
        labels: ['Internship', 'PKL'],
        datasets: [{
            data: [24, 36], // TODO: angka ini tinggal disesuaikan dari database
            backgroundColor: [
                'rgb(34, 197, 94)',   // Internship - Green
                'rgb(99, 102, 241)'   // PKL - Indigo
            ],
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '65%',
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    padding: 18,
                    usePointStyle: true,
                    font: { size: 12 }
                }
            },
            tooltip: {
                callbacks: {
                    label: function(ctx) {
                        const total = ctx.dataset.data.reduce((a,b)=>a+b,0);
                        const value = ctx.raw;
                        const percent = ((value / total) * 100).toFixed(1);
                        return ` ${ctx.label}: ${value} (${percent}%)`;
                    }
                },
                padding: 10,
                backgroundColor: '#111827',
                titleColor: '#fff',
                bodyColor: '#fff'
            }
        }
    },
    plugins: [{
        id: 'centerTextStatusMagang',
        afterDraw: (chart) => {
            const {ctx, width, chartArea} = chart;
            const total = chart.data.datasets[0].data.reduce((a, b) => a + b, 0);

            ctx.save();
            ctx.font = 'bold 18px Inter';
            ctx.fillStyle = '#374151';
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.fillText(total + ' Mahasiswa', width / 2, chartArea.top + (chartArea.bottom - chartArea.top) / 2);
        }
    }]
});
</script>

    <!-- Script Donut Chart: Reminder Durasi Magang -->
    <script>
    const donutCtx = document.getElementById('donutChart').getContext('2d');
    new Chart(donutCtx, {
        type: 'doughnut',
        data: {
        labels: ['Selesai', 'Sisa'],
        datasets: [{
            data: [70, 30], // contoh: sudah 70% magang, 30% sisa
            backgroundColor: [
            'rgb(99, 102, 241)',   // Indigo → progress selesai
            'rgb(229, 231, 235)'   // Gray → sisa durasi
            ],
            borderWidth: 0
        }]
        },
        options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '70%', // bikin lubang tengah lebih besar
        plugins: {
            legend: {
            display: false // legend disembunyiin biar clean
            },
            tooltip: {
            callbacks: {
                label: function(context) {
                return context.label + ': ' + context.parsed + '%';
                }
            }
            }
        }
        },
        plugins: [{
        id: 'donutCenterText',
        afterDraw: (chart) => {
            const {ctx, width} = chart;
            const meta = chart.getDatasetMeta(0);
            const total = chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
            const done = chart.data.datasets[0].data[0];
            const percent = Math.round((done / total) * 100);

            ctx.save();
            ctx.font = 'bold 20px Inter';
            ctx.fillStyle = '#374151';
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.fillText(percent + '%', width / 2, chart.chartArea.top + (chart.chartArea.bottom - chart.chartArea.top) / 2);
        }
        }]
    });
    </script>


</body>
</html>
@endsection