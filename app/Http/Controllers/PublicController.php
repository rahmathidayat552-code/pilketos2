<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemilih;
use App\Models\Kandidat;
use App\Models\Suara;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class PublicController extends Controller
{
    // Halaman utama untuk memasukkan token
    public function showInputToken()
    {
        return Inertia::render('Public/InputToken', [
            'status' => Session::get('status'),
            'error' => Session::get('error'),
        ]);
    }

    // Memproses token dan mengarahkan ke halaman pemilihan
    public function submitToken(Request $request)
    {
        $request->validate([
            'token' => 'required|string|max:8',
        ]);

        $pemilih = Pemilih::where('token', $request->token)->first();

        // Cek apakah token ada dan belum memilih
        if (!$pemilih) {
            return Redirect::back()->with('error', 'Token tidak ditemukan.');
        }

        if ($pemilih->sudah_memilih) {
            return Redirect::back()->with('error', 'Anda sudah menggunakan token ini.');
        }

        // Simpan pemilih_id di session
        Session::put('pemilih_id', $pemilih->id);

        return Redirect::route('public.pilih');
    }

    // Halaman pemilihan kandidat
    public function showPilihKandidat()
    {
        // Pastikan pemilih_id ada di session
        if (!Session::has('pemilih_id')) {
            return Redirect::route('public.home')->with('error', 'Anda harus memasukkan token terlebih dahulu.');
        }

        $kandidat = Kandidat::all();

        return Inertia::render('Public/PilihKandidat', [
            'kandidat' => $kandidat,
        ]);
    }

    // Menyimpan suara dan mengakhiri sesi pemilihan
    public function storeSuara(Request $request)
    {
        $request->validate([
            'kandidat_id' => 'required|exists:kandidat,id',
        ]);

        $pemilihId = Session::get('pemilih_id');
        $pemilih = Pemilih::find($pemilihId);

        // Pastikan pemilih ada dan belum memilih
        if (!$pemilih || $pemilih->sudah_memilih) {
            return Redirect::route('public.home')->with('error', 'Terjadi kesalahan. Silakan coba lagi.');
        }

        // Simpan suara
        Suara::create([
            'pemilih_id' => $pemilih->id,
            'kandidat_id' => $request->kandidat_id,
        ]);

        // Update status pemilih
        $pemilih->update(['sudah_memilih' => true]);

        // Hapus session pemilih
        Session::forget('pemilih_id');

        return Redirect::route('public.home')->with('status', 'Terima kasih sudah memilih!');
    }
}