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
