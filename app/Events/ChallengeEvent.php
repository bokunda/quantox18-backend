<?php

namespace App\Events;

use App\Challenge;
use App\Game;
use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ChallengeEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $challenge;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($challenge)
    {
        $this->challenge = $challenge;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PresenceChannel('challenge.'.$this->challenge->id);
    }
}
