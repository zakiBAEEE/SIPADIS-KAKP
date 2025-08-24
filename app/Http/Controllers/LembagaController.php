<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lembaga;
use Illuminate\Support\Facades\Storage;

class LembagaController extends Controller
{

    public function index()
    {
        $lembaga = Lembaga::first(); // Asumsikan hanya 1 entri lembaga
        return view('pages.lembaga.lembaga', compact('lembaga'));
    }


    public function edit()
    {
        $lembaga = Lembaga::first();
        return view('pages.lembaga.edit-lembaga', compact('lembaga'));
    }


    public function update(Request $request)
    {
        $request->validate([
            'nama_kementerian' => 'required|string|max:255',
            'nama_lembaga' => 'required|string|max:255',
            'alamat' => 'required|string',
            'telepon' => 'required|string',
            'website' => 'nullable|url',
            'kota' => 'required|string',
            'provinsi' => 'required|string',
            'kepala_kantor' => 'required|string',
            'nip_kepala_kantor' => 'required|string',
            'jabatan' => 'required|string',
            'logo' => 'nullable|file|mimes:jpg,jpeg,png,svg|max:2048',
            'tahun' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
        ]);

        $lembaga = Lembaga::first();

        // Ambil semua data kecuali file logo
        $data = $request->except('logo');

        // Jika ada file logo diunggah
        // if ($request->hasFile('logo')) {
        //     $file = $request->file('logo');
        //     $path = $file->store('logo', 'public'); // disimpan ke storage/app/public/logo
        //     $data['logo'] = $path;
        // }


        if ($request->hasFile('logo')) {
            $file = $request->file('logo');

            // Hapus logo lama jika ada
            if (!empty($lembaga->logo) && Storage::disk('public')->exists($lembaga->logo)) {
                // Hapus dari storage utama
                Storage::disk('public')->delete($lembaga->logo);

                // Jika tidak pakai symlink, hapus juga dari public/storage
                if (!is_link(public_path('storage'))) {
                    $oldLogoPath = public_path('storage/' . $lembaga->logo);
                    if (file_exists($oldLogoPath)) {
                        \Illuminate\Support\Facades\File::delete($oldLogoPath);
                    }
                }
            }

            // Simpan logo baru ke storage/app/public/logo
            $path = $file->store('logo', 'public');
            $data['logo'] = $path;

            // Jika tidak pakai symlink, copy logo baru ke public/storage/logo
            if (!is_link(public_path('storage'))) {
                $source = storage_path('app/public/' . $path);
                $destination = public_path('storage/' . $path);

                \Illuminate\Support\Facades\File::ensureDirectoryExists(dirname($destination));
                \Illuminate\Support\Facades\File::copy($source, $destination);
            }
        }

        $lembaga->update($data);

        return redirect()->route('lembaga.index')->with('success', 'Data lembaga berhasil diperbarui.');
    }

}
