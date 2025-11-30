@extends('layouts.mahasiswa', ['noHeader' => true])

@section('pageTitle', 'Laporan Magang')
@section('pageSubtitle', 'Catat aktivitas harian dan unggah laporan akhir magang kamu.')

@section('content')
<div class="space-y-10">

  <!-- 🌈 Header -->
  <div class="flex flex-col md:flex-row justify-between items-center text-white p-7 rounded-2xl shadow-xl gap-6"
    style="background: linear-gradient(135deg, #5a6de0 0%, #6c3fb0 100%); box-shadow: 0 10px 25px rgba(0,0,0,0.15);">
    <div>
      <h2 class="text-2xl font-bold flex items-center gap-5 leading-tight">
        <i class="fas fa-file-alt text-4xl"></i> Laporan Magang
      </h2>
      <p class="text-sm text-white/80 mt-2">Catat aktivitas harian dan unggah laporan akhir magang kamu.</p>
    </div>
    <button
      class="px-5 py-2 bg-white/20 hover:bg-white/30 rounded-lg text-white font-medium flex items-center gap-2 transition-all duration-200 hover:scale-[1.05] shadow-sm">
      <i class="fas fa-bell"></i> Ingatkan Mentor
    </button>
  </div>

  <div class="max-w-5xl mx-auto space-y-10">

    <!-- ✍️ Form Laporan Harian -->
    <div
      class="bg-white/90 backdrop-blur-md rounded-2xl border border-white/40 shadow-xl p-6 hover:shadow-2xl transition-all duration-300 animate-fadeIn">
      <h2 class="text-sm font-semibold text-indigo-600 uppercase tracking-wide mb-1 flex items-center gap-2">
        <i class="fas fa-clipboard-check"></i> Form Laporan Harian
      </h2>
      <h3 class="text-lg font-bold text-gray-800 mb-4">Catatan Aktivitas Harian</h3>

      <form id="formLaporan" method="POST" class="space-y-5">
        @csrf
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Aktivitas</label>
          <div class="flex items-center justify-between gap-3">
            <div class="bg-indigo-50 text-indigo-700 px-4 py-2 rounded-lg font-semibold text-sm flex-1 shadow-sm"
              id="displayTanggal"></div>
            <input type="date" id="inputKalender"
              class="border rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm"
              max="">
          </div>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Aktivitas</label>
          <textarea id="aktivitas" rows="5" placeholder="Tuliskan kegiatan magang hari ini..."
            class="w-full border rounded-lg px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm"></textarea>
        </div>

        <div class="text-right">
          <button type="submit"
            class="px-5 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg shadow hover:scale-[1.05] transition-all">
            <i class="fas fa-save mr-2"></i> Simpan Catatan
          </button>
        </div>
      </form>
    </div>

    <!-- 📄 Upload Laporan Akhir -->
    <div id="laporanAkhirCard"
      class="bg-white/90 backdrop-blur-md border border-white/40 rounded-2xl shadow-xl p-6 transition-all duration-300 hover:shadow-2xl animate-fadeIn">
      <h2 class="text-sm font-semibold text-indigo-600 uppercase tracking-wide mb-1 flex items-center gap-2">
        <i class="fas fa-cloud-upload-alt"></i> Upload Laporan Akhir & Presentasi
      </h2>
      <h3 class="text-lg font-bold text-gray-800 mb-4">Unggah Kedua Dokumen dalam Format PDF</h3>

      <form id="formUpload" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <div id="uploadSection" class="space-y-5">

          <!-- Upload Laporan Akhir -->
          <label class="block text-sm font-medium text-gray-700 mb-1">Upload Laporan Akhir (PDF)</label>
          <label id="uploadAreaLaporan"
            class="flex flex-col items-center justify-center px-4 py-6 border-2 border-dashed rounded-lg cursor-pointer hover:border-indigo-400 hover:shadow-indigo-100 transition text-center">
            <i class="fas fa-file-pdf text-red-500 text-3xl mb-2"></i>
            <span id="uploadTextLaporan" class="text-gray-600 font-medium">Klik untuk memilih file laporan akhir (PDF)</span>
            <input type="file" name="laporan_pdf" accept="application/pdf" id="fileLaporan" class="hidden">
          </label>

          <!-- Upload File Presentasi -->
          <label class="block text-sm font-medium text-gray-700 mb-1">Upload File Presentasi (PDF dari PPT)</label>
          <label id="uploadAreaPresentasi"
            class="flex flex-col items-center justify-center px-4 py-6 border-2 border-dashed rounded-lg cursor-pointer hover:border-indigo-400 hover:shadow-indigo-100 transition text-center">
            <i class="fas fa-file-pdf text-orange-500 text-3xl mb-2"></i>
            <span id="uploadTextPresentasi" class="text-gray-600 font-medium">Klik untuk memilih file presentasi (PDF)</span>
            <input type="file" name="presentasi_pdf" accept="application/pdf" id="filePresentasi" class="hidden">
          </label>

          <div class="text-right">
            <button type="submit"
              class="px-5 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg shadow hover:scale-[1.05] transition">
              <i class="fas fa-paper-plane mr-2"></i> Upload Kedua File
            </button>
          </div>
        </div>

        <!-- Status Upload -->
        <div id="statusUpload"
          class="hidden bg-green-50 border border-green-200 text-green-800 p-5 rounded-lg justify-between items-center animate-fadeIn flex">
          <div class="flex items-center gap-3">
            <i class="fas fa-check-circle text-green-600 text-xl"></i>
            <div>
              <p class="font-semibold text-green-700">File laporan & presentasi berhasil diupload!</p>
              <p id="uploadedFileNames" class="text-sm text-green-600"></p>
            </div>
          </div>
          <button type="button" onclick="hapusLaporan()"
            class="text-red-500 hover:text-red-700 text-sm font-medium flex items-center gap-1">
            <i class="fas fa-trash-alt"></i> Hapus
          </button>
        </div>
      </form>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
      const fileLaporan = document.getElementById('fileLaporan');
      const filePresentasi = document.getElementById('filePresentasi');
      const uploadTextLaporan = document.getElementById('uploadTextLaporan');
      const uploadTextPresentasi = document.getElementById('uploadTextPresentasi');
      const uploadSection = document.getElementById('uploadSection');
      const statusUpload = document.getElementById('statusUpload');
      const uploadedFileNames = document.getElementById('uploadedFileNames');
      const card = document.getElementById('laporanAkhirCard');
      const toast = document.getElementById('toast');

      const showToast = (msg, type = 'info') => {
        const icons = { success: '✅', warning: '⚠️', error: '❌', info: 'ℹ️' };
        toast.textContent = `${icons[type]} ${msg}`;
        toast.classList.remove('hidden');
        setTimeout(() => toast.classList.add('hidden'), 2500);
      };

      fileLaporan.addEventListener('change', () => {
        uploadTextLaporan.textContent = fileLaporan.files.length
          ? fileLaporan.files[0].name
          : 'Klik untuk memilih file laporan akhir (PDF)';
        uploadTextLaporan.classList.toggle('text-indigo-600', fileLaporan.files.length > 0);
      });

      filePresentasi.addEventListener('change', () => {
        uploadTextPresentasi.textContent = filePresentasi.files.length
          ? filePresentasi.files[0].name
          : 'Klik untuk memilih file presentasi (PDF)';
        uploadTextPresentasi.classList.toggle('text-indigo-600', filePresentasi.files.length > 0);
      });

      document.getElementById('formUpload').addEventListener('submit', e => {
        e.preventDefault();
        if (!fileLaporan.files.length || !filePresentasi.files.length) {
          showToast('Kedua file harus diupload (laporan & presentasi).', 'warning');
          return;
        }
        uploadedFileNames.textContent = `📘 ${fileLaporan.files[0].name} & 🎞️ ${filePresentasi.files[0].name}`;
        uploadSection.classList.add('hidden');
        statusUpload.classList.remove('hidden');
        card.classList.add('bg-green-50', 'border-green-200', 'shadow-inner');
        showToast('Kedua file berhasil diupload!', 'success');
      });

      window.__uploadRefs = {
        fileLaporan,
        filePresentasi,
        uploadTextLaporan,
        uploadTextPresentasi,
        uploadSection,
        statusUpload,
        card,
        showToast
      };
    });

    function hapusLaporan() {
      const r = window.__uploadRefs;
      if (!r) return;
      if (confirm('Yakin ingin menghapus file laporan & presentasi ini?')) {
        r.statusUpload.classList.add('hidden');
        r.uploadSection.classList.remove('hidden');
        r.fileLaporan.value = '';
        r.filePresentasi.value = '';
        r.uploadTextLaporan.textContent = 'Klik untuk memilih file laporan akhir (PDF)';
        r.uploadTextPresentasi.textContent = 'Klik untuk memilih file presentasi (PDF)';
        r.card.classList.remove('bg-green-50', 'border-green-200', 'shadow-inner');
        r.showToast('File laporan & presentasi berhasil dihapus.', 'info');
      }
    }
    </script>


    <!-- 🕓 Riwayat Laporan Harian -->
    <div
      class="bg-white/90 backdrop-blur-md border border-white/40 rounded-2xl shadow-xl p-6 animate-fadeIn hover:shadow-2xl transition-all duration-300">
      <div class="flex justify-between items-center mb-4">
        <div>
          <h2 class="text-sm font-semibold text-indigo-600 uppercase tracking-wide mb-1 flex items-center gap-2">
            <i class="fas fa-history"></i> Riwayat Aktivitas
          </h2>
          <h3 class="text-lg font-bold text-gray-800">Laporan Harian Tersimpan</h3>
        </div>
        <div class="flex items-center gap-3">
          <input type="text" id="searchLaporan" placeholder="Cari aktivitas..."
            class="border rounded-lg px-3 py-1 text-sm focus:ring-indigo-500 focus:border-indigo-500">
          <button onclick="exportLaporan()"
            class="px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-600 text-white text-sm rounded-lg shadow hover:scale-105 transition flex items-center gap-2">
            <i class="fas fa-file-export"></i> Export
          </button>
        </div>
      </div>

      @php
      $laporans = [
      (object)[ 'id' => 1, 'tanggal' => 'Selasa, 14 Oktober 2025', 'aktivitas' =>
      'Membuat desain halaman dashboard magang menggunakan Tailwind CSS.' ],
      (object)[ 'id' => 2, 'tanggal' => 'Rabu, 15 Oktober 2025', 'aktivitas' =>
      'Melakukan testing fitur upload dokumen pada sistem magang.' ],
      (object)[ 'id' => 3, 'tanggal' => 'Kamis, 16 Oktober 2025', 'aktivitas' =>
      'Menyusun dokumentasi API untuk sistem presensi mahasiswa magang.' ],
      ];
      @endphp

      <div class="overflow-x-auto">
        <table class="min-w-full text-sm text-gray-700">
          <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
            <tr>
              <th class="px-4 py-3 text-left">No</th>
              <th class="px-4 py-3 text-left">Tanggal</th>
              <th class="px-4 py-3 text-left">Aktivitas</th>
              <th class="px-4 py-3 text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($laporans as $i => $laporan)
            <tr class="border-b hover:bg-gray-50 transition">
              <td class="px-4 py-3">{{ $i + 1 }}</td>
              <td class="px-4 py-3 font-semibold text-indigo-700">{{ $laporan->tanggal }}</td>
              <td class="px-4 py-3 truncate max-w-[250px]">{{ $laporan->aktivitas }}</td>
              <td class="px-4 py-3 text-center">
                <button
                  onclick="lihatAktivitas('{{ addslashes($laporan->tanggal) }}', '{{ addslashes($laporan->aktivitas) }}')"
                  class="text-indigo-600 hover:text-indigo-800">
                  <i class="fas fa-eye"></i>
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

