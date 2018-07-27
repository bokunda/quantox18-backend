<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Takes
 * @package App
 */
class Takes extends Model
{
    /**
     * @var string
     */
    protected $table = 'takes';
    
    /**
     * @var array
     */
    protected $fillable = [
        'game_id',
        'user_id',
        'location'
    ];
    
    public function game()
    {
        return $this->belongsTo(Game::class, 'id');
    }
}
