<?php

namespace App\Http\Controllers\Auth\Api;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * Class AuthController
 * @package App\Http\Controllers\Auth\Api
 */
class AuthController extends Controller
{
    /**
     * @param LoginRequest $request
     * @return UserResource|\Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $credentials = request(['email', 'password']);
        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        JWTAuth::setToken($token);
        $user = new UserResource(JWTAuth::authenticate());
        return (new UserResource($user))->additional([
            'access_token' => $token,
            'token_type'   => 'Bearer',
        ]);
    }
}
