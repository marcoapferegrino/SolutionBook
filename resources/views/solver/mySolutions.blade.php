@extends('app')

@section('content')

    <div class="container">
        <div class="row">
            @include('partials.messages')
            <div class="col-md-12">

                <div class="panel panel-info">
                    <div class="panel-heading"><h3>Solutions <i class="fa fa-code"></i></h3></div>

                    <div class="panel-body">

                        @foreach($solutions as $solution)
                            <div class="panel panel-default ">
                                <div class="panel-heading">
                                    <h4>

                                        <a href="{{route('problem.showProblem',$solution->idProblem)}}"><strong>{{$solution->idProblem}} | Problema : <span class="text-capitalize">{{$solution->title}}</span></strong></a>

                                    </h4>

                                </div>
                                <div class="panel-heading">

                                    <h5>
                                        <strong>{{$solution->id}} | Solver : <span class="text-capitalize">{{$solution->username}}</span></strong>

                                        @include('partials.likesButtons')

                                    </h5>


                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="list-group">
                                                <a href="" class="list-group-item active">
                                                    <h4 class="list-group-item-heading"><i class="fa fa-th-list"></i> Detalles</h4>
                                                    <p class="list-group-item-text">Tiempo : <strong>{{$solution->limitTime}}</strong> seg</p>
                                                    <p class="list-group-item-text">Memoria : <strong>{{$solution->limitMemory}}</strong> kb</p>
                                                    <p class="list-group-item-text">Languaje: <strong class="text-capitalize">{{$solution->language}}</strong></p>

                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-md-6">


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
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('solver.partials.deleteSolutionModal')



@endsection

@section('scripts')
    <script src="{{ asset('/js/modalDeleteSolution.js') }}"></script>
    <script src="{{ asset('/js/likes.js') }}"></script>
    <script src="{{ asset('/js/alerts.js') }}"></script>
@endsection