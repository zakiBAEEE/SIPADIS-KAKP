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
    public function getUsersForDisposisiDropdown(): Collection
    {
        $users = User::with(['divisi', 'role'])->orderBy('name')->get();

        return $users->map(function ($user) {
            if ($user->divisi && $user->role->name === 'Katimja') {
                return [
                    'value' => $user->id,
                    'display' => $user->divisi->nama_divisi . ' (Katimja)',
                ];
            } else {
                $role = optional($user->role)->name ?? 'Tanpa Role';
                return [
                    'value' => $user->id,
                    'display' => $role,
                ];
            }
        });
    }
}