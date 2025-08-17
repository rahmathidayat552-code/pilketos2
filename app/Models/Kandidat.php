<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kandidat extends Model
{
    protected $table = 'kandidat'; // pastikan pakai tabel ini

    protected $fillable = [
        'nama_ketua',
        'nama_wakil',
        'foto',
        'visi',
        'misi'
    ];
}

