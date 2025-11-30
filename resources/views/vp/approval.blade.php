@extends('layouts.vp', ['noHeader' => true])

@section('pageTitle', 'Approval Sertifikat Mahasiswa')
@section('pageSubtitle', 'Tinjau hasil presentasi dan laporan akhir mahasiswa magang sebelum memberikan persetujuan sertifikat digital.')

@section('content')
<div class="space-y-10">

    <!-- 🌈 HEADER -->
    <div class="flex flex-col md:flex-row justify-between items-center text-white p-8 rounded-3xl shadow-lg"
        style="background: linear-gradient(135deg, #5a6de0 0%, #6c3fb0 100%); box-shadow: 0 10px 25px rgba(0,0,0,0.15);">
        <div>
            <h2 class="text-3xl font-bold flex items-center gap-4 leading-tight">
                <i class="fas fa-certificate text-3xl drop-shadow-sm"></i> Approval Sertifikat
            </h2>
            <p class="text-sm text-white/85 mt-2">
                Tinjau file presentasi dan laporan akhir mahasiswa dalam format PDF, kemudian berikan keputusan persetujuan.
            </p>
        </div>
    </div>

    <!-- 📊 STATISTIK -->
    <div class="grid md:grid-cols-3 gap-6">
        <div class="p-5 rounded-2xl text-center bg-green-50 border border-green-100 shadow-sm hover:shadow-md transition">
            <h4 class="font-semibold text-green-700 text-lg mb-1">Sudah Disetujui</h4>
            <p class="text-3xl font-bold text-green-600">8</p>
        </div>
        <div class="p-5 rounded-2xl text-center bg-yellow-50 border border-yellow-100 shadow-sm hover:shadow-md transition">
            <h4 class="font-semibold text-yellow-700 text-lg mb-1">Menunggu</h4>
            <p class="text-3xl font-bold text-yellow-600">4</p>
        </div>
        <div class="p-5 rounded-2xl text-center bg-red-50 border border-red-100 shadow-sm hover:shadow-md transition">
            <h4 class="font-semibold text-red-700 text-lg mb-1">Ditolak</h4>
            <p class="text-3xl font-bold text-red-600">2</p>
        </div>
    </div>

    <!-- 📁 TABEL DATA -->
    <div class="bg-white/90 backdrop-blur-md rounded-3xl shadow-lg p-7 border border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 mb-5 flex items-center gap-2">
            <i class="fas fa-file-signature text-indigo-600"></i> Daftar Dokumen Mahasiswa
        </h3>
        
        <!-- 🔍 FILTER AREA -->
        <div class="bg-white/95 backdrop-blur-md p-5 rounded-2xl shadow-sm border border-gray-200 mb-6">
            
        
            <!-- Filter Grid -->
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
        
                <!-- Kampus -->
                <div>
                    <label class="text-xs font-medium text-gray-600">Kampus</label>
                    <select id="filterKampus" class="w-full border rounded-lg p-2 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="all">Semua</option>
                        <option>Universitas Airlangga</option>
                        <option>ITS</option>
                        <option>Universitas Brawijaya</option>
                    </select>
                </div>
        
                <!-- Mentor -->
                <div>
                    <label class="text-xs font-medium text-gray-600">Mentor</label>
                    <select id="filterMentor" class="w-full border rounded-lg p-2 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="all">Semua</option>
                        <option>Andi Saputra</option>
                        <option>Rina Oktaviani</option>
                    </select>
                </div>
        
                <!-- Status Sertifikat -->
                <div>
                    <label class="text-xs font-medium text-gray-600">Status Sertifikat</label>
                    <select id="filterStatusCert" class="w-full border rounded-lg p-2 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="all">Semua</option>
                        <option>Disetujui</option>
                        <option>Menunggu</option>
                        <option>Ditolak</option>
                    </select>
                </div>
        
                <!-- Persetujuan Mentor -->
                <div>
                    <label class="text-xs font-medium text-gray-600">Persetujuan Mentor</label>
                    <select id="filterPersetujuan" class="w-full border rounded-lg p-2 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="all">Semua</option>
                        <option>✔ Sudah</option>
                        <option>Menunggu</option>
                    </select>
                </div>
        
                <!-- Search -->
                <div>
                    <label class="text-xs font-medium text-gray-600">Cari Nama</label>
                    <div class="relative">
                        <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                        <input type="text" id="searchNama"
                            class="pl-8 w-full border rounded-lg p-2 text-sm focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Cari...">
                    </div>
                </div>
        
            </div>
        </div>



        <div class="overflow-x-auto rounded-2xl border border-gray-100">
            <table class="min-w-full text-sm text-gray-700">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr class="text-gray-700">
                        <th class="px-5 py-3 text-left font-semibold">Nama</th>
                        <th class="px-5 py-3 text-left font-semibold">Kampus</th>
                        <th class="px-5 py-3 text-center font-semibold">Mentor</th>
                        <th class="px-5 py-3 text-center font-semibold">File Presentasi (PDF)</th>
                        <th class="px-5 py-3 text-center font-semibold">Laporan Akhir (PDF)</th>
                        <th class="px-5 py-3 text-center font-semibold">Persetujuan Mentor</th>
                        <th class="px-5 py-3 text-center font-semibold">Status Sertifikat</th>
                        <th class="px-5 py-3 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    <!-- Baris 1 -->
                    <tr class="hover:bg-indigo-50/40 transition">
                        <td class="px-5 py-3 font-medium">Joevanz Mikail</td>
                        <td class="px-5 py-3">Universitas Airlangga</td>
                        <td class="px-5 py-3 text-center">Andi Saputra</td>
                        <td class="px-5 py-3 text-center">
                            <a href="#" class="text-indigo-600 hover:underline flex items-center justify-center gap-1">
                                <i class="fas fa-file-pdf text-red-500"></i> Presentasi.pdf
                            </a>
                        </td>
                        <td class="px-5 py-3 text-center">
                            <a href="#" class="text-indigo-600 hover:underline flex items-center justify-center gap-1">
                                <i class="fas fa-file-pdf text-red-500"></i> Laporan_Akhir.pdf
                            </a>
                        </td>
                        <td class="px-5 py-3 text-center">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">✔ Sudah</span>
                        </td>
                        <td class="px-5 py-3 text-center status-cell">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">Menunggu</span>
                        </td>
                        <td class="px-5 py-3 text-center action-cell">
                            <div class="flex justify-center gap-2">
                                <button class="px-3 py-1 text-xs bg-green-500 hover:bg-green-600 text-white rounded-lg shadow-sm transition" onclick="approveCert(this)">
                                    <i class="fas fa-check mr-1"></i> Setujui
                                </button>
                                <button class="px-3 py-1 text-xs bg-red-500 hover:bg-red-600 text-white rounded-lg shadow-sm transition" onclick="openRejectModal(this)">
                                    <i class="fas fa-times mr-1"></i> Tolak
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Baris 2 -->
                    <tr class="hover:bg-indigo-50/40 transition">
                        <td class="px-5 py-3 font-medium">Siti Nurhaliza</td>
                        <td class="px-5 py-3">ITS</td>
                        <td class="px-5 py-3 text-center">Rina Oktaviani</td>
                        <td class="px-5 py-3 text-center">
                            <a href="#" class="text-indigo-600 hover:underline flex items-center justify-center gap-1">
                                <i class="fas fa-file-pdf text-red-500"></i> Hasil_Presentasi.pdf
                            </a>
                        </td>
                        <td class="px-5 py-3 text-center">
                            <a href="#" class="text-indigo-600 hover:underline flex items-center justify-center gap-1">
                                <i class="fas fa-file-pdf text-red-500"></i> Laporan_Final.pdf
                            </a>
                        </td>
                        <td class="px-5 py-3 text-center">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">✔ Sudah</span>
                        </td>
                        <td class="px-5 py-3 text-center status-cell">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">Disetujui</span>
                        </td>
                        <td class="px-5 py-3 text-center action-cell">
                            <div class="flex justify-center">
                                <button class="px-3 py-1 text-xs bg-gray-600 hover:bg-gray-700 text-white rounded-lg shadow-sm transition" onclick="resetDecision(this)">
                                    <i class="fas fa-edit mr-1"></i> Edit Keputusan
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Baris 3 -->
                    <tr class="hover:bg-indigo-50/40 transition">
                        <td class="px-5 py-3 font-medium">Bagus Pratama</td>
                        <td class="px-5 py-3">Universitas Brawijaya</td>
                        <td class="px-5 py-3 text-center">Andi Saputra</td>
                        <td class="px-5 py-3 text-center">
                            <a href="#" class="text-indigo-600 hover:underline flex items-center justify-center gap-1">
                                <i class="fas fa-file-pdf text-red-500"></i> Presentasi_Final.pdf
                            </a>
                        </td>
                        <td class="px-5 py-3 text-center text-gray-400">Belum diupload</td>
                        <td class="px-5 py-3 text-center">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">Menunggu</span>
                        </td>
                        <td class="px-5 py-3 text-center status-cell">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">Ditolak</span>
                            <p class="text-xs text-gray-500 mt-1">Alasan: File laporan tidak lengkap.</p>
                        </td>
                        <td class="px-5 py-3 text-center action-cell">
                            <div class="flex justify-center">
                                <button class="px-3 py-1 text-xs bg-gray-600 hover:bg-gray-700 text-white rounded-lg shadow-sm transition" onclick="resetDecision(this)">
                                    <i class="fas fa-edit mr-1"></i> Edit Keputusan
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- ❌ MODAL PENOLAKAN -->
    <div id="rejectModal" class="hidden fixed inset-0 bg-black/60 flex items-center justify-center z-50 backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-lg relative animate-fade-in">
            <button onclick="closeRejectModal()" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>

            <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-ban text-red-500"></i> Alasan Penolakan Sertifikat
            </h3>

            <form id="rejectForm" onsubmit="submitReject(event)">
                <textarea id="rejectReason" rows="4" placeholder="Tuliskan alasan penolakan..." class="w-full border rounded-lg p-3 text-sm focus:ring-red-500 focus:border-red-500"></textarea>
                <div class="text-right pt-4">
                    <button type="button" onclick="closeRejectModal()" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg mr-2">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg shadow-sm">
                        <i class="fas fa-paper-plane mr-1"></i> Kirim
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
@keyframes fadeIn { from { opacity: 0; transform: translateY(10px);} to { opacity: 1; transform: translateY(0);} }
.animate-fade-in { animation: fadeIn 0.3s ease-out; }
</style>

