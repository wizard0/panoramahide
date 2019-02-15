@extends('layouts.reader')

@section('content')

    <div id="reader-menu">
        @if(isset($oRelease) && !is_null($oRelease))
            @include('reader.components.sidebar', [
                'oArticles' => $oArticles,
                'oReleases' => $oReleases,
            ])
        @endif
    </div>
    <div id="reader" class="panel">
        <div id="reader-header">
            @include('reader.components.header')
        </div>
        <div id="reader-panel">
            @if(isset($oRelease) && !is_null($oRelease))
                <div class="panel-cover">
                    <img class="panel-cover" src="{{ $oRelease->image }}">
                </div>
                <div class="container js-toc-content">
                    <div class="bookmarks-holder"></div>
                    <nav>
                        <div class="contents">
                            <div>
                                <span class="contents-title" id="content-title">Содержание</span>
                            </div>
                            @foreach($oArticles as $oArticle)
                                <div class="heading">
                                    <a href="#article{{ sprintf("%02d", $oArticle->id) }}">{{ $oArticle->name }}</a>
                                </div>
                                @if(count($oArticle->authors) !== 0)
                                    @foreach($oArticle->authors as $oAuthor)
                                        <div class="contents-author">
                                            <p>{{ $oAuthor->name }},</p>
                                        </div>
                                    @endforeach
                                @endif
                                @if(!is_null($oArticle->description))
                                    <div class="announce">
                                        <p>{{ $oArticle->description }}</p>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </nav>
                    @foreach($oArticles as $oArticle)
                        {!! $oArticle->html !!}
                    @endforeach
                </div>
            @endif
        </div>
        <div id="reader-footer">
            @if(isset($oRelease) && !is_null($oRelease))
                @include('reader.components.footer', [
                    'oRelease' => $oRelease,
                ])
            @endif
        </div>
    </div>



@endsection
