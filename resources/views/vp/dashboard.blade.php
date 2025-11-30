@extends('layouts.vp', ['noHeader' => true])

@section('pageTitle', 'Dashboard Vice President')
@section('pageSubtitle', 'Pantau proses approval sertifikat dan progress presentasi mahasiswa.')

@section('content')
<div class="space-y-10">

    <!-- HEADER -->
    <div class="flex flex-col md:flex-row justify-between items-center text-white p-7 rounded-2xl shadow-lg"
        style="background: linear-gradient(135deg, #5a6de0, #6c3fb0 100%);">
        <div>
            <h2 class="text-2xl font-bold flex items-center gap-4 leading-tight">
                <i class="fas fa-certificate text-3xl"></i> Dashboard Vice President
            </h2>
            <p class="text-sm text-white/80 mt-1">Kelola proses persetujuan sertifikat mahasiswa magang.</p>
        </div>
    </div>

    <!-- STAT CARDS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @php
            $stats = [
                ['Mahasiswa Aktif', 12, 'fa-users', 'indigo'],
                ['Sertifikat Disetujui', 8, 'fa-check-circle', 'green'],
                ['Menunggu Mentor', 3, 'fa-clock', 'yellow'],
                ['Sertifikat Ditolak', 2, 'fa-times-circle', 'red']
            ];
        @endphp

        @foreach ($stats as [$label, $value, $icon, $color])
            <div class="bg-{{ $color }}-50 rounded-xl p-6 shadow-sm relative">
                <div class="absolute right-4 bottom-4 text-{{ $color }}-300 text-6xl opacity-20">
                    <i class="fas {{ $icon }}"></i>
                </div>
                <p class="text-sm text-gray-600">{{ $label }}</p>
                <p class="text-4xl font-bold text-{{ $color }}-700 mt-1">{{ $value }}</p>
            </div>
        @endforeach
    </div>

    <!-- CHARTS -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    
        <!-- Distribusi Status Sertifikat -->
        <div class="bg-white p-6 rounded-xl shadow-md">
            <h3 class="font-semibold text-gray-700 mb-4 flex items-center gap-2">
                <i class="fas fa-chart-pie text-indigo-500"></i> Distribusi Status Sertifikat
            </h3>
    
            <!-- ✅ Chart donut dengan teks di tengah -->
            <div class="relative h-60 flex items-center justify-center">
                <canvas id="chartStatus"></canvas>
    
                <div class="absolute text-center">
                    <p id="labelPersen" class="text-3xl font-extrabold text-indigo-700">-</p>
                    <p class="text-[10px] text-gray-500 uppercase tracking-wide mt-1">Disetujui</p>
                </div>
            </div>
            <!-- ✅ Custom Legend -->
            <div id="legendStatus"></div>
        </div>
        
    
        <!-- Tren Approval Bulanan -->
        <div class="bg-white p-6 rounded-xl shadow-md">
            <h3 class="font-semibold text-gray-700 mb-4 flex items-center gap-2">
                <i class="fas fa-chart-line text-green-500"></i> Tren Approval Bulanan
            </h3>
            <canvas id="chartTrend" class="h-60"></canvas>
        </div>
    
    </div>


    <!-- TABLE -->
    <div class="bg-white rounded-2xl shadow-lg p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                <i class="fas fa-file-powerpoint text-indigo-600"></i> Hasil Presentasi Mahasiswa
            </h3>

            <div class="relative">
                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                <input type="text" placeholder="Cari mahasiswa..."
                    class="pl-9 w-64 border border-gray-300 rounded-lg p-2 text-sm focus:ring-indigo-500 focus:border-indigo-500"
                    id="searchInput">
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-gray-700 border border-gray-200 rounded-xl">
                <thead class="bg-gray-100 text-gray-800">
                    <tr>
                        <th class="px-4 py-2 text-left font-semibold">Mahasiswa</th>
                        <th class="px-4 py-2 text-center font-semibold">Mentor</th>
                        <th class="px-4 py-2 text-center font-semibold">Status Sertifikat</th>
                        <th class="px-4 py-2 text-center font-semibold">Dokumen PPT</th>
                        <th class="px-4 py-2 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tableMahasiswa">
                
                    <tr class="border-b hover:bg-indigo-50 transition">
                        <td class="px-4 py-3 font-medium flex items-center gap-3">
                            <img src="https://ui-avatars.com/api/?name=Joevanz+Mikail&background=6366f1&color=fff"
                                class="w-9 h-9 rounded-full shadow-sm">
                            <div>
                                <p class="font-semibold text-gray-800">Joevanz Mikail</p>
                                <p class="text-xs text-gray-500">Universitas Airlangga</p>
                            </div>
                        </td>
                
                        <td class="px-4 py-2 text-center">Bapak Andi Saputra</td>
                
                        <td class="px-4 py-2 text-center">
                            <span class="badge-status bg-yellow-100 text-yellow-700">
                                Menunggu
                            </span>
                        </td>
                
                        <td class="px-4 py-2 text-center">
                            <a href="#" class="px-3 py-1 text-xs bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition flex items-center justify-center gap-1 mx-auto w-fit">
                                <i class="fas fa-file-powerpoint"></i> PPT
                            </a>
                        </td>
                
                        <td class="px-4 py-2 text-center space-x-2">
                            <button onclick="approveCert(this)" class="btn-approve"><i class="fas fa-check mr-1"></i>Setujui</button>
                            <button onclick="rejectCert(this)" class="btn-reject"><i class="fas fa-times mr-1"></i>Tolak</button>
                        </td>
                    </tr>
                
                </tbody>

            </table>
        </div>

    </div>

