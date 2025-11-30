@extends('layouts.mahasiswa', ['noHeader' => true])

@section('pageTitle', 'Presensi')
@section('pageSubtitle', 'Lakukan absensi harian melalui QR Code')

@section('content')

    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-center text-white p-7 rounded-2xl shadow-lg gap-6 mb-8"
        style="background: linear-gradient(135deg, #5a6de0 0%, #6c3fb0 100%);">
        <div>
            <h2 class="text-2xl font-bold flex items-center gap-5 leading-tight">
                <i class="fas fa-qrcode text-4xl"></i> Presensi Harian
            </h2>
            <p class="text-m text-white-100 mt-2">Lakukan presensi harian melalui QR Code</p>
        </div>
        <button class="px-5 py-2 bg-white/20 hover:bg-white/30 rounded-lg text-white font-medium flex items-center gap-2 transition-all duration-200 hover:scale-[1.03]">
            <i class="fas fa-location-arrow"></i> GPS Location
        </button>
    </div>

<div class="max-w-7xl mx-auto space-y-8">

    <!-- QR Code -->
    <div class="bg-white rounded-2xl shadow-lg p-8 text-center">
        <h2 class="text-xl font-semibold text-gray-800 mb-2 flex items-center justify-center">
            <i class="fas fa-qrcode mr-2 text-indigo-600"></i> QR Code Presensi Harian
        </h2>
        <p class="text-gray-500 text-sm mb-6">
            QR ini bersifat <strong>unik</strong> untuk akun Anda dan hanya berlaku hari ini.<br>
            Gunakan QR ini untuk melakukan <span class="text-indigo-600 font-semibold">Check-In</span> dan 
            <span class="text-green-600 font-semibold">Check-Out</span> melalui perangkat Anda sendiri.
        </p>

        <!-- QR Code -->
        <div class="flex justify-center mb-6">
            <div id="qrContainer"
                class="relative border-4 border-indigo-600 rounded-2xl p-4 bg-white shadow-inner transition-all duration-300 inline-block cursor-pointer hover:shadow-2xl hover:scale-105 active:scale-95">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=230x230&data=Presensi-Hari-Ini"
                    alt="QR Presensi Hari Ini"
                    class="w-52 h-52 mx-auto select-none rounded-lg transition-transform duration-300" />
            </div>
        </div>

        <!-- Popup QR Besar -->
        <div id="qrPopup" class="hidden fixed inset-0 bg-black/70 flex items-center justify-center z-[999] backdrop-blur-sm">
            <div class="relative border-4 border-indigo-600 bg-white rounded-2xl shadow-2xl p-6 transition-transform duration-300 scale-95 animate-fade-in">
                <button id="closeQrPopup"
                    class="absolute -top-3 -right-3 bg-red-600 text-white rounded-full w-8 h-8 flex items-center justify-center shadow hover:bg-red-700 transition">
                    ✕
                </button>
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=400x400&data=Presensi-Hari-Ini"
                    alt="QR Besar"
                    class="w-80 h-80 mx-auto rounded-lg shadow-inner select-none" />
            </div>
        </div>

        <!-- Tambahkan animasi fade -->
        <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
        .animate-fade-in {
            animation: fadeIn 0.25s ease-out forwards;
        }
        </style>

        <script>
        // Popup QR interaktif
        const qrContainer = document.getElementById('qrContainer');
        const qrPopup = document.getElementById('qrPopup');
        const closeQrPopup = document.getElementById('closeQrPopup');

        qrContainer.addEventListener('click', () => {
            qrPopup.classList.remove('hidden');
        });

        closeQrPopup.addEventListener('click', () => {
            qrPopup.classList.add('hidden');
        });

        // Tutup popup bila klik area luar
        qrPopup.addEventListener('click', (e) => {
            if (e.target === qrPopup) qrPopup.classList.add('hidden');
        });
        </script>


        <!-- Mekanisme -->
        <div class="bg-indigo-50 border border-indigo-200 rounded-2xl text-left p-5 max-w-3xl mx-auto">
            <h3 class="font-semibold text-indigo-800 mb-2 flex items-center">
                <i class="fas fa-info-circle mr-2"></i> Mekanisme Presensi
            </h3>
            <ul class="list-disc pl-6 text-sm text-gray-700 space-y-1">
                <li>QR Code ini digunakan sebagai identitas presensi harian dan diperbarui otomatis setiap hari.</li>
                <li>Setiap mahasiswa memiliki QR unik dengan token identitas masing-masing.</li>
                <li>Scan pertama akan mencatat <strong>Check-In</strong> beserta waktu dan lokasi GPS.</li>
                <li>Scan kedua akan mencatat <strong>Check-Out</strong> secara otomatis.</li>
                <li>Status presensi akan berubah menjadi <span class="text-green-600 font-semibold">Hadir</span> setelah keduanya selesai.</li>
            </ul>
        </div>
    </div>

    <!-- Tombol Simulasi Scan -->
    <div class="flex flex-col md:flex-row justify-center gap-4 mt-5">
        <!-- Tombol Scan -->
        <button id="btnSimulasiScan"
            class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl shadow-lg flex items-center gap-2 transition-transform hover:scale-105">
            <i class="fas fa-camera"></i> Simulasi Scan QR (Presensi)
        </button>
    
        <!-- Tombol Ajukan Izin -->
        <button id="btnIzin"
            class="px-6 py-3 bg-yellow-500 hover:bg-yellow-600 text-white rounded-xl shadow-lg flex items-center gap-2 transition-transform hover:scale-105">
            <i class="fas fa-envelope-open-text"></i> Ajukan Izin
        </button>
    </div>
    <p class="text-xs text-gray-500 mt-2 text-center italic">
        Scan untuk Simulasi Presensi • Ajukan izin tanpa scan
    </p>
    
    <!-- MODAL IZIN -->
    <div id="izinModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-[999] backdrop-blur-sm">
        <div class="bg-white rounded-2xl p-6 w-full max-w-md shadow-xl relative animate-fade-in">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                Ajukan Izin Presensi
            </h3>
    
            <label class="text-sm font-medium text-gray-600">Tanggal</label>
            <input type="date" class="w-full border rounded-lg p-2 my-2 text-sm" id="izinDate">
    
            <label class="text-sm font-medium text-gray-600">Alasan</label>
            <textarea id="izinReason" rows="3"
                class="w-full border rounded-lg p-2 text-sm focus:ring-indigo-500 focus:border-indigo-500"
                placeholder="Contoh: Sakit, keperluan keluarga, dsb."></textarea>
    
            <div class="flex justify-end gap-2 mt-4">
                <button onclick="closeIzinModal()"
                    class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 rounded-lg">Batal</button>
                <button onclick="submitIzin()"
                    class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg">Kirim</button>
            </div>
        </div>
    </div>


    
    

    <!-- Riwayat Presensi -->
    <div class="bg-white rounded-2xl shadow-lg p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
            <i class="fas fa-history mr-2 text-purple-600"></i> Riwayat Presensi
        </h2>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-gray-700 border border-gray-200 rounded-xl overflow-hidden">
                <thead class="bg-gray-100 text-gray-800">
                    <tr>
                        <th class="px-4 py-2 text-left font-semibold">Tanggal</th>
                        <th class="px-4 py-2 text-center font-semibold">Check-In</th>
                        <th class="px-4 py-2 text-center font-semibold">Check-Out</th>
                        <th class="px-4 py-2 text-center font-semibold">Status</th>
                    </tr>
                </thead>
                <tbody id="presensiBody">
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="px-4 py-2 align-top font-medium">01 Okt 2025</td>
                        <td class="px-4 py-2 text-center">
                            08:05<br>
                            <span class="text-xs text-gray-500">Surabaya</span><br>
                            <span class="text-[10px] text-gray-400">(Lat: -7.25044, Lon: 112.76884)</span>
                        </td>
                        <td class="px-4 py-2 text-center">
                            16:30<br>
                            <span class="text-xs text-gray-500">Surabaya</span><br>
                            <span class="text-[10px] text-gray-400">(Lat: -7.25044, Lon: 112.76884)</span>
                        </td>
                        <td class="px-4 py-2 text-center">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">Hadir</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Loading Overlay -->
