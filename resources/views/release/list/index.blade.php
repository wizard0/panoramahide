@extends('layouts.app')

@section('content')

    @include('includes.searchbar')

    @include('release.list.breadcrumbs')

    <div class="container">
        <div class="show-results">
            <div class="container">
                <div class="row justify-content-around">
                    <div class="container">
                        <h1>Выберите выпуск для чтения</h1>
                        @foreach($releases->chunk(4) as $chunk)
                            <div class="row" style="margin-top: 30px;">
                                @foreach($chunk as $release)
                                    <a class="col-xs-12 col-md-4 col-lg-3" style="margin-bottom: 30px;"
                                        href="{{ route('api.release', [$partner, $user, $quota->id, $release->id]) }}">
                                        <p style="text-align: center;">{{ $release->name }}</p>
                                        <img src="{{ $release->image }}" style="width: 100%;">
                                    </a>
                                @endforeach
                            </div>
                        @endforeach
                    </div>

                    @include('includes.sidebar_modals')

                </div>
            </div>
        </div>

    </div>
@endsection
