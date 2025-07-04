<?php

namespace App\Services;

use App\Models\SuratMasuk;
use Carbon\Carbon;

class SuratRekapitulasiService
{
    public function getChartData($query, $groupBy = 'daily')
    {
        $klasifikasiList = ['Umum', 'Pengaduan', 'Permintaan Informasi'];

        switch ($groupBy) {
            case 'monthly':
                $data = $query->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as label, klasifikasi_surat, COUNT(*) as total")
                    ->groupBy('label', 'klasifikasi_surat')
                    ->orderBy('label')
                    ->get();

                $labelList = $data->pluck('label')->unique()->sort()->values();
                $categories = $labelList->map(fn($val) => Carbon::parse($val . '-01')->translatedFormat('F Y'))->toArray();
                break;

            case 'weekly':
                $data = $query->selectRaw("YEAR(created_at) as tahun, WEEK(created_at, 1) as minggu, klasifikasi_surat, COUNT(*) as total")
                    ->groupBy('tahun', 'minggu', 'klasifikasi_surat')
                    ->orderBy('tahun')
                    ->orderBy('minggu')
                    ->get()
                    ->map(function ($item) {
                        $item->label = "{$item->tahun}-W" . str_pad($item->minggu, 2, '0', STR_PAD_LEFT);
                        return $item;
                    });

                $labelList = $data->pluck('label')->unique()->sort()->values();
                $categories = $labelList->map(fn($val) => 'Minggu ' . explode('-W', $val)[1] . ' ' . explode('-W', $val)[0])->toArray();
                break;

            default: // daily
                $data = $query->selectRaw("DATE(created_at) as label, klasifikasi_surat, COUNT(*) as total")
                    ->groupBy('label', 'klasifikasi_surat')
                    ->orderBy('label')
                    ->get();

                $labelList = $data->pluck('label')->unique()->sort()->values();
                $categories = $labelList->map(fn($val) => Carbon::parse($val)->translatedFormat('d M'))->toArray();
                break;
        }

        // Bangun series data
        $series = [];

        foreach ($klasifikasiList as $klasifikasi) {
            $dataPerKlasifikasi = [];

            foreach ($labelList as $label) {
                $count = $data->firstWhere(
                    fn($item) =>
                    $item->label == $label && $item->klasifikasi_surat == $klasifikasi
                )?->total ?? 0;

                $dataPerKlasifikasi[] = $count;
            }

            $series[] = [
                'name' => $klasifikasi,
                'data' => $dataPerKlasifikasi,
            ];
        }

        return [
            'categories' => $categories,
            'series' => $series,
        ];
    }


    public function hitungRekapSurat($query)
    {
        return [
            'total' => (clone $query)->count(),
            'umum' => (clone $query)->where('klasifikasi_surat', 'Umum')->count(),
            'pengaduan' => (clone $query)->where('klasifikasi_surat', 'Pengaduan')->count(),
            'permintaan_informasi' => (clone $query)->where('klasifikasi_surat', 'Permintaan Informasi')->count(),
        ];
    }

}
