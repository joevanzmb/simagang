@extends('layouts.mahasiswa', ['noHeader' => true])

@section('pageTitle', 'Profil Mahasiswa')
@section('pageSubtitle', 'Lengkapi data diri, informasi magang, dan unggah berkasmu.')

@section('content')

<!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-center text-white p-7 rounded-2xl shadow-lg gap-6 mb-8"
        style="background: linear-gradient(135deg, #5a6de0 0%, #6c3fb0 100%);">
        <div>
            <h2 class="text-2xl font-bold flex items-center gap-5 leading-tight">
                <i class="fas fa-user-graduate text-4xl"></i> Profil Mahasiswa
            </h2>
            <p class="text-m text-white-100 mt-2">Lengkapi data diri, informasi magang, dan unggah berkasmu</p>
        </div>

    </div>

<div class="max-w-6xl mx-auto bg-white rounded-2xl shadow-xl p-8 border border-gray-100 space-y-12">

    <!-- ================== FOTO PROFIL ================== -->
    <div class="flex flex-col items-center text-center">
        <div class="relative group">
            @if(isset($mahasiswa) && $mahasiswa->foto)
                <!-- Jika sudah upload foto -->
                <img 
                    src="{{ asset('storage/'.$mahasiswa->foto) }}"
                    class="w-32 h-32 rounded-full border-4 border-indigo-100 shadow-md object-cover transition duration-300 group-hover:brightness-90" 
                    alt="Foto Profil">
            @else
                <!-- Avatar Default: Ikon Orang -->
                <div class="w-32 h-32 rounded-full border-4 border-indigo-100 shadow-md bg-gray-200 flex items-center justify-center">
                    <i class="fas fa-user text-gray-400 text-5xl"></i>
                </div>
            @endif

            <!-- Tombol Kamera -->
            <label for="foto" 
                class="absolute bottom-0 right-0 bg-indigo-600 hover:bg-indigo-700 text-white w-10 h-10 flex items-center justify-center rounded-full cursor-pointer shadow-md transition-all duration-200 hover:scale-110">
                <i class="fas fa-camera text-sm"></i>
                <input type="file" name="foto" id="foto" class="hidden" accept="image/*">
            </label>

        </div>
        <p class="text-sm text-gray-500 mt-3">Klik ikon kamera untuk mengganti foto</p>
    </div>

    <!-- ================== FORM ================== -->
    <form action="#" method="POST" enctype="multipart/form-data" class="space-y-12">
        @csrf

        <!-- ========== 1. DATA DIRI ========== -->
        <!-- ========== 1. DATA DIRI ========== -->
        <section id="data-diri">
            <h3 class="text-lg font-semibold text-indigo-700 mb-6 flex items-center">
                <i class="fas fa-id-card-alt mr-2"></i> Data Diri
            </h3>
        
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @php
                    $personalFields = [
                        ['nama', 'Nama Lengkap', 'Masukkan nama lengkap', 'user'],
                        ['jenis_kelamin', 'Jenis Kelamin', '', 'venus-mars'],
                        ['tgl_lahir', 'Tanggal Lahir', '', 'calendar'],
                        ['kontak', 'Kontak', '+62...', 'phone'],
                        ['kampus', 'Kampus', 'Universitas Asal', 'university'],
        
                        // ✅ UPDATE: Ganti NIM jadi Jurusan
                        ['jurusan', 'Jurusan', 'Prodi / Program Studi', 'graduation-cap'],
                    ];
                @endphp
        
                @foreach($personalFields as [$name, $label, $placeholder, $icon])
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">{{ $label }}</label>
        
                        @if($name === 'jenis_kelamin')
                            <select name="jenis_kelamin" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-indigo-500 text-sm">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="Laki-laki" {{ old('jenis_kelamin', $mahasiswa->jenis_kelamin ?? '') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin', $mahasiswa->jenis_kelamin ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
        
                        @elseif($name === 'tgl_lahir')
                            <input type="date" name="tgl_lahir" 
                                value="{{ old('tgl_lahir', $mahasiswa->tgl_lahir ?? '') }}"
                                class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-indigo-500 text-sm">
        
                        @else
                            <div class="relative">
                                <i class="fas fa-{{ $icon }} absolute left-3 top-3 text-gray-400"></i>
                                <input type="text" name="{{ $name }}" placeholder="{{ $placeholder }}"
                                    value="{{ old($name, $mahasiswa->$name ?? '') }}"
                                    class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 text-sm placeholder-gray-400">
                            </div>
                        @endif
                    </div>
                @endforeach
        
                <!-- ✅ Kolom NIM Baru di bawah Jurusan -->
                <!-- ✅ Kolom NIM — lebar sama seperti input lain -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">NIM</label>
                    <div class="relative">
                        <i class="fas fa-id-card absolute left-3 top-3 text-gray-400"></i>
                        <input type="text" name="nim" placeholder="Nomor Induk Mahasiswa"
                            value="{{ old('nim', $mahasiswa->nim ?? '') }}"
                            class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 text-sm placeholder-gray-400">
                    </div>
                </div>

        
            </div>
        </section>


        <!-- ========== 2. INFORMASI MAGANG ========== -->
        <section id="informasi-magang">
            <h3 class="text-lg font-semibold text-indigo-700 mb-6 flex items-center">
                <i class="fas fa-briefcase mr-2"></i> Informasi Magang
            </h3>
        
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
                <!-- PERIODE -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Periode</label>
                    <div class="relative">
                        <i class="fas fa-calendar-alt absolute left-3 top-3 text-gray-400"></i>
                        <input type="text" name="periode" placeholder="Jan 2025 - Jun 2025"
                            value="{{ old('periode', $mahasiswa->periode ?? '') }}"
                            class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 text-sm placeholder-gray-400">
                    </div>
                </div>
        
                <!-- NAMA MENTOR -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Mentor</label>
                    <div class="relative">
                        <i class="fas fa-user-tie absolute left-3 top-3 text-gray-400"></i>
                        <input type="text" name="nama_mentor" placeholder="Masukkan nama mentor"
                            value="{{ old('nama_mentor', $mahasiswa->nama_mentor ?? '') }}"
                            class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 text-sm placeholder-gray-400">
                    </div>
                </div>
        
                <!-- ✅ DIREKTORAT (FULL WIDTH) -->
                <div class="col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Direktorat</label>
                    <select name="direktorat" id="direktorat"
                        class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-indigo-500 text-sm">
                        <option value="">Pilih Direktorat</option>
                        @foreach([
                            'Direktorat Utama',
                            'Direktorat Operasi',
                            'Direktorat Sales & Marketing',
                            'Direktorat Finance & Business Support'
                        ] as $opt)
                            <option value="{{ $opt }}"
                                {{ (old('direktorat', $mahasiswa->direktorat ?? '') == $opt) ? 'selected' : '' }}>
                                {{ $opt }}
                            </option>
                        @endforeach
                    </select>
                </div>
        
                <!-- ✅ FUNGSI (LEFT) -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Fungsi</label>
                    <select name="fungsi" id="fungsi"
                        class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-indigo-500 text-sm">
                        <option value="">Pilih Fungsi</option>
                    </select>
                </div>
        
                <!-- ✅ SUB FUNGSI (RIGHT) -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Sub Fungsi</label>
                    <select name="sub_fungsi" id="sub_fungsi"
                        class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-indigo-500 text-sm">
                        <option value="">Pilih Sub Fungsi</option>
                    </select>
                </div>
        
            </div>
        </section>



                <!-- ======== STATUS MAGANG (Interaktif) ======== -->
                <div class="col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Status</label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="status-card border rounded-xl p-5 flex items-center justify-between cursor-pointer hover:shadow-md transition"
                            data-value="intern">
                            <div>
                                <h4 class="font-semibold text-gray-800">Internship</h4>
                                <p class="text-sm text-gray-500">Sudah lulus dan menjalani magang profesional</p>
                            </div>
                            <i class="fas fa-briefcase text-indigo-500 text-xl"></i>
                        </div>
                        
                        


                        <div class="status-card border rounded-xl p-5 flex items-center justify-between cursor-pointer hover:shadow-md transition"
                            data-value="pkl">
                            <div>
                                <h4 class="font-semibold text-gray-800">PKL</h4>
                                <p class="text-sm text-gray-500">Masih mahasiswa yang sedang praktik kerja</p>
                            </div>
                            <i class="fas fa-user-graduate text-indigo-500 text-xl"></i>
                        </div>
                    </div>
                    <input type="hidden" name="status_magang" id="status_magang" value="{{ old('status_magang', $mahasiswa->status_magang ?? '') }}">
                </div>
                <!-- ======== TAHUN LULUS (Muncul hanya jika Intern) ======== -->
                        <div id="tahun-lulus-field" class="hidden col-span-2 transition-all duration-300">
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Tahun Lulus</label>
                            <input type="number" name="tahun_lulus" min="2015" max="2050"
                                placeholder="2025"
                                value="{{ old('tahun_lulus', $mahasiswa->tahun_lulus ?? '') }}"
                                class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-indigo-500 text-sm">
                        </div>

                <!-- ======== DATA REKENING (Bank + Nomor Rekening) ======== -->
                <div id="rekening-field" class="hidden col-span-2 transition-all duration-300">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Bank</label>
                            <select name="bank" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-indigo-500 text-sm">
                                <option value="">Pilih Bank</option>
                                <option value="BCA" {{ old('bank', $mahasiswa->bank ?? '') == 'BCA' ? 'selected' : '' }}>BCA</option>
                                <option value="Mandiri" {{ old('bank', $mahasiswa->bank ?? '') == 'Mandiri' ? 'selected' : '' }}>Mandiri</option>
                                <option value="BRI" {{ old('bank', $mahasiswa->bank ?? '') == 'BRI' ? 'selected' : '' }}>BRI</option>
                                <option value="BNI" {{ old('bank', $mahasiswa->bank ?? '') == 'BNI' ? 'selected' : '' }}>BNI</option>
                                <option value="CIMB Niaga" {{ old('bank', $mahasiswa->bank ?? '') == 'CIMB Niaga' ? 'selected' : '' }}>CIMB Niaga</option>
                                <option value="BSI" {{ old('bank', $mahasiswa->bank ?? '') == 'BSI' ? 'selected' : '' }}>BSI (Syariah)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor Rekening</label>
                            <div class="relative">
                                <i class="fas fa-credit-card absolute left-3 top-3 text-gray-400"></i>
                                <input type="text" name="rekening" placeholder="Masukkan nomor rekening"
                                    value="{{ old('rekening', $mahasiswa->rekening ?? '') }}"
                                    class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 text-sm placeholder-gray-400">
                            </div>
                        </div>
                    </div>
                </div>
       

        <!-- ========== 3. BERKAS MAGANG → GANTI JADI BERKAS PENDUKUNG ========== -->
        <section id="berkas-magang">
            <h3 class="text-lg font-semibold text-indigo-700 mb-6 flex items-center">
                <i class="fas fa-folder-open mr-2"></i> Berkas Pendukung
            </h3>

            <div id="berkas-pkl" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach ([
                    'proposal' => 'Proposal Magang (PDF)',
                    'surat_pengantar' => 'Surat Pengantar Kampus',
                    'mou' => 'Surat Penerimaan Magang / MOU',
                    'cv' => 'Curriculum Vitae (CV)'
                ] as $field => $label)
                    <div class="berkas-field-pkl">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">{{ $label }}</label>
                        <label class="flex items-center justify-between px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:border-indigo-400 transition">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-upload text-indigo-500"></i>
                                <span class="text-gray-600 text-sm">Pilih File</span>
                            </div>
                            <input type="file" name="{{ $field }}" class="hidden"
                                onchange="this.parentNode.querySelector('.file-name').innerText = this.files[0]?.name || 'Tidak ada file'">
                            <span class="file-name text-xs text-gray-500">Tidak ada file</span>
                        </label>
                    </div>
                @endforeach
            </div>

            <div id="berkas-intern" class="grid grid-cols-1 md:grid-cols-2 gap-6 hidden">
                @foreach ([
                    'skl' => 'SKL / Ijazah',
                    'mou' => 'Surat Penerimaan Magang / MOU',
                    'cv' => 'Curriculum Vitae (CV)'
                ] as $field => $label)
                    <div class="berkas-field-intern">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">{{ $label }}</label>
                        <label class="flex items-center justify-between px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:border-indigo-400 transition">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-upload text-indigo-500"></i>
                                <span class="text-gray-600 text-sm">Pilih File</span>
                            </div>
                            <input type="file" name="{{ $field }}" class="hidden"
                                onchange="this.parentNode.querySelector('.file-name').innerText = this.files[0]?.name || 'Tidak ada file'">
                            <span class="file-name text-xs text-gray-500">Tidak ada file</span>
                        </label>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- Tombol Simpan -->
        <div class="flex justify-end pt-6 border-t border-gray-100">
            <button type="submit"
                class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-medium rounded-lg shadow hover:from-indigo-700 hover:to-purple-700 transition flex items-center">
                <i class="fas fa-save mr-2"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<!-- ================== SCRIPT INTERAKTIF ================== -->
