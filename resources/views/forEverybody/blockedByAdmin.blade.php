@extends('app')

@section('content')
    <div class="container">

        @include('partials.messages')
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <h3>Cuenta bloqueda</h3>
                    </div>
                    <div class="panel-body" align="middle">
                        <strong> Comunicate con el administrador para mas información</strong> <br>
                        <img src="blocked.jpg" align="middle">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
