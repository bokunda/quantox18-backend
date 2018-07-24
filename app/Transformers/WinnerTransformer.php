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
 * Class WinnerTransformer
 * @package App\Transformers
 */
class WinnerTransformer extends \League\Fractal\TransformerAbstract
{
    /**
     * @param User $user
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'id'   => $user->id,
            'name' => $user->name,
        ];
    }
}