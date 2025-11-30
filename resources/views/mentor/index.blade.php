@extends('layouts.app', ['noHeader' => true])

@section('pageTitle', 'Data Mentor Magang')
@section('pageSubtitle', 'Pantau, kelola, dan koordinasikan mentor pembimbing magang.')

@section('content')
<div class="space-y-10">

    <!-- HEADER -->
    <div class="flex flex-col md:flex-row justify-between items-center text-white p-7 rounded-2xl shadow-lg"
        style="background: linear-gradient(135deg, #5a6de0 0%, #6c3fb0 100%);">
        <div>
            <h2 class="text-2xl font-bold flex items-center gap-5 leading-tight">
                <i class="fas fa-user-tie text-4xl"></i> Data Mentor Magang
            </h2>
            <p class="text-m text-white-100 mt-2">Total Mentor: 12 | Aktif Membimbing: 9</p>
        </div>
        <button onclick="openModal()" 
            class="px-5 py-2 bg-white/20 hover:bg-white/30 rounded-lg text-white font-medium flex items-center gap-2 transition-all duration-200 hover:scale-[1.03]">
            <i class="fas fa-user-plus"></i> Tambah Mentor
        </button>
    </div>

    <!-- FILTER -->
    <div class="bg-white p-5 rounded-2xl shadow flex flex-col lg:flex-row justify-between items-center gap-4">
        <div class="flex flex-wrap gap-4 w-full lg:w-auto">
            <div>
                <label for="filterDirektorat" class="block text-sm font-medium text-gray-600">Direktorat</label>
                <select id="filterDirektorat" class="border border-gray-300 rounded-lg p-2 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option>Semua Direktorat</option>
                    <option>Direktorat Utama</option>
                    <option>Direktorat Operasi</option>
                    <option>Direktorat Sales & Marketing</option>
                    <option>Direktorat Finance & Business Support</option>
                </select>
            </div>
            
            <div>
                <label for="filterFungsi" class="block text-sm font-medium text-gray-600">Fungsi</label>
                <select id="filterFungsi" class="border border-gray-300 rounded-lg p-2 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option>Semua Fungsi</option>
                    <option>Human Capital</option>
                    <option>Training & Development</option>
                    <option>Sales Strategy</option>
                    <option>Supply Chain</option>
                    <option>Finance & Accounting</option>
                    <option>IT Support</option>
                    <option>Corporate Communication</option>
                    <!-- bisa kamu tambahkan sesuai kebutuhan -->
                </select>
            </div>


            <div>
                <label for="filterStatus" class="block text-sm font-medium text-gray-600">Status</label>
                <select id="filterStatus" class="border border-gray-300 rounded-lg p-2 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option>Semua</option>
                    <option>Aktif</option>
                    <option>Tidak Aktif</option>
                </select>
            </div>
        </div>

        <div class="relative w-full lg:w-1/3">
            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
            <input type="text" id="searchInput" placeholder="Cari nama mentor..." 
                class="pl-9 w-full border border-gray-300 rounded-lg p-2 text-sm focus:ring-indigo-500 focus:border-indigo-500">
        </div>
    </div>

    <!-- TABEL MENTOR -->
    <div class="bg-white rounded-2xl shadow-lg p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
            <i class="fas fa-table"></i> Daftar Mentor
        </h3>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-gray-700 border border-gray-200 rounded-xl overflow-hidden" id="tableMentor">
                <thead class="bg-gray-100 text-gray-800">
                    <tr>
                        <th class="px-4 py-2 text-left font-semibold">Nama Mentor</th>
                        <th class="px-4 py-2 text-left font-semibold">Direktorat</th>
                        <th class="px-4 py-2 text-left font-semibold">Fungsi</th>
                        <th class="px-4 py-2 text-center font-semibold">Jumlah Bimbingan</th>
                        <th class="px-4 py-2 text-center font-semibold">Status</th>
                        <th class="px-4 py-2 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b hover:bg-indigo-50 transition">
                        <td class="px-4 py-2 font-medium flex items-center gap-3">
                            <img src="https://ui-avatars.com/api/?name=Andhika+Putra&background=6366f1&color=fff" class="w-8 h-8 rounded-full shadow-sm">
                            Andhika Putra
                        </td>
                        <td class="px-4 py-2">Direktorat Utama</td>
                        <td class="px-4 py-2">Corporate Communication</td>
                        <td class="px-4 py-2 text-center">4 Mahasiswa</td>
                        <td class="px-4 py-2 text-center">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">Aktif</span>
                        </td>
                        <td class="px-4 py-2 text-center">
                            <button class="px-3 py-1 text-xs rounded-lg bg-indigo-500 text-white hover:bg-indigo-600 transition" onclick="openDetail()">Lihat Detail</button>
                        </td>
                    </tr>
                
                    <tr class="border-b hover:bg-indigo-50 transition">
                        <td class="px-4 py-2 font-medium flex items-center gap-3">
                            <img src="https://ui-avatars.com/api/?name=Siti+Nuraeni&background=6366f1&color=fff" class="w-8 h-8 rounded-full shadow-sm">
                            Siti Nuraeni
                        </td>
                        <td class="px-4 py-2">Direktorat Operasi</td>
                        <td class="px-4 py-2">Supply Chain</td>
                        <td class="px-4 py-2 text-center">6 Mahasiswa</td>
                        <td class="px-4 py-2 text-center">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">Aktif</span>
                        </td>
                        <td class="px-4 py-2 text-center">
                            <button class="px-3 py-1 text-xs rounded-lg bg-indigo-500 text-white hover:bg-indigo-600 transition" onclick="openDetail()">Lihat Detail</button>
                        </td>
                    </tr>
                
                    <tr class="border-b hover:bg-indigo-50 transition">
                        <td class="px-4 py-2 font-medium flex items-center gap-3">
                            <img src="https://ui-avatars.com/api/?name=Fajar+Ramadan&background=6366f1&color=fff" class="w-8 h-8 rounded-full shadow-sm">
                            Fajar Ramadan
                        </td>
                        <td class="px-4 py-2">Direktorat Sales & Marketing</td>
                        <td class="px-4 py-2">Sales Strategy</td>
                        <td class="px-4 py-2 text-center">3 Mahasiswa</td>
                        <td class="px-4 py-2 text-center">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">Aktif</span>
                        </td>
                        <td class="px-4 py-2 text-center">
                            <button class="px-3 py-1 text-xs rounded-lg bg-indigo-500 text-white hover:bg-indigo-600 transition" onclick="openDetail()">Lihat Detail</button>
                        </td>
                    </tr>
                
                    <tr class="border-b hover:bg-indigo-50 transition">
                        <td class="px-4 py-2 font-medium flex items-center gap-3">
                            <img src="https://ui-avatars.com/api/?name=Aulia+Rahma&background=6366f1&color=fff" class="w-8 h-8 rounded-full shadow-sm">
                            Aulia Rahma
                        </td>
                        <td class="px-4 py-2">Direktorat Finance & Business Support</td>
                        <td class="px-4 py-2">Finance & Accounting</td>
                        <td class="px-4 py-2 text-center">5 Mahasiswa</td>
                        <td class="px-4 py-2 text-center">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-gray-200 text-gray-600">Tidak Aktif</span>
                        </td>
                        <td class="px-4 py-2 text-center">
                            <button class="px-3 py-1 text-xs rounded-lg bg-indigo-500 text-white hover:bg-indigo-600 transition" onclick="openDetail()">Lihat Detail</button>
                        </td>
                    </tr>
                
                    <tr class="border-b hover:bg-indigo-50 transition">
                        <td class="px-4 py-2 font-medium flex items-center gap-3">
                            <img src="https://ui-avatars.com/api/?name=Dewi+Anggraini&background=6366f1&color=fff" class="w-8 h-8 rounded-full shadow-sm">
                            Dewi Anggraini
                        </td>
                        <td class="px-4 py-2">Direktorat Utama</td>
                        <td class="px-4 py-2">Human Capital</td>
                        <td class="px-4 py-2 text-center">4 Mahasiswa</td>
                        <td class="px-4 py-2 text-center">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">Aktif</span>
                        </td>
                        <td class="px-4 py-2 text-center">
                            <button class="px-3 py-1 text-xs rounded-lg bg-indigo-500 text-white hover:bg-indigo-600 transition" onclick="openDetail()">Lihat Detail</button>
                        </td>
                    </tr>
                
                    <tr class="border-b hover:bg-indigo-50 transition">
                        <td class="px-4 py-2 font-medium flex items-center gap-3">
                            <img src="https://ui-avatars.com/api/?name=Rizki+Santoso&background=6366f1&color=fff" class="w-8 h-8 rounded-full shadow-sm">
                            Rizki Santoso
                        </td>
                        <td class="px-4 py-2">Direktorat Operasi</td>
                        <td class="px-4 py-2">IT Support</td>
                        <td class="px-4 py-2 text-center">2 Mahasiswa</td>
                        <td class="px-4 py-2 text-center">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">Aktif</span>
                        </td>
                        <td class="px-4 py-2 text-center">
                            <button class="px-3 py-1 text-xs rounded-lg bg-indigo-500 text-white hover:bg-indigo-600 transition" onclick="openDetail()">Lihat Detail</button>
                        </td>
                    </tr>
                
                    <tr class="border-b hover:bg-indigo-50 transition">
                        <td class="px-4 py-2 font-medium flex items-center gap-3">
                            <img src="https://ui-avatars.com/api/?name=Putri+Maharani&background=6366f1&color=fff" class="w-8 h-8 rounded-full shadow-sm">
                            Putri Maharani
                        </td>
                        <td class="px-4 py-2">Direktorat Sales & Marketing</td>
                        <td class="px-4 py-2">Corporate Communication</td>
                        <td class="px-4 py-2 text-center">1 Mahasiswa</td>
                        <td class="px-4 py-2 text-center">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-gray-200 text-gray-600">Tidak Aktif</span>
                        </td>
                        <td class="px-4 py-2 text-center">
                            <button class="px-3 py-1 text-xs rounded-lg bg-indigo-500 text-white hover:bg-indigo-600 transition" onclick="openDetail()">Lihat Detail</button>
                        </td>
                    </tr>
                
                    <tr class="border-b hover:bg-indigo-50 transition">
                        <td class="px-4 py-2 font-medium flex items-center gap-3">
                            <img src="https://ui-avatars.com/api/?name=Ferdiansyah+Adi&background=6366f1&color=fff" class="w-8 h-8 rounded-full shadow-sm">
                            Ferdiansyah Adi
                        </td>
                        <td class="px-4 py-2">Direktorat Finance & Business Support</td>
                        <td class="px-4 py-2">Training & Development</td>
                        <td class="px-4 py-2 text-center">3 Mahasiswa</td>
                        <td class="px-4 py-2 text-center">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">Aktif</span>
                        </td>
                        <td class="px-4 py-2 text-center">
                            <button class="px-3 py-1 text-xs rounded-lg bg-indigo-500 text-white hover:bg-indigo-600 transition" onclick="openDetail()">Lihat Detail</button>
                        </td>
                    </tr>
                
                    <tr class="border-b hover:bg-indigo-50 transition">
                        <td class="px-4 py-2 font-medium flex items-center gap-3">
                            <img src="https://ui-avatars.com/api/?name=Nurul+Fajriah&background=6366f1&color=fff" class="w-8 h-8 rounded-full shadow-sm">
                            Nurul Fajriah
                        </td>
                        <td class="px-4 py-2">Direktorat Utama</td>
                        <td class="px-4 py-2">Corporate Communication</td>
                        <td class="px-4 py-2 text-center">2 Mahasiswa</td>
                        <td class="px-4 py-2 text-center">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-gray-200 text-gray-600">Tidak Aktif</span>
                        </td>
                        <td class="px-4 py-2 text-center">
                            <button class="px-3 py-1 text-xs rounded-lg bg-indigo-500 text-white hover:bg-indigo-600 transition" onclick="openDetail()">Lihat Detail</button>
                        </td>
                    </tr>
                
                    <tr class="border-b hover:bg-indigo-50 transition">
                        <td class="px-4 py-2 font-medium flex items-center gap-3">
                            <img src="https://ui-avatars.com/api/?name=Bayu+Pratama&background=6366f1&color=fff" class="w-8 h-8 rounded-full shadow-sm">
                            Bayu Pratama
                        </td>
                        <td class="px-4 py-2">Direktorat Operasi</td>
                        <td class="px-4 py-2">IT Support</td>
                        <td class="px-4 py-2 text-center">6 Mahasiswa</td>
                        <td class="px-4 py-2 text-center">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">Aktif</span>
                        </td>
                        <td class="px-4 py-2 text-center">
                            <button class="px-3 py-1 text-xs rounded-lg bg-indigo-500 text-white hover:bg-indigo-600 transition" onclick="openDetail()">Lihat Detail</button>
                        </td>
                    </tr>
                </tbody>

            </table>
        </div>
    </div>
