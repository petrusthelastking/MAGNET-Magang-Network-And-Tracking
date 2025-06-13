<?php

namespace App\Models;

use App\Helpers\DecisionMaking\DataPreprocessing;
use App\Repositories\LokasiMagangRepository;
use App\Repositories\LowonganMagangRepository;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LowonganMagang extends Model
{
    use HasFactory;

    protected $table = 'lowongan_magang';

    protected $fillable = [
        'kuota',
        'pekerjaan_id',
        'deskripsi',
        'persyaratan',
        'jenis_magang',
        'open_remote',
        'status',
        'lokasi_magang_id',
        'perusahaan_id',
    ];

    protected static function booted(): void
    {
        $categorizeDataToPrepareAlternatives = function () {
            $dataCategorizeLocation = LokasiMagangRepository::getAllCategorizeLocation();
            $alternativesData = LowonganMagangRepository::getAllAlternatives();

            $dataProcessing = new DataPreprocessing($alternativesData, $dataCategorizeLocation);
            $dataProcessing->dataCategorization();
        };

        static::created(function () use ($categorizeDataToPrepareAlternatives) {
            $categorizeDataToPrepareAlternatives();
        });

        static::updated(function ()use($categorizeDataToPrepareAlternatives) {
            $categorizeDataToPrepareAlternatives();
        });
    }

    public function lokasi_magang() {
        return $this->belongsTo(LokasiMagang::class);
    }

    public function pekerjaan()
    {
        return $this->belongsTo(Pekerjaan::class);
    }

    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class);
    }

    public function kontrak_magang()
    {
        return $this->hasMany(KontrakMagang::class);
    }
}
