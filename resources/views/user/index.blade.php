@extends('layouts.app', ['noHeader' => true])

@section('pageTitle', 'Manajemen User')
@section('pageSubtitle', 'Kelola akun dan role pengguna sistem magang')

@section('content')

<!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-center text-white p-7 rounded-2xl shadow-lg gap-6 mb-8"
        style="background: linear-gradient(135deg, #5a6de0 0%, #6c3fb0 100%);">
        <div>
            <h2 class="text-2xl font-bold flex items-center gap-5 leading-tight">
                <i class="fas fa-user-cog text-4xl"></i> Manajemen User
            </h2>
            <p class="text-m text-white-100 mt-2">Kelola akun dan role pengguna sistem magang</p>
        </div>
        <button class="px-5 py-2 bg-white/20 hover:bg-white/30 rounded-lg text-white font-medium flex items-center gap-2 transition-all duration-200 hover:scale-[1.03]">
            <i class="fas fa-plus"></i> Tambah User
        </button>
    </div>

<div class="max-w-7xl mx-auto">

    @php
        // Dummy data user
        $users = [
            (object)[
                'id' => 1,
                'nama' => 'Administrator',
                'email' => 'admin@simagang.id',
                'role' => 'Admin',
                'status' => 'Aktif',
                'avatar' => 'https://ui-avatars.com/api/?name=Admin&background=4F46E5&color=fff'
            ],
            (object)[
                'id' => 2,
                'nama' => 'Ahmad Fauzi',
                'email' => 'ahmad@student.unair.ac.id',
                'role' => 'Mahasiswa',
                'status' => 'Aktif',
                'avatar' => 'https://ui-avatars.com/api/?name=Ahmad+Fauzi&background=059669&color=fff'
            ],
            (object)[
                'id' => 3,
                'nama' => 'Budi Santoso',
                'email' => 'budi@mentor.id',
                'role' => 'Mentor',
                'status' => 'Nonaktif',
                'avatar' => 'https://ui-avatars.com/api/?name=Budi+Santoso&background=DC2626&color=fff'
            ],
        ];
    @endphp

    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-gray-800">Daftar User</h2>
        <button onclick="openModal()" class="bg-purple-600 hover:bg-purple-700 text-white px-5 py-2 rounded-lg shadow">
            <i class="fas fa-user-plus mr-2"></i> Tambah User
        </button>
    </div>

    <!-- Card User (grid style) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
        @foreach ($users as $u)
            <div class="bg-white rounded-xl shadow-md p-5 flex items-center gap-4 hover:shadow-xl transition">
                <img src="{{ $u->avatar }}" alt="{{ $u->nama }}" class="w-14 h-14 rounded-full border shadow">
                <div class="flex-1">
                    <h3 class="text-lg font-semibold">{{ $u->nama }}</h3>
                    <p class="text-sm text-gray-500">{{ $u->email }}</p>
                    <span class="inline-block mt-2 px-3 py-1 rounded-full text-xs font-semibold
                        {{ $u->role === 'Admin' ? 'bg-indigo-100 text-indigo-700' :
                           ($u->role === 'Mentor' ? 'bg-green-100 text-green-700' :
                           'bg-blue-100 text-blue-700') }}">
                        {{ $u->role }}
                    </span>
                    <span class="ml-2 inline-block px-3 py-1 rounded-full text-xs font-semibold
                        {{ $u->status === 'Aktif' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ $u->status }}
                    </span>
                </div>
                <div class="flex flex-col gap-2">
                    <button onclick="openDetailModal('{{ $u->nama }}','{{ $u->email }}','{{ $u->role }}','{{ $u->status }}')" 
                        class="text-blue-600 hover:text-blue-800" title="Detail"><i class="fas fa-eye"></i></button>
                    <button class="text-yellow-500 hover:text-yellow-700" title="Edit"><i class="fas fa-edit"></i></button>
                    <button onclick="return confirm('Yakin ingin menghapus user ini?')" 
                        class="text-red-600 hover:text-red-800" title="Hapus"><i class="fas fa-trash"></i></button>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Tabel User -->
    <div class="bg-white rounded-xl shadow-md p-6 overflow-x-auto">
        <table class="min-w-full text-sm text-gray-700">
            <thead>
                <tr class="bg-gray-100 border-b text-gray-800">
                    <th class="py-3 px-4 text-left">Nama</th>
                    <th class="py-3 px-4 text-left">Email</th>
                    <th class="py-3 px-4 text-left">Role</th>
                    <th class="py-3 px-4 text-center">Status</th>
                    <th class="py-3 px-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $u)
                <tr class="border-b hover:bg-gray-50">
                    <td class="py-3 px-4 flex items-center gap-2">
                        <img src="{{ $u->avatar }}" class="w-8 h-8 rounded-full"> 
                        {{ $u->nama }}
                    </td>
                    <td class="py-3 px-4">{{ $u->email }}</td>
                    <td class="py-3 px-4">{{ $u->role }}</td>
                    <td class="py-3 px-4 text-center">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                            {{ $u->status === 'Aktif' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $u->status }}
                        </span>
                    </td>
                    <td class="py-3 px-4 text-center space-x-2">
                        <button onclick="openDetailModal('{{ $u->nama }}','{{ $u->email }}','{{ $u->role }}','{{ $u->status }}')" 
                            class="text-blue-600 hover:text-blue-800"><i class="fas fa-eye"></i></button>
                        <button class="text-yellow-500 hover:text-yellow-700"><i class="fas fa-edit"></i></button>
                        <button class="text-red-600 hover:text-red-800"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

<!-- Modal Tambah -->
<div id="userModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white w-full max-w-lg mx-auto p-6 rounded-xl shadow-xl relative">
        <button onclick="closeModal()" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
            <i class="fas fa-times"></i>
        </button>
        <h3 class="text-xl font-bold mb-4">Tambah User Baru</h3>
        <form>
            <div class="mb-3">
                <label class="block text-sm font-medium">Nama</label>
                <input type="text" class="w-full border px-3 py-2 rounded-lg focus:ring-indigo-500">
            </div>
            <div class="mb-3">
                <label class="block text-sm font-medium">Email</label>
                <input type="email" class="w-full border px-3 py-2 rounded-lg focus:ring-indigo-500">
            </div>
            <div class="mb-3">
                <label class="block text-sm font-medium">Role</label>
                <select class="w-full border px-3 py-2 rounded-lg focus:ring-indigo-500">
                    <option>Admin</option>
                    <option>Mentor</option>
                    <option>Mahasiswa</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="block text-sm font-medium">Status</label>
                <select class="w-full border px-3 py-2 rounded-lg focus:ring-indigo-500">
                    <option>Aktif</option>
                    <option>Nonaktif</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="block text-sm font-medium">Password</label>
                <input type="password" class="w-full border px-3 py-2 rounded-lg focus:ring-indigo-500">
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
        <h3 class="text-xl font-bold mb-4">Detail User</h3>
        <div id="detailContent" class="space-y-2"></div>
    </div>
</div>

<script>
    function openModal() {
        document.getElementById("userModal").classList.remove("hidden");
        document.getElementById("userModal").classList.add("flex");
    }
    function closeModal() {
        document.getElementById("userModal").classList.add("hidden");
        document.getElementById("userModal").classList.remove("flex");
    }

    function openDetailModal(nama,email,role,status) {
        let html = `<p><b>Nama:</b> ${nama}</p>`;
        html += `<p><b>Email:</b> ${email}</p>`;
        html += `<p><b>Role:</b> ${role}</p>`;
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
