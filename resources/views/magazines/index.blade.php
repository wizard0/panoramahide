@extends('layouts.app')

@section('content')
<div class="container"></div>

<div class="cover form-collapsed" style="background-image: url(/img/cover-bg.jpg);">
    <div class="container h-100">
        <div class="d-flex flex-column h-100 justify-content-center">
            <div class="search-form extended-search">
                <form method="POST" action="/search/">
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <div class="search-intro">
                                <span>Поиск среди статей и изданий в информационной системе «панорама»</span>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-between align-items-end all-form-row no-gutters">
                        <div class="col-xl-3 col-lg-3 col-12 section-choice form-margin">
                            <label class="col-12">Тематика</label>
                            <select name="category">
                                <option value="">Любая тематика</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xl-9 col-lg-9 col-md col-12 phrase-search form-margin col-xl-10">
                            <label class="col-12">Поиск по фразе</label>
                            <div class="row no-gutters">
                                <div class="col-xl-9 col-9">
                                    <input class="rightsharp" type="text" placeholder="Например, кормление сельскохозяйственных животных" name="q" value="">
                                </div>
                                <div class="col-xl-3 col-3">
                                    <select class="searcharea leftsharp bothsharp" name="search_in">
                                        <option value="name"  selected="selected"  >по заголовкам</option>
                                        <option value="text"  >по текстам</option>
                                        <option value="all"  >везде</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 form-line-to-collapse">
                            <div class="row">
                                <div class="col-xl-3 col-lg-3 col-12 form-margin">
                                    <label class="col-12">Выбрать журнал</label>
                                    <select name="magazine">
                                        <option value="">Любой журнал</option>
                                        @foreach ($journals as $journal)
                                            <option value="{{ $journal->id }}">{{ $journal->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-12 form-margin">
                                    <label class="col-12">Выбрать автора</label>
                                    <div class="row no-gutters">
                                        <div class="col-3">
                                            <select class="searcharea rightsharp bothsharp" name="author_word">
                                                <option value="">-</option>
                                                @foreach($authorAlphabet as $char)
                                                    <option value="{{ $char }}" >{{ $char }}</option>
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
                                        <input class="col date rightsharp" id="datetimepicker6" type="text" placeholder="" name="active_from" value="">
                                        <input class="col date leftsharp" id="datetimepicker7" type="text" placeholder="" name="active_to" value="">
                                    </div>
                                </div>
                                <div class="col-xl col-lg col-sm-6 col-12 form-margin">
                                    <label class="col-12">УДК</label>
                                    <input type="text" placeholder="" name="udk" value="">
                                </div>
                            </div>
                        </div>

                        <div class="d-flex col-xl-auto col-lg-auto col-md-auto col-sm-auto col-12 form-margin align-items-end mag-art-filter">
                            <div class="row no-gutters">
                                <div class="col-xl-auto col-lg-auto col-auto">
                                    <input id="mag" type="radio" name="type" value="magazine"  >
                                    <label for="mag" class="rightsharp"><span>Журналы</span></label>
                                </div>
                                <div class="col-xl-auto col-lg-auto col-auto">
                                    <input id="art" type="radio" name="type" value="article"  >
                                    <label for="art" class="leftsharp"><span>Статьи</span></label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap col-xl col-lg col-md col-sm col-12 form-margin align-items-end mag-art-filter">
                            <input id="opened" type="checkbox" name="access" value="1"  >
                            <label for="opened" class="mr-2"><span>Только доступные для чтения</span></label>

                            <input id="favs" type="checkbox" name="favorite" value="1"  >
                            <label for="favs"><span>Только в избранном</span></label>
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
                                <a href="#" data-toggle="modal" data-target="#searchesModal">Сохранить поиск</a>
                            </div>
                            <div class="clear-search">
                                <a href="" class="_reset">Сбросить поиск</a>
                            </div>
                        </div>

                        <div class="order-3 order-md-2 order-xl-2">
                            <div class="row justify-content-center">
                                <div class="col-auto collapse-search">
                                    <a class="text-uppercase collapsed-search" href="#">расширенный поиск</a>
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
                                                    <button class="leftsharp _saved_search_delete" data-id="all" title="Удалить все"><span></span></button>
                                                    <span>Сохраненные поиски</span>
                                                </div>
                                                <div class="_saved_search_container"></div>
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

<div class="show-results">
    <div class="container">
        <div class="row">
            <div class="col-xl-9 col-lg-9 col-12 order-1 order-xl-1 order-lg-1">
                <div class="head-of-show-results">
                    <div class="results-count">
                        <span>Найдено <span>{{ Journal::count() }}</span> журнала</span>
                    </div>

                    <div class="row justify-content-between">
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-12">
                            <select name="sort">
                                <option value="DATE_CREATE-DESC"
                                        @if (isset($_GET['sort_by']) && $_GET['sort_by'] == 'created_at')
                                            selected="selected"
                                        @endif
                                >По дате (сначала новые)</option>
                                <option value="NAME-ASC"
                                        @if (!isset($_GET['sort_by']) || $_GET['sort_by'] == 'name')
                                            selected="selected"
                                        @endif
                                >По алфавиту</option>
                            </select>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-6">
                            <div class="view-type">
                                <div class="row no-gutters justify-content-end">
                                    <input id="row-view" type="radio" name="view-type" checked="checked"/><label class="rightsharp" for="row-view" value="row-view"></label>
                                    <input id="grid-view" type="radio" name="view-type"/>
                                    <label class="leftsharp" for="grid-view" value="grid-view"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row col-xl-9 col-lg-9 col-12 order-3 order-xl-2 order-lg-2">
                @foreach ($journals as $journal)
                <div class="magazine-item entity-item d-flex col-12 _magazine"
                     data-id="{{ $journal->id }}"
                     data-link="/magazines/##.html"
                     data-link-subscribe="/magazines/##.html#subscribe">
                    <div class="checkbox-col">
                        <input id="magazine-index-{{ $journal->id }}" type="checkbox" name="article-choise" value="{{ $journal->id }}" />
                        <label for="magazine-index-{{ $journal->id }}"></label>
                    </div>
                    <div class="article-info-col">
                        <div class="row">
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-2 col-12">
                                <div class="issue-image">
                                    <a href="/magazines/##.html">
                                        <img src="{{ $journal->image }}">
                                    </a>
                                </div>
                            </div>
                            <div class="col-xl-9 col-lg-9 col-md-9 col-sm-10 col-12">
                                <h3><a href="/magazines/##.html" class="black-link journalName">{{ $journal->name }}</a></h3>
                                <div class="announce">
                                    <p></p>
                                </div>
                            </div>
                        </div>
                        <div class="magazine-footer row justify-content-between align-items-center no-gutters">
                            <div class="col-xl-2 col-lg-2 col-md-4 col-sm-3 col-12 out-issn">
                                <span>ISSN:</span>{{ $journal->issn }}							</div>
                            <div class="d-flex col-xl-8 col-lg-8 col-md-4 col-sm-6 col-12 goto-issue justify-content-xl-center justify-content-lg-center justify-content-md-center justify-content-sm-center justify-content-start">
                                <span>к номеру:</span>
                                <select name="number">
                                    @foreach ($journal->releases as $release)
                                        <option value="/magazines/{{  $journal->code }}/numbers/##.html">№ {{ $release->number }}, {{ $release->year }}</option>
                                    @endforeach
                                </select>
                                <a href="" class="_go_to_number_3697">перейти</a>
                            </div>
                            <div class="d-flex col-xl-2 col-lg-2 col-md-4 col-sm-3 col-12 get-access-red justify-content-xl-end justify-content-lg-end justify-content-md-end justify-content-sm-end justify-content-start">
                                <a href="/magazines/avtotransport-ekspluatatsiya-obsluzhivanie-remont.html#subscribe" class="red-link">получить доступ</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

                <div class="w-100 pagination d-flex justify-content-center">
                    {{ $journals->links() }}
                    {{--<ul>--}}
                        {{--<li><span class="d-block">1</span></li>--}}

                        {{--<li><a href="/magazines/?PROPERTY_PUBLISHER=793&amp;PAGEN_1=2" class="black-link">2</a></li>--}}

                        {{--<li><a href="/magazines/?PROPERTY_PUBLISHER=793&amp;PAGEN_1=3" class="black-link">3</a></li>--}}

                        {{--<li>...</li>--}}
                        {{--<li><a href="/magazines/?PROPERTY_PUBLISHER=793&amp;PAGEN_1=11" class="black-link">11</a></li>--}}
                    {{--</ul>--}}
                </div>

            </div>
            <div class="col-xl-2 col-lg-3 col-12 order-2 order-xl-3 order-lg-3 offset-xl-1">
                <div class="actions-menu">
                    <div class="row">
                        <div class="col-12">
                            <span class="action-menu-title">Действия с выбранными:</span>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-sm-3 col-6">
                            <a class="get-access action-item accent _access" href="#">
                                <span>получить доступ</span>
                            </a>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-sm-3 col-6">
                            <a class="to-favs action-item _add_to_favorite" href="#">
                                <span>В избранное</span>
                            </a>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-sm-3 col-6">
                            <a class="recommend action-item _recommend" href="javascript:void(0);" data-toggle="modal" data-target="#recommend">
                                <span>Рекомендовать</span>
                            </a>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-sm-3 col-6">
                            <a class="cite action-item _quote" href="javascript:void(0);" data-toggle="modal" data-target="#quote">
                                <span>Цитировать</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal" tabindex="-1" role="dialog" id="recommend">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <form method="POST" action="{{ route('recommend') }}">
                            <div class="modal-header">
                                <h4 class="modal-title">Рекомендовать</h4>
                                <a href="#" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></a>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="ids">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Ваш Email</span>
                                    </div>
                                    @php
                                        (Auth::check())
                                            ? $email = Auth::user()->email
                                            : $email = "";
                                    @endphp
                                    <input type="email" name="email_from" class="form-control"
                                           placeholder="Email" aria-label="Email" aria-describedby="basic-addon1"
                                           required="required" value="{{ $email }}">
                                </div>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon2">Email получателя</span>
                                    </div>
                                    <input type="email" name="email_to" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="basic-addon2" required="required">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="form-footer d-flex justify-content-between align-items-center">
                                    <button type="submit" class="basic-button"><span>Отправить</span></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal" tabindex="-1" role="dialog" id="quote">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Цитировать</h4>
                            <a href="#" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></a>
                        </div>
                        <div class="modal-body">
                            <p class="_text"></p>
                            <div class="form-footer d-flex justify-content-between align-items-center">
                                <div class="action-info-holder">
                                    <div class="action-info hidden">
                                        <div class="d-flex h-100 align-items-center">
                                            <p>Ссылка на источник скопирована в буфер обмена</p>
                                        </div>
                                    </div>
                                </div>
                                <button class="basic-button _copy_clipboard" data-clipboard-target="#quote ._text"><span>Копировать</span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                new ClipboardJS('#quote ._copy_clipboard');
            </script>


        </div>
    </div>
</div>

<div class="holder latest-issues">
    <h2 class="text-uppercase text-center">Новые журналы</h2>
    <div class="container">
        <div class="row">
            @foreach ($lastReleases as $release)
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="row mainpage-issue align-items-center">
                    <div class="issue-image col-12">
                        <a href="/magazines/ovoshchevodstvo-i-teplichnoe-khozyaystvo/numbers/438945.html" class="d-block">
                            <img src="{{ $release->image }}">
                        </a>
                    </div>
                    <div class="issue-number col-12">№{{ $release->number }} / {{ $release->year }}</div>
                    <div class="issue-title col-12">
                        <a href="/magazines/ovoshchevodstvo-i-teplichnoe-khozyaystvo/numbers/438945.html" class="black-link">
                            {{ $release->name }}						</a>
                    </div>
                    <div class="issue-price col-6">{{ $release->price_for_electronic }} <span>р.</span></div>
                    <div class="col-6 issue-to-cart">
                        <a  href="/magazines/ovoshchevodstvo-i-teplichnoe-khozyaystvo/numbers/438945.html"
                            class="red-link _access_number"
                            data-id="438945"
                            data-type="electron"
                        >
                            В корзину						</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="row justify-content-center">
            <div class="col-auto">
                <a href="/search/?type=magazine&extend=1" class="more d-block"><span>Все журналы</span></a>
            </div>
        </div>
    </div></div>
</div>
@endsection

@section('javascript')
<script>
    var SideBarManager = new JSSideBarManager();
</script>
@endsection