<script>
let currentRejectRow = null;

function approveCert(btn) {
  const row = btn.closest('tr');
  const status = row.querySelector('.status-cell');
  const action = row.querySelector('.action-cell');
  status.innerHTML = `<span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">Disetujui</span>`;
  action.innerHTML = `<div class='flex justify-center'>
                        <button class='px-3 py-1 text-xs bg-gray-600 hover:bg-gray-700 text-white rounded-lg shadow-sm transition' onclick='resetDecision(this)'>
                          <i class='fas fa-edit mr-1'></i> Edit Keputusan
                        </button>
                      </div>`;
}

function openRejectModal(btn) {
  currentRejectRow = btn.closest('tr');
  document.getElementById('rejectModal').classList.remove('hidden');
}

function closeRejectModal() {
  document.getElementById('rejectModal').classList.add('hidden');
}

function submitReject(e) {
  e.preventDefault();
  const reason = document.getElementById('rejectReason').value.trim();
  if (!reason) return alert("Harap isi alasan penolakan.");
  const status = currentRejectRow.querySelector('.status-cell');
  const action = currentRejectRow.querySelector('.action-cell');
  status.innerHTML = `<span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">Ditolak</span>
                      <p class="text-xs text-gray-500 mt-1">Alasan: ${reason}</p>`;
  action.innerHTML = `<div class='flex justify-center'>
                        <button class='px-3 py-1 text-xs bg-gray-600 hover:bg-gray-700 text-white rounded-lg shadow-sm transition' onclick='resetDecision(this)'>
                          <i class='fas fa-edit mr-1'></i> Edit Keputusan
                        </button>
                      </div>`;
  closeRejectModal();
}

