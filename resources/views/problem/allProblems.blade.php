@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-info">
                    <div class="panel-heading">Todos los Problemas</div>
                </div>
                    <div class="">
                        @for($i=0;$i<count($result);$i++)
                            @if (($i+1)%3==0) <div class="row"> @endif
                                <div class="col-sm-6 col-md-4">
                                    <div class="thumbnail">
                                        <img src="{{$avatar[$i]}}" alt="{{$avatar[$i]}}">
                                        <div class="caption">

                                            <h3>{{$result[$i]->title}}</h3>
                                            <p>Límite de tiempo: {{$result[$i]->limitTime}} segundos</p>

                                            <p><a href="{{route('problem.showProblem',$result[$i]->pid)}}" class="btn btn-primary" role="button">Ver</a>
                                                <!-- <a href="#" class="btn btn-default" role="button">Button</a> --></p>

                                        </div>
                                    </div>
                                </div>

                                @if (($i+1)%3==0) </div> @endif

                        @endfor

                    </div>

            </div><div class="row">

                <center>{!!$result->render()!!}</center>
            </div>
            <br>
            <br>
            <br>
        </div>
    </div>
@endsection
