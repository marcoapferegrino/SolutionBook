@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-md-offset-2">
                <div class="panel panel-success">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-6 col-md-4">
                                <div class="thumbnail">
                                    <img src="{{$user->avatar}}" alt="...">
                                    <div class="caption">
                                        <h1 class="text-capitalize"> {{$user->rol=='problem' ? 'Problem Setter' : 'Solver' }}:  <small>{{$user->username}}</small></h1>
                                        @if(auth()->user()->getAuthIdentifier()==$user->id)
                                            <a href="mailto:{{$user->email}}" target="_top">{{$user->email}}</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <table class="table table-hover">
                                    <tr>
                                        <th>Institución:</th>
                                        <td>{{$user->institution}}</td>
                                    </tr>
                                    <tr>
                                        <th>Ranking:</th>
                                        <td>{{$user->ranking}} pts.</td>
                                    </tr>
                                    @if(auth()->user()->getAuthIdentifier()==$user->id)
                                    <tr>
                                        <th>Estado:</th>
                                        <td {!! Html::classes(['text-capitalize','success'=>$user->state=='active','warning'=>$user->state=='suspended','danger'=>$user->state=='blocked','danger'=>$user->state=='inactive'])!!}>
                                            {{$user->state}}
                                        </td>
                                    </tr>

                                        <tr>
                                            <th>
                                                Amonestaciones:
                                            </th>
                                            <td
                                            {!! Html::classes(['warning'=>$user->numWarnings==1,'danger'=>$user->numWarnings==2])!!}>

                                            {{$user->numWarnings}}
                                            <div class="pull-right">
                                                <button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#helpWarning">
                                                    ¿?
                                                </button>
                                            </div>
                                            </td>
                                        </tr>
                                    @endif
                                    @if($user->rol=='problem')
                                        <tr>
                                            <th># Problemas:</th>
                                            <td>{{$numProblems}} </td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <th># Soluciones:</th>
                                        <td>{{$numSolutions}} </td>
                                    </tr>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('forEverybody.partials.modalInfoWarnings')
@endsection