function resetDecision(btn) {
  const row = btn.closest('tr');
  const status = row.querySelector('.status-cell');
  const action = row.querySelector('.action-cell');
  status.innerHTML = `<span class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">Menunggu</span>`;
  action.innerHTML = `<div class='flex justify-center gap-2'>
                        <button class='px-3 py-1 text-xs bg-green-500 hover:bg-green-600 text-white rounded-lg shadow-sm transition' onclick='approveCert(this)'>
                          <i class='fas fa-check mr-1'></i> Setujui
                        </button>
                        <button class='px-3 py-1 text-xs bg-red-500 hover:bg-red-600 text-white rounded-lg shadow-sm transition' onclick='openRejectModal(this)'>
                          <i class='fas fa-times mr-1'></i> Tolak
                        </button>
                      </div>`;
}
// ✅ Filter & Search
document.querySelectorAll('#filterKampus, #filterMentor, #filterStatusCert, #filterPersetujuan')
    .forEach(select => select.addEventListener('change', applyFilters));

document.getElementById('searchNama').addEventListener('input', applyFilters);

function applyFilters() {
    const kampus = document.getElementById('filterKampus').value;
    const mentor = document.getElementById('filterMentor').value;
    const statusCert = document.getElementById('filterStatusCert').value;
    const persetujuan = document.getElementById('filterPersetujuan').value;
    const searchNama = document.getElementById('searchNama').value.toLowerCase();

    document.querySelectorAll('tbody tr').forEach(row => {
        const nama = row.children[0].innerText.toLowerCase();
        const kampusRow = row.children[1].innerText;
        const mentorRow = row.children[2].innerText;
        const persetujuanRow = row.children[5].innerText.trim();
        const statusCertRow = row.children[6].innerText.trim();

        const match =
            (kampus === "all" || kampusRow.includes(kampus)) &&
            (mentor === "all" || mentorRow.includes(mentor)) &&
            (persetujuan === "all" || persetujuanRow.includes(persetujuan)) &&
            (statusCert === "all" || statusCertRow.includes(statusCert)) &&
            nama.includes(searchNama);

        row.style.display = match ? "" : "none";
    });
}

</script>
@endsection
