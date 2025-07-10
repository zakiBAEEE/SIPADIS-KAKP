<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use App\Services\SuratMasukService; // <--- TAMBAHKAN BARIS INI
use App\Services\SuratRekapitulasiService;
use App\Services\DisposisiService;
use App\Models\SuratMasuk;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Services\UserService;      // <-- Import Service


class SuratMasukController extends Controller
{

    protected $rekapitulasiService;
    protected $suratMasukService;
    protected $disposisiService;
    protected $userService;


    public function __construct(SuratRekapitulasiService $rekapitulasiService, SuratMasukService $suratMasukService, DisposisiService $disposisiService, UserService $userService)
    {
        $this->rekapitulasiService = $rekapitulasiService;
        $this->suratMasukService = $suratMasukService;
        $this->disposisiService = $disposisiService;
        $this->userService = $userService;
    }

    public function dashboard(Request $request)
    {
        $tanggalRange = $request->input('tanggal_range');
        $groupBy = $request->input('group_by', 'daily'); // default harian

        if ($tanggalRange) {

            $range = explode(' to ', $tanggalRange);

            $start = Carbon::parse($range[0])->startOfDay();
            $end = Carbon::parse($range[1])->endOfDay();

            $query = SuratMasuk::whereBetween('tanggal_surat', [$start, $end]);


        } else {
            $query = SuratMasuk::whereDate('created_at', now()->toDateString());
        }

        $rekapRange = $this->rekapitulasiService->hitungRekapSurat(clone $query);
        $chartData = $this->rekapitulasiService->getChartData(clone $query, $groupBy); // <-- tambahan groupBy

        return view('pages.super-admin.home', [
            'tanggalRange' => $tanggalRange,
            'rekapRange' => $rekapRange,
            'series' => $chartData['series'],
            'categories' => $chartData['categories'],
        ]);
    }

