@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            @include('partials.messages')
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
                                                    </a>
                                    </h3>
                                    <a class="btn btn-default btn-warning btn-sm" href="{{route('problem.showProblem',$r->id)}}" role="button">
                                        <span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span>
                                    </a>
                                    <a href="{{route('problem.updateGetProblem',$r->id)}}" role="button" class="btn btn-info btn-sm">
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
                                                            <th width=50%>
                                                                Descripción
                                                            </th>
                                                            <th width=30%>
                                                                Límites
                                                            </th>
                                                            <th>
                                                                Soluciones
                                                            </th><th>
                                                                Warnings
                                                            </th>
                                                        </tr>
                                                    </table>
                                                        
                                                                <div class="col-sm-6" style="overflow: hidden; text-overflow: ellipsis; max-height: 100px;">
                                                                {{$r->description}}
                                                            </div>
                                                            <div class="col-sm-4" style="overflow: hidden; text-overflow: ellipsis;">
                                                                Tiempo: {{$r->limitTime}} segundos <br> Memoria: {{$r->limitMemory}} bytes
                                                                </div>
                                                            <div class="col-sm-1" style="overflow: hidden; text-overflow: ellipsis;">
                                                                {{$r->numSolutions}}
                                                                </div>
                                                            <div class="col-sm-1 style="overflow: hidden; text-overflow: ellipsis;">
                                                                {{$r->numWarnings}}
                                                                </div>
                                                            
                                                        
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
    </div>

    @include('problem.partials.deleteProblemModal')

    <center> {!!$result->render()!!}</center>
@endsection
@section('scripts')

    <script src="{{ asset('/js/modalDeleteProblem.js') }}"></script>
@endsection