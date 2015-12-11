@extends('app')

@section('content')
<div class="container">
    <div class="row">
        @include('partials.messages')
        <div class="col-md-8">
            @include('forEverybody.partials.noticesHome')
        </div>
        <div class="col-md-4">
            @include('forEverybody.partials.topUsers')
            @include('forEverybody.partials.lastProblems')
        </div>
    </div>
</div>
@endsection

