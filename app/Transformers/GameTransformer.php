<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 24.7.18.
 * Time: 09.28
 */

namespace App\Transformers;

use App\Game;

class GameTransformer extends \League\Fractal\TransformerAbstract
{
    protected $availableIncludes = [
        'takes',
        'winners',
        'user_one',
        'user_two',
    ];
    
    public function transform(Game $game)
    {
        return [
            'id' => $game->id,
        ];
    }
    
    public function includeTakes(Game $game)
    {
        return $this->collection($game->takes, new TakesTransformer());
    }
    
    public function includeWinners(Game $game)
    {
        return $this->item($game->winners, new WinnerTransformer());
    }
    
    public function includeUserOne(Game $game)
    {
        return $this->collection($game->userOne, new UserTransformer());
    }
    
    public function includeUserTwo(Game $game)
    {
        return $this->collection($game->userTwo, new UserTransformer());
    }
}