@extends('app')

@section('content')
    <div class="table">


        @include('partials.messages')
        <div class=" row">


            <table class="table">

                <tbody>
                <tr>
                    <div class="col-md-1">

                    </div>

                    <div class="col-md-1">

                    </div>
                </tr>

                <tr>

                    @include('forEverybody.partials.noticesHome')

                </tr>


                <tr>
                    <div class="col-md-1">

                    </div>

                </tr>
            </tbody>


            </table>


        </div></div>
@endsection

