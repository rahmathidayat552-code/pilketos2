<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KandidatController;
use App\Http\Controllers\PemilihController;
use App\Models\Pemilih;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HasilSuaraController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\SekolahController;

// admin login/logout
Route::get('/admin/login', [AdminController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login']);
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

// admin area (Semua rute di sini hanya bisa diakses oleh admin)
Route::middleware('auth:admin')->group(function () {

    // dashboard
    Route::get('/admin/dashboard', function () {
        $jumlahPemilih = Pemilih::count();
        $sudahMemilih = Pemilih::where('sudah_memilih', true)->count();
        $belumMemilih = Pemilih::where('sudah_memilih', false)->count();

        return Inertia::render('Admin/Dashboard', [
            'jumlahPemilih' => $jumlahPemilih,
            'sudahMemilih' => $sudahMemilih,
            'belumMemilih' => $belumMemilih,
        ]);
    })->name('admin.dashboard');

    // kandidat
    Route::resource('/admin/kandidat', KandidatController::class)->except(['show']);

    // pemilih
    Route::get('/admin/pemilih/import', [PemilihController::class, 'importForm'])->name('pemilih.import.form');
    Route::post('/admin/pemilih/import', [PemilihController::class, 'import'])->name('pemilih.import');
    Route::get('/admin/pemilih/export', [PemilihController::class, 'export'])->name('pemilih.export');
    Route::resource('/admin/pemilih', PemilihController::class)->except(['show']);

    // HASIL SUARA
    Route::get('/admin/rekap', [HasilSuaraController::class, 'index'])->name('rekap.index');
   
    // manajemen pengguna
    Route::resource('/admin/users', UserController::class);

    // Identitas Sekolah
    Route::get('/admin/sekolah', [SekolahController::class, 'index'])->name('sekolah.index');
    Route::post('/admin/sekolah/update', [SekolahController::class, 'update'])->name('sekolah.update');
});

//PUBLIC
// Halaman Public untuk pemilihan
Route::get('/', [PublicController::class, 'showInputToken'])->name('public.home');
Route::post('/vote', [PublicController::class, 'submitToken'])->name('public.submit');
Route::get('/pilih-kandidat', [PublicController::class, 'showPilihKandidat'])->name('public.pilih');
Route::post('/pilih-kandidat', [PublicController::class, 'storeSuara'])->name('public.store-suara');


// default laravel
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';