@extends('layouts.app')

@section('content')
<div class="promo body">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <h1>Получите доступ к эксклюзивным материалам</h1>
                <div class="info">
                    <p>Заполните все поля регистрационной формы. В поле "промокод" используйте код из письма.</p>
                    <p>После отправки формы на Ваш телефон придёт смс-уведомление с кодом, который нужно ввести для подтверждения подлинности вашего номера телефона.</p>
                    <p>Нужно указывать номер мобильного телефона.</p>
                </div>
            </div>
            <div class="col-lg-6 col-lg-offset-2">
                <div class="form-container">
                    <form id="user_form" class="ajax-form --form-promo-access" action="{{ route('promo.access') }}"
                        data-callback="callbackPromoAccess"
                    >
                        <div class="form-wrapper">

                            <div class="form-row">
                                <div class="form-label">Фамилия:</div>
                                <div class="form-holder"><input type="text" class="form-field" name="surname" placeholder="" value="{{ Auth::user()->last_name ?? '' }}"></div>
                            </div>

                            <div class="form-row">
                                <div class="form-label">Имя:</div>
                                <div class="form-holder"><input type="text" class="form-field" name="name" placeholder="" value="{{ Auth::user()->name ?? '' }}"></div>
                            </div>

                            <div class="form-row">
                                <div class="form-label">Отчество:</div>
                                <div class="form-holder"><input type="text" class="form-field" name="patronymic" placeholder="" value=""></div>
                            </div>

                            <div class="form-row">
                                <div class="form-label">Email:</div>
                                <div class="form-holder">
                                    <input type="email" class="form-field" name="email" placeholder="" value="{{ Auth::user()->email ?? '' }}">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-label">Моб. телефон:</div>
                                <div class="form-holder">
                                    <input type="phone" class="form-field" name="phone" placeholder="+7 (xxx) xxx-xx-xx" value="{{ Auth::user()->phone ?? '' }}" data-role="js-mask-phone">
                                </div>
                            </div>

                            <div class="form-row" id="publisher" style="display: none;">
                                <div class="form-label">Издательство:</div>
                                <div class="form-holder">
                                    <select name="publisher" class="form-control" placeholder="Выберите издательство из списка">
                                        <option value="">-</option>
                                        <option value="789">Промиздат</option>
                                        <option value="790">Сельхозиздат</option>
                                        <option value="781">Афина (Академия ФИНАнсов)</option>
                                        <option value="785">Медиздат</option>
                                        <option value="786">Наука и культура</option>
                                        <option value="791">Стройиздат</option>
                                        <option value="784">Индустрия гостеприимства и торговли (HORECA)</option>
                                        <option value="792">Транспорт и связь</option>
                                        <option value="783">Внешэкономиздат</option>
                                        <option value="788">Политэкономиздат</option>
                                        <option value="793">Ты и твой дом</option>
                                        <option value="787">Панорама - спорт</option>
                                        <option value="58153">18+</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-row" id="journal" style="display: none;">
                                <div class="form-label">Журнал:</div>
                                <div class="form-holder">
                                    <select name="journal" class="form-control" placeholder="Выберите журнал из списка"></select>
                                </div>
                            </div>

                            <div class="form-row" id="number" style="display: none;">
                                <div class="form-label">Выпуск:</div>
                                <div class="form-holder">
                                    <select name="number" class="form-control" placeholder="Выберите выпуск из списка"></select>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-label">Промокод:</div>
                                <div class="form-holder"><input type="text" class="form-field promocode" name="promocode" ></div>
                            </div>

                            <div class="form-row">
                                <div class="form-label"></div>
                                <div class="form-holder">
                                    <input type="checkbox" value="1" name="UF_PROC_PER_DATA" checked="checked" >
                                    &nbsp;Я согласен на обработку&nbsp;
                                    <a href="http://panor.ru/coglasie-na-obrabotku-personalnykh-dannykh/" target="_blank">
                                        своих персональных данных
                                    </a>
                                </div>
                            </div>

                        </div>

                        <div class="button-holder">
                            <button type="submit" class="btn btn-primary text-uppercase inner-form-submit" id="btn_access" value="Получить доступ">Получить доступ</button>
                        </div>

                        <div class="text-center">
                            <span>Все поля обязательны для заполнения</span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="promo container">
    <div class="row center">
        <div>
            <h4 style="color: #1771b3;">Почему мы просим указать номер мобильного?</h4>
            <div>
                Сегодня это самый действенный способ отличить человека от алгоритма. Вам не нужно отправлять никаких СМС.<br/>
                Мы не будем Вам названивать и тем более никому не передадим Ваши данные.
            </div>
        </div>
        <div class="phone-container">
            <div>Если у Вас возникли проблемы при регистрации или остались вопросы, обращайтесь по телефону:</div>
            <div class="phone"> +7 495 274-22-22</div>
        </div>
    </div>
</div>
@endsection
