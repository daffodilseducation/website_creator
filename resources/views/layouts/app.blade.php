<?php 
$data= Auth::user();
//die;
?>
<!DOCTYPE html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sso.css') }}" rel="stylesheet">
    <style>
        .headeractions{margin: 0; padding: 0; display: flex; align-items: center;}
        .headeractions li{ list-style-type: none; margin: 0; padding: 0;}
        .headeractions li a{font-size: 16px;}
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="javascript:void(0);">
                    <img src="{{ asset('/images/logo/lo2_logo.jpg')}}">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    @if(!empty($data))
                    <ul class="navbar-nav ml-auto">
                         <nav class="navbar navbar-default navbar-fixed-top">
                            <div id="navbar" class="navbar-collapse collapse">
                                <ul class="nav navbar-nav">
                                  <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><img src="{{ asset('/images/menu.png')}}"> <span class="caret"></span></a>
                                    <ul class="dropdown-menu" role="menu">
                                      @if($data->role == 'client')
                                      <li><a href="{{ url('/home')}}" class="dropdown-item">Dashboard</a></li>
                                      <li><a href="{{ url('/client-user')}}" class="dropdown-item">Client User List</a></li>
                                      <li><a href="{{ url('/domain')}}" class="dropdown-item">Domain</a></li>
                                      <li><a href="{{ url('/menus')}}" class="dropdown-item">Menu</a></li>
                                      @else
                                      <li><a href="{{ url('/home')}}" class="dropdown-item">Dashboard</a></li>
                                      <li><a href="{{ url('/client-list')}}" class="dropdown-item">Client List</a></li>
                                      @endif
                                    </ul>
                                  </li>
                                </ul>

                              </div><!--/.nav-collapse -->
                        </nav>
                        @endif
                    <!--</ul>-->
                        <!-- Authentication Links -->
                        @guest
                            <ul class="headeractions">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            </ul>
                            @endif
                        @else
                        <ul class="headeractions">
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <div class="roleas"> Role - <span><?php echo ucfirst(Auth::user()->role); ?> </span></div>
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
                            <ul>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>

