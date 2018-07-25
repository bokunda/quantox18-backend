<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $table = 'games';
    
    protected $fillable = [
        'winner',
    ];
    
    public function checkWinner()
    {
        if ($this->takes->count() == 9) {
            $winnings    = [
                [1, 2, 3],
                [4, 5, 6],
                [7, 8, 9],
                [1, 4, 7],
                [3, 6, 9],
                [1, 5, 9],
                [7, 5, 3],
            ];
            
            $takesByUser = $this->takes()->where('user_id', auth()->user()->id)->pluck('location')->toArray();
            foreach ($winnings as $winning) {
                if (count(array_intersect($winning, $takesByUser)) == 3) {
                    $this->update([
                        'winner' => auth()->user()->id,
                    ]);
                    return $this;
                }
            }
            return $this;
        }
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
    
    public function challenge()
    {
        return $this->belongsTo(Challenge::class, 'challenge_id');
    }
}
