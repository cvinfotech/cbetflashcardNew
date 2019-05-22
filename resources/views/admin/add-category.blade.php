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
                                    <!-- Form -->
                                    @if (session('success'))
                                        <div class="alert alert-success" role="alert">
                                            {{ __(session('success')) }}
                                        </div>
                                    @endif
                                    @if (session('error'))
                                        <div class="alert alert-danger" role="alert">
                                            {{ __(session('error')) }}
                                        </div>
                                    @endif

                                    @if(isset($category))
                                    <div class="questtions-label page-heading">EDIT CATEGORY</div>
                                    @else
                                    <div class="questtions-label page-heading">ADD CATEGORY</div>
                                    @endif
                                {!! Form::open(['route' => $route, 'files' => 'true']) !!}
                                @csrf
                                <!--  -->
                                    @if(isset($category))
                                    {{ Form::hidden('category_id', $category->id) }}
                                    @endif
                                    <div class="md-form">
                                        {{ Form::text('name', isset($category) ? $category->name : '',
                                        ['required' => 'required', 'class' => 'form-control'.($errors->has('name') ? ' is-invalid' : ''), 'id' => 'name', 'placeholder' => 'Category']) }}
                                        <i class="fas fa-list"></i>
                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Sign in button -->
                                    <button class="btn btn-outline-theme btn-rounded btn-block my-4 waves-effect z-depth-0"
                                            type="submit">{{ isset($category) ? 'EDIT' : 'ADD' }}
                                    </button>


                                    {!! Form::close() !!}

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
