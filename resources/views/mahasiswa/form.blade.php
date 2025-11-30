<form method="POST" enctype="multipart/form-data"
    action="{{ isset($mahasiswa) ? route('mahasiswa.update', $mahasiswa->id) : route('mahasiswa.store') }}">
    @csrf
    @if(isset($mahasiswa)) @method('PUT') @endif

    <input type="text" name="nama" value="{{ old('nama', $mahasiswa->nama ?? '') }}" placeholder="Nama"><br>
    <input type="text" name="nim" value="{{ old('nim', $mahasiswa->nim ?? '') }}" placeholder="NIM"><br>
    <input type="text" name="kampus" value="{{ old('kampus', $mahasiswa->kampus ?? '') }}" placeholder="Kampus"><br>
    <input type="text" name="kontak" value="{{ old('kontak', $mahasiswa->kontak ?? '') }}" placeholder="Kontak"><br>
    <input type="text" name="periode" value="{{ old('periode', $mahasiswa->periode ?? '') }}" placeholder="Periode"><br>

    Foto: <input type="file" name="foto"><br>
    Proposal: <input type="file" name="proposal"><br>
    Surat Pengantar: <input type="file" name="surat_pengantar"><br>
    MOU: <input type="file" name="mou"><br>

    Status:
    <select name="status">
        <option value="aktif" {{ (old('status', $mahasiswa->status ?? '') == 'aktif') ? 'selected' : '' }}>Aktif</option>
        <option value="selesai" {{ (old('status', $mahasiswa->status ?? '') == 'selesai') ? 'selected' : '' }}>Selesai</option>
    </select><br>

    <button type="submit">Simpan</button>
</form>
