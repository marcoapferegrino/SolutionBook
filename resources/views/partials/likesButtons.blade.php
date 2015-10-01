@if(Auth::check())
    <div class="pull-right">
        <div class="row">
            <div class="col-md-4">
                Likes:{{$solution->numLikes}}
                Dislikes:{{$solution->dislikes}}
            </div>
            <div class="col-md-4">


                @if(!auth()->user()->hasLiked($solution->id))
                    {!! Form::open(['route'=>['likes.addLike',$solution->id],'method'=>'POST']) !!}
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-thumbs-up">
                        </i>{{$solution->numLikes}}
                    </button>&nbsp;&nbsp;&nbsp;&nbsp;
                    {!! Form::close() !!}
                @else
                    {!! Form::open(['route'=>['likes.disLike',$solution->id],'method'=>'DELETE']) !!}
                    <button type="submit" class="btn btn-danger">
                        <i class="fa fa-thumbs-down"></i>{{$solution->dislikes}}
                    </button>&nbsp;&nbsp;&nbsp;&nbsp;
                    {!! Form::close() !!}
                @endif


            </div>
            <div class="col-md-4">
                <i class="fa fa-gavel"></i> <strong>{{$solution->ranking}}</strong> ranking&nbsp;&nbsp;
            </div>

        </div>
    </div>
@endif