<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratMasuk extends Model
{
    protected $table = 'surat_masuk'; // Kalau nama tabel tidak jamak

    protected $primaryKey = 'id'; // default, tapi tetap sebutkan agar eksplisit
    public $incrementing = false; // ini WAJIB, agar Laravel tahu ID bukan auto-increment
    protected $keyType = 'string'; // ini WAJIB, agar Laravel tahu ID berupa string
    protected $fillable = [
        'id',
        'nomor_surat',
        'pengirim',
        'asal_instansi', // tambahkan ini
        'email_pengirim', // dan ini
        'tanggal_surat',
        'perihal',
        'klasifikasi_surat',
        'sifat',
        'file_path',
        'created_at',
        'status',
    ];
    public function disposisis()
    {
        return $this->hasMany(Disposisi::class, 'surat_id');
    }

}
