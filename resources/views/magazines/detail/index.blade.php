@extends('layouts.app')

@section('content')
    <div class="container"></div>
    <div class="cover dark form-collapsed" style="background-image: url(/local/templates/panor2016/img/cover03.png);">
        <div class="cover-back">
            <div class="container h-100">
                <div class="d-flex flex-column h-100 justify-content-center">
                    <div class="search-form extended-search">
                        <form method="GET" action="/search/">
                            <input type="hidden" name="magazine" value="3802">
                            <input type="hidden" name="type" value="article">

                            <div class="row">
                                <div class="col-lg-12 text-center">
                                    <div class="search-intro">
                                        <span>Главный механик / Chief mechanical engineer</span>
                                        <p>Поиск среди статей журнала</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-between align-items-end all-form-row no-gutters">
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
                                <div class="col-xl-3 col-lg-3 col-12 form-margin form-line-to-collapse">
                                    <label class="col-12">Выбрать автора</label>
                                    <div class="row no-gutters">
                                        <div class="col-3">
                                            <select class="searcharea rightsharp bothsharp" name="author_word">
                                                <option value="">-</option>
                                                <option value="А"  >А</option>
                                                <option value="Б"  >Б</option>
                                                <option value="В"  >В</option>
                                                <option value="Г"  >Г</option>
                                                <option value="Д"  >Д</option>
                                                <option value="Е"  >Е</option>
                                                <option value="Ж"  >Ж</option>
                                                <option value="З"  >З</option>
                                                <option value="И"  >И</option>
                                                <option value="К"  >К</option>
                                                <option value="Л"  >Л</option>
                                                <option value="М"  >М</option>
                                                <option value="Н"  >Н</option>
                                                <option value="О"  >О</option>
                                                <option value="П"  >П</option>
                                                <option value="Р"  >Р</option>
                                                <option value="С"  >С</option>
                                                <option value="Т"  >Т</option>
                                                <option value="У"  >У</option>
                                                <option value="Ф"  >Ф</option>
                                                <option value="Х"  >Х</option>
                                                <option value="Ц"  >Ц</option>
                                                <option value="Ч"  >Ч</option>
                                                <option value="Ш"  >Ш</option>
                                                <option value="Щ"  >Щ</option>
                                                <option value="Э"  >Э</option>
                                                <option value="Ю"  >Ю</option>
                                                <option value="Я"  >Я</option>
                                            </select>
                                        </div>
                                        <div class="col-9">
                                            <input class="leftsharp" type="text" placeholder="" name="author" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl col-lg col-sm-6 col-12 form-margin form-line-to-collapse">
                                    <label class="col-12">Дата публикации</label>
                                    <div class="row no-gutters">
                                        <input class="col date rightsharp" id="datetimepicker6" type="text" placeholder="" name="active_from" value="">
                                        <input class="col date leftsharp" id="datetimepicker7" type="text" placeholder="" name="active_to" value="">
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-2 col-sm-6 col-12 form-margin form-line-to-collapse">
                                    <label class="col-12">УДК</label>
                                    <input type="text" placeholder="" name="udk" value="">
                                </div>
                                <div class="d-flex flex-wrap col-xl col-lg col-md col-sm col-12 form-margin align-items-end mag-art-filter">
                                    <input id="opened" type="checkbox" name="access" value="1"  >
                                    <label for="opened" class="mr-2"><span>Только доступные для чтения</span></label>

                                </div>

                                <div class="cover-button-holder d-flex col-xl-2 col-lg-3 offset-lg-9 col-md-3 col-6 offset-xl-0 offset-lg-0 offset-md-0 offset-3 form-margin align-items-end justify-content-xl-end justify-content-lg-end justify-content-center">
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
                                                            <button class="leftsharp _saved_search_delete" data-id="all" title="Удалить все">
                                                                <span></span>
                                                            </button>
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
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

    </div>
    <div class="inner-menu">
        <div class="container">
            <div class="toggle-block">
                <a href="#" class="adapt-link collapsed grey-link" data-toggle="collapse" data-target="#toggleMenu01"><span>Меню журнала</span></a>
            </div>
            <div id="toggleMenu01" class="toggleMenu collapse">
                <ul>
                    <li class="inner-menu-active"><a href="#magazine" data-type="magazine">Журнал</a></li>
                    <li><a href="#numbers" data-type="numbers">Все номера</a></li>
                    <li><a href="#fresh_number" data-type="fresh_number">Свежий номер</a></li>
                    <li><a href="#articles" data-type="articles">Все статьи</a></li>
                    <li><a href="#subscribe" data-type="subscribe">Подписка</a></li>
                    <li><a href="#send_article" data-type="send_article">Прислать статью</a></li>
                    <li><a href="#info" data-type="info">Информация</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="show-results" data-id="3802"></div>

    <div class="container">
        @include('includes.new_journals')
    </div>
@endsection
