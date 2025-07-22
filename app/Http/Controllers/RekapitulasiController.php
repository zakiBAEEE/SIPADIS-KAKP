<?php

namespace App\Http\Controllers;
use App\Services\SuratRekapitulasiService;
use App\Models\SuratMasuk;
use Carbon\Carbon;
use App\Exports\RekapitulasiExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Exports\RekapitulasiMultiSheetExport;
use App\Exports\RekapitulasiKategoriMultiSheetExport;


class RekapitulasiController extends Controller
{

    protected $rekapitulasiService;

    public function __construct(SuratRekapitulasiService $rekapitulasiService)
    {
        $this->rekapitulasiService = $rekapitulasiService;
    }




    public function rekapitulasi(Request $request)
    {
        $groupBy = $request->input('group_by', 'daily'); // default: harian

        // Ambil input tanggal sesuai group_by
        switch ($groupBy) {
            case 'daily':
                $tanggal = $request->input('tanggal_daily');
                $start = $tanggal ? Carbon::parse($tanggal)->startOfDay() : now()->startOfDay();
                $end = $tanggal ? Carbon::parse($tanggal)->endOfDay() : now()->endOfDay();
                $waktu = \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y');
                break;

            case 'weekly':
                $tanggal = $request->input('tanggal_weekly'); // format: "YYYY-Wnn"
                if ($tanggal) {
                    // Mengubah dari ISO week format (mis: 2024-W15) ke tanggal awal & akhir minggu
                    [$year, $week] = explode('-W', $tanggal);
                    $start = Carbon::now()->setISODate($year, $week)->startOfWeek();
                    $end = Carbon::now()->setISODate($year, $week)->endOfWeek();
                    $waktu = 'Pekan ' . $start->isoFormat('Wo') . ' ('
                        . $start->translatedFormat('d M') . ' - '
                        . $end->translatedFormat('d M Y') . ')';
                } else {
                    $start = now()->startOfWeek();
                    $end = now()->endOfWeek();
                    $waktu = 'Pekan ' . $start->isoFormat('Wo') . ' ('
                        . $start->translatedFormat('d M') . ' - '
                        . $end->translatedFormat('d M Y') . ')';
                }
                break;

            case 'monthly':
                $tanggal = $request->input('tanggal_monthly'); // format: "YYYY-MM"
                if ($tanggal) {
                    $start = Carbon::parse($tanggal)->startOfMonth();
                    $end = Carbon::parse($tanggal)->endOfMonth();
                    $waktu = \Carbon\Carbon::parse($start)->translatedFormat('F Y');
                } else {
                    $start = now()->startOfMonth();
                    $end = now()->endOfMonth();
                    $waktu = \Carbon\Carbon::parse($start)->translatedFormat('F Y');
                }
                break;

            case 'yearly':
                $tanggal = $request->input('tanggal_yearly'); // hanya tahun saja
                if ($tanggal) {
                    $start = Carbon::createFromDate($tanggal, 1, 1)->startOfYear();
                    $end = Carbon::createFromDate($tanggal, 12, 31)->endOfYear();
                    $waktu = \Carbon\Carbon::parse($start)->translatedFormat('Y');
                } else {
                    $start = now()->startOfYear();
                    $end = now()->endOfYear();
                    $waktu = \Carbon\Carbon::parse($start)->translatedFormat('Y');
                }
                break;

            default:
                // fallback
                $start = now()->startOfDay();
                $end = now()->endOfDay();
                $waktu = null;
                break;
        }

        // Query surat berdasarkan range waktu
        $query = SuratMasuk::whereBetween('tanggal_surat', [$start, $end]);

        $surats = $query->with([
            'disposisiTerakhir.penerima.divisi'
        ])->get();

        // Group berdasarkan divisi
        $rekapDivisi = $surats->filter(function ($surat) {
            return $surat->disposisiTerakhir && $surat->disposisiTerakhir->penerima && $surat->disposisiTerakhir->penerima->divisi;
        })->groupBy(function ($surat) {
            return $surat->disposisiTerakhir->penerima->divisi->nama_divisi ?? 'Tanpa Divisi';
        });

        // Group berdasarkan waktu
        $rekapPerWaktu = match ($groupBy) {
            'weekly' => $surats->groupBy(fn($item) => Carbon::parse($item->tanggal_surat)->startOfWeek()->format('Y-m-d')),
            'monthly' => $surats->groupBy(fn($item) => Carbon::parse($item->tanggal_surat)->format('Y-m')),
            'yearly' => $surats->groupBy(fn($item) => Carbon::parse($item->tanggal_surat)->format('Y')),
            default => $surats->groupBy(fn($item) => Carbon::parse($item->tanggal_surat)->format('Y-m-d')),
        };

        $rekapPerWaktuDetail = $rekapPerWaktu->map(function ($items, $groupKey) {
            return [
                'Klasifikasi' => $items->groupBy('klasifikasi_surat')->map->count(),
                'Sifat' => $items->groupBy('sifat')->map->count(),
                'Status' => $items->groupBy('status')->map->count(),
            ];
        });

        return view('pages.super-admin.rekapitulasi', [
            'rekapPerWaktuDetail' => $rekapPerWaktuDetail,
            'groupBy' => $groupBy,
            'waktu' => $waktu,
            'rekap' => [
                'Klasifikasi' => $surats->groupBy('klasifikasi_surat'),
                'Sifat' => $surats->groupBy('sifat'),
                'Status' => $surats->groupBy('status'),
            ],
            'tanggalInput' => $tanggal ?? null, // hanya untuk tampilan kembali di form
        ]);
    }

