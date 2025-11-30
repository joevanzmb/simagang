@extends('layouts.mentor', ['noHeader' => true])

@section('pageTitle', 'Mahasiswa Bimbingan')
@section('pageSubtitle', 'Pantau aktivitas, ajukan perpanjangan, dan lihat perkembangan mahasiswa bimbingan Anda.')

@section('content')
<div class="space-y-10">

    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-center text-white p-7 rounded-2xl shadow-lg"
        style="background: linear-gradient(135deg, #5a6de0 0%, #6c3fb0 100%);">
        <div>
            <h2 class="text-2xl font-bold flex items-center gap-4 leading-tight">
                <i class="fas fa-users text-3xl"></i> Mahasiswa Bimbingan
            </h2>
            <p class="text-m text-white/90 mt-1">Total Bimbingan: 5 Mahasiswa</p>
        </div>
    </div>

    <!-- Filter -->
    <div class="bg-white p-5 rounded-2xl shadow flex flex-col lg:flex-row justify-between items-center gap-4">
        <div class="flex flex-wrap gap-4 w-full lg:w-auto">
            <div>
                <label for="filterStatus" class="block text-sm font-medium text-gray-600">Status Magang</label>
                <select id="filterStatus" class="border border-gray-300 rounded-lg p-2 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option>Semua</option>
                    <option>Aktif</option>
                    <option>Selesai</option>
                    <option>Menunggu Persetujuan</option>
                </select>
            </div>

            <div>
                <label for="filterPeriode" class="block text-sm font-medium text-gray-600">Periode</label>
                <select id="filterPeriode" class="border border-gray-300 rounded-lg p-2 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option>Semua Periode</option>
                    <option>Jan 2025 – Jun 2025</option>
                    <option>Jul 2025 – Des 2025</option>
                </select>
            </div>
        </div>

        <div class="relative w-full lg:w-1/3">
            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
            <input type="text" id="searchInput" placeholder="Cari nama mahasiswa..."
                class="pl-9 w-full border border-gray-300 rounded-lg p-2 text-sm focus:ring-indigo-500 focus:border-indigo-500">
        </div>
    </div>

    <!-- Tabel Mahasiswa -->
    <div class="bg-white rounded-2xl shadow-lg p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
            <i class="fas fa-user-graduate"></i> Daftar Mahasiswa Bimbingan
        </h3>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-gray-700 border border-gray-200 rounded-xl overflow-hidden" id="tableMahasiswa">
                <thead class="bg-gray-100 text-gray-800">
                    <tr>
                        <th class="px-4 py-2 text-left font-semibold">Nama</th>
                        <th class="px-4 py-2 text-left font-semibold">Kampus</th>
                        <th class="px-4 py-2 text-center font-semibold">Periode</th>
                        <th class="px-4 py-2 text-center font-semibold">Status</th>
                        <th class="px-4 py-2 text-center font-semibold">Progress</th>
                        <th class="px-4 py-2 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr id="rowJoevanz" class="border-b hover:bg-indigo-50 transition">
                        <td class="px-4 py-2 font-medium flex items-center gap-3">
                            <img src="https://ui-avatars.com/api/?name=Joevanz+Mikail&background=6366f1&color=fff" class="w-8 h-8 rounded-full shadow-sm">
                            Joevanz Mikail
                        </td>
                        <td class="px-4 py-2">Universitas Airlangga</td>
                        <td id="periodeJoevanz" class="px-4 py-2 text-center">Jan – Jun 2025</td>
                        <td id="statusJoevanz" class="px-4 py-2 text-center">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-700">Aktif</span>
                        </td>
                        <td class="px-4 py-2 text-center">
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-indigo-600 h-2.5 rounded-full" style="width: 75%"></div>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">75%</p>
                        </td>
                        <td class="px-4 py-2 text-center space-x-2">
                            <button class="px-3 py-1 text-xs rounded-lg bg-indigo-500 text-white hover:bg-indigo-600 transition" onclick="openDetail()">Lihat Detail</button>
                            <button class="px-3 py-1 text-xs rounded-lg bg-amber-500 text-white hover:bg-amber-600 transition" onclick="openExtend('Joevanz')">Ajukan Perpanjangan</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Detail -->
