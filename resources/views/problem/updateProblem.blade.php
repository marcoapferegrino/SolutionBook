@extends('app')
@section('styles')
    <link href="{{ asset('/css/jquery.keypad.css') }}" rel="stylesheet">
@endsection
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12 ">
                <div class="panel panel-warning">
                    <div class="panel-heading"><h4>Editar Problema</h4></div>

                    <div class="panel-body">
                        @include('partials.messages')
                        {!! Form::open([
                        'route' => 'problem.updateProblem',
                        'method' => 'post',
                        'class'=>'form-horizontal',
                        'id'=>'',
                        'files'=>true]) !!}
                        <input type="text" value="{{$dataProblem->id}}" hidden name="idProblem">
                        <div class="form-group">
                            <label for="titulo" class="col-sm-2 control-label"><strong>Título *</strong></label>
                            <div class="col-sm-6">
                                {!!Form::text('title',$dataProblem->title,['class'=>'form-control','id'=>'title'])!!}
                                <!-- {!!Form::text('titulo', '',['class'=>'form-control titulo','id'=>'buscar'])!!} -->
                                <div id="similarTitle"></div>
                            </div>

                        </div>

                        <div class="form-group">
                            <label for="titulo" class="col-sm-2 control-label"><strong>Institución</strong></label>
                            <div class="col-sm-6">

                                {!!Form::text('institucion',$dataProblem->institution,['class'=>'form-control'])!!}
                                <!-- {!!Form::text('titulo', '',['class'=>'form-control titulo','id'=>'buscar'])!!} -->
                            </div>

                        </div>

                        <div class="form-group">
                            <label for="descripcion" class="col-sm-2 control-label"><strong>Descripción *</strong></label>
                            <div class="col-sm-8">
                                @include('forEverybody.partials.tagToEdit')
                                {!!Form::textArea('descripcion',$dataProblem->description,['class'=>'form-control keypad','id'=>'explanation','placeholder'=>'Descripción del problema'])!!}
                            </div>

                        </div>

                        <div class="form-group">
                            <div class="col-sm-8 col-lg-offset-2">
                                <div class="alert alert-info" role="alert"><h4><strong>Así se verá tu explicación :D </strong></h4></div>
                                <pre id="contenido"></pre>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="limitTime" class="col-sm-2 control-label"><strong>Limite de tiempo </strong></label>
                            <div class="col-sm-6">
                                <div class="input-group">
                                    {!!Form::text('limitTime',$dataProblem->limitTime,['class'=>'form-control','placeholder'=>'segundos','disabled'])!!}
                                    <div class="input-group-addon">segs</div>
                                </div>
                            </div>

                        </div>

                        <div class="form-group">
                            <label for="limitMemory" class="col-sm-2 control-label"><strong>Limite de Memoria *</strong></label>
                            <div class="col-sm-6">
                                <div class="input-group">
                                    {!!Form::text('limitMemory',$dataProblem->limitMemory,['class'=>'form-control','placeholder'=>'bytes','disabled'])!!}
                                    <div class="input-group-addon">kb</div>
                                </div>
                            </div>

                        </div>


                        <div class="form-group">
                            <label for="judgeList" class="col-sm-2 control-label"><strong>Juez en Línea</strong></label>
                            <div class="col-sm-6">
                                <select class="form-control" name="judgeList">
                                    <option value='#'></option>
                                    @foreach($judgeList as $j)
                                        @if($j->id==$dataProblem->judgeList_id)
                                            <option value="{{$j->id}}" selected>{{$j->name}}</option>
                                        @else
                                            <option value="{{$j->id}}">{{$j->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                                <div class="col-sm-1 ">
                                    <button type="button" class="btn btn-success btn-sm"  data-toggle="modal" data-target="#addJudge">
                                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                    </button>
                                </div>
                        </div>
                        <div class="form-group" >
                            <label for="EjemploEntrada" class="col-sm-2 control-label"><strong>Ejemplo entrada *</strong></label>
                            <div class="col-sm-4">
                                <textarea rows=8  name="ejemploen" class="form-control" >{{$entrada}}</textarea>
                            </div>
                            <label for="output" class="col-sm-1 control-label"><strong>Ejemplo salida *</strong></label>
                            <div class="col-sm-4">
                                <textarea rows=8 name="ejemplosa" class="form-control" >{{$salida}}</textarea>
                            </div>
                            {{--<div class="col-sm-1 ">
                                <button type="button" class="btn btn-primary btn-lg ">
                                    <a href="#" onclick="agregar();">
                                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                    </a>
                                </button>
                            </div>--}}
                        </div>
                        <div id="emails">
                            <div class="form-group" >
                                <label for="input" class="col-sm-2 control-label"><strong>Entrada *</strong></label>
                                <div class="col-sm-4">
                                    <textarea rows=8 id='textarea'  name="inputs" class="form-control" disabled >{{$inputs}}</textarea>
                                </div>
                                <label for="output" class="col-sm-1 control-label"><strong>Salida *</strong></label>
                                <div class="col-sm-4">
                                    <textarea rows=8 name="outputs" class="form-control" disabled>{{$outputs}}</textarea>
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

                        <div class="form-group" >
                            <label for="tags" class="col-sm-7 control-label" ><strong>Permitir a usuarios descargar archivos de casos de prueba</strong></label>
                            <div class="col-sm-4">
                                <label class="checkbox-inline">
                                    <input type="checkbox" name="share" value="yes" @if($dataProblem->share=='yes') checked @endif> Aceptar
                                </label>
                            </div>
                        </div>
                        <br>

                        <div class="form-group">
                            <label for="tags" class="col-sm-2 control-label"><strong>Palabras clave *</strong></label>
                            <div class="col-sm-6">
                                {!!Form::text('tags',$tags,['class'=>'form-control','id'=>'tags','placeholder'=>'Etiquetas (p. ej.: arboles binarios, estructuras de datos, recursividad)'])!!}
                                <div id="similarTags"></div>
                            </div>

                        </div>

                        <div id="youtubemas" class="form-group">
                            <label for="youtube" class="col-sm-2 control-label"><strong>Youtube</strong></label>
                            <div class="col-sm-6">
                                @if($youtube!=null)
                                    {!!Form::text('youtube',$youtube->link,['class'=>'form-control'])!!}
                                @else
                                    {!!Form::text('youtube','',['class'=>'form-control'])!!}
                                @endif
                            </div>

                        </div>

                        <div id="githubmas" class="form-group">
                            <label for="github" class="col-sm-2 control-label"><strong>Github</strong></label>
                            <div class="col-sm-6">
                                @if($github!=null)
                                    {!!Form::text('github',$github->link,['class'=>'form-control'])!!}
                                @else
                                    {!!Form::text('github','',['class'=>'form-control'])!!}
                                @endif
                            </div>
                        </div>
                        @if($url!=null)
                            <div class="row">
                            @foreach($url as $web)
                                <div class=" col-md-8 col-sm-offset-2">

                                    <a href="{{$web->link}}" >
                                        <label style="overflow: hidden; text-overflow: ellipsis; max-height: 50px;">{{$web->link}}</label>
                                    </a>

                                    <label class=" col-md-2">
                                        <input type="checkbox" name="linksDelete[]" value="{{$web->id}}"> ¿Eliminar?
                                    </label>
                                    <br>

                                </div>
                            @endforeach
                            </div>
                        @endif
                        <div id="webmas" class="form-group">
                            <h4><label for="web" class="col-sm-2 control-label"><strong>Url</strong></label></h4>
                            <div class="col-sm-6">
                                <input type="text"  name="web[]" class="form-control" >
                            </div>

                            <div class="col-sm-1 ">
                                <a href="#" onclick="agregar('web');" class="btn btn-primary btn-sm " role="button">
                                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                </a>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-xs-12">
                                @foreach($files  as $img)
                                    <div class="col-xs-3 col-md-3">
                                        <label class="checkbox-inline">
                                            <input type="checkbox" name="imgsDelete[]" value="{{$img->id}}"> ¿Eliminar?
                                        </label>
                                        <a href="#" class="thumbnail">
                                            @if($img->type=='pdf')
                                            <img src="{{asset('/problem/pdf.jpg')}}" alt="...">
                                            @elseif($img->type=='word')
                                            <img src="{{asset('/problem/word.jpg')}}" alt="...">
                                            @else
                                            <img src="{{asset($img->path)}}" alt="...">
                                            @endif
                                        </a>
                                        <label style="overflow: hidden; text-overflow: ellipsis; max-height: 50px;">{{$img->name}}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="images" class="col-sm-2 control-label"><strong>Archivos de apoyo</strong></label>
                            <div class="col-sm-6">
                                <input type="file"  name="images[]" accept="image/jpg, image/jpeg, image/png, image/bmp, application/pdf" class="btn btn-info" id="images" multiple>
                            </div>

                        </div>

                        <div class="form-group">
                            <label for="submit" class="col-sm-5 control-label"><strong></strong></label>
                            <div class="col-sm-12">
                                {!!Form::submit('Guardar',['class'=>'btn btn-info btn-lg btn-block'])!!}
                            </div>

                        </div>
                        <div id="idBorrados"></div>

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

    <script src="{{ asset('/js/similarTitle.js') }}"></script>
    <script src="{{ asset('/js/similarTags.js') }}"></script>
    <script src="{{ asset('/js/jquery.plugin.js') }}"></script>
    <script src="{{ asset('/js/jquery.keypad.js') }}"></script>
    <script src="{{ asset('/js/keyMapOurs.js') }}"></script>
    <script src="{{ asset('/js/jquery.caret.js') }}"></script>
    <script src="{{ asset('/js/previewExplanation.js') }}"></script>
    <script type="text/javascript">
        function agregar(tipo) {
            var campo = '<br><div class="col-sm-6 col-sm-offset-2"><input type="text"  name="'+tipo+'[]" class="form-control" ></div>';
            $("#"+tipo+"mas").append(campo);

        }
    </script>

@endsection
