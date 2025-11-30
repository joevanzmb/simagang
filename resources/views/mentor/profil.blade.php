@extends('layouts.mentor', ['noHeader' => true])

@section('pageTitle', 'Profil Mentor')
@section('pageSubtitle', 'Perbarui informasi diri dan detail pembimbingan magang.')

@section('content')

<!-- Header -->
<div class="flex flex-col md:flex-row justify-between items-center text-white p-7 rounded-2xl shadow-lg gap-6 mb-8"
    style="background: linear-gradient(135deg, #6c3fb0 0%, #5a6de0 100%);">
    <div>
        <h2 class="text-2xl font-bold flex items-center gap-5 leading-tight">
            <i class="fas fa-user-tie text-4xl"></i> Profil Mentor
        </h2>
        <p class="text-sm text-white/90 mt-1">Kelola data diri dan informasi pembimbingan magang</p>
    </div>
</div>

<div class="max-w-5xl mx-auto bg-white rounded-2xl shadow-xl p-8 border border-gray-100 space-y-12">

    <!-- FOTO PROFIL -->
    <div class="flex flex-col items-center text-center">
        <div class="relative group">
            <div class="w-32 h-32 rounded-full border-4 border-indigo-100 shadow-md bg-gray-200 flex items-center justify-center">
                <i class="fas fa-user-tie text-gray-400 text-5xl"></i>
            </div>
            <label for="foto"
                class="absolute bottom-0 right-0 bg-indigo-600 hover:bg-indigo-700 text-white w-10 h-10 flex items-center justify-center rounded-full cursor-pointer shadow-md transition-all duration-200 hover:scale-110">
                <i class="fas fa-camera text-sm"></i>
                <input type="file" name="foto" id="foto" class="hidden" accept="image/*">
            </label>
        </div>
        <p class="text-sm text-gray-500 mt-3">Klik ikon kamera untuk mengganti foto</p>
    </div>

    <!-- FORM PROFIL -->
    <form action="#" method="POST" enctype="multipart/form-data" class="space-y-12">
        @csrf

        <!-- DATA PRIBADI -->
        <section>
            <h3 class="text-lg font-semibold text-indigo-700 mb-6 flex items-center">
                <i class="fas fa-id-card-alt mr-2"></i> Data Pribadi
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Nama Lengkap -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap</label>
                    <div class="relative">
                        <i class="fas fa-user-tie absolute left-3 top-3 text-gray-400"></i>
                        <input type="text" name="nama" placeholder="Masukkan nama"
                            class="pl-10 w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-indigo-500 text-sm">
                    </div>
                </div>

                <!-- Nopek -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor Pekerja (Nopek)</label>
                    <div class="relative">
                        <i class="fas fa-id-card absolute left-3 top-3 text-gray-400"></i>
                        <input type="text" name="nopek" placeholder="Masukkan Nopek"
                            class="pl-10 w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-indigo-500 text-sm">
                    </div>
                </div>

                <!-- Direktorat -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Direktorat</label>
                    <select name="direktorat" id="direktorat"
                        class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-indigo-500 text-sm">
                        <option value="">Pilih Direktorat</option>
                        <option>Direktorat Utama</option>
                        <option>Direktorat Operasi</option>
                        <option>Direktorat Sales & Marketing</option>
                        <option>Direktorat Finance & Business Support</option>
                    </select>
                </div>

                <!-- Fungsi -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Fungsi</label>
                    <select name="fungsi" id="fungsi"
                        class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-indigo-500 text-sm">
                        <option value="">Pilih Fungsi</option>
                    </select>

                </div>

                <!-- Jabatan -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Jabatan</label>
                    <div class="relative">
                        <i class="fas fa-briefcase absolute left-3 top-3 text-gray-400"></i>
                        <input type="text" name="jabatan" placeholder="Supervisor / Manager"
                            class="pl-10 w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-indigo-500 text-sm">
                    </div>
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                    <div class="relative">
                        <i class="fas fa-envelope absolute left-3 top-3 text-gray-400"></i>
                        <input type="email" name="email" placeholder="example@pertamina.com"
                            class="pl-10 w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-indigo-500 text-sm">
                    </div>
                </div>

                <!-- No Telp -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor Telepon</label>
                    <div class="relative">
                        <i class="fas fa-phone absolute left-3 top-3 text-gray-400"></i>
                        <input type="text" name="kontak" placeholder="+62..."
                            class="pl-10 w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-indigo-500 text-sm">
                    </div>
                </div>

            </div>
        </section>

        <!-- INFORMASI PEMBIMBINGAN -->
        <!-- ========== 2. INFORMASI PEMBIMBINGAN (Lebih Menarik + Progress) ========== -->
        <section id="informasi-pembimbingan">
            <h3 class="text-lg font-semibold text-indigo-700 mb-6 flex items-center">
                <i class="fas fa-user-graduate mr-2"></i> Informasi Pembimbingan
            </h3>
        
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
                <!-- 🟢 Status Pembimbingan -->
                <div class="bg-gradient-to-br from-indigo-50 to-white border border-indigo-200 rounded-2xl p-6 shadow-sm hover:shadow-lg transition">
                    <div class="flex items-center gap-3">
                        <div class="bg-indigo-600 text-white w-10 h-10 rounded-xl flex items-center justify-center shadow">
                            <i class="fas fa-user-check"></i>
                        </div>
                        <div>
                            <h4 class="text-sm text-gray-700 font-semibold">Status Pembimbingan</h4>
                            <p class="mt-1 text-gray-800 font-bold text-lg">
                                {{ $mentor->status_aktif ?? 'Aktif' }}
                            </p>
                        </div>
                    </div>
        
                    <p class="text-xs text-gray-500 mt-3">
                        <i class="fas fa-info-circle mr-1 text-indigo-400"></i>
                        Status ini mengikuti sistem & penugasan HR
                    </p>
                </div>
        
                <!-- 👨‍🏫 Jumlah Mahasiswa Bimbingan (lebih sederhana & informatif) -->
                <div class="bg-purple-50 border border-purple-200 rounded-2xl p-6 shadow-sm hover:shadow-lg transition">
                    <div class="flex items-center gap-4">
                        <div class="bg-purple-600 text-white w-12 h-12 rounded-xl flex items-center justify-center shadow text-xl">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <div>
                            <h4 class="text-sm text-gray-700 font-semibold">Total Mahasiswa Bimbingan</h4>
                            <p class="text-purple-700 font-bold text-3xl mt-1">
                                {{ $mentor->jumlah_bimbingan ?? 5 }}
                            </p>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-3 flex items-center gap-1">
                        <i class="fas fa-info-circle text-purple-400"></i>
                        Data ini diperbarui otomatis dari sistem
                    </p>
                </div>
            </div>
        </section>

        
        
        <!-- ========== 3. DOKUMEN PENDUKUNG (UI Lebih Menarik + TTD Digital Canvas) ========== -->
        <section id="dokumen-opsional">
            <h3 class="text-lg font-semibold text-indigo-700 mb-6 flex items-center">
                <i class="fas fa-folder-open mr-2"></i> Dokumen Pendukung
            </h3>
        
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
                <!-- ✅ Tanda Tangan Digital (Canvas Modal) -->
                <div class="berkas-field">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tanda Tangan Digital</label>
                    
                    <button type="button"
                        onclick="openTTDModal()"
                        class="flex items-center justify-between px-4 py-3 w-full border-2 border-dashed border-gray-300 rounded-xl cursor-pointer hover:border-indigo-500 transition shadow-sm bg-white">
                        
                        <div class="flex items-center gap-3">
                            <div class="bg-indigo-100 text-indigo-600 w-10 h-10 rounded-lg flex items-center justify-center shadow-sm">
                                <i class="fas fa-signature text-lg"></i>
                            </div>
                            <span class="text-gray-700 text-sm font-medium">Buat Tanda Tangan</span>
                        </div>
                        <i class="fas fa-pen text-indigo-500"></i>
                    </button>
        
                    <input type="hidden" name="tanda_tangan" id="tanda_tangan_input">
                    <p id="preview-ttd" class="text-xs text-gray-500 mt-1">Belum ada tanda tangan</p>
                </div>
        
                <!-- ✅ Foto ID / Badge Karyawan Tetap Upload -->
                <div class="berkas-field">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Foto ID / Badge Karyawan</label>
                    <label class="flex items-center justify-between px-4 py-3 border-2 border-dashed border-gray-300 rounded-xl cursor-pointer hover:border-indigo-500 transition shadow-sm bg-white">
                        <div class="flex items-center gap-3">
                            <div class="bg-indigo-100 text-indigo-600 w-10 h-10 rounded-lg flex items-center justify-center shadow-sm">
                                <i class="fas fa-id-card text-lg"></i>
                            </div>
                            <span class="text-gray-700 text-sm font-medium">Unggah Berkas</span>
                        </div>
                        <input type="file" name="foto_karyawan" class="hidden"
                            onchange="this.parentNode.querySelector('.file-name').innerText = this.files[0]?.name || 'Tidak ada file'">
                        <span class="file-name text-xs text-gray-500">Tidak ada file</span>
                    </label>
                </div>
        
            </div>
        </section>



        <!-- BUTTON -->
        <div class="flex justify-end">
            <button type="submit"
                class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-medium rounded-lg shadow hover:from-indigo-700 hover:to-purple-700 transition">
                <i class="fas fa-save mr-2"></i> Simpan Perubahan
            </button>
        </div>
        
        <!-- Modal Tanda Tangan -->
        <div id="ttdModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50">
            <div class="bg-white rounded-2xl shadow-2xl p-6 max-w-md w-full relative">
                
                <h3 class="text-lg font-bold mb-4 flex items-center gap-2 text-indigo-700">
                    <i class="fas fa-signature"></i> Gambar Tanda Tangan
                </h3>
        
                <canvas id="signaturePad" class="border border-gray-300 rounded-lg w-full h-48 bg-gray-50 cursor-crosshair"></canvas>
        
                <div class="flex justify-between mt-4">
                    <button type="button" onclick="clearSignature()"
                        class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 text-sm">
                        Reset
                    </button>
                    <div class="flex gap-2">
                        <button type="button" onclick="closeTTDModal()"
                            class="px-4 py-2 bg-gray-300 rounded-lg text-gray-700 hover:bg-gray-400 text-sm">
                            Batal
                        </button>
                        <button type="button" onclick="saveSignature()"
                            class="px-4 py-2 bg-indigo-600 rounded-lg text-white hover:bg-indigo-700 text-sm">
                            Simpan
                        </button>
                    </div>
                </div>
            </div>
        </div>


    </form>
