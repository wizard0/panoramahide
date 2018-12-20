<div class="cover form-collapsed" style="background-image: url(/img/cover-bg.jpg);">
<div class="container h-100">
<div class="d-flex flex-column h-100 justify-content-center">
<div class="search-form extended-search">
<form method="POST" action="{{ route('search') }}">
    @csrf
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
                @foreach (Category::with('journals')->get() as $category)
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
                    <select name="journal">
                        <option value="">Любой журнал</option>
                        @foreach (Journal::all() as $journal)
                            <option value="{{ $journal->id }}">{{ $journal->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-xl-3 col-lg-3 col-12 form-margin">
                    <label class="col-12">Выбрать автора</label>
                    <div class="row no-gutters">
                        <div class="col-3">
                            <select class="searcharea rightsharp bothsharp" name="author_char">
                                <option value="">-</option>
                                @foreach(Author::getAlphabet() as $char)
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
