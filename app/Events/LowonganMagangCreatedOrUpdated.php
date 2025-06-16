<?php

namespace App\Events;

use App\Models\LowonganMagang;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LowonganMagangCreatedOrUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public LowonganMagang $lowonganMagang;

    /**
     * Create a new event instance.
     */
    public function __construct(LowonganMagang $lowonganMagang)
    {
        $this->lowonganMagang = $lowonganMagang;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