<!-- 🌟 Modal Aktivitas -->
<div id="modalAktivitas"
  class="fixed inset-0 flex items-center justify-center bg-black/50 hidden z-50 backdrop-blur-sm transition-all duration-300">
  <div id="modalBox" class="bg-white rounded-2xl shadow-2xl max-w-lg w-full overflow-hidden transform scale-95 opacity-0 transition-all duration-300">
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white p-4 flex justify-between items-center">
      <h3 class="text-lg font-semibold flex items-center gap-2"><i class="fas fa-clipboard-list"></i> Detail Aktivitas</h3>
      <button onclick="tutupModal()" class="hover:text-gray-200"><i class="fas fa-times"></i></button>
    </div>
    <div class="p-6">
      <p id="modalTanggal" class="text-sm text-gray-500 mb-3"></p>
      <p id="modalIsi" class="text-gray-700 leading-relaxed"></p>
    </div>
  </div>
</div>

<!-- 🔔 Toast -->
<div id="toast" class="hidden fixed bottom-6 right-6 bg-gray-800 text-white px-4 py-3 rounded-lg shadow-lg text-sm"></div>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const today = new Date();
  const yyyy = today.getFullYear();
  const mm = String(today.getMonth() + 1).padStart(2, '0');
  const dd = String(today.getDate()).padStart(2, '0');
  const currentDate = `${yyyy}-${mm}-${dd}`;
  const inputKalender = document.getElementById('inputKalender');
  const displayTanggal = document.getElementById('displayTanggal');

  inputKalender.value = currentDate;
  inputKalender.max = currentDate;
  const options = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
  displayTanggal.textContent = today.toLocaleDateString('id-ID', options);
  inputKalender.addEventListener('change', e => {
    const selected = new Date(e.target.value);
    displayTanggal.textContent = selected.toLocaleDateString('id-ID', options);
  });

  const fileInput = document.getElementById('fileInput');
  const uploadText = document.getElementById('uploadText');
  const uploadSection = document.getElementById('uploadSection');
  const statusUpload = document.getElementById('statusUpload');
  const uploadedFileName = document.getElementById('uploadedFileName');
  const card = document.getElementById('laporanAkhirCard');
  const toast = document.getElementById('toast');

  const showToast = (msg, type = 'info') => {
    const icons = { success: '✅', warning: '⚠️', error: '❌', info: 'ℹ️' };
    toast.textContent = `${icons[type]} ${msg}`;
    toast.classList.remove('hidden');
    setTimeout(() => toast.classList.add('hidden'), 2500);
  };

  fileInput.addEventListener('change', () => {
    if (fileInput.files.length > 0) {
      uploadText.textContent = fileInput.files[0].name;
      uploadText.classList.add('text-indigo-600', 'font-semibold');
    } else {
      uploadText.textContent = 'Klik untuk memilih file PDF';
      uploadText.classList.remove('text-indigo-600', 'font-semibold');
    }
  });

  document.getElementById('formUpload').addEventListener('submit', e => {
    e.preventDefault();
    if (fileInput.files.length === 0) return showToast('Silakan pilih file PDF terlebih dahulu.', 'warning');
    uploadedFileName.textContent = '📄 ' + fileInput.files[0].name;
    uploadSection.classList.add('hidden');
    statusUpload.classList.remove('hidden');
    card.classList.add('bg-green-50', 'border-green-200', 'shadow-inner');
    showToast('Laporan akhir berhasil diupload!', 'success');
  });

  document.getElementById('formLaporan').addEventListener('submit', e => {
    e.preventDefault();
    const aktivitas = document.getElementById('aktivitas').value.trim();
    if (!aktivitas) return showToast('Deskripsi aktivitas belum diisi.', 'warning');
    showToast('Catatan aktivitas berhasil disimpan!', 'success');
    document.getElementById('aktivitas').value = '';
  });

  document.getElementById('searchLaporan').addEventListener('input', function() {
    const q = this.value.toLowerCase();
    document.querySelectorAll('tbody tr').forEach(row => {
      row.style.display = row.innerText.toLowerCase().includes(q) ? '' : 'none';
    });
  });

  window.__uploadRefs = { fileInput, uploadText, uploadSection, statusUpload, card, showToast };
});

