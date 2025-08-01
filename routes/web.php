<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LogbookPegawai;
use App\Http\Controllers\RekapitulasiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\DisposisiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TimKerjaController;
use App\Http\Controllers\LembagaController;
use App\Http\Controllers\InboxController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\LogbookPegawaiController;


require __DIR__ . '/auth.php';



Route::middleware(['auth', 'cekAktif'])->group(function () {



    Route::get('/surat-masuk/{surat}', [SuratMasukController::class, 'show'])->name('surat.show');


    Route::middleware(['role:Admin'])->group(function () {

       
        Route::get('/rekapitulasi/export', [RekapitulasiController::class, 'rekapitulasiExport'])->name('rekapitulasi.export');


        // ---- Manajemen Surat Masuk ----
        Route::get('/surat-masuk-draft', [SuratMasukController::class, 'suratMasukDraft'])->name('surat.draft');
        Route::get('/surat-masuk-tambah', [SuratMasukController::class, 'add'])->name('surat.tambah');
        Route::post('/surat-masuk', [SuratMasukController::class, 'store'])->name('surat.store');
        Route::get('/surat-masuk/{surat}/edit', [SuratMasukController::class, 'edit'])->name('surat.edit');
        Route::post('/surat-masuk/{surat}', [SuratMasukController::class, 'update'])->name('surat.update');
        Route::delete('/surat-masuk/{surat}', [SuratMasukController::class, 'destroy'])->name('surat.destroy');
        Route::post('/surat-masuk/{surat}/kirim-ke-kepala', [DisposisiController::class, 'kirimKeKepala'])->name('surat.kirimKeKepala');
        

        Route::get('/rekapitulasi', [RekapitulasiController::class, 'rekapitulasi'])->name('rekapitulasi');


        // ---- Manajemen Pegawai ----
        Route::get('/pegawai', [UserController::class, 'index'])->name('pegawai.index');
        Route::post('/pegawai', [UserController::class, 'store'])->name('pegawai.store');
        Route::get('/pegawai/{user}/edit', [UserController::class, 'edit'])->name('pegawai.edit');
        Route::post('/pegawai/{user}', [UserController::class, 'update'])->name('pegawai.update');
        Route::delete('/pegawai/{user}', [UserController::class, 'destroy'])->name('pegawai.destroy');

        // ---- Tim Kerja & Lembaga ----
        Route::get('/tim-kerja', [TimKerjaController::class, 'index'])->name('timKerja.index');
        Route::post('/tim-kerja', [TimKerjaController::class, 'store'])->name('timKerja.store');
        Route::post('/tim-kerja/{id}/edit', [TimKerjaController::class, 'update'])->name('timKerja.update');
        Route::delete('/tim-kerja/{id}', [TimKerjaController::class, 'destroy'])->name('tim-kerja.destroy');

        Route::get('/lembaga', [LembagaController::class, 'index'])->name('lembaga.index');
        Route::get('/lembaga/edit', [LembagaController::class, 'edit'])->name('lembaga.edit');
        Route::post('/lembaga/update', [LembagaController::class, 'update'])->name('lembaga.update');
    });

    Route::middleware(['role:Admin,Kepala LLDIKTI,KBU,Katimja'])->group(function () {
        Route::get('/surat-terkirim', [SuratMasukController::class, 'suratTerkirim'])->name('surat.terkirim');

    });


    Route::middleware(['role:Kepala LLDIKTI,KBU,Katimja,Staf'])->group(function () {
        Route::get('/inbox', [InboxController::class, 'index'])->name('inbox.index');
        Route::post('/disposisi/{disposisi}/kembalikan', [DisposisiController::class, 'kembalikan'])->name('disposisi.kembalikan');
    });

    Route::middleware(['role:Staf'])->group(function () {
        Route::post('/disposisi/{disposisi}/kembalikanKeKatimja', [DisposisiController::class, 'kembalikanSuratStaf'])
            ->name('disposisi.kembalikanSuratStaf');

        Route::post('/surat/{surat}/tandai-selesai', [DisposisiController::class, 'tandaiSelesai'])->name('surat.tandaiSelesai');
        Route::post('/surat/{surat}/tandai-ditindaklanjuti', [DisposisiController::class, 'tandaiDitindaklanjuti'])->name('surat.tandaiDitindaklanjuti');
        Route::post('/surat/{surat}/tandai-ditolak', [DisposisiController::class, 'tandaiDitolak'])->name('surat.tandaiDitolak');

    });

    Route::middleware(['role:Katimja'])->group(function () {
        Route::post('/disposisi/{surat}/disposisiSemuaStaf', [DisposisiController::class, 'disposisiKeSemuaStaf'])->name('disposisi.disposisiSemuaStaf');
    });


    Route::middleware(['role:Admin,Kepala LLDIKTI,KBU,Katimja,Staf'])->group(function () {
        Route::get('/inbox/ditolak', [InboxController::class, 'ditolak'])->name('inbox.ditolak');
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/logbook-pegawai', [LogbookPegawaiController::class, 'index'])->name('logbook.pegawai');
    });


    Route::middleware(['role:Admin,Kepala LLDIKTI,KBU,Katimja'])->group(function () {
        Route::post('/surat-masuk/{surat}/disposisi', [DisposisiController::class, 'store'])->name('disposisi.store');
        Route::get('/disposisi/{id}/cetak', [DisposisiController::class, 'cetak'])->name('disposisi.cetak');
    });

});
