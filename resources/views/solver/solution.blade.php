@extends('app')
@section('styles')
    <link rel="stylesheet" href="{{ asset('/css/styles/monokai.css') }}">
    <style>
        .text-danger{
            font-weight: bold;
        }
    </style>
@endsection
@section('content')
    <h4>
        <ol class="breadcrumb">
            <li><a href="{{url('/showProblem/'.$solution->problem_id)}}">Problema | {{$solution->problem_id}}</a></li>
            <li class="active">Solución | {{$solution->id}}</li>
        </ol>
    </h4>
    <div class="container">
        <div class="row">
            <div class="col-md-11 col-md-offset-1">
                @include('partials.messages')
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <h3>
                                <div class="col-md-4">
                                    <img src="{{$solution->avatar}}" alt="no imagen" class="img-rounded" onerror="imgError(this,'user');" height="42" width="42">
                                    <small>Solución por</small>
                                    <a href="{{(Auth::guest())?'#':url('/userPerfil/'.$solution->userId)}}">
                                        <small class="text-capitalize text-primary">{{$solution->username}}</small>
                                    </a>
                                    @if(isset($solution->institution))
                                        <br> <small>Institución</small>
                                        <small class="text-capitalize">{{$solution->institution}}</small>
                                    @endif
                                </div>
                                <div class="col-md-8 ">
                                    @include('partials.likesButtons')

                                </div>

                            </h3>
                        </div>
                        <div class="row">
                            <div class="text-center">
                                {!! Form::open(['route' => ['solution.multimediaZip',$solution->problem_id,$solution->id],'method' => 'get']) !!}
                                <button type="submit" class="btn btn-warning">Descargar ZIP multimedia</button>

                                {!! Form::close() !!}

                            </div>
                        </div>
                    </div>


                    <div class="panel-body">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="pull-right">
                                    @if(count($audio)>0)
                                        <audio controls >

                                            <source src="{{ asset($audio[0]->path)}}" type="audio/ogg">

                                            Tu navegador no soporta esta función
                                        </audio>
                                    @else
                                        <p class="text-danger">Esta solución no tiene audio</p>
                                    @endif
                                </div>

                                <p class="lead"><strong>Explicación</strong></p>

                                <pre data-spy="scroll" style="overflow-y: scroll; max-height:800px;">
                                    {!! $solution->explanation !!}</pre>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="panel panel-info">
                                    <div class="panel-body">
                                        <p class="lead"><strong>Detalles</strong></p>
                                        <dl class="dl-horizontal">
                                            <dt>Tiempo hecho</dt>
                                            <dd>{{$solution->limitTimeString}} segs</dd>
                                            <dt>Memoria usada</dt>
                                            <dd>{{$solution->limitMemory}} kb</dd>
                                            <dt>Lenguaje</dt>
                                            <dd class="text-capitalize">{{$solution->language}}</dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="panel panel-info">
                                    <div class="panel-body">
                                        <p class="lead"><strong>Links</strong></p>
                                        @if(count($links)>0)
                                            <div class="list-group">
                                                @foreach($links as $link)
                                                    @if($link->type == 'YouTube')
                                                        <?php $youtubeLink=$link;?>
                                                    @endif
                                                    <a href="{{$link->link}}" class="list-group-item">
                                                        <h5 class="list-group-item-heading">{{$link->link}}</h5>
                                                    </a>
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="text-danger">Esta solución no tiene links</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a class="btn btn-info btn-lg  btn-block" role="button" id="showCode" data-codeshow="true" data-toggle="collapse" href="#collapseCode" aria-expanded="false" aria-controls="collapseExample">
                        Ver código <i id ="iconCode" class="fa fa-arrow-down"></i>
                    </a>
                    <div class="collapse" id="collapseCode">
                        <br>

                        @if(!$code===false)
                            <pre>
                                <code class="{{$solution->language}}">{{$code}}</code>
                            </pre>
                        @else
                            <p class="text-danger">Esta solución no tiene tiene código deberías reportarla</p>
                        @endif
                    </div>
                    <br><br>
                    {{--@if(isset($youtubeLink))--}}
                    {{--<div class="embed-responsive embed-responsive-4by3">--}}
                    {{--<iframe class="embed-responsive-item" src="{{$youtubeLink->link}}" allowfullscreen></iframe>--}}
                    {{--</div>--}}
                    {{--@endif--}}
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <div class="panel panel-default">
                                <p class="lead"><i class="fa fa-file-image-o"></i> <strong>Imágenes de apoyo</strong> </p>
                                <div class="panel-body">
                                    @if(count($images)>0)
                                        <div id="myCarousel" class="carousel slide" data-ride="carousel" style="height: auto; width: 720px;">
                                            <!-- Indicators -->
                                            <ol class="carousel-indicators">

                                                <li data-target="#myCarousel" data-slide-to="{{$images[0]->id}}" class="active"></li>
                                                @for($j=1;$j<count($images);$j++)
                                                    <li data-target="#myCarousel" data-slide-to="{{$images[$j]->id}}" class="active"></li>
                                                @endfor

                                            </ol>
                                            <div class="carousel-inner" role="listbox">

                                                <div class="item active">
                                                    <img src="{{ asset($images[0]->path)}}" alt="path">
                                                </div>
                                                @for($i=1;$i<count($images);$i++)
                                                    <div class="item">
                                                        <img class="img-responsive" src="{{ asset($images[$i]->path)}}" alt="{{$images[$i]}}">
                                                    </div>
                                                @endfor
                                            </div>
                                            <!-- Wrapper for slides -->
                                            <!-- Controls -->
                                            <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                                                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                                                <span class="sr-only">Previous</span>
                                            </a>
                                            <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                                                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                                <span class="sr-only">Next</span>
                                            </a>
                                        </div>
                                    @else
                                        <p class="text-danger">Esta solución no tiene imágenes de apoyo</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>



                    {{--End carousel--}}
                </div>
                @include('problem.disqus')
            </div>
        </div>
    </div>
    </div>

    @include('solver.partials.deleteSolutionModal')
@endsection
@section('scripts')
    <script src="{{ asset('/js/highlight.pack.js') }}"></script>
    <script>
        hljs.initHighlightingOnLoad();
    </script>
    <script src="{{ asset('/js/changeIconRow.js') }}"></script>
    <script src="{{ asset('/js/modalDeleteSolution.js') }}"></script>
    <script src="{{ asset('/js/likes.js') }}"></script>
    <script src="{{ asset('/js/alerts.js') }}"></script>
    <script src="{{ asset('/js/disqus.js') }}"></script>
    <script src="{{ asset('/js/previewExplanation.js') }}"></script>
@endsection