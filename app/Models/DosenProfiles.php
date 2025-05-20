<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Log;

class DosenProfiles extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'nip', 'program_studi_id', 'no_hp', 'foto_path'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class);
    }

    public function pengajuanMagang()
    {
        return $this->hasMany(PengajuanMagang::class, 'dosen_id');
    }

    public function logAktivitasMagang()
    {
        return $this->hasMany(LogAktivitasMagang::class, 'dosen_id');
    }
}
