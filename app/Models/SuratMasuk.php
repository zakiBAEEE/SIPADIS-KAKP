<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratMasuk extends Model
{
    protected $table = 'surat_masuk'; // Kalau nama tabel tidak jamak

    protected $fillable = [
        'nomor_surat',
        'pengirim',
        'tanggal_surat',
        'tanggal_terima',
        'perihal',
        'klasifikasi_surat',
        'sifat',
        'file_path',
    ];

    public function disposisis()
    {
        return $this->hasMany(Disposisi::class, 'surat_id');
    }

    // app/Models/SuratMasuk.php

    public function scopeFilter($query, array $filters)
    {
        return $query
            ->when($filters['nomor_surat'] ?? null, fn($q, $value) => $q->where('nomor_surat', 'like', "%$value%"))
            ->when($filters['pengirim'] ?? null, fn($q, $value) => $q->where('pengirim', 'like', "%$value%"))
            ->when($filters['perihal'] ?? null, fn($q, $value) => $q->where('perihal', 'like', "%$value%"))
            ->when($filters['filter_tanggal_surat'] ?? null, fn($q, $value) => $q->whereDate('filter_tanggal_surat', $value))
            ->when($filters['filter_tanggal_terima'] ?? null, fn($q, $value) => $q->whereDate('filter_tanggal_terima', $value))
            ->when($filters['klasifikasi_surat'] ?? null, fn($q, $value) => $q->where('klasifikasi_surat', $value))
            ->when($filters['sifat'] ?? null, fn($q, $value) => $q->where('sifat', $value));
    }
}
