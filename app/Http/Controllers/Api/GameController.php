<?php

namespace App\Http\Controllers\Api;

use App\Game;
use App\Http\Controllers\Controller;
use App\Http\Resources\GameResource;
use App\Http\Resources\TakeResource;
use App\Takes;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index()
    {
        $games = Game::all();
        
        return GameResource::collection($games);
    }
    
    public function game($game_id)
    {
        $game = Game::find($game_id);
        if ($game->takes->count() == 9) {
            $winnings = [
              [1,2,3],
              [4,5,6],
              [7,8,9],
              [1,4,7],
              [3,6,9],
              [1,5,9],
              [7,5,3],
            ];
            $takesByUser = $game->takes()->where('user_id', auth()->user()->id)->pluck('location')->toArray();
            foreach ($winnings as $winning) {
                if (count(array_intersect($winning, $takesByUser)) == 3) {
                    $game->update([
                        'winner' => auth()->user()->id
                    ]);
                    $winner = auth()->user()->name;
                    
                    return response()->json($winner);
                }
            }
        }
        return new GameResource($game);
    }
    
    public function create(Request $request, $user_id)
    {
        if ($request->user()->id != $user_id) {
            $game           = new Game();
            $game->user_one = $request->user()->id;
            $game->user_two = $user_id;
            $game->save();
        }
    }
    
    public function accept(Request $request)
    {
        $game = Game::where('user_two', $request->user()->id)->first();
        $game->update([
            'started'           => 1,
            'user_two_accepted' => 1
        ]);
    }
    
    public function take(Request $request, $game_id)
    {
        $user  = $request->user();
        $game     = Game::find($game_id);
        
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
                $takes = new Takes();
    
                $takes->game_id   = $game_id;
                $takes->user_id   = $user->id;
                $takes->location  = $request->location;
                $takes->next_turn = $next;
                $takes->save();
                
                return new TakeResource($takes);
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
