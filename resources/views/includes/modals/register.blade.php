<div class="modal fade" id="login-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Войти в личный кабинет</h4>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </a>
            </div>
            <div class="modal-body">
                <div id="comp_2367e15b8daddc6be6b49b6413220419">

                    <form name="system_auth_form6zOYVN" method="post" target="_top" action="{{ route('login') }}">
                        @csrf
                        <label class="col-12">Логин</label>
                        <input type="text" name="email" placeholder="grishchenkonikolay@gmail.com">
                        <label class="col-12">Пароль</label>
                        <input type="password" name="password" placeholder="">
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

                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="registration-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Зарегистрироваться</h4>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </a>
            </div>
            <div class="modal-body">
                <div id="comp_57156febe02d32d30644847cdc37da67">
                    <div class="bx-auth-reg">
                        <form method="post" action="/" name="regform" enctype="multipart/form-data">
                            <input type="text" name="captcha_check" style="display:none;">
                            <input type="hidden" name="register_submit_button" value="Y">

                            <label class="col-12">Ваше имя</label>
                            <input type="text" name="REGISTER[NAME]" required="required" value="">

                            <label class="col-12">Ваша фамилия</label>
                            <input type="text" name="REGISTER[LAST_NAME]" required="required" value="">

                            <div class="simple-checkbox">
                                <input type="checkbox" name="REGISTER[UF_PRIVATE_PERSON]" value="Y"
                                       id="input_UF_PRIVATE_PERSON" checked="checked">
                                <label class="col-12" for="input_UF_PRIVATE_PERSON">Частное лицо</label>
                            </div>


                            <label class="col-12">Ваш email</label>
                            <input type="email" name="REGISTER[EMAIL]" required="required" value="">

                            <label class="col-12">Ваш телефон</label>
                            <input type="text" name="REGISTER[PERSONAL_PHONE]" class="_phone" required="required"
                                   value="">

                            <label class="col-12">Придумайте пароль</label>
                            <input type="password" name="REGISTER[PASSWORD]" value="">

                            <label class="col-12">Пароль еще раз</label>
                            <input type="password" name="REGISTER[PASSWORD_CONFIRM]" value="">


                            <div class="d-flex justify-content-end">
                                <input type="hidden" name="captcha_sid" value="0e75d598364933790690be443ac54189"/>
                                <img src="/bitrix/tools/captcha.php?captcha_sid=0e75d598364933790690be443ac54189"
                                     width="172" height="32" alt="CAPTCHA"/>
                                <input type="text" name="captcha_word" class="form-field" maxlength="50" value=""
                                       placeholder="Введите слово на картинке"/>
                            </div>

                            <div class="d-flex" style="margin-bottom: 24px;">
                                <div class="simple-checkbox">
                                    <input id="remember_reg" type="checkbox" name="USER_REMEMBER" value="Y"
                                           checked="checked"/>
                                    <label for="remember_reg"><span>Запомнить меня</span></label>
                                </div>
                                <div class="simple-checkbox">
                                    <input id="confirm" type="checkbox" name="UF_PROC_PER_DATA" value="1"
                                           checked="checked" required="required"/>
                                    <label for="confirm"><span>Я согласен на обработку своих <a
                                                    href="//panor.ru/coglasie-na-obrabotku-personalnykh-dannykh/"
                                                    class="red-link">персональных данных</a></span></label>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end">
                                <div class="simple-checkbox">
                                    <input id="UF_NEWS_LETTERS" type="checkbox" name="UF_NEWS_LETTERS" value="Y"
                                           checked="checked"/>
                                    <label for="UF_NEWS_LETTERS"><span>Информируйте меня обо всех новостях и спецпредложениях по почте</span></label>
                                </div>
                                <button type="submit" class="basic-button"><span>Войти</span></button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