</div>

<!-- MODAL DETAIL MENTOR -->
<div id="detailModal" class="hidden fixed inset-0 bg-black/60 flex items-center justify-center z-50 backdrop-blur-sm">
    <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-4xl relative animate-fade-in overflow-y-auto max-h-[90vh]">
        <button onclick="closeDetail()" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
            <i class="fas fa-times"></i>
        </button>

        <!-- Header -->
        <div class="flex items-center gap-4 border-b pb-4 mb-6">
            <img src="https://ui-avatars.com/api/?name=Andi+Saputra&background=6366f1&color=fff" class="w-20 h-20 rounded-full shadow-md">
            <div>
                <h3 class="text-xl font-bold text-gray-800">Andi Saputra</h3>
                <p class="text-sm text-gray-500">Supervisor HR • Human Capital</p>
                <p class="text-sm text-gray-400">andi.saputra@pertamina.com</p>
            </div>
        </div>

        <!-- Informasi Mentor -->
        <h4 class="font-semibold text-indigo-700 mb-2 flex items-center gap-2">
            <i class="fas fa-id-card-alt"></i> Informasi Mentor
        </h4>
        <div class="grid grid-cols-2 gap-x-8 gap-y-2 text-sm mb-6">
            <p><strong>Direktorat:</strong> Human Capital</p>
            <p><strong>Fungsi:</strong> Pengembangan SDM</p>
            <p><strong>Jabatan:</strong> Supervisor</p>
            <p><strong>Status:</strong> Aktif</p>
        </div>

        <!-- Mahasiswa Bimbingan -->
        <h4 class="font-semibold text-indigo-700 mb-2 flex items-center gap-2">
            <i class="fas fa-users"></i> Mahasiswa Bimbingan
        </h4>
        <table class="w-full text-sm border border-gray-200 rounded-lg overflow-hidden mb-6">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="py-2 px-3 text-left font-semibold">Nama</th>
                    <th class="py-2 px-3 text-left font-semibold">Kampus</th>
                    <th class="py-2 px-3 text-center font-semibold">Periode</th>
                    <th class="py-2 px-3 text-center font-semibold">Status Magang</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-t hover:bg-gray-50">
                    <td class="py-2 px-3">Joevanz Mikail</td>
                    <td class="py-2 px-3">Universitas Airlangga</td>
                    <td class="py-2 px-3 text-center">Jan–Jun 2025</td>
                    <td class="py-2 px-3 text-center"><span class="px-3 py-1 rounded-full text-xs bg-indigo-100 text-indigo-700">Internship</span></td>
                </tr>
                <tr class="border-t hover:bg-gray-50">
                    <td class="py-2 px-3">Siti Nurhaliza</td>
                    <td class="py-2 px-3">ITS</td>
                    <td class="py-2 px-3 text-center">Jan–Jun 2025</td>
                    <td class="py-2 px-3 text-center"><span class="px-3 py-1 rounded-full text-xs bg-yellow-100 text-yellow-700">PKL</span></td>
                </tr>
            </tbody>
        </table>

        <!-- Tombol -->
        <div class="flex justify-end gap-3 border-t pt-4">
            <button onclick="closeDetail()" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg">Tutup</button>
            <button class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg">Edit Mentor</button>
        </div>
    </div>
