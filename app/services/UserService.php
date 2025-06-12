<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Collection;

class UserService
{
    /**
     * Menyiapkan daftar pengguna yang diformat untuk dropdown disposisi.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getRecipientListFor(User $currentUser): Collection
    {
        $roleName = $currentUser->role->name;
        $query = User::query();

        // Logika untuk menentukan siapa saja yang bisa menjadi penerima
        switch ($roleName) {
            case 'Super Admin':
            case 'Admin':
                // Admin bisa mengirim ke Kepala untuk memulai alur
                $query->whereHas('role', fn($q) => $q->where('name', 'Kepala'));
                break;
            case 'Kepala LLDIKTI':
                // Kepala hanya bisa mengirim ke KBU
                $query->whereHas('role', fn($q) => $q->where('name', 'KBU'));
                break;
            case 'KBU':
                // KBU hanya bisa mengirim ke Katimja
                $query->whereHas('role', fn($q) => $q->where('name', 'Katimja'));
                break;
            case 'Katimja':
                // Katimja bisa mengirim ke Staf di divisinya sendiri
                $query->where('divisi_id', $currentUser->divisi_id)
                    ->whereHas('role', fn($q) => $q->where('name', 'Staf'));
                break;
            default:
                // Staf atau peran lain tidak bisa mengirim ke siapa-siapa
                return collect(); // Kembalikan koleksi kosong
        }

        $users = $query->orderBy('name')->get();

        // Memformat hasil agar siap digunakan oleh dropdown
        return $users->map(function ($user) {
            $display = $user->name;
            if ($user->role) {
                $display .= ' (' . $user->role->name . ')';
            }
            if ($user->divisi) {
                $display .= ' - ' . $user->divisi->nama_divisi;
            }
            return ['value' => $user->id, 'display' => $display];
        });
    }
}