<?php
namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use App\Models\Disposisi;
use App\Models\User;
use Illuminate\Http\Request;

class LogbookPegawaiController extends Controller
{
    // public function index(Request $request)
    // {
    //     $userId = $request->input('user_id');
    //     $user = User::findOrFail($userId);

    //     $isStaff = $user->role === 'Staff';

    //     if ($isStaff) {
    //         // STAFF: surat yang status-nya 'diproses' atau 'ditindaklanjuti' dan disposisi terakhir ditujukan ke dia
    //         $suratTertahan = SuratMasuk::whereIn('status', ['diproses', 'ditindaklanjuti'])
    //             ->whereHas('disposisiTerakhir', function ($query) use ($userId) {
    //                 $query->where('ke_user_id', $userId);
    //             })
    //             ->get();

    //         $statusCounts = [
    //             'diproses' => $suratTertahan->where('status', 'diproses')->count(),
    //             'ditindaklanjuti' => $suratTertahan->where('status', 'ditindaklanjuti')->count(),
    //         ];

    //         $logRiwayat = []; // staff tidak punya log riwayat
    //     } else {
    //         // NON-STAFF: disposisi terakhir dari setiap surat ke user ini dengan status 'Menunggu' atau 'Dilihat'
    //         $suratTertahan = Disposisi::select('surat_id')
    //             ->latest('id')
    //             ->groupBy('surat_id')
    //             ->havingRaw('MAX(ke_user_id) = ?', [$userId])
    //             ->with('suratMasuk', 'pengirim')
    //             ->whereIn('status', ['Menunggu', 'Dilihat'])
    //             ->get();

    //         $statusCounts = []; // non-staff tidak butuh count status surat

    //         $logRiwayat = Disposisi::with('suratMasuk', 'pengirim', 'penerima')
    //             ->where(function ($query) use ($userId) {
    //                 $query->where('dari_user_id', $userId)
    //                     ->orWhere('ke_user_id', $userId);
    //             })
    //             ->orderByDesc('created_at')
    //             ->get();
    //     }

    //     return view('pages.shared.logbook', [
    //         'user' => $user,
    //         'isStaff' => $isStaff,
    //         'suratTertahan' => $suratTertahan,
    //         'statusCounts' => $statusCounts,
    //         'logRiwayat' => $logRiwayat,
    //     ]);
    // }

    public function index(Request $request)
    {
        $users = User::all(); // Ambil semua user untuk dropdown
        $userId = $request->input('user_id');

        // Jika belum ada user_id, tampilkan halaman kosong atau view pemilihan user
        if (!$userId) {
            return view('pages.shared.logbook', [
                'users' => $users,
                'user' => null,
                'isStaff' => null,
                'suratTertahan' => collect(),
                'statusCounts' => [],
                'logRiwayat' => collect(),
            ]);
        }

        $user = User::findOrFail($userId);
        $isStaff = $user->role === 'Staff';

        if ($isStaff) {
            // STAFF: surat yang status-nya 'diproses' atau 'ditindaklanjuti' dan disposisi terakhir ditujukan ke dia
            $suratTertahan = SuratMasuk::whereIn('status', ['diproses', 'ditindaklanjuti'])
                ->whereHas('disposisiTerakhir', function ($query) use ($userId) {
                    $query->where('ke_user_id', $userId);
                })
                ->get();

            $statusCounts = [
                'diproses' => $suratTertahan->where('status', 'diproses')->count(),
                'ditindaklanjuti' => $suratTertahan->where('status', 'ditindaklanjuti')->count(),
            ];

            $logRiwayat = collect(); // staff tidak punya log riwayat
        } else {
            // NON-STAFF
            $suratTertahan = Disposisi::select('surat_id')
                ->latest('id')
                ->groupBy('surat_id')
                ->havingRaw('MAX(ke_user_id) = ?', [$userId])
                ->with('suratMasuk', 'pengirim')
                ->whereIn('status', ['Menunggu', 'Dilihat'])
                ->get();

            $statusCounts = []; // non-staff tidak butuh count status surat

            $logRiwayat = Disposisi::with('suratMasuk', 'pengirim', 'penerima')
                ->where(function ($query) use ($userId) {
                    $query->where('dari_user_id', $userId)
                        ->orWhere('ke_user_id', $userId);
                })
                ->orderByDesc('created_at')
                ->get();
        }

        return view('pages.shared.logbook', [
            'users' => $users,
            'user' => $user,
            'isStaff' => $isStaff,
            'suratTertahan' => $suratTertahan,
            'statusCounts' => $statusCounts,
            'logRiwayat' => $logRiwayat,
        ]);
    }

}
