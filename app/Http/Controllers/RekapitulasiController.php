<?php

namespace App\Http\Controllers;
use App\Services\SuratRekapitulasiService;
use App\Models\SuratMasuk;
use Carbon\Carbon;

use Illuminate\Http\Request;

class RekapitulasiController extends Controller
{

    protected $rekapitulasiService;

    public function __construct(SuratRekapitulasiService $rekapitulasiService)
    {
        $this->rekapitulasiService = $rekapitulasiService;
    }




    public function rekapitulasi(Request $request)
    {
        $tanggalRange = $request->input('tanggal_range');

        if ($tanggalRange) {
            $range = explode(' to ', $tanggalRange);
            $start = Carbon::parse($range[0])->startOfDay();
            $end = Carbon::parse($range[1])->endOfDay();

            $query = SuratMasuk::whereBetween('tanggal_surat', [$start, $end]);
        } else {
            $query = SuratMasuk::whereDate('created_at', now()->toDateString());
        }

        // Ambil semua surat dalam range
        $surats = $query->get();

        

        return view('pages.super-admin.rekapitulasi', [
            'tanggalRange' => $tanggalRange,
            'suratsBySifat' => $surats->groupBy('sifat'),
            'byKlasifikasi' => $surats->groupBy('klasifikasi_surat'),
            'byStatus' => $surats->groupBy('status'),
        ]);
    }


}
