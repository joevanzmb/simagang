@extends('layouts.mentor', ['noHeader' => true])

@section('pageTitle', 'Presensi Mahasiswa')
@section('pageSubtitle', 'Pantau dan kelola presensi mahasiswa dengan tampilan interaktif')

@section('content')
<div class="space-y-10">

    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-center text-white p-7 rounded-2xl shadow-lg"
        style="background: linear-gradient(135deg, #5a6de0 0%, #6c3fb0 100%);">
        <div>
            <h2 class="text-2xl font-bold flex items-center gap-5 leading-tight">
                <i class="fas fa-calendar-check text-4xl"></i> Presensi Mahasiswa
            </h2>
            <p class="text-m text-white-100 mt-2">Kelola dan pantau seluruh aktivitas kehadiran mahasiswa magang</p>
        </div>
        <button class="px-5 py-2 bg-white/20 hover:bg-white/30 rounded-lg text-white font-medium flex items-center gap-2 transition-all duration-200 hover:scale-[1.03]">
            <i class="fas fa-sync-alt"></i> Refresh Data
        </button>
    </div>

    <!-- Statistik Ringkas -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-green-50 p-6 rounded-2xl shadow hover:shadow-xl transition group">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium text-green-700">Hadir</h3>
                    <p class="text-3xl font-bold text-green-600 mt-1">12</p>
                </div>
                <div class="bg-green-100 text-green-600 rounded-full p-3 shadow-inner group-hover:scale-110 transition">
                    <i class="fas fa-user-check"></i>
                </div>
            </div>
        </div>

        <div class="bg-yellow-50 p-6 rounded-2xl shadow hover:shadow-xl transition group">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium text-yellow-700">Izin</h3>
                    <p class="text-3xl font-bold text-yellow-600 mt-1">3</p>
                </div>
                <div class="bg-yellow-100 text-yellow-600 rounded-full p-3 shadow-inner group-hover:scale-110 transition">
                    <i class="fas fa-user-clock"></i>
                </div>
            </div>
        </div>

        <div class="bg-red-50 p-6 rounded-2xl shadow hover:shadow-xl transition group">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium text-red-700">Alfa</h3>
                    <p class="text-3xl font-bold text-red-600 mt-1">5</p>
                </div>
                <div class="bg-red-100 text-red-600 rounded-full p-3 shadow-inner group-hover:scale-110 transition">
                    <i class="fas fa-user-times"></i>
                </div>
            </div>
        </div>

        <div class="bg-gray-50 p-6 rounded-2xl shadow hover:shadow-xl transition group">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium text-gray-700">Belum Presensi</h3>
                    <p class="text-3xl font-bold text-gray-600 mt-1">4</p>
                </div>
                <div class="bg-gray-100 text-gray-500 rounded-full p-3 shadow-inner group-hover:scale-110 transition">
                    <i class="fas fa-user"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Search -->
    <div class="bg-white p-5 rounded-2xl shadow flex flex-col md:flex-row justify-between items-center gap-4">
        <div class="flex items-center gap-3">
            <label for="filterTanggal" class="font-medium text-gray-600">Tanggal:</label>
            <input type="date" id="filterTanggal" value="2025-10-10" class="border border-gray-300 rounded-lg p-2 text-sm focus:ring-indigo-500 focus:border-indigo-500">
        </div>
        <div class="relative w-full md:w-1/3">
            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
            <input type="text" id="searchInput" placeholder="Cari mahasiswa..." class="pl-9 w-full border border-gray-300 rounded-lg p-2 text-sm focus:ring-indigo-500 focus:border-indigo-500">
        </div>
    </div>

    <!-- Tabel Presensi -->
    <div class="bg-white rounded-2xl shadow-lg p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
            <i class="fas fa-users"></i> Daftar Presensi Mahasiswa
        </h3>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-gray-700 border border-gray-200 rounded-xl overflow-hidden" id="tablePresensi">
                <thead class="bg-gray-100 text-gray-800">
                    <tr>
                        <th class="px-4 py-2 text-left font-semibold">Nama</th>
                        <th class="px-4 py-2 text-left font-semibold">Universitas</th>
                        <th class="px-4 py-2 text-left font-semibold">NIM</th>
                        <th class="px-4 py-2 text-center font-semibold">Status</th>
                        <th class="px-4 py-2 text-center font-semibold">Check-In</th>
                        <th class="px-4 py-2 text-center font-semibold">Check-Out</th>
                        <th class="px-4 py-2 text-center font-semibold">Keterangan</th>
                        <th class="px-4 py-2 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Row 1 -->
                    <tr class="border-b hover:bg-indigo-50 transition">
                        <td class="px-4 py-2 font-medium">Joevanz Mikail</td>
                        <td class="px-4 py-2">Universitas Airlangga</td>
                        <td class="px-4 py-2 font-mono text-gray-600">187221077</td>
                        <td class="px-4 py-2 text-center">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-700">Internship</span>
                        </td>
                        <td class="px-4 py-2 text-center">
                            08:12<br><span class="text-xs text-gray-500">Surabaya</span>
                        </td>
                        <td class="px-4 py-2 text-center">
                            16:30<br><span class="text-xs text-gray-500">Surabaya</span>
                        </td>
                        <td class="px-4 py-2 text-center status-cell">
                            <span class="status-badge px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">Hadir</span>
                        </td>
                        <td class="px-4 py-2 text-center">
                            <button onclick="openDetail(this)" class="px-3 py-1 text-xs rounded-lg bg-indigo-500 text-white hover:bg-indigo-600 transition">Detail</button>
                        </td>
                    </tr>
                
                    <!-- Row 2 -->
                    <tr class="border-b hover:bg-indigo-50 transition">
                        <td class="px-4 py-2 font-medium">Alya Putri</td>
                        <td class="px-4 py-2">ITS</td>
                        <td class="px-4 py-2 font-mono text-gray-600">187221090</td>
                        <td class="px-4 py-2 text-center">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">PKL</span>
                        </td>
                        <td class="px-4 py-2 text-center">
                            08:30<br><span class="text-xs text-gray-500">Gresik</span>
                        </td>
                        <td class="px-4 py-2 text-center">
                            -<br><span class="text-xs text-gray-500">Belum Pulang</span>
                        </td>
                        <td class="px-4 py-2 text-center status-cell">
                            <span class="status-badge px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">Izin</span>
                        </td>
                        <td class="px-4 py-2 text-center">
                            <button onclick="openDetail(this)" class="px-3 py-1 text-xs rounded-lg bg-indigo-500 text-white hover:bg-indigo-600 transition">Detail</button>
                        </td>
                    </tr>
                
                    <!-- Row 3 -->
                    <tr class="border-b hover:bg-indigo-50 transition">
                        <td class="px-4 py-2 font-medium">Rizky Saputra</td>
                        <td class="px-4 py-2">UNESA</td>
                        <td class="px-4 py-2 font-mono text-gray-600">187221081</td>
                        <td class="px-4 py-2 text-center">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-700">Internship</span>
                        </td>
                        <td class="px-4 py-2 text-center">
                            -<br><span class="text-xs text-gray-500">Tidak Masuk</span>
                        </td>
                        <td class="px-4 py-2 text-center">
                            -<br><span class="text-xs text-gray-500">-</span>
                        </td>
                        <td class="px-4 py-2 text-center status-cell">
                            <span class="status-badge px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">Alfa</span>
                        </td>
                        <td class="px-4 py-2 text-center">
                            <button onclick="openDetail(this)" class="px-3 py-1 text-xs rounded-lg bg-indigo-500 text-white hover:bg-indigo-600 transition">Detail</button>
                        </td>
                    </tr>
                </tbody>


            </table>
        </div>
    </div>
