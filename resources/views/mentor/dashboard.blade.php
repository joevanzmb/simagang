@extends('layouts.mentor', ['noHeader' => true])

@section('pageTitle', 'Dashboard Mentor')
@section('pageSubtitle', 'Ringkasan aktivitas mahasiswa bimbingan')

@section('content')

<!-- Header -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center text-white p-5 sm:p-7 rounded-2xl shadow-lg gap-4 sm:gap-6 mb-6 sm:mb-8 animate-fade-in"
    style="background: linear-gradient(135deg, #5a6de0 0%, #6c3fb0 100%);">

    <div>
        <h2 class="text-2xl font-bold flex items-center gap-5 leading-tight">
            <i class="fas fa-chalkboard-teacher text-4xl"></i> Dashboard Mentor
        </h2>
        <p class="text-sm text-white/80 mt-2">Pantau progres bimbingan, presensi, laporan, dan penilaian secara ringkas.</p>
    </div>

    <!-- Reminder Dropdown -->
    <div class="relative">
      <button onclick="toggleReminder()" 
          class="px-4 sm:px-5 py-2 bg-white/20 hover:bg-white/30 rounded-lg text-white font-medium flex items-center gap-2 transition-all duration-200 hover:scale-[1.03] relative">
          <i class="fas fa-bell text-lg sm:text-base"></i>
          <span class="hidden sm:inline">Reminder</span>
          <span class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full animate-pulse"></span>
      </button>
    
      <!-- Dropdown Content -->
      <div id="reminderDropdown" 
           class="hidden absolute right-0 sm:right-0 mt-3 w-[90vw] sm:w-72 bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden z-50 max-w-sm sm:max-w-none">
          <div class="p-4 text-sm text-gray-700">
              <p class="font-semibold text-gray-800 mb-3 text-center sm:text-left">Pengingat Hari Ini</p>
              <ul class="space-y-2">
                  <li class="flex items-center gap-2 text-xs sm:text-sm">
                      <i class="fas fa-star text-yellow-500"></i> 
                      <span class="badge-item">4 mahasiswa belum dinilai</span>
                  </li>
                  <li class="flex items-center gap-2 text-xs sm:text-sm">
                      <i class="fas fa-file-alt text-purple-500"></i> 
                      <span class="badge-item">3 laporan menunggu review</span>
                  </li>
                  <li class="flex items-center gap-2 text-xs sm:text-sm">
                      <i class="fas fa-calendar-check text-green-500"></i> 
                      <span class="badge-item">Presensi hari ini 10/12</span>
                  </li>
              </ul>
          </div>
          <div class="bg-gray-50 px-4 py-3">
              <button onclick="openDetail()" class="w-full text-center text-xs sm:text-sm font-medium px-3 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition">Lihat Detail</button>
          </div>
      </div>
    </div>

<style>
@media (max-width: 640px) {
  #reminderDropdown {
    left: 50% !important;
    transform: translateX(-50%);
  }
}
</style>

</div>



