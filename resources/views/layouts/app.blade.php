<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | {{ config('app.name', 'Laravel') }}</title>
    @section('title','Home')

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <nav class="absolute top-0 left-0 right-0 h-16 bg-white shadow-sm">
            <div class="flex flex-row justify-between items-center h-full w-full">
                <a class="text-xl font-bold px-4" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                
                @guest
                    <div>
                        @if (Route::has('login'))
                            <a class="mx-2" href="{{ route('login') }}">{{ __('Login') }}</a>
                        @endif

                        @if (Route::has('register'))
                            <a class="mx-2" href="{{ route('register') }}">{{ __('Register') }}</a>
                        @endif
                    </div>
                @else
                    <div>
                        <span class="font-bold">{{ Auth::user()->name }}</span>

                        <a class="mx-2" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                    </div>
                @endguest

            </div>
        </nav>

        <main class="py-4 h-screen pt-20">
            @yield('content')
        </main>
    </div>
</body>
</html>
