<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\SuratMasukService;
use App\Services\DisposisisFilterService;

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
        $query = $this->suratMasukWithDisposisi->suratMasukWithDisposisi($request);

        $suratMasuk = $query->orderBy('tanggal_terima')->paginate(10)->appends($request->query());

        return view('pages.super-admin.agenda-kbu', [
            'suratMasuk' => $suratMasuk,
        ]);
    }

    public function agendaKepala(Request $request)
    {
        // Panggil service untuk mendapatkan query surat dengan disposisi
        $query = $this->suratMasukWithDisposisi->suratMasukWithDisposisi($request);

        // Lakukan pemrosesan pagination pertama
        $suratMasuk = $query->orderBy('tanggal_terima')->paginate(10)->appends($request->query());

        // Terapkan filter berdasarkan disposisi kepala, namun pastikan pagination tetap terjaga
        $filteredSuratMasuk = $this->disposisisFilterService->filterByKepalaDisposisi($suratMasuk->getCollection());

        // Kembalikan pagination dengan data yang sudah difilter
        $suratMasuk->setCollection($filteredSuratMasuk);

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

}
