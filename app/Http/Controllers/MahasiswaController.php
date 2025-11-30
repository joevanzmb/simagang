<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MahasiswaController extends Controller
{
    // ================= ADMIN AREA =================
    public function index()
    {
        $mahasiswas = Mahasiswa::all();
        return view('mahasiswa.index', compact('mahasiswas'));
    }

    public function create()
    {
        return view('mahasiswa.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nim' => 'required|string|unique:mahasiswas,nim',
            'kampus' => 'required|string|max:255',
            'kontak' => 'required|string|max:20',
            'periode' => 'required|string|max:50',
            'status' => 'required|in:aktif,selesai',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'proposal' => 'nullable|mimes:pdf|max:5120',
            'surat_pengantar' => 'nullable|mimes:pdf|max:5120',
            'mou' => 'nullable|mimes:pdf|max:5120',
        ]);

        foreach (['foto', 'proposal', 'surat_pengantar', 'mou'] as $file) {
            if ($request->hasFile($file)) {
                $validated[$file] = $request->file($file)->store('uploads', 'public');
            }
        }

        Mahasiswa::create($validated);
        return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa berhasil ditambahkan.');
    }

    public function edit(Mahasiswa $mahasiswa)
    {
        return view('mahasiswa.edit', compact('mahasiswa'));
    }

    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        $data = $request->validate([
            'nama' => 'required',
            'nim' => 'required|unique:mahasiswas,nim,' . $mahasiswa->id,
            'kampus' => 'required',
            'kontak' => 'required',
            'periode' => 'required',
            'status' => 'required|in:aktif,selesai',
            'foto' => 'nullable|image',
            'proposal' => 'nullable|file|mimes:pdf',
            'surat_pengantar' => 'nullable|file|mimes:pdf',
            'mou' => 'nullable|file|mimes:pdf',
        ]);

        foreach (['foto', 'proposal', 'surat_pengantar', 'mou'] as $file) {
            if ($request->hasFile($file)) {
                if ($mahasiswa->$file) {
                    Storage::delete($mahasiswa->$file);
                }
                $data[$file] = $request->file($file)->store("mahasiswa/{$file}");
            }
        }

        $mahasiswa->update($data);
        return redirect()->route('mahasiswa.index')->with('success', 'Data berhasil diupdate');
    }

    public function destroy(Mahasiswa $mahasiswa)
    {
        foreach (['foto', 'proposal', 'surat_pengantar', 'mou'] as $file) {
            if ($mahasiswa->$file) {
                Storage::delete($mahasiswa->$file);
            }
        }

        $mahasiswa->delete();
        return redirect()->route('mahasiswa.index')->with('success', 'Data berhasil dihapus');
    }

    // ================= MAHASISWA AREA =================
    public function dashboard()
    {
        return view('mahasiswa.dashboard', [
            'nama' => auth()->user()->name,
            'nim' => auth()->user()->nim ?? 'Belum diisi',
            'kampus' => auth()->user()->kampus ?? 'Belum diisi',
            'statusMagang' => 'Aktif',
            'progress' => 75,
        ]);
    }

    public function attendance()
    {
        return view('mahasiswa.attendance');
    }

    public function penilaian()
    {
        return view('mahasiswa.penilaian');
    }

    public function laporan()
    {
        return view('mahasiswa.laporan');
    }

    public function feedback()
    {
        return view('mahasiswa.feedback');
    }

    public function reminder()
    {
        return view('mahasiswa.reminder');
    }
    public function profil()
    {
        $mahasiswa = auth()->user();
        return view('mahasiswa.profil', compact('mahasiswa'));
    }

   
   //mentor

   public function mentorView()
   {
       $mahasiswas = Mahasiswa::all();
       return view('mentor.mahasiswa', compact('mahasiswas'));
   }

}

