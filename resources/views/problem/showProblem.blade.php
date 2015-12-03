@extends('app')
@section('styles')
    <link rel="stylesheet" href="{{ asset('/css/styles/monokai.css') }}">
@endsection
@section('content')
    <div class="container">
        <a name="problem"></a>
        <div class="row">
            @include('partials.messages')
            <div class="col-md-12 ">
                <div class="panel panel-info">
                    <div class="panel-heading">

                        <h4><b class="">{{$dataProblem->id}} |  {{$dataProblem->title}} </b>
                            <b style="font-size: small" class="col-sm-offset-1"> Publicado el {{$dias[$publicado->dayOfWeek]}} {{$publicado->day}} de {{$meses[$publicado->month]}} del {{$publicado->year}}</b>


                            @include('problem.partials.buttonsDeleteUpdateProblem')
                        </h4>
                        @if($dataProblem->share=='yes')

                            <div class="row">
                                <div class="text-center">
                                    {!! Form::open(['route' => ['problem.multimediaZip',$dataProblem->id],'method' => 'get']) !!}
                                    <button type="submit" class="btn btn-warning">Descargar archivos de prueba</button>

                                    {!! Form::close() !!}

                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="panel-body">
                        <div class="well well-sm col-md-3 pull-right " style="overflow: hidden; text-overflow: ellipsis; max-width: 260px;">
                            <b>No Soluciones: </b>{{$dataProblem->numSolutions}}<br>
                            <b>Límite de tiempo: </b>{{$dataProblem->limitTime}} s<br>
                            <b>Límite de memoria: </b>{{$dataProblem->limitMemory}} Kb<br>
                            <table class="table table-hover">

                                @if($judge!=null)
                                <tr><th>Jueces:</th></tr>
                                <tr >
                                    <td>
                                        <a href="{{$judge->addressWeb}}" >{{$judge->name}}</a>
                                    </td>
                                </tr>
                                @endif
                                    
                                <tr><th>Palabras clave:</th></tr>
                                <tr>
                                    <td>{{$tags}}</td>
                                </tr>
                                    @if($problemasSimilares!=null)
                                        <tr><th>Problemas similares:</th></tr>
                                    
                                    @foreach($problemasSimilares as $similar)
                                    <tr>
                                        <td><a href="{{route('problem.showProblem',$similar->id)}}">{{$similar->title}}</a></td>
                                    </tr>
                                    @endforeach
                                    @endif
                                @if($links->count()!=null)
                                <tr><th>Enlaces:</th></tr>
                                @foreach($links as $l)
                                <tr>
                                    <td>
                                    <a href="{{$l->link}}" >{{$l->type}}</a>
                                    </td>
                                </tr>
                                @endforeach
                                @endif


                            </table>
                              @foreach($docs as $i=>$pdf)
                                <a href="{{$pdf->path}}">
                                @if($pdf->type=='pdf')
                                    <a style="color:mediumblue;" href="{{url($pdf->path)}}">
                                        <img width="40px" height="45px" src="{{ asset('/problem/pdf.jpg') }}" alt="{{$pdf->name}}">
                                    </a>

                                @else
                                    <a style="color:mediumblue;" href="{{url($pdf->path)}}">
                                        <img width="40px" height="45px" src="{{ asset('/problem/word.jpg') }}" alt="{{$pdf->name}}">
                                    </a>
                                @endif
                                </a>
                            @endforeach  

                            <br>

                        </div>

                        <div class="row">
                            <div class=" col-sm-5 ">
                                <b>Publicado por: </b>{{$dataProblem->author}} <br>
                                <b>Institución: </b>{{$dataProblem->institution}}<br>
                                {{--<b>No Warnings: </b>{{count($warnings)}}<br><br>--}}

                                <br>
                                <br>
                            </div>
                            <div class=" col-xs-9" >
                                <b>Descripción</b>
                                <br>
                                <pre data-spy="scroll" style="overflow-y: scroll; max-height:800px;">{!! $dataProblem->description !!}</pre>

                                <br>
                                <br>

                            </div>

                        </div>
                        @if(!($cSolutions==0 && $javaSolutions==0 && $pythonSolutions==0 && $cplusSolutions==0))
                            <div class="row col-sm-12 ">
                                <div class="well well-sm" id="containerGraph" data-cnorm="{{$cSolutions}}" data-java="{{$javaSolutions}}" data-python="{{$pythonSolutions}}" data-cplus="{{$cplusSolutions}}" >

                                </div>
                            </div>
                        @endif
                        <div class="row">
                            <div class="panel panel-info  col-sm-12  ">
                                    <div class=" col-sm-6">
                                        Ejemplo Entradas: <br>
                                        <pre  data-spy="scroll" style="overflow-y: scroll; max-height:300px;">{{$entrada}}</pre>
                                    </div>
                                    <div class=" col-sm-6">
                                        Ejemplo Salidas:<br>
                                        <pre  data-spy="scroll" style="overflow-y: scroll; max-height:300px;">{{$salida}}</pre>
                                    </div>
                            </div>
                        </div>
                        
                        <div class=" row col-sm-4">
                            <a class="btn btn-warning btn-lg pull-right navbar-fixed-top" href="{{route('solution.getFormSolution',$dataProblem->id)}}" role="button">
                                <i class="fa fa-code"></i> {{(Auth::guest())?"¿Qué esperas?, ¡inicia sesión y agrega tu solución!":"Agregar Solución"}}
                            </a>
                            <br>
                        </div>
                            @if($files!=null)
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
                            @endif
                    </div>
                    <div class="col-sm-14">
                        {{--<b>Soluciones:</b>--}}
                        {{--@foreach($solutions as $s)--}}
                        {{--<br>{{$s->id}} <b>{{$s->ranking}}</b>--}}
                        {{--@endforeach--}}
                        @include('solver.previewsSolution')
                        @include('solver.partials.deleteSolutionModal')
                        @include('problem.disqus')
                    </div>

                </div>
            </div>
        </div>
    </div>
    @include('problem.partials.deleteProblemModal')
@endsection
@section('scripts')
    <script src="{{ asset('/js/highlight.pack.js') }}"></script>
    <script>
        hljs.initHighlightingOnLoad();
    </script>
    <script src="{{ asset('/js/likes.js') }}"></script>
    <script src="{{ asset('/js/modalDeleteProblem.js') }}"></script>
    <script src="{{ asset('/js/alerts.js') }}"></script>
    <script src="{{ asset('/js/disqus.js') }}"></script>
    <script src="{{ asset('/jsCharts/highcharts.js') }}"></script>
    <script src="{{ asset('/jsCharts/modules/exporting.js') }}"></script>
    <script src="{{ asset('/js/modalDeleteSolution.js') }}"></script>
    <script src="{{ asset('/js/graphProblemLanguages.js') }}"></script>

@endsection
