@extends('layouts.app')

@section('breadcrumbs-content')
    <li>
        <a href="/">Главная</a>
    </li>
    <li class="active">
        Выпуски
    </li>
@endsection

@section('content')
    <div class="content">
        @include('includes.breadcrumbs')
        <div class="container">
            <h1>Выберите выпуск для чтения</h1>
            @foreach($releases->chunk(4) as $chunk)
                <div class="row" style="margin-top: 30px;">
                    @foreach($chunk as $release)
                        <a class="col-xs-12 col-md-4 col-lg-3" style="margin-bottom: 30px;" href="{{ $release->getReaderLink() }}">
                            <p style="text-align: center;">{{ $release->name }}</p>
                            <p style="text-align: center;">№{{ $release->number }}/{{ $release->year }}</p>
                            <img src="{{ $release->image }}" style="width: 100%;">
                        </a>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
@endsection
