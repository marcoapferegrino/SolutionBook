@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 ">
                <div class="panel panel-info">
                    <div class="panel-heading"><b class=" col-xs-2">Problema: {{$dataProblem->id}}</b><b>{{$dataProblem->title}}</b></div>

                    <div class="panel-body">
                        <div class=" col-xs-offset-1 col-sm-7 ">
                            <b>Autor: </b>{{$dataProblem->author}} <br>
                            <b>Institución: </b>{{$dataProblem->institution}}<br>
                            {{--<b>No Warnings: </b>{{count($warnings)}}<br><br>--}}
                        </div>

                        <div class="row">
                            <div class=" col-xs-8">
                                <b>Descripción</b>
                                <br>
                                {{$dataProblem->description}}
                                <div class="well well-sm  pull-right ">
                                    <b>No Soluciones: </b>{{$dataProblem->numSolutions}}<br>
                                    <b>Límite de tiempo: </b>{{$dataProblem->limitTime}}<br>
                                    <b>Límite de memoria: </b>{{$dataProblem->limitMemory}}<br>
                                    <table class="table table-hover">

                                        <tr><th>Jueces:</th></tr>
                                        <tr>
                                            <td></td>
                                        </tr>

                                    </table>
                                    <b>Enlaces:</b><br>
                                    @foreach($links as $l)
                                        <a href="{{$l->link}}" >{{$l->type}}</a><br>

                                    @endforeach
                                </div>
                                <br>
                                <br>

                            </div>
                        </div>
                        <div class="row">
                            <div class="panel panel-danger col-sm-4">
                                Entradas: <br>6
                                <br>2
                                <br>3
                                <br>5
                            </div>
                            <div class="panel panel-danger col-xs-offset-1  col-sm-4">
                                Salida:<br>2
                                <br>3
                                <br>6
                            </div>
                        </div>

                        <div class=" col-sm-9">
                        @foreach($files as $f)

                            {{$f->name}}
                            <img src="{{$f->path}}">

                            @endforeach
                            </div>

                    </div>
                    <div class="panel panel-info">
                        {{--<b>Soluciones:</b>--}}
                        {{--@foreach($solutions as $s)--}}
                                {{--<br>{{$s->id}} <b>{{$s->ranking}}</b>--}}
                        {{--@endforeach--}}
                        @include('solver.previewsSolution')
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
