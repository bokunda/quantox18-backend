<?php

namespace App;

use http\Env\Request;
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
    
    public function canPlay($game_id)
    {
        $take = Takes::where('game_id', $game_id)->orderBy('id', 'desc')->first();
        $game = Game::find($game_id);
        
        if ($take != null) {
            if ($take->next_turn == $this->id) {
                return true;
            }
            return false;
        }
        
        if ($game->user_one != $this->id) {
            return false;
        }
        
        return true;
    }
    
    public function takeExists($location, $game_id)
    {
        $take = Takes::where('game_id', $game_id)->pluck('location')->toArray();
        
        if (in_array($location, $take)) {
            return false;
        }
        
        if ($location > 9) {
            return false;
        }
        return true;
    }
}
