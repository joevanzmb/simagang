@extends(Auth::user()->role === 'admin' ? 'layouts.app' : 'layouts.vp', ['noHeader' => true])

@section('pageTitle', 'Vice President Overview')
@section('pageSubtitle', 'Pantau aktivitas dan statistik approval oleh Vice President.')

@section('content')
<div class="space-y-10">

  <!-- 🔹 Header Ringkasan (tetap) -->
  <div class="grid md:grid-cols-3 gap-6">
    <div class="bg-gradient-to-br from-indigo-500 to-purple-600 p-6 rounded-2xl text-white shadow-lg">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-sm opacity-80">Total Approval</p>
          <h2 class="text-3xl font-bold mt-1">124</h2>
        </div>
        <i class="fas fa-check-circle text-3xl opacity-80"></i>
      </div>
      <p class="text-xs mt-3 opacity-80">Sertifikat disetujui oleh VP hingga bulan ini</p>
    </div>

    <div class="bg-gradient-to-br from-blue-500 to-cyan-500 p-6 rounded-2xl text-white shadow-lg">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-sm opacity-80">Pending Approval</p>
          <h2 class="text-3xl font-bold mt-1">18</h2>
        </div>
        <i class="fas fa-hourglass-half text-3xl opacity-80"></i>
      </div>
      <p class="text-xs mt-3 opacity-80">Menunggu review dari Vice President</p>
    </div>

    <div class="bg-gradient-to-br from-rose-500 to-red-500 p-6 rounded-2xl text-white shadow-lg">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-sm opacity-80">Ditolak</p>
          <h2 class="text-3xl font-bold mt-1">6</h2>
        </div>
        <i class="fas fa-times-circle text-3xl opacity-80"></i>
      </div>
      <p class="text-xs mt-3 opacity-80">Sertifikat tidak disetujui oleh VP</p>
    </div>
  </div>

  <!-- 📊 Statistik Approval (tetap) -->
  <div class="bg-white rounded-2xl shadow-md p-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
      <i class="fas fa-chart-line text-indigo-500"></i> Statistik Approval Bulanan
    </h3>
    <canvas id="approvalChart" height="120"></canvas>
  </div>

  <!-- ✅ Filter + Search (baru, baris kedua untuk search) -->
  <div class="bg-white rounded-2xl shadow-md p-6 space-y-4">
    <!-- Baris 1: Filter -->
    <div class="flex flex-wrap gap-4">
      <div>
        <label class="block text-sm font-medium text-gray-600 mb-1">Kampus</label>
        <select id="filterKampus" class="border border-gray-300 rounded-lg p-2 text-sm">
          <option value="all">Semua</option>
          <option>Universitas Airlangga</option>
          <option>ITS</option>
          <option>UB</option>
          <option>UNESA</option>
          <option>PENS</option>
          <option>UPN</option>
        </select>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-600 mb-1">Direktorat</label>
        <select id="filterDirektorat" class="border border-gray-300 rounded-lg p-2 text-sm">
          <option value="all">Semua</option>
          <option>Direktorat Utama</option>
          <option>Direktorat Operasi</option>
          <option>Direktorat Sales & Marketing</option>
          <option>Direktorat Finance & Business Support</option>
        </select>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-600 mb-1">Fungsi</label>
        <select id="filterFungsi" class="border border-gray-300 rounded-lg p-2 text-sm">
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
        <label class="block text-sm font-medium text-gray-600 mb-1">Status Approval</label>
        <select id="filterStatus" class="border border-gray-300 rounded-lg p-2 text-sm">
          <option value="all">Semua</option>
          <option>Menunggu</option>
          <option>Disetujui</option>
          <option>Ditolak</option>
        </select>
      </div>
    </div>

    <!-- Baris 2: Search kiri dan tidak melebar -->
    <div class="w-full md:w-1/3">
      <label class="block text-sm font-medium text-gray-600 mb-1">Cari Mahasiswa</label>
      <div class="relative">
        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
        <input type="text" id="searchInput" placeholder="Ketik nama..."
               class="pl-9 w-full border rounded-lg p-2 text-sm">
      </div>
    </div>
  </div>

  <!-- 📋 Daftar Sertifikat + Aksi Approve/Reject -->
  <div class="bg-white rounded-2xl shadow-md p-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-3 flex items-center gap-2">
      <i class="fas fa-file-signature text-indigo-500"></i> Daftar Sertifikat
    </h3>

    <div class="overflow-x-auto">
      <table class="min-w-full text-sm text-gray-700" id="approvalTable">
        <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
          <tr>
            <th class="px-4 py-3 text-left">Nama</th>
            <th class="px-4 py-3 text-left">Kampus</th>
            <th class="px-4 py-3 text-left">Direktorat</th>
            <th class="px-4 py-3 text-left">Fungsi</th>
            <th class="px-4 py-3 text-left">Status</th>
            <th class="px-4 py-3 text-center">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @php
          $data = [
            ['Joevanz Mikail','Universitas Airlangga','Direktorat Operasi','Supply Chain','Menunggu'],
            ['Siti Nurhaliza','ITS','Direktorat Utama','Human Capital','Disetujui'],
            ['Rizky Pratama','UB','Direktorat Sales & Marketing','Sales Strategy','Menunggu'],
            ['Gastin Maulana','UNESA','Direktorat Finance & Business Support','Finance & Accounting','Ditolak'],
            ['Yusril Hidayat','PENS','Direktorat Operasi','IT Support','Menunggu'],
            ['Dewi Anggraini','UPN','Direktorat Utama','Corporate Communication','Menunggu'],
          ];
          @endphp

          @foreach($data as $row)
          <tr class="border-b hover:bg-gray-50 transition">
            <td class="px-4 py-3">{{ $row[0] }}</td>
            <td class="px-4 py-3">{{ $row[1] }}</td>
            <td class="px-4 py-3">{{ $row[2] }}</td>
            <td class="px-4 py-3">{{ $row[3] }}</td>
            <td class="px-4 py-3 status-cell">
              @php
                $color = $row[4]=='Disetujui' ? 'bg-green-100 text-green-700' :
                         ($row[4]=='Ditolak' ? 'bg-rose-100 text-rose-600' :
                         'bg-yellow-100 text-yellow-700');
              @endphp
              <span class="px-3 py-1 rounded-full text-xs font-semibold status-badge {{ $color }}">{{ $row[4] }}</span>
            </td>
            <td class="px-4 py-3 text-center space-x-2">
              <button class="px-3 py-1 text-xs rounded-lg bg-green-500 text-white hover:bg-green-600 transition" onclick="approveStatus(this)">Approve</button>
              <button class="px-3 py-1 text-xs rounded-lg bg-red-500 text-white hover:bg-red-600 transition" onclick="rejectStatus(this)">Reject</button>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  <!-- 📋 Riwayat Aktivitas (tetap + now realtime append) -->
  <div class="bg-white rounded-2xl shadow-md p-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
      <i class="fas fa-history text-indigo-500"></i> Riwayat Aktivitas VP
    </h3>
    <div class="overflow-x-auto">
      <table class="min-w-full text-sm text-gray-700" id="historyTable">
        <thead>
          <tr class="bg-gray-100 text-gray-600 uppercase text-xs">
            <th class="px-4 py-3 text-left">Tanggal</th>
            <th class="px-4 py-3 text-left">Nama Mahasiswa</th>
            <th class="px-4 py-3 text-left">Aksi</th>
            <th class="px-4 py-3 text-left">Status</th>
          </tr>
        </thead>
        <tbody>
          <tr class="border-b hover:bg-gray-50 transition">
            <td class="px-4 py-3">20 Okt 2025</td>
            <td class="px-4 py-3">Rizky Pratama</td>
            <td class="px-4 py-3">Approval Sertifikat</td>
            <td class="px-4 py-3 text-green-600 font-semibold">Disetujui</td>
          </tr>
          <tr class="border-b hover:bg-gray-50 transition">
            <td class="px-4 py-3">18 Okt 2025</td>
            <td class="px-4 py-3">Yusril Hidayat</td>
            <td class="px-4 py-3">Approval Sertifikat</td>
            <td class="px-4 py-3 text-yellow-600 font-semibold">Menunggu</td>
          </tr>
          <tr class="border-b hover:bg-gray-50 transition">
            <td class="px-4 py-3">15 Okt 2025</td>
            <td class="px-4 py-3">Gastin Maulana</td>
            <td class="px-4 py-3">Approval Sertifikat</td>
            <td class="px-4 py-3 text-rose-600 font-semibold">Ditolak</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <!-- ✅ Toast -->
  <div id="toast" class="hidden fixed bottom-5 right-5 bg-indigo-600 text-white px-4 py-2 rounded-lg shadow-lg">
    ✅ Status diperbarui!
  </div>

