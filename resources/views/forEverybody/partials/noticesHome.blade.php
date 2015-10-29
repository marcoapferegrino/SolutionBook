<div class="col-md-8 ">

    <div class="panel panel-primary">
        <div class="panel-heading">Noticias

        </div>

        <div class="panel-body">


            <div id="myCarousel" class="carousel slide col-md-8 col-lg-push-2" data-ride="carousel">

                <!-- Indicators -->
                <ol class="carousel-indicators">

                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                    @foreach($notices as $i=>$notice)
                    <li data-target="#myCarousel" data-slide-to="{{$i+1}}" ></li>
                    @endforeach

                </ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner" role="listbox" style="height: 60%">
                    <div class="item active">
                        <img src="default.jpg" width="700"  height="600"   >
                        <div class="carousel-caption">
                            <h3>//</h3>
                            <p>******</p>
                        </div>
                    </div>

                    @foreach($notices as $i=>$notice)

                    <div class="item text-center"  >
                        <dd style="font-size: 140%; font-family:Lucida Grande;overflow: hidden; text-overflow: ellipsis;" >
                            <b  >{{$notice->title}}</b>
                        </dd>

                        <img width="700"  height="600" align="middle" src="{{$notice->path}}" >
                        <div class="carousel-caption">

                            <h3> <a style="color: #0000C2;background-color: lightgray" href="{{url('/notice/'.$notice->id)}}"> &nbsp;ver noticia&nbsp; <i class="fa fa-external-link-square"></i>
                                </a></h3>

                        </div>

                    </div>

                    @endforeach

                </div>

                <!-- Left and right controls -->
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
        <ul class="nav  list-group-item-info">

            @foreach($notices as $notice)
            <li ><a href="{{url('/notice/'.$notice->id)}}"> <span>{{$notice->title}} </span> <span class="pull-right">{{$notice->finishDate}} </span> </a></li>

            @endforeach

        </ul>
    </div>


</div>

