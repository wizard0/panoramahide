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
    var SideBarManager = new JSSideBarManager();
</script>
