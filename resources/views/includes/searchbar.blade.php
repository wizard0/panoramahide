@php
    $isJournalPage = isset($isJournalPage) && $isJournalPage == true;
    if (!$isJournalPage) {
        $categories = Category::with('journals')->withTranslation()->get();
        $journals = Journal::withTranslation()->get();
        $barBackground = 'url(/img/cover-bg.jpg)';
    } else {
        $barBackground = 'url(/img/cover03.png)';
    }

@endphp

<div class="cover" style="background-image: {{ $barBackground }};">
    @if ($isJournalPage)
        <div class="cover-back">
    @endif
<div class="container h-100">
<div class="d-flex flex-column h-100 justify-content-center">
<div class="search-form extended-search">
<form method="GET" action="{{ route('search') }}" id="searchBar">
    @if ($isJournalPage)
        <input type="hidden" name="journal" value="{{ $journal->id }}">
        <input type="hidden" name="type" value="article">

        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="search-intro">
                    <span>{{ $journal->name }} /
                        {{ $journal->translate('en', true)->name }}</span>
                    <p>Поиск среди статей журнала</p>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="search-intro">
                    <span>Поиск среди статей и изданий в информационной системе «панорама»</span>
                </div>
            </div>
        </div>
    @endif

    <div class="row justify-content-between align-items-end all-form-row">
        @if (!$isJournalPage)
            <div class="col-xl-3 col-lg-3 col-12 section-choice form-margin">
                <label class="col-12">Тематика</label>
                <select name="category">
                    <option value="">Любая тематика</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @php
                        if (isset($params)) {
                            if (isset($params['category']) && $params['category'] == $category->id)
                                echo 'selected';
                        }
                        @endphp >{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
        @endif
        <div class="col-xl-9 col-lg-9 col-md col-12 phrase-search form-margin">
            <label class="col-12">Поиск по фразе</label>
            <div class="row no-gutters">
                <div class="col-xl-9 col-9">
                    <input class="rightsharp" type="text" placeholder="Например, кормление сельскохозяйственных животных" name="q" value="{{
                    (isset($params) && isset($params['q']))
                        ? $params['q']
                        : ""
                     }}">
                </div>
                <div class="col-xl-3 col-3">
                    <select class="searcharea leftsharp bothsharp" name="search_in">
                        <option value="name"  {{
                        (isset($params) && isset($params['search_in']) && $params['search_in'] == 'name')
                            ? 'selected'
                            : (!isset($params) || !isset($params['search_in']))
                                ? 'selected'
                                : ""
                        }}  >по заголовкам</option>
                        <option value="text" {{
                        (isset($params) && isset($params['search_in']) && $params['search_in'] == 'text')
                            ? 'selected'
                            : ""
                        }} >по текстам</option>
                        <option value="all" {{
                        (isset($params) && isset($params['search_in']) && $params['search_in'] == 'all')
                            ? 'selected'
                            : ""
                        }} >везде</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-12 form-line-to-collapse">
            <div class="row">
                @if (!$isJournalPage)
                    <div class="col-xl-3 col-lg-3 col-12 form-margin">
                        <label class="col-12">Выбрать журнал</label>
                        <select name="journal">
                            <option value="">Любой журнал</option>
                            @foreach ($journals as $journal)
                                <option value="{{ $journal->id }}" {{
                                (isset($params) && isset($params['journal']) && $params['journal'] == $journal->id)
                                    ? 'selected'
                                    : ""
                                 }}>{{ $journal->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <div class="col-xl-3 col-lg-3 col-12 form-margin">
                    <label class="col-12">Выбрать автора</label>
                    <div class="row no-gutters">
                        <div class="col-3">
                            <select class="searcharea rightsharp" name="author_char">
                                <option value="">-</option>
                                @foreach(Author::getAlphabet() as $char)
                                    <option value="{{ $char }}" {{
                                    (isset($params) && isset($params['author_char']) && $params['author_char'] == $char)
                                        ? 'selected'
                                        : ""
                                     }} >{{ $char }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-9">
                            <input class="leftsharp" type="text" placeholder="" name="author" value="">
                        </div>
                    </div>
                </div>
                <div class="col-xl col-lg col-sm-6 col-12 form-margin">
                    <label class="col-12">Дата публикации</label>
                    <div class="row no-gutters">
                        <input class="col date rightsharp" id="datetimepicker6" type="text" placeholder="" name="active_from" value="{{
                        (isset($params) && isset($params['active_from']))
                            ? $params['active_from']
                            : ""
                         }}">
                        <input class="col date leftsharp" id="datetimepicker7" type="text" placeholder="" name="active_to" value="{{
                        (isset($params) && isset($params['active_to']))
                            ? $params['active_to']
                            : ""
                         }}">
                    </div>
                </div>
                <div class="col-xl col-lg col-sm-6 col-12 form-margin">
                    <label class="col-12">УДК</label>
                    <input type="text" placeholder="" name="udk" value="{{
                        (isset($params) && isset($params['udk']))
                            ? $params['udk']
                            : ""
                         }}">
                </div>
            </div>
        </div>

        @if (!$isJournalPage)
            <div class="d-flex col-xl-auto col-lg-auto col-md-auto col-sm-auto col-12 form-margin align-items-end mag-art-filter">
                <div class="row no-gutters">
                    <div class="col-xl-auto col-lg-auto col-auto">
                        <input id="mag" type="radio" name="type" value="{{ UserSearch::TYPE_JOURNAL }}" {{
                        (isset($params) && isset($params['type']) && $params['type'] == UserSearch::TYPE_JOURNAL)
                            ? 'checked'
                            : ''
                         }}  >
                        <label for="mag" class="rightsharp"><span>Журналы</span></label>
                    </div>
                    <div class="col-xl-auto col-lg-auto col-auto">
                        <input id="art" type="radio" name="type" value="{{ UserSearch::TYPE_ARTICLE }}" {{
                        (isset($params) && isset($params['type']) && $params['type'] == UserSearch::TYPE_ARTICLE)
                            ? 'checked'
                            : (!isset($params) || !isset($params['type']))
                                ? 'checked'
                                : ''
                         }} >
                        <label for="art" class="leftsharp"><span>Статьи</span></label>
                    </div>
                </div>
            </div>
        @endif
        <div class="d-flex flex-wrap col-xl col-lg col-md col-sm col-12 form-margin align-items-end mag-art-filter">
            <input id="opened" type="checkbox" name="access" value="1" {{
            (isset($params) && isset($params['access']) && $params['access'] == "1")
                ? 'checked'
                : ''
             }} >
            <label for="opened" class="mr-2"><span>Только доступные для чтения</span></label>

            @if (Auth::check())
                <input id="favs" type="checkbox" name="favorite" value="1" {{
                (isset($params) && isset($params['favorite']) && $params['favorite'] == "1")
                    ? 'checked'
                    : ''
                 }} >
                <label for="favs"><span>Только в избранном</span></label>
            @endif
        </div>

        <div class="d-flex col-xl-2 col-lg-3 col-md-3 col-6 offset-xl-0 offset-lg-0 offset-md-0 offset-3 form-margin align-items-end justify-content-xl-end justify-content-lg-end justify-content-center">
            <button class="leftsharp" type="submit"><span>искать</span></button>
        </div>
    </div>

    <div class="form-functions d-flex">
        <div class="row justify-content-center justify-content-lg-start justify-content-md-start order-1 order-md-1 order-xl-1">
            <div class="save-search delete-search _delete_search _saved_search_delete"  style="display: none;"  >
                <input type="hidden" name="searchID" value="">
                <a href="#" data-toggle="modal" data-target="#searchesModal">Удалить поиск</a>
            </div>
            <div class="save-search _save_search"  style="display: none;"  >
                @php
                    $dataTarget = "#searchesModal";
                    if (!Auth::check()) $dataTarget = "#login-modal";
                @endphp
                <a id="saveSearch" href="#" data-toggle="modal" data-target="{{ $dataTarget }}">Сохранить поиск</a>
            </div>
            <div class="clear-search">
                <a href="" class="_reset">Сбросить поиск</a>
            </div>
        </div>

        <div class="order-3 order-md-2 order-xl-2">
            <div class="row justify-content-center">
                <div class="col-auto collapse-search">
                    <a class="text-uppercase" href="#">расширенный поиск</a>
                </div>
            </div>
        </div>

        <div class="order-2 order-md-3 order-xl-3">
            <div class="row justify-content-xl-end justify-content-lg-end justify-content-md-end justify-content-center">
                <div class="my-searches">
                    <a href="#" class="_saved_search_open" data-toggle="modal" data-target="#searchesModal">Мои поиски</a>
                    <div class="mysearches mysearches-wide" style="display: none;">
                        <div class="triaria"><img src="/local/templates/panor2016/img/tri.svg"></div>
                        <div class="searchesinn">
                            <div class="modal-content">
                                <div class="d-flex searches-title">
                                    <button class="_saved_search_delete" data-id="all" title="Удалить все"><span></span></button>
                                    <span>Сохраненные поиски</span>
                                </div>
                                <div class="_saved_search_container">
                                    @include('includes.searchbar_result')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
