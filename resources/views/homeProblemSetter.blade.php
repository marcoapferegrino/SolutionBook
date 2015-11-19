@extends('app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            @include('forEverybody.partials.noticesHome')
        </div>
        <div class="col-md-4">
            @include('forEverybody.partials.topUsers')
        </div>
    </div>
</div>
@endsection

