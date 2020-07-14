<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\LikeEvent;

class FrontendController extends Controller
{
    public function like(Request $request){
        $params = [
            'name'      => $request->get('name'),
            'message'   => $request->get('name'). ' curtiu sua publicação',
            'id'        => $request->get('id')
        ];
        $user = \Auth::user();
        $account = 'cupdown';
        broadcast(new \App\Events\SendStatus($user, $account));

        // FIRE EVENT
        broadcast(new LikeEvent($params, 'like'));
        
     }
}
