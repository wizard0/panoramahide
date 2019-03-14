@extends('personal.index')

@section('page-content')
    <div class="content">
        @if(count($journals) !== 0)
            @foreach($journals as $releases)
                @foreach($releases->chunk(4) as $chunk)
                    @if($loop->first)
                        <h3 class="text-center text-uppercase section-title personal-title m-t-20 m-b-20">{{ $releases[0]->journal->name }}</h3>
                    @endif
                    <div class="row">
                        @foreach($chunk as $release)
                            <div class="col-12 col-md-6 col-lg-4 col-xl-3 m-b-30">
                                <div class="title-magazine">
                                    <a title="{{ $release->name }}" href="{{ $release->getReaderLink() }}">
                                        {{ str_limit($release->name, 40) }}
                                    </a>
                                    <p>№{{ $release->number }}/{{ $release->year }}</p>
                                </div>
                                <a title="{{ $release->name }}" href="{{ $release->getReaderLink() }}">
                                    <img class="w-100" src="{{ $release->image }}">
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            @endforeach
        @else
            <p class="cart_empty">У вас нет доступных журналов.</p>
        @endif
    </div>
@endsection
