@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card mt-5">
                    <div class="row">
                        @include('layouts.side-menu')
                        <div class="col-md-9 py-4 pl-lg-0">
                            <div class="mt-0">
                                <div class="col-md-12">

                                    <div class="questtions-label page-heading">TEST RESULT</div>

                                    <div class="alert alert-success mt-5" role="alert">
                                        {!! 'Your total score is '.$score.' out of '.$count  !!}. <a href="">Retry again</a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
