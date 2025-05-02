<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'mahasiswa';

    protected $fillable = [
        'nim',
        'nama',
        'jenis_kelamin',
        'alamat',
        'tanggal_lahir',
        'program_studi',
        'angkatan',
        'email',
    ];
}
