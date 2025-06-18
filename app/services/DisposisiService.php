<?php

namespace App\Services;

use App\Models\SuratMasuk;
use App\Models\Disposisi;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
    public function create(SuratMasuk $surat, User $pengirim, User $penerima, ?string $catatan, ?string $tanggal, string $tipeAksi): Disposisi
    {
        // Logika inti untuk membuat disposisi
        $disposisi = Disposisi::create([
            'surat_id' => $surat->id,
            'dari_user_id' => $pengirim->id,
            'ke_user_id' => $penerima->id,
            'catatan' => $catatan,
            'tanggal_disposisi' => $tanggal ?? now(),
            'status' => 'Menunggu',
            'tipe_aksi' => $tipeAksi
        ]);

        // Setelah disposisi dibuat, update status surat menjadi 'Diproses'
        $surat->update(['status' => 'Diproses']);

        return $disposisi;
    }

    public function tandaiSebagaiDilihat(SuratMasuk $surat, User $currentUser): void
    {
        $adminRoles = ['Super Admin'];
        if (in_array($currentUser->role->name, $adminRoles)) {
            return; // Hentikan fungsi jika yang membuka adalah Admin
        }

        $disposisi = $surat->disposisis()
            ->where('ke_user_id', $currentUser->id)
            ->where('status', 'Menunggu')
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
            ->whereIn('status', ['Menunggu', 'Dilihat'])
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
            'status' => 'Menunggu',
        ]);

        // 4. Pastikan status surat adalah 'Diproses'
        if ($surat->status !== 'Diproses') {
            $surat->update(['status' => 'Diproses']);
        }

        return $newDisposisi;
    }

    public function kembalikan(Disposisi $disposisi, string $catatanPengembalian)
    {
        DB::transaction(function () use ($disposisi, $catatanPengembalian) {
            // 1. Update status disposisi yang ditolak menjadi 'Dikembalikan'
            $disposisi->update(['status' => 'Dikembalikan']);

            // 2. Buat disposisi baru dengan tipe 'kembalikan' ke arah sebaliknya
            $this->create(
                $disposisi->suratMasuk,
                Auth::user(),
                User::find($disposisi->pengirim()), // ← FIXED
                $catatanPengembalian,
                now(),
                'kembalikan'
            );


            // 3. Update status surat utama menjadi 'Dikembalikan' agar mudah difilter
            $disposisi->suratMasuk->update(['status' => 'Dikembalikan']);
        });
    }


    public function kirimUlangKeKepala(SuratMasuk $surat, User $pengirim, User $penerima, string $catatan)
    {
        DB::transaction(function () use ($surat, $pengirim, $penerima, $catatan) {
            // 1. Cari dan tutup tugas revisi yang aktif untuk pengirim (Admin)
            $rejectionTask = $surat->disposisis()
                ->where('ke_user_id', $pengirim->id)
                ->where('tipe_aksi', 'kembalikan')
                ->whereIn('status', ['Menunggu', 'Dilihat'])
                ->first();

            if ($rejectionTask) {
                $rejectionTask->update(['status' => 'Ditindaklanjuti']);
            }

            // 2. Buat disposisi baru ke penerima (Kepala)
            $this->create($surat, $pengirim, $penerima, $catatan, now(), 'teruskan');

            // 3. Update status surat utama kembali menjadi 'Diproses'
            $surat->update(['status' => 'Diproses']);
        });
    }

}