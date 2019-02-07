<div class="container">
    <div class="row justify-content-around">
        <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">

            @include('magazines.detail.breadcrumbs', compact('journal'))

        </div>
        <div class="col-xl-2 col-lg-2 col-2"></div>
        <div class="col-xl-8 col-lg-8 col-12 order-3 order-xl-2 order-lg-2">
            <h3 class="text-uppercase" style="margin-bottom: 14px;">{{ __('Информация для читателей и авторов') }}</h3>
            <div class="row">
                <div class="col-12">
                    <div id="accordion">
                        @if (!empty($journal->article_submiission_rules))
                        <div class="card">
                            <div class="card-header">
                                <a class="card-link collapsed" data-toggle="collapse" data-parent="#accordion" href="#pan1">{{ __('ПРАВИЛА ПРЕДОСТАВЛЕНИЯ СТАТЕЙ') }}</a>
                            </div>
                            <div id="pan1" class="collapse">
                                <div class="card-body">
                                    <div class="accordeon-text"><b>{{ __('Правила предоставления статей для публикации в журнале') }} «{{ $journal->name }}»</b>
                                        {{ $journal->article_submission_rules }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if (!empty($journal->contacts))
                        <div class="card">
                            <div class="card-header">
                                <a class="card-link collapsed" data-toggle="collapse" data-parent="#accordion" href="#pan2">{{ __('Контакты') }}</a>
                            </div>
                            <div id="pan2" class="collapse">
                                <div class="card-body">
                                    <div class="accordeon-text">
                                        {{ $journal->contacts }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-lg-2 col-12 order-2 order-xl-3 order-lg-3">
            @include('includes.sidebar', ['hide' => ['title']])
        </div>

        @include('includes.sidebar_modals')

    </div>
</div>
