@extends('personal.index')

@section('page-content')
<NOSCRIPT>
    <div class="errortext">Для оформления заказа необходимо включить JavaScript.
        По-видимому, JavaScript либо не поддерживается браузером, либо отключен.
        Измените настройки браузера и затем <a href="">повторите попытку</a>.</div>
</NOSCRIPT>
<div class="col-12">
    <div id="order_form_content" class="order-make-holder row justify-content-md-center">
        <div class="col-12 col-lg-8 col-lg-offset-2">
            <div class="text-center">
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <label class="btn btn-outline-secondary active">
                        <input type="radio" name="person_type" value="physical" autocomplete="off" checked>ФИЗИЧЕСКОЕ ЛИЦО</label>
                    <label class="btn btn-outline-secondary">
                        <input type="radio" name="person_type" value="legal" autocomplete="off">ЮРИДИЧЕСКОЕ ЛИЦО</label>
                </div>
            </div>
            <div id="phys_user_form">
                @include('personal.orders.form_phys')
            </div>
            <div id="legal_user_form" style="display: none">
                @include('personal.orders.form_legal')
            </div>
        </div>
    </div>
    <hr>
    <div class="form-buttons-holder text-center">
        <button id="order_confirm_button" class="btn btn-primary" value="Оплатить">Оформить заказ</button>
        <button class="btn btn-light" onclick="location.href='{{ route('journals') }}'" value="Вернуться к покупкам">Вернуться к покупкам</button>
    </div>
</div>

<script type="text/javascript">
    function validateEmail(email) {
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    }
    $(document).ready(function() {
        $('input[name=person_type]').change(function() {
            $('#phys_user_form').toggle();
            $('#legal_user_form').toggle();
        });

        $('#order_confirm_button').click(function() {
            $('.is-danger').removeClass('is-danger');
            let result = true;
            let form = 'l_order_form';
            let fields = ['org_name', 'l_surname', 'l_name', 'l_patronymic', 'l_phone', 'l_email', 'l_personal_data_consent', 'l_contract_accept'];
            if ($('input[name=person_type]:checked').val() == 'physical') {
                form = 'p_order_form';
                fields = ['surname','name','patronymic','phone','email','personal_data_consent','contract_accept'];
            }

            $('#' + form).find(':input').each(function() {
                if (this.hasAttribute('required')) {
                    if ($(this).attr('type') == 'checkbox' && !$(this).is(':checked')) {
                        $(this).addClass('is-danger');
                        result = false;
                    } else if ((($(this).attr('name') == 'phone' || $(this).attr('name') == 'l_phone') && $(this).val().length != 18) ||
                               (($(this).attr('name') == 'email' || $(this).attr('name') == 'l_email') && !validateEmail($(this).val())) || $(this).val() == '') {
                        $(this).addClass('is-danger');
                        result = false;
                    }
                }
            });

            if (result) {
                $('#' + form).submit();
            }
        });
    });
</script>

@endsection
