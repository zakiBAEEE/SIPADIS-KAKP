<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratMasuk;
use Illuminate\Support\Facades\Auth;
use App\Models\Disposisi;


class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $userId = $user->id;

        if ($user->role->name === 'Admin') {
            // Ambil ID disposisi terakhir per surat
            $latestDisposisiIds = Disposisi::selectRaw('MAX(id) as id')
                ->groupBy('surat_id');

            // Ambil surat_id dari disposisi yang terbaru ke admin
            $suratDiteruskanKeAdmin = Disposisi::whereIn('id', $latestDisposisiIds)
                ->where('ke_user_id', $userId)
                ->pluck('surat_id');

            // Ambil surat draft ATAU surat yang disposisi terakhirnya ke admin
            $listSuratAktif = SuratMasuk::where(function ($query) use ($suratDiteruskanKeAdmin) {
                $query->where('status', 'draft')
                    ->orWhereIn('id', $suratDiteruskanKeAdmin);
            })
                ->whereNotIn('status', ['selesai', 'ditolak'])
                ->get();

            $rekapSifatAktif = $listSuratAktif->groupBy('sifat')->map->count()->toArray();

        } else {
            // Non-admin: ambil surat yang disposisi terakhirnya ke user login (status menunggu/dilihat)
            $latestDisposisiIds = Disposisi::selectRaw('MAX(id) as id')
                ->groupBy('surat_id');

            $suratAktifIds = Disposisi::whereIn('id', $latestDisposisiIds)
                ->where('ke_user_id', $userId)
                ->whereIn('status', ['menunggu', 'dilihat'])
                ->pluck('surat_id');

            $listSuratAktif = SuratMasuk::whereIn('id', $suratAktifIds)
                ->whereNotIn('status', ['selesai', 'ditolak'])
                ->get();

            $listSuratAktif = $listSuratAktif->groupBy('sifat');

            $rekapSifatAktif = $listSuratAktif->groupBy('sifat')->map->count()->toArray();
        }



        return view('pages.shared.dashboard', [
            'rekapSifatAktif' => $rekapSifatAktif,
            'listSuratAktif' => $listSuratAktif
        ]);
    }



}