    // public function export(Request $request)
    // {
    //     $groupBy = $request->input('group_by', 'daily');

    //     // Salin logika tanggal dari fungsi rekapitulasi()
    //     // (atau refactor ke fungsi terpisah agar tidak duplikatif)
    //     // Contoh (dari kode kamu):
    //     switch ($groupBy) {
    //         case 'daily':
    //             $tanggal = $request->input('tanggal_daily');
    //             $start = $tanggal ? Carbon::parse($tanggal)->startOfDay() : now()->startOfDay();
    //             $end = $tanggal ? Carbon::parse($tanggal)->endOfDay() : now()->endOfDay();
    //             break;
    //         case 'weekly':
    //             $tanggal = $request->input('tanggal_weekly');
    //             [$year, $week] = explode('-W', $tanggal);
    //             $start = Carbon::now()->setISODate($year, $week)->startOfWeek();
    //             $end = Carbon::now()->setISODate($year, $week)->endOfWeek();
    //             break;
    //         case 'monthly':
    //             $tanggal = $request->input('tanggal_monthly');
    //             $start = Carbon::parse($tanggal)->startOfMonth();
    //             $end = Carbon::parse($tanggal)->endOfMonth();
    //             break;
    //         case 'yearly':
    //             $tanggal = $request->input('tanggal_yearly');
    //             $start = Carbon::createFromDate($tanggal, 1, 1)->startOfYear();
    //             $end = Carbon::createFromDate($tanggal, 12, 31)->endOfYear();
    //             break;
    //         default:
    //             $start = now()->startOfDay();
    //             $end = now()->endOfDay();
    //     }

    //     $surats = SuratMasuk::whereBetween('tanggal_surat', [$start, $end])->get();

    //     // Kelompokkan per waktu (daily/weekly/monthly/yearly)
    //     $rekapPerWaktu = match ($groupBy) {
    //         'weekly' => $surats->groupBy(fn($item) => Carbon::parse($item->tanggal_surat)->startOfWeek()->format('Y-m-d')),
    //         'monthly' => $surats->groupBy(fn($item) => Carbon::parse($item->tanggal_surat)->format('Y-m')),
    //         'yearly' => $surats->groupBy(fn($item) => Carbon::parse($item->tanggal_surat)->format('Y')),
    //         default => $surats->groupBy(fn($item) => Carbon::parse($item->tanggal_surat)->format('Y-m-d')),
    //     };

    //     // Siapkan data array untuk export
    //     $data = [];

    //     foreach ($rekapPerWaktu as $waktu => $items) {
    //         $klasifikasi = $items->groupBy('klasifikasi_surat')->map->count();
    //         $sifat = $items->groupBy('sifat')->map->count();
    //         $status = $items->groupBy('status')->map->count();