<script>
document.querySelectorAll('.status-card').forEach(card => {
    card.addEventListener('click', () => {
        const selectedValue = card.dataset.value;
        const hiddenInput = document.getElementById('status_magang');
        const rekeningField = document.getElementById('rekening-field');
        const berkasPKL = document.getElementById('berkas-pkl');
        const berkasIntern = document.getElementById('berkas-intern');
        const tahunLulusField = document.getElementById('tahun-lulus-field');

        document.querySelectorAll('.status-card').forEach(c => {
            c.classList.remove('ring-2', 'ring-indigo-500', 'bg-indigo-50');
        });

        card.classList.add('ring-2', 'ring-indigo-500', 'bg-indigo-50');
        hiddenInput.value = selectedValue;

        // kondisi sesuai revisi
        if (selectedValue === 'intern') {
            rekeningField.classList.remove('hidden');
            tahunLulusField.classList.remove('hidden');
            berkasPKL.classList.add('hidden');
            berkasIntern.classList.remove('hidden');
        } else {
            rekeningField.classList.add('hidden');
            tahunLulusField.classList.add('hidden');
            berkasPKL.classList.remove('hidden');
            berkasIntern.classList.add('hidden');
        }
    });
});

window.addEventListener('DOMContentLoaded', () => {
    const currentStatus = document.getElementById('status_magang').value;
    const rekeningField = document.getElementById('rekening-field');
    const berkasPKL = document.getElementById('berkas-pkl');
    const berkasIntern = document.getElementById('berkas-intern');
    const tahunLulusField = document.getElementById('tahun-lulus-field');

    if (currentStatus === 'intern') {
        rekeningField.classList.remove('hidden');
        tahunLulusField.classList.remove('hidden');
        berkasPKL.classList.add('hidden');
        berkasIntern.classList.remove('hidden');
    } else {
        rekeningField.classList.add('hidden');
        tahunLulusField.classList.add('hidden');
        berkasPKL.classList.remove('hidden');
        berkasIntern.classList.add('hidden');
    }
});

