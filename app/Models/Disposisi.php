<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Disposisi extends Model
{
    protected $fillable = [
        'surat_id',
        'dari_user_id',
        'ke_user_id',
        'catatan',
        'tanggal_disposisi',
    ];
    
    public function suratMasuk() {
        return $this->belongsTo(SuratMasuk::class, 'surat_id');
    }
    public function pengirim()
    {
        return $this->belongsTo(User::class, 'dari_user_id');
    }

    // Relasi ke user penerima disposisi
    public function penerima()
    {
        return $this->belongsTo(User::class, 'ke_user_id');
    }
}