    //         $maxRows = max($klasifikasi->count(), $sifat->count(), $status->count());
    //         $klasifikasi = $klasifikasi->values();
    //         $sifat = $sifat->values();
    //         $status = $status->values();

    //         for ($i = 0; $i < $maxRows; $i++) {
    //             $data[] = [
    //                 'Waktu' => $i == 0 ? $waktu : '',
    //                 'Klasifikasi' => $klasifikasi->keys()[$i] ?? '',
    //                 'Jumlah Klasifikasi' => $klasifikasi->values()[$i] ?? '',
    //                 'Sifat' => $sifat->keys()[$i] ?? '',
    //                 'Jumlah Sifat' => $sifat->values()[$i] ?? '',
    //                 'Status' => $status->keys()[$i] ?? '',
    //                 'Jumlah Status' => $status->values()[$i] ?? '',
    //             ];
    //         }
    //     }

    //     return Excel::download(new RekapitulasiExport($data), 'rekapitulasi.xlsx');
    // }

    public function export(Request $request)
    {
        $groupBy = $request->input('group_by', 'daily');

        switch ($groupBy) {
            case 'daily':
                $tanggal = $request->input('tanggal_daily');
                $start = $tanggal ? Carbon::parse($tanggal)->startOfDay() : now()->startOfDay();
                $end = $tanggal ? Carbon::parse($tanggal)->endOfDay() : now()->endOfDay();
                break;
            case 'weekly':
                $tanggal = $request->input('tanggal_weekly');
                [$year, $week] = explode('-W', $tanggal);
                $start = Carbon::now()->setISODate($year, $week)->startOfWeek();
                $end = Carbon::now()->setISODate($year, $week)->endOfWeek();
                break;
            case 'monthly':
                $tanggal = $request->input('tanggal_monthly');
                $start = Carbon::parse($tanggal)->startOfMonth();
                $end = Carbon::parse($tanggal)->endOfMonth();
                break;
            case 'yearly':
                $tanggal = $request->input('tanggal_yearly');
                $start = Carbon::createFromDate($tanggal, 1, 1)->startOfYear();
                $end = Carbon::createFromDate($tanggal, 12, 31)->endOfYear();
                break;
            default:
                $start = now()->startOfDay();
                $end = now()->endOfDay();
        }


        $surats = SuratMasuk::whereBetween('tanggal_surat', [$start, $end])
            ->with(['disposisiTerakhir.penerima.divisi'])
            ->get();

        // Siapkan data rekap seperti sebelumnya
        $rekapPerWaktu = match ($groupBy) {
            'weekly' => $surats->groupBy(fn($item) => Carbon::parse($item->tanggal_surat)->startOfWeek()->format('Y-m-d')),
            'monthly' => $surats->groupBy(fn($item) => Carbon::parse($item->tanggal_surat)->format('Y-m')),
            'yearly' => $surats->groupBy(fn($item) => Carbon::parse($item->tanggal_surat)->format('Y')),
            default => $surats->groupBy(fn($item) => Carbon::parse($item->tanggal_surat)->format('Y-m-d')),
        };

        $rekapData = [];

        foreach ($rekapPerWaktu as $waktu => $items) {
            $klasifikasi = $items->groupBy('klasifikasi_surat')->map->count();
            $sifat = $items->groupBy('sifat')->map->count();
            $status = $items->groupBy('status')->map->count();

            $maxRows = max($klasifikasi->count(), $sifat->count(), $status->count());
        
            for ($i = 0; $i < $maxRows; $i++) {
                $rekapData[] = [
                    'Waktu' => $i == 0 ? $waktu : '',
                    'Klasifikasi' => $klasifikasi->keys()[$i] ?? '',
                    'Jumlah Klasifikasi' => $klasifikasi->values()[$i] ?? '',
                    'Sifat' => $sifat->keys()[$i] ?? '',
                    'Jumlah Sifat' => $sifat->values()[$i] ?? '',
                    'Status' => $status->keys()[$i] ?? '',
                    'Jumlah Status' => $status->values()[$i] ?? '',
                ];
            }
        }

        return Excel::download(new RekapitulasiMultiSheetExport($rekapData, $surats), 'rekapitulasi-dan-surat.xlsx');
    }



}
