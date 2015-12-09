@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-md-offset-2">
                <div class="panel panel-success">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-6 col-md-4">
                                <div class="thumbnail">
                                    <img class="img-responsive" src="{{$user->avatar}}" alt="..." onerror="imgError(this,'user');">
                                    <div class="caption">
                                        <h1 class="text-capitalize"> {{$user->rol=='problem' ? 'Problem Setter' : 'Solver' }}:  <small>{{$user->username}}</small></h1>
                                        @if(auth()->user()->getAuthIdentifier()==$user->id)
                                            <a href="mailto:{{$user->email}}" target="_top">{{$user->email}}</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <table class="table table-hover">
                                    <tr>
                                        <th>Institución:</th>
                                        <td>{{$user->institution}}</td>
                                    </tr>
                                    <tr>
                                        <th>Ranking:</th>
                                        <td>{{$user->ranking}} pts.</td>
                                    </tr>
                                    {{--@if(auth()->user()->getAuthIdentifier()==$user->id)--}}
                                    <tr>
                                        <th>Estado:</th>
                                        <td {!! Html::classes(['text-capitalize','success'=>$user->state=='active','warning'=>$user->state=='suspended','danger'=>$user->state=='blocked','danger'=>$user->state=='inactive'])!!}>
                                            {{$user->state}}
                                        </td>
                                    </tr>

                                        <tr>
                                            <th>
                                                Amonestaciones:
                                            </th>
                                            <td
                                            {!! Html::classes(['warning'=>$user->numWarnings==1,'danger'=>$user->numWarnings>=2])!!}>

                                                {{$numWarnings}}
                                            <div class="pull-right">
                                                <button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#helpWarning">
                                                    ¿?
                                                </button>
                                            </div>
                                            </td>
                                        </tr>
                                    {{--@endif--}}
                                    @if($user->rol=='problem')
                                        <tr>
                                            <th># Problemas:</th>
                                            <td>{{$numProblems}} </td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <th># Soluciones:</th>
                                        <td>{{$numSolutions}} </td>
                                    </tr>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-body" id="container">
                            <input type="hidden" id="datosChart" data-java="{{$java}}" data-python="{{$python}}"
                                   data-cnorm="{{$cSolutions}}" data-cplus="{{$cPlusSolutions}}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('forEverybody.partials.modalInfoWarnings')
@endsection
@section('scripts')
    <script src="/jsCharts/highcharts.js"></script>
    <script src="/jsCharts/modules/exporting.js"></script>

    <script>
        $(function () {
            var cData =$('#datosChart').data('cnorm');
            var javaData =$('#datosChart').data('java');
            var pythonData =$('#datosChart').data('python');
            var cPlusData =$('#datosChart').data('cplus');
//            console.log(cData);
//            console.log(javaData);
//            console.log(pythonData);
//            console.log(cPlusData);

            $('#container').highcharts({
                title: {
                    text: 'Soluciones por Mes',
                    x: -20 //center
                },
                subtitle: {
                    text: 'Sitio: SolutionBook',
                    x: -20
                },
                xAxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                        'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
                },
                yAxis: {
                    title: {
                        text: 'Número de soluciones'
                    },
                    plotLines: [{
                        value: 0,
                        width: 1,
                        color: '#808080'
                    }]
                },
                tooltip: {
                    valueSuffix: 'solución'
                },
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'middle',
                    borderWidth: 0
                },
                series: [{
                    name: 'C',
                    data: cData
                }, {
                    name: 'C++',
                    data: cPlusData
                }, {
                    name: 'Java',
                    data: javaData
                }, {
                    name: 'Python',
                    data: pythonData
                }]
            });
        });
    </script>
@endsection