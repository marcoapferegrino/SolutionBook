@extends('app')

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

                        <div class=" col-sm-1 pull-right">
                            <a href="{{route('warning.getAddWarning',['id'=>$dataProblem->id,'type'=>1])}}"><strong><small class="text-danger">Reportar</small></strong></a>
                        </div>@include('problem.partials.buttonsDeleteUpdateProblem')
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
                        <div class="well well-sm col-md-3 pull-right " style="overflow: hidden; text-overflow: ellipsis;">
                            <b>No Soluciones: </b>{{$dataProblem->numSolutions}}<br>
                            <b>Límite de tiempo: </b>{{$dataProblem->limitTime}} s<br>
                            <b>Límite de memoria: </b>{{$dataProblem->limitMemory}} Kb<br>
                            <table class="table table-hover">

                                @if($judge!=null)
                                <tr><th>Jueces:</th></tr>
                                <tr >
                                    <td>
                                        <a href="{{$judge->addresWeb}}" >{{$judge->name}}</a>
                                    </td>
                                </tr>
                                @endif
                                    
                                <tr><th>Palabras clave:</th></tr>
                                <tr>
                                    <td>{{$tags}}</td>
                                </tr>
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
                                        <img width="20px" height="30px" src="{{ asset('/problem/pdf.jpg') }}" alt="{{$pdf->name}}">
                                @else
                                    <img width="20px" height="30px" src="{{ asset('/problem/word.jpg') }}" alt="{{$pdf->name}}">
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
                            <div class=" col-xs-8">
                                <b>Descripción</b>
                                <br>
                                <pre>{{$dataProblem->description}}</pre>

                                <br>
                                <br>

                            </div>

                        </div>
                        @if(!($cSolutions==0 && $javaSolutions==0 && $pythonSolutions==0 && $cplusSolutions==0))
                            <div class="row col-sm-10 ">
                                <div class="well well-sm  pull-right " id="container" data-cnorm="{{$cSolutions}}" data-java="{{$javaSolutions}}" data-python="{{$pythonSolutions}}" data-cplus="{{$cplusSolutions}}" >

                                </div>
                            </div>
                        @endif
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
                        
                        <div class=" row col-sm-4">
                            <a class="btn btn-warning btn-lg pull-right navbar-fixed-top" href="{{route('solution.getFormSolution',$dataProblem->id)}}" role="button">
                                <i class="fa fa-code"></i> Agregar Solución
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

    <script src="{{ asset('/js/likes.js') }}"></script>
    <script src="{{ asset('/js/modalDeleteProblem.js') }}"></script>
    <script src="{{ asset('/js/alerts.js') }}"></script>
    <script src="{{ asset('/js/disqus.js') }}"></script>
    <script src="/jsCharts/highcharts.js"></script>
    <script src="/jsCharts/modules/exporting.js"></script>
    <script src="{{ asset('/js/modalDeleteSolution.js') }}"></script>
    <script>
        $(function () {

            var cData =$('#container').data('cnorm');
            var javaData =$('#container').data('java');
            var pythonData =$('#container').data('python');
            var cPlusData =$('#container').data('cplus');
            $('#container').highcharts({
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                title: {
                    text: 'Lenguajes de soluciones'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                            style: {
                                color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                            }
                        }
                    }
                },
                series: [{
                    name: "Lenguajes",
                    colorByPoint: true,
                    data: [{
                        name: "C",
                        y: cData,
                        sliced: true,
                        selected: true
                    }, {
                        name: "C++",
                        y: cPlusData
                    }, {
                        name: "Python",
                        y: pythonData
                    }, {
                        name: "Java",
                        y: javaData
                    }]
                }]
            });
        });
    </script>
@endsection
