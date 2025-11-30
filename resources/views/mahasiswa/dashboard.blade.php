@extends('layouts.mahasiswa', ['noHeader' => true])

@section('pageTitle', 'Dashboard Mahasiswa')
@section('pageSubtitle', 'Selamat datang di Sistem Informasi Magang')

@section('content')

@php
    use Carbon\Carbon;

    $today = Carbon::today();
    $periodeSelesai = isset($mahasiswa->periode_selesai) ? Carbon::parse($mahasiswa->periode_selesai) : Carbon::now()->addDays(30);
    $deadlineLaporan = $periodeSelesai->copy()->subDays(7);
    $sisaHari = $today->diffInDays($deadlineLaporan, false);

    $nilaiRata = $mahasiswa->nilai_rata2 ?? null;
    $showNilai = $today->greaterThanOrEqualTo($periodeSelesai) && $nilaiRata !== null;
    $laporanUploaded = $mahasiswa->laporan_uploaded ?? false;

    // Dummy nilai per aspek
    $aspekNilai = [
        'Integritas' => 88,
        'Ketepatan Waktu' => 85,
        'Keahlian' => 87,
        'Kerjasama' => 84,
        'Komunikasi' => 86,
        'Teknologi' => 83,
        'Pengembangan Diri' => 82,
    ];
@endphp

<!-- ✅ HEADER -->
<div class="flex flex-col md:flex-row justify-between items-center text-white p-7 rounded-2xl shadow-lg mb-10"
    style="background: linear-gradient(135deg, #5a6de0, #6c3fb0);">
    <div>
        <h2 class="text-3xl font-bold flex items-center gap-4">
            <i class="fas fa-user-graduate text-4xl drop-shadow-sm"></i>
            Halo, {{ Auth::user()->name ?? 'Mahasiswa' }} 👋
        </h2>
        <p class="text-sm text-white/80 mt-1">Selamat datang dan selesaikan seluruh proses magangmu dengan baik!</p>
    </div>
    <a href="{{ route('mahasiswa.laporan') }}"
       class="px-5 py-2 bg-white/20 hover:bg-white/30 rounded-lg text-white text-sm font-medium flex items-center gap-2 transition hover:scale-[1.03]">
        <i class="fas fa-file-upload"></i> Laporan Magang
    </a>
</div>

