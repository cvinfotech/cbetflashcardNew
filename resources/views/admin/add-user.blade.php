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

                                    @if(isset($user))
                                    <div class="questtions-label page-heading">EDIT USER</div>
                                    @else
                                    <div class="questtions-label page-heading">ADD USER</div>

                                    @endif
                                {!! Form::open(['route' => $route]) !!}
                                @csrf
                                <!--  -->
                                    @if(isset($user))
                                    {{ Form::hidden('user_id', $user->id) }}
                                    @endif
                                    <div class="md-form">
                                        {{ Form::text('name', isset($user) ? $user->name : '',
                                        ['required' => 'required', 'class' => 'form-control'.($errors->has('name') ? ' is-invalid' : ''), 'id' => 'name', 'placeholder' => 'Full Name']) }}
                                        <i class="fa fa-user icon"></i>
                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="md-form">
                                        {{ Form::email('email', isset($user) ? $user->email : '',
                                        ['required' => 'required', 'class' => 'form-control'.($errors->has('email') ? ' is-invalid' : ''), 'id' => 'email', 'placeholder' => 'Email Address']) }}
                                        <i class="fa fa-envelope icon"></i>
                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="md-form">
                                        {{ Form::text('plan', 'Free Plan',
                                        ['required' => 'required', 'class' => 'form-control', 'id' => 'plan', 'disabled' => 'disabled', 'placeholder' => 'Free Plan']) }}
                                        <i class="fa fa-tag icon"></i>
                                    </div>

                                    <div class="md-form">
                                        {{ Form::text('generated_pass', 'Generated password will be mailed to given email adress',
                                        ['required' => 'required', 'class' => 'form-control', 'id' => 'generated_pass', 'disabled' => 'disabled', 'placeholder' => 'Generated password will be mailed to given email adress']) }}
                                        <i class="fa fa-key icon"></i>
                                    </div>

                                    <!-- Sign in button -->
                                    <button class="btn btn-outline-theme btn-rounded btn-block my-4 waves-effect z-depth-0"
                                            type="submit">{{ isset($user) ? 'EDIT' : 'ADD' }}
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
