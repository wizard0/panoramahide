@component('components.modal', ['id' => 'code-modal', 'title' => 'Введите код подтверждения'])
    @slot('body')
        <form action="{{ route('promo.code') }}" class="ajax-form" data-form-data=".--form-promo-access">
            <span style="font-size: 12px;">
                На указанный Вами номер телефона был отправлен код подтверждения.
            </span>
            <div class="form-group">
                <label>Код подтверждения</label>
                <input type="text" name="code" value="" required>
            </div>
            <div class="form-group m-0 text-right">
                <button type="submit" class="btn inner-form-submit">
                    <span>Зарегистрироваться</span>
                </button>
            </div>
        </form>
    @endslot
@endcomponent
