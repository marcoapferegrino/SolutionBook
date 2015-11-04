<!-- Modal -->
<div class="modal fade" id="addJudge" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Agregar Juez en Línea</h4>
            </div>

            {!! Form::open([
            'route' => 'judges.addJudge',
            'method' => 'post',
            'class'=>'form-horizontal',
            'id'=>'judgesForm',
            'files'=>true]) !!}
            <div class="modal-body"><center>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><strong>Nombre *</strong></label>
                        <div class="col-sm-9">
                            {!!Form::text('name','',['class'=>'form-control','placeholder'=>'Nombre'])!!}
                        </div>

                    </div>


                    <div class="form-group">
                        <label  class="col-sm-2 control-label"><strong>Url *</strong></label>
                        <div class="col-sm-9">
                            {!!Form::text('addressWeb','',['class'=>'form-control','placeholder'=>'url del juez'])!!}
                        </div>

                    </div>


                    <div class="form-group">
                        <label class="col-sm-2 control-label"><strong>Facebook</strong></label>
                        <div class="col-sm-9">
                            {!!Form::text('facebook','',['class'=>'form-control','placeholder'=>'facebook'])!!}
                        </div>

                    </div>


                    <div class="form-group">
                        <label class="col-sm-2 control-label"><strong>Twitter</strong></label>
                        <div class="col-sm-9">
                            {!!Form::text('twitter','',['class'=>'form-control','placeholder'=>'twitter'])!!}
                        </div>

                    </div>


                    <div class="form-group">
                        <label for="images" class="col-sm-2 control-label"><strong>Imágen</strong></label>
                        <div class="col-sm-6">
                            {!! Form::file('images',array('name'=>'images', 'id'=>'images','placeholder'=>'twitter', 'class'=>'btn btn-warning','style'=>'')) !!}
                        </div>

                    </div>
                </center>
            </div>
            <div class="modal-footer">


                <div class="form-group">
                    <div class="col-sm-8">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </div>
                    <div class="col-sm-4">
                        {!!Form::submit('Agregar',['class'=>'form-control btn-info'])!!}
                    </div>

                    @include('partials.messages')
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>