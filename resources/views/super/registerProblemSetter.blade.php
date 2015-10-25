@extends('app')

@section('content')
    @include('partials.messages')
    <div class="container">


        <div class="col-lg-9 col-md-push-2 " >
            {!! Form::open(['route' => 'users.addProblemSetter','method' => 'POST','class'=>'form-inline','files'=>true]) !!}

            <br>

            <span> Aqui puedes agregar problem setters!!</span>

            @include('partials.registerForm')


        </div>
    </div>
    <br><br> <br>

    </div>

@endsection
