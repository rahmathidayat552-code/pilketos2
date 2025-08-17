<?php

namespace App\Http\Controllers;

use App\Models\Kandidat;
use App\Models\Suara;
use App\Models\Pemilih;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class HasilSuaraController extends Controller
{
    public function index()
    {
        // Hitung total suara yang masuk
        $totalSuara = Suara::count();

        // Ambil data kandidat dan hitung jumlah suara untuk setiap kandidat
        $hasilSuara = Kandidat::withCount('suara')
            ->orderByDesc('suara_count')
            ->get();

        // Ambil data pemilih untuk ringkasan
        $jumlahPemilih = Pemilih::count();
        $sudahMemilih = Pemilih::where('sudah_memilih', true)->count();
        $belumMemilih = Pemilih::where('sudah_memilih', false)->count();

        return Inertia::render('Admin/RekapSuara', [
            'hasilSuara' => $hasilSuara,
            'totalSuara' => $totalSuara,
            'jumlahPemilih' => $jumlahPemilih,
            'sudahMemilih' => $sudahMemilih,
            'belumMemilih' => $belumMemilih,
        ]);
    }
}