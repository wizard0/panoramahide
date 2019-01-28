@extends('layouts.app')

@section('content')

    <div class="container"></div>

    @include('includes.searchbar')

    <div class="container"></div>

    <div class="show-results">
        <div class="container">
            <div class="row justify-content-around">
                <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">

                    @include('article.detail.breadcrumbs')

                </div>
                <div class="col-xl-2 col-lg-2 col-2">
                </div>
                <div class="col-xl-8 col-lg-8 col-12 order-3 order-xl-2 order-lg-2">
                    <div class="row">
                        <div class="article-main col">
                            <p></p>
                            <h3>{{ $article->name }}</h3>
                            <div class="first-announce"></div>
                            <div class="issue-announce">
                                @foreach($article->authors as $author)
                                    <div class="authors">
                                        <a href="/search/?author={{ $author->name }}&amp;type=article&amp;extend=1">{{ $author->name }}</a></div>
                                @endforeach
                            </div>
                            <div class="delimiter"></div>
                        </div>
                    </div>

                    <div class="holder article-from-issue">
                        <h2 class="text-uppercase text-center">Эта статья в журнале</h2>
                        <div class="container">
                            <div class="row">
                                <div class="col-xl-4 col-lg-4 col-12">
                                    <div class="issue-cover">
                                        <a href="{{ route('release', ['journalCode' => $journal->code, 'releaseID' => $release->id]) }}"><img src=""></a>
                                    </div>
                                </div>
                                <div class="col-xl-8 col-lg-8 col-12">
                                    <h3><a href="{{ route('release', ['journalCode' => $journal->code, 'releaseID' => $release->id]) }}" class="black-link">
                                            {{ __('Журнал') }} "{{ $journal->name }}"
                                        </a></h3>
                                    <div class="issue-date">№ {{ $release->number }}, {{ $release->year }}</div>
                                    <div class="issue-announce"></div>
                                </div>
                            </div>
                        </div>					</div>
                </div>

                <div class="col-xl-2 col-lg-2 col-12 order-2 order-xl-3 order-lg-3">

                    @include('includes.sidebar', ['hide' => ['subscribe']])

                </div>

                @include('includes.sidebar_modals')

            </div>
        </div>
    </div>

    <div class="container"></div>

@endsection