<div id="detailModal" class="hidden fixed inset-0 bg-black/60 flex items-center justify-center z-50 backdrop-blur-sm">
    <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-4xl relative animate-fade-in overflow-y-auto max-h-[90vh]">
        <button onclick="closeDetail()" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
            <i class="fas fa-times"></i>
        </button>

        <div class="flex items-center gap-4 border-b pb-4 mb-6">
            <img src="https://ui-avatars.com/api/?name=Joevanz+Mikail&background=6366f1&color=fff" class="w-20 h-20 rounded-full shadow-md">
            <div>
                <h3 class="text-xl font-bold text-gray-800">Joevanz Mikail</h3>
                <p class="text-sm text-gray-500">Universitas Airlangga • NIM: 187221077</p>
                <p class="text-sm text-gray-400">Status: Aktif • Periode: Jan – Jun 2025</p>
            </div>
        </div>

        <h4 class="font-semibold text-indigo-700 mb-2 flex items-center gap-2">
            <i class="fas fa-briefcase"></i> Informasi Magang
        </h4>
        <div class="grid grid-cols-2 gap-x-8 gap-y-2 text-sm mb-6">
            <p><strong>Direktorat:</strong> Human Capital</p>
            <p><strong>Fungsi:</strong> Pengembangan SDM</p>
            <p><strong>Kampus:</strong> Universitas Airlangga</p>
            <p><strong>Kontak:</strong> +62 812 3456 7890</p>
        </div>

        <h4 class="font-semibold text-indigo-700 mb-2 flex items-center gap-2">
            <i class="fas fa-chart-line"></i> Progress Magang
        </h4>
        <div class="w-full bg-gray-200 rounded-full h-3 mb-3">
            <div class="bg-indigo-600 h-3 rounded-full" style="width: 75%"></div>
        </div>
        <p class="text-sm text-gray-600 mb-6">Mahasiswa ini telah menyelesaikan 75% dari program magang.</p>

        <div class="flex justify-end gap-3 border-t pt-4">
            <button onclick="closeDetail()" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg">Tutup</button>
        </div>
    </div>
</div>

<!-- Modal Pengajuan Perpanjangan -->
<div id="extendModal" class="hidden fixed inset-0 bg-black/60 flex items-center justify-center z-50 backdrop-blur-sm">
    <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-lg relative animate-fade-in">
        <button onclick="closeExtend()" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
            <i class="fas fa-times"></i>
        </button>

        <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
            <i class="fas fa-calendar-plus text-indigo-600"></i> Ajukan Perpanjangan
        </h3>

        <form id="extendForm" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Tanggal Selesai Lama</label>
                <input type="date" id="tgl_lama" value="2025-06-30" class="w-full border rounded-lg p-2 text-sm bg-gray-100" disabled>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Tanggal Selesai Baru</label>
                <input type="date" id="tgl_baru" class="w-full border rounded-lg p-2 text-sm focus:ring-indigo-500 focus:border-indigo-500" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Alasan Perpanjangan</label>
                <textarea id="alasan" rows="3" placeholder="Tuliskan alasan pengajuan perpanjangan..." class="w-full border rounded-lg p-2 text-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
            </div>

            <div class="text-right pt-2">
                <button type="button" id="btnSimpanExtend" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg">
                    <i class="fas fa-paper-plane mr-2"></i> Kirim Pengajuan
                </button>
            </div>
        </form>
    </div>
</div>

<style>
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(10px);}
  to { opacity: 1; transform: translateY(0);}
}
.animate-fade-in { animation: fadeIn 0.3s ease-out; }
</style>

<script>
function openDetail() {
  document.getElementById('detailModal').classList.remove('hidden');
}
function closeDetail() {
  document.getElementById('detailModal').classList.add('hidden');
}
function openExtend() {
  document.getElementById('extendModal').classList.remove('hidden');
}
function closeExtend() {
  document.getElementById('extendModal').classList.add('hidden');
}

document.getElementById('btnSimpanExtend').addEventListener('click', function () {
  const tglBaru = document.getElementById('tgl_baru').value;
  const alasan = document.getElementById('alasan').value;

  if (!tglBaru || !alasan) {
    alert("⚠️ Lengkapi tanggal dan alasan perpanjangan terlebih dahulu!");
    return;
  }

  // Update tampilan ke status "Menunggu Persetujuan"
  const periodeCell = document.querySelector("#periodeJoevanz");
  const statusCell = document.querySelector("#statusJoevanz");

  periodeCell.textContent = "Jan – Jul 2025";
  statusCell.innerHTML = `
      <span class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">Menunggu Persetujuan Admin</span>
  `;

  closeExtend();
  alert(`✅ Pengajuan perpanjangan berhasil dikirim ke Admin.\nMenunggu persetujuan hingga ${tglBaru}\nAlasan: ${alasan}`);
});
</script>
@endsection