<div id="loadingOverlay" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50 backdrop-blur-sm">
    <div class="bg-white rounded-2xl shadow-lg p-6 flex flex-col items-center">
        <div class="animate-spin rounded-full h-10 w-10 border-t-4 border-indigo-600 mb-3"></div>
        <p class="text-gray-700 text-sm font-medium">Mendeteksi lokasi dan alamat...</p>
    </div>
</div>

<!-- Popup Handphone Realistis -->
<div id="scanPopup" class="hidden fixed inset-0 bg-black/70 flex items-center justify-center z-[999]">
    <div id="popupCard"
        class="relative bg-white rounded-[2.5rem] shadow-2xl w-80 h-[520px] border-[10px] border-gray-800 overflow-hidden transform translate-y-full transition-transform duration-500 ease-out">
        
        <!-- Notch -->
        <div class="absolute top-0 left-1/2 transform -translate-x-1/2 w-28 h-6 bg-gray-800 rounded-b-2xl"></div>

        <!-- Layar isi -->
        <div class="mt-10 p-6 text-center flex flex-col justify-between h-full">
            <div>
                <h3 id="popupTitle" class="text-xl font-semibold text-gray-800 mb-3">📱 Simulasi Presensi</h3>
                <div id="popupContent" class="bg-gray-50 border border-gray-200 rounded-xl p-4 mb-4 text-sm text-gray-700">
                    <p id="popupMessage">Mendeteksi lokasi...</p>
                    <p id="popupTime" class="text-xs text-gray-500 mt-2"></p>
                </div>
            </div>
            <div id="popupButtons">
                <button id="closePopup"
                    class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg shadow transition-all duration-300 hover:scale-105 w-full">
                    Tutup
                </button>
                <p class="text-[10px] text-gray-400 mt-2">Simulasi tampilan layar handphone</p>
            </div>
        </div>
    </div>
