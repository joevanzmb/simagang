@extends('layouts.vp', ['noHeader' => true])

@section('pageTitle', 'Riwayat Approval Sertifikat')
@section('pageSubtitle', 'Pantau semua proses persetujuan sertifikat yang telah dilakukan.')

@section('content')
<div class="space-y-10">

    <!-- 🌈 HEADER -->
    <div class="flex flex-col md:flex-row justify-between items-center text-white p-7 rounded-2xl shadow-lg"
        style="background: linear-gradient(135deg, #5a6de0 0%, #6c3fb0 100%);">
        <div>
            <h2 class="text-2xl font-bold flex items-center gap-4 leading-tight">
                <i class="fas fa-clock-rotate-left text-3xl"></i> Riwayat Approval Sertifikat
            </h2>
            <p class="text-m text-white/90 mt-1">Lihat daftar mahasiswa yang sudah disetujui atau ditolak dalam proses sertifikasi.</p>
        </div>
        <button class="px-5 py-2 bg-white/20 hover:bg-white/30 rounded-lg text-white font-medium flex items-center gap-2 transition-all duration-200 hover:scale-[1.03]">
            <i class="fas fa-filter"></i> Filter Riwayat
        </button>
    </div>

    

<style>
.filter-select {
    border: 1px solid #D1D5DB; 
    border-radius: 8px;
    padding: 0.45rem 0.75rem;
    font-size: 0.85rem;
}
</style>


    <!-- 📊 RINGKASAN GRAFIK -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-gray-700 font-semibold mb-4 flex items-center gap-2">
                <i class="fas fa-chart-pie text-indigo-500"></i> Statistik Status Sertifikat
            </h3>
            <div class="h-64">
                <canvas id="chartHistory"></canvas>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-gray-700 font-semibold mb-4 flex items-center gap-2">
                <i class="fas fa-chart-line text-green-500"></i> Tren Approval Bulanan
            </h3>
            <div class="h-64">
                <canvas id="chartTrend"></canvas>
            </div>
        </div>
    </div>
    
    <!-- 🔍 FILTER -->
    <div class="bg-white p-5 rounded-2xl shadow flex flex-col lg:flex-row justify-between items-center gap-4">
        <div class="flex flex-wrap gap-4 w-full lg:w-auto">
    
            <div>
                <label class="block text-sm font-medium text-gray-600">Kampus</label>
                <select id="filterKampus" class="filter-select">
                    <option value="all">Semua</option>
                    <option>Universitas Airlangga</option>
                    <option>ITS</option>
                    <option>UB</option>
                    <option>UPN</option>
                    <option>PENS</option>
                </select>
            </div>
    
            <div>
                <label class="block text-sm font-medium text-gray-600">Direktorat</label>
                <select id="filterDirektorat" class="filter-select">
                    <option value="all">Semua</option>
                    <option>Human Capital</option>
                    <option>Finance</option>
                    <option>Operasi</option>
                    <option>Marketing</option>
                    <option>IT</option>
                </select>
            </div>
    
            <div>
                <label class="block text-sm font-medium text-gray-600">Fungsi</label>
                <select id="filterFungsi" class="filter-select">
                    <option value="all">Semua</option>
                    <option>Learning & Development</option>
                    <option>Accounting</option>
                    <option>CSR</option>
                    <option>Sales Strategy</option>
                    <option>IT Support</option>
                </select>
            </div>
    
            <div>
                <label class="block text-sm font-medium text-gray-600">Status Magang</label>
                <select id="filterMagang" class="filter-select">
                    <option value="all">Semua</option>
                    <option>Internship</option>
                    <option>PKL</option>
                </select>
            </div>
    
            <div>
                <label class="block text-sm font-medium text-gray-600">Status Approval</label>
                <select id="filterStatus" class="filter-select">
                    <option value="all">Semua</option>
                    <option>Disetujui</option>
                    <option>Ditolak</option>
                </select>
            </div>
    
        </div>
    
        <div class="relative w-full lg:w-1/3">
            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
            <input type="text" id="searchInput" placeholder="Cari nama mahasiswa..."
                class="pl-9 w-full border border-gray-300 rounded-lg p-2 text-sm focus:ring-indigo-500 focus:border-indigo-500">
        </div>
    </div>

    <!-- 📜 TABEL RIWAYAT -->
    <div class="bg-white rounded-2xl shadow-lg p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                <i class="fas fa-list"></i> Daftar Riwayat Approval
            </h3>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-gray-700 border border-gray-200 rounded-xl overflow-hidden">
                <thead class="bg-gray-100 text-gray-800">
                    <tr>
                        <th class="px-4 py-2 text-left font-semibold">Nama</th>
                        <th class="px-4 py-2 text-left font-semibold">Kampus</th>
                        <th class="px-4 py-2 text-center font-semibold">Direktorat</th>
                        <th class="px-4 py-2 text-center font-semibold">Fungsi</th>
                        <th class="px-4 py-2 text-center font-semibold">Status Magang</th>
                        <th class="px-4 py-2 text-center font-semibold">Mentor</th>
                        <th class="px-4 py-2 text-center font-semibold">Status Approval</th>
                        <th class="px-4 py-2 text-center font-semibold">Tanggal Approval</th>
                        <th class="px-4 py-2 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody id="historyBody">

                    <tr data-kampus="Universitas Airlangga" data-direktorat="Human Capital" data-fungsi="Learning & Development"
                        data-magang="Internship" data-status="Disetujui">
                        <td class="px-4 py-2 font-medium">Joevanz Mikail</td>
                        <td class="px-4 py-2">Universitas Airlangga</td>
                        <td class="px-4 py-2 text-center">Human Capital</td>
                        <td class="px-4 py-2 text-center">Learning & Development</td>
                        <td class="px-4 py-2 text-center">
                            <span class="badge-magang">Internship</span>
                        </td>
                        <td class="px-4 py-2 text-center">Andi Saputra</td>
                        <td class="px-4 py-2 text-center">
                            <span class="badge-approved">Disetujui</span>
                        </td>
                        <td class="px-4 py-2 text-center">2025-10-21</td>
                        <td class="px-4 py-2 text-center"><button onclick="openDetail('Joevanz Mikail')"
                            class="btn-detail">Lihat</button></td>
                    </tr>
                    
                    <tr data-kampus="ITS" data-direktorat="Finance" data-fungsi="Accounting"
                        data-magang="PKL" data-status="Ditolak">
                        <td class="px-4 py-2 font-medium">Siti Nurhaliza</td>
                        <td class="px-4 py-2">ITS</td>
                        <td class="px-4 py-2 text-center">Finance</td>
                        <td class="px-4 py-2 text-center">Accounting</td>
                        <td class="px-4 py-2 text-center">
                            <span class="badge-magang">PKL</span>
                        </td>
                        <td class="px-4 py-2 text-center">Rina Oktaviani</td>
                        <td class="px-4 py-2 text-center">
                            <span class="badge-reject">Ditolak</span>
                        </td>
                        <td class="px-4 py-2 text-center">2025-10-20</td>
                        <td class="px-4 py-2 text-center"><button onclick="openDetail('Siti Nurhaliza')"
                            class="btn-detail">Detail</button></td>
                    </tr>
                    
                    <tr data-kampus="UPN" data-direktorat="Marketing" data-fungsi="Sales Strategy"
                        data-magang="PKL" data-status="Disetujui">
                        <td class="px-4 py-2 font-medium">Ayu Kartika</td>
                        <td class="px-4 py-2">UPN</td>
                        <td class="px-4 py-2 text-center">Marketing</td>
                        <td class="px-4 py-2 text-center">Sales Strategy</td>
                        <td class="px-4 py-2 text-center">
                            <span class="badge-magang">PKL</span>
                        </td>
                        <td class="px-4 py-2 text-center">Sri Wahyuni</td>
                        <td class="px-4 py-2 text-center">
                            <span class="badge-approved">Disetujui</span>
                        </td>
                        <td class="px-4 py-2 text-center">2025-10-19</td>
                        <td class="px-4 py-2 text-center"><button onclick="openDetail('Ayu Kartika')"
                            class="btn-detail">Lihat</button></td>
                    </tr>
                    
                    <tr data-kampus="UB" data-direktorat="Operasi" data-fungsi="CSR"
                        data-magang="Internship" data-status="Ditolak">
                        <td class="px-4 py-2 font-medium">Bagus Pratama</td>
                        <td class="px-4 py-2">Universitas Brawijaya</td>
                        <td class="px-4 py-2 text-center">Operasi</td>
                        <td class="px-4 py-2 text-center">CSR</td>
                        <td class="px-4 py-2 text-center"><span class="badge-magang">Internship</span></td>
                        <td class="px-4 py-2 text-center">Bambang Adi</td>
                        <td class="px-4 py-2 text-center"><span class="badge-reject">Ditolak</span></td>
                        <td class="px-4 py-2 text-center">2025-10-18</td>
                        <td class="px-4 py-2 text-center"><button onclick="openDetail('Bagus Pratama')"
                            class="btn-detail">Detail</button></td>
                    </tr>
                    
                    <tr data-kampus="PENS" data-direktorat="IT" data-fungsi="IT Support"
                        data-magang="Internship" data-status="Disetujui">
                        <td class="px-4 py-2 font-medium">Dimas Hadi</td>
                        <td class="px-4 py-2">PENS</td>
                        <td class="px-4 py-2 text-center">IT</td>
                        <td class="px-4 py-2 text-center">IT Support</td>
                        <td class="px-4 py-2 text-center"><span class="badge-magang">Internship</span></td>
                        <td class="px-4 py-2 text-center">Bambang Adi</td>
                        <td class="px-4 py-2 text-center"><span class="badge-approved">Disetujui</span></td>
                        <td class="px-4 py-2 text-center">2025-10-18</td>
                        <td class="px-4 py-2 text-center"><button onclick="openDetail('Dimas Hadi')"
                            class="btn-detail">Lihat</button></td>
                    </tr>
                    
                    </tbody>

