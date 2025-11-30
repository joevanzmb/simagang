@extends('layouts.app', ['noHeader' => true])

@section('pageTitle', 'Reminder Magang')
@section('pageSubtitle', 'Daftar pengingat penting program magang')

@section('content')

<!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-center text-white p-7 rounded-2xl shadow-lg gap-6 mb-8"
        style="background: linear-gradient(135deg, #5a6de0 0%, #6c3fb0 100%);">
        <div>
            <h2 class="text-2xl font-bold flex items-center gap-5 leading-tight">
                <i class="fas fa-bell text-4xl"></i> Reminder Magang
            </h2>
            <p class="text-m text-white-100 mt-2">Daftar pengingat penting program magang</p>
        </div>
        <button class="px-5 py-2 bg-white/20 hover:bg-white/30 rounded-lg text-white font-medium flex items-center gap-2 transition-all duration-200 hover:scale-[1.03]">
            <i class="fas fa-plus"></i> Tambah Reminder
        </button>
    </div>

<div class="max-w-7xl mx-auto">

    @php
        // Dummy data reminder
        $reminders = [
            (object)[
                'id' => 1,
                'judul' => 'Deadline Laporan Mingguan',
                'deskripsi' => 'Mahasiswa wajib mengumpulkan laporan mingguan.',
                'tanggal' => '2025-10-05',
                'status' => 'Segera'
            ],
            (object)[
                'id' => 2,
                'judul' => 'Akhir Periode Magang',
                'deskripsi' => 'Periode magang mahasiswa batch 1 selesai.',
                'tanggal' => '2025-09-30',
                'status' => 'Lewat'
            ],
            (object)[
                'id' => 3,
                'judul' => 'Presentasi Hasil Magang',
                'deskripsi' => 'Mahasiswa presentasi hasil magang di depan mentor.',
                'tanggal' => '2025-10-15',
                'status' => 'Upcoming'
            ],
        ];

        $total = count($reminders);
        $overdue = collect($reminders)->where('status','Lewat')->count();
        $upcoming = collect($reminders)->where('status','Segera')->count();
    @endphp

    <!-- Statistik Card -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-6">
        <div class="bg-white p-5 rounded-xl shadow-md flex items-center gap-4">
            <div class="p-3 bg-indigo-100 text-indigo-600 rounded-full"><i class="fas fa-bell"></i></div>
            <div>
                <p class="text-sm text-gray-500">Total Reminder</p>
                <h3 class="text-xl font-bold">{{ $total }}</h3>
            </div>
        </div>
        <div class="bg-white p-5 rounded-xl shadow-md flex items-center gap-4">
            <div class="p-3 bg-red-100 text-red-600 rounded-full"><i class="fas fa-exclamation-triangle"></i></div>
            <div>
                <p class="text-sm text-gray-500">Lewat Waktu</p>
                <h3 class="text-xl font-bold">{{ $overdue }}</h3>
            </div>
        </div>
        <div class="bg-white p-5 rounded-xl shadow-md flex items-center gap-4">
            <div class="p-3 bg-yellow-100 text-yellow-600 rounded-full"><i class="fas fa-clock"></i></div>
            <div>
                <p class="text-sm text-gray-500">Segera</p>
                <h3 class="text-xl font-bold">{{ $upcoming }}</h3>
            </div>
        </div>
    </div>

    <!-- Tombol Tambah -->
    <div class="mb-4 text-right">
        <button onclick="openModal()" class="bg-purple-600 hover:bg-purple-700 text-white px-5 py-2 rounded-lg shadow">
            <i class="fas fa-plus mr-2"></i> Tambah Reminder
        </button>
    </div>

    <!-- Tabel Reminder -->
    <div class="bg-white rounded-xl shadow-md p-6 overflow-x-auto">
        <table class="min-w-full text-sm text-gray-700">
            <thead>
                <tr class="bg-gray-100 text-gray-800 border-b">
                    <th class="py-3 px-4 text-left">Judul</th>
                    <th class="py-3 px-4 text-left">Deskripsi</th>
                    <th class="py-3 px-4 text-center">Tanggal</th>
                    <th class="py-3 px-4 text-center">Status</th>
                    <th class="py-3 px-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reminders as $r)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-3 px-4 font-medium">{{ $r->judul }}</td>
                        <td class="py-3 px-4">{{ $r->deskripsi }}</td>
                        <td class="py-3 px-4 text-center">{{ $r->tanggal }}</td>
                        <td class="py-3 px-4 text-center">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold 
                                {{ $r->status === 'Lewat' ? 'bg-red-100 text-red-700' : 
                                   ($r->status === 'Segera' ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700') }}">
                                {{ $r->status }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-center space-x-2">
                            <button onclick="openDetailModal('{{ $r->judul }}','{{ $r->deskripsi }}','{{ $r->tanggal }}','{{ $r->status }}')" 
                                class="text-blue-600 hover:text-blue-800" title="Detail"><i class="fas fa-eye"></i></button>
                            <button class="text-yellow-500 hover:text-yellow-700" title="Edit"><i class="fas fa-edit"></i></button>
                            <button onclick="return confirm('Yakin ingin menghapus reminder ini?')" class="text-red-600 hover:text-red-800" title="Hapus"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

<!-- Modal Tambah -->
<div id="reminderModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white w-full max-w-lg mx-auto p-6 rounded-xl shadow-xl relative">
        <button onclick="closeModal()" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
            <i class="fas fa-times"></i>
        </button>
        <h3 class="text-xl font-bold mb-4">Tambah Reminder</h3>
        <form>
            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-700">Judul</label>
                <input type="text" class="w-full border px-3 py-2 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea class="w-full border px-3 py-2 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"></textarea>
            </div>
            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-700">Tanggal</label>
                <input type="date" class="w-full border px-3 py-2 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700">Simpan</button>
        </form>
    </div>
</div>

<!-- Modal Detail -->
<div id="detailModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white w-full max-w-md mx-auto p-6 rounded-xl shadow-xl relative">
        <button onclick="closeDetailModal()" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
            <i class="fas fa-times"></i>
        </button>
        <h3 class="text-xl font-bold mb-4">Detail Reminder</h3>
        <div id="detailContent" class="space-y-2"></div>
    </div>
</div>

<script>
    function openModal() {
        document.getElementById("reminderModal").classList.remove("hidden");
        document.getElementById("reminderModal").classList.add("flex");
    }
    function closeModal() {
        document.getElementById("reminderModal").classList.add("hidden");
        document.getElementById("reminderModal").classList.remove("flex");
    }

    function openDetailModal(judul, deskripsi, tanggal, status) {
        let html = `<p><b>Judul:</b> ${judul}</p>`;
        html += `<p><b>Deskripsi:</b> ${deskripsi}</p>`;
        html += `<p><b>Tanggal:</b> ${tanggal}</p>`;
        html += `<p><b>Status:</b> ${status}</p>`;
        document.getElementById("detailContent").innerHTML = html;
        document.getElementById("detailModal").classList.remove("hidden");
        document.getElementById("detailModal").classList.add("flex");
    }
    function closeDetailModal() {
        document.getElementById("detailModal").classList.add("hidden");
        document.getElementById("detailModal").classList.remove("flex");
    }
</script>

@endsection
