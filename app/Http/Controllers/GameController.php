<?php

namespace App\Http\Controllers;

use App\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function create(Request $request, $user_id)
    {
        $game = new Game();
        $game->save();
        
        if ($request->user()->id != $user_id) {
            $game->takes()->attach([
                'game_id'  => $game->id,
                'user_one' => $request->user()->id,
                'user_two' => $user_id,
            ]);
        }
    }
}
