<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'nim',
        'kampus',
        'kontak',
        'periode',
        'foto',
        'proposal',
        'surat_pengantar',
        'mou',
        'status',
    ];
}
