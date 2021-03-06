

<div class="panel panel-info">
    <div class="panel-heading">
        <h3> <i style="color: gold" class="fa fa-star"></i>Top Solvers <i style="color: gold" class="fa fa-star"></i></h3>
    </div>
    <div class="panel-body">

        <ul class="list-group">
            @foreach($topUsers as $k=>$user)
                <a href="{{(Auth::guest())?'#':url('/userPerfil/'.$user->id)}}">
                    <li class="list-group-item">
                        <span class="badge">{{$user->ranking}} pts</span>


                        @if($k==0)
                            <span class="fa-stack fa-lg">
                                    <i style="font-size: 170%;color: cadetblue" class="fa fa-circle fa-stack-1x"></i>
                                    <i style="color:gold;" class="fa fa-trophy fa-stack-1x fa-inverse"></i>
                            </span>
                        @endif
                        @if($k==1)
                            <span class="fa-stack fa-lg">
                                    <i style="font-size: 170%;color: cadetblue" class="fa fa-circle fa-stack-1x"></i>
                                    <i style="color:#c0c0c0;"  class="fa fa-trophy fa-stack-1x fa-inverse"></i>
                            </span>
                        @endif
                        @if($k==2)
                            <span class="fa-stack fa-lg">
                                    <i style="font-size: 170%;color: cadetblue" class="fa fa-circle fa-stack-1x"></i>
                                    <i style="color:#a94442;" class="fa fa-trophy fa-stack-1x fa-inverse"></i>
                            </span>
                        @endif
                        <img class="media-object" width="22" height="22"  src="{{asset($user->avatar)}}" onerror="imgError(this,'user');" alt=":("/>
                        <strong>{{$user->username}}</strong>

                    </li>
                </a>
            @endforeach
        </ul>

    </div>
</div>