<!-- KPI Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8 animate-fade-in">
  <button class="stat-card kpi-btn bg-blue-50 rounded-xl p-6 shadow-lg relative overflow-hidden text-left" data-target="#sectionMahasiswa">
      <div class="absolute right-4 bottom-4 text-blue-300 text-6xl opacity-20"><i class="fas fa-users"></i></div>
      <p class="text-sm text-gray-600">Mahasiswa Bimbingan</p>
      <p id="kpiMahasiswa" class="text-4xl font-bold text-gray-800 mt-2">12</p>
      <p class="text-xs text-green-600 mt-2">+2 dibanding bulan lalu</p>
  </button>

  <button class="stat-card kpi-btn bg-green-50 rounded-xl p-6 shadow-lg relative overflow-hidden text-left" data-target="#sectionPresensi">
      <div class="absolute right-4 bottom-4 text-green-300 text-6xl opacity-20"><i class="fas fa-calendar-check"></i></div>
      <p class="text-sm text-gray-600">Presensi Hari Ini</p>
      <p id="kpiPresensi" class="text-4xl font-bold text-gray-800 mt-2">10</p>
      <p class="text-xs text-gray-500 mt-2">2 izin, 0 alfa</p>
  </button>

  <button class="stat-card kpi-btn bg-purple-50 rounded-xl p-6 shadow-lg relative overflow-hidden text-left" data-target="#sectionLaporan">
      <div class="absolute right-4 bottom-4 text-purple-300 text-6xl opacity-20"><i class="fas fa-file-alt"></i></div>
      <p class="text-sm text-gray-600">Laporan Akhir</p>
      <p id="kpiLaporan" class="text-4xl font-bold text-gray-800 mt-2">8</p>
      <p class="text-xs text-purple-600 mt-2">Butuh review 3 laporan</p>
  </button>

  <button class="stat-card kpi-btn bg-yellow-50 rounded-xl p-6 shadow-lg relative overflow-hidden text-left" data-target="#sectionPenilaian">
      <div class="absolute right-4 bottom-4 text-yellow-300 text-6xl opacity-20"><i class="fas fa-star"></i></div>
      <p class="text-sm text-gray-600">Penilaian Pending</p>
      <p id="kpiPenilaian" class="text-4xl font-bold text-gray-800 mt-2">4</p>
      <div class="w-full bg-gray-200 rounded-full h-2 mt-3 overflow-hidden">
          <div id="kpiPenilaianBar" class="h-2 bg-indigo-500 rounded-full" style="width: 70%"></div>
      </div>
      <p class="text-xs text-gray-500 mt-1">70% mahasiswa sudah dinilai</p>
  </button>
</div>

<!-- Quick Actions -->
<div class="grid grid-cols-2 sm:flex sm:flex-wrap gap-3 mb-8 animate-fade-in">
    <a href="{{ route('mentor.penilaian') ?? './penilaian' }}" class="px-4 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white text-sm flex items-center gap-2 shadow">
        <i class="fas fa-clipboard-check"></i> Lakukan Penilaian
    </a>
    <a href="{{ route('mentor.laporan') ?? './laporan' }}" class="px-4 py-2 rounded-lg bg-purple-600 hover:bg-purple-700 text-white text-sm flex items-center gap-2 shadow">
        <i class="fas fa-file-alt"></i> Review Laporan
    </a>
    <a href="{{ route('mentor.mahasiswa') ?? './mahasiswa' }}" class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-sm flex items-center gap-2 shadow">
        <i class="fas fa-users"></i> Kelola Mahasiswa
    </a>
</div>

