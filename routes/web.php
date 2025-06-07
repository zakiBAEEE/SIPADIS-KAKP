<?php

use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\AgendaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DisposisiController;
use App\Http\Controllers\LembagaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TimKerjaController;
use App\Http\Controllers\Auth\AuthenticatedSessionController; // <--- TAMBAHKAN IMPORT INI



// Rute-rute yang HANYA BISA DIAKSES SETELAH LOGIN
Route::middleware(['auth'])->group(function () {
    Route::get('/', [SuratMasukController::class, 'dashboard'])->name('surat.home');

    // Surat Masuk
    Route::get('/surat-masuk-disposisi', [SuratMasukController::class, 'suratDenganDisposisi'])->name('surat.denganDisposisi');

    Route::get('/surat-masuk-tanpa-disposisi', [SuratMasukController::class, 'suratTanpaDisposisi'])->name('surat.tanpaDisposisi');

    Route::get('/surat-masuk/{id}', [SuratMasukController::class, 'show'])->name('surat.show');

    Route::get('/surat-masuk-tambah', [SuratMasukController::class, 'add'])->name('surat.tambah');

    Route::delete('/surat-masuk/{surat}', [SuratMasukController::class, 'destroy'])->name('surat.destroy');

    Route::post('/surat-masuk', [SuratMasukController::class, 'store'])->name('surat.store');
    Route::get('/surat-masuk/{surat}/edit', [SuratMasukController::class, 'edit'])->name('surat.edit');
    Route::post('/surat-masuk/{surat}', [SuratMasukController::class, 'update'])->name('surat.update');
    Route::get('/surat/klasifikasi', [SuratMasukController::class, 'detailByKlasifikasi'])->name('surat.klasifikasi');

    Route::get('/agenda-kbu', [AgendaController::class, 'agendaKbu'])->name('surat.agendaKbu');
    Route::get('/agenda-kepala', [AgendaController::class, 'agendaKepala'])->name('surat.agendaKepala');
    Route::get('/print-agenda-kbu', [AgendaController::class, 'printAgendaKbu'])->name('surat.printAgendaKbu');
    Route::get('/print-agenda-kepala', [AgendaController::class, 'printAgendaKepala'])->name('surat.printAgendaKepala');

    // Lembaga
    Route::get('/lembaga', [LembagaController::class, 'index'])->name('lembaga.index');
    Route::get('/lembaga/edit', [LembagaController::class, 'edit'])->name('lembaga.edit');
    Route::post('/lembaga/update', [LembagaController::class, 'update'])->name('lembaga.update');

    // Pegawai
    Route::get('/pegawai', [UserController::class, 'index'])->name('pegawai.index');
    Route::post('/pegawai', [UserController::class, 'store'])->name('pegawai.store');
    Route::get('/pegawai/{user}/edit', [UserController::class, 'edit'])->name('pegawai.edit');
    Route::put('/pegawai/{user}', [UserController::class, 'update'])->name('pegawai.update');
    Route::delete('/pegawai/{user}', [UserController::class, 'destroy'])->name('pegawai.destroy');

    // Tim Kerja
    Route::get('/tim-kerja', [TimKerjaController::class, 'index'])->name('timKerja.index');
    Route::post('/tim-kerja', [TimKerjaController::class, 'store'])->name('timKerja.store');
    Route::post('/tim-kerja/{id}/edit', [TimKerjaController::class, 'update'])->name('timKerja.update'); // Seharusnya PUT atau PATCH jika mengikuti RESTful
    Route::delete('/tim-kerja/{id}', [TimKerjaController::class, 'destroy'])->name('tim-kerja.destroy');

    // Disposisi
    Route::post('/surat-masuk/{suratId}/disposisi', [DisposisiController::class, 'store'])->name('disposisi.store');
    Route::get('/disposisi/{id}/cetak', [DisposisiController::class, 'cetak'])->name('disposisi.cetak');
    // Route::get('/disposisi/{disposisi}/edit', [DisposisiController::class, 'edit'])->name('disposisi.edit');
    Route::put('/disposisi/{disposisi}', [DisposisiController::class, 'update'])->name('disposisi.update');
    Route::delete('/disposisi/{disposisi}', [DisposisiController::class, 'destroy'])->name('disposisi.destroy');

});


require __DIR__ . '/auth.php';