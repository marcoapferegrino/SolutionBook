@extends('app')

@section('content')


    <div class="container">
        <div class="row">
            <div class="col-md-12 ">

                <div class="panel panel-info">
                    <div class="panel-heading">Agregar Solución para el problema {{$idProblem}} mi Id</div>

                    <div class="panel-body">
                        @include('partials.messages')

                        {!! Form::open([
                        'route' => 'solution.addSolution',
                        'method' => 'post',
                        'files'=>true]) !!}


                        {!! Form::hidden('idProblem',$idProblem,array('id' => 'idProblem')) !!}

                        <div class="form-group">
                            <h3><label for="language"><strong>Lenguaje*</strong></label></h3>
                            {!!Form::select('optionsLanguages', config('optionsLanguages.lenguajes'),null,['class'=>'form-control'])!!}
                        </div>

                        <div class="form-group">
                            <h3><label for="explanation"><strong>Explicación*</strong></label></h3>
                            {!! Form::textarea('explanation',null,array('id' => 'explanation','class'=>'form-control','placeholder'=>'Tu explicación debe ser clara y detallada...:D ')) !!}
                        </div>

                        <div class="form-group ">
                            <h3><label class="control-label" for="youtube"><strong>Youtube</strong></label></h3>
                            <input type="url"  class="form-control"  name ="youtube" id="youtube" placeholder="¿Tienes un video con explicación?" >
                        </div>
                        <div class="form-group">
                            <h3> <label class="control-label" for="repositorio"><strong>Repositorio</strong></label></h3>
                            <input type="url"  class="form-control"  name ="repositorio" id="repositorio" placeholder="¿Tienes un repositorio con el código?" >
                        </div>
                        <div class="form-group">
                            <h3> <label class="control-label" for="web"><strong>Página web</strong></label></h3>
                            <input type="url"  class="form-control"  name ="web" id="web" placeholder="¿Tienes una página web con la explicación?" >
                        </div>

                        <div class="form-group">
                            <label for="fileCode" ><strong>Sube tu Código*</strong></label>
                            {!! Form::file('fileCode',array('id'=>'fileCode', 'class'=>'btn btn-info','style'=>'')) !!}
                        </div>

                        <div class="form-group">
                            <label for="images"><strong>Sube tus Imágenes</strong></label>
                            <input type="file"  name="images[]" class="btn btn-info" id="images" multiple>
                        </div>

                        <div class="form-group">
                            <label for="audioFile" ><strong>Sube un audio con la explicación</strong></label>
                            {!! Form::file('audioFile',array('id'=>'audioFile', 'class'=>'btn btn-info','style'=>'')) !!}
                        </div>


                        <button type="submit" class="btn btn-success btn-lg btn-block" id="submit-all">Guardar</button>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

