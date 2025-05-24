<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;

use App\Models\KontrakMagang;

class DosenPembimbing extends Model implements Authenticatable
{
    use HasFactory;
    use \Illuminate\Auth\Authenticatable;

    protected $table = 'dosen_pembimbing';

    protected $fillable = [
        'nama',
        'nidn',
        'password',
        'jenis_kelamin',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'jenis_kelamin' => 'string',
    ];

    public function getRoleName(): string
    {
        return 'dosen';
    }

    public function kontrakMagang()
    {
        return $this->hasMany(KontrakMagang::class, 'dosen_id');
    }
}
