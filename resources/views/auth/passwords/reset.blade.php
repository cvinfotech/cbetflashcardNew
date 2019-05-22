@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- Material form login -->
                <div class="card mt-5">

                    <div class="card-header theme-color white-text text-center py-4">
                        <h1 class="text-uppercase font-weight-bold">Reset Password</h1>
                    </div>
                    <div class="card-body px-lg-5">
                    <!-- Form -->
                        <form class="text-center" style="color: #757575;" method="POST" action="{{ route('password.update') }}">
                        @csrf
                            <input type="hidden" name="token" value="{{ $token }}">
                        <!-- Email -->
                            <div class="md-form">
                                <input id="materialLoginFormEmail" type="email"
                                       class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                       name="email" value="{{ old('email') }}" required autocomplete="email"
                                       autofocus placeholder="Email Address">
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
                                       name="password" required autocomplete="current-password" placeholder="Password">
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
                                       name="password_confirmation" required placeholder="Confirm Password">
                                <i class="fa fa-key icon"></i>
                                @if ($errors->has('password_confirmation'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <!-- Sign in button -->
                            <button class="btn btn-outline-theme btn-rounded btn-block my-4 waves-effect z-depth-0"
                                    type="submit">Reset Password
                            </button>



                        </form>
                        <!-- Form -->

                    </div>

                </div>
                <!-- Material form login -->
            </div>
        </div>
    </div>
@endsection
