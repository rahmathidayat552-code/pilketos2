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

// admin login/logout
Route::get('/admin/login', [AdminController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login']);
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

// admin area
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
    // Route::resource('/admin/kandidat', KandidatController::class)->names('kandidat');
    Route::resource('/admin/kandidat', KandidatController::class)->except(['show']);

    // pemilih (tanpa show, biar tidak bentrok)
    Route::get('/admin/pemilih/import', [PemilihController::class, 'importForm'])->name('pemilih.import.form');
    Route::post('/admin/pemilih/import', [PemilihController::class, 'import'])->name('pemilih.import');
    Route::get('/admin/pemilih/export', [PemilihController::class, 'export'])->name('pemilih.export');
    Route::resource('/admin/pemilih', PemilihController::class)->except(['show']);

    // user management
    Route::resource('/admin/users', UserController::class);
});

// kandidat list for public

// default laravel
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