<div class="space-y-10">

    <!-- ✅ STAT CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <!-- Nilai Rata-rata -->
        <div class="group bg-gradient-to-br from-white to-indigo-50 border border-indigo-100 p-6 rounded-2xl shadow-sm hover:shadow-xl transition">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-gray-500 text-sm">Nilai Rata-rata</p>
                    @if($showNilai)
                        <p class="text-4xl font-extrabold text-indigo-700 mt-1">{{ $nilaiRata }}</p>
                        <span class="text-xs font-medium text-indigo-600">
                            {{ $nilaiRata >= 85 ? 'Baik' : 'Cukup' }}
                        </span>
                    @else
                        <p class="text-sm mt-2 font-medium text-gray-700">Menunggu hasil akhir...</p>
                        <p class="text-[11px] text-gray-500">Selesai: {{ $periodeSelesai->translatedFormat('d M Y') }}</p>
                    @endif
                </div>
                <div class="bg-indigo-100 group-hover:bg-indigo-200 w-14 h-14 rounded-xl flex items-center justify-center">
                    <i class="fas fa-star text-indigo-700 text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Status Laporan -->
        <div class="group bg-gradient-to-br from-white to-purple-50 border border-purple-100 p-6 rounded-2xl shadow-sm hover:shadow-xl transition">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-gray-500 text-sm">Laporan Magang</p>
                    @if($laporanUploaded)
                        <p class="text-4xl font-extrabold text-green-600 mt-1">✅</p>
                        <p class="text-[11px] text-green-600 font-medium mt-2">Sudah Upload</p>
                    @else
                        <p class="text-4xl font-extrabold text-red-600 mt-1"> H-{{ max(0, ceil($sisaHari)) }}</p>
                        <p class="text-[11px] text-yellow-600 font-medium mt-2">
                            Deadline: {{ $deadlineLaporan->translatedFormat('d M') }}
                        </p>
                    @endif
                </div>
                <div class="bg-purple-100 group-hover:bg-purple-200 w-14 h-14 rounded-xl flex items-center justify-center">
                    <i class="fas fa-file-alt text-purple-700 text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Reminder Count -->
        <div class="group bg-gradient-to-br from-white to-pink-50 border border-pink-100 p-6 rounded-2xl shadow-sm hover:shadow-xl transition">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-gray-500 text-sm">Tugas / Reminder</p>
                    <p class="text-4xl font-extrabold text-pink-600 mt-1">{{ $laporanUploaded ? 0 : 1 }}</p>
                </div>
                <div class="bg-pink-100 group-hover:bg-pink-200 w-14 h-14 rounded-xl flex items-center justify-center">
                    <i class="fas fa-bell text-pink-700 text-2xl"></i>
                </div>
            </div>
            <p class="text-[11px] text-gray-500 italic mt-2">Tetap cek pengumuman ya!</p>
        </div>
    </div>

    <!-- ✅ KARTU GRAFIK -->
    <div class="grid md:grid-cols-2 gap-6">

        <!-- Grafik Kehadiran -->
        <div class="bg-white p-6 rounded-2xl shadow-lg relative">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-chart-pie text-indigo-600"></i> Rekap Kehadiran Bulan Ini
            </h3>
        
            <div class="relative flex items-center justify-center">
                <canvas id="chartPresensi" class="w-300px] h-[300px]"></canvas>

        
                <!-- ✅ teks persentase di tengah donut -->
                <div class="absolute text-center">
                    <p class="text-3xl font-extrabold text-indigo-700" id="persentaseKehadiran">-</p>
                    <p class="text-[10px] text-gray-500 mt-1 uppercase tracking-wide">Hadir</p>
                </div>
            </div>
        
            <!-- ✅ legenda ringkas -->
            <div class="flex justify-center mt-4 gap-4 text-xs text-gray-600">
                <span><span class="inline-block w-3 h-3 rounded-full bg-green-500 mr-1"></span>Hadir</span>
                <span><span class="inline-block w-3 h-3 rounded-full bg-yellow-500 mr-1"></span>Izin</span>
                <span><span class="inline-block w-3 h-3 rounded-full bg-red-500 mr-1"></span>Alfa</span>
            </div>

        </div>


        <!-- Grafik Aspek Nilai -->
        <div class="bg-white p-6 rounded-2xl shadow-lg">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-chart-bar text-green-600"></i> Nilai per Aspek
            </h3>
            <canvas id="chartPenilaian" class="w-full h-64"></canvas>
        </div>
    </div>

    <!-- ✅ Reminder Section -->
    <div class="bg-white p-6 rounded-2xl shadow-lg">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Reminder Magang</h3>
        <div class="flex items-center justify-between border-b pb-3 text-sm">
            <span class="flex items-center gap-2 text-gray-700">
                <i class="fas fa-file-upload text-indigo-600"></i> Kirim Laporan Magang
            </span>

            <span class="px-2 py-1 rounded-full text-xs
                @if($laporanUploaded)
                    bg-green-100 text-green-700
                @elseif($sisaHari >= 7)
                    bg-yellow-100 text-yellow-700
                @else
                    bg-red-100 text-red-700
                @endif
            ">
                {{ $laporanUploaded ? 'Selesai' : "H-$sisaHari" }}
            </span>
        </div>
    </div>
</div>


<!-- ✅ CHART.JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// ===== DATA DUMMY (nanti dari backend) =====
const hadir = 22;
const izin = 1;
const alfa = 2;
const total = hadir + izin + alfa;
const persenHadir = Math.round((hadir / total) * 100);

// Tampilkan angka tengah donut
document.getElementById('persentaseKehadiran').innerText = persenHadir + "%";

// ===== DONUT PRESENSI STABIL =====
const presensiChart = new Chart(document.getElementById('chartPresensi'), {
    type: 'doughnut',
    data: {
        labels: ['Hadir', 'Izin', 'Alfa'],
        datasets: [{
            data: [hadir, izin, alfa],
            backgroundColor: [
                '#10B981', // Hadir
                '#F59E0B', // Izin
                '#EF4444'  // Alfa
            ],
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false, // ✅ biar ngikut container
        plugins: {
            legend: { display: false }
        },
        cutout: '70%', // ✅ ideal untuk ukuran kecil
    }
});

// ===== BAR CHART NILAI PER ASPEK =====
const aspekLabels = @json(array_keys($aspekNilai));
const aspekValues = @json(array_values($aspekNilai));

new Chart(document.getElementById('chartPenilaian'), {
    type: 'bar',
    data: {
        labels: aspekLabels,
        datasets: [{
            data: aspekValues,
            backgroundColor: 'rgba(79,70,229,0.85)',
            borderRadius: 10
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false }},
        scales: {
            y: {
                beginAtZero: true,
                max: 100,
                ticks: { stepSize: 20 }
            }
        },
        animation: {
            delay: 300,
            easing: 'easeOutQuart'
        }
    }
});
</script>


@endsection
