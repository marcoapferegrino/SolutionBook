@extends('app')


@section('content')
    @include('partials.messages')

<div class="container">


    <div class="col-lg-10 col-md-push-1 " >
        {!! Form::open(['route' => 'welcome.addRegister','id'=>'register_user', 'files'=>true,'method' => 'POST']) !!}

        <br>
        <div class="page-header text-center bg-success">
            <h1>Solution Book!
                <small>Bienvenido ya casi podrás disfrutar de SolutionBook</small>
            </h1>
        </div>


        @include('partials.registerForm')


    </div>
</div>
    <br><br> <br>


@endsection
@section('scripts')
    <script src="{{asset('/js/findUsername.js')}}"></script>
    <script src="{{asset('/js/comparePasswords.js')}}"></script>
@endsection
