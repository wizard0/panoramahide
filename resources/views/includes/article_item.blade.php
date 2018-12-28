<div class="article-item entity-item d-flex _article" data-id="{{ $s->articleID }}">
    <div class="checkbox-col">
        <input id="article-index-{{ $s->articleID }}" type="checkbox" name="article-choise" value="{{ $s->articleID }}" data-type="article">
        <label for="article-index-{{ $s->articleID }}"></label>
    </div>
    <div class="article-info-col d-flex flex-wrap">
        <div class="out-author w-100">
            <a href="/search/?author={{ $s->authorName }}&amp;type=article&amp;extend=1" class="grey-link">{{ $s->authorName }}</a>							</div>
        <div class="d-flex article-texts-holder justify-content-between">
            <div class="article-item-announce">
                <h3><a href="/articles/{{ $s->articleCode }}.html" class="black-link itemName">{{ $s->articleName }}</a></h3>
                @if (property_exists($s, 'found') && $s->found != null)
                    <div class="col-12"><p>...{{ $s->found }}...</p></div>
                    <div class="coincidence-counter">И еще {{ $s->length }} совпадений <a href="/articles/{{ $s->articleCode }}.html" class="red-link">в статье</a></div>
                @endif
                <div class="output">
                    <span>Журнал:</span>
                    <a href="{{ route('release', ['journalCode' => $s->journalCode, 'releaseCode' => $s->releaseCode]) }}" class="grey-link">
                        {{ $s->releaseName }}						</a>
                </div>
            </div>
        </div>
        <div class="article-footer w-100">
            <div class="to-fav-this"><a href="#" class="_add_to_favorite" data-id="{{ $s->articleID }}"></a></div>
            <div class="share-this"><a href="#" class="_share" title="Поделиться"></a></div>
            {{--Here there must be yandex sharing buttons--}}
            <div class="get-access-link">
                <a href="{{ route('article', ['code' => $articleCode]) }}" class="black-link _access_article" data-id="{{ $s->articleID }}">Получить доступ</a>
            </div>
        </div>
    </div>
</div>
