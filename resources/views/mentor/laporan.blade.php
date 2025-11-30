@extends('layouts.mentor', ['noHeader' => true])

@section('pageTitle', 'Dashboard Laporan Mahasiswa')
@section('pageSubtitle', 'Pantau progres laporan, aktivitas, dan penilaian mahasiswa bimbingan.')

@section('content')
<div class="space-y-10">

  <!-- 🌈 Header -->
  <div class="flex flex-col md:flex-row justify-between items-center text-white p-7 rounded-2xl shadow-xl gap-6"
    style="background: linear-gradient(135deg, #5a6de0 0%, #6c3fb0 100%); box-shadow: 0 10px 25px rgba(0,0,0,0.15);">
    <div>
      <h2 class="text-2xl font-bold flex items-center gap-4">
        <i class="fas fa-chalkboard-teacher text-3xl"></i> Laporan Mahasiswa
      </h2>
      <p class="text-sm text-white/85 mt-1">Pantau aktivitas, laporan akhir, dan hasil presentasi mahasiswa bimbingan Anda.</p>
    </div>
    <button class="px-5 py-2 bg-white/20 hover:bg-white/30 rounded-lg text-white font-semibold flex items-center gap-2 transition-all duration-200 hover:scale-[1.05] shadow-sm">
      <i class="fas fa-sync-alt"></i> Refresh Data
    </button>
  </div>

  <!-- 📊 Statistik -->
  <div class="grid md:grid-cols-4 gap-6 max-w-6xl mx-auto">
    @php
      $stats = [
        ['icon'=>'fa-user-graduate','title'=>'Total Mahasiswa','value'=>12,'color'=>'from-indigo-500 to-purple-500'],
        ['icon'=>'fa-file-alt','title'=>'Total Laporan Harian','value'=>48,'color'=>'from-green-500 to-emerald-600'],
        ['icon'=>'fa-upload','title'=>'Laporan Akhir Diupload','value'=>9,'color'=>'from-sky-500 to-blue-600'],
        ['icon'=>'fa-star','title'=>'Rata-rata Nilai','value'=>88,'color'=>'from-yellow-400 to-amber-500'],
      ];
    @endphp

    @foreach ($stats as $s)
      <div class="bg-white/95 backdrop-blur-md p-6 rounded-2xl border border-gray-100 shadow hover:shadow-lg transition">
        <div class="flex items-center gap-4">
          <div class="p-3 rounded-xl bg-gradient-to-r {{ $s['color'] }} text-white shadow">
            <i class="fas {{ $s['icon'] }} text-2xl"></i>
          </div>
          <div>
            <p class="text-gray-500 text-sm">{{ $s['title'] }}</p>
            <h3 class="text-xl font-bold text-gray-900">{{ $s['value'] }}</h3>
          </div>
        </div>
      </div>
    @endforeach
  </div>

  <!-- 📅 Tabel Utama -->
  <div class="w-full mx-auto rounded-2xl shadow-xl p-8 bg-white backdrop-blur-lg border border-gray-100 transition hover:shadow-2xl duration-300">

    <div class="flex flex-col md:flex-row justify-between items-center mb-5 gap-4">
      <div>
        <h2 class="text-sm font-semibold text-indigo-600 uppercase tracking-wide mb-1 flex items-center gap-2">
          <i class="fas fa-user-graduate"></i> Mahasiswa Bimbingan
        </h2>
        <h3 class="text-lg font-bold text-gray-900">Monitoring Laporan & Presentasi Mahasiswa</h3>
      </div>
      <div class="flex items-center gap-3 w-full md:w-auto">
        <input type="date" id="filterTanggal" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500 w-full md:w-auto">
        <div class="relative w-full md:w-64">
          <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
          <input type="text" id="searchMahasiswa" placeholder="Cari nama mahasiswa..."
            class="pl-9 border border-gray-200 rounded-lg px-3 py-2 text-sm w-full focus:ring-indigo-500 focus:border-indigo-500">
        </div>
      </div>
    </div>

    @php
      $mahasiswas = [
        (object)['id'=>1,'nama'=>'Yusril Fadhillah','nim'=>'187221045','jurusan'=>'Perkantoran Digital','laporan_akhir'=>true,'file_laporan'=>'laporan_yusril.pdf','presentasi'=>true,'file_presentasi'=>'presentasi_yusril.pdf','status'=>'Dinilai','nilai'=>90,'disetujui'=>true],
        (object)['id'=>2,'nama'=>'Gastin Pradana','nim'=>'187221078','jurusan'=>'Sistem Informasi','laporan_akhir'=>true,'file_laporan'=>'laporan_gastin.pdf','presentasi'=>true,'file_presentasi'=>'presentasi_gastin.pdf','status'=>'Menunggu Review','nilai'=>85,'disetujui'=>false],
        (object)['id'=>3,'nama'=>'Joevanz Mikail','nim'=>'187221077','jurusan'=>'Sistem Informasi','laporan_akhir'=>false,'file_laporan'=>null,'presentasi'=>false,'file_presentasi'=>null,'status'=>'Belum Dinilai','nilai'=>null,'disetujui'=>false],
      ];
    @endphp

    <div class="overflow-x-auto">
      <table class="min-w-full text-sm text-gray-700">
        <thead class="bg-gray-50 text-gray-700 uppercase text-xs">
          <tr class="[&>th]:px-4 [&>th]:py-3 [&>th]:font-semibold text-center">
            <th>No</th>
            <th class="text-left">Nama Mahasiswa</th>
            <th>NIM</th>
            <th>Program Studi</th>
            <th>Status Magang</th> <!-- ✅ BARU -->
            <th>Laporan Akhir</th>
            <th>Presentasi</th>
            <th>Nilai</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        
        @php
          $mahasiswas = [
            (object)[
              'id'=>1,'nama'=>'Yusril Fadhillah','nim'=>'187221045','jurusan'=>'Perkantoran Digital',
              'status_magang'=>'Internship','laporan_akhir'=>true,'file_laporan'=>'laporan_yusril.pdf',
              'presentasi'=>true,'file_presentasi'=>'presentasi_yusril.pdf','status'=>'Dinilai',
              'nilai'=>90,'disetujui'=>true
            ],
            (object)[
              'id'=>2,'nama'=>'Gastin Pradana','nim'=>'187221078','jurusan'=>'Sistem Informasi',
              'status_magang'=>'PKL','laporan_akhir'=>true,'file_laporan'=>'laporan_gastin.pdf',
              'presentasi'=>true,'file_presentasi'=>'presentasi_gastin.pdf','status'=>'Menunggu Review',
              'nilai'=>85,'disetujui'=>false
            ],
            (object)[
              'id'=>3,'nama'=>'Joevanz Mikail','nim'=>'187221077','jurusan'=>'Sistem Informasi',
              'status_magang'=>'Internship','laporan_akhir'=>false,'file_laporan'=>null,
              'presentasi'=>false,'file_presentasi'=>null,'status'=>'Belum Dinilai',
              'nilai'=>null,'disetujui'=>false
            ],
          ];
        @endphp
        
        <tbody class="[&>tr>td]:px-4 [&>tr>td]:py-3 text-center">
        @foreach ($mahasiswas as $i => $mhs)
        <tr class="border-b border-gray-100 hover:bg-indigo-50/40 transition" id="row-{{ $mhs->id }}">
          <td>{{ $i + 1 }}</td>
          <td class="font-semibold text-gray-900 text-left">{{ $mhs->nama }}</td>
          <td>{{ $mhs->nim }}</td>
          <td>{{ $mhs->jurusan }}</td>
        
          <!-- ✅ Status Magang Badge -->
          <td>
            <span class="px-3 py-1 rounded-full text-xs font-semibold
              {{ $mhs->status_magang == 'Internship' ? 'bg-indigo-100 text-indigo-700' : 'bg-yellow-100 text-yellow-700' }}">
              {{ $mhs->status_magang }}
            </span>
          </td>
        
          <td>
            @if ($mhs->laporan_akhir)
              <button onclick="lihatFile('{{ $mhs->file_laporan }}')" class="text-emerald-600 hover:text-emerald-700 font-medium">
                <i class="fas fa-file-pdf text-red-500"></i> Lihat
              </button>
            @else
              <span class="px-2 py-1 text-xs bg-red-100 text-red-700 rounded-full">Belum</span>
            @endif
          </td>
        
          <td>
            @if ($mhs->presentasi)
              <button onclick="lihatFile('{{ $mhs->file_presentasi }}')" class="text-orange-500 hover:text-orange-600 font-medium">
                <i class="fas fa-file-powerpoint text-orange-500"></i> PPT
              </button>
            @else
              <span class="px-2 py-1 text-xs bg-gray-100 text-gray-700 rounded-full">Belum</span>
            @endif
          </td>
        
          <td>{{ $mhs->nilai ?? '-' }}</td>
        
          <td>
            @if ($mhs->status === 'Dinilai')
              <span class="px-2 py-1 text-xs bg-blue-100 text-blue-700 rounded-full">Dinilai</span>
            @elseif ($mhs->status === 'Menunggu Review')
              <span class="px-2 py-1 text-xs bg-amber-100 text-amber-700 rounded-full">Review</span>
            @else
              <span class="px-2 py-1 text-xs bg-gray-100 text-gray-700 rounded-full">Belum</span>
            @endif
          </td>
        
          <td>
            <div class="flex flex-col items-center gap-2">
              <button onclick="beriNilai('{{ $mhs->nama }}')" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-semibold bg-purple-600 text-white hover:bg-purple-700 hover:scale-[1.04] transition">
                <i class="fas fa-star text-[11px]"></i> Nilai
              </button>
        
              <button id="btnPersetujuan-{{ $mhs->id }}"
                onclick="bukaPersetujuan('{{ $mhs->id }}','{{ $mhs->nama }}')"
                class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-semibold
                {{ $mhs->disetujui ? 'bg-green-500 hover:bg-green-600' : 'bg-orange-500 hover:bg-orange-600' }}
                text-white hover:scale-[1.04] transition">
                <i class="fas {{ $mhs->disetujui ? 'fa-edit' : 'fa-check-circle' }} text-[11px]"></i>
                {{ $mhs->disetujui ? 'Edit Presentasi' : 'Presentasi' }}
              </button>
            </div>
          </td>
        </tr>
        
        @if ($mhs->disetujui)
        <tr id="approval-{{ $mhs->id }}">
          <td colspan="10" class="bg-green-50 text-left px-8 py-3 text-sm text-green-700 border-t border-green-200">
            ✅ Presentasi disetujui untuk <strong>{{ $mhs->nama }}</strong>.
          </td>
        </tr>
        @endif
        
        @endforeach
        </tbody>

      </table>
    </div>
  </div>
