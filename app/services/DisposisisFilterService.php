<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\SuratMasuk;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
class DisposisisFilterService
{
    public function filterByKepalaDisposisi($suratMasuk)
    {
        $kepala = User::whereHas('role', function ($q) {
            $q->where('name', 'Kepala LLDIKTI');
        })->first();

        if (!$kepala)
            return collect();

        $kepalaId = $kepala->id;

        return $suratMasuk->filter(function ($surat) use ($kepalaId) {
            // Cek apakah ada disposisi dari kepala
            return $surat->disposisis->contains(fn($d) => $d->dari_user_id == $kepalaId);
        })->map(function ($surat) use ($kepalaId) {
            // Hanya ambil disposisi pertama yang dari Kepala
            $firstDariKepala = $surat->disposisis
                ->filter(fn($d) => $d->dari_user_id == $kepalaId)
                ->sortBy('created_at')
                ->first();

            $surat->disposisis = collect([$firstDariKepala]);

            return $surat;
        });
    }



}


