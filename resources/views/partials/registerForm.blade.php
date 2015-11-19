 <div class="panel-body ">

            <div class="panel panel-success ">
                <div class="panel-heading">
                    <h3 class="panel-title">Tu cuenta</h3>
                </div>
                <div class="panel-body">

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                {!! Form::label('username', 'Nombre de usuario*') !!}
                                @if($nombre==null)
                                    {!! Form::text('username','', array('class' => 'form-control','id'=>'username','placeholder'=>'Username','required'))!!}
                                @else
                                    {!! Form::text('username',$nombre, array('class' => 'form-control','id'=>'username','placeholder'=>'Username','required'))!!}
                                @endif

                            </div>

                        </div>
                        <div class="col-md-1" id="icon" >

                        </div>
                        <div class="col-md-4">
                            <br>
                            <button type='button' name='getdata' id='getdata' class="btn btn-info pull-right"> <i class="fa fa-search">Buscar nombre de usuario</i> </button>

                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::label('email', 'Email*') !!}<br>
                                @if($correo==null)
                                    {!! Form::email('email',null, array('class' => 'form-control','id'=>'email','placeholder'=>'Email','required'))!!}
                                @else
                                    <input type="text" value="{{$correo}}"  name="email" hidden>
                                    {!! Form::email('muestracorreo',$correo, array('class' => 'form-control','disabled'))!!}
                                @endif

                            </div>
                        </div>


                        <br>

                        <br>

                        <br>

                        <br>


                    </div>
                    <div class="row">
                        <div class="col-md-8 col-lg-push-8">
                            <div class="form-group">
                                {!! Form::label('password', 'Contraseña*') !!} <br>
                                {!! Form::password('password','', array('class' => 'form-control','id'=>'password','placeholder'=>'Pon una contraseña','required'))!!}
                                <br>
                                {!! Form::label('password', 'Confirmar Contraseña*') !!} <br>
                                {!! Form::password('password2','', array('class' => 'form-control','id'=>'password2','placeholder'=>'confirma tu contraseña','required'))!!}

                                <br><div id="messagePassword"></div>
                            </div>
                        </div>

                    </div>
                    @if(Auth::user()==null)

                    <div class="form-group">
                        <label for="avatar" class="col-sm-2 control-label">Avatar</label><br>
                        <div class="col-sm-6">
                            @if($avatar!=null)
                                Actual:
                                <img width="120px" src="{{$avatar}}" />
                                <input type="text" value="{{$avatar}}"  name="avatarSocial" hidden>
                                Cambiar
                            @endif
                            {!! Form::file('avatar',array('id'=>'avatar', 'class'=>'btn btn-info','style'=>'')) !!}
                        </div>

                    </div>
                    @endif
                </div>
            </div>

            <!--
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">Datos personales</h3>
                </div>
                <div class="panel-body">
                    {!! Form::label('name', 'Su nombre*',array('for'=>'name')) !!}
                    <div class="row">

                        <div class="col-xs-6 col-md-4">

                            <div class="form-group">

                                {!! Form::text('name',null, array('class' => 'form-control text-capitalize','id'=>'name','placeholder'=>'Nombre(s)','required','autofocus'))!!}
                            </div>
                        </div>
                        <div class="col-xs-6 col-md-4">
                            <div class="form-group">
                                {{--{!! Form::label('apellidoP', 'Apellido Paterno') !!}--}}
                                {!! Form::text('apellidoP',null, array('class' => 'form-control text-capitalize','id'=>'apellidoP','placeholder'=>'Apellido paterno','required'))!!}
                            </div>
                        </div>
                        <div class="col-xs-6 col-md-4">

                            <div class="form-group">
                                {{--{!! Form::label('apellidoM', 'Apellido Materno') !!}--}}
                                {!! Form::text('apellidoM',null, array('class' => 'form-control text-capitalize','id'=>'apellidoM','placeholder'=>'Apellido materno','required'))!!}
                            </div>
                        </div>
                    </div>
                </div>




            </div>-->

            <div class="form-group navbar-default nav-justified  " >
                {!! Form::submit('Registrar',array('class'=>'btn btn-success btn-block', 'id'=>'submit')) !!}
                {!! Form::close() !!}
            </div>
        </div>
