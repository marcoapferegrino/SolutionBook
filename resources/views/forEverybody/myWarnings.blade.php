@extends('app')

@section('content')
    <div class="container">

        @include('partials.messages')
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-warning">
                    <div class="panel-heading">

                        @if(Auth::getRol()!="super")
                        <h3>Mis amonestaciones </h3>
                        @else
                        <h3>Listado de amonestaciones {{\SolutionBook\Components\HtmlBuilder::obfuscater("us_f4")}}</h3>
                        @endif
                    </div>
                    <div class="panel-body">
                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

                            @foreach($warnings as $warning)
                                <div class="panel panel-danger">
                                    <div class="panel-heading" role="tab" id="heading{{$warning->id}}">
                                        <h4 class="panel-title">
                                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$warning->id}}"  aria-controls="collapse{{$warning->id}}">
                                                <strong>Warning</strong> <small>#{{$warning->id}}</small>
                                                <div class="pull-right">
                                                    @if($warning->reason=='copiedCode')
                                                        Código Copiado
                                                    @elseif($warning->reason=='notWorking')
                                                        No funciona
                                                    @elseif($warning->reason=='contentInapropiate')
                                                        Contenido inapropiado
                                                    @else
                                                        Otro
                                                    @endif
                                                </div>
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapse{{$warning->id}}" align="middle" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{$warning->id}}">
                                        <div class="panel-body">
                                            <p class="text-justify">{{$warning->description}}</p>
                                        </div>
                                        <div class="well"><strong>Links anexos:</strong> <br>
                                            @foreach($referencia as $ref)
                                                @if($ref->solution_id!=null && $ref->solution_id==$warning->solution_id && $ref->type=='Referencia')

                                                    <a href="{{$ref->link}}" target="_blank"><strong>Publicación de la solución <i class="fa fa-external-link-square"></i>
                                                        </strong></a><br>
                                                    <?php break; ?>
                                                @elseif($ref->problem_id!=null && $ref->problem_id==$warning->problem_id && $ref->type=='Referencia')

                                                    <a href="{{$ref->link}}" target="_blank">Publicación del problema <i class="fa fa-external-link-square"></i>
                                                    </a><br>
                                                    <?php break; ?>
                                                @endif
                                            @endforeach

                                            @foreach($warning->links as $link)
                                                <a href="{{$link->link}}" target="_blank">{{$link->link}}</a><br>
                                            @endforeach
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                @if(Auth::getRol()!="super")
                                                {!! Form::open(['route' => 'warning.ignoreWarning','method' => 'POST','class'=>'form-inline']) !!}
                                                <input type="hidden" name="warning_id" id="warning_id" value="{{$warning->id}}">
                                                {!! Form::submit('Ignorar',array('class'=>'btn btn-success btn-block')) !!}
                                                {!! Form::close() !!}
                                                @else
                                                {!! Form::open(['route' => 'warning.deleteWarning','method' => 'GET','class'=>'form-inline']) !!}
                                                <input type="hidden" name="warning_id" id="warning_id" value="{{$warning->id}}">
                                                {!! Form::submit('Eliminar',array('class'=>'btn btn-success btn-block','onclick'=>'return confirm("Seguro que quieres eliminar la amonestación?")')) !!}
                                                {!! Form::close() !!}

                                                @endif


                                            </div>
                                            <div class="col-lg-6">

                                                @if(Auth::getRol()!="super")
                                                    @if($warning->solution_id!=null)
                                                        <a href="{{url('/updateSolution/'.$warning->solution_id)}}"><button type="button" class="btn btn-block btn-info" >Modificar solución</button></a>

                                                    @elseif($warning->problem_id!=null)
                                                        <a href="{{url('/updateProblem/'.$warning->problem_id)}}"><button type="button" class="btn btn-block btn-info" >Modificar problema</button></a>

                                                    @endif

                                                @else
                                                    {!! Form::open(['route' => 'user.suspendAccount','method' => 'POST','class'=>'form-inline']) !!}
                                                    <input type="hidden" name="user_id" id="user_id" value="{{$warning->user_id}}">
                                                    {!! Form::submit('Suspender cuenta infractor',array('class'=>'btn btn-info btn-block','onclick'=>'return confirm("Seguro que quieres suspender cuenta?")')) !!}
                                                    {!! Form::close() !!}


                                                @endif

                                            </div>


                                        </div>



                                    </div>

                                </div>
                            @endforeach


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
