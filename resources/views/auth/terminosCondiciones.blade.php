@extends('app')

@section('content')
    <div class="container">

        @include('partials.messages')
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-success">
                    <div class="panel-heading"><h4>Términos de Solution Book</h4></div>

                    <div class="panel-body">
                        {!! Form::open([
                        'route' => 'account.termsConditions',
                        'method' => 'get',
                        'class'=>'form-horizontal'])
                        !!}

                        <input type="text" value="{{$nombre}}"  name="nombre" hidden>

                        <input type="text" value="{{$correo}}"  name="correo" hidden>

                        <input type="text" value="{{$avatar}}"  name="avatar" hidden>

                        <div class="form-group ">
                            <div class="row"><center><img width="120px" src="{{ asset('/oie_transparent.png') }}"></center></div>

                            <div class="col-sm-10 col-sm-offset-1">
                            <blockquote ><h3>
                                    Para registrarte a Solution Book debes aceptar los siguientes puntos:</3>
                                <h4>
                                <ul>
                                        <li>Cuando un usuario Problem setter borre un problema el usuario pierde la propiedad sobre el mismo y pasará a propiedad del sistema.

                                            </li>
                                        <li>
                                            Si un usuario Solver da de baja su perfil sus soluciones se seguirán mostrando con su autoría.

                                        </li>
                                        <li>
                                            Si un usuario Problem setter da de baja su perfil los problemas pasarán a ser autoria del sistema.
                                        </li>
                                    </ul>
                                </h4>
                            </blockquote>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-4">
                                <button type=button onClick="parent.location='/home'" class="btn form-control btn-primary" >No gracias</button>
                            </div>
                            <div class="col-sm-1"></div>
                            <div class="col-sm-4">
                                {!!Form::submit('Aceptar',['class'=>'form-control btn-warning'])!!}
                            </div>
                            <div class="col-sm-1"></div>
                        </div>

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
