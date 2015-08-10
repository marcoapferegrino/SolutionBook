<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Laravel</title>

	<link href="{{ asset('/css/app.css') }}" rel="stylesheet">

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
<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">Home</a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<a class="navbar-brand" href="{{url('/')}}">
						@if (!Auth::guest())
							@if(Auth::getRol()=="super")
								Super
							@elseif(Auth::getRol()=="problem")
								Problem Setter
							@elseif(Auth::getRol()=="solver")
								Solver
							@else
								Home
							@endif
						@endif
					</a>
					@if (!Auth::guest())
						@if(Auth::getRol()=="super")
							<li><a href="">Registrar Problem <i class="fa fa-question-circle"></i></a></li>
							<li><a href="">Noticias <i class="fa fa-newspaper-o"></i></a></li>
							<li><a href="">Jueces <i class="fa fa-graduation-cap"></i></a></li>

						@elseif(Auth::getRol()=="problem")
							<li><a href="">Mis soluciones <i class="fa fa-wrench"></i></a></li>
							<li><a href="">Mis problemas</a></li>
							<li><a href="">Promover <i class="fa fa-hand-o-up"></i></a></li>
						@elseif(Auth::getRol()=="solver")

							<li><a href="">Mis soluciones <i class="fa fa-wrench"></i></a></li>


						@endif
					@endif
				</ul>

				<ul class="nav navbar-nav navbar-right">
					@if (!Auth::guest())
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-bell-o fa-2x"></i> <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="">1</a></li>
								<li><a href="">2</a></li>
								<li><a href="">3</a></li>

							</ul>
						</li>
					@endif
					@if (Auth::guest())
						<li><a href="{{ url('/auth/login') }}">Login</a></li>
						<li><a href="{{ url('/auth/register') }}">Register</a></li>
					@else
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->username }} <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="">Mi perfil</a></li>
								<li><a href="{{ url('/auth/logout') }}">Logout</a></li>
								<li><a href="">Configuración</a></li>
							</ul>
						</li>
					@endif
				</ul>
			</div>
		</div>
	</nav>

	@yield('content')

	<!-- Scripts -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
</body>
</html>
