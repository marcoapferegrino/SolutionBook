@extends('app')

@section('content')
    @include('partials.messages')
<div class="container">


    <div class="col-lg-9 col-md-push-2 " >
        {!! Form::open(['route' => 'welcome.addRegister','method' => 'POST','class'=>'form-inline']) !!}

        <br>

        <span>Ya casi podras disfrutar de Solution Book!!</span>

        @include('partials.registerForm')


    </div>
</div>
    <br><br> <br>

</div>

@endsection

