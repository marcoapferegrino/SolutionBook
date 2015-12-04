@extends('app')
@section('styles')
    <link href="{{ asset('/css/jquery.keypad.css') }}" rel="stylesheet">
@endsection
@section('content')


    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3>Editar solución #{{$solution->id}} para el problema: #{{$solution->problem_id}}</h3>
                    </div>

                    <div class="panel-body">
                        @include('partials.messages')

                        {!! Form::open([
                        'route' => 'solution.updateSolution',
                        'method' => 'post',
                        'files'=>true]) !!}





                        {!! Form::hidden('idProblem',$solution->problem_id,array('id' => 'idProblem')) !!}
                        {!! Form::hidden('idSolution',$solution->id,array('id' => 'idSolution')) !!}
                        <div class="form-group col-md-10 col-lg-offset-1">
                            <h4><label for="language"><strong>Lenguaje*</strong></label></h4>
                            {!!Form::text('optionsLanguages',$solutionComplete->language,['class'=>'form-control','disabled'])!!}
                        </div>

                        <div class="form-group col-md-10 col-lg-offset-1 ">
                            @include('forEverybody.partials.tagToEdit')
                            <h4><label for="explanation"><strong>Explicación*</strong></label></h4>
                            {!! Form::textarea('explanation',$solutionComplete->explanation,array('id' => 'explanation','class'=>'form-control keypad','placeholder'=>'Tu explicación debe ser clara y detallada...:D ')) !!}
                        </div>
                        <div class="form-group col-md-10 col-lg-offset-1 ">
                            <div class="alert alert-warning" role="alert"><h3><strong>Así se verá tu explicación :D </strong></h3></div>

                            <pre id="contenido"></pre>

                            </div>

                        </div>


                        <div class="form-group col-md-10 col-lg-offset-1 ">
                            <h4><label class="control-label" for="youtube"><strong>{{isset($linkYouTube->type)?$linkYouTube->type:"youTube"}}</strong></label></h4>
                            <input type="url"  class="form-control" value="{{isset($linkYouTube->link)?$linkYouTube->link:null}}"  name ="youtube" id="youtube" placeholder="¿Tienes un video con explicación?" >
                        </div>

                        <div class="form-group col-md-10 col-lg-offset-1">
                            <h4> <label class="control-label" for="repositorio"><strong>{{isset($linkGitHub->type)?$linkGitHub->type:"Repositorio"}}</strong></label></h4>
                            <input type="url"  class="form-control" value="{{isset($linkGitHub->link)?$linkGitHub->link:null}}"  name ="repositorio" id="repositorio" placeholder="¿Tienes un repositorio con el código?" >
                        </div>

                        <div class="form-group col-md-10 col-lg-offset-1">
                            <h4> <label class="control-label" for="web"><strong>Editar web</strong></label></h4>
                            <input type="url"  class="form-control" value="{{isset($linkWeb->link)?$linkWeb->link:null}}"  name ="web" id="web" placeholder="¿Tienes una página web con la explicación?" >
                        </div>



                        <div class="form-group col-md-10 col-lg-offset-1">
                            <label for="fileCode" ><strong>Sube tu Código*</strong></label>
                            {!! Form::file('fileCode',array('id'=>'fileCode', 'class'=>'btn btn-info','onclick'=>'alert("Si cambias tu código tus likes serán 0")')) !!}
                        </div>

                        <div class="form-group col-md-10 col-lg-offset-1">
                            <label for="images"><strong>Agregar más imagenes</strong></label>
                            <input type="file"  name="images[]" class="btn btn-info" id="images" multiple>
                        </div>

                        <div class="form-group col-md-10 col-lg-offset-1">
                            <label for="audioFile" ><strong>Cambiar audio</strong></label>
                            {!! Form::file('audioFile',array('id'=>'audioFile', 'class'=>'btn btn-info','style'=>'')) !!}
                        </div>

                        <div class="row">
                            <div class="col-xs-12">
                                @foreach($images as $img)
                                    <div class="col-xs-3 col-md-3">
                                        <label class="checkbox-inline">
                                            <input type="checkbox" name="imgsDelete[]" value="{{$img->id}}"> ¿Eliminar?
                                        </label>
                                        <a href="#" class="thumbnail">
                                            <img src="{{asset($img->path)}}" alt="...">
                                        </a>
                                        {{$img->name}}
                                    </div>
                                @endforeach
                            </div>
                        </div>


                        <button type="submit" class="btn btn-success btn-lg btn-block" id="submit-all">Guardar</button>
                        {!! Form::close() !!}
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('/js/jquery.plugin.js') }}"></script>
    <script src="{{ asset('/js/jquery.keypad.js') }}"></script>
    <script src="{{ asset('/js/keyMapOurs.js') }}"></script>
    <script src="{{ asset('/js/jquery.caret.js') }}"></script>
    <script src="{{ asset('/js/previewExplanation.js') }}"></script>
@endsection

