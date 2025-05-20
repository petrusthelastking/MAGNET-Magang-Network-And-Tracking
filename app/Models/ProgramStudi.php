<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramStudi extends Model
{
    use HasFactory;

    protected $fillable = ['nama_program', 'jenjang'];

    public function mahasiswaProfiles()
    {
        return $this->hasMany(MahasiswaProfiles::class);
    }

    public function dosenProfiles()
    {
        return $this->hasMany(DosenProfiles::class);
    }
}