<!-- Charts & Activity -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 animate-fade-in">
    <!-- Presensi Line -->
    <div id="sectionPresensi" class="bg-white p-6 rounded-xl shadow-lg">
        <div class="flex items-center justify-between mb-3">
          <h3 class="text-lg font-semibold text-gray-800">Statistik Presensi Mingguan</h3>
          <div class="text-xs text-gray-500">Sen–Jum</div>
        </div>
        <div class="chart-wrap h-[280px]">
            <canvas id="presensiChart"></canvas>
        </div>
    </div>

    <!-- Penilaian Doughnut -->
    <div id="sectionPenilaian" class="bg-white p-6 rounded-xl shadow-lg">
        <div class="flex items-center justify-between mb-3">
          <h3 class="text-lg font-semibold text-gray-800 mb-4">Status Penilaian Mahasiswa</h3>
          <a href="{{ route('mentor.penilaian') }}" class="text-sm text-indigo-600 hover:text-indigo-700">Lihat detail</a>
        </div>
        <div class="chart-wrap h-[280px]">
            <canvas id="penilaianChart"></canvas>
        </div>
    </div>

    <!-- Radar Nilai per Aspek -->
    <div id="sectionPenilaian" class="bg-white p-6 rounded-xl shadow-lg">
        <div class="flex items-center justify-between mb-3">
            <h3 class="text-lg font-semibold text-gray-800">Rata-rata Nilai per Aspek</h3>
            <a href="{{ route('mentor.penilaian') }}" class="text-sm text-indigo-600 hover:text-indigo-700">Lihat detail</a>
        </div>
        <div class="chart-wrap h-[300px]">
            <canvas id="radarPenilaianChart"></canvas>
        </div>
    </div>
    
    <!-- Status Magang -->
    <div id="sectionMahasiswa" class="bg-white p-6 rounded-xl shadow-lg">
        <div class="flex items-center justify-between mb-3">
            <h3 class="text-lg font-semibold text-gray-800">Status Mahasiswa Bimbingan</h3>
            <a href="{{ route('mentor.mahasiswa') }}" class="text-sm text-indigo-600 hover:text-indigo-700">Lihat semua</a>
        </div>
        <div class="chart-wrap h-[280px]">
            <canvas id="statusMahasiswaChart"></canvas>
        </div>
    </div>


    <!-- Aktivitas & Pending Lists -->
    <div class="bg-white p-6 rounded-xl shadow-lg">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Aktivitas Terbaru</h3>
        <ul class="space-y-4">
            <li class="flex items-start space-x-3">
                <div class="w-10 h-10 flex items-center justify-center bg-blue-100 text-blue-600 rounded-full">
                    <i class="fas fa-user-check"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-800">Ahmad Fauzi melakukan check-in</p>
                    <p class="text-xs text-gray-500">08:05 • Surabaya</p>
                </div>
            </li>
            <li class="flex items-start space-x-3">
                <div class="w-10 h-10 flex items-center justify-center bg-yellow-100 text-yellow-600 rounded-full">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-800">Siti Nurhaliza mengumpulkan laporan akhir</p>
                    <p class="text-xs text-gray-500">Kemarin • 15:30</p>
                </div>
            </li>
            <li class="flex items-start space-x-3">
                <div class="w-10 h-10 flex items-center justify-center bg-green-100 text-green-600 rounded-full">
                    <i class="fas fa-star"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-800">Budi Santoso telah dinilai</p>
                    <p class="text-xs text-gray-500">2 hari lalu</p>
                </div>
            </li>
        </ul>
    </div>

    <div id="sectionLaporan" class="bg-white p-6 rounded-2xl shadow-lg">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Pending Tindakan</h3>
            <div class="text-xs text-gray-500">Prioritas</div>
        </div>
        <div class="space-y-3">
            <!-- List item -->
            <div class="flex items-center justify-between p-3 border rounded-xl hover:bg-gray-50 transition">
                <div class="flex items-center gap-3">
                    <span class="w-2.5 h-2.5 rounded-full bg-yellow-400"></span>
                    <div>
                        <p class="text-sm font-medium text-gray-800">4 Mahasiswa belum dinilai</p>
                        <p class="text-xs text-gray-500">Batas evaluasi Minggu ini</p>
                    </div>
                </div>
                <button onclick="openDetail()" class="px-3 py-1.5 text-xs bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg">Detail</button>
            </div>
            <div class="flex items-center justify-between p-3 border rounded-xl hover:bg-gray-50 transition">
                <div class="flex items-center gap-3">
                    <span class="w-2.5 h-2.5 rounded-full bg-purple-500"></span>
                    <div>
                        <p class="text-sm font-medium text-gray-800">3 Laporan menunggu review</p>
                        <p class="text-xs text-gray-500">Week 4–5</p>
                    </div>
                </div>
                <a href="{{ route('mentor.laporan') ?? './laporan' }}" class="px-3 py-1.5 text-xs bg-purple-600 hover:bg-purple-700 text-white rounded-lg">Tinjau</a>
            </div>
            <div class="flex items-center justify-between p-3 border rounded-xl hover:bg-gray-50 transition">
                <div class="flex items-center gap-3">
                    <span class="w-2.5 h-2.5 rounded-full bg-green-500"></span>
                    <div>
                        <p class="text-sm font-medium text-gray-800">Rekap presensi bulanan</p>
                        <p class="text-xs text-gray-500">Siap diunduh</p>
                    </div>
                </div>
                <button class="px-3 py-1.5 text-xs bg-green-600 hover:bg-green-700 text-white rounded-lg">Export</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL DETAIL REMINDER -->
