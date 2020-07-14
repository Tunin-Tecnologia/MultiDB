@extends('layouts.tenant')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div id="app">
                    <example-component usr-id="{{ \Auth::guard('tenant')->user()->id }}"></example-component>
                </div>        

                <div class="card">

                    <div class="card-header">Mensagem</div>

                    <div class="card-body">
                        
                        <form action="" method="post">

                            {{ csrf_field() }}

                            <input type="text" name="titulo" class="form-control" placeholder="Título">

                            <textarea name="mensagem" class="form-control" placeholder="Mensagem"></textarea>

                            <input type="text" name="idusr" class="form-control" placeholder="ID do usuário">

                            <button type="submit" class="btn btn-primary" value="Enviar">Enviar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
