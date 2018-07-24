<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;

/**
 * Class HomeController
 * @package App\Http\Controllers\Api
 */
class HomeController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $users = User::where('id', '!=', $request->user()->id)->get();
        
        return UserResource::collection($users);
    }
}
