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
    <script src="{{ asset('js/bootstrap.js') }}"></script>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/vue.css') }}" rel="stylesheet">
    <script>
        @if(isset($release_id))
            window.release_id = {{ $release_id }};
        @endif
        window.user = {
            guest:          {{ Auth::guest()  ? 1: 0 }},
            partner:        {{ $isPartnerUser ? 1: 0 }},
            simpleReader:   {{ $simpleReader  ? 1: 0 }},
        };
        window.modal = {
            active: '{{ Session::has('modal') ? Session::get('modal') : null }}'
        };

    </script>
</head>
<body>

    @yield('content')

    <div id="modals">
        @if(!Auth::check())
            @include('includes.modals.register')
        @endif
        @include('includes.modals.reader')
    </div>

    <div id="scripts">
        @include('layouts.components.scripts')
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
