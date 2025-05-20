<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MahasiswaProfiles extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nim',
        'program_studi_id',
        'semester',
        'alamat',
        'status_magang',
        'foto_path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class);
    }

    public function preferensiMagang()
    {
        return $this->hasMany(PreferensiMagang::class, 'mahasiswa_id');
    }

    public function pengajuanMagang()
    {
        return $this->hasMany(PengajuanMagang::class, 'mahasiswa_id');
    }
}
