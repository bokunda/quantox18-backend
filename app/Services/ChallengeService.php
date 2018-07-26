<?php

namespace App\Services;

use App\Challenge;
use App\Game;
use App\Transformers\ChallengeTransformer;
use App\Transformers\GameTransformer;

/**
 * Class AuthService
 * @package App\Services
 */
class ChallengeService
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $challenges = Challenge::get();
        
        if (count($challenges) > 0) {
            return $challenges;
//            return fractal()
//                ->collection($challenges)
//                ->parseIncludes(['user_one', 'user_two'])
//                ->transformWith(new ChallengeTransformer())
//                ->toArray();
        }
        return response()->json([
            'data' => 'No challenges found',
        ]);
    }
    
    /**
     * @param $challenge_id
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function challenge($challenge_id)
    {
        
        $challenge = Challenge::find($challenge_id);
        
        if ($challenge) {
            
            return $challenge;
//            return fractal()
//                ->item($challenge)
//                ->parseIncludes(['user_one', 'user_two'])
//                ->transformWith(new ChallengeTransformer())
//                ->toArray();
        }
        
        return response()->json([
            'data' => 'No challenge found',
        ]);
    }
    
    public function myChallenge()
    {
        $challenge = Challenge::where(function ($q) {
            $q->where('user_one', auth()->user()->id)
                ->orWhere('user_two', auth()->user()->id);
        })
            ->get();
        
        if ($challenge) {
            
            return $challenge;
//            return fractal()
//                ->collection($challenge)
//                ->parseIncludes(['user_one', 'user_two'])
//                ->transformWith(new ChallengeTransformer())
//                ->toArray();
        }
        return response()->json([
            'data' => 'No challenges found',
        ]);
    }
    
    /**
     * @param $request
     * @param $user_id
     * @return string
     */
    public function create($request, $user_id)
    {
        if ($request->user()->id != $user_id) {
            $challenge           = new Challenge();
            $challenge->user_one = $request->user()->id;
            $challenge->user_two = $user_id;
            $challenge->save();
            
            return $challenge;
            
//            return fractal()
//                ->item($challenge)
//                ->parseIncludes(['user_one', 'user_two'])
//                ->transformWith(new ChallengeTransformer())
//                ->toArray();
        }
        return response()->json([
            'data' => 'You cannot play with yourself.',
        ]);
    }
    
    /**
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function accept($request, $challenge_id)
    {
        $challenge = Challenge::find($challenge_id);
        
        if ($challenge->user_two !== $request->user()->id) {
            return response()->json([
                'data' => 'Only user two can accept game.'
            ]);
        }
        
        if ($challenge->user_two_accepted == 1) {
            return response()->json([
                'data' => 'You already accepted to play.'
            ]);
        }
        
        $challenge->update([
            'user_two_accepted' => 1
        ]);
        
        $gs = new GameService();
        
        return $gs->create($challenge_id);
    }
}