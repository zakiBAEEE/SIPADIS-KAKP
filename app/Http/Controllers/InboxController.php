<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Disposisi;
use Carbon\Carbon;

class InboxController extends Controller
{


    public function index(Request $request)
    {
        $query = Disposisi::query()
            ->where('ke_user_id', Auth::id())
            ->with(['suratMasuk', 'pengirim.role']) // Eager loading

            // Tambahan default filter agar tidak menampilkan disposisi reject
            ->whereIn('tipe_aksi', ['Teruskan', 'Revisi'])
            ->whereIn('status', ['Menunggu', 'Dilihat', 'Diteruskan']);

        // ✅ Filter: Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // ✅ Filter: Tipe Aksi
        if ($request->filled('tipe_aksi')) {
            $query->where('tipe_aksi', $request->tipe_aksi);
        }

        // ✅ Filter: Perihal Surat
        if ($request->filled('perihal')) {
            $query->whereHas('suratMasuk', function ($q) use ($request) {
                $q->where('perihal', 'like', '%' . $request->perihal . '%');
            });
        }

        // ✅ Filter: Tanggal Kirim (Range)
        if ($request->filled('filter_tanggal_terkirim')) {
            $range = explode(' to ', $request->filter_tanggal_terkirim);
            if (count($range) === 2) {
                $start = $range[0] . ' 00:00:00';
                $end = $range[1] . ' 23:59:59';
                $query->whereBetween('created_at', [$start, $end]);
            }
        }

        // ✅ Ambil data terfilter dengan paginate
        $disposisis = $query->orderBy('created_at', 'desc')
            ->paginate(10)
            ->appends($request->query());

        return view('pages.shared.inbox', [
            'disposisis' => $disposisis,
            'pageTitle' => 'Inbox Disposisi'
        ]);
    }
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
        if ($request->filled('filter_disposisi_created_at')) {
            $range = explode(' to ', $request->filter_disposisi_created_at);
            if (count($range) === 2) {
                $query->whereBetween('created_at', [$range[0], $range[1]]);
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
   

    public function ditolak(Request $request)
    {
        $query = Disposisi::query()
            ->where('ke_user_id', Auth::id())
            ->where('tipe_aksi', 'Kembalikan')
            ->whereIn('status', ['Menunggu', 'Dilihat'])
            ->with(['suratMasuk', 'pengirim.role']);

        // ✅ Filter: Perihal
        if ($request->filled('perihal')) {
            $query->whereHas('suratMasuk', function ($q) use ($request) {
                $q->where('perihal', 'like', '%' . $request->perihal . '%');
            });
        }

        // ✅ Filter: Tanggal Kirim (range)
        if ($request->filled('filter_tanggal_terkirim')) {
            $range = explode(' to ', $request->filter_tanggal_terkirim);
            if (count($range) === 2) {
                $start = $range[0] . ' 00:00:00';
                $end = $range[1] . ' 23:59:59';
                $query->whereBetween('created_at', [$start, $end]);
            }
        } else {
            $today = Carbon::today();
            $query->whereBetween('created_at', [
                $today->copy()->startOfDay(),
                $today->copy()->endOfDay()
            ]);
        }

        $disposisis = $query->orderBy('created_at', 'desc')
            ->paginate(10)
            ->appends($request->query());

        return view('pages.shared.ditolak', compact('disposisis'));
    }


}