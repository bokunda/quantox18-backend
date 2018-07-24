<?php

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

//Broadcast::channel('App.User.{id}', function ($user, $id) {
//    return (int) $user->id === (int) $id;
//});

Broadcast::channel('lobby', function ($user) {
    return ['user' => $user->name, 'id' => $user->id];
});

Broadcast::channel('games.{game_id}', function ($user, $game_id) {
    return $user->canJoinGame($game_id);
});