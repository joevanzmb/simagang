@extends('layouts.app', ['noHeader' => true])

@section('pageTitle', 'Feedback Evaluasi Magang')
@section('pageSubtitle', 'Rekap hasil evaluasi program magang PT Pertamina Lubricants')

@section('content')

<!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-center text-white p-7 rounded-2xl shadow-lg gap-6 mb-8"
        style="background: linear-gradient(135deg, #5a6de0 0%, #6c3fb0 100%);">
        <div>
            <h2 class="text-2xl font-bold flex items-center gap-5 leading-tight">
                <i class="fas fa-graduation-cap text-4xl"></i> Feedback Evaluasi Magang
            </h2>
            <p class="text-m text-white-100 mt-2">Rekap hasil evaluasi program magang</p>
        </div>
        <button class="px-5 py-2 bg-white/20 hover:bg-white/30 rounded-lg text-white font-medium flex items-center gap-2 transition-all duration-200 hover:scale-[1.03]">
            <i class="fas fa-download"></i> Download Laporan
        </button>
    </div>
<div class="max-w-7xl mx-auto">

    @php
        // Dummy data feedback evaluasi
        $feedbacks = [
            (object)[
                'nama' => 'Ahmad Fauzi',
                'posisi' => 'Data Analyst',
                'mentor' => 'Bapak Andi',
                'nilai' => [
                    'Integritas' => 90,
                    'Ketepatan Waktu' => 85,
                    'Keahlian' => 88,
                    'Kerjasama' => 92,
                    'Komunikasi' => 86,
                    'Teknologi' => 89,
                    'Pengembangan Diri' => 91,
                ],
                'rata2' => 89,
                'rekomendasi' => 'Ya'
            ],
            (object)[
                'nama' => 'Siti Nurhaliza',
                'posisi' => 'Finance Intern',
                'mentor' => 'Ibu Rina',
                'nilai' => [
                    'Integritas' => 75,
                    'Ketepatan Waktu' => 80,
                    'Keahlian' => 70,
                    'Kerjasama' => 82,
                    'Komunikasi' => 78,
                    'Teknologi' => 76,
                    'Pengembangan Diri' => 79,
                ],
                'rata2' => 77,
                'rekomendasi' => 'Tidak'
            ],
            (object)[
                'nama' => 'Budi Santoso',
                'posisi' => 'IT Support',
                'mentor' => 'Pak Joko',
                'nilai' => [
                    'Integritas' => 95,
                    'Ketepatan Waktu' => 93,
                    'Keahlian' => 96,
                    'Kerjasama' => 94,
                    'Komunikasi' => 92,
                    'Teknologi' => 95,
                    'Pengembangan Diri' => 97,
                ],
                'rata2' => 94,
                'rekomendasi' => 'Ya'
            ],
        ];

        $totalResponden = count($feedbacks);
        $avgKeseluruhan = round(collect($feedbacks)->avg('rata2'), 1);
        $persenRekom = round((collect($feedbacks)->where('rekomendasi', 'Ya')->count() / $totalResponden) * 100);
    @endphp

    <!-- Statistik Card -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-6">
        <div class="bg-white p-5 rounded-xl shadow-md flex items-center gap-4">
            <div class="p-3 bg-indigo-100 text-indigo-600 rounded-full"><i class="fas fa-users"></i></div>
            <div>
                <p class="text-sm text-gray-500">Total Responden</p>
                <h3 class="text-xl font-bold">{{ $totalResponden }}</h3>
            </div>
        </div>
        <div class="bg-white p-5 rounded-xl shadow-md flex items-center gap-4">
            <div class="p-3 bg-green-100 text-green-600 rounded-full"><i class="fas fa-star"></i></div>
            <div>
                <p class="text-sm text-gray-500">Rata-rata Nilai</p>
                <h3 class="text-xl font-bold">{{ $avgKeseluruhan }}</h3>
            </div>
        </div>
        <div class="bg-white p-5 rounded-xl shadow-md flex items-center gap-4">
            <div class="p-3 bg-blue-100 text-blue-600 rounded-full"><i class="fas fa-thumbs-up"></i></div>
            <div>
                <p class="text-sm text-gray-500">% Rekomendasi</p>
                <h3 class="text-xl font-bold">{{ $persenRekom }}%</h3>
            </div>
        </div>
    </div>

    <!-- Chart -->
    <div class="bg-white rounded-xl shadow-md p-6 mb-6">
        <h3 class="text-lg font-semibold mb-4">Rata-rata Nilai per Kriteria</h3>
        <canvas id="chartKriteria" height="120"></canvas>
    </div>

    <!-- Tabel Detail Feedback -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <h3 class="text-lg font-semibold mb-4">Detail Evaluasi</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-gray-700">
                <thead>
                    <tr class="bg-gray-100 border-b border-gray-200">
                        <th class="py-3 px-4 text-left">Nama</th>
                        <th class="py-3 px-4">Posisi</th>
                        <th class="py-3 px-4">Mentor</th>
                        <th class="py-3 px-4 text-center">Rata-rata</th>
                        <th class="py-3 px-4 text-center">Rekomendasi</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($feedbacks as $f)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-4 font-medium">{{ $f->nama }}</td>
                            <td class="py-3 px-4">{{ $f->posisi }}</td>
                            <td class="py-3 px-4">{{ $f->mentor }}</td>
                            <td class="py-3 px-4 text-center font-semibold text-indigo-700">{{ $f->rata2 }}</td>
                            <td class="py-3 px-4 text-center">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $f->rekomendasi === 'Ya' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $f->rekomendasi === 'Ya' ? 'Direkomendasikan' : 'Tidak Direkomendasikan' }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-center space-x-2">
                                <button onclick="openDetailModal('{{ $f->nama }}', {{ json_encode($f->nilai) }}, {{ $f->rata2 }}, '{{ $f->rekomendasi }}')" 
                                    class="text-blue-600 hover:text-blue-800" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="text-yellow-500 hover:text-yellow-700" title="Edit"><i class="fas fa-edit"></i></button>
                                <button onclick="return confirm('Yakin ingin menghapus data feedback ini?')" class="text-red-600 hover:text-red-800" title="Hapus"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Modal Detail -->
