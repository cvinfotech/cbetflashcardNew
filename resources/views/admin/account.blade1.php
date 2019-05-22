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

                                    <div class="questtions-label page-heading">Account Setting</div>
                                {!! Form::open(['route' => 'admin.updateAccount']) !!}
                                @csrf
                                <!--  -->
                                    <div class="md-form">
                                        {{ Form::text('email', !empty($user) ? $user->email : '',
                                        ['required' => 'required', 'disabled' => 'disabled', 'readonly' => 'readonly', 'class' => 'form-control'.($errors->has('email') ? ' is-invalid' : ''), 'id' => 'email', 'placeholder' => 'Email']) }}
                                        <i class="fa fa-envelope icon"></i>
                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Password -->
                                    <div class="md-form">
                                        <input id="materialLoginFormPassword" type="password"
                                               class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                               name="password" autocomplete="current-password" placeholder="Password">
                                        <i class="fa fa-key icon"></i>
                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                        @endif
                                    </div>

                                    <!-- Password -->
                                    <div class="md-form">
                                        <input id="password-confirm" type="password"
                                               class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}"
                                               name="password_confirmation" placeholder="Confirm Password">
                                        <i class="fa fa-key icon"></i>
                                        @if ($errors->has('password_confirmation'))
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                        @endif
                                    </div>

                                    <!-- Sign in button -->
                                    <button class="btn btn-outline-theme btn-rounded btn-block my-4 waves-effect z-depth-0"
                                            type="submit">Save Changes
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
