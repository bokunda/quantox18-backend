<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Game
 * @package App
 */
class Game extends Model
{
    /**
     * @var string
     */
    protected $table = 'games';
    
    /**
     * @var array
     */
    protected $fillable = [
        'started',
        'user_two_accepted',
        'winner'
    ];
    
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
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function userOne()
    {
        return $this->belongsToMany(User::class, 'games', 'id', 'user_one');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function userTwo()
    {
        return $this->belongsToMany(User::class, 'games', 'id', 'user_two');
    }
}
