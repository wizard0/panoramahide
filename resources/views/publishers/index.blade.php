@extends('layouts.app')

@section('content')
<div class="container"></div>
<div class="cover min-cover" style="background: url(/img/cover-bg.jpg) center center no-repeat;">
    <div class="container h-100">
        <div class="d-flex flex-column h-100 justify-content-center align-items-center">
            <div class="row justify-content-center w-100">
                <div class="col-xl-6 col-lg-6 col-12 text-center">
                    <div class="search-intro">
                        <span class="text-uppercase">Издательства</span>
                        <p>Издательства журналов издательского дома «Панорама»</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">


    <div class="row">
        <div class="col-12">
            <div class="breadcrumbs">
                <ul>
                    <li><a href="/">Главная</a></li>
                    <li><a href="/categories/">Издательства</a></li>
                </ul>
            </div>
        </div>

        @foreach($publishers as $publisher)
            <div class="col-xl-6 col-lg-6 col-12 theme-item">
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                        <div class="theme-img">
                            <a href="{{ route('publisher', ['code' => $publisher->code]) }}">
                                <img src="{{ $publisher->image }}" alt="{{ $publisher->name }}"></a>
                        </div>
                    </div>
                    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-12">
                        <h3 class="text-uppercase"><a href="{{ route('publisher', ['code' => $publisher->code]) }}" class="black-link">{{ $publisher->name }}</a></h3>
                        <p>
                            {!! $publisher->description !!}
                        </p>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
</div>
@endsection
