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
    Route::post('/register', 'Auth\Api\RegisterController@register')->name('register.api');
    Route::group(['prefix' => 'auth', 'middleware' => 'jwt'], function () {
        Route::get('/logout', 'Auth\Api\AuthController@logout')->name('logout.api');
    });
});
