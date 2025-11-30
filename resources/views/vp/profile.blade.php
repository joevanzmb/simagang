@extends('layouts.vp', ['noHeader' => true])

@section('pageTitle', 'Profil Akun Vice President')
@section('pageSubtitle', 'Kelola identitas akun, tanda tangan digital, dan keamanan sistem.')

@section('content')
<div class="max-w-6xl mx-auto space-y-10">

  <!-- 🟣 HERO PROFIL -->
  <section class="relative overflow-hidden rounded-2xl shadow-lg p-10 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 text-white">
    <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
    <div class="relative flex flex-col md:flex-row items-center justify-between gap-6">
      <div class="flex items-center gap-6">
        <img src="https://ui-avatars.com/api/?name=Vice+President&background=ffffff&color=4F46E5"
             class="w-28 h-28 rounded-full border-4 border-white/30 shadow-md object-cover">
        <div>
          <h1 class="text-3xl font-bold">Vice President Human Capital</h1>
          <p class="text-white/80">PT Pertamina Lubricants</p>
          <p class="text-xs text-white/60 mt-1">Terakhir login: 24 Oktober 2025 • 10:30 WIB</p>
        </div>
      </div>
      <button class="bg-white/20 hover:bg-white/30 text-white px-5 py-2 rounded-lg shadow-md backdrop-blur-md transition">
        <i class="fas fa-user-edit mr-2"></i> Edit Profil
      </button>
    </div>
  </section>

  <!-- 🧾 DATA DIRI -->
  <section class="bg-white/90 backdrop-blur-sm border border-gray-100 shadow-md rounded-2xl p-8">
    <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
      <i class="fas fa-id-badge text-indigo-500"></i> Informasi Pribadi
    </h3>
    <div class="grid md:grid-cols-2 gap-6">
      <div>
        <label class="block text-sm text-gray-600 mb-1">Nama Lengkap</label>
        <input type="text" value="Ibu Vice President" class="input">
      </div>
      <div>
        <label class="block text-sm text-gray-600 mb-1">Jabatan</label>
        <input type="text" value="Vice President Human Capital" class="input">
      </div>
      <div>
        <label class="block text-sm text-gray-600 mb-1">Email</label>
        <input type="email" value="vp@pertamina.com" class="input">
      </div>
      <div>
        <label class="block text-sm text-gray-600 mb-1">No. Telepon</label>
        <input type="text" value="+62 812 3456 7890" class="input">
      </div>
    </div>
  </section>

  <!-- ✍️ SIGNATURE PAD -->
  <section class="bg-white/90 backdrop-blur-sm border border-gray-100 shadow-md rounded-2xl p-8">
    <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
      <i class="fas fa-signature text-purple-500"></i> Tanda Tangan Digital
    </h3>

    <div id="signature-container"
      class="relative border-2 border-dashed border-gray-300 rounded-xl bg-gray-50 w-full md:w-2/3 h-52 flex items-center justify-center overflow-hidden cursor-pointer mx-auto">
      <canvas id="signature-pad" class="w-full h-full bg-white rounded-xl shadow-inner"></canvas>
      <div id="placeholder"
        class="absolute text-gray-400 text-sm select-none transition-all duration-300">Klik kolom untuk mulai tanda tangan...</div>
    </div>

    <div class="flex justify-center gap-4 mt-5">
      <button id="clear" type="button"
        class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg flex items-center gap-2 text-sm">
        <i class="fas fa-undo"></i> Ulangi
      </button>
      <button id="save" type="button"
        class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-4 py-2 rounded-lg shadow flex items-center gap-2 text-sm">
        <i class="fas fa-save"></i> Simpan
      </button>
    </div>

    <div class="mt-6 text-center">
      <h4 class="text-sm font-semibold text-gray-700 mb-2">Preview Tanda Tangan:</h4>
      <div class="border border-gray-200 rounded-lg p-3 bg-gray-50 inline-block">
        <img id="saved-signature" src="" class="max-h-28 object-contain">
      </div>
    </div>
  </section>

  <!-- 🔐 KEAMANAN -->
  <section class="bg-white/90 backdrop-blur-sm border border-gray-100 shadow-md rounded-2xl p-8">
    <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
      <i class="fas fa-lock text-indigo-500"></i> Keamanan Akun
    </h3>
    <div class="grid md:grid-cols-2 gap-6">
      <div>
        <label class="block text-sm text-gray-600 mb-1">Password Baru</label>
        <input id="pwBaru" type="password" placeholder="••••••••••" class="input" oninput="checkStrength(this.value)">
        <div id="pwStrength" class="text-xs mt-1 text-gray-500"></div>
      </div>
      <div>
        <label class="block text-sm text-gray-600 mb-1">Konfirmasi Password</label>
        <input type="password" placeholder="••••••••••" class="input">
      </div>
    </div>
    <button onclick="showToast('✅ Password berhasil diperbarui.')"
      class="mt-5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-5 py-2 rounded-lg shadow">
      <i class="fas fa-save mr-2"></i> Simpan Perubahan
    </button>
  </section>

  <!-- 🧾 AKTIVITAS -->
  <section class="bg-white/90 backdrop-blur-sm border border-gray-100 shadow-md rounded-2xl p-8">
    <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
      <i class="fas fa-history text-gray-500"></i> Aktivitas Terakhir
    </h3>

    <div class="relative border-l-2 border-indigo-100 pl-8 space-y-6">
      @foreach ([['green','check','Menyetujui sertifikat mahasiswa <b>Joevanz Mikail</b>','22 Okt 2025'],
                ['rose','times','Menolak sertifikat mahasiswa <b>Siti Nurhaliza</b>','21 Okt 2025'],
                ['indigo','user-cog','Mengubah preferensi notifikasi','20 Okt 2025']] as $act)
        <div class="relative flex items-start gap-4">
          <div class="absolute -left-[14px] top-1 w-6 h-6 bg-{{ $act[0] }}-100 text-{{ $act[0] }}-600 rounded-full flex items-center justify-center">
            <i class="fas fa-{{ $act[1] }} text-[10px]"></i>
          </div>
          <p class="text-sm text-gray-700 leading-relaxed">{!! $act[2] !!} <span class="text-gray-400">• {{ $act[3] }}</span></p>
        </div>
      @endforeach
    </div>
  </section>

