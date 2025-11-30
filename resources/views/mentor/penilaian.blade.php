@extends('layouts.mentor', ['noHeader' => true])

@section('pageTitle', 'Penilaian Mahasiswa')
@section('pageSubtitle', 'Evaluasi performa mahasiswa bimbingan secara interaktif dan mudah.')

@section('content')
<div class="space-y-10">

    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-center text-white p-7 rounded-2xl shadow-lg"
        style="background: linear-gradient(135deg, #5a6de0 0%, #6c3fb0 100%);">
        <div>
            <h2 class="text-2xl font-bold flex items-center gap-4 leading-tight">
                <i class="fas fa-star text-3xl"></i> Penilaian Mahasiswa
            </h2>
            <p class="text-m text-white/80 mt-1">Isi, kelola, dan pantau hasil penilaian mahasiswa bimbingan.</p>
        </div>
        <button onclick="openPenilaian()" 
            class="px-5 py-2 bg-white/20 hover:bg-white/30 rounded-lg text-white font-medium flex items-center gap-2 transition-all duration-200 hover:scale-[1.03]">
            <i class="fas fa-plus"></i> Tambah Penilaian
        </button>
    </div>

    <!-- Grafik Section -->
    <div class="grid md:grid-cols-2 gap-6">
        <!-- Grafik Rata-rata Nilai -->
        <div class="bg-white rounded-2xl shadow-lg p-6 flex flex-col justify-between h-[360px]">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-chart-line"></i> Rata-Rata Nilai Per Kriteria
            </h3>
            <div class="flex-1">
                <canvas id="grafikRataRata" class="w-full h-full"></canvas>
            </div>
        </div>

        <!-- Grafik Status Penilaian -->
        <div class="bg-white rounded-2xl shadow-lg p-6 flex flex-col justify-between h-[360px]">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-chart-pie"></i> Status Penilaian Mahasiswa
            </h3>
            <div class="flex-1">
                <canvas id="grafikStatus" class="w-full h-full"></canvas>
            </div>
        </div>
    </div>

    <style>
    #grafikRataRata, #grafikStatus { max-height: 260px !important; }
    </style>

    <!-- Filter & Tabel -->
    <div class="bg-white rounded-2xl shadow-lg p-6">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-5">
            <div class="flex flex-wrap gap-4">
                <!-- Filter Keterangan -->
                <div>
                    <label class="block text-sm font-medium text-gray-600">Keterangan Nilai</label>
                    <select id="filterKeterangan" class="border border-gray-300 rounded-lg p-2 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="Semua">Semua</option>
                        <option value="Sangat Memuaskan">Sangat Memuaskan</option>
                        <option value="Memuaskan">Memuaskan</option>
                        <option value="Cukup Memuaskan">Cukup Memuaskan</option>
                    </select>
                </div>

                <!-- Filter Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-600">Status Penilaian</label>
                    <select id="filterStatus" class="border border-gray-300 rounded-lg p-2 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="Semua">Semua</option>
                        <option value="Sudah Dinilai">Sudah Dinilai</option>
                        <option value="Belum Dinilai">Belum Dinilai</option>
                    </select>
                </div>
            </div>

            <div class="relative w-full md:w-1/3">
                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                <input type="text" id="searchInput" placeholder="Cari nama mahasiswa..."
                    class="pl-9 w-full border border-gray-300 rounded-lg p-2 text-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>
        </div>

        <!-- Tabel -->
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-gray-700 border border-gray-200 rounded-xl overflow-hidden">
                <thead class="bg-gray-100 text-gray-800">
                    <tr>
                        <th class="px-4 py-2 text-left font-semibold">Nama</th>
                        <th class="px-4 py-2 text-left font-semibold">Kampus</th>
                        <th class="px-4 py-2 text-center font-semibold">Status Magang</th> <!-- ✅ BARU -->
                        <th class="px-4 py-2 text-center font-semibold">Status Penilaian</th>
                        <th class="px-4 py-2 text-center font-semibold">Nilai Akhir</th>
                        <th class="px-4 py-2 text-center font-semibold">Keterangan</th>
                        <th class="px-4 py-2 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>
                
                @php
                    $students = [
                        ['Joevanz Mikail','Universitas Airlangga','Internship','Sudah Dinilai','90','Sangat Memuaskan'],
                        ['Siti Nurhaliza','ITS','PKL','Sudah Dinilai','92','Sangat Memuaskan'],
                        ['Alya Rahma','Universitas Brawijaya','Internship','Belum Dinilai','-','-'],
                        ['Bagus Setiawan','PENS','Internship','Sudah Dinilai','88','Sangat Memuaskan'],
                        ['Rizky Hidayat','UNESA','PKL','Belum Dinilai','-','-'],
                        ['Tasya Amanda','Universitas Airlangga','Internship','Sudah Dinilai','75','Memuaskan'],
                        ['Fajar Nugraha','ITS','Internship','Sudah Dinilai','94','Sangat Memuaskan'],
                        ['Putri Lestari','UPN Veteran Jatim','PKL','Belum Dinilai','-','-'],
                        ['Andi Saputra','Universitas Brawijaya','PKL','Sudah Dinilai','68','Cukup Memuaskan']
                    ];
                @endphp
                
                <tbody id="studentTableBody">
                    @foreach ($students as $s)
                        <tr class="border-b hover:bg-indigo-50 transition">
                            <td class="px-4 py-2 font-medium flex items-center gap-3">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($s[0]) }}&background=6366f1&color=fff"
                                     class="w-8 h-8 rounded-full shadow-sm" alt="avatar">
                                {{ $s[0] }}
                            </td>
                
                            <td class="px-4 py-2">{{ $s[1] }}</td>
                
                            <!-- ✅ Badge Status Magang -->
                            <td class="px-4 py-2 text-center">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    {{ $s[2] == 'Internship' ? 'bg-indigo-100 text-indigo-700' : 'bg-yellow-100 text-yellow-700' }}">
                                    {{ $s[2] }}
                                </span>
                            </td>
                
                            <!-- Status Penilaian -->
                            <td class="px-4 py-2 text-center">
                                @if($s[3]=='Sudah Dinilai')
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">{{ $s[3] }}</span>
                                @else
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">{{ $s[3] }}</span>
                                @endif
                            </td>
                
                            <!-- Nilai -->
                            <td class="px-4 py-2 text-center font-semibold text-indigo-600">{{ $s[4] }}</td>
                
                            <!-- Keterangan Nilai -->
                            <td class="px-4 py-2 text-center">
                                @php
                                    $color = match($s[5]) {
                                        'Sangat Memuaskan' => 'bg-green-100 text-green-700',
                                        'Memuaskan' => 'bg-blue-100 text-blue-700',
                                        'Cukup Memuaskan' => 'bg-yellow-100 text-yellow-700',
                                        default => 'bg-gray-100 text-gray-500'
                                    };
                                @endphp
                                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $color }}">{{ $s[5] }}</span>
                            </td>
                
                            <!-- Aksi -->
                            <td class="px-4 py-2 text-center space-x-2">
                                @if($s[3]=='Belum Dinilai')
                                    <button onclick="openPenilaian()" 
                                            class="px-3 py-1 text-xs rounded-lg bg-indigo-500 text-white hover:bg-indigo-600 transition">
                                        <i class="fas fa-pen mr-1"></i> Nilai
                                    </button>
                                @else
                                    <button onclick="openEditPenilaian('{{ $s[0] }}')" 
                                            class="px-3 py-1 text-xs rounded-lg bg-amber-500 text-white hover:bg-amber-600 transition">
                                        <i class="fas fa-edit mr-1"></i> Edit
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
</div>

