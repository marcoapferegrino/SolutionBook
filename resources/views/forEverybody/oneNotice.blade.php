@extends('app')

@section('content')
    @include('partials.messages')

    <div class="table">

        <div class="row ">

                    <div class="col-md-8 col-lg-push-2 ">
                        <div >
                            <div class="panel-body col-md-12 text-justify">
                                <div class="panel-body col-md-12 " align="middle">


                                    <h3 class="text-primary" style="color:#000000;"> <span style="font-size: 120%" class="label label-primary"> <strong>{{$notice[0]->title}}</strong></span></h3>

                                    <br><a>
                                    <img data-toggle="modal" data-target="#imgExpand" class = "img-thumbnail" style=" cursor: pointer;border-radius: 15px; height:40%; width:40%" src = "{{url($notice[0]->path)}}" >
                                    </a>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                <samp >
                                    <span style="font-size: 140%" class="label label-success pull-right"><i class="fa fa-calendar"></i> {{\SolutionBook\Components\HtmlBuilder::dateEspañol(date('d/M/Y',strtotime($notice[0]->created_at)))}} </span><br> <br> </samp>
                                <br> <br>
                                    </div> </div>
                                <samp style="display: block;">
                                    <div class="col-md-13">
                                        <pre style=";background-color: transparent;border-color: transparent;font-family:  Arial, Helvetica, sans-serif">{{$notice[0]->description}}</pre>
                                    </div>
                                </samp>
                                @if(count($gallery)>=1)
                                <div class="col-lg-10 col-lg-push-1">
                                    <div id="myCarousel" class="carousel slide " data-ride="carousel">

                                        <!-- Indicators -->
                                        <ol class="carousel-indicators">

                                            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                                            @foreach($gallery as $i=>$imgGallery)
                                                <li data-target="#myCarousel" data-slide-to="{{$i}}" ></li>
                                            @endforeach

                                        </ol>

                                        <div class="carousel-inner " role="listbox">

                                            @foreach($gallery as $i=>$imgGallery)
                                                @if($i==0)
                                                    <div class="item active">
                                                        <img align="middle"  style="width:100%;  height:100%" src="{{url($imgGallery->path)}}" >
                                                        <div class="carousel-caption">
                                                        </div>
                                                    </div>
                                                 @else
                                                    <div class="item text-center" align="middle"  >

                                                        <img align="middle"  style="width:100%;  height:100%" src="{{url($imgGallery->path)}}" >
                                                        <div class="carousel-caption">


                                                        </div>

                                                    </div>
                                                @endif



                                            @endforeach

                                        </div>


                                        <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                                            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                                            <span class="sr-only">Anterior</span>
                                        </a>
                                        <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                                            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                            <span class="sr-only">Siguiente</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-1">

                                </div>
                                @endif
                                @if(count($notice)>1)
                            <div class="col-lg-12">
                                <div class="panel panel-success">
                                    <div class="panel-heading"><i class="fa fa-files-o"></i>
                                        <strong>Archivos</strong>
                                    </div>

                                    <div class="panel-body col-md-12 "  style="background-color: lightgray" align="middle">
                                @foreach($notice as $k=>$noticeFile)
                                    @if($k==0)
                                    @else
                                    <i class="fa {{\SolutionBook\Components\HtmlBuilder::icon($notice[$k]->type)}}"></i><a style="color:mediumblue;" href="{{url($notice[$k]->path)}}"> {{$notice[$k]->name}} </a>  <br>

                                @endif

                                @endforeach
                                    </div>
                                </div>
                                @endif
                            </div>

                            </div>

                            @include('forEverybody.partials.modalImg',['imagen'=>$notice[0]->path])


                        </div>

                    </div>


                    <div class="col-md-1">

                    </div>




        </div></div>
@endsection