</div>

<!-- Modal Alasan Penolakan -->
<div id="modalAlasan" class="hidden fixed inset-0 bg-black/60 flex items-center justify-center z-50 backdrop-blur-sm">
    <div class="bg-white rounded-xl shadow-2xl p-6 w-full max-w-md relative">
        <h3 class="text-lg font-semibold text-gray-800 mb-3">Masukkan Alasan Penolakan</h3>
        <textarea id="alasanInput" rows="3" class="w-full border rounded-lg p-3 text-sm focus:ring-red-500"
            placeholder="Contoh: Presentasi belum mencapai standar minimal"></textarea>

        <div class="flex justify-end gap-3 mt-4">
            <button onclick="closeAlasan()" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg text-sm">Batal</button>
            <button onclick="submitAlasan()" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm">
                Tolak Sertifikat
            </button>
        </div>
    </div>
</div>

<style>
.btn-approve {
    @apply px-3 py-1 text-xs bg-green-500 text-white rounded-lg hover:bg-green-600 transition;
}
.btn-reject {
    @apply px-3 py-1 text-xs bg-red-500 text-white rounded-lg hover:bg-red-600 transition;
}
.badge-status {
    @apply px-3 py-1 rounded-full text-xs font-semibold;
}
</style>

<script>

// Modal state
let targetRowStatus = null;
let targetActionCell = null;

function approveCert(btn) {
    const row = btn.closest("tr");
    const status = row.querySelector(".badge-status");

    status.className = "badge-status px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700";
    status.innerText = "Disetujui";

    btn.closest("td").innerHTML = `
        <span class="text-green-600 font-semibold text-sm">
            <i class="fas fa-check-circle"></i> Sudah Disetujui
        </span>`;
}

function rejectCert(btn) {
    targetRowStatus = btn.closest("tr").querySelector(".badge-status");
    targetActionCell = btn.closest("td");

    document.getElementById("modalAlasan").classList.remove("hidden");
}

function closeAlasan() {
    document.getElementById("modalAlasan").classList.add("hidden");
    document.getElementById("alasanInput").value = "";
}

function submitAlasan() {
    const value = document.getElementById("alasanInput").value.trim();
    if (!value) return alert("⚠️ Isi alasan penolakan terlebih dahulu!");

    targetRowStatus.className =
        "badge-status px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700";
    targetRowStatus.innerText = "Ditolak";

    targetActionCell.innerHTML = `
        <span class="text-red-600 font-semibold text-sm">
            <i class="fas fa-times-circle"></i> Ditolak
        </span>
        <p class="text-xs text-gray-500 mt-1 italic">Alasan: ${value}</p>
    `;

    closeAlasan();
}

// ====== CHART STATUS (DONUT) ======
const approved = 8;
const waiting = 3;
const rejected = 2;
const total = approved + waiting + rejected;
const percentApproved = Math.round((approved / total) * 100);

document.getElementById("labelPersen").innerText = percentApproved + "%";

const chartStatus = new Chart(document.getElementById("chartStatus"), {
    type: "doughnut",
    data: {
        labels: ["Disetujui", "Menunggu", "Ditolak"],
        datasets: [{
            data: [approved, waiting, rejected],
            backgroundColor: ["#22c55e", "#facc15", "#ef4444"],
            borderWidth: 0
        }]
    },
    options: {
        cutout: "78%",
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
    }
});

// ✅ Generate legend manual (di luar chart)
const legendEl = document.getElementById("legendStatus");
legendEl.innerHTML = `
  <div class="flex justify-center gap-4 text-xs mt-4">
    <span class="flex items-center gap-1"><span class="w-3 h-3 rounded-full bg-[#22c55e]"></span>Disetujui</span>
    <span class="flex items-center gap-1"><span class="w-3 h-3 rounded-full bg-[#facc15]"></span>Menunggu</span>
    <span class="flex items-center gap-1"><span class="w-3 h-3 rounded-full bg-[#ef4444]"></span>Ditolak</span>
  </div>
`;


// ====== CHART TREND ======
new Chart(document.getElementById('chartTrend'), {
    type: 'line',
    data: {
        labels: ['Jan','Feb','Mar','Apr','Mei','Jun'],
        datasets: [{
            label: 'Sertifikat Disetujui',
            data: [3,4,6,8,9,10],
            borderColor: '#6366F1',
            backgroundColor: 'rgba(99,102,241,0.12)',
            tension: .4,
            fill: true
        }]
    },
    options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
});
</script>

@endsection
