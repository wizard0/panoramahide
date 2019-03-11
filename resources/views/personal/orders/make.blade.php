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
            <div id="legal_user_form" class="hidden">
                @include('personal.orders.form_legal')
            </div>
        </div>
    </div>
    <hr>
    <div class="form-buttons-holder text-center">
        <button class="btn btn-primary" id="order_confirm_button" value="Оплатить">Оформить заказ</button>
        <button class="btn btn-light" onclick="location.href='{{ route('journals') }}'" value="Вернуться к покупкам">Вернуться к покупкам</button>
    </div>
</div>
@endsection
