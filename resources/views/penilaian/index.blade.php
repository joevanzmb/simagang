@extends('layouts.app', ['noHeader' => true])

@section('pageTitle', 'Data Penilaian Mahasiswa')
@section('pageSubtitle', 'Pantau seluruh hasil evaluasi magang dari mentor secara terpusat.')

@section('content')
<div class="space-y-10 animate-fade-in max-w-[1600px] mx-auto">

  <!-- Header -->
  <div class="flex flex-col md:flex-row justify-between items-center text-white p-7 rounded-2xl shadow-lg"
      style="background: linear-gradient(135deg, #5a6de0 0%, #6c3fb0 100%);">
      <div>
          <h2 class="text-2xl font-bold flex items-center gap-4 leading-tight">
              <i class="fas fa-star text-3xl"></i> Data Penilaian Mahasiswa
          </h2>
          <p class="text-sm text-white/80 mt-1">Kelola dan analisis hasil penilaian magang seluruh mahasiswa.</p>
      </div>
      <button class="px-5 py-2.5 bg-white/20 hover:bg-white/30 rounded-lg text-white font-medium flex items-center gap-2 transition-all duration-200 hover:scale-[1.03]">
          <i class="fas fa-file-pdf"></i> Unduh Rekap Penilaian
      </button>
  </div>

  <!-- Statistik Ringkas -->
  <div class="grid md:grid-cols-3 gap-6">
      @php
        $stats = [
          ['icon' => 'fa-users', 'label' => 'Total Mahasiswa Dinilai', 'value' => 72, 'color' => 'indigo'],
          ['icon' => 'fa-chart-line', 'label' => 'Rata-rata Nilai Keseluruhan', 'value' => '87.4', 'color' => 'green'],
          ['icon' => 'fa-user-tie', 'label' => 'Mentor Aktif', 'value' => 12, 'color' => 'purple']
        ];
      @endphp

      @foreach($stats as $s)
      <div class="bg-white rounded-2xl shadow hover:shadow-md transition-all p-6 text-center group">
          <div class="flex justify-center mb-3">
              <div class="w-12 h-12 flex items-center justify-center rounded-full bg-{{ $s['color'] }}-100 text-{{ $s['color'] }}-600 group-hover:scale-110 transition">
                  <i class="fas {{ $s['icon'] }} text-xl"></i>
              </div>
          </div>
          <p class="text-sm text-gray-500">{{ $s['label'] }}</p>
          <h3 class="text-2xl font-bold text-{{ $s['color'] }}-600 mt-1">{{ $s['value'] }}</h3>
      </div>
      @endforeach
  </div>

  <!-- Grafik Section -->
  <div class="grid lg:grid-cols-2 gap-6">
      <div class="bg-white rounded-2xl shadow-lg p-6">
          <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
              <i class="fas fa-chart-line"></i> Rata-rata Nilai Mahasiswa per Mentor
          </h3>
          <div class="h-[280px]">
            <canvas id="grafikMentor"></canvas>
          </div>
      </div>

      <div class="bg-white rounded-2xl shadow-lg p-6">
          <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
              <i class="fas fa-chart-pie"></i> Status Penilaian Keseluruhan
          </h3>
          <div class="h-[280px]">
            <canvas id="grafikStatus"></canvas>
          </div>
      </div>
  </div>

    <!-- Filter & Tabel -->
    <div class="bg-white rounded-2xl shadow-lg p-6">
    
        <!-- ✅ Baris Pertama Filter -->
        <div class="flex flex-wrap gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Kampus</label>
                <select id="filterKampus" class="border border-gray-300 rounded-lg p-2 text-sm focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">
                    <option value="all">Semua</option>
                    <option>Universitas Airlangga</option>
                    <option>ITS</option>
                    <option>UPN</option>
                    <option>PENS</option>
                    <option>UB</option>
                    <option>UNESA</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Jurusan</label>
                <select id="filterJurusan" class="border border-gray-300 rounded-lg p-2 text-sm focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">
                    <option value="all">Semua</option>
                    <option>Psikologi</option>
                    <option>Teknik Informatika</option>
                    <option>Manajemen</option>
                    <option>Akuntansi</option>
                    <!-- tambahkan opsi lain -->
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Status Magang</label>
                <select id="filterStatusMagang" class="border border-gray-300 rounded-lg p-2 text-sm focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">
                    <option value="all">Semua</option>
                    <option>PKL</option>
                    <option>Internship</option>
                </select>
            </div>

    
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Mentor</label>
                <select id="filterMentor" class="border border-gray-300 rounded-lg p-2 text-sm focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">
                    <option value="all">Semua</option>
                    <option>Andi Saputra</option>
                    <option>Sri Wahyuni</option>
                    <option>Bambang Adi</option>
                </select>
            </div>
    
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Direktorat</label>
                <select id="filterDirektorat" class="border border-gray-300 rounded-lg p-2 text-sm focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">
                    <option value="all">Semua</option>
                    <option>Direktorat Utama</option>
                    <option>Direktorat Operasi</option>
                    <option>Direktorat Sales & Marketing</option>
                    <option>Direktorat Finance & Business Support</option>
                </select>
            </div>
    
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Fungsi</label>
                <select id="filterFungsi" class="border border-gray-300 rounded-lg p-2 text-sm focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">
                    <option value="all">Semua</option>
                    <option>Human Capital</option>
                    <option>Training & Development</option>
                    <option>Sales Strategy</option>
                    <option>Supply Chain</option>
                    <option>Finance & Accounting</option>
                    <option>IT Support</option>
                    <option>Corporate Communication</option>
                </select>
            </div>
    
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Status Penilaian</label>
                <select id="filterStatus" class="border border-gray-300 rounded-lg p-2 text-sm focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">
                    <option value="all">Semua</option>
                    <option>Sudah Dinilai</option>
                    <option>Belum Dinilai</option>
                </select>
            </div>
        </div>
    
        <!-- ✅ Baris Kedua — Search Nama -->
        <div class="w-full md:w-1/3 mb-6">
            <label class="block text-sm font-medium text-gray-600 mb-1">Cari Nama</label>
            <div class="relative">
                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                <input type="text" id="searchInput" placeholder="Cari nama mahasiswa..."
                    class="pl-9 w-full border border-gray-300 rounded-lg p-2 text-sm focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">
            </div>
        </div>


      <!-- Tabel -->
        <!-- Tabel -->
        <div class="rounded-xl border border-gray-200">
            <div class="overflow-x-auto w-full">
                <table class="min-w-full text-sm text-gray-700" id="tablePenilaian">
                    <thead class="bg-gray-100 text-gray-800">
                        <tr>
                            <th class="px-4 py-2 text-left font-semibold">Nama Mahasiswa</th>
                            <th class="px-4 py-2 text-left font-semibold">Kampus</th>
                            <th class="px-4 py-2 text-left font-semibold">Jurusan</th>
                            <th class="px-4 py-2 text-left font-semibold">Status Magang</th>
                            <th class="px-4 py-2 text-left font-semibold">Direktorat</th>
                            <th class="px-4 py-2 text-left font-semibold">Fungsi</th>
                            <th class="px-4 py-2 text-left font-semibold">Mentor</th>
                            <th class="px-4 py-2 text-center font-semibold">Nilai Akhir</th>
                            <th class="px-4 py-2 text-center font-semibold">Kategori</th>
                            <th class="px-4 py-2 text-center font-semibold">Status</th>
                            <th class="px-4 py-2 text-center font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                    @php
                        $penilaian = [
                            ['Joevanz Mikail','Universitas Airlangga','Psikologi','PKL','Direktorat Utama','Human Capital','Andi Saputra','90','Sangat Memuaskan','Sudah Dinilai'],
                            ['Siti Nurhaliza','ITS','Teknik Informatika','Internship','Direktorat Sales & Marketing','Sales Strategy','Sri Wahyuni','92','Sangat Memuaskan','Sudah Dinilai'],
                            ['Bagus Setiawan','PENS','Elektro','PKL','Direktorat Operasi','Supply Chain','Andi Saputra','88','Sangat Memuaskan','Sudah Dinilai'],
                            ['Alya Rahma','UB','Manajemen','Internship','Direktorat Finance & Business Support','Finance & Accounting','Bambang Adi','75','Memuaskan','Sudah Dinilai'],
                            ['Rizky Hidayat','UNESA','Teknik Informatika','PKL','Direktorat Operasi','IT Support','Andi Saputra','-','-','Belum Dinilai'],
                        ];
                    @endphp
        
                    @foreach ($penilaian as $p)
                    <tr class="hover:bg-indigo-50 transition">
                        <td class="px-4 py-2 font-medium">{{ $p[0] }}</td>
                        <td class="px-4 py-2">{{ $p[1] }}</td>
                        <td class="px-4 py-2">{{ $p[2] }}</td>
                        <td class="px-4 py-2">{{ $p[3] }}</td>
                        <td class="px-4 py-2">{{ $p[4] }}</td>
                        <td class="px-4 py-2">{{ $p[5] }}</td>
                        <td class="px-4 py-2">{{ $p[6] }}</td>
                        <td class="px-4 py-2 text-center font-semibold text-indigo-600">{{ $p[7] }}</td>
                        <td class="px-4 py-2 text-center">
                            @php
                                $kategoriBadge = match($p[8]) {
                                    'Sangat Memuaskan' => 'bg-green-100 text-green-700',
                                    'Memuaskan' => 'bg-blue-100 text-blue-700',
                                    default => 'bg-gray-100 text-gray-500'
                                };
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $kategoriBadge }}">{{ $p[8] }}</span>
                        </td>
                        <td class="px-4 py-2 text-center">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $p[9] == 'Sudah Dinilai' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                {{ $p[9] }}
                            </span>
                        </td>
                        <td class="px-4 py-2 text-center space-x-2">
                            <button class="px-3 py-1 text-xs rounded-lg bg-indigo-500 text-white hover:bg-indigo-600 transition">
                                <i class="fas fa-eye mr-1"></i> Lihat
                            </button>
                            <button class="px-3 py-1 text-xs rounded-lg bg-red-500 text-white hover:bg-red-600 transition">
                                <i class="fas fa-trash mr-1"></i> Hapus
                            </button>
                        </td>
                    </tr>
                    @endforeach
                    
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<style>
@keyframes fadeIn { from { opacity: 0; transform: translateY(10px);} to { opacity: 1; transform: translateY(0);} }
.animate-fade-in { animation: fadeIn 0.3s ease-out; }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Grafik Mentor
new Chart(document.getElementById('grafikMentor'), {
  type: 'bar',
  data: {
    labels: ['Andi Saputra', 'Sri Wahyuni', 'Bambang Adi', 'Rina Kusuma', 'Hendri Wijaya'],
    datasets: [{
      label: 'Rata-rata Nilai',
      data: [89, 91, 84, 88, 86],
      backgroundColor: 'rgba(99,102,241,0.8)',
      borderRadius: 8
    }]
  },
  options: {
    scales: { y: { beginAtZero: true, max: 100 } },
    plugins: { legend: { display: false } },
    responsive: true,
    maintainAspectRatio: false
  }
});

