@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            @include('partials.messages')
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Promocionar Solver</div>
                <div class="panel-body">

                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs nav-justified" role="tablist">
                            <li role="presentation" class="active"><a href="#usuarios" aria-controls="usuarios" role="tab" data-toggle="tab">Usuarios</a></li>
                            <li role="presentation"><a href="#promovidos" aria-controls="promovidos" role="tab" data-toggle="tab">Promovidos</a></li>
                        </ul>
                        <br><br>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane fade in active" id="usuarios">
                                @if($solver->count()==0)
                                    No hay usuarios solver por el momento
                                @endif
                                @foreach($solver as $i => $s)
                                        @if (($i+1)%3==0) <div class="row"> @endif
                                            <div class="col-sm-6 col-md-4">
                                                <div class="thumbnail">
                                                    <div class="media-left media-middle">
                                                        <a href="#">
                                                            <img width=100px height="100px" class="media-object" src="{{$s->avatar}}" alt="{{$s->username}}">
                                                        </a>
                                                    </div>
                                                    <div class="media-body">
                                                        <h4 class="media-heading">{{$s->username}}</h4>
                                                        {!! Form::open(['route' => ['users.promotion'],'method' => 'post']) !!}

                                                        <input type="text" value="{{$s->id}}"  name="id" hidden>
                                                        <input type="text" value=0  name="tipo" hidden>
                                                        {!!Form::submit('Promover',['class'=>'form-control btn-info'])!!}
                                                        {!! Form::close() !!}
                                                    </div>
                                                </div>
                                            </div>
                                            @if (($i+1)%3==0) </div> @endif
                                    @endforeach

                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="promovidos">
                                @if($promovidos->count()==0)
                                    No Tienes usuarios promovidos
                                @endif

                                @foreach($promovidos as $i => $p)
                                        @if (($i+1)%3==0) <div class="row"> @endif
                                            <div class="col-sm-6 col-md-4">
                                                <div class="thumbnail">
                                                    <div class="media-left media-middle">
                                                        <a href="#">
                                                            <img width=100px height="100px" class="media-object" src="{{$p->avatar}}" alt="{{$p->username}}">
                                                        </a>
                                                    </div>
                                                    <div class="media-body">
                                                        <h4 class="media-heading">{{$p->username}}</h4>
                                                        {!! Form::open(['route' => ['users.promotion'],'method' => 'post']) !!}

                                                        <input type="text" value="{{$p->id}}"  name="id" hidden>
                                                        <input type="text" value=1  name="tipo" hidden>
                                                        {!!Form::submit('Degradar usuario',['class'=>'form-control btn-warning'])!!}
                                                        {!! Form::close() !!}
                                                    </div>
                                                </div>
                                            </div>
                                            @if (($i+1)%3==0) </div> @endif
                                @endforeach

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
