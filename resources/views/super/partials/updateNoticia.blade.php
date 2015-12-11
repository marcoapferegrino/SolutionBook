<!-- Modal -->
<div class="modal fade" id="modalEditNotice{{$notice->id}}" tabindex="-1" role="dialog" aria-labelledby="modalEditNotice{{$notice->id}}">
    <div class="modal-dialog modal-lg" style="min-width: 86%" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Editar Noticia: {{$notice->title}}</h4>
            </div>
            <div class="modal-body">

                {!! Form::open(['route' => 'notices.updateNotice','method' => 'POST','class'=>'form-inline','files'=>true]) !!}

                {!! Form::hidden('id',$notice->id) !!}
                         <div class="panel panel-success">
                        <div class="panel-heading">
                            <h3 class="panel-title">Editar </h3>
                        </div>

                        <div class="panel-body ">

                                <div class="form-group">
                                    {!! Form::label('title', 'Título*') !!} <br>
                                    {!! Form::text('title',$notice->title, array('class' => 'form-control ','size' => '86','id'=>'title','placeholder'=>'Título de la Noticia ','required'))!!}
                                </div>


                                <div class="form-group">
                                    {!! Form::label('description', 'Descripcion*') !!} <br>
                                    {!! Form::textarea('description',$notice->description, array('class' => 'field','style'=>'resize: none', 'size' => '127x15','id'=>'description','placeholder'=>'Texto','required'))!!}
                                </div>



                                <div class="form-group">
                                    {!! Form::label('finishDate', 'Fecha de Expiración*') !!} <br>
                                    <input type="date" value="{{$notice->finishDate}}" class="form-control" size="86" id="finishDate"  name="finishDate" placeholder="Fecha de expiración de noticia" required min={{\Carbon\Carbon::now()->subYears(1)}} max={{\Carbon\Carbon::now()->addYears(18)}} >
                                </div>

                            <span style="font-size: 140%" class="label label-warning">Si no se agregan archivos se conservarán los guardados previamente</span><br><br>
                            <div class="form-group">
                                <label for="file" class="col-sm-4 control-label"><strong>Imágen representativa:</strong></label> <br><br>
                                <div class="col-sm-6">
                                    {!! Form::file('file',array('id'=>'file', 'class'=>'btn btn-info','style'=>'')) !!}
                                </div>

                            </div>

                            <br><br>
                            <div class="form-group">
                                <label for="file" class="col-sm-4 control-label"><strong>Archivos de apoyo:</strong></label> <br><br><br>
                                <div class="col-sm-6">

                                    <input type="file"  name="apoyo[]" class="btn btn-info" id="apoyo" multiple>
                                </div>

                            </div>
                            <br><br><br><br>
                            <div class="form-group">
                                <label for="file" class="col-sm-8 control-label"><strong>Galería de imágenes (añadir más imágenes ):</strong></label> <br><br>
                                <div class="col-sm-6">

                                    <input type="file"  name="gallery[]" class="btn btn-info" id="gallery" multiple>
                                </div>

                            </div><br><br> <br><br>
                            @if($images!=null)
                            <div class="row" align="middle">

                                <strong>Selecciona imágenes para borrarlas </strong>
                            </div>
                            @endif
                            <div class="row">
                                <div class="col-xs-12">
                                    @foreach($images as $img)
                                        @if($img->notice_id==$notice->id)
                                        <div class="col-xs-3 col-md-3">
                                            <label class="checkbox-inline">
                                                <input type="checkbox" name="imgsDelete[]" value="{{$img->id}}"> ¿Eliminar?
                                            </label>
                                            <a href="#" class="thumbnail">
                                                <img src="{{asset($img->path)}}" alt="...">
                                            </a>
                                            {{$img->name}}
                                        </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>


                        </div>


                    </div>


                </div>

                <div class="form-group navbar-default nav-justified  " >
                    {!! Form::submit('Registrar los cambios',array('class'=>'btn btn-success btn-block')) !!}
                    {!! Form::close() !!}
                </div>
            </div>

    </div>
    </div>


