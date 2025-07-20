<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratMasuk;
use Illuminate\Support\Facades\Auth;
use App\Models\Disposisi;


class DashboardController extends Controller
{
    // public function index()
    // {
    //     $user = Auth::user();
    //     $userId = $user->id;

    //     if ($user->role->name === 'Admin') {
    //         // Ambil surat_id dari disposisi terakhir (MAX id per surat) yang ke admin
    //         $subLatestDisposisi = Disposisi::selectRaw('MAX(id) as id')
    //             ->groupBy('surat_id');

    //         $suratDiteruskanKeAdmin = Disposisi::whereIn('id', $subLatestDisposisi)
    //             ->where('ke_user_id', $userId)
    //             ->pluck('surat_id');

    //         // Ambil surat yang statusnya draft atau disposisi terakhirnya ke admin
    //         $listSuratAktif = SuratMasuk::where(function ($query) use ($suratDiteruskanKeAdmin) {
    //             $query->where('status', 'draft')
    //                 ->orWhereIn('id', $suratDiteruskanKeAdmin);
    //         })
    //             ->whereNotIn('status', ['selesai', 'ditolak'])
    //             ->get();

    //         $listSuratAktif = $listSuratAktif->groupBy('sifat');
    //         $rekapSifatAktif = $listSuratAktif->map->count()->toArray();

    //     } else {
    //         // Non-admin: ambil surat yang disposisi terakhirnya ke user login (status menunggu/dilihat)
    //         $latestDisposisiIds = Disposisi::selectRaw('MAX(id) as id')
    //             ->groupBy('surat_id');

    //         $suratAktifIds = Disposisi::whereIn('id', $latestDisposisiIds)
    //             ->where('ke_user_id', $userId)
    //             ->whereIn('status', ['Menunggu', 'Dilihat'])
    //             ->pluck('surat_id');

    //         $listSuratAktif = SuratMasuk::whereIn('id', $suratAktifIds)
    //             ->whereNotIn('status', ['selesai', 'ditolak'])
    //             ->get();


    //         $listSuratAktif = $listSuratAktif->groupBy('sifat');
    //         $rekapSifatAktif = $listSuratAktif->map->count()->toArray();
    //     }



    //     return view('pages.shared.dashboard', [
    //         'rekapSifatAktif' => $rekapSifatAktif,
    //         'listSuratAktif' => $listSuratAktif
    //     ]);
    // }


    public function index()
    {
        $user = Auth::user();
        $userId = $user->id;

        if ($user->role->name === 'Admin') {
            $subLatestDisposisi = Disposisi::selectRaw('MAX(id) as id')
                ->groupBy('surat_id');

            $suratDiteruskanKeAdmin = Disposisi::whereIn('id', $subLatestDisposisi)
                ->where('ke_user_id', $userId)
                ->pluck('surat_id');

            $listSuratAktif = SuratMasuk::where(function ($query) use ($suratDiteruskanKeAdmin) {
                $query->where('status', 'draft')
                    ->orWhereIn('id', $suratDiteruskanKeAdmin);
            })
                ->whereNotIn('status', ['selesai', 'ditolak'])
                ->get();

            $listSuratAktif = $listSuratAktif->groupBy('sifat');
            $rekapSifatAktif = $listSuratAktif->map->count()->toArray();
        } else {
            $latestDisposisiIds = Disposisi::selectRaw('MAX(id) as id')
                ->groupBy('surat_id');

            $suratAktifIds = Disposisi::whereIn('id', $latestDisposisiIds)
                ->where('ke_user_id', $userId)
                ->whereIn('status', ['Menunggu', 'Dilihat'])
                ->pluck('surat_id');

            $listSuratAktif = SuratMasuk::whereIn('id', $suratAktifIds)
                ->whereNotIn('status', ['selesai', 'ditolak'])
                ->get();

            $listSuratAktif = $listSuratAktif->groupBy('sifat');
            $rekapSifatAktif = $listSuratAktif->map->count()->toArray();
        }

        // Hitung statistik tambahan
        $inboxSuratCount = $this->getInboxSuratCount($userId);
        $dikembalikanKeAndaCount = $this->getDikembalikanKeAndaCount($userId);
        $suratTerdisposisiHariIniCount = $this->getSuratTerdisposisiHariIniCount($userId);

        return view('pages.shared.dashboard', [
            'rekapSifatAktif' => $rekapSifatAktif,
            'listSuratAktif' => $listSuratAktif,
            'inboxSuratCount' => $inboxSuratCount,
            'dikembalikanKeAndaCount' => $dikembalikanKeAndaCount,
            'suratTerdisposisiHariIniCount' => $suratTerdisposisiHariIniCount,
        ]);
    }


    protected function getInboxSuratCount($userId)
    {
        $latestDisposisi = Disposisi::selectRaw('MAX(id) as id')
            ->groupBy('surat_id');

        return Disposisi::whereIn('id', $latestDisposisi)
            ->where('ke_user_id', $userId)
            ->whereIn('status', ['Menunggu', 'Dilihat'])
            ->count();
    }

    protected function getDikembalikanKeAndaCount($userId)
    {
        $latestDisposisi = Disposisi::selectRaw('MAX(id) as id')
            ->groupBy('surat_id');

        return Disposisi::whereIn('id', $latestDisposisi)
            ->where('ke_user_id', $userId)
            ->where('status', 'Dikembalikan')
            ->count();
    }

    protected function getSuratTerdisposisiHariIniCount($userId)
    {
        $today = \Carbon\Carbon::today();

        return Disposisi::where('dari_user_id', $userId)
            ->whereDate('created_at', $today)
            ->count();
    }




}
