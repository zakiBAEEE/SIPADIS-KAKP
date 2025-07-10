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


require __DIR__ . '/auth.php';


Route::middleware(['auth', 'cekAktif'])->group(function () {



    Route::get('/surat-masuk/{surat}', [SuratMasukController::class, 'show'])->name('surat.show');


    Route::middleware(['role:Admin'])->group(function () {

        Route::get('/', [SuratMasukController::class, 'dashboard'])->name('surat.home');

        // ---- Manajemen Surat Masuk ----
        Route::get('/surat-masuk-draft', [SuratMasukController::class, 'suratMasukDraft'])->name('surat.draft');
        Route::get('/surat-masuk-tambah', [SuratMasukController::class, 'add'])->name('surat.tambah');
        Route::post('/surat-masuk', [SuratMasukController::class, 'store'])->name('surat.store');
        Route::get('/surat-masuk/{surat}/edit', [SuratMasukController::class, 'edit'])->name('surat.edit');
        Route::post('/surat-masuk/{surat}', [SuratMasukController::class, 'update'])->name('surat.update');
        Route::delete('/surat-masuk/{surat}', [SuratMasukController::class, 'destroy'])->name('surat.destroy');
        Route::post('/surat-masuk/{surat}/kirim-ke-kepala', [DisposisiController::class, 'kirimKeKepala'])->name('surat.kirimKeKepala');
        Route::post('/surat-masuk/{surat}/kirim-ulang-ke-kepala', [DisposisiController::class, 'kirimUlangKeKepala'])->name('surat.kirimUlangKeKepala');
        Route::get('/surat/klasifikasi', [SuratMasukController::class, 'detailByKlasifikasi'])->name('surat.klasifikasi');
        Route::get('/arsip-surat', [SuratMasukController::class, 'arsipSurat'])->name('surat.arsip');


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


    Route::middleware(['role:Kepala LLDIKTI,KBU,Katimja,Staf'])->group(function () {
        Route::get('/inbox', [InboxController::class, 'index'])->name('inbox.index');
        Route::post('/disposisi/{disposisi}/kembalikan', [DisposisiController::class, 'kembalikan'])->name('disposisi.kembalikan');
    });

    Route::middleware(['role:Staf'])->group(function () {
        Route::post('/disposisi/{disposisi}/kembalikanKeKatimja', [DisposisiController::class, 'kembalikanSuratStaf'])
            ->name('disposisi.kembalikanSuratStaf');
    });

    Route::middleware(['role:Katimja'])->group(function () {
        Route::post('/disposisi/{surat}/disposisiSemuaStaf', [DisposisiController::class, 'disposisiKeSemuaStaf'])->name('disposisi.disposisiSemuaStaf');

    });


    Route::middleware(['role:Admin,Kepala LLDIKTI,KBU,Katimja,Staf'])->group(function () {
        Route::get('/outbox', [InboxController::class, 'outbox'])->name('outbox.index');
        Route::get('/inbox/ditolak', [InboxController::class, 'ditolak'])->name('inbox.ditolak');
    });


    Route::middleware(['role:Super Admin,Admin,Kepala LLDIKTI,KBU,Katimja'])->group(function () {
        Route::post('/surat-masuk/{surat}/disposisi', [DisposisiController::class, 'store'])->name('disposisi.store');
        Route::get('/disposisi/{id}/cetak', [DisposisiController::class, 'cetak'])->name('disposisi.cetak');
    });

    Route::middleware(['role:Kepala,KBU,Super Admin,Admin'])->group(function () {
        Route::get('/agenda-kbu', [AgendaController::class, 'agendaKbu'])->name('surat.agendaKbu');
        Route::get('/agenda-kepala', [AgendaController::class, 'agendaKepala'])->name('surat.agendaKepala');
        Route::get('/print-agenda-kbu', [AgendaController::class, 'printAgendaKbu'])->name('surat.printAgendaKbu');
        Route::get('/print-agenda-kepala', [AgendaController::class, 'printAgendaKepala'])->name('surat.printAgendaKepala');
    });

});
