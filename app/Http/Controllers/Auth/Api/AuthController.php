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
     * AuthController constructor.
     */
    public function __construct()
    {
        $this->middleware('jwt', ['except' => ['login']]);
    }
    
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
        return (new UserResource(JWTAuth::authenticate()))->additional([
            'access_token' => $token,
            'token_type'   => 'Bearer',
        ]);
    }
    
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }
}
