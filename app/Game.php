<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $table = 'games';
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function takes()
    {
        return $this->belongsToMany(User::class, 'takes')->withPivot('location', 'next_turn');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function winners()
    {
        return $this->belongsTo(User::class, 'id');
    }
    
    public function challenge()
    {
        return $this->belongsTo(Challenge::class, 'challenge_id');
    }
}
