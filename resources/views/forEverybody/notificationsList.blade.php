@extends('app')

@section('content')
    <div class="container">

        @include('partials.messages')
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <h3>Tus notificaciones</h3>
                    </div>
                    <div class="panel-body" align="middle">
                         <br>
                        <table  class="table table-hover">

                        <thead>
                        <tr>
                            <th >
                            </th>
                            <th></th>

                            <th></th>


                        </tr>

                        </thead>
                            <tbody>
                            @foreach($notifications as $notif)

                            <tr style="cursor: pointer" onmouseout="this.style.background='white'" onmouseover="this.style.background='lightgray';"  onclick="location.href='{{url($notif->url)}}'">
                                    <td>
                                    @if($notif->description=='Warning')
                                            <i style="color: red" class="fa fa-exclamation-triangle pull-right"></i>

                                        @elseif($notif->description=='Promote')
                                            <i style="color: lawngreen" class="fa fa-arrow-circle-up pull-right"></i>


                                        @elseif($notif->description=='Like')
                                            <i style="color: steelblue" class="fa fa-thumbs-o-up pull-right"></i>


                                        @elseif($notif->description=='DePromote')
                                            <i style="color: red" class="fa fa-arrow-circle-down pull-right"></i>


                                        @endif
</td>

                                    <td>{{$notif->title}}</td>



                                    <td align="right">{{\SolutionBook\Components\HtmlBuilder::dateDiff($notif->created_at)}}</td>




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
