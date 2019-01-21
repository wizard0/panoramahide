<div class="container">
        <div class="row justify-content-around">
            <div class="col-xl-8 col-lg-8 col-12 order-3 order-xl-2 order-lg-2">
                <div class="issue-main">
                    <div class="row">
                        <div class="col-12">

                            @include('magazines.detail.breadcrumbs', compact('journal'))

                        </div>
                        <div class="col-xl-4 col-lg-4 col-12">
                            <div class="issue-cover">
                                <img src="{{ $journal->image }}">
                            </div>
                        </div>
                        <div class="col-xl-8 col-lg-8 col-12">
                            <h3>Журнал "{{ $journal->name }} /
                                {{ $journal->translate('en', true)->name }}"</h3>
                            <div class="issue-announce">
                                <p></p>
                            </div>
                            @if (!empty($journal->ISSN))
                                <div class="out-issn"><span>ISSN:</span>{{ $journal->ISSN }}</div>
                            @endif
                            @if (!empty($journal->in_HAC_list))
                                <div class="vak">
								<span>
									<a href="#">Входит в перечень ВАК</a>
									<div class="vak-tooltip" style="display: none;">
                                        {!! $journal->in_HAC_list !!}
                                    </div>
								</span>
                                </div>
                                <script>
                                    $(".vak-tooltip").bind("clickoutside", function(event) {
                                        $(this).hide();
                                    });
                                </script>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-2 col-lg-2 col-12 order-2 order-xl-3 order-lg-3">
                @include('includes.sidebar', ['hide' => ['title']])
            </div>

        </div>
    </div>

    {{--<script>--}}
        {{--$('._access').on('click', function(){--}}
            {{--goTo('subscribe');--}}
            {{--return false;--}}
        {{--});--}}
    {{--</script>--}}
