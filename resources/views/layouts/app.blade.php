<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="img/favicon.png" rel="icon">
    <!-- Latest compiled and minified CSS -->
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
    <!-- Bootstrap core CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.7.7/css/mdb.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

        @yield('styles')

</head>
<body>
    <header class="header">
        <div class="container">
            <div class="row site-header clearfix">
                <div class="col-lg-3 col-md-3 col-sm-6 title-area">
                    <div class="site-title" id="title">
                        <a href="{{ Auth::id() ? route('home') : route('index') }}" title="">
                            <img src="{{ asset('images/logo.png') }}">
                        </a>
                    </div>
                </div>

                <div class="col-lg-8 col-md-12 col-sm-12">

                    <nav class="navbar navbar-expand-md navbar-light bg-white">
                        <!-- Brand -->
                        <a class="navbar-brand" href="{{ Auth::id() ? route('home') : route('index') }}" title="">
                            <img src="{{ asset('images/logo.png') }}">
                        </a>

                        <!-- Toggler/collapsibe Button -->
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <!-- Navbar links -->
                        <div class="collapse navbar-collapse" id="collapsibleNavbar">
                            <ul class="navbar-nav mr-auto">

                                @guest
                                    <li class="nav-item">
                                        <a href="{{ route('login') }}">Log in</a>
                                    </li>
                                    @if (Route::has('register'))
                                        <li class="nav-item">
                                            <a href="{{ route('register') }}">Register</a>
                                        </li>
                                    @endif
                                @else
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Hi, {{ Auth::user()->name }} <span class="caret"></span>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-left" aria-labelledby="navbarDropdown">
                                            @if(Auth::user()->user_type != 'admin')
                                                <a class="dropdown-item" href="{{ route('home') }}">
                                                    Flashcards
                                                </a>
                                                <a class="dropdown-item" href="{{ route('account.setting') }}">
                                                    My Account
                                                </a>
                                            @endif
                                            <a class="dropdown-item" href="{{ route('logout') }}"
                                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                                {{ __('Logout') }}
                                            </a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                @csrf
                                            </form>
                                        </div>
                                    </li>
                                @endguest

                            </ul>
                        </div>
                    </nav>
                    <div class="topnav">
                        <div class="topnav-right">
                            @guest
                                <a href="{{ route('login') }}">Log in</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}">Register</a>
                                @endif
                            @else
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    Hi, {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    @if(Auth::user()->user_type != 'admin')
                                    <a class="dropdown-item" href="{{ route('home') }}">
                                        Flashcards
                                    </a>
                                    <a class="dropdown-item" href="{{ route('account.setting') }}">
                                        My Account
                                    </a>
                                    @endif
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            @endguest
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    @yield('content')
    <footer>
        <div class="footer text-center">
            Copyright © 2019 CBETFlashcards.com
        </div>
    </footer>

    <!-- JQuery -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.7.7/js/mdb.min.js"></script>

    @yield('scripts')
<script>
    $('#spotted-on-test').on('click', function () {
       $.ajax({
           url: '{{ route('check.spotted') }}',
           success: function (response) {
               if(response.success){
                   window.location.href = "{{ route('spotteds.all') }}";
               }else{
                   $('#spottedModal').modal('show');
               }
           }
       })
    });
</script>
    <script>
        (function(i,s,o,g,r,a,m){
            i['GoogleAnalyticsObject']=r;
            i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},
                i[r].l=1*new Date();
            a=s.createElement(o),m=s.getElementsByTagName(o)[0];
            a.async=1;
            a.src=g;
            m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-139573833-1', 'auto');
        ga('send', 'pageview');
    </script>
</body>
</html>