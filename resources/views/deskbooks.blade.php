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
                    <button type="submit" class="btn deskbook-button hidden">Получить доступ</button>
                </div>
                <div class="section">
                    <div class="deskbook-section-title">
                        <span class="text-uppercase">Медицина</span>
                    </div>
                    <div class="row">
                        @for($i = 0; $i < 6; $i++)
                            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                                @include('components.journal', [
                                    'oItem' => collect(['id' => $i])
                                ])
                            </div>
                        @endfor
                    </div>
                </div>
                <div class="section">
                    <div class="deskbook-section-title">
                        <span class="text-uppercase">Промышленность и строительство</span>
                    </div>
                    <div class="row">
                        @for($i = 0; $i < 6; $i++)
                            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                                @include('components.journal', [
                                    'oItem' => collect(['id' => $i]),
                                    'img' => 'cover01.jpg'
                                ])
                            </div>
                        @endfor
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
