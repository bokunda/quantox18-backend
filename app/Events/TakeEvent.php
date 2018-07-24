<?php

namespace App\Events;

use App\Takes;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TakeEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $take;
    
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Takes $take)
    {
        $this->take = $take;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('games.'.$this->take->game_id);
    }
}
