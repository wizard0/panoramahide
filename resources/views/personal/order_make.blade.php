@extends('layouts.app')

@section('content')
    <div class="container"><div class="container show-results">
        <div class="row">

            @include('personal.left_sidebar', ['active' => 'order'])

            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-9 personal-form">
                <div class="row justify-content-center">
                    <h3 class="text-center text-uppercase section-title">Оформление заказа</h3>
                    <a name="order_form"></a>
                    <NOSCRIPT>
                        <div class="errortext">Для оформления заказа необходимо включить JavaScript.
                            По-видимому, JavaScript либо не поддерживается браузером, либо отключен.
                            Измените настройки браузера и затем <a href="">повторите попытку</a>.</div>
                    </NOSCRIPT>
                    <div class="col-12">
                        <form action="{{ route('order.make') }}"
                              method="POST" name="ORDER_FORM" id="ORDER_FORM"
                              data-toggle="validator" enctype="multipart/form-data">
                            @csrf
                            <div id="order_form_content" class="order-make-holder row justify-content-center">
                                <div style="display:none;">
                                    <input
                                            style="display:none;"
                                            type="radio"
                                            id="PERSON_TYPE_1"
                                            name="PERSON_TYPE"
                                            value="physical"
                                            checked="checked"
                                    >
                                    <label for="PERSON_TYPE_1">Физ. лицо</label>
                                    <br />
                                    <input
                                            style="display:none;"
                                            type="radio"
                                            id="PERSON_TYPE_2"
                                            name="PERSON_TYPE"
                                            value="legal"
                                    >
                                    <label for="PERSON_TYPE_2">Юр. лицо</label>
                                    <br />
                                </div>
                                <ul class="orderStep orderStepLook2 nav nav-tabs">
                                    <li  class="active"  >
                                        <a
                                                onclick="$('#PERSON_TYPE_1').trigger('click');"
                                                href="javascript:void(0);"
                                                class="btn btn-success person_type_btn"
                                        >
                                            ФИЗИЧЕСКИЕ ЛИЦА            </a>
                                    </li>
                                    <li  >
                                        <a
                                                onclick="$('#PERSON_TYPE_2').trigger('click');"
                                                href="javascript:void(0);"
                                                class="btn btn-primary person_type_btn"
                                        >
                                            ЮРИДИЧЕСКИЕ ЛИЦА           </a>
                                    </li>
                                </ul>
                                <input type="hidden" name="PERSON_TYPE_OLD" value="1" />
                                <div class="form-ordermake-block">
                                </div>
                                <div id="phys_user_form">
                                <div class="form-container col-12">
                                    <div class="form-wrapper">
                                        <div class="form-row">
                                            <div class="form-label">Фамилия:</div>
                                            <div class="form-holder">
                                                <input type="text" class="form-field" id="surname" placeholder="Фамилия" value="" name="surname">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-label">Имя:</div>
                                            <div class="form-holder">
                                                <input type="text" class="form-field" id="name" placeholder="Имя" value="" name="name">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-label">Отчество:</div>
                                            <div class="form-holder">
                                                <input type="text" class="form-field" id="patronnynic" placeholder="Отчество" value="" name="patronymic">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-label">Телефон:</div>
                                            <div class="form-holder">
                                                <input type="text" class="form-field" id="phone" placeholder="Телефон" value="" name="phone">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-label">Email:</div>
                                            <div class="form-holder">
                                                <input type="text" class="form-field" id="email" placeholder="Email" value="" name="email">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-label">Адрес доставки:</div>
                                            <div class="form-holder">
                                                <input type="text" class="form-field" id="delivery_address" placeholder="Адрес доставки" value="" name="delivery_address">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-label">
                                            </div>
                                            <div class="form-holder">
                                                <input type="checkbox" id="personal_data_consent" placeholder="personal_data_consent" value="Y" name="personal_data_consent" checked>
                                                Я согласен на обработку <a target="_blank" href="/coglasie-na-obrabotku-personalnykh-dannykh/">своих персональных данных</a>
                                            </div>
                                        </div>
                                        <input type="hidden" name="ORDER_PROP_18" value="Y" >
                                        <div class="form-row">
                                            <div class="form-label">
                                                Я внимательно ознакомился с &lt;a target=&quot;_blank&quot; href=&quot;/oferta/&quot;&gt;договором оферты&lt;/a&gt; и принимаю все его положения:
                                                <span class="asterisk">*</span>
                                            </div>
                                            <div class="form-holder">
                                                <input type="checkbox" id="contract_accept" placeholder="contract_accept" value="Y" name="contract_accept" checked>
                                            </div>
                                        </div>
                                        <input type="hidden" name="ORDER_PROP_23" value="Y" >
                                        <div style="display:none;">
                                            <div id="LOCATION_tmp">
                                                <div style="display:none">
                                                    <select disabled id="tmp" name="tmp" onChange="submitForm()" type="location">
                                                        <option>(выберите страну)</option>
                                                        <option value="1" selected="selected">Россия</option>
                                                    </select>
                                                </div>
                                                <div class="sale_locations_fixed">Страна: Россия<br></div>
                                                <div style="display:none">
                                                    <select id="tmp"  name="tmp" onchange="submitForm()" type="location">
                                                        <option>(выберите город)</option>
                                                        <option value="1">(другой)</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div id="wait_container_tmp" style="display: none;"></div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-label"></div>
                                            <div class="form-holder"><span class="osbold">Способ оплаты:</span></div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-label"></div>
                                            <div class="form-holder">
                                                <div class="unit-version">
                                                    <label>
                                                        <input type="radio"
                                                               aria-label="Электронный платеж"
                                                               style="vertical-align:top;"
                                                               id="paysystem_physic_1"
                                                               name="paysystem_physic"
                                                               value="{{ Paysystem::ROBOKASSA }}"
                                                               checked="checked"                onclick="changePaySystem();" />
                                                        <span style="vertical-align:top;">Электронный платеж</span>
                                                    </label>
                                                    <label>
                                                        <input type="radio"
                                                               aria-label="Оплата через Сбербанк"
                                                               style="vertical-align:top;"
                                                               id="paysystem_physic_2"
                                                               name="paysystem_physic"
                                                               value="{{ Paysystem::SBERBANK }}"
                                                               onclick="changePaySystem();" />
                                                        <span style="vertical-align:top;">Оплата через Сбербанк</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                                <div id="legal_user_form" style="display: none">
                                    <div class="form-container col-12">
                                        <div class="form-wrapper">
                                            <div class="form-row">
                                                <div class="form-label"></div>
                                                <div class="form-holder"><span class="osbold">
            Организация:
            </span>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-label">Название организации:</div>
                                                <div class="form-holder">
                                                    <input type="text" class="form-field" id="org_name" placeholder="Название организации" value="" name="org_name">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-label">Юридический адрес:</div>
                                                <div class="form-holder">
                                                    <input type="text" class="form-field" id="legal_address" placeholder="Юридический адрес" value="" name="legal_address">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-label">ИНН:</div>
                                                <div class="form-holder">
                                                    <input type="text" class="form-field" id="INN" placeholder="ИНН" value="" name="INN">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-label">КПП:</div>
                                                <div class="form-holder">
                                                    <input type="text" class="form-field" id="KPP" placeholder="КПП" value="" name="KPP">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-label"></div>
                                                <div class="form-holder"><span class="osbold">
            Ответственное лицо:
            </span>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-label">Фамилия:</div>
                                                <div class="form-holder">
                                                    <input type="text" class="form-field" id="l_surname" placeholder="Фамилия" value="Фaмилия ответственного лица" name="l_surname">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-label">Имя:</div>
                                                <div class="form-holder">
                                                    <input type="text" class="form-field" id="l_name" placeholder="Имя" value="Имя ответственного лица" name="l_name">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-label">Отчество:</div>
                                                <div class="form-holder">
                                                    <input type="text" class="form-field" id="l_patronymic" placeholder="Отчество" value="Отчество ответственного лица" name="l_patronymic">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-label"></div>
                                                <div class="form-holder"><span class="osbold">
            Контакты:
            </span>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-label">Телефон:</div>
                                                <div class="form-holder">
                                                    <input type="text" class="form-field" id="l_phone" placeholder="Телефон" value="" name="l_phone">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-label">Электронная почта:</div>
                                                <div class="form-holder">
                                                    <input type="text" class="form-field" id="l_email" placeholder="Электронная почта" value="" name="l_email">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-label">Адрес доставки:</div>
                                                <div class="form-holder">
                                                    <input type="text" class="form-field" id="l_delivery_address" placeholder="Адрес доставки" value="" name="l_delivery_address">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-label">
                                                </div>
                                                <div class="form-holder">
                                                    <input type="checkbox" id="l_personal_data_consent" placeholder="ORDER_PROP_19" value="Y" name="l_personal_data_consent" checked>
                                                    Я согласен на обработку <a target="_blank" href="/coglasie-na-obrabotku-personalnykh-dannykh/">своих персональных данных</a>
                                                </div>
                                            </div>
                                            <input type="hidden" name="ORDER_PROP_19" value="Y" >
                                            <div class="form-row">
                                                <div class="form-label">
                                                    Я внимательно ознакомился с &lt;a target=&quot;_blank&quot; href=&quot;/oferta/&quot;&gt;договором оферты&lt;/a&gt; и принимаю все его положения:
                                                    <span class="asterisk">*</span>
                                                </div>
                                                <div class="form-holder">
                                                    <input type="checkbox" id="l_contract_accept" placeholder="l_contract_accept" value="Y" name="l_contract_accept" checked>
                                                </div>
                                            </div>
                                            <input type="hidden" name="ORDER_PROP_24" value="Y" >

                                            <div style="display:none;">
                                                <div id="LOCATION_tmp">
                                                    <div style="display:none">
                                                        <select disabled id="tmp" name="tmp" onChange="submitForm()" type="location">
                                                            <option>(выберите страну)</option>
                                                            <option value="1" selected="selected">Россия</option>
                                                        </select>
                                                    </div>
                                                    <div class="sale_locations_fixed">Страна: Россия<br></div>
                                                    <div style="display:none">
                                                        <select id="tmp"  name="tmp" onchange="submitForm()" type="location">
                                                            <option>(выберите город)</option>
                                                            <option value="1">(другой)</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div id="wait_container_tmp" style="display: none;"></div>

                                            </div>
                                            <div class="form-row">
                                                <div class="form-label"></div>
                                                <div class="form-holder"><span class="osbold">Способ оплаты:</span></div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-label"></div>
                                                <div class="form-holder">
                                                    <div class="unit-version">

                                                        <input type="hidden" name="PAY_SYSTEM_ID" value="6">
                                                        <label>
                                                            <input type="radio"
                                                                   aria-label="Счет"
                                                                   style="vertical-align:top;"
                                                                   id="paysystem_legal_3"
                                                                   name="paysystem_legal"
                                                                   value="{{ Paysystem::INVOICE }}"
                                                                   checked="checked"							onclick="changePaySystem();"
                                                            />
                                                            <span style="vertical-align:top;">Счет</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bx_section" style="display:none">
                                    <h4>Свойства, связанные с оплатой и доставкой</h4>
                                    <br />
                                </div>
                            </div>
                            <input type="hidden" name="confirmorder" id="confirmorder" value="Y">
                            <input type="hidden" name="profile_change" id="profile_change" value="N">
                            <input type="hidden" name="is_ajax_post" id="is_ajax_post" value="Y">
                            <input type="hidden" name="json" value="Y">
                        </form>
                    </div>
                    <div style="display:none;">
                        <div id="delivery_info_"><a href="javascript:void(0)" onClick="deliveryCalcProceed({'STEP':'1','DELIVERY_ID':'','DELIVERY':'','PROFILE':'','WEIGHT':'0','PRICE':'0','LOCATION':'0','LOCATION_ZIP':'','CURRENCY':'','INPUT_NAME':'','TEMP':'','ITEMS':'','EXTRA_PARAMS_CALLBACK':'','ORDER_DATA':[]})">Рассчитать стоимость</a></div>
                        <div id="wait_container_" style="display: none;"></div>
                    </div>
                    <div class="form-buttons-holder">
                        <button
                                form="ORDER_FORM"
                                onclick="submitForm('Y'); return false;"
                                id="ORDER_CONFIRM_BUTTON"
                                name="submit"
                                type="submit"
                                class="btn btn-primary"
                                value="Оплатить"
                        >
                            Оформить заказ    </button>
                        <button
                                type="submit"
                                class="btn btn-primary greybtn"
                                onclick="location.href='/magazines/'"
                                value="Вернуться к покупкам"
                                style="margin-top: 15px;"
                        >
                            Вернуться к покупкам </button>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
@endsection
