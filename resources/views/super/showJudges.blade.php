@extends('app')

@section('content')
    <div class="row">
        @include('partials.messages')</div>
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-sm-offset-1 ">
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <h3>Jueces en Línea</h3>
                    </div>
                </div>
                    <div class="panel panel-info">
                <table class="table table-hover">
                    <tr>
                        <th>
                            Id
                        </th>
                        <th>
                            Juez
                        </th>
                    </tr>
                    @foreach($judges as $j)
                        <tr>
                            <td>
                                {{$j->id}}
                            </td>
                            <td>
                                <a href="{{$j->webAddress}}">{{$j->name}}</a>
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
@endsection