<div id="detailModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white w-full max-w-lg mx-auto p-6 rounded-xl shadow-xl relative">
        <button onclick="closeModal('detailModal')" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
            <i class="fas fa-times"></i>
        </button>
        <h3 class="text-xl font-bold mb-4">Detail Evaluasi</h3>
        <div id="detailContent" class="space-y-2"></div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Chart Kriteria (ambil rata-rata per kriteria)
    const feedbacks = @json($feedbacks);
    const kriteriaLabels = Object.keys(feedbacks[0].nilai);
    const avgValues = kriteriaLabels.map(k => {
        let total = 0, count = 0;
        feedbacks.forEach(f => { total += f.nilai[k]; count++; });
        return (total / count).toFixed(1);
    });

    new Chart(document.getElementById('chartKriteria'), {
        type: 'bar',
        data: {
            labels: kriteriaLabels,
            datasets: [{
                label: 'Rata-rata Nilai',
                data: avgValues,
                backgroundColor: '#6366F1',
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, max: 100 } }
        }
    });

    // Modal detail
    function openDetailModal(nama, nilai, rata2, rekom) {
        let html = `<p><b>Nama:</b> ${nama}</p>`;
        html += `<p><b>Rata-rata:</b> ${rata2}</p>`;
        html += `<p><b>Rekomendasi:</b> ${rekom}</p>`;
        html += `<ul class="list-disc ml-6 mt-2">`;
        for (const [k,v] of Object.entries(nilai)) {
            html += `<li>${k}: <b>${v}</b></li>`;
        }
        html += `</ul>`;
        document.getElementById("detailContent").innerHTML = html;
        document.getElementById("detailModal").classList.remove("hidden");
        document.getElementById("detailModal").classList.add("flex");
    }

    function closeModal(id) {
        document.getElementById(id).classList.add("hidden");
        document.getElementById(id).classList.remove("flex");
    }
</script>

@endsection
