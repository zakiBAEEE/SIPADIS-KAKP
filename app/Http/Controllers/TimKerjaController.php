<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use App\Models\Role;
use Illuminate\Http\Request;

class TimKerjaController extends Controller
{


    public function index()
    {
        // Query ini dipertahankan karena dibutuhkan di view
        $indukRoles = Role::whereIn('name', ['Kepala LLDIKTI', 'KBU'])->get();


        // Query untuk data utama
        $divisis = Divisi::orderBy('created_at', 'desc')->paginate(8);

        // Kirim KEDUA variabel ke view menggunakan compact
        return view('pages.super-admin.tim-kerja', compact('divisis', 'indukRoles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_divisi' => 'required|string|max:255|unique:divisis,nama_divisi',
            'parent_role_id' => 'required|exists:roles,id',
        ]);

        try {
            Divisi::create([
                'nama_divisi' => $request->nama_divisi,
                'is_active' => true,
                'parent_role_id' => $request->parent_role_id,
            ]);

            return redirect()->route('timKerja.index')
                ->with('success', 'Tim kerja berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan tim kerja. Silakan coba lagi atau hubungi administrator.');
        }
    }


    public function edit($id)
    {
        $divisi = Divisi::findOrFail($id);
    }

    // UPDATE: Simpan perubahan
    // public function update(Request $request, $id)
    // {
    //     $divisi = Divisi::findOrFail($id);

    //     $request->validate([
    //         'nama_divisi' => 'required|string|max:255|unique:divisis,nama_divisi,' . $divisi->id,
    //     ]);

    //     $divisi->update([
    //         'nama_divisi' => $request->nama_divisi,
    //     ]);

    //     return redirect()->route('timKerja.index')->with('success', 'Tim kerja berhasil diperbarui.');
    // }

    public function update(Request $request, $id)
    {
        $divisi = Divisi::findOrFail($id);

        $request->validate([
            'nama_divisi' => 'required|string|max:255|unique:divisis,nama_divisi,' . $divisi->id,
            'is_active' => 'required|boolean',
        ]);

        $divisi->update([
            'nama_divisi' => $request->nama_divisi,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('timKerja.index')->with('success', 'Tim kerja berhasil diperbarui.');
    }


    // DELETE: Hapus data
    public function destroy($id)
    {
        $divisi = Divisi::findOrFail($id);

        if ($divisi->users()->exists()) {
            return back()->with('error', 'Divisi ini tidak dapat dihapus karena masih memiliki pengguna di dalamnya.');
        }

        $divisi->delete();

        return redirect()->route('timKerja.index')->with('success', 'Tim kerja berhasil dihapus.');
    }
}
