<div class="breadcrumbs">
    <ul>
        <li><a href="/">Главная</a></li>
        <li><a href="{{ route('journals') }}">Журналы</a></li>
        <li><a href="{{ route('journal', ['code' => $journal->code]) }}">{{ $journal->name }}</a></li>
        <li><a href="{{ route('release', ['releaseID' => $release->id, 'journalCode' => $journal->code]) }}">
                №{{ $release->number }}, {{ $release->year }}
            </a></li>
        <li><a href="">{{ $article->name }}</a></li>
    </ul>
</div>
