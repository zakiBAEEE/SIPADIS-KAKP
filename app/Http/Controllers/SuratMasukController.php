<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use App\Services\SuratMasukService; // <--- TAMBAHKAN BARIS INI
use App\Services\SuratRekapitulasiService;
use App\Models\SuratMasuk;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class SuratMasukController extends Controller
{

    protected $rekapService;
    protected $suratMasukService;

    public function __construct(SuratRekapitulasiService $rekapService, SuratMasukService $suratMasukService)
    {
        $this->rekapService = $rekapService;
        $this->suratMasukService = $suratMasukService;
    }

    public function dashboard(Request $request)
    {
        $todayStart = now()->startOfDay();
        $todayEnd = now()->endOfDay();

        $rekapService = new SuratRekapitulasiService();

        $totalToday = $rekapService->getRekapitulasiSurat($todayStart, $todayEnd);

        $tanggalRange = $request->input('tanggal_range');
        $rekapRange = null;
        $tanggalRangeDisplay = 'Per Hari ini';

        // Default chart values
        $series = [
            ['name' => 'Umum', 'data' => []],
            ['name' => 'Pengaduan', 'data' => []],
            ['name' => 'Permintaan Informasi', 'data' => []],
        ];
        $categories = [];

        if ($tanggalRange) {
            [$start, $end] = $rekapService->parseRangeTanggal($tanggalRange);

            $rekapRange = $rekapService->getRekapitulasiSurat($start->copy()->startOfDay(), $end->copy()->endOfDay());

            $tanggalRangeDisplay = $start->translatedFormat('F Y') . ' - ' . $end->translatedFormat('F Y');

            $chart = $rekapService->getChartSeries($start, $end);
            $series = [
                ['name' => 'Umum', 'data' => $chart['series']['umum']],
                ['name' => 'Pengaduan', 'data' => $chart['series']['pengaduan']],
                ['name' => 'Permintaan Informasi', 'data' => $chart['series']['permintaan_informasi']],
            ];
            $categories = $chart['categories'];
        }

        return view('pages.super-admin.home', [
            'totalToday' => $totalToday['total'],
            'umumToday' => $totalToday['umum'],
            'pengaduanToday' => $totalToday['pengaduan'],
            'permintaanInformasiToday' => $totalToday['permintaan_informasi'],
            'rekapRange' => $rekapRange,
            'tanggalRange' => $tanggalRangeDisplay,
            'series' => $series,
            'categories' => $categories
        ]);
    }

    public function detailByKlasifikasi(Request $request)
    {
        $klasifikasi = $request->input('klasifikasi');
        $tanggalRange = $request->input('tanggal_range');
        $query = SuratMasuk::query();

        if ($klasifikasi) {
            $query->where('klasifikasi_surat', $klasifikasi);
        }

        if ($tanggalRange) {
            $dates = explode(' to ', $tanggalRange);
            if (count($dates) === 2) {
                $start = Carbon::parse($dates[0])->startOfDay();
                $end = Carbon::parse($dates[1])->endOfDay();
                $query->whereBetween('created_at', [$start, $end]);
            }
        } else {
            $query->whereDate('created_at', now()->toDateString()); // Default: Hari ini
        }

        $suratList = $query->orderBy('created_at', 'desc')->get();

        return view('pages.super-admin.klasifikasi-surat', [
            'surats' => $suratList,
            'klasifikasi' => $klasifikasi,
            'tanggalRange' => $tanggalRange ?? 'Hari ini',
        ]);
    }

    public function suratTanpaDisposisi(Request $request)
    {
        $query = SuratMasuk::doesntHave('disposisis');

        // Filter berdasarkan berbagai parameter
        if ($request->filled('nomor_agenda')) {
            $query->where('nomor_agenda', 'like', '%' . $request->nomor_agenda . '%');
        }

        if ($request->filled('nomor_surat')) {
            $query->where('nomor_surat', 'like', '%' . $request->nomor_surat . '%');
        }

        if ($request->filled('pengirim')) {
            $query->where('pengirim', 'like', '%' . $request->pengirim . '%');
        }

        // Filter tanggal surat
        if ($request->filled('filter_tanggal_surat')) {
            $range = explode(' to ', $request->filter_tanggal_surat);
            if (count($range) === 2) {
                $query->whereBetween('tanggal_surat', [$range[0], $range[1]]);
            } elseif (count($range) === 1) {
                $query->whereDate('tanggal_surat', $range[0]);
            }
        }

        // Filter tanggal terima
        if ($request->filled('filter_tanggal_terima')) {
            $range = explode(' to ', $request->filter_tanggal_terima);
            if (count($range) === 2) {
                $query->whereBetween('tanggal_terima', [$range[0], $range[1]]);
            } elseif (count($range) === 1) {
                $query->whereDate('tanggal_terima', $range[0]);
            }
        }

        if ($request->filled('perihal')) {
            $query->where('perihal', 'like', '%' . $request->perihal . '%');
        }

        if ($request->filled('klasifikasi_surat')) {
            $query->where('klasifikasi_surat', $request->klasifikasi_surat);
        }

        if ($request->filled('sifat')) {
            $query->where('sifat', $request->sifat);
        }

        // Pagination dan kirim data ke view
        $surats = $query->orderBy('created_at', 'desc')
            ->paginate(8)
            ->appends($request->query());


        return view('pages.super-admin.surat-masuk-tanpa-disposisi', compact('surats'));

    }

    public function suratDenganDisposisi(Request $request)
    {

        $query = SuratMasuk::has('disposisis');


        // Filter berdasarkan berbagai parameter
        if ($request->filled('nomor_agenda')) {
            $query->where('nomor_agenda', 'like', '%' . $request->nomor_agenda . '%');
        }

        if ($request->filled('nomor_surat')) {
            $query->where('nomor_surat', 'like', '%' . $request->nomor_surat . '%');
        }

        if ($request->filled('pengirim')) {
            $query->where('pengirim', 'like', '%' . $request->pengirim . '%');
        }

        // Filter tanggal surat
        if ($request->filled('filter_tanggal_surat')) {
            $range = explode(' to ', $request->filter_tanggal_surat);
            if (count($range) === 2) {
                $query->whereBetween('tanggal_surat', [$range[0], $range[1]]);
            } elseif (count($range) === 1) {
                $query->whereDate('tanggal_surat', $range[0]);
            }
        }

        // Filter tanggal terima
        if ($request->filled('filter_tanggal_terima')) {
            $range = explode(' to ', $request->filter_tanggal_terima);
            if (count($range) === 2) {
                $query->whereBetween('tanggal_terima', [$range[0], $range[1]]);
            } elseif (count($range) === 1) {
                $query->whereDate('tanggal_terima', $range[0]);
            }
        }

        if ($request->filled('perihal')) {
            $query->where('perihal', 'like', '%' . $request->perihal . '%');
        }

        if ($request->filled('klasifikasi_surat')) {
            $query->where('klasifikasi_surat', $request->klasifikasi_surat);
        }

        if ($request->filled('sifat')) {
            $query->where('sifat', $request->sifat);
        }

        // Pagination dan kirim data ke view
        $surats = $query->orderBy('created_at', 'desc')
            ->paginate(8)
            ->appends($request->query());


        return view('pages.super-admin.surat-masuk-dengan-disposisi', compact('surats'));

    }

    public function add()
    {
        return view('pages.super-admin.tambah-surat-masuk');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_agenda' => 'required|string',
            'nomor_surat' => 'required|string',
            'pengirim' => 'required|string',
            'tanggal_surat' => 'required|date',
            'tanggal_terima' => 'required|date',
            'perihal' => 'required|string',
            'klasifikasi_surat' => 'nullable|string',
            'sifat' => 'nullable|string',
            'file_path' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
        ]);

        try {
            if ($request->hasFile('file_path')) {
                $path = $request->file('file_path')->store('surat', 'public');
                $validated['file_path'] = $path;
            }

            $surat = SuratMasuk::create($validated);

            if ($surat) {
                return redirect()->route('surat.tambah')->with('success', 'Surat berhasil ditambahkan!');
            } else {
                return redirect()->route('surat.tambah')->with('error', 'Gagal menambahkan surat. Data tidak valid atau ada masalah lain.');
            }

        } catch (\Illuminate\Database\QueryException $e) {
            Log::error('Database error saat menambahkan surat: ' . $e->getMessage()); // Catat error untuk debugging
            return redirect()->route('surat.tambah')->with('error', 'Gagal menambahkan surat karena masalah database. Silakan coba lagi atau hubungi administrator.');
        } catch (\Exception $e) {
            Log::error('Error umum saat menambahkan surat: ' . $e->getMessage()); // Catat error untuk debugging
            return redirect()->route('surat.tambah')->with('error', 'Terjadi kesalahan yang tidak terduga saat menambahkan surat.');
        }
    }

    public function show($id)
    {
        $surat = SuratMasuk::with([
            'disposisis.pengirim.divisi',
            'disposisis.pengirim.role',
            'disposisis.penerima.divisi',
            'disposisis.penerima.role'
        ])->findOrFail($id);

        $users = User::with(['divisi', 'role'])->get();

        $daftarUser = $users->filter(function ($user) {
            if ($user->divisi) {
                return $user->role && $user->role->name === 'Katimja';
            }
            return true;
        })->map(function ($user) {
            if ($user->divisi && $user->role && $user->role->name === 'Katimja') {
                return [
                    'value' => $user->id,
                    'display' => $user->divisi->nama_divisi,
                ];
            } else {
                $role = optional($user->role)->name ?? 'Tanpa Role';
                return [
                    'value' => $user->id,
                    'display' => $role,
                ];
            }
        });

        return view('pages.super-admin.detail-surat', compact('surat', 'daftarUser'));
    }

    public function edit(SuratMasuk $surat)
    {
        return view('pages.super-admin.edit-surat', compact('surat'));
    }

    public function update(Request $request, SuratMasuk $surat)
    {
        $validated = $request->validate([
            'nomor_agenda' => 'nullable|string',
            'nomor_surat' => 'required|string',
            'pengirim' => 'required|string',
            'tanggal_surat' => 'required|date',
            'tanggal_terima' => 'required|date',
            'perihal' => 'required|string',
            'klasifikasi_surat' => 'nullable|string',
            'sifat' => 'nullable|string',
            'file_path' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
        ]);

        if ($request->hasFile('file_path')) {
            // Hapus file lama jika ada
            if ($surat->file_path && Storage::disk('public')->exists($surat->file_path)) {
                Storage::disk('public')->delete($surat->file_path);
            }

            // Simpan file baru
            $path = $request->file('file_path')->store('surat', 'public');
            $validated['file_path'] = $path;
        }

        $surat->update($validated);

        return redirect()->route('surat.show', ['id' => $surat->id])->with('success', 'Surat berhasil diperbarui!');
    }


    public function destroy(SuratMasuk $surat)
    {
        // Saya mengganti 'Admin' menjadi 'Super Admin Surat' sesuai seeder Anda, sesuaikan jika perlu
        if (auth()->user()->role->name !== 'Admin') {
            // Ganti redirect()->route(...) dengan redirect()->back()
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk menghapus surat.');
        }

        try {
            // Hapus file terkait dari storage jika ada
            if ($surat->file_path && Storage::disk('public')->exists($surat->file_path)) {
                Storage::disk('public')->delete($surat->file_path);
            }

            // Hapus semua data disposisi yang terkait
            $surat->disposisis()->delete();

            // Hapus data surat itu sendiri
            $surat->delete();

            // Ganti redirect()->route(...) dengan redirect()->back()
            return redirect()->back()->with('success', 'Surat berhasil dihapus beserta seluruh disposisinya.');

        } catch (\Exception $e) {
            Log::error('Error saat menghapus surat: ' . $e->getMessage());

            // Ganti redirect()->route(...) dengan redirect()->back()
            return redirect()->back()->with('error', 'Gagal menghapus surat. Terjadi kesalahan pada server.');
        }
    }

    // ...
}






