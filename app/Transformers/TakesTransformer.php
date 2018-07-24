<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 24.7.18.
 * Time: 09.28
 */

namespace App\Transformers;

use App\User;

/**
 * Class TakesTransformer
 * @package App\Transformers
 */
class TakesTransformer extends \League\Fractal\TransformerAbstract
{
    /**
     * @param User $user
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'game_id'   => $user->pivot->game_id,
            'user_id'   => $user->pivot->user_id,
            'location'  => $user->pivot->location,
            'next_turn' => $user->pivot->next_turn,
        ];
    }
}