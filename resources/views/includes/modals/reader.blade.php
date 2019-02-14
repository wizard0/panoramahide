@component('components.modal', ['id' => 'reader-code-modal', 'title' => 'Введите код подтверждения', 'backdop' => false, 'closeHeader' => false])
    @slot('body')
        <form action="{{ route('reader.code') }}" class="ajax-form"
              data-callback="callbackReaderAccess"
        >
            <span style="font-size: 12px;">
                На указанный ваш email был отправлен код подтверждения устройства.
            </span>
            <div class="form-group">
                <label>Код подтверждения</label>
                <input type="text" name="code" value="" required data-role="js-mask-int" data-length="6">
            </div>
            <div class="form-group m-0 text-right">
                <button type="submit" class="btn inner-form-submit">
                    <span>Подтвердить</span>
                </button>
            </div>
        </form>
    @endslot
@endcomponent
