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
class ChallengeTransformer extends \League\Fractal\TransformerAbstract
{
    /**
     * @var array
     */
    protected $defaultIncludes = [
        'user_one',
        'user_two',
    ];
    
    /**
     * @param Challenge $challenge
     * @return array
     */
    public function transform(Challenge $challenge)
    {
        return [
            'id' => $challenge->id,
        ];
    }
    
    /**
     * @param Challenge $challenge
     * @return \League\Fractal\Resource\Collection
     */
    public function includeUserOne(Challenge $challenge)
    {
        return $this->collection($challenge->userOne, new UserTransformer());
    }
    
    /**
     * @param Challenge $challenge
     * @return \League\Fractal\Resource\Collection
     */
    public function includeUserTwo(Challenge $challenge)
    {
        return $this->collection($challenge->userTwo, new UserTransformer());
    }
}