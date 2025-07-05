<?php

namespace App\Services;

use App\Models\User;
use App\Models\Role; // <-- Pastikan Model Role di-import
use Illuminate\Support\Collection;

class UserService
{
    /**
     * Menyiapkan daftar penerima disposisi yang valid secara dinamis
     * berdasarkan peran dan hierarki di database.
     *
     * @param User $currentUser Pengguna yang akan mengirim disposisi.
     * @return \Illuminate\Support\Collection
     */
    public function getRecipientListFor(User $currentUser): Collection
    {
        // Pengaman jika user karena suatu hal tidak punya role
        if (!$currentUser->role) {
            return collect();
        }

        $roleName = $currentUser->role->name;
        $query = User::query();

        // Logika dinamis berdasarkan peran
        switch ($roleName) {
            case 'Admin':
                // Admin selalu memulai alur dengan mengirim ke Kepala
                $query->whereHas('role', fn($q) => $q->where('name', 'Kepala'));
                break;

            case 'Kepala LLDIKTI':
                $kbuRoleId = Role::where('name', 'KBU')->value('id');
                $katimjaRoleId = Role::where('name', 'Katimja')->value('id');
                $kepalaRoleId = $currentUser->role_id;

                $query->where(function ($q) use ($kbuRoleId, $katimjaRoleId, $kepalaRoleId) {
                    $q->whereHas('role', fn($rq) => $rq->where('id', $kbuRoleId))
                        ->orWhere(function ($nested) use ($katimjaRoleId, $kepalaRoleId) {
                            $nested->whereHas('role', fn($r) => $r->where('id', $katimjaRoleId))
                                ->whereHas('divisi', fn($d) => $d->where('parent_role_id', $kepalaRoleId));
                        });
                });
                break;
            case 'KBU':
                // KBU hanya bisa mengirim ke Katimja yang divisinya berada di bawah KBU
                $kbuRoleId = $currentUser->role_id;
                $query->whereHas('role', fn($q) => $q->where('name', 'Katimja'))
                    ->whereHas('divisi', fn($dq) => $dq->where('parent_role_id', $kbuRoleId));
                break;

            case 'Katimja':
                // Katimja hanya bisa mengirim ke Staf di dalam divisinya sendiri
                $query->where('divisi_id', $currentUser->divisi_id)
                    ->whereHas('role', fn($q) => $q->where('name', 'Staf'));
                break;

            default:
                // Staf atau peran lain tidak bisa mengirim ke siapa-siapa
                return collect();
        }

        // Ambil user yang cocok dan format untuk dropdown
        $users = $query->with('role', 'divisi')->orderBy('name')->get();

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