<div id="detailModal" class="hidden fixed inset-0 bg-black/60 flex items-center justify-center z-50 backdrop-blur-sm">
  <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-lg relative animate-fade-in">
    <button onclick="closeDetail()" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
      <i class="fas fa-times"></i>
    </button>

    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white px-6 py-3 rounded-t-2xl flex items-center gap-2 shadow-sm mb-6 -mx-8 -mt-8">
      <i class="fas fa-bell"></i>
      <h3 class="text-lg font-semibold tracking-wide">Detail Pengingat</h3>
    </div>

    <div class="space-y-5">
      <div class="bg-indigo-50 p-4 rounded-xl border border-indigo-100">
        <h4 class="font-semibold text-indigo-700 mb-2 flex items-center gap-2">
          <i class="fas fa-star text-indigo-500"></i> Mahasiswa Belum Dinilai
        </h4>
        <ul class="list-disc list-inside text-sm text-gray-700 space-y-1">
          <li>Ahmad Fauzi</li>
          <li>Siti Nurhaliza</li>
          <li>Budi Santoso</li>
          <li>Indah Pratiwi</li>
        </ul>
      </div>

      <div class="bg-purple-50 p-4 rounded-xl border border-purple-100">
        <h4 class="font-semibold text-purple-700 mb-2 flex items-center gap-2">
          <i class="fas fa-file-alt text-purple-500"></i> Laporan Menunggu Review
        </h4>
        <ul class="list-disc list-inside text-sm text-gray-700 space-y-1">
          <li>Week 4 - Siti Nurhaliza</li>
          <li>Week 5 - Ahmad Fauzi</li>
          <li>Week 5 - Budi Santoso</li>
        </ul>
      </div>
    </div>

    <div class="flex justify-end mt-6">
      <button onclick="closeDetail()" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg text-sm font-medium">Tutup</button>
    </div>
  </div>
</div>

<style>
@keyframes fade-in { from { opacity: 0; transform: translateY(10px);} to { opacity: 1; transform: translateY(0);} }
.animate-fade-in { animation: fade-in 0.5s ease-out; }

.stat-card { transition: all 0.25s ease; }
.stat-card:hover { transform: translateY(-5px); box-shadow: 0 12px 24px rgba(99,102,241,0.15); }

.chart-wrap canvas { width: 100% !important; height: 100% !important; display: block; }



.kpi-btn:focus { outline: 2px solid rgba(99,102,241,0.5); outline-offset: 3px; }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
/* ---------- UI Controls ---------- */
function toggleReminder() {
  const dropdown = document.getElementById('reminderDropdown');
  dropdown.classList.toggle('hidden');
  document.addEventListener('click', function handler(e) {
    if (!dropdown.contains(e.target) && !e.target.closest('button[onclick="toggleReminder()"]')) {
      dropdown.classList.add('hidden');
      document.removeEventListener('click', handler);
    }
  });
}
function openDetail() { document.getElementById('detailModal').classList.remove('hidden'); }
function closeDetail() { document.getElementById('detailModal').classList.add('hidden'); }

document.querySelectorAll('.kpi-btn').forEach(btn=>{
  btn.addEventListener('click', ()=>{
    const target = btn.getAttribute('data-target');
    if (target && document.querySelector(target)) document.querySelector(target).scrollIntoView({behavior:'smooth', block:'start'});
  });
});



/* ---------- Charts ---------- */
const ctxPresensi = document.getElementById('presensiChart');
const ctxPenilaian = document.getElementById('penilaianChart');
const ctxRadar = document.getElementById('radarPenilaianChart');
const ctxStatus = document.getElementById('statusMahasiswaChart');

