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
    Route::post('/login', 'Auth\Api\AuthController@login')->name('login.api');
    Route::post('/register', 'Auth\Api\AuthController@register')->name('register.api');
    Route::group(['middleware' => 'jwt'], function () {
        
        Route::get('/logout', 'Auth\Api\AuthController@logout')->name('logout.api');
        Route::get('/users', 'Api\HomeController@index')->name('home.index');
        
        Route::group(['prefix' => 'challenges'], function () {
            Route::get('/', 'Api\ChallengeController@index')->name('challenge.index');
            Route::get('/me', 'Api\ChallengeController@myChallenge')->name('challenge.my');
            Route::get('/{challenge_id}', 'Api\ChallengeController@challenge')->name('challenge.index');
            Route::post('/{user_id}', 'Api\ChallengeController@create')->name('challenge.create');
            Route::patch('/{challenge_id}', 'Api\ChallengeController@accept')->name('challenge.accept');
            Route::post('/{challenge_id}/take', 'Api\ChallengeController@take')->name('challenge.take');
        });
    
        Route::group(['prefix' => 'games'], function () {
            Route::get('/', 'Api\GameController@index')->name('game.index');
            Route::get('/{game_id}', 'Api\GameController@game')->name('game.index');
            Route::post('/{user_id}', 'Api\GameController@create')->name('game.create');
            Route::patch('/{game_id}', 'Api\GameController@accept')->name('game.accept');
            Route::post('/{game_id}/take', 'Api\GameController@take')->name('game.take');
        });
    });
});
