<?php

namespace App\Http\Controllers;

use App\Http\Resources\UsersResource;
use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $users = User::where('id', '!=', $request->user()->id)->get();
        
        return UsersResource::collection($users);
    }
}
