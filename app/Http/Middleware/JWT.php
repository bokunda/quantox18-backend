<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * Class jwt
 * @package App\Http\Middleware
 */
class JWT
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user() != null) {
            JWTAuth::parseToken()->authenticate();
            return $next($request);
        }
        return response()->json(false);
    }
}
