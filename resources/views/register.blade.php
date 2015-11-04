@extends('app')


@section('content')
    @include('partials.messages')

<div class="container">


    <div class="col-lg-9 col-md-push-1 " >
        {!! Form::open(['route' => 'welcome.addRegister','id'=>'register_user', 'files'=>true,'method' => 'POST','class'=>'form-inline']) !!}

        <br>

        <span>Ya casi podras disfrutar de Solution Book!!</span>

        @include('partials.registerForm')


    </div>
</div>
    <br><br> <br>

</div>


@endsection
@section('scripts')
    <script src="{{asset('/js/findUsername.js')}}"></script>
@endsection
