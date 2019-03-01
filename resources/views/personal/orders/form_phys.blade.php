<form action="{{ route('order.make') }}" class="ajax-form"
      data-outer-submit="#order_confirm_button"
      {{--method="POST" --}}
      id="p_order_form"
      {{--data-toggle="validator" enctype="multipart/form-data"--}}
>
    @csrf
    <input type="hidden" name="PERSON_TYPE" value="physical">
    <div class="form-group">
        <label>Фамилия</label>
        <input type="text" class="form-control" id="surname" placeholder="Фамилия" value="" name="surname" required>
    </div>
    <div class="form-group">
        <label>Имя</label>
        <input type="text" class="form-control" id="name" placeholder="Имя" value="" name="name" required>
    </div>
    <div class="form-group">
        <label>Отчество</label>
        <input type="text" class="form-control" id="patronnynic" placeholder="Отчество" value="" name="patronymic" required>
    </div>
    <div class="form-group">
        <label>Телефон</label>
        <input type="text" class="form-control" id="phone" placeholder="Телефон" value="" name="phone"
               data-role="js-mask-phone" required>
    </div>
    <div class="form-group">
        <label>Email</label>
        <input type="email" class="form-control" id="email" placeholder="Email" value="" name="email" required>
    </div>
    <div class="form-group">
        <label>Адрес доставки</label>
        <input type="text" class="form-control" id="delivery_address" placeholder="Адрес доставки" value=""
               name="delivery_address" required>
    </div>
    <div class="form-group">
        <div class="checkbox simple-checkbox">
            <input type="checkbox" id="personal_data_consent" value="Y" name="personal_data_consent" checked required>
            <label for="personal_data_consent">
                <span>Я согласен на обработку <a target="_blank" href="/coglasie-na-obrabotku-personalnykh-dannykh/">своих персональных данных</a></span>
            </label>
        </div>
    </div>
    <div class="form-group">
        <div class="checkbox simple-checkbox">
            <input type="checkbox" id="contract_accept" placeholder="contract_accept" value="Y" name="contract_accept" checked required>
            <label for="contract_accept" class="wrap">
                <span>Я внимательно ознакомился с <a target="_blank" href="/oferta/">договором оферты</a> и принимаю все его положения:<span class="asterisk">*</span></span>
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
                    <input type="radio" aria-label="Электронный платеж" checked name="paysystem_physic"
                           value="{{ Paysystem::ROBOKASSA }}"/>
                    Электронный платеж
                </label>
                <label class="btn btn-outline-secondary">
                    <input type="radio" aria-label="Сбербанк online" name="paysystem_physic"
                           value="{{ Paysystem::SBERBANK }}"/>
                    Оплата через Сбербанк
                </label>
            </div>
        </div>
    </div>
</form>
