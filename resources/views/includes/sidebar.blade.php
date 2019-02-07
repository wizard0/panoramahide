<div class="actions-menu _share_container">
    <div class="row">
        @if (!isset($hide) || !in_array('title', $hide))
            <div class="col-12">
                <span class="action-menu-title">Действия с выбранными:</span>
            </div>
        @endif
        @if (!isset($hide) || !in_array('subscribe', $hide))
            <div class="col-xl-12 col-lg-12 col-sm-3 col-6">
                <a class="get-access action-item accent _access" href="#subscribe">
                    <span>получить доступ</span>
                </a>
            </div>
        @endif
        <div class="col-xl-12 col-lg-12 col-sm-3 col-6">
            <a class="to-favs action-item _add_to_favorite" href="{{ route('to.favorite') }}">
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
        @if (isset($article))
            <div class="col-xl-12 col-lg-12 col-sm-3 col-6">
                <a class="share action-item _share" href="#">
                    <span>Поделиться</span>
                </a>
            </div>
        @endif
    </div>
</div>
<script>
    new ClipboardJS('#quote ._copy_clipboard');
            @if (isset($article))
    var SideBarManager = new JSSideBarManager('<?= json_encode([
            'id' => $article->id,
            'type' => 'article',
            'url' => route('article', ['code' => $article->code])
        ]) ?>');
            @elseif (isset($journal))
    var SideBarManager = new JSSideBarManager('<?= json_encode([
            'id' => $journal->id,
            'type' => 'journal',
            'url' => route('journal', ['code' => $journal->code])
        ]) ?>');
            @else
    var SideBarManager = new JSSideBarManager();
    @endif
</script>
