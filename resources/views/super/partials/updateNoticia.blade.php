<!-- Modal -->
<div class="modal fade" id="modalEditNotice{{$notice->id}}" tabindex="-1" role="dialog" aria-labelledby="modalEditNotice{{$notice->id}}">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Editar Noticia: {{$notice->title}}</h4>
            </div>
            <div class="modal-body">

                {!! Form::open(['route' => 'notices.updateNotice','method' => 'POST','class'=>'form-inline']) !!}
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
                                    {!! Form::textarea('description',$notice->description, array('class' => 'field', 'size' => '90x5','id'=>'description','placeholder'=>'Texto','required'))!!}
                                </div>



                                <div class="form-group">
                                    {!! Form::label('finishDate', 'Fecha de Expiración*') !!} <br>
                                    <input type="date" value="{{$notice->finishDate}}" class="form-control" size="86" id="finishDate"  name="finishDate" placeholder="Fecha de expiración de noticia" required min={{\Carbon\Carbon::now()->subYears(1)}} max={{\Carbon\Carbon::now()->addYears(18)}} >
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


