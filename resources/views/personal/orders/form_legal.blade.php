<form action="{{ route('order.make') }}"
      method="POST" id="l_order_form"
      data-toggle="validator" enctype="multipart/form-data">
@csrf
<input type="hidden" name="PERSON_TYPE" value="legal">
<div class="form-container col-12">
    <div class="form-wrapper">
        <div class="form-row">
            <div class="form-label"></div>
            <div class="form-holder"><span class="font-weight-bold">Организация:</span></div>
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
            <div class="form-holder"><span class="font-weight-bold">Ответственное лицо:</span></div>
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
            <div class="form-holder"><span class="font-weight-bold">Контакты:</span></div>
        </div>
        <div class="form-row">
            <div class="form-label">Телефон:</div>
            <div class="form-holder">
                <input type="text" class="form-field" id="l_phone" placeholder="Телефон" value="" name="l_phone" data-role="js-mask-phone">
            </div>
        </div>
        <div class="form-row">
            <div class="form-label">Электронная почта:</div>
            <div class="form-holder">
                <input type="email" class="form-field" id="l_email" placeholder="Электронная почта" value="" name="l_email">
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
                <div class="checkbox simple-checkbox">
                    <input type="checkbox" id="l_personal_data_consent" value="Y" name="l_personal_data_consent" checked>
                    <label for="l_personal_data_consent">
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
                <input type="checkbox" id="l_contract_accept" placeholder="l_contract_accept" value="Y" name="l_contract_accept" checked>
                Я внимательно ознакомился с <a target="_blank" href="/oferta/">договором оферты</a> и принимаю все его положения:<span class="asterisk">*</span>
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
            <div class="form-label"><span class="font-weight-bold">Способ оплаты:</span></div>
            <div class="form-holder">
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <label class="btn btn-outline-secondary active">
                        <input type="radio" aria-label="Счёт" checked name="paysystem_legal" value="{{ Paysystem::INVOICE }}"/>
                        Счёт
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
