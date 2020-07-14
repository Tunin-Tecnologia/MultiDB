<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Contracts\Broadcasting\Broadcaster;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Broadcast;

class BroadcastController extends Controller
{
    /**
     * Authenticate the request for channel access.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Illuminate\Contracts\Broadcasting\Broadcaster $broadcaster
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request, Broadcaster $broadcaster)
    {
        \Log::info('BroadcastController - '.  json_encode($request->all()) .'<>'.  json_encode($broadcaster));
        if ($request->hasSession()) {
            $request->session()->reflash();
        }

        return $broadcaster->auth($request);
    }
}