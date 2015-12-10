@extends('app')

@section('content')
    @include('partials.messages')

    <div class="table">

        <div class="row ">

                    <div class="col-md-10 col-lg-push-1 ">
                        <div class="panel panel-primary ">
                            <div class="panel-heading">Noticias</div>

                            <div class="panel-body col-md-12 ">

                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th> Título </th>

                                        <th> Fecha de expiración</th>
                                        <th> Imagen </th>
                                        <th> Fecha de creación</th>

                                        <th> Acciones </th>


                                    </tr>


                                    </thead>

                                    <tbody>
                                        @foreach($notices as $notice)
                                            <tr>

                                            <th>{{$notice->title}}</th>
                                            <th>{{$notice->finishDate}}</th>
                                            <th> <img src="{{$notice->path}}"  height="52" width="52"> </th>
                                            <th>{{$notice->created_at}}</th>
                                            <th>
                                                <div class="row">
                                                    <div class="col-sm-1">           <button type="submit" class="btn btn-warning" data-toggle="modal" data-target="#modalEditNotice{{$notice->id}}">
                                                            <i class="fa fa-pencil-square-o"></i>
                                                        </button>
                                                    </div>
                                                    <div class="col-sm-2">

                                                        {!! Form::open(['route' => ['notices.deleteNotice',$notice->id],'method' => 'DELETE']) !!}
                                                        <button type="submit" onclick="return confirm('¿Seguro que quieres eliminar la noticia?')" class="btn btn-danger">
                                                            <i class="fa fa-trash-o"></i>
                                                        </button>
                                                        {!! Form::close() !!}
                                                    </div>
                                                    <div class="col-sm-4">     <a href="{{route('notices.oneNotice',$notice->id)}}">    <button >Ver noticia </button></a>
                                                    </div>
                                                </div>





                                            </th>

                                                @include('super.partials.updateNoticia')

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