</div>

<!-- Modal Detail Mahasiswa -->
<div id="detailModal" class="hidden fixed inset-0 bg-black/60 flex items-center justify-center z-50 backdrop-blur-sm">
    <div class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-lg relative animate-fade-in">
        <button onclick="closeDetail()" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
            <i class="fas fa-times"></i>
        </button>

        <h3 class="text-lg font-bold mb-4 text-indigo-700 flex items-center gap-2">
            <i class="fas fa-user"></i> Detail Presensi Mahasiswa
        </h3>

        <div class="text-sm text-gray-700 space-y-3">

            <div class="grid grid-cols-2 gap-4">
                <p><strong>Nama:</strong> <span id="detailNama"></span></p>
                <p><strong>NIM:</strong> <span id="detailNim"></span></p>
                <p><strong>Universitas:</strong> <span id="detailUniv"></span></p>
                <p><strong>Status Magang:</strong> <span id="detailMagang"></span></p>
            </div>

            <hr class="my-2">

            <!-- Check-In -->
            <div>
                <p class="font-semibold text-indigo-600">Check-In</p>
                <p><strong>Jam:</strong> <span id="detailIn"></span></p>
                <div class="mt-1">
                    <p class="text-gray-700 text-sm" id="detailInLoc">-</p>
                    <a id="detailInMap" target="_blank"
                        class="text-blue-600 text-xs underline mt-1 inline-block hidden">
                        🌍 Lihat di Google Maps
                    </a>
                </div>
            </div>
            
            <!-- Check-Out -->
            <div class="mt-3">
                <p class="font-semibold text-indigo-600">Check-Out</p>
                <p><strong>Jam:</strong> <span id="detailOut"></span></p>
                <div class="mt-1">
                    <p class="text-gray-700 text-sm" id="detailOutLoc">-</p>
                    <a id="detailOutMap" target="_blank"
                        class="text-blue-600 text-xs underline mt-1 inline-block hidden">
                        🌍 Lihat di Google Maps
                    </a>
                </div>
            </div>
            
            <hr class="my-3">
            
            <p><strong>Status Presensi:</strong>
                <span id="detailStatusBadge"
                    class="px-3 py-1 rounded-full text-xs font-semibold inline-block">
                </span>
            </p>

        </div>

        <div class="mt-6 flex justify-end gap-3">
            <button onclick="closeDetail()" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg">
                Tutup
            </button>
            <button id="btnUbahStatus" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg">
                Ubah Status
            </button>
        </div>
    </div>
