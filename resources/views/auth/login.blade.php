@extends('app')

@section('content')

    @include('partials.messages')
<div class="container-fluid">

	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-success">
				<div class="panel-heading"><h4><strong>Iniciar sesión</strong></h4></div>
				<div class="panel-body">


					<form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/login') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group">
							<label class="col-md-4 control-label"><strong>Correo Electrónico</strong></label>
							<div class="col-md-6">
								<input type="email" class="form-control" name="email" value="{{ old('email') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label"><strong>Contraseña</strong></label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password">
							</div>
						</div>

						{{--<div class="form-group">--}}
							{{--<div class="col-md-6 col-md-offset-4">--}}
								{{--<div class="checkbox">--}}
									{{--<label>--}}
										{{--<input type="checkbox" name="remember"> Remember Me--}}
									{{--</label>--}}
								{{--</div>--}}
							{{--</div>--}}
						{{--</div>--}}

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary btn-block">Ingresar</button>

								<a class="btn btn-link" href="{{ url('/password/email') }}">¿Olvidaste tu contraseña?</a>
							</div>
						</div>

                        @include('auth.loginSocial')
					</form>

				</div>
			</div>
		</div>
	</div>
</div>
@endsection
