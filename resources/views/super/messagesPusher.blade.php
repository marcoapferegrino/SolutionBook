@extends('app')

@section('content')
    @include('partials.messages')

    <div class="table">

        <div class="row ">

                    <div class="col-md-8 col-lg-push-2 ">
                        <strong style="font-size: 140%">Aqui puedes enviar notificaciones personalizadas a todos los usuarios  </strong> <br> <br>

                        <div class="panel panel-primary ">
                            <div class="panel-heading"><strong>Envío de notificaciones </strong></div>

                            <div class="panel-body col-md-12 ">


                                {!! Form::open(['route' => 'notifications.allNotification','method' => 'POST','class'=>'form-inline']) !!}

                                <div class="col-md-12">
                                    <div class="col-md-10 col-lg-push-1">
                                    <div class="form-group" >
                                        {!! Form::label('message', 'Mensaje*') !!} <br>
                                        {!! Form::text('message',null, array('class' => 'form-control ','maxlength' => '50','size' => '80','id'=>'title','placeholder'=>'Texto para enviar (Máximo 50 carácteres) ','required'))!!}
                                        <br> <br> <br>
                                        {!! Form::submit('Enviar',array('class'=>'btn btn-success btn-block')) !!}
                                        {!! Form::close() !!}
                                    </div>
                                    </div>


                                </div>


                            </div>


                        </div>

                    </div>


                    <div class="col-md-1">

                    </div>




        </div></div>
@endsection
@section('scripts')

@endsection

