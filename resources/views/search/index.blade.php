@extends('layouts.app')

@section('content')
    <div class="container"></div>

    @include('includes.searchbar', compact('params'))

    <div class="container">
        <div class="breadcrumbs">
            <ul>
                <li><a href="/">Главная</a></li>
                <li><a href="/search/">Поиск</a></li>
            </ul>
        </div>
    </div>


    <div class="show-results"><div class="show-results"><div class="container">
                <div class="row">
                    @if ($search)
                        <div class="col-xl-9 col-lg-9 col-12 order-1 order-xl-1 order-lg-1">

                            <div class="head-of-show-results">
                                <div class="results-count">
                                    <span>Найдено <span>{{ $rowCount }}</span> результата</span>
                                </div>

                                <div class="row justify-content-between">
                                    @include('includes.sortbar', ['sort_by' => !isset($params['sort_by']) ?: $params['sort_by'] ])
                                    <div class="col-xl-2 col-lg-2 col-6">
                                        <div class="view-type">
                                            <div class="row no-gutters justify-content-end">
                                                <input id="row-view" type="radio" name="view-type" checked="checked">
                                                <label class="rightsharp" for="row-view" value="row-view"></label>
                                                <input id="grid-view" type="radio" name="view-type">
                                                <label class="leftsharp" for="grid-view" value="grid-view"></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @include('search.search_results', compact('search', 'params'))

                        @include('includes.sidebar')

                    @endif
                </div>
            </div>

            <script>
                window.q = '<mark>{{ $params['q'] }}</mark>';
            </script></div>

    </div>

@endsection