<form action="{{ route('order.make') }}" method="POST" id="p_order_form" enctype="multipart/form-data">
@csrf
<input type="hidden" name="PERSON_TYPE" value="physical">
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
                <input type="text" class="form-field" id="phone" placeholder="Телефон" value="" name="phone" data-role="js-mask-phone">
            </div>
        </div>
        <div class="form-row">
            <div class="form-label">Email:</div>
            <div class="form-holder">
                <input type="email" class="form-field" id="email" placeholder="Email" value="" name="email">
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
                <div class="checkbox simple-checkbox">
                    <input type="checkbox" id="personal_data_consent" value="Y" name="personal_data_consent" checked>
                    <label for="personal_data_consent">
                        <span>
                            Я согласен на обработку <a target="_blank" href="/coglasie-na-obrabotku-personalnykh-dannykh/">своих персональных данных</a>
                        </span>
                    </label>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="form-label">
            </div>
            <div class="form-holder">
                <div class="checkbox simple-checkbox">
                    <input type="checkbox" id="contract_accept" placeholder="contract_accept" value="Y" name="contract_accept" checked>
                    <label for="contract_accept">
                        <span>
                            Я внимательно ознакомился с <a target="_blank" href="/oferta/">договором оферты</a><br> и принимаю все его положения:
                            <span class="asterisk">*</span>
                        </span>
                    </label>
                </div>
            </div>
        </div>
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
            <div class="form-label"><span>Способ оплаты:</span></div>
            <div class="form-holder">
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <label class="btn btn-outline-secondary active">
                        <input type="radio" aria-label="Электронный платеж" checked name="paysystem_physic" value="{{ Paysystem::ROBOKASSA }}"/>
                        Электронный платеж
                    </label>
                    <label class="btn btn-outline-secondary">
                        <input type="radio" aria-label="Сбербанк online" name="paysystem_physic" value="{{ Paysystem::SBERBANK }}"/>
                        Оплата через Сбербанк
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