    public function arsipSurat(Request $request)
    {
        $query = SuratMasuk::whereHas('disposisis');

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
        if ($request->filled('filter_created_at')) {
            $range = explode(' to ', $request->filter_created_at);
            if (count($range) === 2) {
                $query->whereBetween('created_at', [$range[0], $range[1]]);
            } elseif (count($range) === 1) {
                $query->whereDate('created_at', $range[0]);
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


        return view('pages.super-admin.arsip-surat-masuk', compact('surats'));
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

        // Filter tambahan dari form pencarian
        if ($request->filled('nomor_surat')) {
            $query->where('nomor_surat', 'like', '%' . $request->nomor_surat . '%');
        }

        if ($request->filled('pengirim')) {
            $query->where('pengirim', 'like', '%' . $request->pengirim . '%');
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

        // Pagination + mempertahankan parameter query
        $surats = $query->orderBy('created_at', 'desc')
            ->paginate(8)
            ->appends($request->query());

        return view('pages.super-admin.klasifikasi-surat', [
            'surats' => $surats,
            'klasifikasi' => $klasifikasi,
            'tanggalRange' => $tanggalRange ?? 'Hari ini',
        ]);
    }

    public function suratMasukDraft(Request $request)
    {
        $query = SuratMasuk::doesntHave('disposisis');

        // Filter berdasarkan berbagai parameter


        if ($request->filled('nomor_surat')) {
            $query->where('nomor_surat', 'like', '%' . $request->nomor_surat . '%');
        }

        if ($request->filled('pengirim')) {
            $query->where('pengirim', 'like', '%' . $request->pengirim . '%');
        }

        // Filter tanggal surat
        if ($request->filled('filter_tanggal_surat')) {

            $range = explode(' to ', $request->filter_tanggal_surat);
            $start = Carbon::parse($range[0])->startOfDay();
            if (count($range) === 2) {

                $end = Carbon::parse($range[1])->endOfDay();
                $query->whereBetween('tanggal_surat', [$start, $end]);

            } elseif (count($range) === 1) {
                $query->whereDate('tanggal_surat', $range[0]);
            }
        }

        // Filter tanggal terima
        if ($request->filled('filter_created_at')) {

            $range = explode(' to ', $request->filter_created_at);
            $start = Carbon::parse($range[0])->startOfDay();
            if (count($range) === 2) {

                $end = Carbon::parse($range[1])->endOfDay();
                $query->whereBetween('created_at', [$start, $end]);

            } elseif (count($range) === 1) {
                $query->whereDate('created_at', $range[0]);
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


        return view('pages.super-admin.surat-masuk-draft', compact('surats'));

    }

    public function add()
    {
        return view('pages.super-admin.tambah-surat-masuk');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_surat' => 'required|string|unique:surat_masuk,nomor_surat',
            'pengirim' => 'required|string',
            'tanggal_surat' => 'required|date',
            'perihal' => 'required|string',
            'klasifikasi_surat' => 'nullable|string',
            'sifat' => 'nullable|string',
            'file_path' => 'nullable|file|mimes:pdf,doc,docx,jpg,png',
        ]);

        try {
            if ($request->hasFile('file_path')) {
                // Simpan ke storage/app/public/surat
                $path = $request->file('file_path')->store('surat', 'public');
                $validated['file_path'] = $path;

                // Cek apakah public/storage adalah symlink
                if (!is_link(public_path('storage'))) {
                    // HANYA copy file kalau symlink tidak ada (di hosting)
                    $source = storage_path('app/public/' . $path);
                    $destination = public_path('storage/' . $path);

                    \Illuminate\Support\Facades\File::ensureDirectoryExists(dirname($destination));
                    \Illuminate\Support\Facades\File::copy($source, $destination);
                }
            }
            $tahun = now()->format('Y');

            // Ambil ID terakhir yang masih ada untuk tahun ini
            $lastId = SuratMasuk::where('id', 'like', '%-TU-' . $tahun)
                ->orderByDesc('id')
                ->first();

            if ($lastId) {
                // Ambil nomor urut dari bagian depan ID, misalnya: "005-TU-2025"
                $lastUrut = (int) explode('-', $lastId->id)[0];
                $nomorUrut = str_pad($lastUrut + 1, 3, '0', STR_PAD_LEFT);
            } else {
                // Kalau belum ada surat tahun ini
                $nomorUrut = '001';
            }

            $idSurat = "{$nomorUrut}-TU-{$tahun}";
            $validated['id'] = $idSurat;
            $surat = SuratMasuk::create($validated);

            if ($surat) {
                return redirect()->route('surat.tambah')->with('success', 'Surat berhasil ditambahkan!');
            } else {
                return redirect()->route('surat.tambah')->with('error', 'Gagal menambahkan surat.');
            }

        } catch (\Illuminate\Database\QueryException $e) {
            dd($e->getMessage()); // Tampilkan error MySQL langsung di browser

            return redirect()->route('surat.tambah')->with('error', 'Gagal menambahkan surat karena masalah database.');
        } catch (\Exception $e) {
            Log::error('Error umum saat menambahkan surat: ' . $e->getMessage());
            return redirect()->route('surat.tambah')->with('error', 'Terjadi kesalahan tak terduga saat menambahkan surat.');
        }
    }


    public function show(SuratMasuk $surat) // Gunakan Route Model Binding
    {
        $this->disposisiService->tandaiSebagaiDilihat($surat, Auth::user());

        $daftarUser = $this->userService->getRecipientListFor(Auth::user());

        $surat->load(['disposisis.pengirim.role', 'disposisis.penerima.role']);

        return view('pages.super-admin.detail-surat', compact('surat', 'daftarUser'));
    }

    public function edit(SuratMasuk $surat)
    {
        return view('pages.super-admin.edit-surat', compact('surat'));
    }

    // public function update(Request $request, SuratMasuk $surat)
    // {
    //     $validated = $request->validate([
    //         'nomor_surat' => 'required|string',
    //         'pengirim' => 'required|string',
    //         'tanggal_surat' => 'required|date',
    //         'perihal' => 'required|string',
    //         'klasifikasi_surat' => 'nullable|string',
    //         'sifat' => 'nullable|string',
    //         'file_path' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
    //     ]);

    //     // if ($request->hasFile('file_path')) {
    //     //     // Hapus file lama jika ada
    //     //     if ($surat->file_path && Storage::disk('public')->exists($surat->file_path)) {
    //     //         Storage::disk('public')->delete($surat->file_path);
    //     //     }

    //     //     // Simpan file baru
    //     //     $path = $request->file('file_path')->store('surat', 'public');
    //     //     $validated['file_path'] = $path;
    //     // }



    //     if ($request->hasFile('file_path')) {
    //         // Hapus file lama dari storage dan public jika ada
    //         if ($surat->file_path && Storage::disk('public')->exists($surat->file_path)) {
    //             // Hapus dari storage asli
    //             Storage::disk('public')->delete($surat->file_path);

    //             // Jika tidak ada symlink, hapus juga dari public/storage
    //             if (!is_link(public_path('storage'))) {
    //                 $oldCopiedPath = public_path('storage/' . $surat->file_path);
    //                 if (file_exists($oldCopiedPath)) {
    //                     \Illuminate\Support\Facades\File::delete($oldCopiedPath);
    //                 }
    //             }
    //         }
    //         // Simpan file baru ke storage/app/public/surat
    //         $path = $request->file('file_path')->store('surat', 'public');
    //         $validated['file_path'] = $path;

    //         // Jika tidak ada symlink, copy juga ke public/storage/surat
    //         if (!is_link(public_path('storage'))) {
    //             $source = storage_path('app/public/' . $path);
    //             $destination = public_path('storage/' . $path);

    //             \Illuminate\Support\Facades\File::ensureDirectoryExists(dirname($destination));
    //             \Illuminate\Support\Facades\File::copy($source, $destination);
    //         }
    //     }


    //     $surat->update($validated);

    //     return redirect()->route('surat.show', ['surat' => $surat->id])->with('success', 'Surat berhasil diperbarui!');
    // }


    public function update(Request $request, SuratMasuk $surat)
    {
        try {
            $validated = $request->validate([
                'nomor_surat' => 'required|string',
                'pengirim' => 'required|string',
                'tanggal_surat' => 'required|date',
                'perihal' => 'required|string',
                'klasifikasi_surat' => 'nullable|string',
                'sifat' => 'nullable|string',
                'file_path' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
            ]);

            if ($request->hasFile('file_path')) {
                // Hapus file lama dari storage dan public jika ada
                if ($surat->file_path && Storage::disk('public')->exists($surat->file_path)) {
                    Storage::disk('public')->delete($surat->file_path);

                    if (!is_link(public_path('storage'))) {
                        $oldCopiedPath = public_path('storage/' . $surat->file_path);
                        if (file_exists($oldCopiedPath)) {
                            \Illuminate\Support\Facades\File::delete($oldCopiedPath);
                        }
                    }
                }

                $path = $request->file('file_path')->store('surat', 'public');
                $validated['file_path'] = $path;

                if (!is_link(public_path('storage'))) {
                    $source = storage_path('app/public/' . $path);
                    $destination = public_path('storage/' . $path);

                    \Illuminate\Support\Facades\File::ensureDirectoryExists(dirname($destination));
                    \Illuminate\Support\Facades\File::copy($source, $destination);
                }
            }

            $surat->update($validated);

            return redirect()
                ->route('surat.show', ['surat' => $surat->id])
                ->with('success', 'Surat berhasil diperbarui!');
        } catch (\Exception $e) {
            \Log::error('Gagal memperbarui surat: ' . $e->getMessage());

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui surat. Silakan coba lagi.');
        }
    }

    public function destroy(SuratMasuk $surat)
    {
        if (auth()->user()->role->name !== 'Admin') {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk menghapus surat.');
        }

        // try {
        //     if ($surat->file_path && Storage::disk('public')->exists($surat->file_path)) {
        //         Storage::disk('public')->delete($surat->file_path);
        //     }

        //     $surat->disposisis()->delete();

        //     $surat->delete();

        //     return redirect()->back()->with('success', 'Surat berhasil dihapus beserta seluruh disposisinya.');

        // } catch (\Exception $e) {
        //     Log::error('Error saat menghapus surat: ' . $e->getMessage());

        //     return redirect()->back()->with('error', 'Gagal menghapus surat. Terjadi kesalahan pada server.');
        // }

        try {
            if ($surat->file_path && Storage::disk('public')->exists($surat->file_path)) {
                Storage::disk('public')->delete($surat->file_path);

                if (!is_link(public_path('storage'))) {
                    $copiedPath = public_path('storage/' . $surat->file_path);
                    if (file_exists($copiedPath)) {
                        \Illuminate\Support\Facades\File::delete($copiedPath);
                    }
                }
            }

            $surat->disposisis()->delete();

            $surat->delete();

            return redirect()->back()->with('success', 'Surat berhasil dihapus beserta seluruh disposisinya.');

        } catch (\Exception $e) {
            Log::error('Error saat menghapus surat: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Gagal menghapus surat. Terjadi kesalahan pada server.');
        }
    }





}






