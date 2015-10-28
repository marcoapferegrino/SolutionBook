@extends('app')

@section('content')
    <div class="container">

        @include('partials.messages')
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <h3>Mis amonestaciones</h3>
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
                                    <div id="collapse{{$warning->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{$warning->id}}">
                                        <div class="panel-body">
                                            <p class="text-justify">{{$warning->description}}</p>
                                        </div>
                                        <div class="well"><strong>Link de pruebas:</strong> <br>
                                            @foreach($warning->links as $link)
                                                <a href="{{$link->link}}">{{$link->link}}</a>
                                            @endforeach
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <button type="button" class="btn btn-block btn-warning">Ignorar</button>
                                            </div>
                                            <div class="col-lg-6">
                                                <button type="button" class="btn btn-block btn-info">Resolver</button>
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
