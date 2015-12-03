@extends('app')

@section('content')
    @include('partials.messages')

    <div class="table">

        <div class="row ">

                    <div class="col-md-8 col-lg-push-2 ">
                        <div class="panel panel-primary ">
                            <div class="panel-heading"><strong>Configuraciones de estilo de Solution Book</strong></div>

                            <div class="panel-body col-md-12 ">

                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th> Nombre del estilo </th>

                                        <th> Estado </th>
                                        <th> Acciones </th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                        @foreach($styles as $style)
                                            <tr>

                                            <th>{{$style->name}}</th>
                                            <th>{{$style->state}}</th>


                                            <th>
                                                @if($style->state!='Activo')
                                                    {!! Form::open(['route' => ['user.activateCss'],'method' => 'POST']) !!}
                                                    <button type="submit" onclick="return confirm('¿Seguro que quieres cambiar el estilo para todo el mundo?')" class="btn btn-success">
                                                        <i class="fa fa-paint-brush"> Activar</i>


                                                    </button>
                                                    <input type="hidden" name="style_id" id="style_id" value="{{$style->id}}">
                                                    {!! Form::close() !!}
                                                @endif

                                            </th>


                                            </tr>


                                        @endforeach



                                    </tbody>



                                </table>


                            </div>


                        </div>

                    </div>


                    <div class="col-md-1">

                    </div>




        </div></div>
@endsection

