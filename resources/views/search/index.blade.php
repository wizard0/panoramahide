@extends('layouts.app')

@section('content')
    <div class="container"></div>

    @include('includes.searchbar')

    <div class="container">
        <div class="breadcrumbs">
            <ul>
                <li><a href="/">Главная</a></li>
                <li><a href="/search/">Поиск</a></li>
            </ul>
        </div>
    </div>


    <div class="show-results">
        @include('search.search_results', compact('search'))
    </div>

@endsection

@section('javascript')
    <script>
        var searchResultLoading = false;

        // расширенный поиск
        function isExtend()
        {
            return !P.search.settings.form.parents('.cover').eq(0).hasClass('form-collapsed');
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
            if (!P.search.isExtend()) {
//                $('.collapse-search a').text(MESS.ADVANCED_SEARCH);
            } else {
//                $('.collapse-search a').text(MESS.HIDE_SEARCH);
            }
        }

        function showResult()
        {
            $('html, body').animate({scrollTop: $('.show-results').offset().top}, time_animation);
        }

        function loadResultFrom(url)
        {
            var btn = P.search.settings.form.find('[type=submit]');
            if (searchResultLoading) {
                notice(MESS.SEARCH_EXECUTED, 'error', btn, {position: 'top center'});
                return false;
            }
            notice(MESS.SEARCH_EXEC, 'success', btn, {position: 'top center'});

            searchResultLoading = true;
            load(url, '.show-results', function(res) {
                searchResultLoading = false;
                showResult();
                // подсветить ключевой запрос
                if (window.q) {
                    $('.show-results').html($('.show-results').html().replace(new RegExp('('+q+')', 'gi'), '<mark>$1</mark>'));
                }
                // выполнить js
                $(res).find('script').each(function(i, item){
                    eval($(item).text());
                });
            });
        }

        function loadResult(data)
        {
            loadResultFrom('ajax.php?'+$.param(data));
        }

        function AddToHistory(data)
        {
            var url = $.param(data);
            history.pushState(data, 'search', '?'+url);
        }

        $(function() {
            P.search.settings.form = $('.search-form form');
            P.search.isExtendHandler = isExtend;
            P.search.toggleExtendHandler = toggleExtend;

            P.search.settings.form.on('change input', 'input, select', function(){
                P.search.showSearchSave();
            });

            window.onpopstate = function(event) {
                loadResult(event.state);
            }

            // поиск
            P.search.settings.form.on('submit', function(){
                var data = P.search.getFormData();
                if (!searchResultLoading) {
                    AddToHistory(data);
                }
                loadResult(data);
                return false;
            });

            // переключить режим поиска
            $('.collapse-search a').on('click', function(e) {
                P.search.toggleExtend();
                return false;
            });

            // сбросить поиск
            P.search.settings.form.on('click', '._reset', function(){
                P.search.resetForm();
                return false;
            });

            // сохранить поиск
            P.search.settings.form.on('click', P.search.settings.saveSearch, function(event){
                if ($(event.target).data('target') == '#searchesModal')
                    P.search.saveSearch();
//                return false;
            });

            // применить сохраенный поиск
            P.search.settings.form.on('click', P.search.settings.savedSearchApply, function(event){
                event.preventDefault();
                console.log('clickesadasdsadsadd');
                P.search.applySavedSearch($(this).data('id'));
                return false;
            });

            // удалить сохраненный поиск
            P.search.settings.form.on('click', P.search.settings.savedSearchDelete, function(){
                if (confirm('Вы уверены что хотите удалить этот сохраненный поиск?')) {
                    P.search.deleteSavedSearch($(this).data('id'));
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
//                    P.search.loadSavedSearch();
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
//                    P.search.loadSavedSearch();
                    $('.mysearches').toggle();
                    e.preventDefault();
                });

                /*--Скрываем выпадающее окно при клике снаружи--*/
                $(".mysearches").bind( "clickoutside", function(event){
                    $(this).hide();
                });
            }
            /*--Мои поиски--*/

            $(document).on('change', '[name=sort]', function(){
                showResult();
                loadResultFrom('ajax.php?'+$.param(P.search.getFormData())+'&'+getSortURL($(this).val()));
            });

            $(document).on('click', '.pagination a', function(){
                showResult();
                loadResultFrom($(this).attr('href'));
                return false;
            });
        });
        $(function(){
            P.search.toggleExtend();
        });
    </script>
@endsection