function hapusLaporan() {
  const r = window.__uploadRefs;
  if (!r) return;
  if (confirm('Yakin ingin menghapus laporan akhir ini?')) {
    r.statusUpload.classList.add('hidden');
    r.uploadSection.classList.remove('hidden');
    r.fileInput.value = '';
    r.uploadText.textContent = 'Klik untuk memilih file PDF';
    r.uploadText.classList.remove('text-indigo-600', 'font-semibold');
    r.card.classList.remove('bg-green-50', 'border-green-200', 'shadow-inner');
    r.showToast('Laporan akhir berhasil dihapus.', 'info');
  }
}

function lihatAktivitas(tanggal, isi) {
  const box = document.getElementById('modalBox');
  const modal = document.getElementById('modalAktivitas');
  document.getElementById('modalTanggal').textContent = tanggal;
  document.getElementById('modalIsi').textContent = isi;
  modal.classList.remove('hidden');
  setTimeout(() => { box.classList.remove('scale-95', 'opacity-0'); box.classList.add('scale-100', 'opacity-100'); }, 50);
}
function tutupModal() {
  const box = document.getElementById('modalBox');
  const modal = document.getElementById('modalAktivitas');
  box.classList.add('scale-95', 'opacity-0');
  setTimeout(() => modal.classList.add('hidden'), 200);
}
function exportLaporan() {
  alert('📦 Fitur export laporan harian (PDF & Excel) akan hadir segera!');
}
</script>

<style>
@keyframes fadeIn { from {opacity: 0; transform: translateY(10px);} to {opacity: 1; transform: translateY(0);} }
.animate-fadeIn { animation: fadeIn 0.5s ease-out; }
#uploadArea:hover { box-shadow: 0 0 15px rgba(99,102,241,0.25); }
</style>

@endsection
