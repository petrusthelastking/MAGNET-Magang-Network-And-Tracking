<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function hasRole($role)
    {
        return $this->role === $role;
    }

    public function hasAnyRole($roles)
    {
        if (is_array($roles)) {
            return in_array($this->role, $roles);
        }

        return $this->role === $roles;
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isMahasiswa()
    {
        return $this->role === 'mahasiswa';
    }

    public function isDosen()
    {
        return $this->role === 'dosen';
    }

    /**
     * Relasi ke profil mahasiswa.
     */
    public function mahasiswaProfile()
    {
        return $this->hasOne(MahasiswaProfiles::class, 'user_id');
    }

    /**
     * Relasi ke profil dosen.
     */
    public function dosenProfile()
    {
        return $this->hasOne(DosenProfiles::class, 'user_id');
    }

    /**
     * Relasi ke profil admin.
     */
    public function adminProfile()
    {
        return $this->hasOne(AdminProfiles::class, 'user_id');
    }
}
