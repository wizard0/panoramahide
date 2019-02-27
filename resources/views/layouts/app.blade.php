<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user_id" content="{{ Auth()->id() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="shortcut icon" href="{{{ asset('img/favicon.png') }}}">

    <!-- Scripts -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/popper.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/moment.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datetimepicker.js') }}"></script>
    <script src="{{ asset('js/default_scripts.js') }}"></script>
    <script src="{{ asset('js/CartManager.js') }}"></script>
    <script src="{{ asset('js/clipboard.min.js') }}"></script>
    <script src="{{ asset('js/SideBarManager.js') }}"></script>
    <script src="{{ asset('js/MagazinesDetailManager.js') }}"></script>
    <script src="{{ asset('js/panor/scripts.js') }}"></script>
    <script src="{{ asset('js/panor/panor.js') }}"></script>
    <script src="{{ asset('js/panor/search.js') }}"></script>

    <link rel="shortcut icon" href="{{{ asset('img/favicon.png') }}}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    @if (preg_match('/^\/personal\.*/', $_SERVER['REQUEST_URI']))
        <link href="{{ asset('css/personal.css') }}" rel="stylesheet">
    @endif
    @if (preg_match('/^\/personal\/order\/make.*/', $_SERVER['REQUEST_URI']))
        <link href="{{ asset('css/style_for_orders.css') }}" rel="stylesheet">
    @endif
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="{{ isset($bodyClass) ? $bodyClass : '' }}">
    @include('includes.header')

    @yield('content')

    @yield('sidebar.modals')

    @include('includes.footer')

    @yield('javascript')

    <script src="{{ asset('js/app.js') }}"></script>

    <div id="scripts">
        @include('layouts.components.scripts.captcha')
        @include('layouts.components.scripts.toastr')
    </div>
</body>
</html>
