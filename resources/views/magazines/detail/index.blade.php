@extends('layouts.app')

@section('content')
    <div class="container"></div>

    @include('includes.searchbar', ['isJournalPage' => true])

    @include('magazines.detail.inner_menu')

    <div class="show-results" data-id="{{ $journal->id }}">
        @include('magazines.detail.tab_journal', compact('journal'))
    </div>

    <div class="container">
        @include('includes.new_journals')
    </div>

    <script>
        var MagazineDetailManager = new JSMagazineDetailManager(<?= json_encode(['code' => $journal->code]) ?>);
    </script>
@endsection