</div>
<script>
let canvas = document.getElementById('signaturePad');
let ctx = canvas.getContext('2d');
let isDrawing = false;

// ✅ Sesuaikan ukuran canvas dengan ukuran aslinya (support retina)
canvas.width = canvas.offsetWidth;
canvas.height = canvas.offsetHeight;

function getPosition(e) {
    const rect = canvas.getBoundingClientRect();
    const x = (e.touches ? e.touches[0].clientX : e.clientX) - rect.left;
    const y = (e.touches ? e.touches[0].clientY : e.clientY) - rect.top;
    return { x, y };
}

canvas.addEventListener('mousedown', (e) => {
    isDrawing = true;
    const pos = getPosition(e);
    ctx.beginPath();
    ctx.moveTo(pos.x, pos.y);
});

canvas.addEventListener('mousemove', (e) => {
    if (!isDrawing) return;
    const pos = getPosition(e);
    draw(pos.x, pos.y);
});

canvas.addEventListener('mouseup', () => { isDrawing = false; });
canvas.addEventListener('mouseleave', () => { isDrawing = false; });

// ✅ Support touchscreen (mobile / tablet)
canvas.addEventListener('touchstart', (e) => {
    isDrawing = true;
    const pos = getPosition(e);
    ctx.beginPath();
    ctx.moveTo(pos.x, pos.y);
    e.preventDefault();
});

