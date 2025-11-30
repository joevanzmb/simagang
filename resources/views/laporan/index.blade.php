@extends('layouts.app', ['noHeader' => true])

@section('pageTitle', 'Laporan Magang')
@section('pageSubtitle', 'Rekap laporan data mahasiswa, presensi, dan penilaian')

@section('content')

<!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-center text-white p-7 rounded-2xl shadow-lg gap-6 mb-8"
        style="background: linear-gradient(135deg, #5a6de0 0%, #6c3fb0 100%);">
        <div>
            <h2 class="text-2xl font-bold flex items-center gap-5 leading-tight">
                <i class="fas fa-file-alt text-4xl"></i> Laporan Magang
            </h2>
            <p class="text-m text-white-100 mt-2">Rekap laporan data mahasiswa, presensi, dan penilaian</p>
        </div>
        <button class="px-5 py-2 bg-white/20 hover:bg-white/30 rounded-lg text-white font-medium flex items-center gap-2 transition-all duration-200 hover:scale-[1.03]">
            <i class="fas fa-download"></i> Unduh Rekap Laporan
        </button>
    </div>


<div class="max-w-7xl mx-auto">

    <!-- Filter Periode -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-6 flex flex-col sm:flex-row justify-between items-center gap-4">
        <div class="flex items-center gap-3">
            <label class="text-sm font-semibold">Pilih Periode:</label>
            <input type="month" class="border rounded-lg px-3 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500">
        </div>
        <div class="flex gap-3">
            <button class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg shadow text-sm">
                <i class="fas fa-file-pdf mr-2"></i> Export PDF
            </button>
            <button class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg shadow text-sm">
                <i class="fas fa-file-excel mr-2"></i> Export Excel
            </button>
        </div>
    </div>

    @php
        // Dummy data statistik
        $statistik = [
            'mahasiswa' => 25,
            'hadir' => 350,
            'izin' => 15,
            'alfa' => 8,
            'rataNilai' => 87
        ];

        // Dummy data laporan
        $laporans = [
            (object)[
                'nama' => 'Ahmad Fauzi',
                'nim' => '187221001',
                'kampus' => 'Universitas Airlangga',
                'hadir' => 22,
                'izin' => 1,
                'alfa' => 0,
                'nilai' => 90,
                'status' => 'Baik'
            ],
            (object)[
                'nama' => 'Siti Nurhaliza',
                'nim' => '187221002',
                'kampus' => 'ITS Surabaya',
                'hadir' => 20,
                'izin' => 2,
                'alfa' => 1,
                'nilai' => 78,
                'status' => 'Cukup'
            ],
            (object)[
                'nama' => 'Budi Santoso',
                'nim' => '187221003',
                'kampus' => 'Universitas Brawijaya',
                'hadir' => 23,
                'izin' => 0,
                'alfa' => 0,
                'nilai' => 94,
                'status' => 'Sangat Baik'
            ],
        ];
    @endphp

    <!-- Statistik Card -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-white p-5 rounded-xl shadow-md flex items-center gap-4">
            <div class="p-3 bg-indigo-100 text-indigo-600 rounded-full"><i class="fas fa-user-graduate"></i></div>
            <div>
                <p class="text-sm text-gray-500">Total Mahasiswa</p>
                <h3 class="text-xl font-bold">{{ $statistik['mahasiswa'] }}</h3>
            </div>
        </div>
        <div class="bg-white p-5 rounded-xl shadow-md flex items-center gap-4">
            <div class="p-3 bg-green-100 text-green-600 rounded-full"><i class="fas fa-check-circle"></i></div>
            <div>
                <p class="text-sm text-gray-500">Total Hadir</p>
                <h3 class="text-xl font-bold">{{ $statistik['hadir'] }}</h3>
            </div>
        </div>
        <div class="bg-white p-5 rounded-xl shadow-md flex items-center gap-4">
            <div class="p-3 bg-yellow-100 text-yellow-600 rounded-full"><i class="fas fa-exclamation-circle"></i></div>
            <div>
                <p class="text-sm text-gray-500">Total Izin</p>
                <h3 class="text-xl font-bold">{{ $statistik['izin'] }}</h3>
            </div>
        </div>
        <div class="bg-white p-5 rounded-xl shadow-md flex items-center gap-4">
            <div class="p-3 bg-red-100 text-red-600 rounded-full"><i class="fas fa-times-circle"></i></div>
            <div>
                <p class="text-sm text-gray-500">Total Alfa</p>
                <h3 class="text-xl font-bold">{{ $statistik['alfa'] }}</h3>
            </div>
        </div>
    </div>

    <!-- Grafik -->
    <div class="bg-white rounded-xl shadow-md p-6 mb-6">
        <h3 class="text-lg font-semibold mb-4">Grafik Kehadiran</h3>
        <canvas id="chartHadir" height="120"></canvas>
    </div>

    <!-- Tabel Laporan -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <h3 class="text-lg font-semibold mb-4">Tabel Rekap Laporan</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-gray-700">
                <thead>
                    <tr class="bg-gray-100 border-b border-gray-200">
                        <th class="py-3 px-4 text-left">Nama</th>
                        <th class="py-3 px-4">NIM</th>
                        <th class="py-3 px-4">Kampus</th>
                        <th class="py-3 px-4 text-center">Hadir</th>
                        <th class="py-3 px-4 text-center">Izin</th>
                        <th class="py-3 px-4 text-center">Alfa</th>
                        <th class="py-3 px-4 text-center">Nilai</th>
                        <th class="py-3 px-4">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($laporans as $l)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-4 font-medium">{{ $l->nama }}</td>
                            <td class="py-3 px-4 text-center">{{ $l->nim }}</td>
                            <td class="py-3 px-4">{{ $l->kampus }}</td>
                            <td class="py-3 px-4 text-center text-green-600 font-semibold">{{ $l->hadir }}</td>
                            <td class="py-3 px-4 text-center text-yellow-600">{{ $l->izin }}</td>
                            <td class="py-3 px-4 text-center text-red-600">{{ $l->alfa }}</td>
                            <td class="py-3 px-4 text-center font-bold text-indigo-600">{{ $l->nilai }}</td>
                            <td class="py-3 px-4">
                                @php
                                    $statusClasses = [
                                        'Sangat Baik' => 'bg-green-100 text-green-700',
                                        'Baik' => 'bg-blue-100 text-blue-700',
                                        'Cukup' => 'bg-yellow-100 text-yellow-700',
                                    ];
                                @endphp
                                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusClasses[$l->status] ?? 'bg-gray-100 text-gray-700' }}">
                                    {{ $l->status }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('chartHadir').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Ahmad Fauzi', 'Siti Nurhaliza', 'Budi Santoso'],
            datasets: [
                {
                    label: 'Hadir',
                    data: [22, 20, 23],
                    backgroundColor: '#34D399'
                },
                {
                    label: 'Izin',
                    data: [1, 2, 0],
                    backgroundColor: '#FBBF24'
                },
                {
                    label: 'Alfa',
                    data: [0, 1, 0],
                    backgroundColor: '#F87171'
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
</script>

@endsection
