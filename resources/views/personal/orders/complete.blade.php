@extends('personal.index')

@section('page-content')
    <NOSCRIPT>
        <div class="errortext">Для оформления заказа необходимо включить JavaScript. По-видимому, JavaScript либо не поддерживается браузером, либо отключен. Измените настройки браузера и затем <a href="">повторите попытку</a>.</div>
    </NOSCRIPT>
    <div class="back-personal-button">
        <a href="{{ route('personal.orders') }}" class="btn btn-light" title="Вернуться к покупкам">
            <span class="glyphicon glyphicon-chevron-left"></span>
            Вернуться к покупкам
        </a>
    </div>
    <table class="sale_order_full_table mt-3">
        <tr>
            <td>
                <p class="text-center">
                    Ваш заказ <b>№{{ $order->id }}</b> от {{ \Carbon\Carbon::parse($order->created_at)->format('d.m.Y')}} успешно создан.
                </p>
                Вы можете следить за выполнением своего заказа в <a href="{{ route('personal.orders') }}">Персональном разделе сайта</a>. Обратите внимание, что для входа в этот раздел вам необходимо будет ввести логин и пароль пользователя сайта.
            </td>
        </tr>
    </table>
    <table class="sale_order_full_table d-flex justify-content-center text-center">
        <tbody class="__paper mt-3">
        <tr>
            <td class="ps_logo">
                <div class="pay_name">
                    <h4>Оплата заказа</h4>
                </div>
                <img src="{{ Storage::url($order->paysystem->logo) }}" border=0 alt="" width="100" height="100" />
                <div class="paysystem_name">{{ $order->paysystem->name }}</div><br>
            </td>
        </tr>
        <tr>
            <td class="form-payment">
                @include('personal.orders.payment.buttons.' . $order->paysystem->code, compact('payData', 'order'))
            </td>
        </tr>
        </tbody>
    </table>
@endsection
