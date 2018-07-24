<?php

namespace App\Services;

use App\Events\TakeEvent;
use App\Challenge;
use App\Game;
use App\Takes;
use App\Transformers\ChallengeTransformer;
use App\Transformers\GameTransformer;

/**
 * Class AuthService
 * @package App\Services
 */
class GameService
{
    public function index()
    {
        $games = Game::get();
        
        if (count($games) > 0) {
            return fractal()
                ->collection($games)
                ->parseIncludes(['takes', 'winners'])
                ->transformWith(new GameTransformer())
                ->toArray();
        }
        return response()->json([
            'data' => 'No challenges found',
        ]);
    }
    /**
     * @param $challenge_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function game($challenge_id)
    {
        $challenge = Challenge::find($challenge_id);
        if ($challenge) {
            if ($challenge->takes->count() == 9) {
                $winnings    = [
                    [1, 2, 3],
                    [4, 5, 6],
                    [7, 8, 9],
                    [1, 4, 7],
                    [3, 6, 9],
                    [1, 5, 9],
                    [7, 5, 3],
                ];
                $takesByUser = $challenge->takes()->where('user_id', auth()->user()->id)->pluck('location')->toArray();
                foreach ($winnings as $winning) {
                    if (count(array_intersect($winning, $takesByUser)) == 3) {
                        $challenge->update([
                            'winner' => auth()->user()->id
                        ]);
                        return fractal()
                            ->item($challenge)
                            ->parseIncludes(['takes', 'winners'])
                            ->transformWith(new GameTransformer())
                            ->toArray();
                    }
                }
            }
            return fractal()
                ->item($challenge)
                ->parseIncludes('takes')
                ->transformWith(new GameTransformer())
                ->toArray();
        }
        return response()->json([
            'data' => 'No game found',
        ]);
    }
    
    /**
     * @param $request
     * @param $user_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function create($challenge_id)
    {
        $game = new Game();
        
        $game->challenge_id = $challenge_id;
        $game->started      = 1;
        
        $game->save();
    
        $fractal = fractal()
            ->item($game)
            ->parseIncludes('challenge')
            ->transformWith(new GameTransformer())
            ->toArray();
        
        return $fractal;
    }
    
    /**
     * @param $request
     * @param $challenge_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function take($request, $challenge_id)
    {
        $user      = $request->user();
        $challenge = Challenge::find($challenge_id);
        
        if (!$challenge) {
            return response()->json([
                'data' => "Challenge does not exists."
            ]);
        }
        
        $users = [
            '1' => $challenge->user_one,
            '2' => $challenge->user_two
        ];
        
        if ($user->canPlay($request->location, $challenge_id)) {
            $key = array_search($user->id, $users);
            
            unset($users[$key]);
            
            if (array_key_exists('1', $users)) {
                $next = $users[1];
            } else {
                $next = $users[2];
            }
            $take = new Takes();
            
            $take->game_id   = $challenge_id;
            $take->user_id   = $user->id;
            $take->location  = $request->location;
            $take->next_turn = $next;
            $take->save();
            
            broadcast(new TakeEvent($take))->toOthers();
            
            return fractal()
                ->item($challenge)
                ->parseIncludes(['takes', 'winners'])
                ->transformWith(new GameTransformer())
                ->toArray();
        }
        return response()->json([
            'data' => 'It\'s not your turn, or take already exists.',
        ]);
    }
}