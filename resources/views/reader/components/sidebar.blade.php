<nav>
    <div class="nav nav-tabs nav-hidden hidden" role="tablist">
        <a class="nav-item nav-link" data-toggle="tab" href="#tab-contents" role="tab"
           aria-controls="nav-home" aria-selected="true">
            <span class="text-uppercase">Содержание</span>
        </a>
        <a class="nav-item nav-link" data-toggle="tab" href="#tab-bookmark" role="tab"
           aria-controls="nav-profile" aria-selected="false">
            <span class="text-uppercase">Закладки</span>
        </a>
        <a class="nav-item nav-link" data-toggle="tab" href="#tab-library" role="tab"
           aria-controls="nav-contact" aria-selected="false">
            <span class="text-uppercase">Библиотека</span>
        </a>
    </div>
</nav>
<div class="tab-content">
    <div class="tab-pane fade" id="tab-contents" role="tabpanel">
        <h3 class="text-uppercase text-center m-t-15 m-b-15">Содержание</h3>
        <div class="tab-content-item" data-simplebar>
            <ul class="content contents-nav">
                @foreach($oArticles as $oArticle)
                    <li>
                        @include('reader.components.item.chapter', [
                            'oArticle' => $oArticle
                        ])
                    </li>
                @endforeach
            </ul>

        </div>
    </div>
    <div class="tab-pane fade" id="tab-bookmark" role="tabpanel">
        <h3 class="text-uppercase text-center m-t-15 m-b-15">Закладки</h3>
        <div class="tab-content-item" data-simplebar>
            <ul class="content contents-nav">

            </ul>
        </div>
    </div>
    <div class="tab-pane fade" id="tab-library" role="tabpanel">
        <h3 class="text-uppercase text-center m-t-15 m-b-15">Библиотека</h3>
        <div class="tab-content-item" data-simplebar>
            <ul class="content contents-nav">
                @foreach($oReleases as $oRelease)
                    <li>
                        @include('reader.components.item.journal', [
                            'oRelease' => $oRelease
                        ])
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
