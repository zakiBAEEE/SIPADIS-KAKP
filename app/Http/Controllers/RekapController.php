<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RekapController extends Controller
{
    public function exportRekapPerWaktu(Request $request)
{
    $groupBy = $request->input('group_by'); // 'daily', 'weekly', 'monthly', 'yearly'
    $waktu = $request->input('waktu');      // contoh: '2025-08-20'

    // Ambil data rekap sesuai waktu dan tipe pengelompokannya
  

    // Cek jika data tidak ditemukan
    if (!$rekapPerWaktuDetail) {
        return redirect()->back()->with('error', 'Data tidak ditemukan.');
    }

    // Ekspor data ke file Excel
    return Excel::download(
        new RekapPerWaktuExport($rekapPerWaktuDetail, $waktu, $groupBy),
        'rekap-per-waktu.xlsx'
    );
}
}
