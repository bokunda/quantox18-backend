<?php

namespace App\Events;

use App\Challenge;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * Class GameStartedEvent
 * @package App\Events
 */
class GameStartedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    /**
     * @var Challenge
     */
    public $challenge;
    
    /**
     * GameStartedEvent constructor.
     * @param Challenge $challenge
     */
    public function __construct(Challenge $challenge)
    {
        $this->game = $challenge;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PresenceChannel('lobby');
    }
}
