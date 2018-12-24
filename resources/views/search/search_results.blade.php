<div class="show-results"><div class="container">
        <div class="row">
            @if ($search)
            <div class="col-xl-9 col-lg-9 col-12 order-1 order-xl-1 order-lg-1">

                <div class="head-of-show-results">
                    <div class="results-count">
                        <span>Найдено <span>{{ $rowCount }}</span> результата</span>
                    </div>

                    <div class="row justify-content-between">
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-12">
                            <select name="sort">
                                <option value="ACTIVE_FROM-DESC" selected="selected">По дате (сначала новые)</option>
                                <option value="NAME-ASC">По алфавиту</option>
                            </select>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-6">
                            <div class="view-type">
                                <div class="row no-gutters justify-content-end">
                                    <input id="row-view" type="radio" name="view-type" checked="checked">
                                    <label class="rightsharp" for="row-view" value="row-view"></label>
                                    <input id="grid-view" type="radio" name="view-type">
                                    <label class="leftsharp" for="grid-view" value="grid-view"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row col-xl-9 col-lg-9 col-12 order-3 order-xl-2 order-lg-2">
                @foreach($search as $s)
                <div class="article-item entity-item d-flex _article" data-id="{{ $s->articleID }}">
                    <div class="checkbox-col">
                        <input id="article-index-{{ $s->articleID }}" type="checkbox" name="article-choise" value="{{ $s->articleID }}">
                        <label for="article-index-{{ $s->articleID }}"></label>
                    </div>
                    <div class="article-info-col d-flex flex-wrap">
                        <div class="out-author w-100">
                            <a href="/search/?author={{ $s->authorName }}&amp;type=article&amp;extend=1" class="grey-link">{{ $s->authorName }}</a>							</div>
                        <div class="d-flex article-texts-holder justify-content-between">
                            <div class="article-item-announce">
                                <h3><a href="/articles/{{ $s->articleCode }}.html" class="black-link">{{ $s->articleName }}</a></h3>
                                @if ($s->found)
                                    <div class="col-12"><p>...{{ $s->found }}...</p></div>
                                    <div class="coincidence-counter">И еще {{ $s->length }} совпадений <a href="/articles/{{ $s->articleCode }}.html" class="red-link">в статье</a></div>
                                @endif
                                <div class="output">
                                    <span>Журнал:</span>
                                    <a href="/magazines/{{ $s->journalCode }}/numbers/{{ $s->releaseCode }}.html" class="grey-link">
                                        {{ $s->releaseName }}						</a>
                                </div>
                            </div>
                        </div>
                        <div class="article-footer w-100">
                            <div class="to-fav-this"><a href="#" class="_add_to_favorite" data-id="{{ $s->articleID }}"></a></div>
                            <div class="share-this"><a href="#" class="_share" title="Поделиться"></a></div>
                            {{--Here there must be yandex sharing buttons--}}
                            <div class="get-access-link">
                                <a href="#" class="black-link _access_article" data-id="{{ $s->articleID }}">Получить доступ</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

                <div class="w-100 pagination d-flex justify-content-center">
                    {{ $search->links() }}
                </div>
            </div>

            @include('includes.sidebar')

            @endif
        </div>
    </div>

    <script>
        window.q = '<mark>душ</mark>';
    </script></div>
