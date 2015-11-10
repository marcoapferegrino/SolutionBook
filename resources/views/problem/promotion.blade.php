@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            @include('partials.messages')
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <!-- Código del form buscador-->
                        {!! Form::model(Request::only(['buscar']),['route' => 'users.buscarPromovidos','method' => 'GET','class'=>'form-inline navbar-form navbar-left pull-right','role'=>'search']) !!}
                        @include('problem.partials.findProblem')
                        <!--Fin buscador-->
                        <h3> Promocionar Solver</h3>
                    </div>
                    <div class="panel-body">

                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs nav-justified" role="tablist">
                            <li role="presentation" class="active"><a href="#usuarios" aria-controls="usuarios" role="tab" data-toggle="tab"><h4>Usuarios</h4></a></li>
                            <li role="presentation"><a href="#promovidos" aria-controls="promovidos" role="tab" data-toggle="tab"><h4>Promovidos</h4></a></li>
                        </ul>
                        <br><br>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane fade in active" id="usuarios">
                                <div class="row">
                                @if($solver->count()==0)
                                    @if($cadena!=null)
                                        No hay coincidencias con esta búsqueda.
                                    @else
                                        No hay usuarios solver por el momento
                                    @endif
                                @endif
                                @foreach($solver as $i => $s)
                                    @if (($i+1)%3==0) <div class="row"> @endif
                                        <div class="col-sm-6 col-md-4">
                                            <div class="thumbnail">
                                                <div class="media-left media-middle  ">
                                                    <a href="#">
                                                        <img width=100px height="100px" class="media-object" src="{{$s->avatar}}" alt="{{$s->username}}">
                                                    </a>
                                                </div>
                                                <div class="media-body media-left media-middle">
                                                    <h4 class="media-heading">{{$s->username}}</h4><div class=" col-md-14">
                                                        {!! Form::open(['route' => ['users.promotion'],'method' => 'post']) !!}
                                                        <input type="text" value="{{$s->id}}"  name="id" hidden>
                                                        <input type="text" value=0  name="tipo" hidden>
                                                        <button type="submit" class="btn btn-info  pull-left" id="submit-all">Promover</button>

                                                        {!! Form::close() !!}
                                                    </div></div>
                                            </div>
                                        </div>
                                        @if (($i+1)%3==0) </div> @endif
                                @endforeach
                                </div>
                                <div class="row"><center>
                                        {!!$solver->appends(Request::only(['buscar']))->render()!!}
                                    </center>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="promovidos">
                                <div class="row">
                                @if($promovidos->count()==0)
                                    @if($cadena!=null)
                                        No hay coincidencias con esta búsqueda.
                                    @else
                                        No hay usuarios solver por el momento
                                    @endif
                                @endif

                                @foreach($promovidos as $i => $p)
                                    @if (($i+1)%3==0) <div class="row"> @endif
                                        <div class="col-sm-6 col-md-4">
                                            <div class="thumbnail">
                                                <div class="media-left media-middle">
                                                    <a href="#">
                                                        <img  width=100px height="100px"  class="media-object" src="{{$p->avatar}}" alt="{{$p->username}}">
                                                    </a>
                                                </div>
                                                <div class="media-body">
                                                    <h4 class="media-heading">{{$p->username}}</h4><div class=" col-md-14">
                                                        {!! Form::open(['route' => ['users.promotion'],'method' => 'post']) !!}
                                                        <input type="text" value="{{$p->id}}"  name="id" hidden>
                                                        <input type="text" value=1  name="tipo" hidden>
                                                        <button type="submit" class="btn btn-warning  pull-left" id="submit-all">Regresar a Solver</button>

                                                        {!! Form::close() !!}
                                                    </div></div>
                                            </div>
                                        </div>
                                        @if (($i+1)%3==0) </div> @endif
                                @endforeach
                                        </div>
                                        <div class="row"><center>
                                        {!!$promovidos->appends(Request::only(['buscar']))->render()!!}
                                    </center>
                                </div>
                            </div>
                        </div>


                    </div>

                </div>
                <br>
                <br>
                <br>
            </div>
        </div>
    </div>
@endsection
