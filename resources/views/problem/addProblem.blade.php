@extends('app')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12 ">
                <div class="panel panel-warning">
                    <div class="panel-heading"><h4>Agregar Problema</h4></div>

                    <div class="panel-body">
                        {!! Form::open([
                        'route' => 'problem.addProblem',
                        'method' => 'post',
                        'class'=>'form-horizontal',
                        'id'=>'',
                        'files'=>true]) !!}
                        <div class="form-group">
                            <label for="titulo" class="col-sm-2 control-label"><strong>Título</strong></label>
                            <div class="col-sm-6">
                                {!!Form::text('titulo', '',['class'=>'form-control'])!!}
                            </div>

                        </div>

                        <div class="form-group">
                            <label for="descripcion" class="col-sm-2 control-label"><strong>Descripción</strong></label>
                            <div class="col-sm-8">
                                {!!Form::textArea('descripcion', 'Descripción del problema',['class'=>'form-control'])!!}
                            </div>

                        </div>

                        <div class="form-group">
                            <label for="limitTime" class="col-sm-2 control-label"><strong>Limite de tiempo</strong></label>
                            <div class="col-sm-6">
                                {!!Form::text('limitTime','MS',['class'=>'form-control'])!!}
                            </div>

                        </div>

                        <div class="form-group">
                            <label for="limitMemory" class="col-sm-2 control-label"><strong>Limite de Memoria</strong></label>
                            <div class="col-sm-6">
                                {!!Form::text('limitMemory','MB',['class'=>'form-control'])!!}
                            </div>

                        </div>


                        <div class="form-group">
                            <label for="judgeList" class="col-sm-2 control-label"><strong>Juez en Línea</strong></label>
                            <div class="col-sm-6">
                                {!!Form::select('judgeList',$judgeList,null,['class'=>'form-control'])!!}
                            </div>

                        </div>
                        <div id="emails">
                        <div class="form-group" >
                            <div class="col-sm-1"></div>
                            <label for="descripcion" class="col-sm-1 control-label"><strong>Ejemplo entrada</strong></label>
                            <div class="col-sm-4">
                                <textarea rows=8  name="inputs[]" class="form-control" ></textarea>
                            </div>
                            <label for="descripcion" class="col-sm-1 control-label"><strong>Ejemplo salida</strong></label>
                            <div class="col-sm-4">
                                <textarea rows=8 name="outputs[]" class="form-control" ></textarea>
                            </div>
                            <div class="col-sm-1 ">
                                <button type="button" class="btn btn-primary btn-lg ">
                                    <a href="#" onclick="agregar();">
                                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                    </a>
                                </button>
                            </div>
                        </div>
                        </div>

                        <div class="form-group">
                            <label for="tags" class="col-sm-2 control-label"><strong>Palabras clave</strong></label>
                            <div class="col-sm-6">
                                {!!Form::text('tags','',['class'=>'form-control'])!!}
                            </div>

                        </div>


                        <div class="form-group">
                            <label for="tags" class="col-sm-2 control-label"><strong>Imágenes</strong></label>
                            <div class="col-sm-6">
                                {!! Form::file('images',array('name'=>'images[]', 'id'=>'images', 'class'=>'btn btn-warning','style'=>'')) !!}

                            </div>

                        </div>

                        <div class="form-group">
                            <label for="submit" class="col-sm-5 control-label"><strong></strong></label>
                            <div class="col-sm-4">
                                {!!Form::submit('Agregar',['class'=>'form-control btn-info'])!!}
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
    <script type="text/javascript">
        function agregar() {
            campo = '<div class="form-group"><div class="col-sm-1"></div>                                <label for="descripcion" class="col-sm-1 control-label"><strong>Ejemplo entrada</strong></label>                                <div class="col-sm-4">                                     <textarea rows=8 name="inputs[]"  class="form-control" ></textarea>                         </div>   <label for="descripcion" class="col-sm-1 control-label"><strong>Ejemplo salida</strong></label>                                <div class="col-sm-4">                                     <textarea rows=8  name="outputs[]" class="form-control" ></textarea>        </div></div>';
            $("#emails").append(campo);
        }
    </script>

@endsection
