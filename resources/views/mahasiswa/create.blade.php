<form action="{{ route('mahasiswa.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="text" name="nama" placeholder="Nama"><br>
    <input type="text" name="nim" placeholder="NIM"><br>
    <input type="text" name="kampus" placeholder="Kampus"><br>
    <input type="text" name="kontak" placeholder="Kontak"><br>
    <input type="text" name="periode" placeholder="Periode"><br>
    
    Foto: <input type="file" name="foto"><br>
    Proposal: <input type="file" name="proposal"><br>
    Surat Pengantar: <input type="file" name="surat_pengantar"><br>
    MOU: <input type="file" name="mou"><br>

    <label>Status:
        <select name="status">
            <option value="aktif">Aktif</option>
            <option value="selesai">Selesai</option>
        </select>
    </label><br>

    <button type="submit">Simpan</button>
</form>
