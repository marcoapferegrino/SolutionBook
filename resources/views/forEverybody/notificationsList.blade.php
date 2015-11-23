@extends('app')

@section('content')
    <div class="container">

        @include('partials.messages')
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <h3>Tus notificaciones</h3>
                    </div>
                    <div class="panel-body" align="middle">
                         <br>
                        <table  class="table table-hover">

                        <thead>
                        <tr>
                            <th>   Texto</th>
                            <th>   Tipo</th>
                            <th>   Fecha</th>
                            <th>   </th>


                        </tr>

                        </thead>
                            <tbody>
                            @foreach($notifications as $notif)

                            <tr style="cursor: pointer" onclick="location.href='{{url($notif->url)}}'">

                                    <td>{{$notif->title}}</td>

                                    <td>{{$notif->description}}</td>

                                    <td>{{\SolutionBook\Components\HtmlBuilder::dateDiff($notif->created_at)}}</td>




                            </tr>

                            @endforeach
                            </tbody>


                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