</div>

<!-- MODAL TAMBAH MENTOR -->
<div id="addModal" class="hidden fixed inset-0 bg-black/60 flex items-center justify-center z-50 backdrop-blur-sm">
    <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-2xl relative animate-fade-in overflow-y-auto max-h-[90vh]">
        <button onclick="closeModal()" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
            <i class="fas fa-times"></i>
        </button>

        <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
            <i class="fas fa-user-plus text-indigo-600"></i> Tambah Mentor Baru
        </h3>

        <form id="mentorForm" onsubmit="addMentor(event)" class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="text-sm font-semibold text-gray-700">Nama Mentor</label>
                <input type="text" id="namaMentor" class="w-full border rounded-lg p-2 mt-1">
            </div>
            <div>
                <label class="text-sm font-semibold text-gray-700">Email</label>
                <input type="email" id="emailMentor" class="w-full border rounded-lg p-2 mt-1">
            </div>
            <div>
                <label class="text-sm font-semibold text-gray-700">Direktorat</label>
                <input type="text" id="direktoratMentor" class="w-full border rounded-lg p-2 mt-1">
            </div>
            <div>
                <label class="text-sm font-semibold text-gray-700">Fungsi</label>
                <input type="text" id="fungsiMentor" class="w-full border rounded-lg p-2 mt-1">
            </div>
            <div>
                <label class="text-sm font-semibold text-gray-700">Jabatan</label>
                <input type="text" id="jabatanMentor" class="w-full border rounded-lg p-2 mt-1">
            </div>
            <div>
                <label class="text-sm font-semibold text-gray-700">Status</label>
                <select id="statusMentor" class="w-full border rounded-lg p-2 mt-1">
                    <option>Aktif</option>
                    <option>Tidak Aktif</option>
                </select>
            </div>

            <div class="col-span-2 text-right mt-4">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg">
                    <i class="fas fa-save mr-2"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<style>
