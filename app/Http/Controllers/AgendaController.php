<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\SuratMasukService;
use App\Services\DisposisisFilterService;
use App\Models\SuratMasuk;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;



class AgendaController extends Controller
{
    protected $suratMasukWithDisposisi;
    protected $disposisisFilterService;

    public function __construct(SuratMasukService $suratMasukWithDisposisi, DisposisisFilterService $disposisisFilterService)
    {
        $this->suratMasukWithDisposisi = $suratMasukWithDisposisi;
        $this->disposisisFilterService = $disposisisFilterService;  // Simpan service di properti controller
    }

    public function agendaKbu(Request $request)
    {
        // Memanggil "mesin" utama yang SAMA, hanya beda parameter
        $suratMasuk = $this->getAgendaForRole('KBU', $request);

        return view('pages.super-admin.agenda-kbu', [
            'suratMasuk' => $suratMasuk,
        ]);
    }

    public function agendaKepala(Request $request)
    {
        // Memanggil "mesin" utama dengan parameter 'Kepala'
        $suratMasuk = $this->getAgendaForRole('Kepala LLDIKTI', $request);

        return view('pages.super-admin.agenda-kepala', [
            'suratMasuk' => $suratMasuk,
        ]);
    }


    public function printAgendaKbu(Request $request)
    {
        $query = $this->suratMasukWithDisposisi->suratMasukWithDisposisi($request);
        $suratMasuk = $query->orderBy('tanggal_terima')->get();

        return view('pages.super-admin.print-agenda-kbu', [
            'suratMasuk' => $suratMasuk,
            'tanggalRange' => null,
        ]);
    }

    public function printAgendaKepala(Request $request)
    {
        $query = $this->suratMasukWithDisposisi->suratMasukWithDisposisi($request);

        $suratMasuk = $query->orderBy('tanggal_terima')->get();

        $suratMasuk = $this->disposisisFilterService->filterByKepalaDisposisi($suratMasuk);

        return view('pages.super-admin.print-agenda-kepala', [
            'suratMasuk' => $suratMasuk,
            'tanggalRange' => null,
        ]);
    }


    private function getAgendaForRole(string $roleName, Request $request): LengthAwarePaginator
    {
        // 1. Dapatkan semua ID user yang memiliki peran yang diminta
        $roleUserIds = User::whereHas('role', fn($q) => $q->where('name', $roleName))->pluck('id');

        if ($roleUserIds->isEmpty()) {
            return new LengthAwarePaginator([], 0, 10);
        }

        // 2. Buat query dasar untuk SuratMasuk
        // Kita juga bisa memanfaatkan fungsi filter Anda jika diperlukan
        $query = SuratMasuk::query();
        if ($request->hasAny(['nomor_agenda', 'nomor_surat', 'pengirim', 'perihal'])) {
            $query->filter($request->all()); // Memanggil scopeFilter di model SuratMasuk
        }

        // 3. Terapkan filter utama yang sesuai dengan aturan Anda
        $query->whereHas('disposisis', function (Builder $q) use ($roleUserIds) {

            // ATURAN 1: Hanya mengambil disposisi DARI peran ini (dari_user_id).
            $q->whereIn('dari_user_id', $roleUserIds)

                // ATURAN 2: TIDAK MENAMPILKAN yang statusnya 'Dikembalikan'.
                ->where('status', '!=', 'Dikembalikan');
        });

        // 4. Lakukan paginasi dan eager load relasi yang dibutuhkan
        return $query->with([
            'disposisis' => function ($q) use ($roleUserIds) {
                $q->whereIn('dari_user_id', $roleUserIds)->latest();
            },
            'disposisis.penerima.role'
        ])
            ->latest('updated_at')
            ->paginate(10)
            ->appends($request->query());
    }

}
