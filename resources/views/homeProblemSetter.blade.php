@extends('app')

@section('content')
    <div class="table">

        <div class=" row">


            <table class="table">

                <tbody>
                <tr>
                    <div class="col-md-1">
                        <ul class="nav nav-pills nav-stacked">
                            <li class="active " ><a href="#">Mi cuenta</a></li>
                            <li ><a href="#DatosGenerales">&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-user fa-4x"></i>
                                </a></li>
                            <li><a href="#Ranking">&nbsp;&nbsp;&nbsp;<i class="fa fa-trophy fa-4x"></i>
                                </a></li>
                            <li><a href="#EliminarCuenta">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-user-times fa-4x"></i>
                                </a></li>
                        </ul>
                    </div>

                    <div class="col-md-1">

                    </div>
                </tr>
                <tr><div class="col-md-8 ">
                        <div class="panel panel-primary">
                            <div class="panel-heading">Noticias

                            </div>

                            <div class="panel-body">


                                <div id="myCarousel" class="carousel slide" data-ride="carousel">
                                    <!-- Indicators -->
                                    <ol class="carousel-indicators">
                                        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                                        <li data-target="#myCarousel" data-slide-to="1"></li>
                                        <li data-target="#myCarousel" data-slide-to="2"></li>
                                        <li data-target="#myCarousel" data-slide-to="3"></li>
                                    </ol>

                                    <!-- Wrapper for slides -->
                                    <div class="carousel-inner" role="listbox">
                                        <div class="item active">
                                            <img src="img/11.jpg" alt="1">
                                            <div class="carousel-caption">
                                                <h3>Noticia #1</h3>
                                                <p>Poe ataca de nuevo</p>
                                            </div>
                                        </div>

                                        <div class="item">
                                            <img src="img/2.jpg" alt="2">
                                            <div class="carousel-caption">
                                                <h3>Noticia #2</h3>
                                                <p>Eres un baka</p>
                                            </div>
                                        </div>

                                        <div class="item">
                                            <img src="img/3.png" alt="3">
                                            <div class="carousel-caption">
                                                <h3>Noticia #3</h3>
                                                <p>Gatos.</p>
                                            </div>
                                        </div>

                                        <div class="item">
                                            <img src="img/4.jpg" alt="4">
                                            <div class="carousel-caption">
                                                <h3>Noticia #4</h3>
                                                <p>Smiths</p>
                                            </div>
                                        </div>
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
                        </div>

                    </div>

                </tr>


                <tr>
                    <div class="col-md-1">

                    </div>

                </tr>   <div class="col-md-1 " >
                    <ul class="nav nav-pills navbar-right list-group-item-danger">
                        <li class=" list-group-item list-group-item-info" style="background-color: #a92222" ><a href="#">Notificaciones</a></li>
                        <li ><a href="#">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-refresh fa-spin fa-4x"></i>
                            </a></li>

                    </ul>
                </div>




                </tbody>


            </table>


        </div>
@endsection

