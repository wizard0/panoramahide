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

    <div class="mt-3">
        <div class="container">

            <div class="container">
                <div class="row ">
                    <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">

                        @include('publishers.detail.breadcrumbs')

                    </div>
                </div>
            </div>

            <div class="container">
                <div class="row">
                    <div class="col-xl-9 col-lg-9 col-12 order-1 order-xl-1 order-lg-1">
                        <div class="head-of-show-results">
                            <div class="row justify-content-between">

                                @include('includes.sortbar', ['sort_by' => !isset($_GET['sort_by']) ?: $_GET['sort_by']])

                                <div class="col-xl-2 col-lg-2 col-6">
                                    <div class="view-type">
                                        <div class="row no-gutters justify-content-end">
                                            <input id="row-view" type="radio" name="view-type" checked="checked"/><label class="rightsharp" for="row-view" value="row-view"></label>
                                            <input id="grid-view" type="radio" name="view-type"/>
                                            <label class="leftsharp" for="grid-view" value="grid-view"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row col-xl-9 col-lg-9 col-12 order-3 order-xl-2 order-lg-2">
                        @foreach($journals as $journal)
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
                    </div>

                    <div class="col-xl-2 col-lg-3 col-12 order-2 order-xl-3 order-lg-3 offset-xl-1">
                        @include('includes.sidebar')
                    </div>

                    @include('includes.sidebar_modals')
                </div>
            </div>
        </div>
    </div>
@endsection
