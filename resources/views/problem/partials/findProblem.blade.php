<div class="pull-right ">
    @if(isset($judges))
        <div class="form-group">
            <select class="form-control" name="judgeList" id="judges">
                <option value='#'></option>
                @foreach($judges as $j)
                    <option value="{{$j->id}}">{{$j->name}}</option>
                @endforeach
            </select>
        </div>
        @endif
    <div class="form-group">{!!Form::text('buscar','',['class'=>'form-control col-sm-4','placeholder'=>$placeholder])!!}
    </div>

    <button type="submit" class="btn btn-info"> <i class="fa fa-search"></i> </button>
</div>
    {!! Form::close() !!}