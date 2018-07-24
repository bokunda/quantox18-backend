<?php

namespace App\Http\Controllers\Api;

use App\Game;
use App\Http\Controllers\Controller;
use App\Http\Resources\GameResource;
use App\Http\Resources\TakeResource;
use App\Takes;
use App\Transformers\GameTransformer;
use App\Transformers\TakesTransformer;
use Illuminate\Http\Request;

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
        return $this->GameService()->index();
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
     * @param $user_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request, $user_id)
    {
        return $this->GameService()->create($request, $user_id);
    }
    
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function accept(Request $request)
    {
        return $this->GameService()->accept($request);
    }
    
    /**
     * @param Request $request
     * @param $game_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function take(Request $request, $game_id)
    {
        return $this->GameService()->take($request, $game_id);
    }
}