</div>

<!-- JS Presensi -->
<script>
let scanCount = 0;
const btnScan = document.getElementById('btnSimulasiScan');
const presensiBody = document.getElementById('presensiBody');
const loadingOverlay = document.getElementById('loadingOverlay');
const popup = document.getElementById('scanPopup');
const popupCard = document.getElementById('popupCard');
const popupTitle = document.getElementById('popupTitle');
const popupMessage = document.getElementById('popupMessage');
const popupTime = document.getElementById('popupTime');
const popupContent = document.getElementById('popupContent');
const popupButtons = document.getElementById('popupButtons');
const closePopup = document.getElementById('closePopup');

// Fungsi tampilkan popup
function showPopup(status, alamat, lat, lon, time, callback = null) {
    popup.classList.remove('hidden');
    setTimeout(() => popupCard.classList.remove('translate-y-full'), 50);
    if (navigator.vibrate) navigator.vibrate(80);

    if (status === 'checkin') {
        popupTitle.textContent = '✅ Check-In Berhasil';
        popupMessage.innerHTML = `<span class="block mb-1">${alamat}</span>
        <span class="text-xs text-gray-500">(Lat: ${lat}, Lon: ${lon})</span>`;
        popupTime.textContent = `Waktu: ${time}`;
        popupButtons.innerHTML = `<button id="closePopup"
            class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg shadow transition-all duration-300 hover:scale-105 w-full">
            Tutup
        </button>`;
        document.getElementById('closePopup').onclick = closeModal;
    }

    else if (status === 'confirm-checkout') {
        popupTitle.textContent = '🚪 Konfirmasi Check-Out';
        popupMessage.textContent = 'Apakah Anda yakin ingin melakukan Check-Out sekarang?';
        popupTime.textContent = '';
        popupButtons.innerHTML = `
            <div class="flex gap-3">
                <button id="btnCancel" class="flex-1 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg">Batalkan</button>
                <button id="btnYes" class="flex-1 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg">Ya, Check-Out</button>
            </div>`;
        document.getElementById('btnCancel').onclick = closeModal;
        document.getElementById('btnYes').onclick = () => {
            closeModal();
            setTimeout(callback, 400);
        };
    }

    else if (status === 'checkout') {
        popupTitle.textContent = '✅ Check-Out Berhasil';
        popupMessage.innerHTML = `<span class="block mb-1">${alamat}</span>
        <span class="text-xs text-gray-500">(Lat: ${lat}, Lon: ${lon})</span>`;
        popupTime.textContent = `Waktu: ${time}`;
        popupButtons.innerHTML = `<button id="closePopup"
            class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg shadow w-full">
            Tutup
        </button>`;
        document.getElementById('closePopup').onclick = closeModal;
    }
}

