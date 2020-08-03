<?php

namespace App\Http\Controllers\Auth;


use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Broadcasting\Broadcaster;

class BroadcastController extends Controller
{
    /**
     * Authenticate the request for channel access.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Illuminate\Contracts\Broadcasting\Broadcaster $broadcaster
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        \Log::info('auth - '. json_encode($request->session()->all()));
        if ($request->hasSession()) {
            
            $request->session()->reflash();
            $user = $request->session()->all();
            #\Log::info('auth2 - '. json_encode($request->session()->all()));


            $prefix = $user['prefix'];
            \Log::info('account - '. json_encode($prefix));
            $empresa = null;
            if ($prefix) {
                $company = \App\Models\Company::where('prefix', $prefix)->first();
                if ($company) {
                    \Tenant::setTenant($company);
                }
            }
    
        }

        // $pusher = new \Pusher\Pusher(config('broadcasting.connections.pusher.key'), config('broadcasting.connections.pusher.secret'), config('broadcasting.connections.pusher.app_id'));
    
        // if (\Str::startsWith($request->input('channel_name'), 'private')) {
        //     \Log::info('startsWith - '. json_encode($request->input('socket_id')) .' - '. json_encode($request->input('channel_name')));
        //     return $pusher->socket_auth($request->input('channel_name'), $request->input('socket_id'));
        // } else {
        //     return $pusher->presence_auth($request->input('channel_name'), $request->input('socket_id'), session('id'), ['session' => $request->session()->all()]);
        // }
        $user['channel_name'] = $request->input('channel_name');
        \Log::info('auth3 - '. json_encode($user));
        
        $request = new \Illuminate\Http\Request();
        $request->replace($user);
    
        Broadcast::auth($request);    
    }

    public function authenticateold(Request $request, Broadcaster $broadcaster)
    {
        \Log::info('BroadcastController - '.  json_encode($request->all()) .'<>'.  json_encode($broadcaster));
        if ($request->hasSession()) {
            $request->session()->reflash();
        }
        \Log::info('requests - '.  json_encode($request->session()->all()));
        return $broadcaster->auth($request);
    }
    
}