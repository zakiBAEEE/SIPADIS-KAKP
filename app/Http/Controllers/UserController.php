<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Divisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * Menampilkan daftar semua pengguna.
     */
    public function index()
    {
        $users = User::with(['role', 'divisi'])->orderBy('created_at', 'desc')->paginate(10);

        $roles = Role::all();
        $divisis = Divisi::all();

        return view('pages.super-admin.pegawai', compact('users', 'roles', 'divisis'));
    }
    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'name' => 'required|string|max:255',
    //         'username' => 'required|string|max:255|unique:users,username',
    //         'role_id' => 'required|exists:roles,id',
    //         'divisi_id' => 'nullable|exists:divisis,id',
    //         'password' => ['required', 'confirmed', Password::min(8)],
    //     ]);

    //     $validated['password'] = Hash::make($validated['password']);
    //     $validated['is_active'] = true;

    //     User::create($validated);

    //     return redirect()->route('pegawai.index')->with('success', 'Pegawai baru berhasil ditambahkan.');
    // }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'role_id' => 'required|exists:roles,id',
            'divisi_id' => 'nullable|exists:divisis,id',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        // Ambil nama role dari ID
        $role = Role::findOrFail($validated['role_id']);
        $roleName = $role->name;

        // Validasi tunggal untuk role sentral
        if (in_array($roleName, ['Admin', 'Kepala LLDIKTI', 'KBU'])) {
            $sudahAda = User::where('role_id', $validated['role_id'])
                ->where('is_active', true)
                ->exists();

            if ($sudahAda) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', "User dengan peran $roleName sudah ada dan aktif.");
            }
        }

        // Validasi satu Katimja per divisi
        if ($roleName === 'Katimja') {
            if (!$validated['divisi_id']) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Katimja wajib memiliki divisi.');
            }

            $sudahAdaKatimja = User::where('role_id', $validated['role_id'])
                ->where('divisi_id', $validated['divisi_id'])
                ->where('is_active', true)
                ->exists();

            if ($sudahAdaKatimja) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Divisi ini sudah memiliki Katimja aktif.');
            }
        }

        // Simpan data
        $validated['password'] = Hash::make($validated['password']);
        $validated['is_active'] = true;

        User::create($validated);

        return redirect()->route('pegawai.index')->with('success', 'Pegawai baru berhasil ditambahkan.');
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'confirmed', Password::min(8)],
            'is_active' => 'required|boolean',
        ]);

        // Hanya update password jika diisi
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            // Hapus password dari array agar tidak menimpa password lama dengan nilai kosong
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        // Otorisasi: Jangan biarkan pengguna menghapus dirinya sendiri
        if (auth()->id() === $user->id) {
            return redirect()->route('pegawai.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        // Otorisasi: Pastikan hanya Super Admin yang bisa menghapus
        if (auth()->user()->role->name !== 'Admin') {
            return redirect()->route('pegawai.index')->with('error', 'Anda tidak memiliki izin untuk menghapus pegawai.');
        }

        // Pencegahan: Cek apakah user memiliki relasi penting (contoh: disposisi)
        if ($user->disposisiDikirim()->exists() || $user->disposisiDiterima()->exists()) {
            return redirect()->route('pegawai.index')->with('error', 'Tidak dapat menghapus pegawai ini karena memiliki riwayat disposisi.');
        }

        $user->delete();

        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil dihapus.');
    }
}