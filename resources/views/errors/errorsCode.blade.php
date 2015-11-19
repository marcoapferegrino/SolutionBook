@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-lg-offset-2">
                <h4>
                    <ol class="breadcrumb">
                        <li><a href="{{url('/showProblem/'.$idProblem)}}">Problema | {{$idProblem}}</a></li>
                        <li class="active">Errors</li>
                    </ol>
                </h4>
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <h3 class="panel-title">Tú código contiene los siguientes errores lo lamentamos :(</h3>
                    </div>
                    <div class="panel-body">
                        <code>
                            @foreach($compileErrors as $error)
                                <p><code>{{$error}}</code></p>
                            @endforeach
                        </code>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection