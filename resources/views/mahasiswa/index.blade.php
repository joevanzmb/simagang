@extends('layouts.app', ['noHeader' => true])

@section('pageTitle', 'Data Mahasiswa Magang')
@section('pageSubtitle', 'Pantau, verifikasi, dan kelola data mahasiswa magang secara terpusat')

@section('content')
<div class="space-y-10">

    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-center text-white p-7 rounded-2xl shadow-lg"
        style="background: linear-gradient(135deg, #5a6de0 0%, #6c3fb0 100%);">
        <div>
            <h2 class="text-2xl font-bold flex items-center gap-5 leading-tight">
                <i class="fas fa-users text-4xl"></i> Data Mahasiswa Magang
            </h2>
            <p class="text-m text-white/90 mt-2">Total mahasiswa: 48 | Terverifikasi: 31</p>
        </div>
        <button
            class="px-5 py-2 bg-white/20 hover:bg-white/30 rounded-lg text-white font-medium flex items-center gap-2 transition-all duration-200 hover:scale-[1.03]">
            <i class="fas fa-user-plus"></i> Tambah Mahasiswa
        </button>
    </div>

    <!-- Tabs -->
    <div class="flex gap-2 bg-white p-2 rounded-xl shadow-sm w-fit mx-auto">
        <button id="tabMahasiswa"
            class="px-5 py-2 text-sm font-semibold rounded-lg bg-indigo-600 text-white transition">Data
            Mahasiswa</button>
        <button id="tabPerpanjangan"
            class="px-5 py-2 text-sm font-semibold rounded-lg text-gray-700 hover:bg-gray-100 transition">Permohonan Perpanjangan</button>
    </div>

    <!-- ===================== TAB 1: Data Mahasiswa ===================== -->
    <div id="sectionMahasiswa" class="bg-white rounded-2xl shadow-lg p-6 space-y-6">
    
      <!-- Filter Layout Baru -->
      <div class="space-y-4">
        
        <!-- 🔹 Baris Pertama → Kampus, Jurusan, Status -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
          <!-- Filter Kampus -->
          <div>
            <label for="filterKampus" class="block text-xs font-medium text-gray-600">Kampus</label>
            <select id="filterKampus"
              class="border border-gray-300 rounded-lg p-2 text-sm focus:ring-indigo-500 focus:border-indigo-500 w-full">
              <option value="all">Semua Kampus</option>
              <option>Universitas Airlangga</option>
              <option>ITS</option>
              <option>UPN</option>
            </select>
          </div>
    
          <!-- Filter Jurusan -->
          <div>
            <label for="filterJurusan" class="block text-xs font-medium text-gray-600">Jurusan</label>
            <select id="filterJurusan"
              class="border border-gray-300 rounded-lg p-2 text-sm focus:ring-indigo-500 focus:border-indigo-500 w-full">
              <option value="all">Semua Jurusan</option>
              <option>Sistem Informasi</option>
              <option>Teknik Informatika</option>
              <option>Manajemen</option>
              <option>Administrasi Bisnis</option>
            </select>
          </div>
    
          <!-- Filter Status -->
          <div>
            <label for="filterStatus" class="block text-xs font-medium text-gray-600">Status</label>
            <select id="filterStatus"
              class="border border-gray-300 rounded-lg p-2 text-sm focus:ring-indigo-500 focus:border-indigo-500 w-full">
              <option value="all">Semua Status</option>
              <option value="internship">Internship</option>
              <option value="pkl">PKL</option>
            </select>
          </div>
        </div>
    
        <!-- 🔹 Baris Kedua → Direktorat, Fungsi, Sub Fungsi -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
          <!-- Direktorat -->
          <div>
            <label for="filterDirektorat" class="block text-xs font-medium text-gray-600">Direktorat</label>
            <select id="filterDirektorat"
              class="border border-gray-300 rounded-lg p-2 text-sm focus:ring-indigo-500 focus:border-indigo-500 w-full">
              <option value="all">Semua Direktorat</option>
              <option value="utama">Direktorat Utama</option>
              <option value="operasi">Direktorat Operasi</option>
              <option value="sales">Sales & Marketing</option>
              <option value="finance">Finance & Business Support</option>
            </select>
          </div>
        
    
          <!-- Fungsi -->
          <div>
            <label for="filterFungsi" class="block text-xs font-medium text-gray-600">Fungsi</label>
            <select id="filterFungsi"
              class="border border-gray-300 rounded-lg p-2 text-sm focus:ring-indigo-500 focus:border-indigo-500 w-full">
              <option value="all">Semua Fungsi</option>
              <option value="human capital">Human Capital</option>
              <option value="marketing retail">Marketing Retail</option>
              <option value="supply chain">Supply Chain</option>
              <option value="keuangan">Keuangan</option>
            </select>
          </div>
    
          <!-- Filter Sub Fungsi (Search dari data tabel) -->
          <div class="relative">
            <label for="filterSubFungsi" class="block text-xs font-medium text-gray-600">Sub Fungsi</label>
            <input type="text" id="filterSubFungsi" placeholder="Cari sub fungsi..."
                class="border border-gray-300 rounded-lg p-2 text-sm w-full focus:ring-indigo-500 focus:border-indigo-500"
                onfocus="showSubFungsiDropdown()" oninput="filterSubFungsiOptions(this.value)">
              
            <!-- Dropdown otomatis -->
            <div id="subFungsiDropdown"
                 class="absolute z-10 mt-1 bg-white border border-gray-200 rounded-lg shadow-md w-full max-h-48 overflow-y-auto hidden">
                     <!-- isi akan di-generate otomatis -->
            </div>
          </div>
        </div>

    
        <!-- 🔹 Baris Ketiga → Search -->
        <div class="relative max-w-lg">
          <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
          <input type="text" id="searchInput" placeholder="Cari nama mahasiswa..."
            class="pl-9 w-full border border-gray-300 rounded-lg p-2 text-sm focus:ring-indigo-500 focus:border-indigo-500">
        </div>
    
      </div>



        <!-- Tabel Mahasiswa -->
        <div class="overflow-x-auto">
          <table class="min-w-full text-sm text-gray-700 border border-gray-200 rounded-xl overflow-hidden"
              id="tableMahasiswa">
            <thead class="bg-gray-100 text-gray-800">
              <tr>
                <th class="px-4 py-2 text-left font-semibold">Nama</th>
                <th class="px-4 py-2 text-left font-semibold">Kampus</th>
                <th class="px-4 py-2 text-left font-semibold">Jurusan</th>
                <th class="px-4 py-2 text-center font-semibold">Status</th>
                <th class="px-4 py-2 text-left font-semibold">Direktorat</th>
                <th class="px-4 py-2 text-left font-semibold">Fungsi</th>
                <th class="px-4 py-2 text-left font-semibold">Sub Fungsi</th>
                <th class="px-4 py-2 text-center font-semibold">Mentor</th>
                <th class="px-4 py-2 text-center font-semibold">Periode</th>
                <th class="px-4 py-2 text-center font-semibold">Aksi</th>
              </tr>
            </thead>
        
            <tbody>
              @php
              $mahasiswaData = [
                  [
                      'nama' => 'Joevanz Mikail',
                      'kampus' => 'Universitas Airlangga',
                      'jurusan' => 'Sistem Informasi',
                      'status' => 'Internship',
                      'direktorat' => 'Direktorat Utama',
                      'fungsi' => 'Corporate Communication',
                      'subfungsi' => 'Public Relations',
                      'mentor' => 'Andhika Putra',
                      'periode' => 'Jan – Jun 2025',
                  ],
                  [
                      'nama' => 'Siti Rahmawati',
                      'kampus' => 'ITS',
                      'jurusan' => 'Teknik Informatika',
                      'status' => 'PKL',
                      'direktorat' => 'Direktorat Operasi',
                      'fungsi' => 'Supply Chain',
                      'subfungsi' => 'Inventory Management',
                      'mentor' => 'Siti Nuraeni',
                      'periode' => 'Feb – Jul 2025',
                  ],
                  [
                      'nama' => 'Rizal Fadilah',
                      'kampus' => 'UPN Veteran Jatim',
                      'jurusan' => 'Administrasi Bisnis',
                      'status' => 'Internship',
                      'direktorat' => 'Sales & Marketing',
                      'fungsi' => 'Sales Strategy',
                      'subfungsi' => 'Customer Engagement',
                      'mentor' => 'Fajar Ramadan',
                      'periode' => 'Jan – Jun 2025',
                  ],
              ];
              @endphp
        
              @foreach($mahasiswaData as $mhs)
              <tr class="border-b hover:bg-indigo-50 transition">
                <td class="px-4 py-2 font-medium flex items-center gap-3">
                  <img src="https://ui-avatars.com/api/?name={{ urlencode($mhs['nama']) }}&background=6366f1&color=fff"
                      class="w-8 h-8 rounded-full shadow-sm">
                  {{ $mhs['nama'] }}
                </td>
        
                <td class="px-4 py-2">{{ $mhs['kampus'] }}</td>
                <td class="px-4 py-2 text-gray-700">{{ $mhs['jurusan'] }}</td>
        
                <td class="px-4 py-2 text-center">
                  <span class="px-3 py-1 rounded-full text-xs font-semibold
                    {{ $mhs['status'] === 'Internship' ? 'bg-indigo-100 text-indigo-700' : 'bg-yellow-100 text-yellow-700' }}">
                    {{ $mhs['status'] }}
                  </span>
                </td>
        
                <td class="px-4 py-2">{{ $mhs['direktorat'] }}</td>
                <td class="px-4 py-2">{{ $mhs['fungsi'] }}</td>
                <td class="px-4 py-2">{{ $mhs['subfungsi'] }}</td>
                <td class="px-4 py-2 text-center">{{ $mhs['mentor'] }}</td>
                <td class="px-4 py-2 text-center">{{ $mhs['periode'] }}</td>
        
                <td class="px-4 py-2 text-center">
                  <button
                      class="px-3 py-1 text-xs rounded-lg bg-indigo-500 text-white hover:bg-indigo-600 transition"
                      onclick="openDetail()">Lihat Detail</button>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>

    </div>

    <!-- ===================== TAB 2: Persetujuan Perpanjangan ===================== -->
    <div id="sectionPerpanjangan" class="hidden bg-white rounded-2xl shadow-lg p-6 space-y-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
            <i class="fas fa-calendar-plus text-indigo-600"></i> Daftar Pengajuan Perpanjangan
        </h3>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-gray-700 border border-gray-200 rounded-xl overflow-hidden">
                <thead class="bg-gray-100 text-gray-800">
                    <tr>
                        <th class="px-4 py-2 text-left font-semibold">Mahasiswa</th>
                        <th class="px-4 py-2 text-center font-semibold">Mentor</th>
                        <th class="px-4 py-2 text-center font-semibold">Periode Lama</th>
                        <th class="px-4 py-2 text-center font-semibold">Periode Baru</th>
                        <th class="px-4 py-2 text-center font-semibold">Alasan</th>
                        <th class="px-4 py-2 text-center font-semibold">Status</th>
                        <th class="px-4 py-2 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b hover:bg-indigo-50 transition">
                        <td class="px-4 py-2 font-medium flex items-center gap-3">
                            <img src="https://ui-avatars.com/api/?name=Joevanz+Mikail&background=6366f1&color=fff"
                                class="w-8 h-8 rounded-full shadow-sm">
                            Joevanz Mikail
                        </td>
                        <td class="px-4 py-2 text-center">Bapak Andi Saputra</td>
                        <td class="px-4 py-2 text-center">Jan – Jun 2025</td>
                        <td class="px-4 py-2 text-center">Jan – Jul 2025</td>
                        <td class="px-4 py-2 text-center text-gray-600 italic">Proyek magang belum rampung</td>
                        <td id="statusPerpanjangan" class="px-4 py-2 text-center">
                            <span
                                class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">Menunggu
                                Persetujuan</span>
                        </td>
                        <td class="px-4 py-2 text-center space-x-2">
                            <button
                                class="px-3 py-1 text-xs rounded-lg bg-green-500 text-white hover:bg-green-600 transition"
                                onclick="approveExtend()">Setujui</button>
                            <button
                                class="px-3 py-1 text-xs rounded-lg bg-red-500 text-white hover:bg-red-600 transition"
                                onclick="rejectExtend(this)">Tolak</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Detail Mahasiswa -->
