<?php

namespace App\Http\Controllers;

use App\Models\TimKerja;
use App\Models\Role;
use Illuminate\Http\Request;

class TimKerjaController extends Controller
{


    public function index()
    {
        // Query ini dipertahankan karena dibutuhkan di view
        $indukRoles = Role::whereIn('name', ['Kepala LLDIKTI', 'KBU'])->get();


        // Query untuk data utama
        $timKerjas = TimKerja::orderBy('created_at', 'desc')->paginate(8);

        // Kirim KEDUA variabel ke view menggunakan compact
        return view('pages.tim-kerja.tim-kerja', compact('timKerjas', 'indukRoles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_timKerja' => 'required|string|max:255|unique:timKerja,nama_timKerja',
        ]);

        try {
            TimKerja::create([
                'nama_timKerja' => $request->nama_timKerja,
                'is_active' => true,

            ]);

            return redirect()->route('tim-kerja.index')
                ->with('success', 'Tim kerja berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan tim kerja. Silakan coba lagi atau hubungi administrator.');
        }
    }


    public function edit($id)
    {
        $timKerja = TimKerja::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $timKerja = TimKerja::findOrFail($id);

        $request->validate([
            'nama_timKerja' => 'required|string|max:255|unique:timKerja,nama_timKerja,' . $timKerja->id,
            'is_active' => 'required|boolean',
        ]);

        $timKerja->update([
            'nama_timKerja' => $request->nama_timKerja,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('tim-kerja.index')->with('success', 'Tim kerja berhasil diperbarui.');
    }


    // DELETE: Hapus data
    public function destroy($id)
    {
        $timKerja = TimKerja::findOrFail($id);

        if ($timKerja->users()->exists()) {
            return back()->with('error', 'Tim Kerja ini tidak dapat dihapus karena masih memiliki pengguna di dalamnya.');
        }

        $timKerja->delete();

        return redirect()->route('tim-kerja.index')->with('success', 'Tim kerja berhasil dihapus.');
    }
}
