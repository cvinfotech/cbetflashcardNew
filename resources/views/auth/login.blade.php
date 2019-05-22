@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- Material form login -->
                <div class="card mt-5">

                    <div class="card-header theme-color white-text text-center py-4">
                        <h1 class="text-uppercase font-weight-bold">Login</h1>
                        <h4 class="">
                            <strong>Don't have an account? <a href="{{ route('register') }}">Click here to register</a></strong>
                        </h4>
                    </div>

                    <!--Card content-->
                    <div class="card-body px-lg-5">

                        <!-- Form -->
                        <form class="text-center" style="color: #757575;" method="POST" action="{{ route('login') }}">
                            @csrf
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

                            <div class="d-flex justify-content-end">

                                <div>
                                    <!-- Forgot password -->
                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link pr-0" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                                </div>
                            </div>

                            <!-- Sign in button -->
                            <button class="btn btn-outline-theme btn-rounded btn-block my-4 waves-effect z-depth-0"
                                    type="submit">Sign in
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
