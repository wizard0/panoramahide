<form action="{{ route('login') }}" class="ajax-form" id="login-form">
    @if(isset($backTo))
        <input type="hidden" name="backTo" value="{{ $backTo }}">
    @endif
    <div class="form-group">
        <label>Логин</label>
        <input type="text" name="email" placeholder="test@test.com" autocomplete="username">
    </div>
    <div class="form-group">
        <label>Пароль</label>
        <input type="password" name="password" placeholder="" autocomplete="current-password">
    </div>
    <div class="form-group">
        <div class="d-flex justify-content-between" style="margin-bottom: 24px;">
            <div class="simple-checkbox">
                <input id="remember_auth" name="remember" value="Y" type="checkbox" checked/>
                <label for="remember_auth"><span>Запомнить меня</span></label>
            </div>
            <noindex>
                <div>
                    <a href="{{ route('password.request') }}" rel="nofollow" class="grey-link" style="font-size: 14px;">Забыли пароль?</a>
                </div>
            </noindex>
        </div>
    </div>
    <div class="form-group m-0 text-right">
        <button type="submit" class="btn inner-form-submit">
            <span>Войти</span>
        </button>
    </div>
</form>
