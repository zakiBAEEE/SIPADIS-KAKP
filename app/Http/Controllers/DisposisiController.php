<?php

namespace App\Http\Controllers;
use App\Services\DisposisiService; // Pastikan service di-import
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Controllers\SuratMasukController;
use App\Models\SuratMasuk;
use App\Models\Disposisi;
use App\Models\User;
use Illuminate\Support\Facades\Log;

use App\Models\Lembaga;

class DisposisiController extends Controller
{
    protected $disposisiService;
    public function __construct(DisposisiService $disposisiService)
    {
        $this->disposisiService = $disposisiService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index($suratId)
    {

    }


    public function store(Request $request, SuratMasuk $surat)
    {
        // 1. Validasi input dari form modal
        $validated = $request->validate([
            'ke_user_id' => 'required|exists:users,id',
            'catatan' => 'nullable|string',
            'tanggal_disposisi' => 'required|date',
        ]);

        $pengirim = Auth::user();
        $penerima = User::find($validated['ke_user_id']);


        if ($pengirim->id === $penerima->id) {
            return redirect()->back()->with('error', 'Tidak bisa mendisposisikan surat ke diri sendiri.');
        }

        // 2. Panggil SATU fungsi di service untuk melakukan semua pekerjaan
        $this->disposisiService->forward(
            $surat,
            $pengirim,
            $penerima,
            $validated // Mengirim semua data tervalidasi
        );

        return redirect()->route('surat.show', $surat->id)->with('success', 'Disposisi berhasil diteruskan.');
    }

    // app/Http/Controllers/DisposisiController.php
    public function kembalikan(Request $request, Disposisi $disposisi)
    {
        $request->validate(['catatan_pengembalian' => 'required|string|max:1000']);

       
        // Otorisasi: Pastikan yang mengembalikan adalah penerima asli
        if (Auth::id() !== $disposisi->ke_user_id) {
            abort(403, 'AKSES DITOLAK');
        }

        // 1. Ubah status disposisi asli menjadi 'Dikembalikan'
        $disposisi->update(['status' => 'Dikembalikan']);

        // 2. Buat disposisi baru dengan arah sebaliknya menggunakan service
        // Pastikan DisposisiService sudah di-inject di constructor
        $this->disposisiService->create(
            $disposisi->suratMasuk,                  // Suratnya tetap sama
            Auth::user(),                               // Pengirimnya adalah user saat ini (yang mengembalikan)
            $disposisi->pengirim,               // Penerimanya adalah pengirim disposisi sebelumnya
            $request->input('catatan_pengembalian'),    // Catatannya adalah alasan pengembalian
            now()
        );

        // Redirect ke halaman inbox, karena tugasnya sudah selesai (dikembalikan)
        return redirect()->route('inbox.index')->with('success', 'Disposisi telah dikembalikan ke pengirim.');
    }

    public function update(Request $request, Disposisi $disposisi)
    {
        // Otorisasi sederhana: Sama seperti di metode edit
        $user = auth()->user();
        if ($user->id !== $disposisi->dari_user_id && $user->role->name !== 'Admin') {
            abort(403, 'AKSES DITOLAK');
        }

        $validated = $request->validate([
            // User pengirim tidak bisa diubah, jadi tidak divalidasi
            'ke_user_id' => 'required|exists:users,id',
            'catatan' => 'nullable|string',
            'tanggal_disposisi' => 'required|date',
        ]);

        // Pastikan pengguna tidak mendisposisikan ke diri sendiri
        if ($disposisi->dari_user_id == $request->ke_user_id) {
            return redirect()->back()->withInput()->with('error', 'Tidak bisa mendisposisikan surat ke diri sendiri.');
        }

        try {
            $disposisi->update($validated);

            // Redirect ke halaman detail surat setelah berhasil update
            return redirect()->route('surat.show', $disposisi->surat_id)->with('success', 'Disposisi berhasil diperbarui.');

        } catch (\Exception $e) {
            Log::error('Gagal memperbarui disposisi: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat memperbarui disposisi.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Disposisi $disposisi)
    {
        // 1. Otorisasi: Pastikan hanya pengguna yang berhak yang bisa menghapus.
        //    Contoh: hanya pengirim disposisi asli atau super admin.
        $user = auth()->user();
        if ($user->id !== $disposisi->dari_user_id && $user->role->name !== 'Admin') {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk menghapus disposisi ini.');
        }

        // 2. Proses Hapus dan Redirect
        try {
            $disposisi->delete(); // Menghapus record disposisi dari database

            // Kembali ke halaman sebelumnya dengan pesan sukses
            return redirect()->back()->with('success', 'Disposisi berhasil dihapus.');

        } catch (\Exception $e) {
            // Jika terjadi error, catat di log dan kembali dengan pesan error
            Log::error('Gagal menghapus disposisi: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus disposisi.');
        }
    }

    public function cetak($id)
    {
        // Ambil surat beserta semua disposisinya sekaligus
        $surat = SuratMasuk::with(['disposisis.pengirim', 'disposisis.penerima'])->findOrFail($id);

        // Ambil data lembaga untuk kop surat
        $lembaga = Lembaga::first();

        // Kirim ke view cetak
        return view('pages.super-admin.disposisi-cetak', [
            'surat' => $surat,
            'disposisis' => $surat->disposisis,
            'lembaga' => $lembaga,
        ]);
    }


}
