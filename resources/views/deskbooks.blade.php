@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="promocodes __deskbooks">
            <div class="inform-holder">
                <div class="inform-cell high-cell">
                    <div class="inform">Вы можете выбрать <span class="checks-number">{{ $oGroups->sum('max') - $oGroups->sum('selected') }}</span> любых справочников и
                        получить доступ к ним в личном кабинете.
                    </div>
                </div>
            </div>
            <form action="{{ route('deskbooks.save') }}" class="ajax-form --journal-checkboxes" data-max="5">
                <div class="text-center">
                    <button type="submit" class="btn deskbook-button hidden inner-form-submit">Получить доступ</button>
                </div>
                @foreach($oGroups as $oGroup)
                    @if(count($oGroup->journals) !== 0)
                        <div class="section --journal-section-checkboxes" data-max="{{ $oGroup->promocode->release_limit }}">
                            <div class="deskbook-section-title">
                                <span class="text-uppercase">{{ $oGroup->name }}</span>
                                <div class="info-count">
                                    <span class="selected">{{ $oGroup->selected }}</span>/<span class="max">{{ $oGroup->max }}</span>
                                </div>
                            </div>
                            <div class="row">
                                @foreach($oGroup->journals as $oJournal)
                                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                                        @include('components.journal', [
                                            'oItem' => $oJournal,
                                            'promocode_id' => $oGroup->promocode_id,
                                            'checked' => $oJournal->checked
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