</div>


<!-- Modal Ubah Status -->
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

function openDetail(button) {
    currentRow = button.closest('tr');

    const nama = currentRow.cells[0].textContent.trim();
    const univ = currentRow.cells[1].textContent.trim();
    const nim = currentRow.cells[2].textContent.trim();
    const magang = currentRow.cells[3].innerText.trim();

    const inCell = currentRow.cells[4].innerText.split('\n');
    const outCell = currentRow.cells[5].innerText.split('\n');

    const status = currentRow.querySelector('.status-badge').innerText.trim();

    // Inject data
    document.getElementById('detailNama').textContent = nama;
    document.getElementById('detailUniv').textContent = univ;
    document.getElementById('detailNim').textContent = nim;
    document.getElementById('detailMagang').textContent = magang;

    document.getElementById('detailIn').textContent = inCell[0] || '-';
    document.getElementById('detailOut').textContent = outCell[0] || '-';

    setLocation("detailInLoc", "detailInMap", inCell[1]);
    setLocation("detailOutLoc", "detailOutMap", outCell[1]);

    // ✅ Status Presensi Badge Style
    const badge = document.getElementById('detailStatusBadge');
    badge.innerText = status;
    badge.className =
        "px-3 py-1 rounded-full text-xs font-semibold inline-block " +
        (
            status === 'Hadir' ? 'bg-green-100 text-green-700' :
            status === 'Izin' ? 'bg-yellow-100 text-yellow-700' :
            'bg-red-100 text-red-700'
        );

    document.getElementById('detailModal').classList.remove('hidden');
}

// ✅ Lokasi lebih lengkap (dummy mapping untuk visual)
function setLocation(locId, mapId, locText) {
    const locLabel = document.getElementById(locId);
    const mapLink = document.getElementById(mapId);

    if (!locText || locText.includes('-')) {
        locLabel.textContent = "-";
        mapLink.classList.add("hidden");
        return;
    }

    // Simulasi lokasi lengkap
    const lokasiLengkap = `${locText.trim()}, Kec. Tegalsari, Kota Surabaya, Jawa Timur`;
    locLabel.textContent = lokasiLengkap;

    // Simulasi koordinat (nanti hubungkan database)
    const lat = -7.257472 + (Math.random() * 0.002);
    const long = 112.752090 + (Math.random() * 0.002);

    mapLink.href = `https://www.google.com/maps?q=${lat},${long}`;
    mapLink.classList.remove("hidden");
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

// Pilih status
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

// Pencarian
document.getElementById('searchInput').addEventListener('input', function() {
    const val = this.value.toLowerCase();
    document.querySelectorAll('#tablePresensi tbody tr').forEach(tr => {
        const nama = tr.cells[0].textContent.toLowerCase();
        tr.style.display = nama.includes(val) ? '' : 'none';
    });
});
</script>
@endsection
