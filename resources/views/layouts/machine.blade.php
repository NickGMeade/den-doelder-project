<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Den Doelder</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
          integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
          crossorigin="anonymous"/>

    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    @yield('third_party_stylesheets')

    @stack('page_css')
</head>

<div class="card">
    <body>
    <!-- Main Header -->
    <div class="card-header navbar navbar-expand navbar-light colour-purple">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="secondLiHeader"><h1 class="headerCenter">@yield('header')</h1></li>
        </ul>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                    <img src="/img/pallets150.jpg"
                         class="user-image img-circle elevation-2" alt="Goose">
                    <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <!-- User image -->
                    <li class="user-header shade">
                        <img src="/img/pallets150.jpg"
                             class="img-circle elevation-2"
                             alt="User Image">
                        <p>
                        <h6> {{ Auth::user()->name }}</h6>
                        <span class="badge colour-orange ">{{ Auth::user()->role }} team</span>
                        <small>Member since {{ Auth::user()->created_at->format('M. Y') }}</small>
                        </p>

                    </li>
                    <!-- Menu Footer-->
                    <li class="user-footer">
                        <a href="#" class="btn shade ">Profile</a>
                        <a href="#" class="btn shade float-right"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Sign out
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </div>

    <!-- Left side column. contains the logo and sidebar -->
{{--@include('layouts.sidebar')--}}

<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content">
            <div class="card-body">
            @yield('content')
            </div>
        </section>
    </div>



<script src="{{ mix('js/app.js') }}" defer></script>

@yield('third_party_scripts')

@stack('page_scripts')
    </body>
</div>

</html>
