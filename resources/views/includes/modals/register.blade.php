@component('components.modal', ['id' => 'login-modal', 'title' => 'Войти в личный кабинет'])
    @slot('body')
        <form name="system_auth_form6zOYVN" method="post" target="_top" action="{{ route('login') }}">
            @csrf
            <label class="col-12">Логин</label>
            <input type="text" name="email" placeholder="grishchenkonikolay@gmail.com" autocomplete="username">
            <label class="col-12">Пароль</label>
            <input type="password" name="password" placeholder="" autocomplete="current-password">
            <div class="d-flex justify-content-between" style="margin-bottom: 24px;">
                <div class="simple-checkbox">
                    <input id="remember_auth" name="remember" value="Y" type="checkbox" checked/>
                    <label for="remember_auth"><span>Запомнить меня</span></label>
                </div>
                <noindex>
                    <div><a href="/personal/profile/?forgot_password=yes&amp;backurl=%2F" rel="nofollow"
                            class="grey-link" style="font-size: 14px;">Забыли пароль?</a></div>
                </noindex>
            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" class="basic-button"><span>Войти</span></button>
            </div>
        </form>
    @endslot
@endcomponent

@component('components.modal', ['id' => 'registration-modal', 'title' => 'Зарегистрироваться'])
    @slot('body')
        <form method="post" action="{{ route('register') }}" name="regform" class="ajax-form" enctype="multipart/form-data">
            <input type="text" name="captcha_check" style="display:none;">
            <input type="hidden" name="register_submit_button" value="Y">
            <div class="form-group">
                <label>Ваше имя</label>
                <input type="text" name="name" value="" required>
            </div>
            <div class="form-group">
                <label>Ваша фамилия</label>
                <input type="text" name="last_name" value="" required>
            </div>
            <div class="form-group m-0">
                <div class="simple-checkbox">
                    <input type="checkbox" name="uf[private_person]" value="Y"
                           id="input_UF_PRIVATE_PERSON" checked="checked">
                    <label class="col-12" for="input_UF_PRIVATE_PERSON">Частное лицо</label>
                </div>
            </div>
            <div class="form-group">
                <label>Ваш email</label>
                <input type="email" name="email" value="" autocomplete="username" required>
            </div>
            <div class="form-group">
                <label>Ваш телефон</label>
                <input type="text" name="phone" class="_phone" value="" data-role="js-mask-phone" required>
            </div>
            <div class="form-group">
                <label>Придумайте пароль</label>
                <input type="password" name="password" value="" autocomplete="new_password">
            </div>
            <div class="form-group m-b-25">
                <label>Пароль еще раз</label>
                <input type="password" name="password_confirmation" value="" autocomplete="new_password">
            </div>
            <div class="form-group">
                <div id="auth_register_id"></div>
            </div>
            {{--<div class="form-group p-t-5">--}}
                {{--<div class="d-flex justify-content-end">--}}
                    {{--<input type="hidden" name="captcha_sid" value="0e75d598364933790690be443ac54189"/>--}}
                    {{--<img src="/bitrix/tools/captcha.php?captcha_sid=0e75d598364933790690be443ac54189"--}}
                         {{--width="172" height="32" alt="CAPTCHA"/>--}}
                    {{--<input type="text" name="captcha_word" class="form-field" maxlength="50" value=""--}}
                           {{--placeholder="Введите слово на картинке"/>--}}
                {{--</div>--}}
            {{--</div>--}}
            <div class="form-group p-t-5 m-b-5">
                <div class="simple-checkbox">
                    <input id="remember_reg" type="checkbox" name="uf[remember]" value="Y"
                           checked="checked"/>
                    <label for="remember_reg"><span>Запомнить меня</span></label>
                </div>
            </div>
            <div class="form-group m-b-5">
                <div class="simple-checkbox">
                    <input id="confirm" type="checkbox" name="uf[per_data]" value="1"
                           checked="checked" required="required"/>
                    <label for="confirm"><span>Я согласен на обработку своих <a
                                    href="//panor.ru/coglasie-na-obrabotku-personalnykh-dannykh/"
                                    class="red-link">персональных данных</a></span></label>
                </div>
            </div>
            <div class="form-group m-b-5">
                <div class="simple-checkbox">
                    <input id="UF_NEWS_LETTERS" type="checkbox" name="uf[news_letters]" value="Y"
                           checked="checked"/>
                    <label for="UF_NEWS_LETTERS"><span>Информируйте меня обо всех новостях и спецпредложениях по почте</span></label>
                </div>
            </div>
            <div class="form-group m-0 text-right">
                <button type="submit" class="btn inner-form-submit">
                    <span>Зарегистрироваться</span>
                </button>
            </div>
        </form>
    @endslot
@endcomponent
