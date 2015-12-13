@if(Auth::check())
    <div class="pull-right solution" data-id="{{$solution->id}}">
        <div class="col-xs-4 col-md-4">
            @include('solver.partials.editDeleteSolutionButtons')
        </div>
            <div class="col-xs-2 col-md-2">
                {!! Form::open(['id'=>'form-like','route'=>['likes.addLike',':id'],'method'=>'POST']) !!}
                <button type="submit" {!! Html::classes(['btn btn-primary btn-like','hidden'=>auth()->user()->hasLiked($solution->id)]) !!}>
                    <i class="fa fa-thumbs-up">
                    </i>
                </button>
                {!! Form::close() !!}

                {!! Form::open(['id'=>'form-unlike','route'=>['likes.disLike',':id'],'method'=>'DELETE']) !!}
                <button type="submit" {!! Html::classes(['btn btn-danger btn-unlike','hidden'=>!auth()->user()->hasLiked($solution->id)]) !!}>
                    <i class="fa fa-thumbs-down"></i>
                </button>
                {!! Form::close() !!}
            </div>
            <div class="col-xs-3 col-md-3">
                <span class="label label-info numLikes">{{$solution->numLikes}} likes</span>
                @if(isset($solution->state))
                    <?php
                    if($solution->state=='active'){
                        $class='success';
                        $title='Solución correcta';
                    }
                    elseif($solution->state=='suspended'){
                        $class='warning';
                        $title='En revisión';
                    }

                    else{
                        $class='danger';
                        $title='Esto no debió pasar';
                    }

                    ?>
                    <span data-toggle="tooltip" data-placement="right" title="{{$title}}" class="label label-{{$class}}">{{($solution->state=='active')?'Activa':'Suspendida' }}</span>

                @endif
            </div>
            {{--<div class="col-md-3">--}}
                {{--<i class="fa fa-gavel"></i> <small>{{$solution->ranking}} ranking</small>--}}
            {{--</div>--}}
        @if($solution->userId != auth()->user()->getAuthIdentifier()&&isset($solution->user_id)!=auth()->user()->getAuthIdentifier())
            <div class="col-xs-2 col-md-2">
                <a href="{{route('warning.getAddWarning',['id'=>$solution->id,'type'=>0])}}"><strong><small class="text-danger">Reportar</small></strong></a>
            </div>
        @endif

    </div>
@endif