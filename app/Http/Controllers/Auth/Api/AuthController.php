<?php

namespace App\Http\Controllers\Auth\Api;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\User;
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
     * @return array|\Illuminate\Http\Request|string
     */
    public function login(LoginRequest $request)
    {
        $credentials = $this->AuthService()->login();
        return $credentials;
    }
    
    /**
     * @param RegisterRequest $request
     * @param User $user
     * @return array|\Illuminate\Http\Request|string
     */
    public function register(RegisterRequest $request, User $user)
    {
        $credentials = $this->AuthService()->register($request, $user);
        return $credentials;
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