<div id="detailModal"
    class="hidden fixed inset-0 bg-black/60 flex items-center justify-center z-50 backdrop-blur-sm">
    <div
        class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-4xl relative animate-fade-in overflow-y-auto max-h-[90vh]">
        <button onclick="closeDetail()" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
            <i class="fas fa-times"></i>
        </button>

        <!-- Header Mahasiswa -->
        <div class="flex items-center gap-4 border-b pb-4 mb-6">
            <img src="https://ui-avatars.com/api/?name=Joevanz+Mikail&background=6366f1&color=fff"
                class="w-20 h-20 rounded-full shadow-md">
            <div>
                <h3 class="text-xl font-bold text-gray-800">Joevanz Mikail</h3>
                <p class="text-sm text-gray-500">NIM: 187221077 • Universitas Airlangga</p>
            </div>
        </div>

        <!-- Data Diri -->
        <h4 class="font-semibold text-indigo-700 mb-2 flex items-center gap-2">
            <i class="fas fa-id-card-alt"></i> Data Diri
        </h4>
        <div class="grid grid-cols-2 gap-x-8 gap-y-2 text-sm mb-6">
            <p><strong>Jenis Kelamin:</strong> Laki-laki</p>
            <p><strong>Tanggal Lahir:</strong> 20 Juli 2002</p>
            <p><strong>Kontak:</strong> +62 812 3456 7890</p>
            <p><strong>Jurusan:</strong> Sistem Informasi</p>

            <p><strong>Tahun Lulus:</strong> 2025</p>
        </div>

        <!-- Informasi Magang -->
        <h4 class="font-semibold text-indigo-700 mb-2 flex items-center gap-2">
            <i class="fas fa-briefcase"></i> Informasi Magang
        </h4>
        <div class="grid grid-cols-2 gap-x-8 gap-y-2 text-sm mb-6">
            <p><strong>Periode:</strong> Jan 2025 – Jun 2025</p>
            <p><strong>Nama Mentor:</strong> Bapak Andi Saputra</p>
            <p><strong>Direktorat:</strong> Human Capital</p>
            <p><strong>Fungsi:</strong> Pengembangan SDM</p>
            <p><strong>Status:</strong> Internship</p>
        </div>

        <!-- Rekening -->
        <h4 class="font-semibold text-indigo-700 mb-2 flex items-center gap-2">
            <i class="fas fa-credit-card"></i> Rekening
        </h4>
        <div class="grid grid-cols-2 gap-x-8 gap-y-2 text-sm mb-6">
            <p><strong>Bank:</strong> BCA</p>
            <p><strong>Nomor Rekening:</strong> 1234567890</p>
        </div>

        <!-- Berkas -->
        <h4 class="font-semibold text-indigo-700 mb-2 flex items-center gap-2">
            <i class="fas fa-folder-open"></i> Berkas
        </h4>
        <ul class="list-disc pl-5 text-gray-700 text-sm mb-8 space-y-1">
            <li>📄 Proposal Magang.pdf</li>
            <li>📎 Surat Pengantar Kampus.pdf</li>
            <li>🤝 MOU Magang.pdf</li>
            <li>🧾 CV Joevanz.pdf</li>
        </ul>

        <!-- Tombol Aksi -->
        <div class="flex justify-end gap-3 border-t pt-4">
            <button onclick="closeDetail()" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg">Tutup</button>
            <button class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg">Edit Profil</button>
            <button class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg">Verifikasi Data</button>
        </div>
    </div>
