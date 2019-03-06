@extends('personal.index')

@section('page-content')
    <div class="content">
        @forelse($journals as $releases)
            @foreach($releases->chunk(4) as $chunk)
                @if($loop->first)
                    <h3>{{ $releases[0]->journal->name }}</h3>
                @endif
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
        @empty
            <p class="cart_empty">У вас нет доступных журналов.</p>
        @endforelse
    </div>
@endsection
