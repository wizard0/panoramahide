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
    $(document).ready(function() {
        $('input[name=person_type]').change(function() {
            if ($(this).val() == 'physical') {
                $('#phys_user_form').show();
                $('#legal_user_form').hide();
            } else {
                $('#legal_user_form').show();
                $('#phys_user_form').hide();
            }
        });
        $('#order_confirm_button').click(function() {
            if ($('input[name=person_type]:checked').val() == 'physical') {
                $('#p_order_form').submit();
            } else {
                $('#l_order_form').submit();
            }
        });
    });
</script>

@endsection
