<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Challenge
 * @package App
 */
class Challenge extends Model
{
    /**
     * @var string
     */
    protected $table = 'challenges';
    
    /**
     * @var array
     */
    protected $fillable = [
        'started',
        'user_two_accepted',
        'winner'
    ];
    
    /**
     * @var array
     */
    protected $with = ['userOne', 'userTwo'];
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function userOne()
    {
        return $this->belongsToMany(User::class, 'challenges', 'id', 'user_one');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function userTwo()
    {
        return $this->belongsToMany(User::class, 'challenges', 'id', 'user_two');
    }
}
