

<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title">Top Solvers</h3>
    </div>
    <div class="panel-body">

        <ul class="list-group">
            @foreach($topUsers as $user)
                <a href="{{(Auth::guest())?'#':url('/userPerfil/'.$user->id)}}">
                    <li class="list-group-item">
                        <span class="badge">{{$user->ranking}} pts</span>
                        <img class="media-object" width="22" height="22" src="{{$user->avatar}}" alt=":("/>
                        <strong>{{$user->username}}</strong>
                    </li>
                </a>
            @endforeach
        </ul>

    </div>
</div>
