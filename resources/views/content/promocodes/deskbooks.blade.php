@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="promocodes __deskbooks">
            <div class="inform-holder">
                <div class="inform-cell high-cell">
                    <div class="inform">Вы можете выбрать <span class="checks-number">5</span> любых справочников и получить доступ к ним в личном кабинете.</div>
                </div>
            </div>
            <example-component></example-component>
            <form action="/" class="ajax-form">
                <div class="section">
                    <div class="deskbook-section-title">
                        <span class="text-uppercase">Медицина</span>
                    </div>
                    <div class="row">
                        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                            @include('content.promocodes.journal')
                        </div>
                        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                            @include('content.promocodes.journal')
                        </div>
                        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                            @include('content.promocodes.journal')
                        </div>
                        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                            @include('content.promocodes.journal')
                        </div>
                        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                            @include('content.promocodes.journal')
                        </div>
                        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                            @include('content.promocodes.journal')
                        </div>
                    </div>
                </div>
                <div class="section">
                    <div class="deskbook-section-title">
                        <span class="text-uppercase">Промышленность и строительство</span>
                    </div>
                    <div class="row">
                        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                            @include('content.promocodes.journal', ['img' => 'cover01.jpg'])
                        </div>
                        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                            @include('content.promocodes.journal', ['img' => 'cover01.jpg'])
                        </div>
                        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                            @include('content.promocodes.journal', ['img' => 'cover01.jpg'])
                        </div>
                        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                            @include('content.promocodes.journal', ['img' => 'cover01.jpg'])
                        </div>
                        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                            @include('content.promocodes.journal', ['img' => 'cover01.jpg'])
                        </div>
                        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                            @include('content.promocodes.journal', ['img' => 'cover01.jpg'])
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
