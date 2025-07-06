<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\{SuratMasuk, Disposisi, User, Lembaga};
use App\Services\DisposisiService;

class DisposisiController extends Controller
{
    protected $disposisiService;

    public function __construct(DisposisiService $disposisiService)
    {
        $this->disposisiService = $disposisiService;
    }

    public function store(Request $request, SuratMasuk $surat)
    {
        $validated = $request->validate([
            'ke_user_id' => 'required|exists:users,id',
            'catatan' => 'nullable|string',
        ]);

        $pengirim = Auth::user();
        $penerima = User::findOrFail($validated['ke_user_id']);

        if ($pengirim->id === $penerima->id) {
            return redirect()->back()->with('error', 'Tidak bisa mendisposisikan surat ke diri sendiri.');
        }

        $previousDisposisi = $surat->disposisis()
            ->where('ke_user_id', $pengirim->id)
            ->whereIn('status', ['Menunggu', 'Dilihat'])
            ->first();

        if ($previousDisposisi) {
            $previousDisposisi->update(['status' => 'Diteruskan']);
        }

        Disposisi::create([
            'surat_id' => $surat->id,
            'dari_user_id' => $pengirim->id,
            'ke_user_id' => $penerima->id,
            'catatan' => $validated['catatan'],
            'status' => 'Menunggu',
            'tipe_aksi' => 'Teruskan',
        ]);

        $surat->update(['status' => 'Diproses']);

        return redirect()->route('surat.show', $surat->id)->with('success', 'Disposisi berhasil diteruskan.');
    }

    public function kembalikan(Request $request, Disposisi $disposisi)
    {
        $validated = $request->validate([
            'catatan_pengembalian' => 'required|string|max:1000'
        ]);

        DB::transaction(function () use ($disposisi, $validated) {
            $user = Auth::user();
            $userRole = $user->role->name;

            $keUserId = null;

            if ($userRole === 'Kepala LLDIKTI') {
                // Kembali ke Admin pencatat surat
                $keUserId = User::whereHas('role', function ($q) {
                    $q->where('name', 'Admin');
                })->first()?->id;


            } elseif ($userRole === 'KBU') {
                // Kembali ke Kepala
                $keUserId = User::whereHas('role', function ($q) {
                    $q->where('name', 'Kepala LLDIKTI');
                })->first()?->id;

            } elseif ($userRole === 'Katimja') {
                // Kembali ke user yang memiliki role sesuai parent_role_id
                $divisi = $user->divisi;
                $parentRoleId = $divisi->parent_role_id ?? null;

                $keUserId = User::whereHas('role', function ($q) use ($parentRoleId) {
                    $q->where('id', $parentRoleId);
                })->first()?->id;
            }
            // Fallback kalau tetap null
            if (!$keUserId) {
                throw new \Exception("Gagal menentukan user tujuan pengembalian.");
            }

            // Update disposisi lama jadi 'Dikembalikan'
            $disposisi->update(['status' => 'Dikembalikan']);

            // Buat disposisi pengembalian baru
            Disposisi::create([
                'surat_id' => $disposisi->surat_id,
                'dari_user_id' => $user->id,
                'ke_user_id' => $keUserId,
                'catatan' => $validated['catatan_pengembalian'],
                'status' => 'Menunggu',
                'tipe_aksi' => 'Kembalikan',
            ]);

            $disposisi->suratMasuk->update(['status' => 'Dikembalikan']);
        });

        return redirect()->route('inbox.index')->with('success', 'Disposisi berhasil dikembalikan.');
    }
    
    public function kirimKeKepala(SuratMasuk $surat)
    {
        try {
            $admin = Auth::user();
            $kepala = User::whereHas('role', fn($q) => $q->where('name', 'Kepala LLDIKTI'))->firstOrFail();

            $activeDisposisiExists = $surat->disposisis()
                ->whereIn('status', ['Dilihat', 'Diteruskan'])
                ->exists();

            if ($activeDisposisiExists) {
                return redirect()->back()->with('error', 'Surat ini sedang aktif dalam proses disposisi lain.');
            }

            $rejectionTask = $surat->disposisis()
                ->where('ke_user_id', $admin->id)
                ->where('tipe_aksi', 'Kembalikan')
                ->whereIn('status', ['Terkirim', 'Dilihat'])
                ->first();

            if ($rejectionTask) {
                $rejectionTask->update(['status' => 'Ditindaklanjuti']);
            }

            $this->disposisiService->create(
                $surat,
                $admin,
                $kepala,
                'Mohon Arahan Pimpinan.',
                now(),
                'Teruskan'
            );

            return redirect()->back()->with('success', 'Surat hasil revisi berhasil dikirim ke Kepala.');
        } catch (\Exception $e) {
            Log::error('Gagal mengirim surat ke kepala: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem saat mengirim surat.');
        }
    }

    public function kirimUlangKeKepala(SuratMasuk $surat)
    {
        $pengirim = Auth::user();
        $kepala = User::whereHas('role', fn($q) => $q->where('name', 'Kepala LLDIKTI'))->firstOrFail();

        DB::transaction(function () use ($surat, $pengirim, $kepala) {
            $previousDisposisi = $surat->disposisis()
                ->where('ke_user_id', $pengirim->id)
                ->whereIn('status', ['Menunggu', 'Dilihat'])
                ->first();

            if ($previousDisposisi) {
                $previousDisposisi->update(['status' => 'Diteruskan']);
            }

            Disposisi::create([
                'surat_id' => $surat->id,
                'dari_user_id' => $pengirim->id,
                'ke_user_id' => $kepala->id,
                'catatan' => 'Hasil Revisian',
                'status' => 'Menunggu',
                'tipe_aksi' => 'Teruskan',
            ]);

            $surat->update(['status' => 'Diproses']);
        });

        return redirect()->route('inbox.ditolak')->with('success', 'Disposisi berhasil dikembalikan.');
    }

    public function cetak($id)
    {
        $surat = SuratMasuk::with(['disposisis.pengirim', 'disposisis.penerima'])->findOrFail($id);
        $lembaga = Lembaga::first();

        return view('pages.super-admin.disposisi-cetak', [
            'surat' => $surat,
            'disposisis' => $surat->disposisis,
            'lembaga' => $lembaga,
        ]);
    }
}
