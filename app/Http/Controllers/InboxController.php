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
        $disposisis = Disposisi::where('ke_user_id', Auth::id())
            ->whereIn('status', ['Terkirim', 'Dilihat']) // Hanya tampilkan disposisi aktif
            ->with(['suratMasuk', 'pengirim.role']) // Eager loading untuk performa
            ->latest('tanggal_disposisi')
            ->paginate(10)
            ->appends($request->query());

        // Kirim data ke satu view generik yang sama
        return view('pages.shared.inbox', [
            'disposisis' => $disposisis,
            'pageTitle' => 'Inbox Disposisi'
        ]);
    }

    public function outbox(Request $request)
    {
        // Perubahan kuncinya ada di sini:
        // Kita mencari disposisi di mana PENGIRIMNYA adalah user yang login.
        $disposisis = Disposisi::where('dari_user_id', Auth::id())
            ->with(['surat', 'penerima.role']) // Sekarang kita butuh info penerima
            ->latest('tanggal_disposisi')
            ->paginate(10)
            ->appends($request->query());

        // Kita akan membuat view outbox yang baru
        return view('pages.shared.outbox', [
            'disposisis' => $disposisis,
            'pageTitle' => 'Outbox: Riwayat Disposisi Terkirim'
        ]);
    }
}