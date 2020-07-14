<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Tenant</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    
    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">

    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet" />
    <link href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/3.2.1/css/font-awesome.min.css" rel="stylesheet" />
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js" ></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <script>
    $(document).ready(function() {
        var socket  = io('http://www.cupdown.com.br:8888/');
        var urlBase = 'http://www.cupdown.com.br/company5';
        var me      = 0;

        $('#like').click(function(event){
            event.preventDefault();
            var self = $(this);

            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });

            // Envio um AJAX para o Laravel
            $.ajax({
                url: urlBase + '/like',
                type: "POST",
                data: {

                    name    : self.data('name'),
                    id      : me
                },
                success: function(result){
                    console.log('Sucesso!');
                }
            });
        });
        alert();
        let subdomain = 'cupdown';
        Echo.join(`room.${subdomain}`)
        .here((users) => {
            console.log(users);
        })
        .joining((user) => {
            console.log(user);
        })
        .leaving((user) => {
            console.log(user);
        });


        // Registra usuário no Socket
        socket.on('welcome', function(data){
            me = data.id;
        });

        /**
        * Recebe notificação de like
        */
        socket.on('like', function(response){
            
            toastr.success('Notificação de LIKE', response.message)
            /*
            $.toast({
                heading: 'Notificação de LIKE',
                text: response.message,
                loader: true,
                hideAfter: 15000,
                loaderBg: '#000000',
                bgColor: '#385bdc',
                textColor: 'white'
            });
            */
        });
    });
    </script>
</head>
<body>
<div>
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                Tenant
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">
                    @auth('tenant')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('tenant.categories.index', ['prefix' => \Request::route('prefix')]) }}">Categorias</a>
                            <a class="nav-link" href="{{ route('tenant.mensagens', ['prefix' => \Request::route('prefix')]) }}">Mensagem</a>
                        </li>
                    @endauth
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @auth('tenant')
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::guard('tenant')->user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item"
                                   href="{{ route('tenant.logout', ['prefix' => \Request::route('prefix')]) }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form"
                                      action="{{ route('tenant.logout', ['prefix' => \Request::route('prefix')]) }}"
                                      method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link"
                               href="{{ route('tenant.login', ['prefix' => \Request::route('prefix')]) }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link"
                                   href="{{ route('tenant.register', ['prefix' => \Request::route('prefix')]) }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>

    <a href="#" class="btn" id="like" data-name="Diego Souza">CURTIR</a>
</div>

<!-- Scripts -->
<script type="text/javascript" src="{{ mix('/js/app.js') }}"></script>

</body>
</html>
