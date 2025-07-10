<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'password',
        'role_id',
        'divisi_id',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            static::cekRoleUnik($user);
        });

        static::updating(function ($user) {
            // Hanya jalankan validasi kalau status akan diaktifkan
            if ($user->is_active && $user->getOriginal('is_active') == false) {
                static::cekRoleUnik($user);
            }

            // Jika role_id atau divisi_id diubah, validasi juga
            if (
                $user->isDirty('role_id') ||
                $user->isDirty('divisi_id')
            ) {
                static::cekRoleUnik($user);
            }
        });
    }

    protected static function cekRoleUnik($user)
    {
        $roleName = optional($user->role)->name;

        if (in_array($roleName, ['Admin', 'Kepala LLDIKTI', 'KBU'])) {
            $sudahAda = User::where('role_id', $user->role_id)
                ->where('id', '!=', $user->id)
                ->where('is_active', true)
                ->exists();

            if ($sudahAda) {
                throw new \Exception("User dengan peran {$roleName} sudah ada dan aktif.");
            }
        }

        if ($roleName === 'Katimja' && $user->divisi_id) {
            $sudahAda = User::where('role_id', $user->role_id)
                ->where('divisi_id', $user->divisi_id)
                ->where('id', '!=', $user->id)
                ->where('is_active', true)
                ->exists();

            if ($sudahAda) {
                throw new \Exception("Divisi ini sudah memiliki Katimja aktif.");
            }
        }
    }

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function divisi()
    {
        return $this->belongsTo(Divisi::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function disposisiDikirim()
    {
        return $this->hasMany(Disposisi::class, 'dari_user_id');
    }

    public function disposisiDiterima()
    {
        return $this->hasMany(Disposisi::class, 'ke_user_id');
    }
}