const presensiChart = new Chart(ctxPresensi, {
  type: 'line',
  data: {
    labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum'],
    datasets: [
      { label: 'Hadir', data: [10,11,9,10,12], borderColor: '#6366F1', backgroundColor: 'rgba(99,102,241,0.15)', tension: 0.4, fill: true },
      { label: 'Izin', data: [1,0,2,1,0], borderColor: '#A855F7', backgroundColor: 'rgba(168,85,247,0.15)', tension: 0.4, fill: true },
      { label: 'Alfa', data: [0,1,0,0,1], borderColor: '#F43F5E', backgroundColor: 'rgba(244,63,94,0.15)', tension: 0.4, fill: true }
    ]
  },
  options: {
    responsive: true, maintainAspectRatio: false,
    animation: { duration: 900, easing: 'easeOutQuart' },
    plugins: { legend: { position: 'bottom' }, tooltip: { mode: 'index', intersect: false } },
    scales: { y: { beginAtZero: true } }
  }
});

const penilaianChart = new Chart(ctxPenilaian, {
  type: 'doughnut',
  data: {
    labels: ['Sudah Dinilai', 'Belum Dinilai'],
    datasets: [{ data: [8, 4], backgroundColor: ['#6366F1', '#FACC15'], borderWidth: 3 }]
  },
  options: {
    responsive: true, maintainAspectRatio: false,
    animation: { duration: 900, easing: 'easeOutQuart' },
    cutout: '68%',
    plugins: { legend: { position: 'bottom' } }
  }
});

const radarPenilaianChart = new Chart(ctxRadar, {
  type: 'radar',
  data: {
    labels: ['Integritas', 'Komunikasi', 'Kerjasama', 'Disiplin', 'Teknis'],
    datasets: [{
      label: 'Rata-rata Nilai',
      data: [88, 92, 85, 90, 87],
      backgroundColor: 'rgba(99,102,241,0.25)',
      borderColor: '#6366F1',
      borderWidth: 2,
      pointBackgroundColor: '#6366F1'
    }]
  },
  options: {
    responsive: true, maintainAspectRatio: false,
    scales: { r: { beginAtZero: true, max: 100, ticks: { display: false }, grid: { color: '#e5e7eb' } } },
    plugins: { legend: { position: 'bottom' } }
  }
});

const statusMahasiswaChart = new Chart(ctxStatus, {
  type: 'pie',
  data: {
    labels: ['PKL', 'Internship'],
    datasets: [{
      data: [8, 4], // nanti diisi dari database
      backgroundColor: ['#60A5FA', '#A78BFA'],
      borderColor: '#ffffff',
      borderWidth: 2
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: {
        position: 'bottom'
      },
      tooltip: {
        callbacks: {
          label: (ctx) => `${ctx.label}: ${ctx.parsed} Mahasiswa`
        }
      }
    }
  }
});

/* ---------- Helper agar mudah update dengan data API nantinya ---------- */
function updateAllWithData(payload) {
  // payload = { kpi:{...}, presensi:{labels, datasets}, penilaian:{...}, radar:{...}, progress:{...} }
  if (payload?.kpi) {
    const { mahasiswa, presensi, laporan, pending, dinilaiPct } = payload.kpi;
    if (mahasiswa!=null) document.getElementById('kpiMahasiswa').innerText = mahasiswa;
    if (presensi!=null) document.getElementById('kpiPresensi').innerText = presensi;
    if (laporan!=null) document.getElementById('kpiLaporan').innerText = laporan;
    if (pending!=null) document.getElementById('kpiPenilaian').innerText = pending;
    if (dinilaiPct!=null) document.getElementById('kpiPenilaianBar').style.width = dinilaiPct + '%';
  }
  if (payload?.presensi) { presensiChart.data = payload.presensi; presensiChart.update(); }
  if (payload?.penilaian) { penilaianChart.data = payload.penilaian; penilaianChart.update(); }
  if (payload?.radar) { radarPenilaianChart.data = payload.radar; radarPenilaianChart.update(); }
  if (payload?.progress) { progressBarChart.data = payload.progress; progressBarChart.update(); }
}
</script>

@endsection