</div>

<!-- ChartJS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Chart tetap
new Chart(document.getElementById('approvalChart'), {
  type: 'bar',
  data: {
    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt'],
    datasets: [{
      label: 'Sertifikat Disetujui',
      data: [10, 12, 8, 14, 9, 15, 17, 20, 18, 12],
      backgroundColor: '#6366F1',
      borderRadius: 6
    }, {
      label: 'Ditolak',
      data: [2, 1, 3, 1, 0, 2, 3, 1, 4, 2],
      backgroundColor: '#F43F5E',
      borderRadius: 6
    }]
  },
  options: {
    responsive: true,
    plugins: { legend: { position: 'bottom' } },
    scales: { y: { beginAtZero: true, ticks: { stepSize: 5 } } }
  }
});

// ---------- Aksi Approve / Reject (tanpa konfirmasi) + update history (C) ----------
function approveStatus(btn) {
  updateStatus(btn, 'Disetujui', 'bg-green-100 text-green-700');
}
function rejectStatus(btn) {
  updateStatus(btn, 'Ditolak', 'bg-rose-100 text-rose-600');
}

function updateStatus(btn, text, badgeClass) {
  const row = btn.closest('tr');
  const name = row.cells[0].textContent.trim();
  const badge = row.querySelector('.status-badge');
  badge.textContent = text;
  badge.className = `px-3 py-1 rounded-full text-xs font-semibold status-badge ${badgeClass}`;

  appendHistory(name, text); // ✅ tambahkan ke riwayat
  showToast();
}

