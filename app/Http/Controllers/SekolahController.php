<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;

class SekolahController extends Controller
{
    // Menampilkan halaman data sekolah
    public function index()
    {
        // Mencari data sekolah pertama, atau membuat instance baru jika belum ada
        $sekolah = Sekolah::firstOrNew();
        
        return Inertia::render('Admin/Sekolah/Index', [
            'sekolah' => $sekolah,
        ]);
    }

    // Memperbarui data sekolah
    public function update(Request $request)
    {
        $sekolah = Sekolah::firstOrNew();

        $validatedData = $request->validate([
            'npsn' => 'nullable|string|max:255',
            'nama_sekolah' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'nama_kepsek' => 'nullable|string|max:255',
            'nama_pembos' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            // Hapus logo lama jika ada
            if ($sekolah->logo) {
                Storage::disk('public')->delete($sekolah->logo);
            }
            // Simpan logo baru
            $validatedData['logo'] = $request->file('logo')->store('sekolah', 'public');
        }

        $sekolah->fill($validatedData)->save();

        Session::flash('success', 'Data sekolah berhasil diperbarui!');
        return redirect()->back();
    }
}