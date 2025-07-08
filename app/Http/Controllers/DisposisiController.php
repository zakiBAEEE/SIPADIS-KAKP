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
            'catatan' => 'required|string|max:1000',
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

        return redirect()->route('inbox.index', $surat->id)->with('success', 'Disposisi berhasil diteruskan.');
    }

    public function disposisiKeSemuaStaf(SuratMasuk $surat, Request $request)
    {
        $katimja = Auth::user();

        // Validasi catatan (jika dikirim)
        $validated = $request->validate([
            'catatan' => 'nullable|string|max:255',
        ]);
        $pengirim = Auth::user();
        $previousDisposisi = $surat->disposisis()
            ->where('ke_user_id', $pengirim->id)
            ->whereIn('status', ['Menunggu', 'Dilihat'])
            ->first();

        if ($previousDisposisi) {
            $previousDisposisi->update(['status' => 'Diteruskan']);
        }

        try {
            DB::transaction(function () use ($katimja, $surat, $validated) {
                // Ambil semua staf dalam divisi Katimja
                $stafs = User::where('divisi_id', $katimja->divisi_id)
                    ->whereHas('role', fn($q) => $q->where('name', 'Staf'))
                    ->get();

                foreach ($stafs as $staf) {
                    Disposisi::create([
                        'surat_id' => $surat->id,
                        'dari_user_id' => $katimja->id,
                        'ke_user_id' => $staf->id,
                        'catatan' => $validated['catatan'] ?? 'Mohon ditindaklanjuti',
                        'status' => 'Menunggu',
                        'tipe_aksi' => 'Teruskan',
                    ]);
                }

                // Update status surat jika perlu
                $surat->update(['status' => 'Diproses']);
            });

            return redirect()->route('outbox.index', $surat->id)->with('success', 'Surat berhasil didisposisikan ke semua staf.');
        } catch (\Exception $e) {
            \Log::error('Gagal mendisposisikan ke semua staf: ' . $e->getMessage());
            return redirect()->route('outbox.index', $surat->id)->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
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

    public function kembalikanSuratStaf(Request $request, Disposisi $disposisi)
    {
        $user = Auth::user();

        if ($user->role->name !== 'Staf') {
            return redirect()->back()->with('error', 'Anda tidak berhak mengembalikan disposisi ini.');
        }

        $validated = $request->validate([
            'catatan_pengembalian' => 'required|string|max:1000'
        ]);

        try {

            DB::transaction(function () use ($disposisi, $user, $validated) {
                $surat = $disposisi->suratMasuk;

                // Update semua disposisi aktif dari staf untuk surat ini jadi "Dikembalikan"
                $surat->disposisis()
                    ->whereHas('penerima.role', fn($q) => $q->where('name', 'Staf'))
                    ->whereIn('status', ['Menunggu', 'Dilihat'])
                    ->update(['status' => 'Dikembalikan']);

                // Kirim balik ke pengirim disposisi sebelumnya (misal ke Katimja)
                Disposisi::create([
                    'surat_id' => $surat->id,
                    'dari_user_id' => $user->id,
                    'ke_user_id' => $disposisi->dari_user_id,
                    'catatan' => $validated['catatan_pengembalian'],
                    'status' => 'Menunggu',
                    'tipe_aksi' => 'Kembalikan',
                ]);

                // Opsional: update status surat jika perlu
                $surat->update(['status' => 'Dikembalikan']);
            });

            return redirect()->route('inbox.index')->with('success', 'Disposisi berhasil dikembalikan.');
        } catch (\Exception $e) {
            \Log::error('Gagal mengembalikan surat: ' . $e->getMessage());
            return redirect()->route('inbox.index')->with('error', 'Gagal mengembalikan surat: ' . $e->getMessage());
        }
    }

    public function kirimKeKepala(Request $request, SuratMasuk $surat)
    {
        $validated = $request->validate([
            'catatan' => 'required|string|max:1000',
        ]);

        $pengirim = Auth::user();
        $kepala = User::whereHas('role', fn($q) => $q->where('name', 'Kepala LLDIKTI'))->firstOrFail();

        try {
            DB::transaction(function () use ($surat, $pengirim, $kepala, $validated) {
                // Cek apakah pengirim pernah menerima disposisi surat ini
                $previousDisposisi = $surat->disposisis()
                    ->where('ke_user_id', $pengirim->id)
                    ->whereIn('status', ['Menunggu', 'Dilihat'])
                    ->latest()
                    ->first();

                // Jika ada disposisi sebelumnya yang aktif, update status-nya
                if ($previousDisposisi) {
                    $previousDisposisi->update(['status' => 'Diteruskan']);
                }

                // Buat disposisi baru ke Kepala
                Disposisi::create([
                    'surat_id' => $surat->id,
                    'dari_user_id' => $pengirim->id,
                    'ke_user_id' => $kepala->id,
                    'catatan' => $validated['catatan'],
                    'status' => 'Menunggu',
                    'tipe_aksi' => 'Teruskan',
                ]);

                // Update status surat
                $surat->update(['status' => 'Diproses']);
            });

            return redirect()->back()->with('success', 'Surat berhasil dikirim ke Kepala.');
        } catch (\Exception $e) {
            \Log::error('Gagal mengirim surat ke Kepala: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
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
