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
        if ($kepala) {
            $kepalaId = $kepala->id;
            $suratMasuk = $suratMasuk->filter(function ($surat) use ($kepalaId) {
                $firstDisposisi = $surat->disposisis->sortBy('created_at')->first();
                return $firstDisposisi && $firstDisposisi->dari_user_id == $kepalaId;
            })->map(function ($surat) {
                $surat->disposisis = collect([$surat->disposisis->sortBy('created_at')->first()]);
                return $surat;
            });
        } else {
            $suratMasuk = collect();
        }
        return $suratMasuk;
    }

 
}


