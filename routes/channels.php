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

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});


Broadcast::channel('mensagem-recebida.{id}', function ($usr, $id) {
    \Log::info('Channels - '. json_encode($usr) .' <> '. json_encode($id));
    return (int) $usr->id === (int) $id;
});

Broadcast::channel('room.{account}', function ($usr, $account) {
    \Log::info('Channels - '. json_encode($usr) .' <> '. json_encode($account));
    return true;
});