<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kandidat;
use Illuminate\Support\Facades\Storage;

class KandidatController extends Controller
{
    // daftar kandidat
    public function index()
    {
       $kandidat = Kandidat::all();
    return inertia('Admin/Kandidat/Index', [
        'kandidat' => $kandidat
        ]);
    }

    // simpan kandidat baru
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_ketua' => 'required|string|max:100',
            'nama_wakil' => 'required|string|max:100',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'visi' => 'nullable|string',
            'misi' => 'nullable|string',
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('kandidat', 'public');
        }

        Kandidat::create($data);

        return redirect()->route('kandidat.index')
            ->with('success', 'Kandidat berhasil ditambahkan.');
    }

    // update kandidat


public function update(Request $request, Kandidat $kandidat)
{
    $data = $request->validate([
        'nama_ketua' => 'required|string|max:100',
        'nama_wakil' => 'required|string|max:100',
        'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        'visi' => 'nullable|string',
        'misi' => 'nullable|string',
    ]);

    // kalau tidak ada foto baru, jangan hapus yang lama
    if ($request->hasFile('foto')) {
        $data['foto'] = $request->file('foto')->store('kandidat', 'public');
    } else {
        unset($data['foto']); // penting, supaya tidak jadi NULL
    }

    $kandidat->update($data);

    return back()->with('success', 'Kandidat berhasil diperbarui.');
}

    // hapus kandidat
    public function destroy(Kandidat $kandidat)
    {
        if ($kandidat->foto) {
            Storage::disk('public')->delete($kandidat->foto);
        }

        $kandidat->delete();

        return redirect()->route('kandidat.index')
            ->with('success', 'Kandidat berhasil dihapus.');
    }
}
