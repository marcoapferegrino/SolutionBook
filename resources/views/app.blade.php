<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Solution Book</title>

    <link rel="icon" href="{{url("oie_transparent.png")}}">
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/footer.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/notifications.css') }}" rel="stylesheet">
    @yield('styles')
    <!-- Fonts -->
    <link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>


    <![endif]-->

    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

</head>
<body style="overflow-x: hidden;">
@if(!Auth::guest())
    {{\SolutionBook\Components\HtmlBuilder::retrieveLikes()}}<!-- NOTIFICATIONS -->

@endif
<div id="wrapper">
    <div id="header">
        <div class="page-header" style="margin-top: 0%;position: relative;
	clear:both;" >
            <h3 class="title text-center" style="font-family: Roboto; font-size:260%"> <b > &nbsp;&nbsp;
                    <a href="{{'/'}}"><img style="cursor: pointer;height:3%; width:3%"  src="{{url("oie_transparent.png")}}"></a>&nbsp;Solution Book </b><small>.Beta</small>  <i class="fa fa-qq "></i></h3>

            <small class="pull-right" > <i style="font-family: Roboto;font-size: 100%;color: #5e5e5e"> Easy for you; Easy for us &nbsp;&nbsp; </i></small><br>


        </div>
        <div id="notifications"></div>

        <nav class="navbar navbar-default">
            <div class="container-fluid" style="position: relative;">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">

                        @if (!Auth::guest())
                            @if(Auth::getRol()=="super")
                                <a class="navbar-brand" href="{{url('/homeAdmin')}}"><i class="fa fa-home"></i>

                                    Super
                                </a>
                            @elseif(Auth::getRol()=="problem")
                                <a class="navbar-brand" href="{{url('/homeProblemSetter')}}"><i class="fa fa-home"></i>

                                    Problem Setter
                                </a>
                            @elseif(Auth::getRol()=="solver")
                                <a class="navbar-brand" href="{{url('/homeSolver')}}"><i class="fa fa-home"></i>

                                    Solver
                                </a>
                            @else
                                <a class="navbar-brand" href="{{url('/')}}"><i class="fa fa-home"></i>

                                    Home
                                </a>
                            @endif
                        @else
                            <a class="navbar-brand" href="{{url('/home')}}"><i class="fa fa-home"></i>

                                Home
                            </a>

                        @endif

                        @if (!Auth::guest())
                            @if(Auth::getRol()=="super")

                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-newspaper-o"></i> Registros y Listas <span class="caret"></span></a>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="{{ url('/getAddProblemSetter') }}"><i class="fa fa-user"></i> Registrar Problem </a></li>

                                            <li><a href="{{url("/getUsers")}}"><i class="fa fa-group"></i> Lista usuarios </a></li>
                                            <li><a href="{{ url('/getAddNotice') }}"><i class="fa fa-newspaper-o"></i> Crear noticia </a></li>
                                            <li><a href="{{url('/getNotices')}}"><i class="fa fa-list"></i> Listas de noticias</a></li>
                                            <li><a href="{{url("/showJudges")}}"><i class="fa fa-graduation-cap"></i> Jueces </a></li>
                                        </ul>
                                    </li>

                                    <li><a href="{{ url('/myWarnings') }}"><i class="fa fa-exclamation-triangle "></i> Amonestaciones</a></li>
                                    <li><a href="{{url('/viewPromotion')}}"><i class="fa fa-hand-o-up"></i> Promover </a></li>
                                    <li><a href="{{url("/allProblems")}}"><i class="fa fa-list"></i> Catálogo de problemas </a></li>



                            @elseif(Auth::getRol()=="problem")
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-smile-o"></i> Portafolio<span class="caret"></span></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="{{url('/myProblems')}}"><i class="fa fa-list-ol"></i> Mis problemas </a></li>
                                        <li><a href="{{url('/mySolutions')}}"><i class="fa fa-wrench"></i> Mis soluciones </a></li>
                                        <li><a href="{{url('/myWarnings')}}"><i class="fa fa-exclamation-triangle"></i> Mis Amonestaciones</a></li>
                                    </ul>
                                </li>


                                <li><a href="{{url('/viewPromotion')}}"><i class="fa fa-hand-o-up"></i> Promover </a></li>
                                <li><a href="{{url('/allProblems')}}"><i class="fa fa-list"></i> Catálogo de problemas </a></li>
                                <li><a href="{{url('/addFormProblem')}}"><i class="fa fa-plus"></i> Problema </a></li>
                            @elseif(Auth::getRol()=="solver")
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-smile-o"></i> Portafolio<span class="caret"></span></a>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="{{url('/mySolutions')}}"><i class="fa fa-wrench"></i> Mis soluciones </a></li>
                                            <li><a href="{{url('/myWarnings')}}"><i class="fa fa-exclamation-triangle"></i> Mis Amonestaciones</a></li>
                                        </ul>
                                    </li>

                                <li><a href="{{url('/allProblems')}}"><i class="fa fa-list"></i> Catálogo de problemas</a></li>
                            @endif


                        @endif

                    </ul>

                    <ul class="nav navbar-nav navbar-right " >
                        @if (!Auth::guest())
                            <li class="dropdown sidebar-offcanvas" >
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    <span style="font-size: 125%" id="number" class="label label-success"><i  id="notify3" class="fa fa-bell">&nbsp;<span id="notify"></span><i id="wait" class="fa fa-spinner fa-pulse"></i></i> <span class="caret"></span> </span></a>

                                <ul id="likeList" class="dropdown-menu sidebar-offcanvas "  style="max-height: 250px;overflow-y:scroll;"  id="notificationsj" role="menu">

                                    @foreach(session('MY_LIKES') as $k=>$oneLike)
                                        <li class="text text-center"><a onclick="deView({{$oneLike->id}})"          href=" {{url($oneLike->url)}}"
                                                                         >{{$oneLike->title}}<br>
                                                <small> {{\SolutionBook\Components\HtmlBuilder::dateDiff(($oneLike->created_at))}}</small>

                                            </a>
                                        </li>
                                        @if($k>=11)

                                            <?php break; ?>
                                        @endif
                                    @endforeach
                                    <li id="lastLike" class="label-primary text-center "><a href="{{url('/')}}">Ver todas <i class="fa fa-plus-square"></i>
                                        </a></li>


                                </ul>
                            </li>
                        @endif
                        @if (Auth::guest())
                            <li><a href="{{ url('/auth/login') }}">Login</a></li>
                            <li><a href="{{ url('/register') }}">Registrarse <i class="fa fa-pencil"></i>
                                </a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><img src="{{Auth::user()->avatar}}" alt="no imagen" class="img-rounded" height="22" width="22"> &nbsp;&nbsp;{{ Auth::user()->username }}<span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{ url('/userPerfil/'.auth()->user()->getAuthIdentifier()) }}"><i class="fa fa-user"></i> Mi perfil</a></li>
                                    <li><a href="{{url('/getEditPerfil')}}"><i class="fa fa-cogs"></i> Editar Perfil</a></li>
                                    <li><a href="{{ url('/auth/logout') }}"><i class="fa fa-sign-out"></i>Salir</a></li>

                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <div id="content">
        @yield('content')

    </div>
    <div id="footer">
        <p class="text-center">


            Solution Book®, By Marco, Valeria & Luis  2015


        </p>
    </div>

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
    @if(!Auth::guest())
        <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
        <script src="//js.pusher.com/3.0/pusher.min.js"></script>
        <script src="{{asset('/js/pusherEmbed.js')}}"></script>
    @endif
    @yield('scripts')
    <!-- Scripts -->

</div>
</body>
</html>

