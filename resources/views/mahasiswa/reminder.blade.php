@extends('layouts.mahasiswa', ['noHeader' => true])

@section('pageTitle', 'Reminder & Durasi Magang')
@section('pageSubtitle', 'Pantau sisa waktu magang dan agenda penting')

@section('content')

@php
    $tanggalSelesai = '2025-10-30';
    $hariSekarang = date('Y-m-d');
    $selisihHari = floor((strtotime($tanggalSelesai) - strtotime($hariSekarang)) / 86400);
@endphp

<div class="max-w-5xl mx-auto space-y-8">

    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-center text-white p-7 rounded-2xl shadow-lg gap-6 mb-8"
        style="background: linear-gradient(135deg, #5a6de0 0%, #6c3fb0 100%);">
        <div>
            <h2 class="text-2xl font-bold flex items-center gap-5 leading-tight">
                <i class="fas fa-bell text-4xl"></i> Sisa Waktu Magang
            </h2>
            <p class="text-m text-white-100 mt-2">Magang berakhir pada <b>{{ date('d F Y', strtotime($tanggalSelesai)) }}</b></p>
        </div>
        <div class="text-center mt-6 sm:mt-0">
            <p class="text-5xl font-extrabold" id="countdownDays">{{ $selisihHari > 0 ? $selisihHari : 0 }}</p>
            <p class="text-sm">Hari Tersisa</p>
        </div>
    </div>


    <!-- Reminder H-7 s/d H-1 -->
    @if($selisihHari <= 7 && $selisihHari > 0)
    <div class="bg-yellow-100 text-yellow-800 border border-yellow-300 px-6 py-4 rounded-xl shadow-md flex gap-3 items-start">
        <i class="fas fa-exclamation-circle mt-1"></i>
        <div>
            <p class="font-semibold">⚠️ Sudah H-{{ $selisihHari }} menuju akhir magang!</p>
            <p class="text-sm">Segera selesaikan dan upload laporan akhir magang ke sistem.</p>
        </div>
    </div>
    @endif


    <!-- Progress Magang -->
    <div class="bg-white rounded-2xl shadow-md p-6">
        <h3 class="text-lg font-semibold mb-4 flex items-center text-gray-800">
            <i class="fas fa-hourglass-half text-purple-600 mr-2"></i> Progress Magang
        </h3>

        @php
            $tanggalMulai = '2025-01-01'; // contoh: bisa dari database
            $totalHari = (strtotime($tanggalSelesai) - strtotime($tanggalMulai)) / 86400;
            $hariBerjalan = (strtotime($hariSekarang) - strtotime($tanggalMulai)) / 86400;
            $persenProgress = max(min(($hariBerjalan / $totalHari) * 100, 100), 0);
        @endphp

        <div>
            <div class="w-full bg-gray-200 rounded-full h-4 mb-2">
                <div class="bg-indigo-600 h-4 rounded-full text-right pr-2 text-white text-xs font-bold flex items-center justify-end"
                    style="width: {{ $persenProgress }}%;">
                    {{ number_format($persenProgress, 0) }}%
                </div>
            </div>
            <p class="text-xs text-gray-500">Periode: Jan 2025 – Okt 2025</p>
        </div>
    </div>

</div>

<script>
    // Countdown Example
    const endDate = new Date("{{ $tanggalSelesai }}").getTime();
    const countdownEl = document.getElementById("countdownDays");

    function updateCountdown() {
        const now = new Date().getTime();
        const diff = endDate - now;
        const days = Math.floor(diff / (1000 * 60 * 60 * 24));
        countdownEl.textContent = days > 0 ? days : 0;
    }
    updateCountdown();
    setInterval(updateCountdown, 86400000);
</script>

@endsection
