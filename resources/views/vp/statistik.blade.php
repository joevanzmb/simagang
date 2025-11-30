@extends('layouts.vp', ['noHeader' => true])

@section('pageTitle', 'Statistik dan Analisis Sertifikat')
@section('pageSubtitle', 'Analisis performa mentor dan distribusi approval sertifikat secara keseluruhan.')

@section('content')
<div class="space-y-10">

  <!-- 🌈 HEADER -->
  <div class="flex flex-col md:flex-row justify-between items-center text-white p-7 rounded-2xl shadow-lg"
      style="background: linear-gradient(135deg, #5a6de0 0%, #6c3fb0 100%);">
      <div>
          <h2 class="text-2xl font-bold flex items-center gap-4 leading-tight">
              <i class="fas fa-chart-bar text-3xl"></i> Statistik Sertifikat & Mentor
          </h2>
          <p class="text-m text-white/90 mt-1">Lihat data performa mentor dan tren approval sertifikat magang/PKL.</p>
      </div>
      <button class="px-5 py-2 bg-white/20 hover:bg-white/30 rounded-lg text-white font-medium flex items-center gap-2 transition-all duration-200 hover:scale-[1.03]">
          <i class="fas fa-calendar-alt"></i> Periode: 2025
      </button>
  </div>

  <!-- 🧮 KARTU STATISTIK -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
      <div class="bg-indigo-50 rounded-xl p-6 shadow-md relative overflow-hidden">
          <div class="absolute right-4 bottom-4 text-indigo-300 text-6xl opacity-20"><i class="fas fa-users"></i></div>
          <p class="text-sm text-gray-600">Total Mahasiswa</p>
          <p class="text-4xl font-bold text-indigo-700 mt-1">128</p>
          <p class="text-xs text-gray-500 mt-2">Seluruh kampus & program</p>
      </div>

      <div class="bg-green-50 rounded-xl p-6 shadow-md relative overflow-hidden">
          <div class="absolute right-4 bottom-4 text-green-300 text-6xl opacity-20"><i class="fas fa-certificate"></i></div>
          <p class="text-sm text-gray-600">Sertifikat Disetujui</p>
          <p class="text-4xl font-bold text-green-700 mt-1">102</p>
          <p class="text-xs text-gray-500 mt-2">Telah diterbitkan otomatis</p>
      </div>

      <div class="bg-yellow-50 rounded-xl p-6 shadow-md relative overflow-hidden">
          <div class="absolute right-4 bottom-4 text-yellow-300 text-6xl opacity-20"><i class="fas fa-clock"></i></div>
          <p class="text-sm text-gray-600">Menunggu Approval</p>
          <p class="text-4xl font-bold text-yellow-700 mt-1">18</p>
          <p class="text-xs text-gray-500 mt-2">Sedang dalam proses review</p>
      </div>

      <div class="bg-red-50 rounded-xl p-6 shadow-md relative overflow-hidden">
          <div class="absolute right-4 bottom-4 text-red-300 text-6xl opacity-20"><i class="fas fa-ban"></i></div>
          <p class="text-sm text-gray-600">Ditolak</p>
          <p class="text-4xl font-bold text-red-700 mt-1">8</p>
          <p class="text-xs text-gray-500 mt-2">Perlu revisi mahasiswa</p>
      </div>
  </div>

  <!-- 📈 GRAFIK UTAMA -->
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
      <!-- Grafik Mentor -->
      <div class="bg-white p-6 rounded-xl shadow-md">
          <h3 class="font-semibold text-gray-700 mb-4 flex items-center gap-2">
              <i class="fas fa-user-tie text-indigo-500"></i> Performa Mentor (Jumlah Approval)
          </h3>
          <div class="h-72"><canvas id="mentorChart"></canvas></div>
      </div>

      <!-- Grafik Tren Bulanan -->
      <div class="bg-white p-6 rounded-xl shadow-md">
          <h3 class="font-semibold text-gray-700 mb-4 flex items-center gap-2">
              <i class="fas fa-chart-line text-green-500"></i> Tren Approval Sertifikat per Bulan
          </h3>
          <div class="h-72"><canvas id="trendChart"></canvas></div>
      </div>
  </div>

  <!-- 📊 TABEL DETAIL PER MENTOR -->
  <div class="bg-white rounded-2xl shadow-lg p-6">
      <div class="flex justify-between items-center mb-4">
          <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
              <i class="fas fa-list"></i> Detail Performa Mentor
          </h3>
          <div class="relative">
              <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
              <input type="text" placeholder="Cari nama mentor..."
                  class="pl-9 w-64 border border-gray-300 rounded-lg p-2 text-sm focus:ring-indigo-500 focus:border-indigo-500">
          </div>
      </div>

      <div class="overflow-x-auto">
          <table class="min-w-full text-sm text-gray-700 border border-gray-200 rounded-xl overflow-hidden">
              <thead class="bg-gray-100 text-gray-800">
                  <tr>
                      <th class="px-4 py-2 text-left font-semibold">Nama Mentor</th>
                      <th class="px-4 py-2 text-center font-semibold">Direktorat</th>
                      <th class="px-4 py-2 text-center font-semibold">Total Mahasiswa</th>
                      <th class="px-4 py-2 text-center font-semibold">Sertifikat Disetujui</th>
                      <th class="px-4 py-2 text-center font-semibold">Ditolak</th>
                      <th class="px-4 py-2 text-center font-semibold">Persentase Approval</th>
                      <th class="px-4 py-2 text-center font-semibold">Aksi</th>
                  </tr>
              </thead>
              <tbody>
                  <tr class="border-b hover:bg-indigo-50 transition">
                      <td class="px-4 py-2 font-medium">Andi Saputra</td>
                      <td class="px-4 py-2 text-center">Human Capital</td>
                      <td class="px-4 py-2 text-center">12</td>
                      <td class="px-4 py-2 text-center text-green-600 font-semibold">11</td>
                      <td class="px-4 py-2 text-center text-red-600 font-semibold">1</td>
                      <td class="px-4 py-2 text-center">
                          <div class="flex items-center justify-center gap-2">
                              <div class="w-24 bg-gray-200 rounded-full h-2.5">
                                  <div class="bg-green-500 h-2.5 rounded-full" style="width: 91.6%"></div>
                              </div>
                              <span class="text-xs font-semibold text-gray-600">91%</span>
                          </div>
                      </td>
                      <td class="px-4 py-2 text-center">
                          <button class="px-3 py-1 text-xs rounded-lg bg-indigo-500 text-white hover:bg-indigo-600 transition">
                              <i class="fas fa-eye mr-1"></i> Detail
                          </button>
                      </td>
                  </tr>

                  <tr class="border-b hover:bg-indigo-50 transition">
                      <td class="px-4 py-2 font-medium">Rina Oktaviani</td>
                      <td class="px-4 py-2 text-center">Keuangan</td>
                      <td class="px-4 py-2 text-center">8</td>
                      <td class="px-4 py-2 text-center text-green-600 font-semibold">7</td>
                      <td class="px-4 py-2 text-center text-red-600 font-semibold">1</td>
                      <td class="px-4 py-2 text-center">
                          <div class="flex items-center justify-center gap-2">
                              <div class="w-24 bg-gray-200 rounded-full h-2.5">
                                  <div class="bg-green-500 h-2.5 rounded-full" style="width: 88%"></div>
                              </div>
                              <span class="text-xs font-semibold text-gray-600">88%</span>
                          </div>
                      </td>
                      <td class="px-4 py-2 text-center">
                          <button class="px-3 py-1 text-xs rounded-lg bg-indigo-500 text-white hover:bg-indigo-600 transition">
                              <i class="fas fa-eye mr-1"></i> Detail
                          </button>
                      </td>
                  </tr>
              </tbody>
          </table>
      </div>
  </div>

