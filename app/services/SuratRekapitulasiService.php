<?php

namespace App\Services;

use App\Models\SuratMasuk;
use Carbon\Carbon;

class SuratRekapitulasiService
{
    public function getRekapitulasiSurat($start, $end)
    {
        return [
            'total' => SuratMasuk::whereBetween('created_at', [$start, $end])->count(),
            'umum' => SuratMasuk::whereBetween('created_at', [$start, $end])
                ->where('klasifikasi_surat', 'umum')->count(),
            'pengaduan' => SuratMasuk::whereBetween('created_at', [$start, $end])
                ->where('klasifikasi_surat', 'pengaduan')->count(),
            'permintaan_informasi' => SuratMasuk::whereBetween('created_at', [$start, $end])
                ->where('klasifikasi_surat', 'permintaan informasi')->count(),
        ];
    }

    public function parseRangeTanggal($range)
    {
        $dates = explode(' to ', $range);
        if (count($dates) === 2) {
            return [
                Carbon::parse($dates[0])->startOfMonth(),
                Carbon::parse($dates[1])->endOfMonth(),
            ];
        }
        return [null, null];
    }

    public function getChartSeries($start, $end)
    {
        Carbon::setLocale('id');
        $categories = [];
        $series = [
            'umum' => [],
            'pengaduan' => [],
            'permintaan_informasi' => [],
        ];

        for ($date = $start->copy(); $date->lte($end); $date->addMonth()) {
            $bulanStart = $date->copy()->startOfMonth();
            $bulanEnd = $date->copy()->endOfMonth();
            $categories[] = $date->translatedFormat('F Y');

            foreach (array_keys($series) as $jenis) {
                $jumlah = SuratMasuk::whereBetween('created_at', [$bulanStart, $bulanEnd])
                    ->where('klasifikasi_surat', $jenis)
                    ->count();
                $series[$jenis][] = $jumlah;
            }
        }

        return [
            'categories' => $categories,
            'series' => $series,
        ];
    }
}