<!-- Modal Penilaian -->
<div id="penilaianModal"
  class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm items-center justify-center z-[9999]">

  <div class="bg-white rounded-3xl shadow-2xl w-full max-w-3xl relative animate-fade-in overflow-hidden">


    <!-- Header -->
    <div class="bg-gradient-to-r from-indigo-500 via-purple-600 to-pink-500 
                text-white px-8 py-6 rounded-t-3xl shadow-lg flex items-center justify-between">

      <!-- Kiri: Ikon + Judul -->
      <div class="flex items-center gap-5">
        <div class="relative flex items-center justify-center w-12 h-12 rounded-2xl bg-white/20 
                    border border-white/30 shadow-inner backdrop-blur-md">
          <i class="fas fa-clipboard-check text-white text-2xl drop-shadow-md"></i>
          <div class="absolute inset-0 rounded-2xl ring-1 ring-white/20"></div>
        </div>
        <div>
          <h3 class="text-2xl font-bold leading-tight drop-shadow-sm">
            Form Penilaian Mahasiswa
          </h3>
          <p class="text-sm text-white/80 mt-1">
            Evaluasi performa mahasiswa secara menyeluruh dan objektif
          </p>
        </div>
      </div>

      <!-- Kanan: Tombol Close -->
      <button onclick="closePenilaian()"
              class="bg-white/20 hover:bg-white/30 transition-all duration-200 
                    p-2.5 rounded-full text-white shadow-md hover:scale-105">
          <i class="fas fa-times text-lg"></i>
      </button>
    </div>


    <!-- Isi Form -->
    <div class="p-8 overflow-y-auto max-h-[80vh]">
      <form id="penilaianForm" class="space-y-6">
        <!-- Nama Mahasiswa -->
        <div class="relative">
          <label class="block font-semibold text-gray-700 mb-1">Nama Mahasiswa</label>
          <input type="text" id="namaMahasiswa" placeholder="Ketik nama mahasiswa..."
            oninput="autoSearch(this.value)"
            class="w-full border rounded-xl p-3 text-sm focus:ring-indigo-500 focus:border-indigo-500 transition shadow-sm">
          <ul id="namaSuggestions"
              class="absolute left-0 right-0 mt-1 hidden border border-gray-200 rounded-lg bg-white shadow-lg z-50"></ul>
        </div>

        <!-- Grid Penilaian -->
        <div class="grid sm:grid-cols-1 md:grid-cols-2 gap-5">
          @php
              $criteria = [
                  'Integritas (Etika, moral, dan kesungguhan)',
                  'Ketepatan waktu dalam bekerja',
                  'Keahlian berdasarkan bidang ilmu',
                  'Kerjasama dalam tim',
                  'Komunikasi',
                  'Penggunaan teknologi informasi',
                  'Pengembangan diri'
              ];
          @endphp

          @foreach ($criteria as $title)
          <div class="border rounded-xl p-4 hover:shadow-md transition-all duration-300 bg-gray-50/70">
            <label class="block font-semibold text-gray-800 mb-2">{{ $loop->iteration }}. {{ $title }}</label>
            <input type="number" min="0" max="100" placeholder="Nilai 0–100"
              oninput="updateBar(this)"
              class="w-full border rounded-lg p-2 text-sm focus:ring-indigo-500 focus:border-indigo-500 transition">
            <div class="w-full bg-gray-200 h-1 mt-2 rounded-full overflow-hidden">
              <div class="h-1 bg-gradient-to-r from-indigo-500 to-purple-500 w-0 transition-all duration-500"></div>
            </div>
          </div>
          @endforeach
        </div>

        <!-- Penilaian Keseluruhan -->
        <div>
          <label class="block font-semibold text-gray-700 mb-1">Penilaian Keseluruhan</label>
          <select class="w-full border rounded-xl p-3 text-sm focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">
            <option value="">Pilih...</option>
            <option value="Rekomendasi">Direkomendasikan</option>
            <option value="Tidak">Tidak direkomendasikan</option>
          </select>
        </div>

        <!-- Catatan / Feedback -->
        <div>
          <label class="block font-semibold text-gray-700 mb-1">Catatan / Feedback</label>
          <textarea rows="4" placeholder="Tuliskan kesan, saran, atau catatan..."
            class="w-full border rounded-xl p-3 text-sm focus:ring-indigo-500 focus:border-indigo-500 shadow-sm"></textarea>
        </div>

        <!-- Tombol Aksi -->
        <div class="flex justify-end pt-5 border-t mt-8">
          <button type="button" onclick="closePenilaian()"
            class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg shadow-sm mr-3 transition">
            Batal
          </button>
          <button type="submit"
            class="px-6 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white rounded-lg shadow-md transition flex items-center gap-2">
            <i class="fas fa-save"></i> Simpan Penilaian
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Animasi & Utility -->
<style>
@keyframes fadeIn { from { opacity: 0; transform: translateY(10px);} to { opacity: 1; transform: translateY(0);} }
.animate-fade-in { animation: fadeIn 0.35s ease-out; }

