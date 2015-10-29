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
                            <b>Límite de tiempo: </b>{{$dataProblem->limitTime}} segundos<br>
                            <b>Límite de memoria: </b>{{$dataProblem->limitMemory}} bytes<br>
                            <table class="table table-hover">

                                <tr><th>Jueces:</th></tr>
                                <tr>
                                    <td>{{$judge->name}}</td>
                                </tr>
                                <tr><th>Palabras clave:</th></tr>
                                <tr>
                                    <td>{{$tags}}</td>
                                </tr>
                                <tr><th>Enlaces:</th></tr>
                                @foreach($links as $l)<tr>
                                    <td>
                                    <a href="{{$l->link}}" >{{$l->type}}</a><br>
                                    </td>
                                </tr>
                                @endforeach

                            </table>
                            <br>
                        </div>

                        <div class="row">
                            <div class=" col-sm-5 ">
                                <b>Autor: </b>{{$dataProblem->author}} <br>
                                <b>Institución: </b>{{$dataProblem->institution}}<br>
                                {{--<b>No Warnings: </b>{{count($warnings)}}<br><br>--}}

                                <br>
                                <br>
                            </div>
                            <div class=" col-xs-8">
                                <b>Descripción</b>
                                <br>
                                <pre>{{$dataProblem->description}}</pre>

                                <br>
                                <br>

                            </div>

                        </div>
                        <div class="row">
                            <div class="panel panel-info  col-sm-12  ">
                                    <div class=" col-sm-6">
                                        Ejemplo Entradas: <br>
                                        <pre>{{$entrada}}</pre>
                                    </div>
                                    <div class=" col-sm-6">
                                        Ejemplo Salidas:<br>
                                        <pre>{{$salida}}</pre>
                                    </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="panel panel-success  col-sm-12  ">
                                    <div class=" col-sm-6">
                                        Entradas: <br>
                                        <pre>{{$inputs}}</pre>
                                    </div>
                                    <div class=" col-sm-6">
                                        Salidas:<br>
                                        <pre>{{$outputs}}</pre>
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
                                                <center><img width=600px height="550px" src="{{asset($f->path)}}" alt="{{$f->name}}"></center>
                                                <div class="carousel-caption">
                                                    {{$f->name}}
                                                </div>
                                            </div>
                                        @else
                                            <div class="item">
                                                <center><img width=600px height="550px" src="{{asset($f->path)}}" alt="{{$f->name}}"></center>
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

                        @include('problem.disqus')
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <!--<script src="{{ asset('/js/modalDeleteSolution.js') }}"></script>-->

    <script src="{{ asset('/js/disqus.js') }}"></script>
@endsection
