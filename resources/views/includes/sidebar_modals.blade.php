
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
