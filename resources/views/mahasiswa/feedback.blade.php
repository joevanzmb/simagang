@extends('layouts.app', ['noHeader' => true])

@section('pageTitle', 'Feedback & Evaluasi Magang')
@section('pageSubtitle', 'Rekap hasil evaluasi dan masukan mahasiswa terhadap program magang PT Pertamina Lubricants')

@section('content')

<!-- Header -->
<div class="flex flex-col md:flex-row justify-between items-center text-white p-7 rounded-2xl shadow-lg gap-6 mb-8"
     style="background: linear-gradient(135deg,#5a6de0 0%,#6c3fb0 100%);">
  <div>
    <h2 class="text-2xl font-bold flex items-center gap-5 leading-tight">
      <i class="fas fa-graduation-cap text-4xl"></i> Feedback & Evaluasi Magang
    </h2>
    <p class="text-m text-white/90 mt-2">Rekap keseluruhan penilaian, saran, dan masukan mahasiswa</p>
  </div>
  <button class="px-5 py-2 bg-white/20 hover:bg-white/30 rounded-lg text-white font-medium flex items-center gap-2 transition-all duration-200 hover:scale-[1.03]">
    <i class="fas fa-download"></i> Download Laporan
  </button>
</div>

<div class="max-w-7xl mx-auto">

  @php
    $feedbacks = [
        (object)[
            'nama' => 'Ahmad Fauzi',
            'posisi' => 'Web Developer',
            'mentor' => 'Bapak Andi',
            'penilaian' => [
                'Kepuasan terhadap pengalaman magang' => 4,
                'Kesesuaian kegiatan magang dengan bidang studi' => 3,
                'Kenyamanan lingkungan kerja' => 4,
                'Penilaian terhadap pembimbing lapangan' => 4,
                'Kejelasan arahan dan evaluasi dari pembimbing' => 3,
                'Hubungan dengan karyawan/tim' => 4,
                'Penilaian keseluruhan pengalaman magang' => 4
            ],
            'hal_disukai' => 'Kebersamaan tim dan lingkungan kerja yang positif.',
            'tantangan' => 'Adaptasi awal terhadap sistem kerja baru.',
            'saran' => 'Program orientasi bisa diperpanjang agar lebih mengenal divisi.',
        ],
        (object)[
            'nama' => 'Siti Nurhaliza',
            'posisi' => 'Finance Intern',
            'mentor' => 'Ibu Rina',
            'penilaian' => [
                'Kepuasan terhadap pengalaman magang' => 3,
                'Kesesuaian kegiatan magang dengan bidang studi' => 3,
                'Kenyamanan lingkungan kerja' => 3,
                'Penilaian terhadap pembimbing lapangan' => 3,
                'Kejelasan arahan dan evaluasi dari pembimbing' => 2,
                'Hubungan dengan karyawan/tim' => 3,
                'Penilaian keseluruhan pengalaman magang' => 3
            ],
            'hal_disukai' => 'Kesempatan belajar banyak tentang laporan keuangan.',
            'tantangan' => 'Waktu kerja yang cukup padat.',
            'saran' => 'Perlu lebih banyak mentoring langsung dari pembimbing.',
        ],
        (object)[
            'nama' => 'Budi Santoso',
            'posisi' => 'IT Support',
            'mentor' => 'Pak Joko',
            'penilaian' => [
                'Kepuasan terhadap pengalaman magang' => 4,
                'Kesesuaian kegiatan magang dengan bidang studi' => 4,
                'Kenyamanan lingkungan kerja' => 4,
                'Penilaian terhadap pembimbing lapangan' => 4,
                'Kejelasan arahan dan evaluasi dari pembimbing' => 4,
                'Hubungan dengan karyawan/tim' => 4,
                'Penilaian keseluruhan pengalaman magang' => 4
            ],
            'hal_disukai' => 'Bimbingan mentor yang sangat jelas dan terstruktur.',
            'tantangan' => 'Mengatur waktu antara tugas kuliah dan magang.',
            'saran' => 'Program magang bisa ditambah sesi sharing antar peserta.',
        ],
    ];

    $totalResponden = count($feedbacks);
    $avgKeseluruhan = round(collect($feedbacks)->map(fn($f) => collect($f->penilaian)->avg())->avg(), 2);
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
        <p class="text-sm text-gray-500">Rata-rata Penilaian</p>
        <h3 class="text-xl font-bold">{{ $avgKeseluruhan }}</h3>
      </div>
    </div>
    <div class="bg-white p-5 rounded-xl shadow-md flex items-center gap-4">
      <div class="p-3 bg-yellow-100 text-yellow-600 rounded-full"><i class="fas fa-comments"></i></div>
      <div>
        <p class="text-sm text-gray-500">Aspek Dinilai</p>
        <h3 class="text-xl font-bold">7 Aspek</h3>
      </div>
    </div>
  </div>

  <!-- Chart -->
  <div class="bg-white rounded-xl shadow-md p-6 mb-6">
    <h3 class="text-lg font-semibold mb-4">Rata-rata Nilai per Aspek</h3>
    <canvas id="chartKriteria" height="120"></canvas>
  </div>

  <!-- Tabel Evaluasi -->
  <div class="bg-white rounded-xl shadow-md p-6 mb-8">
    <h3 class="text-lg font-semibold mb-4">Detail Penilaian Mahasiswa</h3>
    <div class="overflow-x-auto">
      <table class="min-w-full text-sm text-gray-700">
        <thead>
          <tr class="bg-gray-100 border-b border-gray-200">
            <th class="py-3 px-4 text-left">Nama</th>
            <th class="py-3 px-4">Posisi</th>
            <th class="py-3 px-4">Mentor</th>
            <th class="py-3 px-4 text-center">Rata-rata</th>
            <th class="py-3 px-4 text-center">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($feedbacks as $f)
          <tr class="border-b hover:bg-gray-50">
            <td class="py-3 px-4 font-medium">{{ $f->nama }}</td>
            <td class="py-3 px-4">{{ $f->posisi }}</td>
            <td class="py-3 px-4">{{ $f->mentor }}</td>
            <td class="py-3 px-4 text-center font-semibold text-indigo-700">
              {{ round(collect($f->penilaian)->avg(), 2) }}
            </td>
            <td class="py-3 px-4 text-center space-x-2">
              <button onclick="openDetailModal(@json($f))" class="text-blue-600 hover:text-blue-800" title="Detail">
                <i class="fas fa-eye"></i>
              </button>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  <!-- Masukan & Saran -->
  <div class="bg-white rounded-xl shadow-md p-6 mb-6">
    <h3 class="text-lg font-semibold mb-4">Masukan dan Saran Mahasiswa</h3>
    <div class="space-y-4">
      @foreach ($feedbacks as $f)
      <div class="border border-gray-200 rounded-lg p-4 hover:shadow-sm transition-all">
        <h4 class="font-semibold text-gray-800 mb-1">{{ $f->nama }} <span class="text-sm text-gray-500">({{ $f->posisi }})</span></h4>
        <p class="text-sm text-gray-600"><b>Hal disukai:</b> {{ $f->hal_disukai }}</p>
        <p class="text-sm text-gray-600"><b>Tantangan:</b> {{ $f->tantangan }}</p>
        <p class="text-sm text-gray-600"><b>Saran:</b> {{ $f->saran }}</p>
      </div>
      @endforeach
    </div>
  </div>

