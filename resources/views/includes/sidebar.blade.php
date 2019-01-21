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

@section('sidebar.modals')
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
                <p class="_text">
                    @if (isset($article))
                        {{ __('Статья') }} "{{ $article->name }}" <br>
                    @endif
                    @if (isset($journal))
                        <a href="{{ route('journal', ['code' => $journal->code]) }}">Журнал "{{ $journal->name }} /
                            {{ $journal->translate('en', true)->name }}"</a>
                    @endif
                </p>
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
@endsection
