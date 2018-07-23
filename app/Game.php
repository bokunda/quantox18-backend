<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $table = 'games';
    
    protected $fillable = [
        'started',
        'user_two_accepted',
        'winner'
    ];
    
    public function takes()
    {
        return $this->belongsToMany(User::class, 'takes')->withPivot('location', 'next_turn');
    }
}
