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

    public function getDaftarPenerimaDisposisi(User $currentUser): Collection
    {
        // Pengaman jika user karena suatu hal tidak punya role
        if (!$currentUser->role) {
            return collect();
        }

        $roleName = $currentUser->role->name;
        $query = User::query()->where('is_active', true);

        // Logika dinamis berdasarkan peran
        switch ($roleName) {
            case 'Admin':
                $query->where(function ($q) {
                    // Kepala LLDIKTI atau KBU
                    $q->whereHas('role', fn($r) => $r->whereIn('name', ['Kepala LLDIKTI', 'KBU']))

                        // Atau Katimja dengan syarat aktif + tim kerja aktif
                        ->orWhere(function ($sub) {
                            $sub->whereHas('role', fn($r) => $r->where('name', 'Katimja'))
                                ->where('is_active', true)
                                ->whereHas('timKerja', fn($d) => $d->where('is_active', true));
                        });
                });
                break;

            case 'Kepala LLDIKTI':
                $kbuRoleId = Role::where('name', 'KBU')->value('id');
                $katimjaRoleId = Role::where('name', 'Katimja')->value('id');

                $query->where(function ($q) use ($kbuRoleId, $katimjaRoleId) {
                    // User Katimja yang aktif dan tim kerja aktif
                    $q->where(function ($sub) use ($katimjaRoleId) {
                        $sub->whereHas('role', fn($r) => $r->where('name', 'Katimja'))
                            ->where('is_active', true)
                            ->whereHas('timKerja', fn($d) => $d->where('is_active', true));
                    })
                        // Atau user KBU yang aktif
                        ->orWhere(function ($sub) use ($kbuRoleId) {
                            $sub->whereHas('role', fn($r) => $r->where('id', $kbuRoleId))
                                ->where('is_active', true);
                        });
                });
                break;


            case 'KBU':
                $query->whereHas('role', fn($r) => $r->where('name', 'Katimja'))
                    ->where('is_active', true)
                    ->whereHas('timKerja', fn($d) => $d->where('is_active', true));
                break;



            case 'Katimja':
                $query->where('tim_kerja_id', $currentUser->tim_kerja_id)
                    ->whereHas('role', fn($q) => $q->where('name', 'Staf'))
                    ->whereHas('timKerja', fn($d) => $d->where('is_active', true)); // Tambahan
                break;

            default:
                // Staf atau peran lain tidak bisa mengirim ke siapa-siapa
                return collect();
        }

        // Ambil user yang cocok dan format untuk dropdown
        $users = $query->with('role', 'timKerja')->orderBy('name')->get();

        return $users->map(function ($user) {
            $display = $user->name;
            if ($user->role) {
                $display .= ' (' . $user->role->name . ')';
            }
            if ($user->timKerja) {
                $display .= ' - ' . $user->timKerja->nama_timKerja;
            }
            return ['value' => $user->id, 'display' => $display];
        });
    }

    public function getDaftarPenerimaSuratDikembalikan(User $currentUser): Collection
    {
        // Pengaman jika user karena suatu hal tidak punya role
        if (!$currentUser->role) {
            return collect();
        }

        $roleName = $currentUser->role->name;
        $query = User::query()->where('is_active', true);

        // Logika dinamis berdasarkan peran
        switch ($roleName) {
            // Kepala LLDIKTI Ngembaliin ke admin
            case 'Kepala LLDIKTI':
                $query->whereHas('role', fn($q) => $q->where('name', 'Admin'));
                break;

            case 'KBU':
                $query->whereHas('role', function ($q) {
                    $q->whereIn('name', ['Kepala LLDIKTI', 'Admin']);
                });
                break;

            case 'Katimja':
                $query->whereHas('role', function ($q) {
                    $q->whereIn('name', ['Kepala LLDIKTI', 'KBU', 'Admin']);
                });
                break;

            default:
                // Staf atau peran lain tidak bisa mengirim ke siapa-siapa
                return collect();
        }

        // Ambil user yang cocok dan format untuk dropdown
        $users = $query->with('role', 'timKerja')->orderBy('name')->get();

        return $users->map(function ($user) {
            $display = $user->name;
            if ($user->role) {
                $display .= ' (' . $user->role->name . ')';
            }
            if ($user->timKerja) {
                $display .= ' - ' . $user->timKerja->nama_timKerja;
            }
            return ['value' => $user->id, 'display' => $display];
        });
    }
}