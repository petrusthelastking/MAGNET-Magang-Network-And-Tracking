<?php

namespace App\Listeners;

use App\Events\MahasiswaPreferenceUpdated;
use App\Helpers\DecisionMaking\DataPreprocessing;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RunEncodingData
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
    public function handle(MahasiswaPreferenceUpdated $event): void
    {
        DataPreprocessing::dataEncoding($event->mahasiswa);
    }
}
