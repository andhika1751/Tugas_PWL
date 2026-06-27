<?php

use App\Http\Controllers\DosenController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MatakuliahController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\KrsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {

    // Dashboard statistic (beda tampilan untuk admin & mahasiswa)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile (bawaan Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | KHUSUS ADMIN: kelola semua data master
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin')->group(function () {
        Route::resource('dosen',      DosenController::class);
        Route::resource('mahasiswa',  MahasiswaController::class);
        Route::resource('matakuliah', MatakuliahController::class);
        Route::resource('jadwal', JadwalController::class)->except(['index', 'show']);
    });

    /*
    |--------------------------------------------------------------------------
    | ADMIN & MAHASISWA: lihat jadwal
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin,mahasiswa')->group(function () {
        Route::resource('jadwal', JadwalController::class)->only(['index', 'show']);
    });

    /*
    |--------------------------------------------------------------------------
    | ADMIN & MAHASISWA: KRS
    | - index, create, store, show, destroy bisa diakses keduanya
    |   (logic & batasan kepemilikan/role diatur di dalam KrsController)
    | - edit & update khusus Admin (dicek manual di controller, supaya
    |   tidak perlu bikin grup/route terpisah)
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin,mahasiswa')->group(function () {
        Route::resource('krs', KrsController::class)
             ->only(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']);

        Route::get('/krs-export/pdf',   [KrsController::class, 'exportPdf'])->name('krs.export.pdf');
        Route::get('/krs-export/excel', [KrsController::class, 'exportExcel'])->name('krs.export.excel');
    });
});

require __DIR__.'/auth.php';
