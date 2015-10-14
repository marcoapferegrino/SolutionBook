@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1" >

                    @if($result->total()==0)
                        <h3>No tienes Problemas</h3>
                    @else
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        @foreach($result as $i=>$r)
                            <div class="panel-success">
                                <div class="panel-heading ">
                                    <h3 class="panel-title">
                                        @if($i==0) 
                                <a class="panel-title col-md-10 collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#p{{$r->id}}" aria-expanded="true" aria-controls="p{{$r->id}}">
                                        @else 
                                <a class="panel-title col-md-10 collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#p{{$r->id}}" aria-expanded="false" aria-controls="p{{$r->id}}">
                                        @endif
                                        
                                            <b class="col-xs-1">{{$r->id}}</b> {{$r->title}}
                                        </a></h3> 
                                    <a class="btn btn-default btn-warning btn-sm" href="{{route('problem.showProblem',$r->id)}}" role="button">
                                        <span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span> 
                                    </a>
                                    <a href="{{route('problem.updateProblem',$r->id)}}" role="button" class="btn btn-info btn-sm">
                                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> 
                                    </a>
                                    <a data-toggle="modal" data-target="#eliminar" data-whatever="{{$r->id}}" role="button" class="btn btn-danger btn-sm">
                                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> 
                                    </a>
                                </div>
                                @if($i==0) 
                                <div id="p{{$r->id}}" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading{{$r->id}}">
                                @else 
                                <div id="p{{$r->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{$r->id}}">
                                @endif
                                    <div class="panel-body" > 
                                        <table class="table table-hover info">
                                            <tr>
                                                <th>
                                                    Descripción
                                                </th>
                                                <th>
                                                    Límites
                                                </th>
                                                <th>
                                                    Soluciones
                                                </th><th>
                                                    Warnings
                                                </th>
                                            </tr>
                                            <tr>
                                                <td>
                                                    {{$r->description}}
                                                </td>
                                                <td>
                                                    Tiempo: {{$r->limitTime}} segundos <br> Memoria: {{$r->limitMemory}} bytes
                                                </td>
                                                <td>
                                                    {{$r->numSolutions}}
                                                </td>
                                                <td>
                                                    {{$r->numWarnings}}
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        @endforeach
                            </div>
                    @endif
                                <a class="btn btn-default btn-success pull-right" href="{{route('problem.addFormProblem')}}" role="button">
                                    Nuevo
                                </a>
               
            </div>
        </div>
    </div>


<div class="modal fade" id="eliminar">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
        <p>Si usted elimina este problema perdera todo derecho sobre el.</p>
      </div>
      <div class="modal-footer">
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
 <center> {!!$result->render()!!}</center>
@endsection
@section('scripts')
<script type="text/javascript">
$('#eliminar').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var idProblema = button.data('whatever') // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this)
  modal.find('.modal-title').text('Eliminar problema ' + idProblema)
  modal.find('.modal-footer').html('<a  class="btn btn-warning" href="/deleteProblem/'+idProblema+'" role="button" >Aceptar</a>   <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>')
  
})
</script>
@endsection