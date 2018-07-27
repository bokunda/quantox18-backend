<?php

namespace App\Http\Controllers\Api;

use App\Events\GameStartedEvent;
use App\Events\TakeEvent;
use App\Takes;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class GameController
 * @package App\Http\Controllers\Api
 */
class GameController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $games = $this->GameService()->index();
        
        return $games;
    }
    
    /**
     * @param $game_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function game($game_id)
    {
        return $this->GameService()->game($game_id);
    }
    
    /**
     * @param Request $request
     * @param $game_id
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\Custom
     */
    public function take(Request $request, $game_id)
    {
        $game = $this->GameService()->take($request, $game_id);
        
        broadcast(new TakeEvent($game));
        
        return $game;
    }
    
    public function refresh($game_id)
    {
        $takes = $this->GameService()->refresh($game_id);
        
        return $takes;
        
    }
}
