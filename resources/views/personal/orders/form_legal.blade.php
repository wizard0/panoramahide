<form action="{{ route('order.make') }}" class="ajax-form" data-outer-submit="#order_confirm_button" id="l_order_form">
    @csrf
    <input type="hidden" name="PERSON_TYPE" value="legal">
    <div class="form-group mb-1">
        <span class="font-weight-bold">Организация</span>
        <hr class="mt-0 mb-0">
    </div>
    <div class="form-group">
        <label>Название организации</label>
        <input type="text" class="form-control" id="org_name" placeholder="Название организации" value=""
               name="org_name" required>
    </div>
    <div class="form-group">
        <label>Юридический адрес</label>
        <input type="text" class="form-control" id="legal_address" placeholder="Юридический адрес" value=""
               name="legal_address" required>
    </div>
    <div class="form-group">
        <label>ИНН</label>
        <input type="text" class="form-control" id="INN" placeholder="ИНН" value="" name="INN" required>
    </div>
    <div class="form-group">
        <label>КПП</label>
        <input type="text" class="form-control" id="KPP" placeholder="КПП" value="" name="KPP" required>
    </div>
    <div class="form-group">
        <span class="font-weight-bold">Ответственное лицо</span>
        <hr class="mt-0 mb-0">
    </div>
    <div class="form-group">
        <label>Фамилия</label>
        <input type="text" class="form-control" id="l_surname" placeholder="Фамилия ответственного лица" value="" name="l_surname" required>
    </div>
    <div class="form-group">
        <label>Имя</label>
        <input type="text" class="form-control" id="l_name" placeholder="Имя ответственного лица" value="" name="l_name" required>
    </div>
    <div class="form-group">
        <label>Отчество</label>
        <input type="text" class="form-control" id="l_patronymic" placeholder="Отчество ответственного лица" name="l_patronymic" required>
    </div>
    <div class="form-group">
        <span class="font-weight-bold">Контакты</span>
        <hr class="mt-0 mb-0">
    </div>
    <div class="form-group">
        <label>Телефон</label>
        <input type="text" class="form-control" id="l_phone" placeholder="Телефон" value="" name="l_phone" data-role="js-mask-phone" required>
    </div>
    <div class="form-group {{ Auth::check() ? 'hidden' : '' }}">
        <label>Электронная почта</label>
        <input type="email" class="form-control" id="l_email" placeholder="Электронная почта"
               value="{{ Auth::check() ? Auth::user()->email : '' }}" name="l_email" required>
    </div>
    <div class="form-group">
        <label>Адрес доставки</label>
        <input type="text" class="form-control" id="l_delivery_address" placeholder="Адрес доставки" value="" name="l_delivery_address" required>
    </div>
    <div class="form-group">
        <div class="checkbox simple-checkbox">
            <input type="checkbox" id="l_personal_data_consent" value="Y" name="l_personal_data_consent" checked required>
            <label for="l_personal_data_consent">
                <span>Я согласен на обработку <a target="_blank" href="/coglasie-na-obrabotku-personalnykh-dannykh/">своих персональных данных</a></span>
            </label>
        </div>
    </div>
    <div class="form-group hidden">
        <div id="LOCATION_tmp">
            <div>
                <select disabled id="tmp" name="tmp" onChange="submitForm()" type="location">
                    <option>(выберите страну)</option>
                    <option value="1" selected="selected">Россия</option>
                </select>
            </div>
            <div class="sale_locations_fixed">Страна: Россия<br></div>
            <div>
                <select id="tmp" name="tmp" onchange="submitForm()" type="location">
                    <option>(выберите город)</option>
                    <option value="1">(другой)</option>
                </select>
            </div>
        </div>
        <div id="wait_container_tmp" style="display: none;"></div>
    </div>
    <div class="form-group text-center">
        <label>Способ оплаты</label>
        <div>
            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                <label class="btn btn-outline-secondary active">
                    <input type="radio" aria-label="Счёт" checked name="paysystem_legal"
                           value="{{ Paysystem::INVOICE }}"/>
                    Счёт
                </label>
            </div>
        </div>
    </div>
</form>
