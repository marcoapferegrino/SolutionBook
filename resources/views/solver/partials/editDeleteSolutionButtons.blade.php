
@if($solution->userId == auth()->user()->getAuthIdentifier() ||  isset ($solutionComplete->userId) == auth()->user()->getAuthIdentifier())
    <div class="col-md-3 pull-left">
        <a href="{{route('problem.updateProblem',$solution->id)}}" role="button" class="btn btn-warning btn-sm">
            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
        </a>
        <a data-toggle="modal" data-target="#eliminarSolution" data-whatever="{{$solution->id}}" role="button" class="btn btn-danger btn-sm">
            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
        </a>
    </div>
@endif
