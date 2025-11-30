@extends('layouts.app', ['noHeader' => true])

@section('pageTitle', 'Manajemen Presensi')
@section('pageSubtitle', 'Pantau dan ubah status kehadiran mahasiswa dengan interaktif')

@section('content')
<div class="space-y-10 max-w-[1600px] mx-auto">

    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-center text-white p-7 rounded-2xl shadow-lg"
        style="background: linear-gradient(135deg, #5a6de0 0%, #6c3fb0 100%);">
        <div>
            <h2 class="text-2xl font-bold flex items-center gap-5 leading-tight">
                <i class="fas fa-calendar-check text-4xl"></i> Presensi Mahasiswa
            </h2>
            <p class="text-sm text-white/80 mt-2">Kelola dan pantau seluruh aktivitas kehadiran mahasiswa magang</p>
        </div>
        <button class="px-5 py-2 bg-white/20 hover:bg-white/30 rounded-lg text-white font-medium flex items-center gap-2 transition-all duration-200 hover:scale-[1.03]">
            <i class="fas fa-download"></i> Unduh Rekap Presensi
        </button>
    </div>

    <!-- Statistik Ringkas -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @php
            $cards = [
                ['label' => 'Total Mahasiswa', 'value' => 48, 'color' => 'indigo', 'icon' => 'fa-users'],
                ['label' => 'Hadir Hari Ini', 'value' => 31, 'color' => 'green', 'icon' => 'fa-user-check'],
                ['label' => 'Izin Hari Ini', 'value' => 9, 'color' => 'yellow', 'icon' => 'fa-user-clock'],
                ['label' => 'Alfa Hari Ini', 'value' => 8, 'color' => 'red', 'icon' => 'fa-user-times'],
            ];
        @endphp

        @foreach ($cards as $c)
        <div class="bg-{{ $c['color'] }}-50 p-6 rounded-2xl shadow hover:shadow-xl transition group">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium text-{{ $c['color'] }}-700">{{ $c['label'] }}</h3>
                    <p class="text-3xl font-bold text-{{ $c['color'] }}-600 mt-1">{{ $c['value'] }}</p>
                </div>
                <div class="bg-{{ $c['color'] }}-100 text-{{ $c['color'] }}-600 rounded-full p-3 shadow-inner group-hover:scale-110 transition">
                    <i class="fas {{ $c['icon'] }}"></i>
                </div>
            </div>
        </div>
        @endforeach
    </div>

   
        
        
    <!-- Tabel Presensi + Filter di dalam satu card -->
    <div class="bg-white rounded-2xl shadow-lg p-6">
    
        <!-- Header Title -->
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                <i class="fas fa-table"></i> Rekap Presensi Seluruh Mahasiswa
            </h3>
        </div>
    
        <!-- ✅ Row 1 — Filter Dropdown (disamakan dengan Penilaian) -->
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
                    <option>Sistem Informasi</option>
                    <option>Manajemen</option>
                    <option>Akuntansi</option>
                    <option>Elektro</option>
                    <option>Teknik Industri</option>
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
                    <option>Rina Kusuma</option>
                    <option>Hendri Wijaya</option>
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
                <label class="block text-sm font-medium text-gray-600 mb-1">Status Presensi</label>
                <select id="filterStatus" class="border border-gray-300 rounded-lg p-2 text-sm focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">
                    <option value="all">Semua</option>
                    <option>Hadir</option>
                    <option>Izin</option>
                    <option>Alfa</option>
                </select>
            </div>
        </div>

        <!-- ✅ Row 2 — Search Nama -->
        <div class="relative w-full md:w-1/3">
            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
            <input type="text" id="searchInput" placeholder="Cari nama mahasiswa..."
                class="pl-9 w-full border border-gray-300 rounded-lg p-2 text-sm focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">
        </div>
    
        
    
        <!-- Divider -->
        <hr class="my-4 border-gray-200">

        <div class="overflow-x-auto rounded-xl border border-gray-200">
            <table class="min-w-full text-sm text-gray-700" id="tablePresensi">
                <thead class="bg-gray-100 text-gray-800">
                    <tr>
                        <th class="px-4 py-2 text-left font-semibold">Nama Mahasiswa</th>
                        <th class="px-4 py-2 text-left font-semibold">Kampus</th>
                        <th class="px-4 py-2 text-left font-semibold">Jurusan</th>
                        <th class="px-4 py-2 text-left font-semibold">Status Magang</th>
                        <th class="px-4 py-2 text-left font-semibold">Direktorat</th>
                        <th class="px-4 py-2 text-left font-semibold">Fungsi</th>
                        <th class="px-4 py-2 text-left font-semibold">Mentor</th>
                        <th class="px-4 py-2 text-center font-semibold">Status</th>
                        <th class="px-4 py-2 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                @php
                    // Dummy data 24 baris untuk uji filter/search
                    $presensi = [
                        ['Joevanz Mikail','Universitas Airlangga','Psikologi','PKL','Direktorat Utama','Human Capital','Andi Saputra','Hadir'],
                        ['Siti Nurhaliza','ITS','Teknik Informatika','Internship','Direktorat Sales & Marketing','Sales Strategy','Sri Wahyuni','Hadir'],
                        ['Bagus Setiawan','PENS','Elektro','PKL','Direktorat Operasi','Supply Chain','Andi Saputra','Izin'],
                        ['Alya Rahma','UB','Manajemen','Internship','Direktorat Finance & Business Support','Finance & Accounting','Bambang Adi','Hadir'],
                        ['Rizky Hidayat','UNESA','Teknik Informatika','PKL','Direktorat Operasi','IT Support','Andi Saputra','Alfa'],
                        ['Dinda Laras','UPN','Sistem Informasi','Internship','Direktorat Utama','Corporate Communication','Rina Kusuma','Hadir'],
                        ['Fajar Pratama','ITS','Teknik Industri','PKL','Direktorat Operasi','Supply Chain','Hendri Wijaya','Izin'],
                        ['Nadia Putri','Universitas Airlangga','Akuntansi','Internship','Direktorat Finance & Business Support','Finance & Accounting','Bambang Adi','Hadir'],
                        ['Dio Ramadhan','UB','Manajemen','PKL','Direktorat Sales & Marketing','Sales Strategy','Sri Wahyuni','Alfa'],
                        ['Mella Sari','UNESA','Psikologi','Internship','Direktorat Utama','Human Capital','Andi Saputra','Hadir'],
                        ['Hafidz Akbar','PENS','Elektro','PKL','Direktorat Operasi','IT Support','Hendri Wijaya','Hadir'],
                        ['Rara Ayu','UPN','Sistem Informasi','Internship','Direktorat Utama','Corporate Communication','Rina Kusuma','Izin'],
                        ['Galang Prakoso','ITS','Teknik Informatika','PKL','Direktorat Operasi','Supply Chain','Hendri Wijaya','Hadir'],
                        ['Salsa Amelia','Universitas Airlangga','Akuntansi','Internship','Direktorat Finance & Business Support','Finance & Accounting','Bambang Adi','Izin'],
                        ['Yoga Pramana','UB','Manajemen','PKL','Direktorat Sales & Marketing','Sales Strategy','Sri Wahyuni','Hadir'],
                        ['Tiara Lestari','PENS','Elektro','Internship','Direktorat Operasi','IT Support','Andi Saputra','Alfa'],
                        ['Ridho Saputro','UNESA','Teknik Informatika','PKL','Direktorat Operasi','IT Support','Hendri Wijaya','Hadir'],
                        ['Rina Azzahra','UPN','Sistem Informasi','Internship','Direktorat Utama','Corporate Communication','Rina Kusuma','Hadir'],
                        ['Farhan Dwi','ITS','Teknik Industri','PKL','Direktorat Operasi','Supply Chain','Hendri Wijaya','Alfa'],
                        ['Aditiya Kurnia','UB','Manajemen','Internship','Direktorat Sales & Marketing','Sales Strategy','Sri Wahyuni','Izin'],
                        ['Aurelia N','Universitas Airlangga','Psikologi','PKL','Direktorat Utama','Human Capital','Andi Saputra','Hadir'],
                        ['Bima Sakti','PENS','Elektro','Internship','Direktorat Operasi','IT Support','Hendri Wijaya','Izin'],
                        ['Kezia Maria','UNESA','Akuntansi','PKL','Direktorat Finance & Business Support','Finance & Accounting','Bambang Adi','Hadir'],
                        ['Robby Ananta','UPN','Sistem Informasi','Internship','Direktorat Utama','Corporate Communication','Rina Kusuma','Hadir'],
                    ];
                    function statusBadge($s) {
                        return $s === 'Hadir' ? 'bg-green-100 text-green-700' :
                               ($s === 'Izin' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700');
                    }
                @endphp

                @foreach ($presensi as $row)
                <tr class="hover:bg-indigo-50 transition">
                    <td class="px-4 py-2 font-medium">{{ $row[0] }}</td>
                    <td class="px-4 py-2">{{ $row[1] }}</td>
                    <td class="px-4 py-2">{{ $row[2] }}</td>
                    <td class="px-4 py-2">{{ $row[3] }}</td>
                    <td class="px-4 py-2">{{ $row[4] }}</td>
                    <td class="px-4 py-2">{{ $row[5] }}</td>
                    <td class="px-4 py-2">{{ $row[6] }}</td>
                    <td class="px-4 py-2 text-center">
                        <span class="status-badge px-3 py-1 rounded-full text-xs font-semibold {{ statusBadge($row[7]) }}">{{ $row[7] }}</span>
                    </td>
                    <td class="px-4 py-2 text-center">
                        <button onclick="openDetail(this)" class="px-3 py-1 text-xs rounded-lg bg-indigo-500 text-white hover:bg-indigo-600 transition">Detail</button>
                    </td>
                </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Detail Mahasiswa (tanpa NIM agar konsisten) -->
<div id="detailModal" class="hidden fixed inset-0 bg-black/60 flex items-center justify-center z-50 backdrop-blur-sm">
    <div class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-md relative animate-fade-in">
        <button onclick="closeDetail()" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
            <i class="fas fa-times"></i>
        </button>
        <h3 class="text-lg font-bold mb-4 text-indigo-700 flex items-center gap-2">
            <i class="fas fa-user"></i> Detail Presensi Mahasiswa
        </h3>
        <div class="text-sm text-gray-700 space-y-2">
            <p><strong>Nama:</strong> <span id="detailNama"></span></p>
            <p><strong>Kampus:</strong> <span id="detailKampus"></span></p>
            <p><strong>Jurusan:</strong> <span id="detailJurusan"></span></p>
            <p><strong>Mentor:</strong> <span id="detailMentor"></span></p>
            <p><strong>Status:</strong> <span id="detailStatus" class="font-semibold"></span></p>
        </div>
        <div class="mt-6 flex justify-end gap-3">
            <button onclick="closeDetail()" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg">Tutup</button>
            <button id="btnUbahStatus" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg">Ubah Status</button>
        </div>
    </div>
</div>

<!-- Modal Pilih Status -->
<div id="statusModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 backdrop-blur-sm">
    <div class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-sm relative animate-fade-in">
        <button onclick="closeStatusModal()" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
            <i class="fas fa-times"></i>
        </button>
        <h3 class="text-lg font-bold mb-4 text-indigo-700 flex items-center gap-2">
            <i class="fas fa-user-edit"></i> Ubah Status Mahasiswa
        </h3>
        <p class="text-sm text-gray-600 mb-4">Pilih status kehadiran baru:</p>
        <div class="flex flex-col gap-3">
            <button class="status-option py-2 rounded-lg border border-green-200 bg-green-50 text-green-700 font-semibold shadow-sm transition-all duration-300 ease-in-out transform hover:scale-[1.03] active:scale-[0.97] hover:text-white hover:shadow-lg hover:bg-gradient-to-r hover:from-green-500 hover:to-green-600" data-status="Hadir">Hadir</button>
            <button class="status-option py-2 rounded-lg border border-yellow-200 bg-yellow-50 text-yellow-700 font-semibold shadow-sm transition-all duration-300 ease-in-out transform hover:scale-[1.03] active:scale-[0.97] hover:text-white hover:shadow-lg hover:bg-gradient-to-r hover:from-yellow-400 hover:to-yellow-500" data-status="Izin">Izin</button>
            <button class="status-option py-2 rounded-lg border border-red-200 bg-red-50 text-red-700 font-semibold shadow-sm transition-all duration-300 ease-in-out transform hover:scale-[1.03] active:scale-[0.97] hover:text-white hover:shadow-lg hover:bg-gradient-to-r hover:from-red-500 hover:to-red-600" data-status="Alfa">Alfa</button>
        </div>
    </div>
</div>

<!-- Toast -->
<div id="toast" class="hidden fixed bottom-5 right-5 bg-green-600 text-white px-4 py-2 rounded-lg shadow-lg">
    ✅ Status berhasil diperbarui!
</div>

<style>
@keyframes fadeIn { from { opacity: 0; transform: translateY(10px);} to { opacity: 1; transform: translateY(0);} }
.animate-fade-in { animation: fadeIn 0.3s ease-out; }
.status-option:hover { background-color: #f3f4f6; }
</style>

<script>
let currentRow = null;

// Buka modal detail (indeks kolom mengikuti tabel baru)
function openDetail(button) {
    currentRow = button.closest('tr');
    const cells = currentRow.querySelectorAll('td');

    document.getElementById('detailNama').textContent = cells[0].textContent.trim();
    document.getElementById('detailKampus').textContent = cells[1].textContent.trim();
    document.getElementById('detailJurusan').textContent = cells[2].textContent.trim();
    document.getElementById('detailMentor').textContent = cells[6].textContent.trim();
    document.getElementById('detailStatus').textContent = currentRow.querySelector('.status-badge').textContent.trim();

    document.getElementById('detailModal').classList.remove('hidden');
}

function closeDetail() {
    document.getElementById('detailModal').classList.add('hidden');
}

document.getElementById('btnUbahStatus').addEventListener('click', () => {
    document.getElementById('statusModal').classList.remove('hidden');
});

function closeStatusModal() {
    document.getElementById('statusModal').classList.add('hidden');
}

// Ubah status (simulasi)
document.querySelectorAll('.status-option').forEach(opt => {
    opt.addEventListener('click', () => {
        const newStatus = opt.dataset.status;
        const badge = currentRow.querySelector('.status-badge');
        const detailStatus = document.getElementById('detailStatus');

        badge.textContent = newStatus;
        detailStatus.textContent = newStatus;

        badge.className = `status-badge px-3 py-1 rounded-full text-xs font-semibold ${
            newStatus === 'Hadir' ? 'bg-green-100 text-green-700' :
            newStatus === 'Izin' ? 'bg-yellow-100 text-yellow-700' :
            'bg-red-100 text-red-700'
        }`;

        closeStatusModal();
        showToast();
    });
});

function showToast() {
    const toast = document.getElementById('toast');
    toast.classList.remove('hidden');
    setTimeout(() => toast.classList.add('hidden'), 2000);
}

// ✅ Live Filtering (disamakan dengan Penilaian, dengan perbaikan bug .toLowerCase())
function filterData() {
    const kampus = document.getElementById('filterKampus').value.toLowerCase();
    const jurusan = document.getElementById('filterJurusan').value.toLowerCase();
    const statusMagang = document.getElementById('filterStatusMagang').value.toLowerCase();
    const mentor = document.getElementById('filterMentor').value.toLowerCase();
    const direktorat = document.getElementById('filterDirektorat').value.toLowerCase();
    const fungsi = document.getElementById('filterFungsi').value.toLowerCase();
    const status = document.getElementById('filterStatus').value.toLowerCase();
    const search = document.getElementById('searchInput').value.toLowerCase();

    document.querySelectorAll('#tablePresensi tbody tr').forEach(row => {
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
