<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DosenPembimbing extends Model
{
    use HasFactory;

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

    public function kontakMagang()
    {
        return $this->hasMany(KontrakMagang::class, 'dosen_id');
    }
}
