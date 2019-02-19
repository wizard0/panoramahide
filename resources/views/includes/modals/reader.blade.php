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
                <input type="text" name="code" value="" required
                       {{--data-role="js-mask-int" data-length="6"--}}
                >
            </div>
            <div class="form-group m-0 text-right">
                <button type="submit" class="btn inner-form-submit">
                    <span>Подтвердить</span>
                </button>
            </div>
        </form>
    @endslot
@endcomponent

@component('components.modal', ['id' => 'reader-confirm-online-modal', 'title' => 'Подтвердите устройство', 'header' => false, 'backdop' => false, 'closeHeader' => false])
    @slot('body')
        <form class="ajax-form" action="{{ route('reader.online', ['online' => 1]) }}"
              data-callback="callbackReaderAccess"
        >
            <h3 class="text-center">
                Читать с этого устройства?
            </h3>
            <span style="font-size: 12px;">
                Одновременно использовать читалку разрешено только с одного устройства.
            </span>
            <div class="form-group m-t-10 m-b-0 text-center">
                <button type="submit" class="btn inner-form-submit">
                    <span>Подтвердить устройство</span>
                </button>
            </div>
        </form>
    @endslot
@endcomponent

@component('components.modal', ['id' => 'reader-max-devices-modal', 'title' => 'Подтвердите устройство', 'header' => false, 'backdop' => false, 'closeHeader' => false])
    @slot('body')
        <form class="ajax-form" action="{{ route('reader.online', ['reset' => 1]) }}"
              data-callback="callbackReaderAccess"
        >
            <h3 class="text-center">
                Достигнуто максимально количество разрешенных устройств.
            </h3>
            <span style="font-size: 12px;">
                Сбросить разрешенные устройства Вы можете по ссылке в email сообщении.
            </span>
            <div class="form-group m-t-10 m-b-0 text-center">
                <button type="submit" class="btn inner-form-submit">
                    <span>Получить ссылку</span>
                </button>
            </div>
        </form>
    @endslot
@endcomponent
