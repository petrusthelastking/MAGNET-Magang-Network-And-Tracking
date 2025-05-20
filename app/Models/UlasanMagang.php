<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UlasanMagang extends Model
{
    use HasFactory;

    protected $table = 'ulasan_magang';

    protected $fillable = ['pengajuan_id', 'rating', 'ulasan', 'is_published', 'is_anonymous'];

    public function pengajuan()
    {
        return $this->belongsTo(PengajuanMagang::class, 'pengajuan_id');
    }
}