canvas.addEventListener('touchmove', (e) => {
    if (!isDrawing) return;
    const pos = getPosition(e);
    draw(pos.x, pos.y);
    e.preventDefault();
});

canvas.addEventListener('touchend', () => { isDrawing = false; });

window.addEventListener("DOMContentLoaded", () => {
    const currentDirektorat = "{{ $mentor->direktorat ?? '' }}";
    const currentFungsi = "{{ $mentor->fungsi ?? '' }}";

    if (currentDirektorat) {
        direktoratSelect.value = currentDirektorat;
        direktoratSelect.dispatchEvent(new Event('change'));
    }

    if (currentFungsi) {
        fungsiSelect.value = currentFungsi;
    }
});


function draw(x, y) {
    ctx.lineWidth = 2;
    ctx.lineCap = "round";
    ctx.strokeStyle = "#000";
    ctx.lineTo(x, y);
    ctx.stroke();
}

function openTTDModal() {
    const modal = document.getElementById('ttdModal');
    modal.classList.remove('hidden');

    setTimeout(() => {
        // ✅ Hitung ulang ukuran aktual canvas
        canvas.width = canvas.clientWidth;
        canvas.height = canvas.clientHeight;
        clearSignature();
    }, 50);
}


function closeTTDModal() {
    document.getElementById('ttdModal').classList.add('hidden');
}

function clearSignature() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
}

function saveSignature() {
    const dataURL = canvas.toDataURL("image/png");
    document.getElementById('tanda_tangan_input').value = dataURL;

    document.getElementById('preview-ttd').innerHTML =
        `<img src="${dataURL}" class="w-32 mt-2 border rounded shadow">`;

    closeTTDModal();
}


const direktoratSelect = document.getElementById('direktorat');
const fungsiSelect = document.getElementById('fungsi');

// Mapping data
const fungsiDirektorat = {
    "Direktorat Utama": [
        "Audit Executive",
        "Corporate Secretary",
        "Corp Strategic & Buss Dev",
        "Product Development",
        "HSSE"
    ],
    "Direktorat Sales & Marketing": [
        "West Region",
        "East Region",
        "Marketing",
        "Sales Strategy & Operation",
        "Key Account",
        "Sales & Marketing Overseas",
        "Technical Specialist"
    ],
    "Direktorat Operasi": [
        "Production",
        "Distribution",
        "Quality",
        "Technical Services"
    ],
    "Direktorat Finance & Business Support": [
        "Finance",
        "Human Capital & Quality Management",
        "Procurement & General Affairs"
    ]
};

// Event setiap Direktori berubah
direktoratSelect.addEventListener('change', function () {
    const selected = this.value;
    fungsiSelect.innerHTML = `<option value="">Pilih Fungsi</option>`;

    if (fungsiDirektorat[selected]) {
        fungsiDirektorat[selected].forEach(fungsi => {
            const opt = document.createElement('option');
            opt.value = fungsi;
            opt.textContent = fungsi;
            fungsiSelect.appendChild(opt);
        });
    }
});

</script>


@endsection
