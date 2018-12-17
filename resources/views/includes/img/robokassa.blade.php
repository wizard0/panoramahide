<tr>
    <td class="ps_logo">
        <div class="pay_name">Оплата заказа</div>
        <img src="/img/robokassa_logo.jpg" border=0 alt="" width="100" height="100" />					<div class="paysystem_name">Электронный платеж</div><br>
    </td>
</tr>
<tr>
    <td>
        <form action="https://auth.robokassa.ru/Merchant/Index.aspx" method="post" target="_blank">
            <p>{{ $payData->description }}</p>
            <p>Cчет № {{ $order->id }}  {{ $order->createdAt }}</p>
            <p>Сумма к оплате по счету: <strong>{{ $order->totalPrice }} руб.</strong></p>

            <input type="hidden" name="FinalStep" value="1">
            <input type="hidden" name="MrchLogin" value="{{ $payData->login }}">
            <input type="hidden" name="OutSum" value="{{ $order->totalPrice }}">
            <input type="hidden" name="InvId" value="{{ $order->id }}">
            <input type="hidden" name="Desc" value="{{ $order->id }}">
            <input type="hidden" name="SignatureValue" value="{{ $payData->signature }}">
            <input type="hidden" name="IncCurrLabel" value="BankCard">
            <input type="hidden" name="IsTest" value="1">

            <input type="submit" name="Submit" class="btn btn-primary" value="Оплатить">

        </form>
    </td>
</tr>
