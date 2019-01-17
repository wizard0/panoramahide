<div class="container">
    <div class="row justify-content-around">
        <div class="col-xl-8 col-lg-8 col-12 order-3 order-xl-2 order-lg-2">
            <div class="head-of-show-results">

                @include('magazines.detail.breadcrumbs', compact('journal'))

                <div class="results-count">
                    <span>Найдено <span>{{ $articles->total() }}</span> статей</span>
                </div>
                <div class="row justify-content-between">

                    @include('includes.sortbar', ['sort_by' => !isset($_GET['sort_by']) ?: $_GET['sort_by']])

                    <div class="col-2">
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
            <div class="row">

                @foreach($articles as $article)
                    @include('includes.article_item', compact('article', 'journal'))
                @endforeach

                <div class="article-item entity-item d-flex _article" data-id="443516">

                    <div class="w-100 pagination d-flex justify-content-center">
                            {{ $articles->fragment($tab)->links() }}
                    </div>
                </div>
            </div>

        </div>
        <div class="col-xl-2 col-lg-2 col-12 order-2 order-xl-3 order-lg-3">
            @include('includes.sidebar')
        </div>

    </div>
</div>
