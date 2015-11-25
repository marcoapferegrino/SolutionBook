@extends('app')

@section('content')
    <div class="container">

        @include('partials.messages')
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <h3>Lista de usuarios</h3>
                    </div>
                    <div class="panel-body" align="middle">
                         <br>
                        <table  class="table table-hover">

                        <thead>
                        <tr>
                            <th>   Username</th>
                            <th>   Rol</th>
                            <th>   Estado cuenta</th>
                            <th>   Fecha registro</th>
                            <th>   Acciones</th>


                        </tr>

                        </thead>
                            <tbody>
                            @foreach($users as $user)
                            <tr>

                                    <td><a href="/userPerfil/{{$user->id}}" >{{$user->username}} </a></td>

                                    <td>{{$user->rol}}</td>

                                    <td>{{ \SolutionBook\Components\HtmlBuilder::stateEspañol($user->state) }}</td>

                                    <td>{{$user->created_at}}</td>

                                    <td>
                                        @if($user->state=='blocked'||$user->state=='active')


                                            @if($user->state=='blocked')

                                                {!! Form::open(['route' => 'user.reactiveAccount','method' => 'POST']) !!}
                                                <button type="submit" onclick="return confirm('¿Seguro que quieres continuar?')" class="btn btn-info">
                                                    <input type="hidden" name="user_id" id="user_id" value="{{$user->id}}">

                                                    <i class="fa fa-check-circle"> Desbloquear</i>

                                                    {!! Form::close() !!}
                                                </button>
                                            @elseif($user->state=='active')

                                              {!! Form::open(['route' => 'user.suspendAccount','method' => 'GET']) !!}
                                        <button type="submit" onclick="return confirm('¿Seguro que quieres continuar?')" class="btn btn-warning">

                                            <input type="hidden" name="user_id" id="user_id" value="{{$user->id}}">
                                                        <i class="fa fa-times-circle"> Bloquear</i>
                                        </button>
                                                {!! Form::close() !!}

                                            @endif


                                                @endif


                                    </td>

                            </tr>
                            @endforeach
                            </tbody>


                        </table>
                        {!!$users->render()!!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
