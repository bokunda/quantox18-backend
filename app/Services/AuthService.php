<?php

namespace App\Services;

use App\Http\Resources\UserResource;
use App\User;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * Class AuthService
 * @package App\Services
 */
class AuthService
{
    /**
     * @param $request
     * @param User $user
     * @return array|\Illuminate\Http\Request|string
     */
    public function register($request, User $user)
    {
        $user->email    = $request->email;
        $user->name     = $request->name;
        $user->password = bcrypt($request->password);
        $user->save();
        $credentials = request(['email', 'password']);
        
        if (!$token = auth()->attempt($credentials)) {
            return response()->json([
                'error' => 'Please check your details'
            ], 401);
        }
        return (new UserResource($user))->additional([
            'access_token' => $token,
            'token_type'   => 'Bearer',
        ]);

    }
    
    /**
     * @return array|\Illuminate\Http\Request|string
     */
    public function login()
    {
        $credentials = request(['email', 'password']);
    
        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        JWTAuth::setToken($token);
        return (new UserResource(JWTAuth::authenticate()))->additional([
            'access_token' => $token,
            'token_type'   => 'Bearer',
        ]);
    }
}