</div>

<!-- Modal Detail -->
<div id="detailModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
  <div class="bg-white w-full max-w-lg mx-auto p-6 rounded-xl shadow-xl relative">
    <button onclick="closeModal('detailModal')" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
      <i class="fas fa-times"></i>
    </button>
    <h3 class="text-xl font-bold mb-4">Detail Penilaian</h3>
    <div id="detailContent" class="space-y-2"></div>
  </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const feedbacks = @json($feedbacks);
  const aspekLabels = Object.keys(feedbacks[0].penilaian);
  const avgValues = aspekLabels.map(aspek => {
    let total = 0, count = 0;
    feedbacks.forEach(f => { total += f.penilaian[aspek]; count++; });
    return (total / count).toFixed(2);
  });

  new Chart(document.getElementById('chartKriteria'), {
    type: 'bar',
    data: {
      labels: aspekLabels,
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
      scales: { y: { beginAtZero: true, max: 5 } }
    }
  });

  function openDetailModal(data) {
    let html = `<p><b>Nama:</b> ${data.nama}</p>`;
    html += `<p><b>Posisi:</b> ${data.posisi}</p>`;
    html += `<p><b>Mentor:</b> ${data.mentor}</p>`;
    html += `<hr class='my-2'>`;
    html += `<ul class="list-disc ml-6 mt-2 text-sm">`;
    for (const [k, v] of Object.entries(data.penilaian)) {
      const text = ["Kurang","Cukup","Baik","Sangat Baik"][v-1];
      html += `<li>${k}: <b>${text}</b></li>`;
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
