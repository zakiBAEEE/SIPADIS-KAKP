<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Disposisi;
use App\Models\SuratMasuk;

class InboxController extends Controller
{
    /**
     * Menampilkan halaman inbox yang sesuai dengan peran pengguna yang login.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $roleName = $user->role->name;

        // Gunakan switch untuk menentukan data dan view berdasarkan peran
        switch ($roleName) {
            case 'Kepala':
                $surats = $this->getSuratUntukKepala($user->id, $request);
                return view('pages.kepala.inbox', [
                    'surats' => $surats,
                    'pageTitle' => 'Agenda & Surat Masuk'
                ]);

            case 'KBU':
            case 'Katimja':
            case 'Staf':
                $disposisis = $this->getDisposisiUntukUser($user->id, $request);
                return view('pages.shared.inbox', [
                    'disposisis' => $disposisis,
                    'pageTitle' => 'Inbox Disposisi'
                ]);

            // Jika peran tidak terdefinisi (sebagai fallback), arahkan ke dashboard utama
            default:
                return redirect()->route('dashboard');
        }
    }

    /**
     * Helper private untuk mengambil data surat khusus untuk Kepala.
     */
    private function getSuratUntukKepala($userId, Request $request)
    {
        return SuratMasuk::whereHas('disposisis', function ($query) use ($userId) {
                $query->where('ke_user_id', $userId)
                      ->whereIn('status', ['Terkirim', 'Dilihat']);
            })
            ->with(['disposisis' => function ($query) use ($userId) {
                $query->where('ke_user_id', $userId)->latest();
            }])
            ->filter($request->all()) // Menggunakan scopeFilter dari model SuratMasuk
            ->latest()
            ->paginate(10)
            ->appends($request->query());
    }

    /**
     * Helper private untuk mengambil data disposisi untuk peran selain Kepala.
     */
    private function getDisposisiUntukUser($userId, Request $request)
    {
        return Disposisi::where('ke_user_id', $userId)
                        ->whereIn('status', ['Terkirim', 'Dilihat'])
                        ->with(['surat', 'pengirim.role'])
                        // Jika Anda ingin filter di inbox, Anda perlu membuat scopeFilter di model Disposisi
                        // ->filter($request->all()) 
                        ->latest('tanggal_disposisi')
                        ->paginate(10)
                        ->appends($request->query());
    }
}