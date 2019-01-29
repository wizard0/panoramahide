@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="promocodes __deskbooks">
            <div class="inform-holder">
                <div class="inform-cell high-cell">
                    <div class="inform">Мои журналы</div>
                </div>
            </div>
            <form action="{{ route('home.journals.save') }}" class="ajax-form --journal-checkboxes">
                @foreach($oPromocodes as $oPromocode)
                    @if(count($oPromocode->journals) !== 0)
                        <div class="section">
                            <div class="deskbook-section-title">
                                <span class="text-uppercase">{{ $oPromocode->promocode }}</span>
                            </div>
                            <div class="row">
                                @foreach($oPromocode->journals as $oJournal)
                                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                                        @include('components.journal', [
                                            'oItem' => $oJournal,
                                            'innerspan' => false,
                                            'promocode_id' => $oPromocode->id,
                                        ])
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            </form>
        </div>
    </div>
@endsection
