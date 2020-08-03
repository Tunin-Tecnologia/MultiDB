<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        $view = \Tenant::isTenantRequest() ? 'tenant.auth.login' : 'system.auth.login';
        return view($view);
    }

    public function redirectPath()
    {
        return \Tenant::isTenantRequest() ?
            route('tenant.home', ['prefix' => \Request::route('prefix')]) :
            '/system/home';
    }

    /**
     * The user has logged out of the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        return \Tenant::isTenantRequest() ?
            redirect()->route('tenant.login', ['prefix' => \Request::route('prefix')]) :
            redirect()->route('system.login');
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        $guard = \Tenant::isTenantRequest() ? 'tenant':'system';
        \Log::info('guard - '. json_encode($guard));
        return \Auth::guard($guard);
    }

        /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        $data = $request->only('email', 'password');
        $token = \Auth::guard('api')->attempt($data);

        // $empresa = Empresa::where('ciid', '=', $user['ciidempresa'])->get()->first()->toArray();
        
        // $dados = json_decode($empresa['jsdados'], true);
        // $config = json_decode($empresa['jsconfig'], true);
        // $empresa = array_merge($dados, $config);
        // $empresa = Arr::only($empresa, ['vccidade', 'ccestado', 'bostorage', 'cistorage', 'cidecimais']);

        // if($user['vcfoto'] == 'ñ informado') {
        //     $user['vcfoto'] = \Gravatar::src($user['email']);
        // } else {
        //     $user['vcfoto'] = 'storage/2/avatar/'. $user['vcfoto'];
        // }

        // $whatsapp = soNumero($user['obtelefones']['Whatsapp'][0]);

        // Registrando sessões
        session(['id'           => $user['id']]);
        session(['prefix'       => \Request::route('prefix')]);
        // session(['idempresa'    => $user['ciidempresa']]);
        session(['login'        => $user['email']]);
        session(['nome'         => $user['name']]);
        // session(['cargo'        => @$user['vccargo']]);
        // session(['segmento'     => 1]);
        // session(['foto'         => $user['vcfoto']]);
        // session(['userid'       => '55'. $whatsapp .'@c.br']);
        // session(['lockedscreen' => 2]);
        // session(['config'       => $empresa]);
        session(['tokenjwt'        => $token]);    
    }
}
