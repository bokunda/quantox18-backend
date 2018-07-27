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
        'winner',
    ];
    
    /**
     * @return bool
     */
    public function checkWinner()
    {
        $winnings = [
            [0, 1, 2],
            [3, 4, 5],
            [6, 7, 8],
            [0, 3, 6],
            [2, 5, 8],
            [0, 4, 8],
            [6, 4, 2],
            [1, 4, 7]
        ];
        
        $takesByUser = $this->takes()->where('user_id', auth()->user()->id)->pluck('location')->toArray();
        foreach ($winnings as $winning) {
            if (count(array_intersect($winning, $takesByUser)) == 3) {
                $this->update([
                    'winner' => auth()->user()->id,
                ]);
                return true;
            }
        }
        return false;
    }
    
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
        return $this->belongsTo(User::class, 'winner');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function challenge()
    {
        return $this->belongsTo(Challenge::class, 'challenge_id');
    }
}
