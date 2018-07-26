<?php

namespace App\Http\Controllers\Api;

use App\Events\ChallengeEvent;
use App\Events\GameStartedEvent;
use App\Events\TakeEvent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GameController extends Controller
{
    public function index()
    {
        $games = $this->GameService()->index();
        
        return $games;
    }
    public function game($game_id)
    {
        return $this->GameService()->game($game_id);
    }
    public function take(Request $request, $game_id)
    {
        $game = $this->GameService()->take($request, $game_id);
        
        return $game;
    }
}