@keyframes fadeIn { from { opacity: 0; transform: translateY(10px);} to { opacity: 1; transform: translateY(0);} }
.animate-fade-in { animation: fadeIn 0.3s ease-out; }
</style>

<script>
function openDetail() {
    document.getElementById('detailModal').classList.remove('hidden');
}
function closeDetail() {
    document.getElementById('detailModal').classList.add('hidden');
}
function openModal() {
    document.getElementById('addModal').classList.remove('hidden');
}
function closeModal() {
    document.getElementById('addModal').classList.add('hidden');
}

const filterDirektorat = document.getElementById('filterDirektorat');
const filterFungsi = document.getElementById('filterFungsi');
const filterStatus = document.getElementById('filterStatus');
const searchInput = document.getElementById('searchInput');
const tableMentor = document.getElementById('tableMentor').getElementsByTagName('tbody')[0];

// ✅ MAIN FILTER FUNCTION
function applyFilters() {
    const dirVal = filterDirektorat.value.toLowerCase();
    const funVal = filterFungsi ? filterFungsi.value.toLowerCase() : "semua fungsi";
    const statVal = filterStatus.value.toLowerCase();
    const searchVal = searchInput.value.toLowerCase();

    Array.from(tableMentor.rows).forEach(row => {
        const nama = row.cells[0].innerText.toLowerCase();
        const direktorat = row.cells[1].innerText.toLowerCase();
        const fungsi = row.cells[2].innerText.toLowerCase();
        const status = row.cells[4].innerText.toLowerCase();

        const matchNama = nama.includes(searchVal);
        const matchDir = dirVal === "semua direktorat" || direktorat.includes(dirVal);
        const matchFun = funVal === "semua fungsi" || fungsi.includes(funVal);
        const matchStat = statVal === "semua" || status.includes(statVal);

        if (matchNama && matchDir && matchFun && matchStat) {
            row.classList.remove('hidden');
        } else {
            row.classList.add('hidden');
        }
    });
}

