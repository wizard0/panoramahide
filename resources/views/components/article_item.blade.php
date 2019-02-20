<div class="article-item entity-item d-flex _article" data-id="{{ $id }}">
    <div class="checkbox-col">
        <input id="article-index-{{ $id }}" type="checkbox" name="article-choise" value="{{ $id }}" data-type="article">
        <label for="article-index-{{ $id }}"></label>
    </div>
    <div class="article-info-col d-flex flex-wrap">
        <div class="out-author w-100">
            <a href="/search/?author={{ $author }}&amp;type=article&amp;extend=1" class="grey-link">{{ $author }}</a>							</div>
        <div class="d-flex article-texts-holder justify-content-between">
            <div class="article-item-announce">
                <h3><a href="/articles/{{ $code }}.html" class="black-link itemName">{{ $name }}</a></h3>
                @if ($found)
                    <div class="col-12"><p>...{{ $found }}...</p></div>
                    <div class="coincidence-counter">И еще {{ $length }} совпадений
                        <a href="{{ route('article', compact('code')) }}" class="red-link">в статье</a></div>
                @endif
                <div class="output">
                    <span>Журнал:</span>
                    <a href="{{ route('release', ['journalCode' => $journalCode, 'releaseID' => $releaseID]) }}" class="grey-link">
                        {{ $journalName }} . №{{ $number }}						</a>
                </div>
            </div>
        </div>
        <div class="article-footer w-100">
            <div class="to-fav-this"><a href="#" class="_add_to_favorite" data-id="{{ $id }}"></a></div>
            <div class="share-this"><a href="#" class="_share" title="Поделиться"></a></div>
            {{--Here there must be yandex sharing buttons--}}
            <div class="get-access-link">
                <a href="{{ route('article', ['code' => $code]) }}" class="black-link _access_article" data-id="{{ $id }}">Получить доступ</a>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('._access_article[data-id="{{ $id }}"]').on('click', function (e) {
            e.preventDefault();

            CartManager.addToCart('electronic', 'article', {{ $id }});
            return false;
        });
    });
</script>
