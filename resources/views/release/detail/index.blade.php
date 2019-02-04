@extends('layouts.app')

@section('content')
    <div class="container"></div>

    @include('includes.searchbar')

    <div class="container">
        <div class="show-results">
            <div class="container">
                <div class="row justify-content-around">
                    <div class="col-xl-8 col-lg-8 col-12 order-3 order-xl-2 order-lg-2">
                        <div>
                            <div class="row">
                                <div class="col-12">

                                    @include('release.detail.breadcrumbs')

                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-5 col-12">
                                    <a href="{{ route('journal', ['code' => $journal->code]) }}" class="h6">{{ $journal->name }}</a>
                                    <div class="issue-date">№ {{ $release->number }}, {{ $release->year }}</div>
                                    <div class="issue-cover">
                                        <img src="{{ $journal->image }}">
                                    </div>
                                </div>
                                <div class="col-xl-9 col-lg-9 col-md-9 col-sm-7 col-12">

                                    @foreach($articles as $article)
                                        @component('components.article_item', [
                                            'id' => $article->id,
                                            'author' => $article->authors->first()->name,
                                            'code' => $article->code,
                                            'name' => $article->name,
                                            'journalCode' => $journal->code,
                                            'journalName' => $journal->name,
                                            'releaseCode' => $release->code,
                                            'releaseID' => $release->id,
                                            'releaseName' => $release->name,
                                            'number' => $release->number,
                                        ])
                                        @endcomponent
                                    @endforeach

                                        {{--<script src="https://yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>--}}
                                        {{--<script src="https://yastatic.net/share2/share.js" async="async"></script>--}}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-2 col-lg-2 col-12 order-2 order-xl-3 order-lg-3">
                        @include('includes.sidebar')
                    </div>

                    @include('includes.sidebar_modals')

                </div>
            </div>
        </div>

        @include('includes.new_journals')

    </div>
@endsection
