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
    <div class="container">
        <div class="row">
            <div class="col-md-11 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                       <h3>
                           <div class="col-md-6 ">
                               <small>Solución por</small> <strong class="text-capitalize">{{$solutionComplete->username}}</strong>
                               <br> <small>Email</small>
                               <a href="mailto:{{$solutionComplete->email}}">{{$solutionComplete->email}}</a>
                           </div>
                           <div class="col-md-6 ">
                               @include('partials.likesButtons')
                           </div>
                            <div class="text-center">
                                <button type="button" class="btn btn-warning">Descargar ZIP multimedia</button>
                            </div>
                       </h3>
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
                                <p class="text-justify">{{$solutionComplete->explanation}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="panel panel-info">
                                    <div class="panel-body">
                                        <p class="lead"><strong>Detalles</strong></p>
                                        <dl class="dl-horizontal">
                                            <dt>Tiempo límite</dt>
                                            <dd>{{$solutionComplete->limitTime}} segs</dd>
                                            <dt>Memoria límite</dt>
                                            <dd>{{$solutionComplete->limitMemory}} kb</dd>
                                            <dt>Lenguaje</dt>
                                            <dd>{{$solutionComplete->language}}</dd>
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
                                                    <a href="{{$link->link}}" class="list-group-item">
                                                        <h5 class="list-group-item-heading">{{$link->type}}</h5>
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
                                        <code class="{{$solutionComplete->language}}">{{$code}}</code>
                                    </pre>
                                    @else
                                    <p class="text-danger">Esta solución no tiene tiene código deberías reportarla</p>
                                @endif
                        </div>
                        <br><br>

                        <div class="panel panel-default">
                            <p class="lead"><i class="fa fa-file-image-o"></i> <strong>Imágenes de apoyo</strong> </p>
                            <div class="panel-body">
                                @if(count($images)>0)
                                    <div id="myCarousel" class="carousel slide" data-ride="carousel">
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
                                                    <img src="{{ asset($images[$i]->path)}}" alt="{{$images[$i]}}">
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

                        {{--End carousel--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('/js/highlight.pack.js') }}"></script>
    <script>
        hljs.initHighlightingOnLoad();
    </script>
    <script src="{{ asset('/js/changeIconRow.js') }}"></script>
@endsection