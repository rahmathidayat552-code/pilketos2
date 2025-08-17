<?php

namespace App\Imports;

use App\Models\Pemilih;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PemilihImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Pemilih([
            'nama' => $row['nama'],   // kolom di Excel harus 'nama'
            'jenis' => $row['jenis'], // kolom di Excel harus 'jenis' (siswa/guru)
            'token' => strtoupper(Str::random(5)),
            'sudah_memilih' => false,
        ]);
    }
}