// ✅ Event listeners untuk semua filter
filterDirektorat.addEventListener('change', applyFilters);
if(filterFungsi) filterFungsi.addEventListener('change', applyFilters);
filterStatus.addEventListener('change', applyFilters);
searchInput.addEventListener('keyup', applyFilters);

// ✅ Add Mentor ke tabel
function addMentor(event) {
    event.preventDefault();
    const nama = document.getElementById('namaMentor').value;
    const email = document.getElementById('emailMentor').value;
    const direktorat = document.getElementById('direktoratMentor').value;
    const fungsi = document.getElementById('fungsiMentor').value;
    const jabatan = document.getElementById('jabatanMentor').value;
    const status = document.getElementById('statusMentor').value;

    if (!nama || !email) {
        alert("Nama dan Email wajib diisi!");
        return;
    }

    const newRow = document.createElement('tr');
    newRow.classList.add('border-b', 'hover:bg-indigo-50', 'transition');
    newRow.innerHTML = `
        <td class="px-4 py-2 font-medium flex items-center gap-3">
            <img src="https://ui-avatars.com/api/?name=${encodeURIComponent(nama)}&background=6366f1&color=fff"
                class="w-8 h-8 rounded-full shadow-sm">
            ${nama}
        </td>
        <td class="px-4 py-2">${direktorat || '-'}</td>
        <td class="px-4 py-2">${fungsi || '-'}</td>
        <td class="px-4 py-2 text-center">0 Mahasiswa</td>
        <td class="px-4 py-2 text-center">
            <span class="px-3 py-1 rounded-full text-xs font-semibold 
            ${status === 'Aktif' ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-600'}">
                ${status}
            </span>
        </td>
        <td class="px-4 py-2 text-center">
            <button class="px-3 py-1 text-xs rounded-lg bg-indigo-500 text-white hover:bg-indigo-600 transition" onclick="openDetail()">Lihat Detail</button>
        </td>
    `;
    
    tableMentor.appendChild(newRow);

    document.getElementById('mentorForm').reset();
    closeModal();
    applyFilters();
}
</script>

@endsection
