<?php

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Broadcasting\Broadcaster;

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

Route::post('broadcasting/auth', 'Auth\BroadcastController@authenticate');


// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/broadcasting/auth', function (Request $request) {
    \Log::info('api - '. json_encode($request->all()));

    if ($request->hasSession()) {
            
        $request->session()->reflash();
        $user = \Auth::user();
        \Log::info('auth2 - '. json_encode($user));
    }


    //Broadcast::auth($request);
});
