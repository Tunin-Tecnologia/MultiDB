<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['middleware' => ['jwt.verify']], function() {
    Route::post('broadcasting/auth', 'Auth\BroadcastController@authenticate');
});

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => '/system', 'as' => 'system.'], function () {
    Auth::routes();

    Route::group(['middleware' => 'auth:system'], function(){
        Route::get('home', function () {
            return view('system.home');
        });
    });
});

Route::group(['prefix' => '/{prefix}', 'as' => 'tenant.'], function () {

    Auth::routes();

    Route::group(['middleware' => 'auth:tenant'], function(){
        Route::name('home')->get('home', function () {
            return view('tenant.home');
        });

        Route::post('/like', 'FrontendController@like');
        Route::resource('categories', 'CategoryController');

        Route::get('/mensagens', function () {
            return view('tenant.mensagens.index');
        })->name('mensagens');
        
        Route::post('/mensagens', function () {
            
            $data = request()->all();
            $mensagem = \App\Models\Mensagem::create($data);

            // Get usuário autenticado
            $usr = \App\Models\UserTenant::findOrFail($mensagem->idusr);

            broadcast(new \App\Events\EnviarMensagem($mensagem, $usr))->toOthers();

            return redirect()->route('tenant.mensagens', ['prefix' => \Request::route('prefix')]);
        })->name('mensagens');
    });
});

/*
Route::get('/send', function () {
    broadcast(new \App\Events\EnviarMensagem);
    return 'done';
});
*/

//Route::get('/home', 'HomeController@index')->name('home');
