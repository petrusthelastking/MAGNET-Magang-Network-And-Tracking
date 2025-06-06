<?php

namespace App\Listeners;

use App\Events\LowonganMagangSaved;
use App\Helpers\DecisionMaking\NumericalEncoding;
use App\Models\LowonganMagangNumerik;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class GenerateNumericValues
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(LowonganMagangSaved $event): void
    {
        $raw = $event->lowonganMagang;

        $numericalData = [
            'lowongan_magang_id' => $raw->id,
            'lokasi_num' => NumericalEncoding::encode('lokasi_num', $raw->lokasi),
            'pekerjaan_num' => NumericalEncoding::encode('pekerjaan_num', $raw->pekerjaan),
            'jenis_magang_num' => NumericalEncoding::encode('jenis_magang_num', $raw->jenis_magang),
            'open_remote_num' => NumericalEncoding::encode('open_remote_num', $raw->open_remote),
            'bidang_industri_num' => 0
        ];

        LowonganMagangNumerik::updateOrCreate(
            ['lowongan_magang_id' => $raw->id],
            $numericalData
        );
    }
}
