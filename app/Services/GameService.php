<?php

namespace App\Services;

use App\Exceptions\Custom;
use App\Game;
use App\Takes;

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
            return $games;
        }
        return response()->json([
            'data' => 'No games found',
        ]);
    }
    
    /**
     * @param $challenge_id
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
                        return $game;
                    }
                }
            }
            return $game;
        }
        return response()->json([
            'data' => 'No game found',
        ]);
    }
    
    /**
     * @param $challenge_id
     * @return Game
     */
    public function create($challenge_id)
    {
        $game = new Game();
        
        $game->challenge_id = $challenge_id;
        $game->started      = 1;
        
        $game->save();
        
        return $game;
    }
    
    /**
     * @param $request
     * @param $game_id
     * @return \Illuminate\Http\JsonResponse
     * @throws Custom
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
            '1' => $game->challenge->user_one,
            '2' => $game->challenge->user_two
        ];
        
        if ($user->canPlay($request->location, $game_id)) {
            
            $key = array_search($user->id, $users);
            
            unset($users[$key]);
            
            if (array_key_exists('1', $users)) {
                $next = $users[1];
            } else {
                $next = $users[2];
            }
            $take = new Takes();
            
            $take->game_id   = $game_id;
            $take->user_id   = $user->id;
            $take->location  = $request->location;
            $take->next_turn = $next;
            $take->save();
            
            $game->load('takes');
            
            if ($game->checkWinner()) {
                $game->load('winners');
            }
            
            return $game;
        }
    }
}