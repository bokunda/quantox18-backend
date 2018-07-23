<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['prefix' => 'v1'], function () {
    Route::group(['middleware' => 'cors'], function () {
        Route::post('/login', 'Auth\Api\AuthController@login')->name('login.api');
        Route::post('/register', 'Auth\Api\AuthController@register')->name('register.api');
        Route::group(['middleware' => 'jwt'], function () {
        
            Route::get('/logout', 'Auth\Api\AuthController@logout')->name('logout.api');
        
            Route::get('/users', 'HomeController@index')->name('home.index');
        
            Route::post('/games/{user_id}', 'GameController@create')->name('game.create');
        });
    });
});
