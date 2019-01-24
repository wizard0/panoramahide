@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="promocodes __deskbooks">
            <div class="inform-holder">
                <div class="inform-cell high-cell">
                    <div class="inform">Вы можете выбрать <span class="checks-number">5</span> любых справочников и
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
                        <div class="section">
                            <div class="deskbook-section-title">
                                <span class="text-uppercase">{{ $oGroup->name }}</span>
                            </div>
                            <div class="row">
                                @foreach($oGroup->journals as $oJournal)
                                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                                        @include('components.journal', [
                                            'oItem' => $oJournal
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
