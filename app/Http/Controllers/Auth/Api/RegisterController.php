<?php

namespace App\Http\Controllers\Auth\Api;

use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\User;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request, User $user)
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
            'token_type' => 'Bearer',
        ]);
    }
}