</div>

<!-- 🟩 Modal Presentasi -->
<div id="modalPersetujuan" class="fixed inset-0 flex items-center justify-center bg-black/50 hidden z-50 backdrop-blur-sm">
  <div id="modalPersetujuanBox" class="bg-white rounded-2xl shadow-2xl max-w-md w-full overflow-hidden transform scale-95 opacity-0 transition-all duration-300">
    <div class="bg-gradient-to-r from-green-500 to-emerald-600 text-white p-4 flex justify-between items-center">
      <h3 id="modalTitle" class="text-lg font-semibold flex items-center gap-2"><i class="fas fa-check-circle"></i> Konfirmasi Presentasi</h3>
      <button onclick="tutupPersetujuan()" class="hover:text-gray-200"><i class="fas fa-times"></i></button>
    </div>
    <div class="p-6 space-y-4">
      <p id="namaPersetujuan" class="text-gray-800 font-medium"></p>
      <label class="flex items-start gap-2 text-sm text-gray-700">
        <input type="checkbox" id="checkPersetujuan" class="mt-1 w-4 h-4 accent-green-600">
        <span id="textPersetujuan">Saya selaku mentor telah menyetujui bahwa mahasiswa ini telah melaksanakan <strong>presentasi laporan magang</strong>.</span>
      </label>
      <div class="text-right">
        <button onclick="konfirmasiPersetujuan()" class="px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-lg shadow hover:scale-[1.04] transition">
          <i class="fas fa-paper-plane mr-2"></i> Konfirmasi
        </button>
      </div>
    </div>
  </div>
