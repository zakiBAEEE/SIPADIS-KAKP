<?php

namespace App\Services;

use App\Models\SuratMasuk;
use App\Models\Disposisi;
use App\Models\User;

class DisposisiService
{
    /**
     * Membuat record disposisi baru.
     * Ini adalah satu-satunya "sumber kebenaran" untuk logika pembuatan disposisi.
     *
     * @param SuratMasuk $surat
     * @param User $pengirim
     * @param User $penerima
     * @param string|null $catatan
     * @param string|null $tanggal
     * @return Disposisi
     */
    public function create(SuratMasuk $surat, User $pengirim, User $penerima, ?string $catatan, ?string $tanggal): Disposisi
    {
        // Logika inti untuk membuat disposisi
        $disposisi = Disposisi::create([
            'surat_id' => $surat->id,
            'dari_user_id' => $pengirim->id,
            'ke_user_id' => $penerima->id,
            'catatan' => $catatan,
            'tanggal_disposisi' => $tanggal ?? now(),
            'status' => 'Terkirim',
        ]);

        // Setelah disposisi dibuat, update status surat menjadi 'Diproses'
        $surat->update(['status' => 'Diproses']);

        return $disposisi;
    }

    public function tandaiSebagaiDilihat(SuratMasuk $surat, User $currentUser): void
    {
        $adminRoles = ['Super Admin', 'Admin'];
        if (in_array($currentUser->role->name, $adminRoles)) {
            return; // Hentikan fungsi jika yang membuka adalah Admin
        }

        $disposisi = $surat->disposisis()
            ->where('ke_user_id', $currentUser->id)
            ->where('status', 'Terkirim')
            ->first();

        if ($disposisi) {
            $disposisi->update(['status' => 'Dilihat']);
        }
    }

    public function forward(SuratMasuk $surat, User $pengirim, User $penerima, array $data): Disposisi
    {
        // 1. Cari disposisi SEBELUMNYA yang ditujukan ke pengirim saat ini
        $previousDisposisi = $surat->disposisis()
            ->where('ke_user_id', $pengirim->id)
            ->whereIn('status', ['Terkirim', 'Dilihat'])
            ->first();

        // 2. Jika ada, ubah statusnya menjadi 'Diteruskan'
        if ($previousDisposisi) {
            $previousDisposisi->update(['status' => 'Diteruskan']);
        }

        // 3. Buat record disposisi BARU
        $newDisposisi = Disposisi::create([
            'surat_id' => $surat->id,
            'dari_user_id' => $pengirim->id,
            'ke_user_id' => $penerima->id,
            'catatan' => $data['catatan'],
            'tanggal_disposisi' => $data['tanggal_disposisi'],
            'status' => 'Terkirim',
        ]);

        // 4. Pastikan status surat adalah 'Diproses'
        if ($surat->status !== 'Diproses') {
            $surat->update(['status' => 'Diproses']);
        }

        return $newDisposisi;
    }

    // Metode create() yang lebih sederhana bisa kita hapus atau buat private
    // jika semua pembuatan disposisi akan melalui metode yang lebih spesifik seperti forward().
}