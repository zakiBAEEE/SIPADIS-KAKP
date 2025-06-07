<?php
namespace App\Services;

use App\Models\SuratMasuk;
use Illuminate\Http\Request;

class SuratMasukService
{

    public function getSuratMasukWithFilters($filters, $existingQuery = null)
    {
       $query = $existingQuery ?? SuratMasuk::query();

        if (!empty($filters['nomor_agenda'])) {
            $query->where('nomor_agenda', 'like', '%' . $filters['nomor_agenda'] . '%');
        }

        if (!empty($filters['nomor_surat'])) {
            $query->where('nomor_surat', 'like', '%' . $filters['nomor_surat'] . '%');
        }

        if (!empty($filters['pengirim'])) {
            $query->where('pengirim', 'like', '%' . $filters['pengirim'] . '%');
        }

        $this->applyDateFilters($query, $filters);

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
            'nomor_agenda',
            'nomor_surat',
            'filter_tanggal_surat',
            'filter_tanggal_terima',
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
            [$start, $end] = explode(' to ', $filters['filter_tanggal_surat']);
            $query->whereBetween('tanggal_surat', [$start, $end]);
        }

        // Apply filter for 'tanggal_terima'
        if (!empty($filters['filter_tanggal_terima']) && str_contains($filters['filter_tanggal_terima'], ' to ')) {
            [$start, $end] = explode(' to ', $filters['filter_tanggal_terima']);
            $query->whereBetween('tanggal_terima', [$start, $end]);
        }
    }
}
