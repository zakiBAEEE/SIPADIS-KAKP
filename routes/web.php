<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\DisposisiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TimKerjaController;
use App\Http\Controllers\LembagaController;
use App\Http\Controllers\InboxController;
use App\Http\Controllers\AgendaController;

/*
|--------------------------------------------------------------------------
| Rute Publik & Autentikasi
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';


/*
|--------------------------------------------------------------------------
| Rute Aplikasi Inti (Wajib Login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // == HALAMAN UTAMA / DASHBOARD (Umum untuk Admin) ==
    Route::get('/', [SuratMasukController::class, 'dashboard'])->name('surat.home');

    // == RUTE UMUM (Bisa diakses oleh semua peran yang sudah login) ==
    Route::get('/surat-masuk/{surat}', [SuratMasukController::class, 'show'])->name('surat.show');


    // =====================================================================
    // == GRUP RUTE KHUSUS ADMIN (Nama peran sudah diperbaiki) ==
    // =====================================================================
    Route::middleware(['role:Super Admin,Admin'])->group(function () {

        // Daftar Surat Masuk (versi Admin)
        Route::get('/surat-masuk-disposisi', [SuratMasukController::class, 'suratDenganDisposisi'])->name('surat.denganDisposisi');
        Route::get('/surat-masuk-tanpa-disposisi', [SuratMasukController::class, 'suratTanpaDisposisi'])->name('surat.tanpaDisposisi');

        // CRUD Surat Masuk
        Route::get('/surat-masuk-tambah', [SuratMasukController::class, 'add'])->name('surat.tambah');
        Route::post('/surat-masuk', [SuratMasukController::class, 'store'])->name('surat.store');
        Route::get('/surat-masuk/{surat}/edit', [SuratMasukController::class, 'edit'])->name('surat.edit');
        Route::post('/surat-masuk/{surat}', [SuratMasukController::class, 'update'])->name('surat.update');
        Route::delete('/surat-masuk/{surat}', [SuratMasukController::class, 'destroy'])->name('surat.destroy');
        Route::post('/surat-masuk/{surat}/kirim-ke-kepala', [SuratMasukController::class, 'kirimKeKepala'])->name('surat.kirimKeKepala');

        // Laporan & Lainnya
        Route::get('/surat/klasifikasi', [SuratMasukController::class, 'detailByKlasifikasi'])->name('surat.klasifikasi');

        // Manajemen Pegawai (User)
        Route::get('/pegawai', [UserController::class, 'index'])->name('pegawai.index');
        Route::post('/pegawai', [UserController::class, 'store'])->name('pegawai.store');
        Route::get('/pegawai/{user}/edit', [UserController::class, 'edit'])->name('pegawai.edit');
        Route::put('/pegawai/{user}', [UserController::class, 'update'])->name('pegawai.update');
        Route::delete('/pegawai/{user}', [UserController::class, 'destroy'])->name('pegawai.destroy');

        // Manajemen Tim Kerja & Lembaga
        Route::get('/tim-kerja', [TimKerjaController::class, 'index'])->name('timKerja.index');
        Route::post('/tim-kerja', [TimKerjaController::class, 'store'])->name('timKerja.store');
        Route::post('/tim-kerja/{id}/edit', [TimKerjaController::class, 'update'])->name('timKerja.update');
        Route::delete('/tim-kerja/{id}', [TimKerjaController::class, 'destroy'])->name('tim-kerja.destroy');

        Route::get('/lembaga', [LembagaController::class, 'index'])->name('lembaga.index');
        Route::get('/lembaga/edit', [LembagaController::class, 'edit'])->name('lembaga.edit');
        Route::post('/lembaga/update', [LembagaController::class, 'update'])->name('lembaga.update');

        // Disposisi ke kepala
        Route::post('/surat-masuk/{surat}/kirim-ke-kepala', [App\Http\Controllers\SuratMasukController::class, 'kirimKeKepala'])->name('surat.kirimKeKepala');
        Route::get('/disposisi/{id}/cetak', [DisposisiController::class, 'cetak'])->name('disposisi.cetak');

    });


    // =====================================================================
    // == GRUP RUTE ALUR KERJA (Pimpinan & Pelaksana) ==
    // =====================================================================
    Route::middleware(['role:Kepala LLDIKTI,KBU,Katimja,Staf'])->group(function () {

        Route::get('/inbox', [InboxController::class, 'index'])->name('inbox.index');
        Route::post('/disposisi/{disposisi}/kembalikan', [DisposisiController::class, 'kembalikan'])->name('disposisi.kembalikan');
        Route::get('/outbox', [InboxController::class, 'outbox'])->name('outbox.index');
    });

    // =====================================================================
    // == GRUP RUTE AKSI DISPOSISI (Yang bisa melakukan disposisi) ==
    // =====================================================================
    // Admin juga bisa melakukan disposisi (manual), jadi kita tambahkan di sini
    Route::middleware(['role:Super Admin,Admin,Kepala LLDIKTI,KBU,Katimja'])->group(function () {
        Route::post('/surat-masuk/{surat}/disposisi', [DisposisiController::class, 'store'])->name('disposisi.store');
        Route::put('/disposisi/{disposisi}', [DisposisiController::class, 'update'])->name('disposisi.update');
        Route::delete('/disposisi/{disposisi}', [DisposisiController::class, 'destroy'])->name('disposisi.destroy');
    });

    // =====================================================================
    // == GRUP RUTE KHUSUS AGENDA & CETAK (Admin ditambahkan) ==
    // =====================================================================
    Route::middleware(['role:Kepala,KBU,Super Admin,Admin'])->group(function () {
        Route::get('/agenda-kbu', [AgendaController::class, 'agendaKbu'])->name('surat.agendaKbu');
        Route::get('/agenda-kepala', [AgendaController::class, 'agendaKepala'])->name('surat.agendaKepala');
        Route::get('/print-agenda-kbu', [AgendaController::class, 'printAgendaKbu'])->name('surat.printAgendaKbu');
        Route::get('/print-agenda-kepala', [AgendaController::class, 'printAgendaKepala'])->name('surat.printAgendaKepala');
    });

});