const direktoratSelect = document.querySelector('select[name="direktorat"]');
const fungsiSelect = document.getElementById('fungsi');
const subFungsiSelect = document.getElementById('sub_fungsi');

// Mapping direktorat ke fungsi
const fungsiOptions = {
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
        "Technical Specialist",
        "Proj Sales & Marketing Sp Chem"
    ],
    "Direktorat Operasi": [
        "Production",
        "Distribution",
        "Quality",
        "Technical Services"
    ],
    "Direktorat Finance & Business Support": [
        "Finance",
        "Risk Management & Financial Policy",
        "Human Capital & Quality Management",
        "Procurement & General Affairs"
    ]
};

// Mapping Fungsi → Sub Fungsi
const subFungsiOptions = {
    // ✅ 1. Audit Executive
    "Audit Executive": [
        "Audit Executive",
        "Operation Audit",
        "Finance & Support Audit"
    ],

    // ✅ 2. Corporate Secretary
    "Corporate Secretary": [
        "Corporate Secretary",
        "CSR",
        "Corporate Governance & Board Support",
        "Executive Secretary",
        "Corporate Communication & Investor Relations",
        "External Communications",
        "Internal Communications",
        "Investor Relation & Sustainability"
    ],

    // ✅ 3. Legal Counsel
    "Legal Counsel": [
        "Legal Counsel",
        "BD & Finance",
        "Corporate Matters & Operation Support",
        "Litigation & Area Support"
    ],

    // ✅ 4. Corp Strategic & Buss Dev
    "Corp Strategic & Buss Dev": [
        "Corporate Strategic & Business Development",
        "Corp Planning, Portfolio & Investment",
        "Strategic Planning",
        "Investment & Partnership Evaluation",
        "Performance Management & Evaluation",
        "Business Development & Organic Improvement",
        "Strategic Projects & Inorganic Dev",
        "Coordinator I",
        "Coordinator II"
    ],

    // ✅ 5. Product Development
    "Product Development": [
        "Product Development",
        "Engine & Driveline Lubricants",
        "Automotive Engine Oil",
        "Diesel Engine Oil",
        "Marine & Gas Engine Oil",
        "Driveline & OEM Lubricants",
        "Industrial Grease & Specialties",
        "Petrochemical & Oil Field Chemical",
        "Field Engineer",
        "Product Development Support",
        "Lab Product Development",
        "Bench Test & Engine Test",
        "Quality & Technical"
    ],

    // ✅ 6. HSSE
    "HSSE": [
        "HSSE",
        "Plan, Monitoring & Audit System Management",
        "Performance & HSE Audit",
        "HSE Operation",
        "Security"
    ],

    "West Region": [
        "West Region",
        "Sales Operation West Region",
    
        // Region I
        "Sales Region I",
        "Retail Sumbar",
        "Retail Area Outer Padang",
        "Retail Riau & Kepri",
        "Retail Area Dumai",
        "Retail Area Batam",
        "Retail Sumut & NAD",
        "Retail Area Karo Binjai",
        "Retail Area Tapanuli & Labuhan Batu",
        "Industry Sumut & NAD",
        "Industry Riau, Sumbar & Kepri",
        "Industry Area Padang",
        "Sales Support Region I",
    
        // Region II	
        "Sales Region II",
        "Retail Lampung",
        "Retail Area Bengkulu",
        "Retail Sumsel, Jambi & Babel",
        "Industry Sumsel & Babel",
        "Industry Area Lampung",
        "Industry Area Jambi & Bengkulu",
        "Sales Support Region II",
    
        // Region III
        "Sales Region III",
        "Retail Bandung",
        "Retail Area Tasikmalaya",
        "Retail Bogor",
        "Retail Area Sukabumi & Cianjur",
        "Retail DKI Jakarta",
        "Retail Area Jakarta Selatan",
        "Retail Area Jakarta Timur",
        "Retail Cirebon",
        "Retail Area Bekasi",
        "Retail Area Bekasi & Karawang",
        "Retail Banten",
        "Retail Area Tangerang",
        "Industry Jakarta 1",
        "Industry Marine Barat",
        "Industry Marine Jakarta",
        "Industry Jakarta 2",
        "Industry Area Bandung",
        "Industry Area Banten & Bogor",
        "Sales Support Region III",
    
        // Region IV
        "Sales Region IV",
        "Retail DI Yogyakarta",
        "Retail Area Surakarta",
        "Retail Area Banyumas & Magelang",
        "Retail Jawa Tengah",
        "Retail Area Pekalongan",
        "Industry Jateng & DIY",
        "Industry Area Yogyakarta & Solo",
        "Sales Support Region IV"],
        
    "East Region": [
        "East Region",
        "Sales Operation East Region",
    
        // Region V
        "Sales Region V",
        "Retail Bali & Nusra",
        "Retail Area NTT",
        "Retail Area Lombok",
        "Retail Surabaya",
        "Retail Area Lamongan, Tuban & Bojonegoro",
        "Retail Area Sidoarjo, Mojokerto & Madura",
        "Retail Malang, Jember & Probolinggo",
        "Retail Kediri & Madiun",
        "Retail Area Madiun, Ponorogo, Magetan & Pacitan",
        "Industry Jatim & Balinus",
        "Industry Area Jatim Selatan",
        "Sales Support Region V",
    
        // Region VI
        "Sales Region VI",
        "Retail Kalbar",
        "Retail Kalsel & Kalteng",
        "Retail Area Kalteng",
        "Retail Kaltim & Kaltara",
        "Retail Area Kaltara",
        "Retail Area Balikpapan & Samarinda",
        "Industry Banjarmasin",
        "Industry Area Pontianak",
        "Industry Area Balikpapan",
        "Industry Area Samarinda",
        "Industry Area Tarakan",
        "Sales Support Region VI",
    
        // Region VII
        "Sales Region VII",
        "Retail Sulut, Sulteng & Gorontalo",
        "Retail Area Sulawesi Tengah",
        "Retail Sulsel, Sulbar & Tenggara",
        "Retail Area Sulawesi Tenggara",
        "Retail Maluku & Papua",
        "Retail Area Maluku Selatan",
        "Industry Sulawesi",
        "Industry Area Sulteng & Tenggara",
        "Industry Area Papua",
        "Sales Support Region VII"],
        
    "Marketing": [
        "Marketing",
        "Marketing Strategy",
        "Market Research & Intelligence",
        "Pricing",
        "PCO & Specialties",
        "SEO",
        "PDO & AGO",
        "Engine Oil",
        "Non Engine Oil",
        "Grease & Specialty Lubricants",
        "Brand Communication"],
        
    "Sales Strategy & Operation": [
        "Sales Strategy & Operation",
        "Sales Planning & Performance",
        "Demand Analysis",
        "Distributor Management",
        "Credit & Customer Management",
        "Customer Care & Complaint Handling",
        "Channel Management",
        "B2C Outlet Management",
        "B2B Customer Management"],
        
    "Key Account": [
        "Key Account",
        "Key Account I",
        "Key Account II",
        "Key Account III",
        "Key Account IV",
        "Key Account VII",
        "Key Account IX",
        "Key Account X",
        "Sales Support Key Account"],
        
    "Sales & Marketing Overseas": [
        "Sales & Marketing Overseas",
        "Asia Pacific",
        "West Asia, Middle East & Africa",
        "Sales Support Overseas",
        "LBO Trading",
        "Trader LBO Operation"],
        
    "Technical Specialist": [
        "Technical Specialist",
        "Marine",
        "Powergen & Rotating Equipment",
        "Industrial Specialties",
        "Heavy Equipment & Fleet",
        "On Field Engineer",
        "Oil Clinic",
        "OEM & Customer Service",
        "Quality & HSSE",
        "Lab Batakan",
        "Quality & HSSE Batakan",
        "ILMA"],
        
    "Proj Sales & Marketing Sp Chem": [
        "Project Sales & Marketing Specialty Chemicals",
        "Area Manager RPO & SF Jakarta",
        "Area Manager RPO & SF Jatim",
        "Area Manager RPO & SF Kalimantan"],
        

    "Production": [
        "Production",
        "Process Engineering & Technology",
        "Production & RMP",
        "Production Planning",
        "Raw Material Planning",
        "Packaging Planning",
        "Specialty Chemical",
    
        // ✅ Production Unit Jakarta (PUJ)
        "PUJ - LOBP",
        "PUJ - Control Room",
        "PUJ - Receiving & Storage Hydro",
        "PUJ - Receiving Bulk Hydro",
        "PUJ - Grease Plant",
        "PUJ - Blending Grease Specialties",
        "PUJ - VIM Plant & Specialties",
        "PUJ - Filling",
        "PUJ - Lithos PUJ II",
        "PUJ - Lithos PUJ III",
        "PUJ - Drum PUJ II",
        "PUJ - Bulk PUJ I",
        "PUJ - Bulk PUJ II",
        "PUJ - Admin Operation",
        "PUJ - Logistic",
        "PUJ - Custom & Clearance",
        "PUJ - Material Warehouse",
        "PUJ - HSSE Area Jakarta",
    
        // ✅ Production Unit Cilacap (PUC)
        "PUC - LOBP",
        "PUC - Receiving & Storage Hydro",
        "PUC - Blending PUC I",
        "PUC - Blending PUC II",
        "PUC - Filling",
        "PUC - Lithos PUC I",
        "PUC - Lithos PUC III",
        "PUC - Bulk PUC",
        "PUC - Admin Operation",
        "PUC - Logistic",
        "PUC - Logistic & Purchasing",
        "PUC - HSSE Area Cilacap",
    
        // ✅ Production Unit Gresik (PUG)
        "PUG - LOBP",
        "PUG - Control Room PUG II",
        "PUG - Control Room PUG III",
        "PUG - Control Room PUG IV",
        "PUG - Receiving & Storage Hydro",
        "PUG - Receiving & Storage BH PUG I",
        "PUG - Receiving & Storage BH PUG II",
        "PUG - VIM Plant",
        "PUG - Filling",
        "PUG - Lithos PUG I",
        "PUG - Lithos PUG II",
        "PUG - Drum PUG",
        "PUG - Bulk PUG I",
        "PUG - Bulk PUG II",
        "PUG - Admin Operation",
        "PUG - Logistic",
        "PUG - Logistic & Purchasing",
        "PUG - Custom & Clearance",
        "PUG - HSSE Area Gresik"],
        
    "Distribution": [
        "Distribution",
        "Operation Planning & Performance",
        "Distribution System & IT",
        "Inventory Control",
        "Distribution & Transportation Management",
        "Transportation Management",
        "Distribution Performance",
    
        // ✅ West Region Distribution
        "Distribution SUMBAGUT",
        "Distribution Padang",
        "Distribution Pekan Baru",
        "Distribution SUMBAGSEL",
        "Distribution Kertapati",
        "Distribution JBB & JBT",
        "Distribution Plumpang",
        "Lithos Distribution Plumpang",
        "Drum Distribution Plumpang",
    
        // ✅ Central / Java Region
        "Distribution Semarang",
        "Distribution Cilacap",
    
        // ✅ Overseas
        "Distribution Overseas",
    
        // ✅ East Region Distribution
        "Distribution JATIM BALINUS",
        "Distribution Gresik & Pasar Turi",
        "Distribution Pasar Turi",
        "Distribution Kalimantan",
        "Distribution Banjarmasin",
        "Distribution Batakan",
        "Distribution SULAMPUA",
        "Distribution Makassar",
        "Distribution Jayapura"],
        
    "Quality": [
        "Quality",
        "Quality Assurance",
        "Quality Control",
        "Quality PUJ",
        "Quality PUG",
        "Quality PUC",
        "Lab. PU Jakarta",
        "Lab. PU Cilacap",
        "Lab. PU Gresik"],
        
    "Technical Services": [
        "Technical Services",
        "Design",
        "Project Construction",
        "Cost Control & Administration",
        "Reliability & Maintenance",
        "Reliability Planning & Performance",
        "Maintenance & Inspection PUJ & West Operation Distribution",
        "Maintenance & Inspection PUC & Distribution Cilacap"],

    "Finance": [
        "Finance",
        "Finance Support",
        "Finance Support Head Office",
        "AR & AP Analysis and Reporting",
        
        // Finance Support per Region
        "Finance Support Sales Region I",
        "Finance Support Sales Region II",
        "Finance Support Sales Region III",
        "Finance Support Sales Region IV",
        "Finance Support Sales Region V",
        "Finance Support Sales Region VI",
        "Finance Support Sales Region VII",
    
        // Treasury & Controller
        "Treasury & Financing",
        "Treasury & Cash Management",
        "Corporate Financing",
        "Controller",
        "Financial & Management Accounting",
        "Budgeting & Forecasting",
        "Budget Monitoring & Evaluation",
        "Cost Management & Finance Production Support",
        "Cost Accounting",
        "Inventory Accounting",
    
        // Finance Support Production Units
        "Finance Support PU Jakarta",
        "Finance Support PU Gresik",
        "Finance Support PU Cilacap",
    
        // Tax
        "Tax Advisory & Compliance",
        "Tax Compliance",
        "Tax Advisory & Litigation"
        ],
        
    "Risk Management & Financial Policy": [
        "Risk Management & Financial Policy",
        "Enterprise Risk Management",
        "Financial Risk & Insurance",
        "PDA & CG"
        ],
        
    "Human Capital & Quality Management": [
        "Human Capital & Quality Management",
        "HC Policy",
        "Quality Management",
        "HC Policy & Quality Management",
        "Human Capital",
        
        // HCBP
        "HCBP Region I",
        "HCBP Region II",
        "HCBP Region III",
    
        // Outsourcing
        "Outsourcing Management & IR",
    
        // HR Systems
        "HCIS, Service & Payroll"
        ],
        
    "Procurement & General Affairs": [
        "Procurement & General Affairs",
        "Planning & Performance",
        "Strategic Sourcing",
        "Hydro Material Procurement",
        "Non-Hydro Material Procurement",
        "Contract Administration & Support",
        "Business Support Procurement",
        "General Procurement",
    
        // Asset & Facilities
        "Asset Management",
        "Asset Optimization",
        "General Services",
    
        // Business Support per Region & PU
        "Business Support Operation SR 3",
        "Business Support Operation SR 4",
        "Business Support Operation SR 5",
        "Business Support Operation SR 7",
        "Business Support Operation PUJ",
        "Business Support Operation PUC",
        "Business Support Operation PUG",
    
        // ICT (IT)
        "Information & Communication Technology",
        "IT Operation",
        "IT Architecture, Security Policy & Governance",
        "IT Business Solution"
        ]
        
};