</div>


<!-- Modal Alasan Penolakan -->
<div id="modalAlasan" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded-xl shadow-lg w-full max-w-md relative">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Tulis Alasan Penolakan</h3>

        <textarea id="alasanInput"
            class="w-full border rounded-lg p-3 text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500"
            rows="3" placeholder="Contoh: Proyek sudah selesai sehingga tidak perlu diperpanjang."></textarea>

        <div class="flex justify-end gap-3 mt-5">
            <button onclick="closeAlasan()" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg text-sm">
                Batal
            </button>
            <button onclick="submitAlasan()" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm">
                Tolak Pengajuan
            </button>
        </div>
    </div>
</div>


<style>
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px)
    }

    to {
        opacity: 1;
        transform: translateY(0)
    }
}

.animate-fade-in {
    animation: fadeIn 0.3s ease-out
}
</style>

<script>
// ========================= MODAL DETAIL =========================
function openDetail() {
    document.getElementById('detailModal').classList.remove('hidden');
}
function closeDetail() {
    document.getElementById('detailModal').classList.add('hidden');
}

// ========================= TAB SWITCH =========================
document.getElementById('tabMahasiswa').addEventListener('click', () => {
    document.getElementById('sectionMahasiswa').classList.remove('hidden');
    document.getElementById('sectionPerpanjangan').classList.add('hidden');
    document.getElementById('tabMahasiswa').classList.add('bg-indigo-600', 'text-white');
    document.getElementById('tabPerpanjangan').classList.remove('bg-indigo-600', 'text-white');
});

