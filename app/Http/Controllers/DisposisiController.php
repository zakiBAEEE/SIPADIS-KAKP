<?php

namespace App\Http\Controllers;

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
    /**
     * Display a listing of the resource.
     */
    public function index($suratId)
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    public function store(Request $request, $suratId)
    {
        $validated = $request->validate([
            'dari_user_id' => 'required|exists:users,id',
            'ke_user_id' => 'required|exists:users,id|different:dari_user_id',
            'catatan' => 'nullable|string',
            'tanggal_disposisi' => 'required|date',
        ]);
        // Inject surat_id ke array yang sudah tervalidasi
        $validated['surat_id'] = $suratId;
        Disposisi::create($validated);
        return redirect()->back()->with('success', 'Disposisi berhasil disimpan.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Disposisi $disposisi)
    {
        // Otorisasi sederhana: Pastikan hanya admin atau pengirim asli yang bisa edit
        $user = auth()->user();
        if ($user->id !== $disposisi->dari_user_id && $user->role->name !== 'Super Admin Surat') {
            abort(403, 'AKSES DITOLAK');
        }

        // Ambil semua user untuk pilihan dropdown 'KEPADA'
        $users = User::orderBy('name')->get();

        return view('pages.super-admin.disposisi-edit', compact('disposisi', 'users'));
    }

    /**
     * Memperbarui disposisi yang ada di database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Disposisi  $disposisi
     * @return \Illuminate\Http\RedirectResponse
     */
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
