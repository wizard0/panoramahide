@component('components.modal', ['id' => 'promo-access-password-modal', 'title' => 'Войдите в учетную запись'])
    @slot('body')
        <form class="ajax-form" action="{{ route('promo.password') }}" data-form-data=".--form-promo-access"
              data-callback="callbackPromoAccess"
        >
            <div class="form-group">
                <label>Логин</label>
                <input type="text" name="email" placeholder="" autocomplete="username" disabled>
            </div>
            <div class="form-group">
                <label>Пароль</label>
                <input type="password" name="password" placeholder="" autocomplete="current-password">
            </div>
            <div class="form-group m-0 text-right">
                <button type="submit" class="btn inner-form-submit">
                    <span>Войти</span>
                </button>
            </div>
        </form>
    @endslot
@endcomponent

@component('components.modal', ['id' => 'promo-activation-promocode-modal', 'title' => 'Активация промокода', 'header' => false, 'closeBody' => false])
    @slot('body')
        <form class="ajax-form" action="{{ route('promo.activation') }}" data-form-data=".--form-promo-access"
              data-callback="showMessageLoading"
        >
            <h3 class="text-center">
                Активация промокода
            </h3>
            <div class="message-loading"></div>
        </form>
    @endslot
@endcomponent

@component('components.modal', ['id' => 'promo-code-modal', 'title' => 'Введите код подтверждения'])
    @slot('body')
        <form action="{{ route('promo.code') }}" class="ajax-form" data-form-data=".--form-promo-access"
              data-callback="callbackPromoAccess"
        >
            <span style="font-size: 12px;">
                На указанный Вами номер телефона был отправлен код подтверждения.
            </span>
            <div class="form-group">
                <label>Код подтверждения</label>
                <input type="text" name="code" value="" required>
            </div>
            <div class="form-group m-0 text-right">
                <button type="submit" class="btn inner-form-submit">
                    <span>Подтвердить</span>
                </button>
            </div>
        </form>
    @endslot
@endcomponent