// Tutup popup
function closeModal() {
    popupCard.classList.add('translate-y-full');
    setTimeout(() => popup.classList.add('hidden'), 400);
}

// Geolocation + simulasi scan
function simulateScan() {
    if (!navigator.geolocation) {
        alert("Browser tidak mendukung geolokasi.");
        return;
    }
    loadingOverlay.classList.remove('hidden');

    navigator.geolocation.getCurrentPosition(async (pos) => {
        const lat = pos.coords.latitude.toFixed(5);
        const lon = pos.coords.longitude.toFixed(5);
        const alamat = await getReadableLocation(lat, lon);
        const time = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        const tanggal = new Date().toLocaleDateString('id-ID', { day: '2-digit', month: '2-digit', year: 'numeric' });

        loadingOverlay.classList.add('hidden');

        let existingRow = [...presensiBody.querySelectorAll('tr')].find(row =>
            row.querySelector('td')?.innerText.trim() === tanggal
        );

        if (!existingRow) {
            existingRow = document.createElement('tr');
            existingRow.className = 'border-b hover:bg-gray-50 transition';
            existingRow.innerHTML = `
                <td class="px-4 py-2 align-top font-medium">${tanggal}</td>
                <td class="px-4 py-2 text-center" id="in-${tanggal.replace(/\//g,'')}">-</td>
                <td class="px-4 py-2 text-center" id="out-${tanggal.replace(/\//g,'')}">-</td>
                <td class="px-4 py-2 text-center" id="status-${tanggal.replace(/\//g,'')}">-</td>`;
            presensiBody.prepend(existingRow);
        }

        const inCell = document.getElementById(`in-${tanggal.replace(/\//g,'')}`);
        const outCell = document.getElementById(`out-${tanggal.replace(/\//g,'')}`);
        const statusCell = document.getElementById(`status-${tanggal.replace(/\//g,'')}`);

        const lokasiHTML = `
            <span class="block text-xs text-gray-500 mt-1">${alamat}</span>
            <span class="block text-[10px] text-gray-400">(Lat: ${lat}, Lon: ${lon})</span>`;

        scanCount++;
        if (scanCount === 1) {
            inCell.innerHTML = `${time}${lokasiHTML}`;
            statusCell.innerHTML = `<span class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">Belum Check-Out</span>`;
            showPopup('checkin', alamat, lat, lon, time);
        } 
        else if (scanCount === 2) {
            showPopup('confirm-checkout', '', '', '', '', () => {
                outCell.innerHTML = `${time}${lokasiHTML}`;
                statusCell.innerHTML = `<span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">Hadir</span>`;
                showPopup('checkout', alamat, lat, lon, time);
            });
        } 
        else {
            alert("📌 Anda sudah melakukan Check-In dan Check-Out hari ini.");
        }
    }, () => {
        loadingOverlay.classList.add('hidden');
        alert('❌ Gagal mendeteksi lokasi.');
    });
}

async function getReadableLocation(lat, lon) {
    try {
        const res = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`);
        const data = await res.json();
        return data.display_name || `Lat: ${lat}, Lon: ${lon}`;
    } catch {
        return `Lat: ${lat}, Lon: ${lon}`;
    }
}

btnScan.addEventListener('click', simulateScan);


const btnIzin = document.getElementById('btnIzin');
const izinModal = document.getElementById('izinModal');

btnIzin.addEventListener('click', () => {
    izinModal.classList.remove('hidden');
});

function closeIzinModal() {
    izinModal.classList.add('hidden');
}

function submitIzin() {
    const tanggal = document.getElementById('izinDate').value;
    const alasan = document.getElementById('izinReason').value.trim();

    if (!tanggal || !alasan) {
        alert("Harap isi tanggal dan alasan izin.");
        return;
    }

    presensiBody.insertAdjacentHTML('afterbegin', `
        <tr class="border-b hover:bg-gray-50 transition">
            <td class="px-4 py-2 font-medium">${tanggal}</td>
            <td class="px-4 py-2 text-center text-gray-400" colspan="2">
                Izin — ${alasan}
            </td>
            <td class="px-4 py-2 text-center">
                <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-semibold">Izin</span>
            </td>
        </tr>
    `);

    closeIzinModal();
}

</script>

@endsection
