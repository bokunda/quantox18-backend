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
    
    /**
     * @param $location
     * @param $game_id
     * @return bool
     */
    public function canPlay($location, $game_id)
    {
        $take = Takes::where('game_id', $game_id)->orderBy('id', 'desc')->get();
        
        $game = Game::find($game_id);
        
        if (in_array($location, $take->pluck('location')->toArray())) {
            return false;
        }
        
        if (count($take->pluck('location')->toArray()) > 9) {
            return false;
        }
        
        if ($take->first() == null) {
            if ($game->user_one != $this->id) {
                return false;
            }
        }
        
        if ($take->first() != null) {
            if ($take->first()->next_turn != $this->id) {
                return false;
            }
            return true;
        }
        
        return true;
    }
}
