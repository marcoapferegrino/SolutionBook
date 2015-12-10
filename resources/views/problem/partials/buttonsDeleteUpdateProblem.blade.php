
@if(!Auth::guest())
    @if($dataProblem->user_id != auth()->user()->getAuthIdentifier())
        <div class=" col-sm-1 pull-right">
            <a href="{{route('warning.getAddWarning',['id'=>$dataProblem->id,'type'=>1])}}"><strong><small class="text-danger">Reportar</small></strong></a>
        </div>
    @endif
    @if($dataProblem->user_id == auth()->user()->getAuthIdentifier())
        <div class=" pull-right">
            <a href="{{route('problem.updateGetProblem',$dataProblem->id)}}" role="button" class="btn btn-warning btn-sm">
                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
            </a>
            <a data-toggle="modal" data-target="#eliminar" data-whatever="{{$dataProblem->id}}" role="button" class="btn btn-danger btn-sm">
                <span class="glyphicon glyphicon-trash" aria-hidden="true"> </span>
            </a>
        </div>
    @endif
@endif