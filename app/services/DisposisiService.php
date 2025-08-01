<?php

namespace App\Services;

use App\Models\SuratMasuk;
use App\Models\Disposisi;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
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

    public static function getCleanTimeline(Collection $disposisis): Collection
    {
        $filtered = $disposisis->filter(function ($item) {
            $status = strtolower($item->status);
            return in_array($status, ['diteruskan', 'dilihat']);
        })->sortBy('created_at');

        $unique = collect();
        $seen = [];

        foreach ($filtered as $item) {
            $receiverId = $item->penerima->id ?? null;
            if ($receiverId && !in_array($receiverId, $seen)) {
                $unique->push($item);
                $seen[] = $receiverId;
            }
        }

        return $unique;
    }

    public function create(SuratMasuk $surat, User $pengirim, User $penerima, ?string $catatan, ?string $tanggal, string $tipeAksi): Disposisi
    {
        // Logika inti untuk membuat disposisi
        $disposisi = Disposisi::create([
            'surat_id' => $surat->id,
            'dari_user_id' => $pengirim->id,
            'ke_user_id' => $penerima->id,
            'catatan' => $catatan,
            'status' => 'Menunggu',
            'tipe_aksi' => $tipeAksi
        ]);

        // Setelah disposisi dibuat, update status surat menjadi 'Diproses'
        $surat->update(['status' => 'Diproses']);

        return $disposisi;
    }

    // public function tandaiSebagaiDilihat(SuratMasuk $surat, User $currentUser): void
    // {
    //     $adminRoles = ['Super Admin'];
    //     if (in_array($currentUser->role->name, $adminRoles)) {
    //         return; // Hentikan fungsi jika yang membuka adalah Admin
    //     }

    //     $disposisi = $surat->disposisis()
    //         ->where('ke_user_id', $currentUser->id)
    //         ->where('status', 'Menunggu')
    //         ->first();

    //     if ($disposisi) {
    //         $disposisi->update(['status' => 'Dilihat']);
    //     }
    // }

    public function tandaiSebagaiDilihat(SuratMasuk $surat, User $currentUser): void
    {
        $adminRoles = ['Super Admin'];
        if (in_array($currentUser->role->name, $adminRoles)) {
            return; // Hentikan fungsi jika yang membuka adalah Admin
        }

        // Ambil disposisi untuk current user (kalau ada)
        $disposisi = $surat->disposisis()
            ->where('ke_user_id', $currentUser->id)
            ->where('status', 'Menunggu')
            ->first();

        if ($disposisi) {
            $disposisi->update(['status' => 'Dilihat']);
        }

        // Tambahan logika jika user adalah Staf: semua staf dalam divisi sama → update
        if (strtolower($currentUser->role->name) === 'staf') {
            $stafIds = User::where('divisi_id', $currentUser->divisi_id)
                ->whereHas('role', fn($q) => $q->where('name', 'Staf'))
                ->pluck('id');

            $surat->disposisis()
                ->whereIn('ke_user_id', $stafIds)
                ->where('status', 'Menunggu')
                ->update(['status' => 'Dilihat']);
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

}