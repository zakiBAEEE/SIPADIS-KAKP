<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use Illuminate\Http\Request;

class TimKerjaController extends Controller
{
    // INDEX: Tampilkan semua tim kerja
    public function index()
    {
        $timKerja = Divisi::orderBy('created_at', 'desc')->paginate(8); 
        return view('pages.super-admin.tim-kerja', compact('timKerja'));
    }

    // STORE: Simpan data baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_divisi' => 'required|string|max:255|unique:divisis,nama_divisi',
        ]);

        Divisi::create([
            'nama_divisi' => $request->nama_divisi,
        ]);

        return redirect()->route('timKerja.index')->with('success', 'Tim kerja berhasil ditambahkan.');
    }

    // EDIT: Tampilkan form edit
    public function edit($id)
    {
        $divisi = Divisi::findOrFail($id);
        // return view('pages.super-admin.tim-kerja.edit', compact('divisi'));
    }

    // UPDATE: Simpan perubahan
    public function update(Request $request, $id)
    {
        $divisi = Divisi::findOrFail($id);

        $request->validate([
            'nama_divisi' => 'required|string|max:255|unique:divisis,nama_divisi,' . $divisi->id,
        ]);

        $divisi->update([
            'nama_divisi' => $request->nama_divisi,
        ]);

        return redirect()->route('timKerja.index')->with('success', 'Tim kerja berhasil diperbarui.');
    }

    // DELETE: Hapus data
    public function destroy($id)
    {
        $divisi = Divisi::findOrFail($id);
        $divisi->delete();

        return redirect()->route('timKerja.index')->with('success', 'Tim kerja berhasil dihapus.');
    }
}
