@extends('app')

@section('content')
    <div class="container">

        @include('partials.messages')
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <h3>Reportar {{$type==0 ? 'Solución' : 'Problema' }} #{{$id}}</h3>
                    </div>

                    <div class="panel-body">
                        <div class="alert alert-info alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>¡Que pena!</strong> Lamentamos este inconveniente :( por favor ayúdanos a resolverlo proporcionándonos algunos datos.
                        </div>
                        {!! Form::open([
                            'route' => 'warning.addWarning',
                            'method' => 'post',
                            'files'=>true]) !!}
                        {!! Form::hidden('id',$id) !!}
                        {!! Form::hidden('type',$type) !!}
                        <div class="form-group">
                            <h4><label for="description"><strong>Razón*</strong></label></h4>
                            {!!Form::select('reason', config('optionsReasonWarning.reasonsWarnings'),null,['class'=>'form-control','required'])!!}
                        </div>

                        <div class="form-group">
                            <h4><label for="description"><strong>Descripción*</strong></label></h4>
                            <textarea  required id="description" name="description" class="form-control" rows="4" placeholder="Por favor describe la razón del contenido lo mas detallado posible"></textarea>
                        </div>

                        <div class="form-group">
                            <h4> <label class="control-label" for="link"><strong>Link</strong></label></h4>
                            <input type="url" class="form-control" name ="link" id="link" placeholder="¿Tienes algún link de prueba?" >
                        </div>


                        <button type="submit" class="btn btn-warning btn-lg btn-block" id="submit-all">Enviar</button>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection