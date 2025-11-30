<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        return view('laporan.index');
    }

    public function mentorView()
    {
        // Dummy data laporan mahasiswa
        $laporans = [
            (object)[
                'id' => 1,
                'nama' => 'Ahmad Fauzi',
                'nim' => '187221001',
                'judul' => 'Laporan Mingguan 1',
                'file' => 'laporan1.pdf',
                'tanggal' => '2025-09-28',
                'status' => 'Menunggu Review'
            ],
            (object)[
                'id' => 2,
                'nama' => 'Siti Nurhaliza',
                'nim' => '187221002',
                'judul' => 'Laporan Mingguan 1',
                'file' => 'laporan2.pdf',
                'tanggal' => '2025-09-28',
                'status' => 'Disetujui'
            ],
            (object)[
                'id' => 3,
                'nama' => 'Budi Santoso',
                'nim' => '187221003',
                'judul' => 'Laporan Mingguan 1',
                'file' => 'laporan3.pdf',
                'tanggal' => '2025-09-28',
                'status' => 'Direvisi'
            ],
        ];

        return view('mentor.laporan', compact('laporans'));
    }

}


