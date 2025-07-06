<?php
namespace App\Services;

use App\Models\SuratMasuk;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SuratMasukService
{

    public function getSuratMasukWithFilters($filters, $existingQuery = null)
    {
        $query = $existingQuery ?? SuratMasuk::query();



        if (!empty($filters['nomor_surat'])) {
            $query->where('nomor_surat', 'like', '%' . $filters['nomor_surat'] . '%');
        }

        if (!empty($filters['pengirim'])) {
            $query->where('pengirim', 'like', '%' . $filters['pengirim'] . '%');
        }

        if (!empty($filters['filter_tanggal_surat']) && str_contains($filters['filter_tanggal_surat'], ' to ')) {
            $range = explode(' to ', $filters['filter_tanggal_surat']);

            $start = Carbon::parse($range[0])->startOfDay();
            $end = Carbon::parse($range[1])->endOfDay();

            $query->whereBetween('tanggal_surat', [$start, $end]);
        }

        if (!empty($filters['filter_created_at']) && str_contains($filters['filter_created_at'], ' to ')) {
            $range = explode(' to ', $filters['filter_created_at']);

            $start = Carbon::parse($range[0])->startOfDay();
            $end = Carbon::parse($range[1])->endOfDay();

            $query->whereBetween('created_at', [$start, $end]);
        }

        if (!empty($filters['klasifikasi_surat'])) {
            $query->where('klasifikasi_surat', $filters['klasifikasi_surat']);
        }

        if (!empty($filters['sifat'])) {
            $query->where('sifat', $filters['sifat']);
        }

        if (!empty($filters['perihal'])) {
            $query->where('perihal', 'like', '%' . $filters['perihal'] . '%');
        }

        return $query;
    }

    public function suratMasukWithDisposisi(Request $request)
    {
        $filters = $request->only([
            'nomor_surat',
            'filter_tanggal_surat',
            'filter_created_at',
            'pengirim',
            'klasifikasi_surat',
            'sifat',
            'perihal',
        ]);

        $hasFilters = collect($filters)->filter()->isNotEmpty();

        $query = SuratMasuk::with([
            'disposisis.pengirim.divisi',
            'disposisis.pengirim.role',
            'disposisis.penerima.divisi',
            'disposisis.penerima.role',
        ])->has('disposisis');

        if ($hasFilters) {
            $query = $this->getSuratMasukWithFilters($filters, $query);
        }

        return $query;
    }

    private function applyDateFilters($query, $filters)
    {
        // Apply filter for 'tanggal_surat'
        if (!empty($filters['filter_tanggal_surat']) && str_contains($filters['filter_tanggal_surat'], ' to ')) {
            $range = explode(' to ', $filters['filter_tanggal_surat']);

            $start = Carbon::parse($range[0])->startOfDay();
            $end = Carbon::parse($range[1])->endOfDay();

            $query->whereBetween('tanggal_surat', [$start, $end]);
        }

        // Apply filter for 'created_at'
        if (!empty($filters['filter_created_at']) && str_contains($filters['filter_created_at'], ' to ')) {
            $range = explode(' to ', $filters['filter_created_at']);

            $start = Carbon::parse($range[0])->startOfDay();
            $end = Carbon::parse($range[1])->endOfDay();

            $query->whereBetween('created_at', [$start, $end]);
        }
    }
}
