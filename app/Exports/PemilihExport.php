<?php

namespace App\Exports;

use App\Models\Pemilih;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class PemilihExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection(): Collection
    {
        return Pemilih::all()->map(function ($pemilih) {
            return [
                'id' => $pemilih->id,
                'nama' => $pemilih->nama,
                'jenis' => $pemilih->jenis,
                'token' => $pemilih->token,
                'sudah_memilih' => $pemilih->sudah_memilih ? 'Sudah Memilih' : 'Belum Memilih',
            ];
        });
    }

    /**
    * @return array
    */
    public function headings(): array
    {
        return [
            'ID',
            'Nama',
            'Jenis',
            'Token',
            'Status'
        ];
    }
}