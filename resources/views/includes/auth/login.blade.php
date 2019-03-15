@if (Auth::check())
    <a class="grey-link" href="/personal/">{{ __('Личный кабинет') }}</a>&nbsp;/&nbsp;
    <a class="grey-link" href="/logout">{{ __('Выйти') }}</a>
@else
    <a href="#" class="grey-link" data-toggle="modal" data-target="#login-modal">{{ __('Войти') }}</a>&nbsp;/&nbsp;
    <a href="#" class="grey-link" data-toggle="modal" data-target="#registration-modal">{{ __('Регистрация') }}</a>
@endif