// Update fungsi dropdown saat direktorat dipilih
direktoratSelect.addEventListener('change', () => {
    fungsiSelect.innerHTML = `<option value="">Pilih Fungsi</option>`;
    subFungsiSelect.innerHTML = `<option value="">Pilih Sub Fungsi</option>`;
    
    const selected = direktoratSelect.value;
    if (fungsiOptions[selected]) {
        fungsiOptions[selected].forEach(f => {
            fungsiSelect.innerHTML += `<option value="${f}">${f}</option>`;
        });
    }
});

// Update sub fungsi saat fungsi dipilih
fungsiSelect.addEventListener('change', () => {
    subFungsiSelect.innerHTML = `<option value="">Pilih Sub Fungsi</option>`;
    
    const selected = fungsiSelect.value;
    if (subFungsiOptions[selected]) {
        subFungsiOptions[selected].forEach(sf => {
            subFungsiSelect.innerHTML += `<option value="${sf}">${sf}</option>`;
        });
    }
});

// Load saat edit
window.addEventListener('DOMContentLoaded', () => {
    const selectedDirektorat = direktoratSelect.value;
    const selectedFungsi = "{{ old('fungsi', $mahasiswa->fungsi ?? '') }}";
    const selectedSubFungsi = "{{ old('sub_fungsi', $mahasiswa->sub_fungsi ?? '') }}";

    if (fungsiOptions[selectedDirektorat]) {
        fungsiOptions[selectedDirektorat].forEach(f => {
            const opt = document.createElement('option');
            opt.value = f;
            opt.textContent = f;
            if (f === selectedFungsi) opt.selected = true;
            fungsiSelect.appendChild(opt);
        });
    }

    if (subFungsiOptions[selectedFungsi]) {
        subFungsiOptions[selectedFungsi].forEach(sf => {
            const opt = document.createElement('option');
            opt.value = sf;
            opt.textContent = sf;
            if (sf === selectedSubFungsi) opt.selected = true;
            subFungsiSelect.appendChild(opt);
        });
    }
});

</script>

@endsection
