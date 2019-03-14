@php
$releases = Release::with(['journal'])->newestTranslated(4)->get();
$releases->load('journal.translations');
@endphp

<div class="holder latest-issues">
    <h2 class="text-uppercase text-center m-b-20 m-t-20">{{ __('Новые журналы') }}</h2>
    <div class="container">
        <div class="row">

            @foreach($releases as $release)
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="row mainpage-issue align-items-center">
                    <div class="issue-image col-12">
                        <a href="{{ route('release', [
                            'journalCode' => $release->journal->code,
                            'releaseID' => $release->id
                        ]) }}" class="d-block">
                            <img src="{{ $release->image }}">
                        </a>
                    </div>
                    <div class="issue-number col-12">№{{ $release->number }} / {{ $release->year }}</div>
                    <div class="issue-title col-12">
                        <a href="{{ route('release', [
                            'journalCode' => $release->journal->code,
                            'releaseID' => $release->id
                        ]) }}" class="black-link">
                            {{ $release->journal->name }} №{{ $release->number }}						</a>
                    </div>
                    <div class="issue-price col-6">{{ $release->price_for_electronic }} <span>р.</span></div>
                    <div class="col-6 issue-to-cart">
                        <a  href="{{ route('release', [
                                'journalCode' => $release->journal->code,
                                'releaseID' => $release->id
                            ]) }}"
                            class="red-link _access_number addToCart"
                            data-id="{{ $release->id }}"
                            data-type="electronic"
                        >
                            {{ __('В корзину') }}
                        </a>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
        <div class="row justify-content-center">
            <div class="col-auto">
                <a href="/search/?type=magazine&extend=1" class="more d-block"><span>{{ __('Все журналы') }}</span></a>
            </div>
        </div>
    </div>
</div>

