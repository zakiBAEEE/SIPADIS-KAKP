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
        // $surats = $query->get();
        $surats = $query
            ->with([
                'disposisiTerakhir.penerima.divisi'
            ])
            ->get();

        $rekapDivisi = $surats->filter(function ($surat) {
            return $surat->disposisiTerakhir && $surat->disposisiTerakhir->penerima && $surat->disposisiTerakhir->penerima->divisi;
        })->groupBy(function ($surat) {
            return $surat->disposisiTerakhir->penerima->divisi->nama_divisi ?? 'Tanpa Divisi';
        });


        return view('pages.super-admin.rekapitulasi', [
            'tanggalRange' => $tanggalRange,
            'rekap' => [
                'Klasifikasi' => $surats->groupBy('klasifikasi_surat'),
                'Sifat' => $surats->groupBy('sifat'),
                'Status' => $surats->groupBy('status'),
                'Divisi' => $rekapDivisi,
            ],
        ]);
    }


}