// Tambah baris ke tabel Riwayat (realtime)
function appendHistory(nama, status) {
  const tbody = document.querySelector('#historyTable tbody');
  const tr = document.createElement('tr');
  tr.className = 'border-b hover:bg-gray-50 transition';

  const now = new Date();
  const opts = { day: '2-digit', month: 'short', year: 'numeric' };
  const tanggal = now.toLocaleDateString('id-ID', opts).replace('.', '');

  const statusClass =
    status === 'Disetujui' ? 'text-green-600' :
    status === 'Ditolak'   ? 'text-rose-600'  : 'text-yellow-600';

  tr.innerHTML = `
    <td class="px-4 py-3">${tanggal}</td>
    <td class="px-4 py-3">${nama}</td>
    <td class="px-4 py-3">Approval Sertifikat</td>
    <td class="px-4 py-3 ${statusClass} font-semibold">${status}</td>
  `;
  // prepend ke atas
  tbody.insertBefore(tr, tbody.firstChild);
}

// Toast
function showToast() {
  const toast = document.getElementById('toast');
  toast.classList.remove('hidden');
  setTimeout(() => toast.classList.add('hidden'), 1800);
}

// ---------- Filtering + Search ----------
const $f = id => document.getElementById(id);
['filterKampus','filterDirektorat','filterFungsi','filterStatus'].forEach(id => {
  $f(id).addEventListener('change', applyFilters);
});
$f('searchInput').addEventListener('input', applyFilters);

function applyFilters() {
  const kampus = $f('filterKampus').value.toLowerCase();
  const direktorat = $f('filterDirektorat').value.toLowerCase();
  const fungsi = $f('filterFungsi').value.toLowerCase();
  const status = $f('filterStatus').value.toLowerCase();
  const search = $f('searchInput').value.toLowerCase();

  document.querySelectorAll('#approvalTable tbody tr').forEach(tr => {
    const text = tr.innerText.toLowerCase();
    tr.style.display =
      (kampus === 'all'     || text.includes(kampus))     &&
      (direktorat === 'all' || text.includes(direktorat)) &&
      (fungsi === 'all'     || text.includes(fungsi))     &&
      (status === 'all'     || text.includes(status))     &&
      text.includes(search)
      ? '' : 'none';
  });
}
</script>
@endsection
