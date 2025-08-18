<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemilih;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PemilihImport;
use App\Exports\PemilihExport;

class PemilihController extends Controller
{
    // EXPORT ke Excel
    public function export()
{
    return Excel::download(new PemilihExport, 'data_pemilih.xlsx');
}

    // Tambah data pemilih
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:100',
            'jenis' => 'required|string',
        ]);

        // generate token otomatis 5 huruf kapital
        $data['token'] = strtoupper(Str::random(5));

        Pemilih::create($data);

        return redirect()->route('pemilih.index')
            ->with('success', 'Pemilih berhasil ditambahkan.');
    }

    // Daftar pemilih (pencarian & pagination)
    public function index(Request $request)
    {
        $query = Pemilih::query();

        // pencarian nama / token
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%$search%")
                  ->orWhere('token', 'like', "%$search%");
            });
        }

        // default 15, bisa pilih 20, 50, atau all
        $perPage = $request->get('per_page', 15);

        if ($perPage === 'all') {
            $pemilih = $query->orderBy('id', 'desc')->get();
        } else {
            $pemilih = $query->orderBy('id', 'desc')
                             ->paginate((int) $perPage)
                             ->withQueryString();
        }

        return inertia('Admin/Pemilih/Index', [
            'pemilih' => $pemilih,
            'filters' => $request->only(['search', 'per_page']),
        ]);
    }

    // Update data pemilih
    public function update(Request $request, Pemilih $pemilih)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:100',
            'jenis' => 'required|string',
        ]);

        $pemilih->update($data);

        return redirect()->route('pemilih.index')
            ->with('success', 'Data berhasil diperbarui.');
    }

    // Hapus pemilih
    public function destroy(Pemilih $pemilih)
    {
        $pemilih->delete();

        return redirect()->route('pemilih.index')
            ->with('success', 'Data berhasil dihapus.');
    }

    // Halaman form upload
    public function importForm()
    {
        return inertia('Admin/Pemilih/Import');
    }

    // Proses upload excel
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        Excel::import(new PemilihImport, $request->file('file'));

        return redirect()->route('pemilih.index')
            ->with('success', 'Data pemilih berhasil diimport.');
    }
}
