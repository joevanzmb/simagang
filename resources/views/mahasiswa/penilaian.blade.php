@extends('layouts.mahasiswa', ['noHeader' => true])

@section('pageTitle', 'Penilaian Magang')
@section('pageSubtitle', 'Lihat hasil evaluasi performa magang dan umpan balik dari mentor.')

@section('content')
<div class="space-y-10">

    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-center text-white p-7 rounded-2xl shadow-lg"
        style="background: linear-gradient(135deg, #5a6de0 0%, #6c3fb0 100%);">
        <div>
            <h2 class="text-2xl font-bold flex items-center gap-4 leading-tight">
                <i class="fas fa-medal text-3xl"></i> Penilaian Magang
            </h2>
            <p class="text-m text-white/80 mt-1">Hasil evaluasi performa magang oleh mentor Anda.</p>
        </div>
    </div>

    <!-- Ringkasan Nilai & Grafik -->
    <div class="grid md:grid-cols-2 gap-6">
        <!-- Card Nilai Akhir + Feedback -->
        <div class="bg-white rounded-2xl shadow-lg p-6 flex flex-col items-center text-center space-y-20">
            @php $nilaiAkhir = 89; @endphp

            <!-- Nilai Akhir -->
            <div class="bg-gradient-to-br from-indigo-50 to-white p-5 rounded-2xl border border-indigo-100 shadow-inner flex flex-col items-center">
                <div class="text-xl font-bold text-indigo-700 mb-7">Nilai Akhir</div>
                <div class="relative w-52 h-52 flex items-center justify-center">
                    <svg id="progressCircle" class="w-52 h-52 -rotate-90" viewBox="0 0 100 100">
                        <circle cx="50" cy="50" r="45" stroke="#E5E7EB" stroke-width="10" fill="none" />
                        <circle id="progressBar" cx="50" cy="50" r="45" stroke-width="10" fill="none" stroke-linecap="round"
                            stroke-dasharray="282.6" stroke-dashoffset="282.6" />
                    </svg>
                    <div id="nilaiText" class="absolute text-6xl font-bold text-indigo-700 drop-shadow-sm">0</div>
                </div>
                <p id="keteranganNilai" class="mt-4 px-5 py-2 bg-indigo-100/60 text-indigo-700 font-semibold text-sm rounded-full shadow-sm">
                    Menilai...
                </p>
            </div>

            <!-- Feedback Mentor -->
            <div class="w-full bg-indigo-50 p-5 rounded-2xl border border-indigo-100 text-left shadow-sm">
                <h4 class="text-sm font-semibold text-indigo-700 mb-2 flex items-center gap-2">
                    <i class="fas fa-comments text-indigo-500"></i> Feedback Mentor
                </h4>
                <p class="text-gray-700 text-sm leading-relaxed mb-2">
                    “Joevanz menunjukkan performa yang luar biasa dalam keaktifan dan komunikasi tim.
                    Penguasaan teknologinya sangat baik, hanya perlu sedikit peningkatan pada manajemen waktu.”
                </p>
                <p class="text-xs text-gray-500 italic">— Andi Saputra, Mentor Human Capital</p>
                <div class="mt-3 flex justify-end">
                </div>
            </div>
        </div>

        <!-- Grafik Nilai -->
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-chart-pie text-indigo-600"></i> Rata-rata Nilai Tiap Aspek
            </h3>
            <canvas id="grafikNilaiMahasiswa" height="160"></canvas>
        </div>
    </div>

    <!-- Detail Penilaian -->
    <div class="bg-white rounded-2xl shadow-lg p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2">
            <i class="fas fa-clipboard-list text-indigo-600"></i> Detail Penilaian
        </h3>

        @php
            $nilai = [
                ['Integritas (Etika, moral, dan kesungguhan)', 90],
                ['Ketepatan waktu dalam bekerja', 87],
                ['Keahlian berdasarkan bidang ilmu', 88],
                ['Kerjasama dalam tim', 85],
                ['Komunikasi', 92],
                ['Penggunaan teknologi informasi', 86],
                ['Pengembangan diri', 89]
            ];
            $totalNilai = collect($nilai)->sum(fn($n) => $n[1]);
            $rataRata = round($totalNilai / count($nilai), 2);
        @endphp

        <!-- TABEL ASPEK PENILAIAN -->
        <div class="overflow-x-auto">
            <div class="bg-gradient-to-r from-indigo-50 to-purple-50 border border-indigo-100 rounded-2xl shadow-md overflow-hidden">
                
                <!-- HEADER 3 KOLOM -->
                <div class="grid grid-cols-3 bg-indigo-600 text-white text-sm font-semibold">
                    <div class="px-5 py-3 flex items-center gap-2 border-r border-indigo-500">
                        <i class="fas fa-list-check"></i> Aspek Penilaian Mahasiswa
                    </div>
                    <div class="text-center flex items-center justify-center border-r border-indigo-500">Nilai</div>
                    <div class="text-center flex items-center justify-center">Kategori</div>
                </div>

                <!-- Bagian dalam tabel Aspek Penilaian -->
                <table class="min-w-full text-sm text-gray-700">
                    <tbody class="bg-white">
                        @foreach ($nilai as [$aspek, $score])
                            <tr class="hover:bg-gray-50 transition border-t">
                                <td class="px-4 py-3">{{ $aspek }}</td>
                                <td class="px-4 py-3 text-center align-middle font-semibold text-indigo-600">{{ $score }}</td>
                                <td class="px-4 py-3 text-center align-middle">
                                    @if ($score >= 86)
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700 shadow-sm">Sangat Memuaskan</span>
                                    @elseif ($score >= 71)
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700 shadow-sm">Memuaskan</span>
                                    @else
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700 shadow-sm">Cukup Memuaskan</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                        <!-- Baris Rata-rata -->
                        <tr class="bg-indigo-50 border-t">
                            <td class="px-4 py-3 font-bold text-gray-800">Rata-rata</td>
                            <td class="px-4 py-3 text-center align-middle font-bold text-indigo-700 text-base">{{ $rataRata }}</td>
                            <td class="px-4 py-3 text-center align-middle">
                                @if ($rataRata >= 86)
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700 shadow-sm">Sangat Memuaskan</span>
                                @elseif ($rataRata >= 71)
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700 shadow-sm">Memuaskan</span>
                                @else
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700 shadow-sm">Cukup Memuaskan</span>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


        <!-- KETERANGAN INDIKATOR PENILAIAN -->
        <div class="mt-5 bg-gray-50 border border-gray-200 rounded-xl p-4 text-sm text-gray-600">
            <h4 class="font-semibold text-gray-800 mb-2 flex items-center gap-2">
                <i class="fas fa-info-circle text-indigo-600"></i> Keterangan Indikator Penilaian:
            </h4>
            <ul class="list-disc pl-5 space-y-1">
                <li>Nilai ≥ 86           : <span class="font-medium text-green-600">Sangat Memuaskan</span> </li>
                <li>Nilai antara 71 – 85 :  <span class="font-medium text-yellow-600">Memuaskan</span></li>
                <li>Nilai ≤ 70           : <span class="font-medium text-red-600">Cukup Memuaskan</span> </li>
            </ul>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const nilai = {{ $nilaiAkhir }};
    const progress = document.getElementById('progressBar');
    const text = document.getElementById('nilaiText');
    const keterangan = document.getElementById('keteranganNilai');
    const maxDash = 282.6;
    let color = '#EF4444';
    let label = 'Cukup Memuaskan';

    if (nilai >= 86) { color = '#22C55E'; label = 'Sangat Memuaskan'; }
    else if (nilai >= 71) { color = '#EAB308'; label = 'Memuaskan'; }

    progress.setAttribute('stroke', color);
    const target = maxDash - (maxDash * nilai / 100);
    let current = 0, currentValue = 0;
    const step = (maxDash - target) / 60;

    function animate() {
        if (current < (maxDash - target)) {
            current += step;
            currentValue += nilai / 60;
            progress.setAttribute('stroke-dashoffset', maxDash - current);
            text.textContent = Math.round(currentValue);
            requestAnimationFrame(animate);
        } else {
            progress.setAttribute('stroke-dashoffset', target);
            text.textContent = nilai;
            keterangan.textContent = label;
        }
    }
    animate();
});

new Chart(document.getElementById('grafikNilaiMahasiswa'), {
    type: 'radar',
    data: {
        labels: ['Integritas','Ketepatan waktu','Keahlian','Kerjasama','Komunikasi','Teknologi','Pengembangan diri'],
        datasets: [{
            label: 'Nilai Anda',
            data: [90,87,88,85,92,86,89],
            fill: true,
            backgroundColor: 'rgba(99,102,241,0.2)',
            borderColor: '#6366f1',
            pointBackgroundColor: '#6366f1'
        }]
    },
    options: {
        scales: {
            r: {
                beginAtZero: true,
                suggestedMax: 100,
                grid: { color: '#e5e7eb' },
                angleLines: { color: '#e5e7eb' },
                pointLabels: { color: '#374151', font: { size: 11 } }
            }
        },
        plugins: { legend: { display: false } }
    }
});
</script>
@endsection
