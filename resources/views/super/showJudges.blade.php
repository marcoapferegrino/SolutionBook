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
                </div>
                    <div class="panel panel-info">
                <table class="table table-hover">
                    <tr>
                        <th colspan=2>
                            Juez
                        </th>
                    </tr>
                    @foreach($judges as $j)
                        <tr>
                            <td>
                                <img width=50px height=50px src="{{ asset($j->image) }}">
                            </td>
                            <td>
                                <a href="{{$j->addressWeb}}">{{$j->name}}</a>
                            </td>
                            <td>
                                @if($j->facebook!=null)
                                    <a href="{{$j->facebook}}">Facebook</a>
                                    @endif
                            </td>
                            <td>
                                @if($j->twitter!=null)
                                    <a href="{{$j->twitter}}">Twitter</a>
                                @endif
                            </td>
                            <td>
                                <a data-toggle="modal" data-target="#updateJudge" data-id="{{$j->id}}" data-name="{{$j->name}}"  data-web="{{$j->addressWeb}}"  data-facebook="{{$j->facebook}}" data-twitter="{{$j->twitter}}" data-img="{{$j->image}}" role="button" class="btn btn-info btn-sm">
                                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                </a>
                                <a data-toggle="modal" data-target="#eliminar" data-whatever="{{$j->id}}" role="button" class="btn btn-danger btn-sm">
                                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                </a>
                            </td>

                        </tr>
                        @endforeach
                </table>


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
@endsection

@section('scripts')
    <script src="{{ asset('/js/updateJudge.js') }}"></script>
    <script src="{{ asset('/js/deleteJudge.js') }}"></script>
@endsection