</div>

<!-- 🔔 TOAST -->
<div id="toast" class="hidden fixed bottom-6 right-6 bg-gray-900 text-white px-5 py-3 rounded-lg shadow-lg text-sm"></div>

<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
<script>
const canvas = document.getElementById('signature-pad');
const placeholder = document.getElementById('placeholder');
const container = document.getElementById('signature-container');
const signaturePad = new SignaturePad(canvas, { backgroundColor: 'rgba(255,255,255,0)', penColor: '#4F46E5' });
let active = false;

function resizeCanvas() {
  const ratio = Math.max(window.devicePixelRatio || 1, 1);
  canvas.width = canvas.offsetWidth * ratio;
  canvas.height = canvas.offsetHeight * ratio;
  canvas.getContext('2d').scale(ratio, ratio);
  signaturePad.clear();
}
window.addEventListener('resize', resizeCanvas);
resizeCanvas();

// aktif saat klik
container.addEventListener('click', () => {
  active = true;
  placeholder.classList.add('opacity-0');
});

canvas.addEventListener('mousedown', () => placeholder.classList.add('opacity-0'));
canvas.addEventListener('touchstart', () => placeholder.classList.add('opacity-0'));

document.getElementById('clear').addEventListener('click', () => {
  signaturePad.clear();
  placeholder.classList.remove('opacity-0');
});

document.getElementById('save').addEventListener('click', () => {
  if (signaturePad.isEmpty()) return showToast('⚠️ Belum ada tanda tangan.');
  const dataURL = signaturePad.toDataURL();
  document.getElementById('saved-signature').src = dataURL;
  showToast('✍️ Tanda tangan disimpan.');
});

function checkStrength(pw) {
  const el = document.getElementById('pwStrength');
  if (pw.length === 0) el.textContent = '';
  else if (pw.length < 6) el.textContent = 'Kekuatan: Lemah 🔴';
  else if (/[A-Z]/.test(pw) && /\d/.test(pw) && pw.length >= 8) el.textContent = 'Kekuatan: Kuat 🟢';
  else el.textContent = 'Kekuatan: Sedang 🟠';
}

function showToast(msg) {
  const t = document.getElementById('toast');
  t.textContent = msg;
  t.classList.remove('hidden');
  t.classList.add('animate-fadeIn');
  setTimeout(() => t.classList.add('hidden'), 2500);
}
</script>

<style>
.input { @apply w-full border border-gray-300 rounded-lg p-3 text-sm focus:ring-indigo-500 focus:border-indigo-500 transition; }
@keyframes fadeIn { from {opacity:0;transform:translateY(10px);} to {opacity:1;transform:translateY(0);} }
.animate-fadeIn { animation: fadeIn .4s ease-out; }
#placeholder { transition: opacity .3s ease; }
</style>
@endsection
