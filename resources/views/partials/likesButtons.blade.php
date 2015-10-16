@if(Auth::check())
    <div class="pull-right solution" data-id="{{$solution->id}}">

            <div class="col-md-2 col-lg-offset-4">
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
            <div class="col-md-3">
                <span class="label label-info numLikes">{{$solution->numLikes}} likes</span>
                @if(isset($solution->state))
                    <?php
                    if($solution->state=='active')
                        $class='success';
                    elseif($solution->state=='suspended' || $solution->state=='blocked')
                        $class='danger';
                    else
                        $class='info';
                    ?>
                    <span class="label label-{{$class}}">{{$solution->state}}</span>

                @endif
            </div>
            <div class="col-md-3">
                <i class="fa fa-gavel"></i> <small>{{$solution->ranking}} ranking</small>
            </div>

        
    </div>
@endif