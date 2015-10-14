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
                                {!!Form::text('title','',['class'=>'form-control','id'=>'title'])!!}
                                <!-- {!!Form::text('titulo', '',['class'=>'form-control titulo','id'=>'buscar'])!!} -->
                            </div>

                        </div>

                        <div class="form-group">
                            <label for="descripcion" class="col-sm-2 control-label"><strong>Descripción</strong></label>
                            <div class="col-sm-8">
                                {!!Form::textArea('descripcion', '',['class'=>'form-control','placeholder'=>'Descripción del problema'])!!}
                            </div>

                        </div>

                        <div class="form-group">
                            <label for="limitTime" class="col-sm-2 control-label"><strong>Limite de tiempo</strong></label>
                            <div class="col-sm-6">
                                {!!Form::text('limitTime','',['class'=>'form-control','placeholder'=>'segundos'])!!}
                            </div>

                        </div>

                        <div class="form-group">
                            <label for="limitMemory" class="col-sm-2 control-label"><strong>Limite de Memoria</strong></label>
                            <div class="col-sm-6">
                                {!!Form::text('limitMemory','',['class'=>'form-control','placeholder'=>'bytes'])!!}
                            </div>

                        </div>


                        <div class="form-group">
                            <label for="judgeList" class="col-sm-2 control-label"><strong>Juez en Línea</strong></label>
                            <div class="col-sm-6">
                                {!!Form::select('judgeList',$judgeList,null,['class'=>'form-control'])!!}
                            </div>
                            <div class="col-sm-1 ">
                                <button type="button" class="btn btn-success btn-sm"  data-toggle="modal" data-target="#addJudge">
                                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                </button>
                            </div>
                        </div>
                        <div id="emails">
                            <div class="form-group" >
                                <div class="col-sm-1"></div>
                                <label for="input" class="col-sm-1 control-label"><strong>Ejemplo entrada</strong></label>
                                <div class="col-sm-4">
                                    <textarea rows=8  name="inputs[]" class="form-control" ></textarea>
                                </div>
                                <label for="output" class="col-sm-1 control-label"><strong>Ejemplo salida</strong></label>
                                <div class="col-sm-4">
                                    <textarea rows=8 name="outputs[]" class="form-control" ></textarea>
                                </div>
                                {{--<div class="col-sm-1 ">
                                    <button type="button" class="btn btn-primary btn-lg ">
                                        <a href="#" onclick="agregar();">
                                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                        </a>
                                    </button>
                                </div>--}}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="tags" class="col-sm-2 control-label"><strong>Palabras clave</strong></label>
                            <div class="col-sm-6">
                                {!!Form::text('tags','',['class'=>'form-control','id'=>'tags'])!!}
                            </div>

                        </div>

                        <div class="form-group">
                            <label for="youtube" class="col-sm-2 control-label"><strong>Youtube</strong></label>
                            <div class="col-sm-6">
                                {!!Form::text('youtube','',['class'=>'form-control'])!!}
                            </div>

                        </div>

                        <div class="form-group">
                            <label for="github" class="col-sm-2 control-label"><strong>Github</strong></label>
                            <div class="col-sm-6">
                                {!!Form::text('github','',['class'=>'form-control'])!!}
                            </div>

                        </div>


                        <div class="form-group">
                            <label for="images" class="col-sm-2 control-label"><strong>Archivos de apoyo</strong></label>
                            <div class="col-sm-6">
                                <input type="file"  name="images[]" class="btn btn-info" id="images" multiple>
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
    {!! Form::open(['route' => ['problem.similarProblems',':TEXT'],'method' => 'post','id'=>'form-titulo']) !!}
    {!! Form::close() !!}
    {!! Form::open(['route' => ['problem.similarTags',':TEXT'],'method' => 'post','id'=>'form-tag']) !!}
    {!! Form::close() !!}

@include('problem.formJudge')

@endsection
@section('scripts')
    <script type="text/javascript">
        function agregar() {
            campo = '<div class="form-group"><div class="col-sm-1"></div>                                <label for="descripcion" class="col-sm-1 control-label"><strong>Ejemplo entrada</strong></label>                                <div class="col-sm-4">                                     <textarea rows=8 name="inputs[]"  class="form-control" ></textarea>                         </div>   <label for="descripcion" class="col-sm-1 control-label"><strong>Ejemplo salida</strong></label>                                <div class="col-sm-4">                                     <textarea rows=8  name="outputs[]" class="form-control" ></textarea>        </div></div>';
            $("#emails").append(campo);
        }
    </script>
    <script type="text/javascript">

        $("#title").on('keyup',function(){

            $(this).popover({
                title: 'Ver Problemas similares:',
                placement: 'bottom'
            });
            var x = $(this).val();
            if (x=='') {x='a'};
            var form = $('#form-titulo');
            var url = form.attr('action').replace(':TEXT',x);
            var data = form.serialize();

            $.post(url,data,function(result){
                $(".popover-content").html(result);
            });
            $(this).popover('show');

        });
        $("#title").change(function(){

            $(this).popover('hide');
        });

        $("#tags").on('keyup',function(){

            var x = $(this).val();

            if (x=='') {x='a'};
            var form = $('#form-tag');
            var url = form.attr('action').replace(':TEXT',x);
            var data = form.serialize();
            $(this).popover({
                title: 'Ver Problemas similares:',
                placement: 'bottom'
            });
            $.post(url,data,function(result){
                $(".popover-content").html(result);
            });

            $(this).popover('show');

        });
        $("#tags").change(function(){

            $(this).popover('hide');
        });

    </script>

@endsection
