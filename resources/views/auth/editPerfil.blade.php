@extends('app')

@section('content')
    <div class="container-fluid">
        @include('partials.messages')
        <div class="row">
            <div class="col-xs-12 col-md-8 col-lg-offset-2">
                <div class="panel panel-info">
                    <div class="panel-heading"><h3>Editar perfil </h3></div>
                    <div class="panel-body">

                        {!! Form::open([
                       'route' => 'user.editPerfil',
                       'method' => 'post',
                       'files'=>true]) !!}

                        <div class="form-group">
                            <h4><label class="control-label"><strong>Username</strong></label></h4>
                            <input type="text" class="form-control" disabled value="{{ $user->username }}">
                        </div>

                        <div class="form-group">
                            <h4><label class=" control-label"><strong>E-Mail</strong></label></h4>
                            <input type="email" class="form-control" disabled value="{{ $user->email }}">
                        </div>
                        <div class="form-group">
                            <h4><label class=" control-label"><strong>Avatar</strong></label></h4>
                            <img class="img-responsive" width="50" height="50" src="{{asset($user->avatar)}}"  alt="..." onerror="imgError(this,'user');">
                            {!! Form::file('avatar',array('id'=>'avatar', 'class'=>'btn btn-info','style'=>'')) !!}

                        </div>

                        <div class="form-group">
                            <h4><label class=" control-label"><strong>Password</strong></label></h4>
                            <input type="password" id="password" class="form-control" id="password" name="password" value="">
                        </div>

                        <div class="form-group">
                            <h4><label class=" control-label"  id="labelPasswordConfirm"><strong>Otra vez la Password</strong></label></h4>
                            <input type="password" id="passwordConfirm" class="form-control" name="password_confirmation">
                        </div>

                        <div class="form-group">
                            <div>
                                <button type="submit" id="guardar" class="btn btn-success btn-block">
                                    Guardar
                                </button>
                            </div>
                        </div>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{asset('/js/comparePasswords.js')}}"></script>
@endsection