document.getElementById('tabPerpanjangan').addEventListener('click', () => {
    document.getElementById('sectionMahasiswa').classList.add('hidden');
    document.getElementById('sectionPerpanjangan').classList.remove('hidden');
    document.getElementById('tabPerpanjangan').classList.add('bg-indigo-600', 'text-white');
    document.getElementById('tabMahasiswa').classList.remove('bg-indigo-600', 'text-white');
});

// ========================= APPROVE / REJECT =========================
let targetStatusCell = null;
function approveExtend() {
    const status = document.getElementById('statusPerpanjangan');
    status.innerHTML = `<span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">Disetujui</span>`;
    alert('✅ Perpanjangan telah disetujui dan diperbarui.');
}
function rejectExtend(el) {
    targetStatusCell = el.closest("tr").querySelector("#statusPerpanjangan");
    document.getElementById("modalAlasan").classList.remove("hidden");
}
function closeAlasan() {
    document.getElementById("modalAlasan").classList.add("hidden");
    document.getElementById("alasanInput").value = "";
}
function submitAlasan() {
    const alasan = document.getElementById("alasanInput").value.trim();
    if (!alasan) {
        alert("⚠️ Harap berikan alasan penolakan.");
        return;
    }
    targetStatusCell.innerHTML = `
        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
            Ditolak
        </span>
        <p class="text-[11px] text-gray-500 italic mt-1">${alasan}</p>
    `;
    closeAlasan();
    alert('❌ Pengajuan perpanjangan ditolak.');
}

