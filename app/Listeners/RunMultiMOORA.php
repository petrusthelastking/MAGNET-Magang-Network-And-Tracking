<?php

namespace App\Listeners;

use App\Events\MahasiswaPreferenceUpdated;
use App\Helpers\DecisionMaking\MultiMOORA;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RunMultiMOORA
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
        (new MultiMOORA($event->mahasiswa))->computeMultiMOORA();
    }
}
