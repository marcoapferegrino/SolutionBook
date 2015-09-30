@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 ">
                <div class="panel panel-info">
                    <div class="panel-heading"><b class="">Problema: {{$dataProblem->id}} </b><b class=" col-md-offset-1"> {{$dataProblem->title}}</b></div>

                    <div class="panel-body">
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

                        <div class="row">
                            <div class=" col-sm-5 ">
                            <b>Autor: </b>{{$dataProblem->author}} <br>
                            <b>Institución: </b>{{$dataProblem->institution}}<br>
                            {{--<b>No Warnings: </b>{{count($warnings)}}<br><br>--}}

                                <br>
                                <br>
                            </div>
                            <div class=" col-xs-9">
                                <b>Descripción</b>
                                <br>
                                {{$dataProblem->description}}
                                
                                <br>
                                <br>

                            </div>
                            
                        </div>
                            
                        <div class="row">
                            <div class="panel panel-success  col-sm-12  ">
                            <div class=" col-sm-6">
                                Entrada: <br>6
                                <br>2
                                <br>3
                                <br>5
                            </div>
                            <div class=" col-sm-6">
                                Salida:<br>2
                                <br>3
                                <br>6
                            </div>
                            </div>
                        </div>
                        <div class=" row">
                            <a class="btn btn-default btn-warning btn-lg pull-right " href="{{route('solution.getFormSolution',$dataProblem->id)}}" role="button">
                                Agregar Solución                                    
                            </a>
                            <br>
                        </div>
                        <div class=" row">
                        <br>
<!-- Carousel de imagenes -->
                        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                          <!-- Indicators -->
                          <ol class="carousel-indicators">
                            @foreach($files as $i=>$f)
                            @if($i==0)
                            <li data-target="#carousel-example-generic" data-slide-to="{{$f->id}}" class="active"></li>
                            @else
                            <li data-target="#carousel-example-generic" data-slide-to="{{$f->id}}"></li>
                            @endif
                            @endforeach
                          </ol>

                          <!-- Wrapper for slides -->
                          <div class="carousel-inner" role="listbox">
                            @foreach($files as $i=>$f)
                            @if($i==0)
                            <div class="item active">
                              <img src="{{$f->path}}" alt="{{$f->name}}">
                              <div class="carousel-caption">
                                ...
                              </div>
                            </div>
                            @else
                            <div class="item">
                              <img src="{{$f->path}}" alt="{{$f->name}}">
                              <div class="carousel-caption">
                                {{$f->name}}
                              </div>
                            </div>
                            @endif
                            @endforeach
                          </div>

                          <!-- Controls -->
                          <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                          </a>
                          <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                          </a>
                        </div>
<!-- Fin Carousel -->
                            
                        </div>
                        <br>
                        <br>
                        <br>
                    </div>
                    <div class="col-sm-14">
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
