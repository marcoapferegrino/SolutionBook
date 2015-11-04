<div class="pull-right">
    {!! Form::model(Request::all(),['route' => 'solutions.orderSolutions','method' => 'GET','class'=>'form-inline navbar-form navbar-left pull-right','role'=>'search']) !!}

   {!! Form::hidden('idProblem',isset($dataProblem->id)?$dataProblem->id:$idProblem) !!}

    <div class="form-group">
        {!! Form::select('language',config('optionsLanguages.lenguages'),null,array('class'=>'form-control')) !!}
    </div>
    <div class="form-group">
        {!! Form::select('restriction',config('optionsRestrictions.restrictions'),null,array('class'=>'form-control')) !!}
    </div>

    <button type="submit" class="btn btn-info"> <i class="fa fa-search"></i> </button>
    {!! Form::close() !!}
</div>