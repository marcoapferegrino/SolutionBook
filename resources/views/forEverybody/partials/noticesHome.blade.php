
    <div class="panel panel-primary">
        <div class="panel-heading"><strong><h3>Noticias</h3></strong>

        </div>

        <div class="panel-body">
            <div id="myCarousel" class="carousel slide " data-ride="carousel">

                <!-- Indicators -->
                <ol class="carousel-indicators">

                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                    @foreach($notices as $i=>$notice)
                    <li data-target="#myCarousel" data-slide-to="{{$i+1}}" ></li>
                    @endforeach

                </ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner" role="listbox">
                    <div class="item active">
                        <img src="default.jpg" width="100%"  height="100%"   >
                        <div class="carousel-caption">
                            <h3>Bienvenido a Solution Book</h3>
                            <p>*************************</p>
                        </div>
                    </div>

                    @foreach($notices as $i=>$notice)

                    <div class="item text-center" align="middle"  >
                        <dd style="font-size: 200%; font-family:Lucida Grande;overflow: hidden; text-overflow: ellipsis;" >
                            <b  >{{$notice->title}}</b>
                        </dd>

                        <img align="middle"  style="width:100%;  height:100%" src="{{$notice->path}}" >
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
        <ul class="nav list-group-item-info">
            @foreach($notices as $notice)
            <li  ><a href="{{url('/notice/'.$notice->id)}}"> <span style="font-weight: bold"  >{{$notice->title}} </span> <span class="pull-right label label-primary">{{\SolutionBook\Components\HtmlBuilder::dateEspañol(date('d/M/Y',strtotime($notice->created_at)))}} </span> </a></li>
            @endforeach
        </ul>
    </div>



