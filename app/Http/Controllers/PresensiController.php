<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PresensiController extends Controller
{
    public function index()
    {
        // Dummy data presensi
        $presensis = [
            (object)[
                'id' => 1,
                'nama' => 'Ahmad Fauzi',
                'nim' => '187221001',
                'tanggal' => '2025-10-01',
                'jam_masuk' => '08:05',
                'jam_keluar' => '16:30',
                'status' => 'Hadir',
                'lokasi' => 'Surabaya'
            ],
            (object)[
                'id' => 2,
                'nama' => 'Siti Nurhaliza',
                'nim' => '187221002',
                'tanggal' => '2025-10-01',
                'jam_masuk' => '08:20',
                'jam_keluar' => '16:10',
                'status' => 'Izin',
                'lokasi' => 'Sidoarjo'
            ],
            (object)[
                'id' => 3,
                'nama' => 'Budi Santoso',
                'nim' => '187221003',
                'tanggal' => '2025-10-01',
                'jam_masuk' => null,
                'jam_keluar' => null,
                'status' => 'Alfa',
                'lokasi' => '-'
            ],
        ];
        // Generate QR Code unik untuk hari ini
        $token = base64_encode(now()->format('Y-m-d'));
        $qrCode = \SimpleSoftwareIO\QrCode\Facades\QrCode::size(200)->generate(url('/mahasiswa/checkin?token=' . $token));

        return view('presensi.index', compact('presensis', 'qrCode'));

        
        
    }
    public function showForm()
    {
        // generate token unik untuk hari ini
        $token = base64_encode(now()->format('Y-m-d') . '-' . Auth::id());

        $qrCode = QrCode::size(200)->generate(url('/mahasiswa/checkin?token=' . $token));

        return view('presensi.mahasiswa', compact('qrCode'));
    }

    public function checkIn(Request $request)
    {
        $token = $request->query('token');
        $user = Auth::user();

        // validasi token → harus match dengan hari ini
        $expected = base64_encode(now()->format('Y-m-d') . '-' . $user->id);
        if ($token !== $expected) {
            return redirect()->back()->with('error', 'QR Code tidak valid atau kadaluarsa.');
        }

        // Simpan presensi ke database
        // contoh sementara:
        return redirect()->route('mahasiswa.presensi')->with('success', 'Presensi berhasil tercatat.');
    }

    // PresensiController.php
    public function mentorView()
    {
        // Dummy daftar mahasiswa presensi hari ini
        $presensis = [
            (object)[
                'nama' => 'Ahmad Fauzi',
                'nim' => '187221001',
                'status' => 'Hadir',
                'jam_masuk' => '08:10',
                'jam_keluar' => '16:00',
                'lokasi' => 'Surabaya'
            ],
            (object)[
                'nama' => 'Siti Nurhaliza',
                'nim' => '187221002',
                'status' => 'Izin',
                'jam_masuk' => null,
                'jam_keluar' => null,
                'lokasi' => '-'
            ],
            (object)[
                'nama' => 'Budi Santoso',
                'nim' => '187221003',
                'status' => 'Alfa',
                'jam_masuk' => null,
                'jam_keluar' => null,
                'lokasi' => '-'
            ],
        ];

        // QR unik untuk hari ini
        $token = base64_encode(now()->format('Y-m-d'));
        $qrCode = \SimpleSoftwareIO\QrCode\Facades\QrCode::size(200)->generate(url('/mahasiswa/checkin?token=' . $token));

        return view('mentor.presensi', compact('presensis', 'qrCode'));
    }

}