// ========================= FILTERING =========================
let selectedSubFungsi = 'all';
let allSubFungsi = [];

window.addEventListener('DOMContentLoaded', () => {
    generateSubFungsiList();

    // Event listener untuk dropdown biasa
    document.querySelectorAll('#filterKampus, #filterStatus, #filterDirektorat, #filterFungsi')
        .forEach(filter => filter.addEventListener('change', applyFilters));

    document.getElementById('searchInput').addEventListener('input', applyFilters);
});

// 🔹 Generate otomatis isi dropdown Sub Fungsi dari tabel
function generateSubFungsiList() {
    const rows = document.querySelectorAll('#tableMahasiswa tbody tr');
    const values = new Set();

    rows.forEach(row => {
        const subFungsiCell = row.querySelector('td:nth-child(7)');
        if (subFungsiCell) values.add(subFungsiCell.innerText.trim());
    });

    allSubFungsi = Array.from(values).sort();
    const dropdown = document.getElementById('subFungsiDropdown');

    dropdown.innerHTML = `
        <div class="p-2 text-gray-700 text-sm cursor-pointer hover:bg-indigo-50 rounded"
            onclick="selectSubFungsi('Semua Sub Fungsi')">Semua Sub Fungsi</div>
        ${allSubFungsi.map(v => `
            <div class="p-2 text-gray-700 text-sm cursor-pointer hover:bg-indigo-50 rounded"
                onclick="selectSubFungsi('${v}')">${v}</div>
        `).join('')}
    `;
}

// 🔹 Tampilkan / Filter Sub Fungsi dropdown
function showSubFungsiDropdown() {
    document.getElementById("subFungsiDropdown").classList.remove("hidden");
}
function filterSubFungsiOptions(searchValue) {
    const dropdown = document.getElementById("subFungsiDropdown");
    dropdown.classList.remove("hidden");
    dropdown.querySelectorAll("div").forEach(opt => {
        const text = opt.textContent.toLowerCase();
        opt.style.display = text.includes(searchValue.toLowerCase()) ? "" : "none";
    });
}
function selectSubFungsi(value) {
    document.getElementById("filterSubFungsi").value = value;
    document.getElementById("subFungsiDropdown").classList.add("hidden");
    selectedSubFungsi = value.toLowerCase();
    applyFilters();
}

// Tutup dropdown jika klik di luar
document.addEventListener("click", (e) => {
    const dropdown = document.getElementById("subFungsiDropdown");
    const input = document.getElementById("filterSubFungsi");
    if (!input.contains(e.target) && !dropdown.contains(e.target)) {
        dropdown.classList.add("hidden");
    }
});

// 🔹 Fungsi utama filter tabel
function applyFilters() {
    const kampus = document.getElementById('filterKampus').value.toLowerCase();
    const status = document.getElementById('filterStatus').value.toLowerCase();
    const direktorat = document.getElementById('filterDirektorat').value.toLowerCase();
    const fungsi = document.getElementById('filterFungsi').value.toLowerCase();
    const search = document.getElementById('searchInput').value.toLowerCase();

    document.querySelectorAll('#tableMahasiswa tbody tr').forEach(row => {
        const text = row.innerText.toLowerCase();
        const match =
            (kampus === 'all' || text.includes(kampus)) &&
            (status === 'all' || text.includes(status)) &&
            (direktorat === 'all' || text.includes(direktorat)) &&
            (fungsi === 'all' || text.includes(fungsi)) &&
            (selectedSubFungsi === 'all' || text.includes(selectedSubFungsi)) &&
            text.includes(search);

        row.style.display = match ? '' : 'none';
    });
}
</script>


@endsection
