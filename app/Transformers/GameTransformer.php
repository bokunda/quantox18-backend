<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 24.7.18.
 * Time: 09.28
 */

namespace App\Transformers;

use App\Challenge;
use App\Game;

/**
 * Class GameTransformer
 * @package App\Transformers
 */
class GameTransformer extends \League\Fractal\TransformerAbstract
{
    /**
     * @var array
     */
    protected $availableIncludes = [
        'takes',
        'winners',
        'challenge'
    ];
    
    /**
     * @param Challenge $challenge
     * @return array
     */
    public function transform(Game $game)
    {
        return [
            'id'      => $game->id,
            'started' => $game->started,
        ];
    }
    
    /**
     * @param Challenge $challenge
     * @return \League\Fractal\Resource\Collection
     */
    public function includeTakes(Game $game)
    {
        return $this->collection($game->takes, new TakesTransformer());
    }
    
    /**
     * @param Challenge $challenge
     * @return \League\Fractal\Resource\Item
     */
    public function includeWinners(Game $game)
    {
        return $this->item($game->winners, new WinnerTransformer());
    }
    
    public function includeChallenge(Game $game)
    {
        return $this->item($game->challenge, new ChallengeTransformer());
    }
    
}