<div class="breadcrumbs">
    <ul>
        <li><a href="/">Главная</a></li>
        <li><a href="{{ route('journals') }}">Журналы</a></li>
        <li><a href="">{{ $journal->name }} /
                {{ $journal->translate('en', true)->name }}</a></li>
    </ul>
</div>
