<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $table = 'games';
    
    public function takes()
    {
        return $this->belongsTo(Game::class, 'game_id');
    }
}
