

    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12 col-md-12">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        @include('solver.partials.orderSolutions')
                        <h3><i class="fa fa-code"></i> Soluciones
                            <a href="#problem"><small>del Problema</small> {{isset($dataProblem->id)?$dataProblem->id:$idProblem}}</a>

                        </h3>

                    </div>

                    <div class="panel-body">

                       @if(count($solutions)>0)
                            @foreach($solutions as $solution)
                                <div class="panel panel-default ">
                                    <div class="clearfix visible-xs-block"></div>
                                    <div class="panel-heading">
                                        @include('partials.likesButtons')
                                        <h4>
                                            <strong>{{$solution->id}} |
                                                <img src="{{asset($solution->avatar)}}" alt="no imagen" class="img-rounded" height="42" onerror="imgError(this,'user');" width="42">
                                                <a href="{{url('/userPerfil/'.$solution->userId)}}">
                                                    <span class="text-capitalize">{{$solution->username}}</span>
                                                </a>
                                            </strong>
                                        </h4>

                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-xs-6 col-md-6">
                                                <div class="list-group">
                                                    <a href="" class="list-group-item active">
                                                        <h4 class="list-group-item-heading"><i class="fa fa-th-list"></i> Detalles</h4>
                                                        <p class="list-group-item-text">Tiempo : <strong>{{$solution->limitTimeString}}</strong> seg</p>
                                                        <p class="list-group-item-text">Memoria : <strong>{{$solution->limitMemory}}</strong> kb</p>
                                                        <p class="list-group-item-text">Languaje: <strong class="text-capitalize">{{$solution->language}}</strong></p>

                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-xs-6 col-md-6">


                                                <div class="panel panel-default">
                                                    <div class="panel-body">
                                                        <a class="btn btn-info btn-block" role="button" data-toggle="collapse" href="#collapse{{$solution->id}}" aria-expanded="false" aria-controls="collapseExample">
                                                            Ver explicación <i class="fa fa-arrow-down"></i>
                                                        </a>
                                                        <div class="collapse" id="collapse{{$solution->id}}">
                                                            <div class="well">
                                                                <p class="text-justify">{{$solution->explanation}}</p>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>


                                                <a class="btn btn-success btn-block" href="{{route('solution.showSolution',$solution->id)}}" role="button">Ver solución</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            @endforeach
                            <div class="text-center">{!! $solutions->render() !!}</div>
                           @else
                            <div class="alert alert-danger" role="alert"><strong>Aún no tenemos soluciones :( Sube una por favor</strong></div>
                       @endif
                    </div>
                </div>
            </div>
        </div>
    </div>






