@extends('app')

@section('content')
    <div class="container">


        @include('partials.messages')

    </div>
<div class="container">

    <div class="col-lg-12 col-md-push-0 " >

        {!! Form::open(['route' => 'notices.addNotice','method' => 'POST','class'=>'form-inline','files'=>true]) !!}

        <div class="panel-body ">


            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title">Agregar noticia</h3>
                </div>

                <div class="panel-body col-md-8"> <!-- magia -->



                        <div class="col-md-12">
                            <div class="form-group">
                                {!! Form::label('title', 'Título*') !!} <br>
                                {!! Form::text('title',null, array('class' => 'form-control ','size' => '86','maxlength' => '50','id'=>'title','placeholder'=>'Título de la Noticia ','required'))!!}
                            </div>


                    </div>
                    <br> <br><br> <br>

                        <div class="col-md-12 col-lg-pull-0">
                            <div class="form-group" >
                                {!! Form::label('description', 'Descripción*') !!} <br>
                                {!! Form::textarea('description',null, array('class' => 'form-control','style'=>'resize: none', 'size' => '127x15','id'=>'description','placeholder'=>'Texto noticia','required'))!!}
                            </div>
                        </div>
                    <br> <br><br> <br>

                    <br> <br><br> <br>
                    <div class="col-md-12">
                    <div class="form-group">
                        <br> <br>
                        {!! Form::label('finishDate', 'Fecha de Expiración*') !!} <br>
                        <input type="date" class="form-control" size="86" id="finishDate"  name="finishDate" placeholder="Fecha de expiración de noticia" required min={{\Carbon\Carbon::now()->subYears(1)}} max={{\Carbon\Carbon::now()->addYears(1)}} >
                    </div>
                    </div>
                    <br> <br><br> <br><br><br>
                    <div class="form-group">
                        <label for="file" class="col-sm-12 control-label">Imagen representativa (Se mostrará en la vista principal):</label> <br><br>
                        <div class="col-sm-6">
                            {!! Form::file('file',array('id'=>'file', 'class'=>'btn btn-info','style'=>'')) !!}
                        </div>

                    </div>
                    <br><br>
                    <div class="form-group">
                        <label for="apoyo" class="col-sm-8 control-label">Archivos de apoyo(Se aceptan archivos jpg,bmp,png,txt,pdf,mp3,docx,doc,wav):</label> <br><br>
                        <div class="col-sm-6">

                            <input type="file"  name="apoyo[]" class="btn btn-info" id="apoyo" multiple>
                        </div>

                    </div>

                    <br><br>
                    <div class="form-group">
                        <label for="file" class="col-sm-8 control-label">Galería de imágenes:</label> <br><br>
                        <div class="col-sm-6">

                            <input type="file"  name="gallery[]" class="btn btn-info" id="gallery" multiple>
                        </div>

                    </div>

                </div>


            </div>





            </div>

            <div class="form-group navbar-default nav-justified  " >
                {!! Form::submit('Registrar',array('class'=>'btn btn-success btn-block')) !!}
                {!! Form::close() !!}
            </div>
        </div>

    </div>   </div>
    <br><br> <br>

</div>

@endsection

