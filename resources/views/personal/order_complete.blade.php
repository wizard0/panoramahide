@extends('layouts.app')

@section('content')
<div class="container">
    <div class="show-results">
        <div class="container">
            <div class="row">

                @include('personal.left_sidebar', ['active' => 'order'])

                <!--Меню личного кабинета-->
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-9 personal-form">
                    <div class="row justify-content-center">
                        <h3 class="text-center text-uppercase section-title">Оформление заказа</h3>
                        <a name="order_form"></a>
                        <NOSCRIPT>
                            <div class="errortext">Для оформления заказа необходимо включить JavaScript. По-видимому, JavaScript либо не поддерживается браузером, либо отключен. Измените настройки браузера и затем <a href="">повторите попытку</a>.</div>
                        </NOSCRIPT>

                        <b>Заказ сформирован</b><br /><br />



                        <table class="sale_order_full_table">
                            <tr>
                                <td>
                                    Ваш заказ <b>№21130</b> от 07.12.2018 15:55:10 успешно создан.				<br /><br />
                                    Вы можете следить за выполнением своего заказа в <a href="/personal/">Персональном разделе сайта</a>. Обратите внимание, что для входа в этот раздел вам необходимо будет ввести логин и пароль пользователя сайта.			</td>
                            </tr>
                        </table>
                        <br /><br />

                        <table class="sale_order_full_table">
                            <tr>
                                <td class="ps_logo">
                                    <div class="pay_name">Оплата заказа</div>
                                    <img src="{{ $order->paysystem->logo }}" border=0 alt="" width="100" height="100" />
                                    <div class="paysystem_name">{{ $order->paysystem->name }}</div><br>
                                </td>
                            </tr>
                            @include('includes.img.' . $order->paysystem->code, compact('payData', 'order'))
                        </table>

                        <div class="form-buttons-holder">
                            <button
                                    type="submit"
                                    class="btn btn-primary greybtn"
                                    onclick="location.href='/magazines/'"
                                    value="Вернуться к покупкам"
                                    style="margin-top: 15px;"
                            >
                                Вернуться к покупкам	</button>
                        </div>
                        <style type="text/css">
                            .has-error input{
                                border: 2px solid #e63201;
                            }
                        </style>				</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
