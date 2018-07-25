<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GameController extends Controller
{
    public function index()
    {
        return $this->GameService()->index();
    }
    public function game($game_id)
    {
        return $this->GameService()->game($game_id);
    }
    public function take(Request $request, $game_id)
    {
        return $this->GameService()->take($request, $game_id);
    }
}
