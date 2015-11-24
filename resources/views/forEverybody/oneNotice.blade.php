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
                                    <span style="font-size: 140%" class="label label-success pull-right"><i class="fa fa-calendar"></i> {{\SolutionBook\Components\HtmlBuilder::dateEspañol(date('d/M/Y',strtotime($notice[0]->finishDate)))}} </span><br> <br> </samp>
                                <br> <br>
                                    </div> </div>
                                <samp style="display: block">
                                    <div>
                                        <pre>{{$notice[0]->description}}</pre>
                                    </div>
                                </samp>

                                @if(count($notice)>1)

                                <div class="panel panel-success">
                                    <div class="panel-heading"><i class="fa fa-files-o"></i>
                                        <strong>Archivos</strong></div>

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

                            @include('forEverybody.partials.modalImg',['imagen'=>$notice[0]->path])


                        </div>

                    </div>


                    <div class="col-md-1">

                    </div>




        </div></div>
@endsection

