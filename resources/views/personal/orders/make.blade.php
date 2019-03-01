@extends('personal.index')

@section('page-content')
<NOSCRIPT>
    <div class="errortext">Для оформления заказа необходимо включить JavaScript.
        По-видимому, JavaScript либо не поддерживается браузером, либо отключен.
        Измените настройки браузера и затем <a href="">повторите попытку</a>.</div>
</NOSCRIPT>
<div class="col-12">
    <div id="order_form_content" class="order-make-holder row justify-content-center">
            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                <label class="btn btn-outline-secondary active">
                <input type="radio" name="person_type" value="physical" autocomplete="off" checked>ФИЗИЧЕСКОЕ ЛИЦО</label>
                <label class="btn btn-outline-secondary">
                <input type="radio" name="person_type" value="legal" autocomplete="off">ЮРИДИЧЕСКОЕ ЛИЦО</label>
            </div>
        <div id="phys_user_form">
            @include('personal.orders.form_phys')
        </div>
        <div id="legal_user_form" style="display: none">
            @include('personal.orders.form_legal')
        </div>
    </div>
</div>


<div class="form-buttons-holder">
    <button id="order_confirm_button" class="btn btn-primary" value="Оплатить" style="width:200px">Оформить заказ</button>
    <button class="btn btn-primary greybtn" onclick="location.href='{{ route('journals') }}'" value="Вернуться к покупкам" style="width:200px">Вернуться к покупкам</button>
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
            $.each( fields, function( key, value ) {
                let field = $('input[name=' + value + ']')
                if (field.attr('type') == 'checkbox' && !field.is(':checked')) {
                    field.addClass('is-danger');
                    result = false;
                } else if (((value == 'phone' || value == 'l_phone') && field.val().length != 18) ||
                           ((value == 'email' || value == 'l_email') && !validateEmail(field.val())) || field.val() == '') {
                    field.addClass('is-danger');
                    result = false;
                }

            });
            if (result) {
                $('#' + form).submit();
            }
        });
    });
</script>

@endsection
