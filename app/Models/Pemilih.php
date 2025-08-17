<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemilih extends Model
{
    protected $table = 'pemilih'; // 👈 pakai nama tabel yang benar

    protected $fillable = [
        'nama',
        'jenis',
        'token',
        'sudah_memilih',
    ];
}


