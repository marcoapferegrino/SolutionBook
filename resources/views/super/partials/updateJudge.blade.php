<!-- Modal -->
<div class="modal fade" id="updateJudge" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Editar Juez en Línea</h4>
            </div>

            {!! Form::open([
            'route' => 'judges.updateJudge',
            'method' => 'post',
            'class'=>'form-horizontal',
            'files'=>true]) !!}
            <div class="modal-body">
                   
            </div>
            <div class="modal-footer">


                <div class="form-group">
                    <div class="col-sm-8">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </div>
                    <div class="col-sm-4">
                        {!!Form::submit('Guardar',['class'=>'form-control btn-info'])!!}
                    </div>

                    @include('partials.messages')
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>