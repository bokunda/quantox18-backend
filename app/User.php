<?php

namespace App;

use App\Exceptions\Custom;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Class User
 * @package App
 */
class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    
    /**
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
    
    /**
     * @param $challengeId
     * @return bool
     */
    public function canJoinGame($challengeId)
    {
        $challenge = Challenge::find($challengeId);
        
        return $challenge->user_one == $this->id || $challenge->user_two == $this->id;
    }
    
    /**
     * @param $location
     * @param $game_id
     * @return bool
     * @throws Custom
     */
    public function canPlay($location, $game_id)
    {
        $game = Game::find($game_id);
        
        if (in_array($location, $game->takes()->pluck('location')->toArray())) {
            throw new Custom('Take already exists', '403');
        }
        
        if (count($game->takes()->pluck('location')->toArray()) > 9) {
            throw new Custom('The game is over', '403');
        }
        
        if ($game->takes()->first() == null) {
            if ($game->challenge->user_one != $this->id) {
                throw new Custom('User one play\'s first', '403');
            }
        }
        
        if ($game->takes()->first() != null) {
            if ($game->takes->first()->pivot->orderBy('id', 'desc')->first()->next_turn != $this->id) {
                throw new Custom('It\'s not your turn', '403');
            }
        }
        
        if ($game->takes()->count() == 9 && $game->winner == null) {
            throw new Custom('Draw', '403');
        }
        
        if ($game->winner != null) {
            throw new Custom('We have a winner!', '403');
        }
        
        return true;
    }
}