/* Paksa modal overlay menutupi viewport penuh & di atas semua layer */
#penilaianModal {
  position: fixed !important;
  inset: 0 !important;
  top: 0 !important; left: 0 !important; right: 0 !important; bottom: 0 !important;
  z-index: 9999 !important;
  backdrop-filter: blur(8px);
  -webkit-backdrop-filter: blur(8px);
}

/* Fokus input lebih terlihat */
input:focus, select:focus, textarea:focus { box-shadow: 0 0 0 3px rgba(99,102,241,0.25); }

/* Kanvas chart stabil di semua browser */
canvas { width: 100% !important; height: 100% !important; }

/* Viewport pendek */
@media (max-height: 700px){ #penilaianForm { max-height: 65vh; overflow-y: auto; } }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// ======= STATE =======
const namaList = ["Joevanz Mikail","Siti Nurhaliza","Alya Rahma","Bagus Setiawan","Rizky Hidayat","Tasya Amanda","Fajar Nugraha","Putri Lestari","Andi Saputra"];

// ======= MODAL CONTROL (fix overlay tidak penuh & kompatibel parent transform) =======
function ensureModalInBody() {
  const modal = document.getElementById('penilaianModal');
  if (!modal.dataset.movedToBody) {
    document.body.appendChild(modal);           // pindahkan ke <body> agar tidak terpotong parent
    modal.dataset.movedToBody = '1';
  }
}

function openPenilaian(){
  ensureModalInBody();
  const modal = document.getElementById('penilaianModal');
  modal.classList.remove('hidden');
  modal.classList.add('flex');                  // pastikan flex aktif
  document.body.style.overflow = 'hidden';      // kunci scroll body
}

function closePenilaian(){
  const modal = document.getElementById('penilaianModal');
  modal.classList.remove('flex');
  modal.classList.add('hidden');
  document.body.style.overflow = '';            // kembalikan scroll
}

// klik area overlay utk close
document.addEventListener('click', (e) => {
  const modal = document.getElementById('penilaianModal');
  if (!modal.classList.contains('hidden') && e.target === modal) {
    closePenilaian();
  }
});

function openEditPenilaian(name){
  openPenilaian();
  document.getElementById('namaMahasiswa').value = name;
}

// ======= AUTOCOMPLETE NAMA =======
function autoSearch(value){
  const suggestionBox = document.getElementById('namaSuggestions');
  suggestionBox.innerHTML = '';
  if(!value.trim()){ suggestionBox.classList.add('hidden'); return; }
  const results = namaList.filter(n => n.toLowerCase().includes(value.toLowerCase()));
  results.forEach(n=>{
      const li=document.createElement('li');
      li.textContent=n;
      li.className='px-3 py-2 text-sm hover:bg-gray-100 cursor-pointer';
      li.onclick=()=>{ document.getElementById('namaMahasiswa').value=n; suggestionBox.classList.add('hidden'); };
      suggestionBox.appendChild(li);
  });
  suggestionBox.classList.toggle('hidden', results.length===0);
}

// ======= INPUT NILAI: PROGRESS BAR =======
function updateBar(input){
  const bar = input.nextElementSibling.firstElementChild;
  const val = Math.min(Math.max(parseInt(input.value)||0,0),100);
  bar.style.width = `${val}%`;
  bar.className = `h-1 rounded-full transition-all duration-500 ${
      val < 70 ? 'bg-red-500' : val < 86 ? 'bg-yellow-400' : 'bg-green-500'
  }`;
}

// ======= CHARTS =======
new Chart(document.getElementById('grafikRataRata'), {
  type: 'bar',
  data: {
    labels: ['Integritas','Ketepatan waktu','Keahlian','Kerjasama','Komunikasi','Teknologi','Pengembangan'],
    datasets: [{ data: [90,85,87,83,88,86,84], backgroundColor: '#6366f1', borderRadius: 6 }]
  },
  options: { maintainAspectRatio: false, scales:{ y:{ beginAtZero:true, max:100 } }, plugins:{ legend:{ display:false } } }
});

new Chart(document.getElementById('grafikStatus'), {
  type: 'doughnut',
  data: {
    labels: ['Sudah Dinilai','Belum Dinilai'],
    datasets: [{ data: [7,3], backgroundColor: ['#22c55e','#facc15'], borderWidth: 3 }]
  },
  options: { maintainAspectRatio: false, cutout: '65%', plugins:{ legend:{ position:'bottom' } } }
});

// ======= FILTERING TABEL =======
document.getElementById('filterKeterangan').addEventListener('change', applyFilters);
document.getElementById('filterStatus').addEventListener('change', applyFilters);
document.getElementById('searchInput').addEventListener('input', applyFilters);

function applyFilters() {
  const keterangan = document.getElementById('filterKeterangan').value;
  const status = document.getElementById('filterStatus').value;
  const search = document.getElementById('searchInput').value.toLowerCase();
  const rows = document.querySelectorAll('#studentTableBody tr');

  rows.forEach(row => {
    const nama = row.children[0].innerText.toLowerCase();
    const statusText = row.children[2].innerText.trim();
    const keteranganText = row.children[4].innerText.trim();

    const matchSearch = nama.includes(search);
    const matchStatus = status === 'Semua' || statusText === status;
    const matchKeterangan = keterangan === 'Semua' || keteranganText === keterangan;

    row.style.display = matchSearch && matchStatus && matchKeterangan ? '' : 'none';
  });
}
</script>
@endsection