// Grafik Status
new Chart(document.getElementById('grafikStatus'), {
  type: 'doughnut',
  data: {
    labels: ['Sudah Dinilai', 'Belum Dinilai'],
    datasets: [{
      data: [72, 8],
      backgroundColor: ['#22c55e', '#facc15'],
      borderWidth: 3
    }]
  },
  options: {
    plugins: { legend: { position: 'bottom' } },
    cutout: '65%',
    responsive: true,
    maintainAspectRatio: false
  }
});

// ✅ Live Filtering
function filterData() {
    const kampus = document.getElementById('filterKampus').value.toLowerCase
    const jurusan = document.getElementById('filterJurusan').value.toLowerCase();
    const statusMagang = document.getElementById('filterStatusMagang').value.toLowerCase();
    const mentor = document.getElementById('filterMentor').value.toLowerCase();
    const direktorat = document.getElementById('filterDirektorat').value.toLowerCase();
    const fungsi = document.getElementById('filterFungsi').value.toLowerCase();
    const status = document.getElementById('filterStatus').value.toLowerCase();
    const search = document.getElementById('searchInput').value.toLowerCase();

    document.querySelectorAll('#tablePenilaian tbody tr').forEach(row => {
        const text = row.innerText.toLowerCase();
        row.style.display =
            (kampus === 'all' || text.includes(kampus)) &&
            (mentor === 'all' || text.includes(mentor)) &&
            (direktorat === 'all' || text.includes(direktorat)) &&
            (fungsi === 'all' || text.includes(fungsi)) &&
            (status === 'all' || text.includes(status)) &&
            (jurusan === 'all' || text.includes(jurusan)) &&
            (statusMagang === 'all' || text.includes(statusMagang)) &&
            text.includes(search)

            ? '' : 'none';
    });
}

document.querySelectorAll(
  '#filterKampus, #filterMentor, #filterDirektorat, #filterFungsi, #filterStatus, #filterJurusan, #filterStatusMagang'
).forEach(s => s.addEventListener('change', filterData));


document.getElementById('searchInput').addEventListener('input', filterData);
</script>
@endsection
