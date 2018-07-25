<?php

namespace App\Http\Controllers\Api;

use App\Challenge;
use App\Http\Controllers\Controller;
use App\Http\Resources\GameResource;
use App\Http\Resources\TakeResource;
use App\Takes;
use App\Transformers\GameTransformer;
use App\Transformers\TakesTransformer;
use Illuminate\Http\Request;

/**
 * Class ChallengeController
 * @package App\Http\Controllers\Api
 */
class ChallengeController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return $this->ChallengeService()->index();
    }
    
    /**
     * @param $challenge_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function challenge($challenge_id)
    {
        return $this->ChallengeService()->challenge($challenge_id);
    }
    
    /**
     * @param Request $request
     * @param $user_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request, $user_id)
    {
        $challenge = $this->ChallengeService()->create($request, $user_id);
    
//        $user = User::find($user_id);
//
//        broadcast(new GameChallengeEvent($user));
//
//
        
        return $challenge;
    }
    
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function accept(Request $request, $challenge_id)
    {
        $challenge = $this->ChallengeService()->accept($request, $challenge_id);
        
//        broadcast(new GameStartedEvent($challenge))->toOthers();
        
        return $challenge;
        
    }
    
    /**
     * @param Request $request
     * @param $challenge_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function take(Request $request, $challenge_id)
    {
        return $this->GameService()->take($request, $challenge_id);
    }
}
