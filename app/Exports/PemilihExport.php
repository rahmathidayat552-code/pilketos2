<?php

namespace App\Exports;

use App\Models\Pemilih;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PemilihExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Pemilih::select('id', 'nama', 'jenis', 'token', 'sudah_memilih')->get();
    }

    public function headings(): array
    {
        return ['ID', 'Nama', 'Jenis', 'Token', 'Sudah Memilih'];
    }
}
