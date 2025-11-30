<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PenilaianController extends Controller
{
    public function index()
    {
        return view('penilaian.index');
    }

    public function mentorView()
    {
        // Dummy data mahasiswa bimbingan
        $penilaians = [
            (object)[
                'id' => 1,
                'nama' => 'Ahmad Fauzi',
                'nim' => '187221001',
                'kampus' => 'Universitas Airlangga',
                'rata2' => 88,
                'status' => 'Baik',
            ],
            (object)[
                'id' => 2,
                'nama' => 'Siti Nurhaliza',
                'nim' => '187221002',
                'kampus' => 'ITS Surabaya',
                'rata2' => 79,
                'status' => 'Cukup',
            ],
        ];

        return view('mentor.penilaian', compact('penilaians'));
    }

}



