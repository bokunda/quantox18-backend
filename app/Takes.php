<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Takes extends Model
{
    protected $table = 'takes';
    
    protected $fillable = [
        'game_id',
        'user_id',
        'location'
    ];
}
