@extends('layouts.reader')

@section('content')

    <div id="menu">
        @include('reader.components.sidebar', [

        ])
    </div>
    <div id="body" class="panel">
        <div id="header">
            @include('reader.components.header')
        </div>
        <div id="panel">

        </div>
        <div id="footer">
            @include('reader.components.footer')
        </div>
    </div>


@endsection
