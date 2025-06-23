<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Disposisi;

class InboxController extends Controller
{
    /**
     * Menampilkan halaman inbox untuk pengguna yang sedang login.
     * Logika ini sekarang sama untuk semua peran non-admin.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Langsung ambil data disposisi untuk user yang login
        $disposisis = Disposisi::where('ke_user_id', operator: Auth::id())
            ->whereIn('tipe_aksi', ['Teruskan', 'Revisi'])
            ->whereIn('status', ['Menunggu', 'Dilihat']) // Hanya tampilkan disposisi aktif
            ->with(['suratMasuk', 'pengirim.role']) // Eager loading untuk performa
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->appends($request->query());

        // Kirim data ke satu view generik yang sama
        return view('pages.shared.inbox', [
            'disposisis' => $disposisis,
            'pageTitle' => 'Inbox Disposisi'
        ]);
    }

    // public function outbox(Request $request)
    // {
    //     // Perubahan kuncinya ada di sini:
    //     // Kita mencari disposisi di mana PENGIRIMNYA adalah user yang login.
    //     $disposisis = Disposisi::where('dari_user_id', Auth::id())
    //         ->with(['suratMasuk', 'penerima.role']) // Sekarang kita butuh info penerima
    //         ->orderBy('created_at', 'desc')
    //         ->paginate(10)
    //         ->appends($request->query());

    //     // Kita akan membuat view outbox yang baru
    //     return view('pages.shared.outbox', [
    //         'disposisis' => $disposisis,
    //         'pageTitle' => 'Outbox: Riwayat Disposisi Terkirim'
    //     ]);
    // }

    public function outbox(Request $request)
    {
        $query = Disposisi::where('dari_user_id', Auth::id())
            ->with(['suratMasuk', 'penerima.role']);

        // ✅ Filter: Status penerima
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // ✅ Filter: Tipe Aksi
        if ($request->filled('tipe_aksi')) {
            $query->where('tipe_aksi', $request->tipe_aksi);
        }

        // ✅ Filter: Perihal surat
        if ($request->filled('perihal')) {
            $query->whereHas('suratMasuk', function ($q) use ($request) {
                $q->where('perihal', 'like', '%' . $request->perihal . '%');
            });
        }

        // ✅ Filter: Rentang tanggal kirim (created_at)
        if ($request->filled('filter_tanggal_terkirim')) {
            $range = explode(' to ', $request->filter_tanggal_terkirim);
            if (count($range) === 2) {
                $query->whereBetween('tanggal_disposisi', [$range[0], $range[1]]);
            }
        }

        // ✅ Ambil hasil akhir
        $disposisis = $query->orderBy('created_at', 'desc')
            ->paginate(10)
            ->appends($request->query());

        return view('pages.shared.outbox', [
            'disposisis' => $disposisis,
            'pageTitle' => 'Outbox: Riwayat Disposisi Terkirim'
        ]);
    }

    // app/Http/Controllers/InboxController.php
    public function ditolak(Request $request)
    {
        $disposisis = Disposisi::where('ke_user_id', Auth::id())
            ->where('tipe_aksi', 'Kembalikan') // <-- Kunci query
            ->whereIn('status', ['Menunggu', 'Dilihat'])
            ->with(['suratMasuk', 'pengirim.role'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('pages.shared.ditolak', compact('disposisis'));
    }
}