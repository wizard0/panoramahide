@extends('layouts.app')

@section('breadcrumbs-content')
    <li>
        <a href="/">Главная</a>
    </li>
    <li class="active">
        Журналы
    </li>
@endsection

@section('content')
    @include('includes.searchbar')

    @include('includes.breadcrumbs')

    <div class="show-results">
        <div class="container">
            <div class="row">
                <div class="col-xl-9 col-lg-9 col-12 order-1 order-xl-1 order-lg-1">
                    <div class="head-of-show-results">
                        <div class="results-count">
                            <span>Найдено <span>{{ Journal::count() }}</span> журнала</span>
                        </div>

                        <div class="row justify-content-between">

                            @include('includes.sortbar', ['sort_by' => !isset($_GET['sort_by']) ?: $_GET['sort_by']])

                            <div class="col-xl-2 col-lg-2 col-6">
                                <div class="view-type">
                                    <div class="row no-gutters justify-content-end">
                                        <input id="row-view" type="radio" name="view-type" checked="checked"/><label
                                                class="rightsharp" for="row-view" value="row-view"></label>
                                        <input id="grid-view" type="radio" name="view-type"/>
                                        <label class="leftsharp" for="grid-view" value="grid-view"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row col-xl-9 col-lg-9 col-12 order-3 order-xl-2 order-lg-2">
                    @foreach ($journals as $journal)
                        @component('components.journal_item', [
                            'id' => $journal->id,
                            'image' => $journal->image,
                            'name' => $journal->name,
                            'code' => $journal->code,
                            'issn' => $journal->issn,
                            'releases' => $journal->releases->load('translations'),
                        ])
                        @endcomponent
                    @endforeach
                    <div class="w-100 pagination d-flex justify-content-center">
                        {{ $journals->links() }}
                    </div>
                </div>

                <div class="col-xl-2 col-lg-3 col-12 order-2 order-xl-3 order-lg-3 offset-xl-1">
                    @include('includes.sidebar', compact('journal'))
                </div>

                @include('includes.sidebar_modals')

            </div>
        </div>
    </div>

    @include('includes.new_journals')

@endsection
