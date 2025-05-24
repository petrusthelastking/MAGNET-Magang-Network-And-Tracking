<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogMagang extends Model
{
    use HasFactory;

    protected $table = 'log_magang';

    protected $fillable = [
        'kontrak_magang_id',
        'kegiatan',
        'tanggal',
        'jam_masuk',
        'jam_keluar',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jam_masuk' => 'datetime:H:i:s',
        'jam_keluar' => 'datetime:H:i:s',
    ];

    public function kontrakMagang()
    {
        return $this->belongsTo(KontrakMagang::class);
    }
}
