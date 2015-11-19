
@if($solution->userId == auth()->user()->getAuthIdentifier()||isset($solution->user_id)==auth()->user()->getAuthIdentifier())

        <a href="{{route('solution.getUpdateSolution',$solution->id)}}" role="button" class="btn btn-warning btn-sm">
            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
        </a>
        <a data-toggle="modal" data-target="#eliminarSolution" data-whatever="{{$solution->id}}" role="button" class="btn btn-danger btn-sm">
            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
        </a>

@endif
