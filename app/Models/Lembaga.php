<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lembaga extends Model
{
    use HasFactory;

    // Jika nama tabel berbeda dari plural bentuk model, tentukan secara eksplisit:
    protected $table = 'lembaga';

    // Field yang boleh diisi (mass assignment)
    protected $fillable = [
        'nama_kementerian',
        'nama_lembaga',
        'email',
        'alamat',
        'telepon',
        'website',
        'kota',
        'provinsi',
        'kepala_kantor',
        'nip_kepala_kantor',
        'jabatan',
        'logo',
        'tahun',
    ];
}
