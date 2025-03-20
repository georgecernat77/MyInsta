<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="app-url" content="{{ env('MEMCACHED_HOST') }}">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MyInsta') }}</title>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ mix('resources/css/app.css') }}">
    <link rel="stylesheet" href="{{ mix('resources/css/showPost.css') }}">
    <link rel="stylesheet" href="{{ mix('resources/css/indexPost.css') }}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">



    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])


</head>
<body>
    <div id="app" class="d-flex flex-column" style="height: 100vh">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container" style="width: 1000px;">
                <a class="navbar-brand d-flex flex-column justify-content-center align-items-center" href="{{ url('/') }}">
                    <div><img src="/svg/smartphone-logo.svg" alt="logo" style="height: 30px;"></div>
                    <div>MyInsta</div>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav nav-center">
                        @auth
                            <div class="search-box d-flex flex-column">
                                <i class="fas fa-search search-icon"></i>
                                <input type="text" id="searchBar" class="search-bar" placeholder="Search" autocomplete="off">
                                <div id="search-modal">
                                    <div class="search-results d-flex justify-content-center">
                                        <div class="results-box" id="resultsBox">
                                            <div class="pl-3 pt-3 pb-1">
                                                <span class="text-dark" style="font-size: 14px; font-weight: 600">Results</span>
                                            </div>
                                            <div class="profile-results" id="profileResults"></div>
                                            {{--                                        <div class="search-result">--}}
                                            {{--                                            <a href="/profile/{{ auth()->user()->id }}" class="text-decoration-none"--}}
                                            {{--                                               target="_blank">--}}
                                            {{--                                                <div class="d-flex align-items-center justify-content-between">--}}
                                            {{--                                                    <div class="d-flex align-items-center" style="line-height: 1.4;">--}}
                                            {{--                                                        <div class="pl-3 pr-3">--}}
                                            {{--                                                            <img src="{{ auth()->user()->profile->profileImage() }}"--}}
                                            {{--                                                                 class="w-100 rounded-circle"--}}
                                            {{--                                                                 style="height: 44px; width: 44px" alt="user-image">--}}
                                            {{--                                                        </div>--}}
                                            {{--                                                        <div class="d-flex flex-column">--}}
                                            {{--                                                            <span class="font-weight-bold text-dark"--}}
                                            {{--                                                                  style="font-size: 14px;">--}}
                                            {{--                                                                {{ auth()->user()->username }}--}}
                                            {{--                                                            </span>--}}
                                            {{--                                                            <span--}}
                                            {{--                                                                style="font-weight: 400; font-size: 14px; color: rgb(168, 168, 168);">--}}
                                            {{--                                                                <div class="d-flex">--}}
                                            {{--                                                                    {{ auth()->user()->name }}--}}
                                            {{--                                                                    <div class="pl-1 pr-1">•</div>--}}
                                            {{--                                                                    {{ auth()->user()->profile->followers->count() }} followers--}}
                                            {{--                                                                </div>--}}
                                            {{--                                                            </span>--}}
                                            {{--                                                        </div>--}}
                                            {{--                                                    </div>--}}
                                            {{--                                                </div>--}}
                                            {{--                                            </a>--}}
                                            {{--                                        </div>--}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endauth
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->username }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="/profile/{{ auth()->user()->id }}">Profile</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4 d-flex flex-column align-items-center">
            <div class="main-content" style="width: 1000px;">
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
