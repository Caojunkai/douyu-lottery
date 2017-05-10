<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script>
      window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body>
<div id="app">
    <douyu-navbar
            app-name="{{ config('app.name', 'Laravel') }}"
            app-link="{{ url('/') }}"
            lottery-name="抽奖"
            lottery-link="{{ route('lottery.index') }}"
            is-login="{{ (!Auth::guest()) }}"
            @if( !Auth::guest() )
            user-name="{{ Auth::user()->name }}"
            logout-link="{{ route('logout') }}"
            @endif
            login-link="{{ route('login') }}"
            register-link="{{ route('register') }}"
    ></douyu-navbar>
    @yield('content')
</div>
<!-- Scripts -->
<script src="{{ mix('js/app.js') }}"></script>
@yield('js')

</body>
</html>
