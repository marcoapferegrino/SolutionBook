

<div class="panel panel-info">
    <div class="panel-heading">
        <h3> <i class="fa fa-file-code-o"></i> Problemas recientes</h3>
    </div>
    <div class="panel-body">

        <ul class="list-group">
            @foreach($lastProblems as $k=>$lastProblem)
                <a href="{{url('/showProblem/'.$lastProblem->id)}}">
                    <li style="overflow: hidden;background-color: #f0f0f0 ; text-overflow: ellipsis;" class="list-group-item">
                       <strong >{{$lastProblem->title}}</strong>

                    </li>
                </a>
            @endforeach
                <a href="{{url('/allProblems')}}">
                    <li style="background-color: gainsboro" class="list-group-item text-center">
                        <strong >Todos <i class="fa fa-plus-square"></i></strong>

                    </li>
                </a>
        </ul>

    </div>
</div>
