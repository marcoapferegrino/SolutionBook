@extends('app')

@section('content')
    <div class="row">
        @include('partials.messages')</div>
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-sm-offset-1 ">
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <h3>Jueces en Línea
                            <button type="button" class="btn btn-success btn-sm pull-right"  data-toggle="modal" data-target="#addJudge">
                                Nuevo <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                            </button>
                        </h3>    
                    </div>
                        @if($judges->total()==0)
                        <center><h4>No hay jueces registrados</h4></center>
                        @else
                <table class="table table-hover">
                    <tr>
                        <th></th>
                        <th>
                            <h4>Juez</h4>
                        </th>
                        <th colspan=2><center><h4>Redes sociales</h4></center></th>
                        <th></th>
                    </tr>
                    @foreach($judges as $j)
                        <tr>
                            <td>
                                <img width=70px height=70px src="{{ asset($j->image) }}">
                            </td>
                            <td>
                                <a href="{{$j->addressWeb}}">{{$j->name}}</a>
                            </td>
                            <td>
                                @if($j->facebook!=null)
                                    <center><a href="{{$j->facebook}}"><img src="{{ asset('auth/facebook.jpg')}}" width="50px"></a></center>
                                    @endif
                            </td>
                            <td>
                                @if($j->twitter!=null)
                                    <center><a href="{{$j->twitter}}"><img src="{{ asset('auth/twitter.png')}}" width="50px"></a></center>
                                @endif
                            </td>
                            <td>
                                <a data-toggle="modal" data-target="#updateJudge" data-id="{{$j->id}}" data-name="{{$j->name}}"  data-web="{{$j->addressWeb}}"  data-facebook="{{$j->facebook}}" data-twitter="{{$j->twitter}}" data-img="{{$j->image}}" role="button" class="btn btn-warning btn-sm">
                                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                </a>
                                <a data-toggle="modal" data-target="#eliminar" data-whatever="{{$j->id}}" data-name="{{$j->name}}" role="button" class="btn btn-danger btn-sm">
                                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                </a>
                            </td>

                        </tr>
                        @endforeach
                </table>
                @endif

                    </div>
            </div>

            <div class="row">

            </div>
            <br>
            <br>
            <br>
        </div>
    </div>
    @include('problem.formJudge')
    @include('super.partials.updateJudge')
    @include('super.partials.deleteJudgeModal')
    <center> {!!$judges->render()!!}</center>
@endsection

@section('scripts')
    <script src="{{ asset('/js/updateJudge.js') }}"></script>
    <script src="{{ asset('/js/deleteJudge.js') }}"></script>
@endsection
