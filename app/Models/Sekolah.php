<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    use HasFactory;
    
    protected $table = 'sekolah';

    protected $fillable = [
        'npsn',
        'nama_sekolah',
        'alamat',
        'nama_kepsek',
        'nama_pembos',
        'logo'
    ];
}