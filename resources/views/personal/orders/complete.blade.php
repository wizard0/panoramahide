@extends('personal.index')

@section('page-content')
    <NOSCRIPT>
        <div class="errortext">Для оформления заказа необходимо включить JavaScript. По-видимому, JavaScript либо не поддерживается браузером, либо отключен. Измените настройки браузера и затем <a href="">повторите попытку</a>.</div>
    </NOSCRIPT>
    <table class="sale_order_full_table">
        <tr>
            <td>
                Ваш заказ <b>№{{ $order->id }}</b> от 07.12.2018 {{ $order->created_att }} успешно создан.<br /><br />
                Вы можете следить за выполнением своего заказа в <a href="{{ route('personal.orders') }}">Персональном разделе сайта</a>. Обратите внимание, что для входа в этот раздел вам необходимо будет ввести логин и пароль пользователя сайта.
            </td>
        </tr>
    </table>
    <br /><br />
    <table class="sale_order_full_table">
        <tr>
            <td class="ps_logo">
                <div class="pay_name">Оплата заказа</div>
                <img src="{{ Storage::url($order->paysystem->logo) }}" border=0 alt="" width="100" height="100" />
                <div class="paysystem_name">{{ $order->paysystem->name }}</div><br>
            </td>
        </tr>
        <tr>
            <td>
                @include('personal.orders.payment.buttons.' . $order->paysystem->code, compact('payData', 'order'))
            </td>
        </tr>
    </table>
    <div class="form-buttons-holder">
        <button class="btn btn-primary greybtn" onclick="location.href='{{ route('journals') }}'" value="Вернуться к покупкам" style="width:200px">
            Вернуться к покупкам
        </button>
    </div>
@endsection
