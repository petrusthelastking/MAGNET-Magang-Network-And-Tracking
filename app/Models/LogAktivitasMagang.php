<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class logAktivitasMagang extends Model
{
    use HasFactory;

    protected $fillable = ['dosen_id', 'pengajuan_id', 'tanggal', 'kegiatan', 'catatan_dosen'];

    public function pengajuan()
    {
        return $this->belongsTo(PengajuanMagang::class, 'pengajuan_id');
    }

    public function dosen()
    {
        return $this->belongsTo(DosenProfiles::class, 'dosen_id');
    }
}