</div>
</div>
</div>
</div>
@if ($isJournalPage)
    </div>
@endif


{{--@section('searchbar-js')--}}
    <script>
        var searchResultLoading = false;
        var time_animation = 500;

        // расширенный поиск
        function isExtend()
        {
            return !Panorama.search.settings.form.parents('.cover').eq(0).hasClass('form-collapsed');
        }

        // переключить режим формы поиска
        function toggleExtend()
        {
            $('.cover').toggleClass("form-collapsed");
            $('.collapse-search a').toggleClass("collapsed-search");
            $('.phrase-search').toggleClass("col-xl-10");
            $('.all-form-row').toggleClass("no-gutters");
            $('.searcharea').toggleClass("bothsharp");
            $('.cover button').toggleClass("leftsharp");
        }

        $(function() {
            Panorama.search.settings.form = $('.search-form form');
            Panorama.search.isExtendHandler = isExtend;
            Panorama.search.toggleExtendHandler = toggleExtend;

            Panorama.search.settings.form.on('change input', 'input, select', function(){
                Panorama.search.showSearchSave();
            });

            // Change 'form' to class or ID of your specific form
            Panorama.search.settings.form.submit(function() {
                $(this).find(":input").filter(function(){ return !this.value; }).attr("disabled", "disabled");
                return true; // ensure form still submits
            });

            // Un-disable form fields when page loads, in case they click back after submission
            Panorama.search.settings.form.find( ":input" ).prop( "disabled", false );

            // переключить режим поиска
            $('.collapse-search a').on('click', function(e) {
                Panorama.search.toggleExtend();
                return false;
            });

            // сбросить поиск
            Panorama.search.settings.form.on('click', '._reset', function(){
                Panorama.search.resetForm();
                return false;
            });

            // сохранить поиск
            Panorama.search.settings.form.on('click', Panorama.search.settings.saveSearch, function(event){
                if ($(event.target).data('target') == '#searchesModal')
                    Panorama.search.saveSearch();
//                return false;
            });

            // применить сохраенный поиск
            $(Panorama.search.settings.savedSearchApply).on('click', function(event){
                event.preventDefault();
                Panorama.search.applySavedSearch($(this).data('id'));
                return false;
            });

            // удалить сохраненный поиск
            Panorama.search.settings.form.on('click', Panorama.search.settings.savedSearchDelete, function(){
                if (confirm('Вы уверены что хотите удалить этот сохраненный поиск?')) {
                    Panorama.search.deleteSavedSearch($(this).data('id'));
                }
                return false;
            });

            /*--Мои поиски--*/
            var win = $(this);
            if (win.width() < 426) {
                /*--На мобильных выводим в виде модального окна--*/
                $('.mysearches').addClass('modal fade');
                $('.mysearches').removeClass('mysearches-wide');
                $('.searchesinn').addClass('modal-dialog modal-dialog-centered');
                $('.mysearches').attr('id','searchesModal');
                $('.mysearches').on('show.bs.modal', function() {
                    $('.mysearches').toggle();
//                    Panorama.search.loadSavedSearch();
                });
            } else {
                /*--На больших экранах выводим в виде выпадающего меню--*/
                $('.mysearches').removeClass('modal fade');
                $('.mysearches').addClass('mysearches-wide');
                $('.mysearches').removeAttr('id','searchesModal');
                $('.searchesinn').removeClass('modal-dialog modal-dialog-centered');
                /*--Появление выпадающего блока по клику на ссылке--*/
                $('.my-searches a').on('click', function(e) {
                    e.stopPropagation();
//                    Panorama.search.loadSavedSearch();
                    $('.mysearches').toggle();
                    e.preventDefault();
                });

                /*--Скрываем выпадающее окно при клике снаружи--*/
                $(".mysearches").bind( "clickoutside", function(event){
                    $(this).hide();
                });
            }
        });
        $(function(){
            Panorama.search.toggleExtend();
        });
    </script>
{{--@endsection--}}