</div>

<!-- 🔔 Toast -->
<div id="toast" class="hidden fixed bottom-6 right-6 bg-gray-900 text-white px-4 py-3 rounded-lg shadow-lg text-sm"></div>

<script>
let currentID = null;
let isEdit = false;

// ✅ Handler tombol "Nilai"
function beriNilai(nama) {
  showToast("✅ Form penilaian akan dibuka untuk: " + nama);

  // Jika nantinya mau redirect ke halaman penilaian:
  // window.location.href = `/mentor/penilaian/${nama}`;
  
  // Atau jika mau buka modal penilaian:
  // openPenilaian();
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


// === Modal Presentasi
function bukaPersetujuan(id, nama){
  currentID = id;
  const approval = document.getElementById('approval-'+id);
  isEdit = approval !== null; // kalau sudah ada berarti edit
  document.getElementById('modalTitle').innerHTML = isEdit ? 
    '<i class="fas fa-edit"></i> Edit Presentasi' : 
    '<i class="fas fa-check-circle"></i> Konfirmasi Presentasi';
  document.getElementById('textPersetujuan').innerHTML = isEdit ? 
    'Batalkan persetujuan bahwa mahasiswa ini telah melaksanakan <strong>presentasi laporan magang</strong>.' : 
    'Saya selaku mentor telah menyetujui bahwa mahasiswa ini telah melaksanakan <strong>presentasi laporan magang</strong>.';
  document.getElementById('checkPersetujuan').checked = false;
  document.getElementById('namaPersetujuan').textContent = 'Mahasiswa: ' + nama;
  toggleModal('modalPersetujuan','modalPersetujuanBox');
}

function konfirmasiPersetujuan(){
  const cb = document.getElementById('checkPersetujuan');
  if(!cb.checked) return showToast('⚠️ Silakan centang konfirmasi terlebih dahulu.');

  const tr = document.getElementById('row-' + currentID);
  const nama = tr.querySelector('td:nth-child(2)').textContent;
  const approvalRow = document.getElementById('approval-' + currentID);
  const btn = document.getElementById('btnPersetujuan-' + currentID);

  if (isEdit) {
    if (approvalRow) approvalRow.remove();
    btn.innerHTML = '<i class="fas fa-check-circle text-[11px]"></i> Presentasi';
    btn.className = 'inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-semibold bg-orange-500 text-white hover:bg-orange-600 hover:scale-[1.04] transition';
    showToast('⚠️ Persetujuan presentasi dibatalkan.');
  } else {
    const newRow = document.createElement('tr');
    newRow.id = 'approval-' + currentID;
    newRow.innerHTML = `<td colspan="9" class="bg-green-50 text-left px-8 py-3 text-sm text-green-700 border-t border-green-200">
      ✅ Saya selaku mentor telah menyetujui bahwa <strong>${nama}</strong> telah melaksanakan <strong>presentasi laporan magang</strong>.
    </td>`;
    tr.insertAdjacentElement('afterend', newRow);
    btn.innerHTML = '<i class="fas fa-edit text-[11px]"></i> Edit Presentasi';
    btn.className = 'inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-semibold bg-green-500 text-white hover:bg-green-600 hover:scale-[1.04] transition';
    showToast('✅ Presentasi disetujui!');
  }

  tutupPersetujuan();
}

function tutupPersetujuan(){ closeModal('modalPersetujuan','modalPersetujuanBox'); }

// === Modal Utility
function toggleModal(id,box){const m=document.getElementById(id),b=document.getElementById(box);m.classList.remove('hidden');setTimeout(()=>{b.classList.remove('scale-95','opacity-0');b.classList.add('scale-100','opacity-100');},50);}
function closeModal(id,box){const m=document.getElementById(id),b=document.getElementById(box);b.classList.add('scale-95','opacity-0');setTimeout(()=>m.classList.add('hidden'),180);}

// === Toast
function showToast(msg){const t=document.getElementById('toast');t.textContent=msg;t.classList.remove('hidden');setTimeout(()=>t.classList.add('hidden'),2400);}
</script>

<style>
@keyframes fadeIn{from{opacity:0;transform:translateY(10px);}to{opacity:1;transform:translateY(0);}}
.animate-fadeIn{animation:fadeIn .5s ease-out;}
</style>
@endsection
