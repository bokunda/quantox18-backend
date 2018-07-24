<?php

namespace App\Services;

use App\Events\TakeEvent;
use App\Game;
use App\Takes;
use App\Transformers\GameTransformer;

/**
 * Class AuthService
 * @package App\Services
 */
class GameService
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $games = Game::get();
        
        if (count($games) > 0) {
            return fractal()
                ->collection($games)
                ->parseIncludes(['user_one', 'user_two'])
                ->transformWith(new GameTransformer())
                ->toArray();
        }
        return response()->json([
            'data' => 'No games found',
        ]);
    }
    
    /**
     * @param $game_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function game($game_id)
    {
        $game = Game::find($game_id);
        if ($game) {
            if ($game->takes->count() == 9) {
                $winnings    = [
                    [1, 2, 3],
                    [4, 5, 6],
                    [7, 8, 9],
                    [1, 4, 7],
                    [3, 6, 9],
                    [1, 5, 9],
                    [7, 5, 3],
                ];
                $takesByUser = $game->takes()->where('user_id', auth()->user()->id)->pluck('location')->toArray();
                foreach ($winnings as $winning) {
                    if (count(array_intersect($winning, $takesByUser)) == 3) {
                        $game->update([
                            'winner' => auth()->user()->id
                        ]);
                        return fractal()
                            ->item($game)
                            ->parseIncludes(['takes', 'winners'])
                            ->transformWith(new GameTransformer())
                            ->toArray();
                    }
                }
            }
            return fractal()
                ->item($game)
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
    public function create($request, $user_id)
    {
        if ($request->user()->id != $user_id) {
            $game           = new Game();
            $game->user_one = $request->user()->id;
            $game->user_two = $user_id;
            $game->save();
            
            return fractal()
                ->item($game)
                ->parseIncludes(['user_one', 'user_two'])
                ->transformWith(new GameTransformer())
                ->toArray();
        }
        return response()->json([
            'data' => 'You cannot play with yourself.',
        ]);
    }
    
    /**
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function accept($request)
    {
        $game = Game::where('user_two', $request->user()->id)->first();
        if (!$game) {
            return response()->json([
                'data' => 'Only user two can accept game.'
            ]);
        }
        if ($game->user_two_accepted != 0) {
            return response()->json([
                'data' => 'You already accepted to play.'
            ]);
        }
        $game->update([
            'started'           => 1,
            'user_two_accepted' => 1
        ]);
        return fractal()
            ->item($game)
            ->parseIncludes(['user_two'])
            ->transformWith(new GameTransformer())
            ->toArray();
        
    }
    
    /**
     * @param $request
     * @param $game_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function take($request, $game_id)
    {
        $user = $request->user();
        $game = Game::find($game_id);
        
        if (!$game) {
            return response()->json([
                'data' => "Game does not exists."
            ]);
        }
        
        $users = [
            '1' => $game->user_one,
            '2' => $game->user_two
        ];
        
        if ($user->canPlay($game_id)) {
            $key = array_search($user->id, $users);
            
            unset($users[$key]);
            
            if (array_key_exists('1', $users)) {
                $next = $users[1];
            } else {
                $next = $users[2];
            }
            if ($user->takeExists($request->location, $game_id)) {
                $take = new Takes();
                
                $take->game_id   = $game_id;
                $take->user_id   = $user->id;
                $take->location  = $request->location;
                $take->next_turn = $next;
                $take->save();
    
                broadcast(new TakeEvent($take))->toOthers();
                
                return fractal()
                    ->item($game)
                    ->parseIncludes(['takes', 'winners'])
                    ->transformWith(new GameTransformer())
                    ->toArray();
            }
            return response()->json([
                'data' => 'That take already exists.',
            ]);
        }
        return response()->json([
            'data' => 'It\'s not your turn!',
        ]);
    }
}