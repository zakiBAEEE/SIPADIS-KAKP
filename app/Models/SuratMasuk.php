<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratMasuk extends Model
{
    protected $table = 'surat_masuk'; // Kalau nama tabel tidak jamak

    protected $fillable = [
        'nomor_agenda',
        'nomor_surat',
        'pengirim',
        'tanggal_surat',
        'tanggal_terima',
        'perihal',
        'klasifikasi_surat',
        'sifat',
        'file_path',
    ];

    public function disposisis() {
        return $this->hasMany(Disposisi::class, 'surat_id');
    }
}