</div>

<style>
@keyframes fadeIn { from { opacity: 0; transform: translateY(10px);} to { opacity: 1; transform: translateY(0);} }
.animate-fade-in { animation: fadeIn 0.3s ease-out; }
</style>

<script>
// Grafik Performa Mentor
new Chart(document.getElementById('mentorChart'), {
    type: 'bar',
    data: {
        labels: ['Andi Saputra', 'Rina Oktaviani', 'Bagus Santoso', 'Dewi Lestari', 'Ahmad Fauzi'],
        datasets: [{
            label: 'Jumlah Sertifikat Disetujui',
            data: [11, 7, 6, 9, 8],
            backgroundColor: ['#6366F1', '#22C55E', '#8B5CF6', '#F59E0B', '#06B6D4'],
            borderRadius: 6,
        }]
    },
    options: {
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true, ticks: { stepSize: 2 } } },
    }
});

// Grafik Tren Approval
new Chart(document.getElementById('trendChart'), {
    type: 'line',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt'],
        datasets: [{
            label: 'Jumlah Approval',
            data: [8, 9, 11, 12, 10, 13, 14, 12, 15, 17],
            borderColor: '#6366F1',
            backgroundColor: 'rgba(99,102,241,0.1)',
            fill: true,
            tension: 0.4,
        }]
    },
    options: {
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true },
            x: { grid: { display: false } }
        }
    }
});
</script>
@endsection