<style>
.badge-magang { background:#eef2ff;color:#4338ca;font-size:10px;padding:3px 8px;border-radius:6px;font-weight:600; }
.badge-approved { background:#d1fae5;color:#047857;font-size:10px;padding:3px 8px;border-radius:6px;font-weight:600; }
.badge-reject { background:#fee2e2;color:#b91c1c;font-size:10px;padding:3px 8px;border-radius:6px;font-weight:600; }
.btn-detail { padding:4px 10px;font-size:11px;border-radius:6px;background:#6366f1;color:white; }
</style>

            </table>
        </div>
    </div>

    <!-- 🔍 MODAL DETAIL -->
    <div id="detailModal" class="hidden fixed inset-0 bg-black/60 flex items-center justify-center z-50 backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-2xl relative animate-fade-in">
            <button onclick="closeDetail()" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>

            <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-file-alt text-indigo-500"></i> Detail Approval Sertifikat
            </h3>

            <div class="space-y-3 text-sm text-gray-700">
                <p><strong>Nama:</strong> <span id="detailNama">-</span></p>
                <p><strong>Kampus:</strong> Universitas Airlangga</p>
                <p><strong>Mentor:</strong> Andi Saputra</p>
                <p><strong>Status:</strong> <span class="px-2 py-[2px] bg-green-100 text-green-700 rounded text-xs">Disetujui</span></p>
                <p><strong>Tanggal Approval:</strong> 2025-10-21</p>
                <p><strong>Alasan Penolakan:</strong> -</p>
            </div>

            <div class="text-right pt-5">
                <button onclick="closeDetail()" class="px-5 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg">
                    Tutup
                </button>
            </div>
        </div>
    </div>

</div>

<style>
@keyframes fadeIn { from { opacity: 0; transform: translateY(10px);} to { opacity: 1; transform: translateY(0);} }
.animate-fade-in { animation: fadeIn 0.3s ease-out; }
</style>

<script>
    
const filterControls = {
    kampus: document.getElementById('filterKampus'),
    direktorat: document.getElementById('filterDirektorat'),
    fungsi: document.getElementById('filterFungsi'),
    magang: document.getElementById('filterMagang'),
    status: document.getElementById('filterStatus'),
    search: document.getElementById('searchInput'),
};

Object.values(filterControls).forEach(el => el.addEventListener('input', applyFilter));

function applyFilter() {
    const rows = document.querySelectorAll('#historyBody tr');

    rows.forEach(row => {
        const matches =
            (filterControls.kampus.value === "all" || row.dataset.kampus === filterControls.kampus.value) &&
            (filterControls.direktorat.value === "all" || row.dataset.direktorat === filterControls.direktorat.value) &&
            (filterControls.fungsi.value === "all" || row.dataset.fungsi === filterControls.fungsi.value) &&
            (filterControls.magang.value === "all" || row.dataset.magang === filterControls.magang.value) &&
            (filterControls.status.value === "all" || row.dataset.status === filterControls.status.value) &&
            row.children[0].innerText.toLowerCase().includes(filterControls.search.value.toLowerCase());

        row.style.display = matches ? "" : "none";
    });
}


function openDetail(nama) {
    document.getElementById('detailModal').classList.remove('hidden');
    document.getElementById('detailNama').innerText = nama;
}
function closeDetail() {
    document.getElementById('detailModal').classList.add('hidden');
}

new Chart(document.getElementById('chartHistory'), {
    type: 'doughnut',
    data: {
        labels: ['Disetujui', 'Ditolak'],
        datasets: [{
            data: [85, 15],
            backgroundColor: ['#22c55e', '#ef4444'],
            borderWidth: 0
        }]
    },
    options: {
        cutout: '70%',
        plugins: { legend: { position: 'bottom' } }
    }
});

new Chart(document.getElementById('chartTrend'), {
    type: 'line',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt'],
        datasets: [{
            label: 'Approval Sertifikat',
            data: [5, 8, 6, 10, 12, 14, 9, 11, 13, 15],
            borderColor: '#6366F1',
            backgroundColor: 'rgba(99,102,241,0.1)',
            fill: true,
            tension: 0.4
        }]
    },
    options: {
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true } }
    }
});
</script>
@endsection
