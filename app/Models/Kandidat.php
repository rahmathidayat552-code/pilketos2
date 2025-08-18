<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany; // Tambahkan ini

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
    
    // Tambahkan method ini untuk mendefinisikan relasi
    public function suara(): HasMany
    {
        return $this->hasMany(Suara::class, 'kandidat_id');
    }
}