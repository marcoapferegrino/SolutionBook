@extends('app')

@section('content')
    <div class="container">

        @include('partials.messages')
        <div class="row">
            <div class="col-md-12">
                <div class="jumbotron">
                    <h1 class="text-center">Cuenta sin confirmar!</h1>


                    <div class="row">
                        <div class="col-md-8 col-lg-offset-2">
                            <p>Por favor ve a tu bandeja de entrada y confirma tu correo</p>
                            <p class="text-danger">Si no recibiste el email por favor ingresa tu email y lo reenviaremos gracias.</p>
                        </div>
                    </div>
                    {!! Form::open(['route' => 'welcome.resendEmailConfirmation','method' => 'POST']) !!}
                        <div class="row">
                            <div class="col-lg-5 col-lg-offset-3">
                                <div class="form-group">
                                    <h3><label for="email"><strong>Email</strong></label></h3>
                                    <input type="email" name="email" class="form-control" id="email" placeholder="Email">
                                </div>
                                {!! Form::submit('Enviar Email',array('class'=>'btn btn-primary btn-lg center-block')) !!}
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
