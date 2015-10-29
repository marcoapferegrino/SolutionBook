@extends('app')

@section('content')
    <div class="container">

        @include('partials.messages')
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Terminos de Solution Book</div>

                    <div class="panel-body">
                        {!! Form::open([
                        'route' => 'account.termsConditions',
                        'method' => 'post',
                        'class'=>'form-horizontal'])
                        !!}

                        <input type="text" value="{{$nombre}}"  name="nombre" hidden>

                        <input type="text" value="{{$correo}}"  name="correo" hidden>

                        <input type="text" value="{{$avatar}}"  name="avatar" hidden>

                        <div class="form-group ">
                            <blockquote><h4>Acepta que todos los problemas que pueda subir se mantendran en el Sistema y si usted los borra solo esta desprendiendose de los derechos de autor de dicho problema</h4>
                            </blockquote>
                        </div>
                        <div class="form-group">
                            <label for="submit" class="col-sm-5 control-label"><strong></strong></label>
                            <div class="col-sm-12">
                                {!!Form::submit('Aceptar',['class'=>'form-control  btn-warning'])!!}
                            </div>

                        </div>

                        {!! Form::close() !!}

                        <a class="btn btn-default btn-info form-control col-sm-4" href="/home" role="button">
                            No, gracias.
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
