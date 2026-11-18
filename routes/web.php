<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PeminjamanWebController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::redirect('/', '/dashboard');
// Pengalihan dashboard berdasarkan role pengguna
Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    }

    if ($user->hasRole('petugas')) {
        return redirect()->route('petugas.dashboard');
    }

    if ($user->hasRole('siswa')) {
        return redirect()->route('siswa.dashboard');
    }

    abort(403, 'Anda tidak memiliki role yang sesuai.');
})->middleware('auth')->name('dashboard');

// ==========================================
// DASHBOARD ROLE-BASED
// ==========================================

// Dashboard Admin
Route::middleware([
    'auth',
    'role:admin',
    'permission:akses dashboard admin'
])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

// Dashboard Petugas
Route::middleware([
    'auth',
    'role:petugas',
    'permission:akses dashboard petugas'
])->group(function () {
    Route::get('/petugas/dashboard', function () {
        return view('petugas.dashboard');
    })->name('petugas.dashboard');
});

// Dashboard Siswa
Route::middleware(['auth', 'role:siswa'])->group(function () {
    Route::get('/siswa/dashboard', function () {
        return view('siswa.dashboard');
    })->name('siswa.dashboard');
});

// ==========================================
// DATA BUKU
// ==========================================

// Halaman daftar dan detail buku (Admin, Petugas, Siswa)
Route::middleware([
    'auth',
    'permission:lihat daftar buku'
])->group(function () {
    Route::get('/buku', [BukuController::class, 'index'])
        ->name('buku.index');

    Route::get('/buku/{id}', [BukuController::class, 'show'])
        ->name('buku.show');
});

// ==========================================
// KELOLA PENGGUNA & ROLE (KHUSUS ADMIN)
// ==========================================
Route::middleware([
    'auth',
    'role:admin',
    'permission:kelola data pengguna'
])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', UserController::class)->only(['index', 'store', 'update', 'destroy']);
});

// ==========================================
// KELOLA PEMINJAMAN & PENGEMBALIAN (ADMIN & PETUGAS)
// ==========================================
Route::middleware([
    'auth',
    'permission:kelola peminjaman'
])->group(function () {
    Route::get('/peminjaman', [PeminjamanWebController::class, 'index'])->name('peminjaman.index');

    Route::patch('/peminjaman/{id}/setujui', [PeminjamanWebController::class, 'setujui'])
        ->middleware('permission:memproses persetujuan peminjaman')->name('peminjaman.setujui');

    Route::patch('/peminjaman/{id}/tolak', [PeminjamanWebController::class, 'tolak'])
        ->middleware('permission:memproses persetujuan peminjaman')->name('peminjaman.tolak');

    Route::patch('/peminjaman/{id}/konfirmasi', [PeminjamanWebController::class, 'konfirmasiPengembalian'])
        ->middleware('permission:mencatat pengembalian buku')->name('peminjaman.konfirmasi');
});

// ==========================================
// RIWAYAT PEMINJAMAN SISWA
// ==========================================
Route::middleware([
    'auth',
    'permission:melihat riwayat peminjaman sendiri'
])->group(function () {
    Route::get('/peminjaman-saya', [PeminjamanWebController::class, 'indexSaya'])->name('peminjaman.saya');
    Route::post('/peminjaman-saya/kembalikan/{id}', [PeminjamanWebController::class, 'ajukanPengembalian'])->name('peminjaman.saya.kembalikan');
});

// ==========================================
// MODUL VI
// ==========================================
Route::middleware('auth')->group(function () {
    // A2 (SOAL 2b): query sudah memakai binding di BukuController::cari()
    Route::get('/buku-cari', [BukuController::class, 'cari'])->name('buku.cari');

    // A3 (SOAL 2c & SOAL 3): route DELETE diproteksi Gate can:kelola-buku
    Route::delete('/buku/{buku}', [BukuController::class, 'destroy'])
        ->middleware('can:kelola-buku')
        ->name('buku.destroy');

    // A4 (SOAL 4 akan menutup celah ini dengan Policy)
    Route::get('/peminjaman/{id}', [PeminjamanWebController::class, 'show'])->name('peminjaman.show');
});

// ==========================================
// LAPORAN PERPUSTAKAAN (ADMIN & PETUGAS)
// ==========================================
Route::middleware([
    'auth',
    'permission:lihat laporan perpustakaan'
])->group(function () {
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
});

// ==========================================
// PROFIL PENGGUNA
// ==========================================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    
});

// Route autentikasi Breeze
require __DIR__.'/auth.php';
Route::get('/diagnostic', function () {
    return response()->json([
        'status' => 'Laravel is running',
        'app' => app()->version(),
        'environment' => app()->environment(),
        'database' => config('database.default'),
    ]);
});