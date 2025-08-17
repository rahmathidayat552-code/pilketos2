<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suara extends Model
{
    use HasFactory;

    protected $table = 'suara';

    protected $fillable = [
        'pemilih_id',
        'kandidat_id',
    ];

    public function pemilih()
    {
        return $this->belongsTo(Pemilih::class);
    }

    public function kandidat()
    {
        return $this->belongsTo(Kandidat::class);
    }
}