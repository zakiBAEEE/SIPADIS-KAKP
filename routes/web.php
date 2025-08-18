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
    Route::prefix('surat')->name('surat.')->group(function () {
        Route::get('inbox', [InboxController::class, 'index'])->name('inbox');
        Route::middleware(['role:Admin,Kepala LLDIKTI,KBU,Katimja'])->group(function () {
            Route::get('ditolak', [InboxController::class, 'ditolak'])->name('ditolak');
            Route::get('terkirim', [SuratMasukController::class, 'suratTerkirim'])->name('terkirim');
        });
        Route::middleware(['role:Staf'])->group(function () {
            Route::post('{surat}/tandai-selesai', [DisposisiController::class, 'tandaiSelesai'])->name('tandaiSelesai');
            Route::post('{surat}/tandai-ditindaklanjuti', [DisposisiController::class, 'tandaiDitindaklanjuti'])->name('tandaiDitindaklanjuti');
            Route::post('{surat}/tandai-ditolak', [DisposisiController::class, 'tandaiDitolak'])->name('tandaiDitolak');
        });
        Route::middleware(['role:Admin'])->group(function () {
            Route::get('/draft', [SuratMasukController::class, 'suratMasukDraft'])->name('draft');
            Route::get('tambah', [SuratMasukController::class, 'add'])->name('tambah');
            Route::post('/', [SuratMasukController::class, 'store'])->name('store');
            Route::get('{surat}/edit', [SuratMasukController::class, 'edit'])->name('edit');
            Route::put('{surat}', [SuratMasukController::class, 'update'])->name('update');
            Route::delete('{surat}', [SuratMasukController::class, 'destroy'])->name('destroy');
        });
        Route::get('{surat}', [SuratMasukController::class, 'show'])->name('show');
    });

    Route::middleware(['role:Admin'])->group(function () {
        Route::prefix('rekapitulasi')->name('rekapitulasi.')->group(function () {
            Route::get('/', [RekapitulasiController::class, 'rekapitulasi'])->name('index');
            Route::get('export', [RekapitulasiController::class, 'rekapitulasiExport'])->name('export');
        });
        Route::prefix('pegawai')->name('pegawai.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::post('/store', [UserController::class, 'store'])->name('store');
            Route::get('/pegawai/{user}/edit', [UserController::class, 'edit'])->name('edit');
            Route::put('{user}', [UserController::class, 'update'])->name('update');
            Route::delete('{user}', [UserController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('tim-kerja')->name('tim-kerja.')->group(function () {
            Route::get('/', [TimKerjaController::class, 'index'])->name('index');
            Route::post('/store', [TimKerjaController::class, 'store'])->name('store');
            Route::put('{id}', [TimKerjaController::class, 'update'])->name('update');
            Route::delete('{id}', [TimKerjaController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('lembaga')->name('lembaga.')->group(function () {
            Route::get('/', [LembagaController::class, 'index'])->name('index');
            Route::get('edit', [LembagaController::class, 'edit'])->name('edit');
            Route::put('update', [LembagaController::class, 'update'])->name('update');
        });
    });

    Route::prefix('disposisi')->name('disposisi.')->group(function () {
        Route::post('{disposisi}/kembalikan', [DisposisiController::class, 'kembalikan'])->name('kembalikan');
        Route::post('{surat}/kirim-ke-kepala', [DisposisiController::class, 'kirimKeKepala'])->name('kirimKeKepala');
        Route::post('{disposisi}/kembalikanKeKatimja', [DisposisiController::class, 'kembalikanSuratStaf'])
            ->name('kembalikanSuratStaf');
        Route::post('{surat}/disposisiSemuaStaf', [DisposisiController::class, 'disposisiKeSemuaStaf'])->name('disposisiSemuaStaf');
        Route::post('{surat}/disposisi', [DisposisiController::class, 'store'])->name('store');
        Route::get('{id}/cetak', [DisposisiController::class, 'cetak'])->name('cetak');
    });

    Route::middleware(['role:Admin,Kepala LLDIKTI,KBU,Katimja,Staf'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/logbook-pegawai', [LogbookPegawaiController::class, 'index'])->name('logbook.pegawai');
    });

});
