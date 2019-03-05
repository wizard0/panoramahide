<div class="table-responsive">
    <table class="table __personal __order __details">
        <thead>
        <tr>
            <th>Журнал</th>
            <th>Описание</th>
            <th>Количество</th>
            <th>Скидка</th>
            <th>Цена</th>
        </tr>
        </thead>
        <tbody>
        @foreach($orders->items as $item)
            <tr>
                <td>
                    <a href="{{ $item->route }}">
                        <img src="{{ !$item->image ? asset('img/no_photo.png') : $item->image }}" title="{{ $item->title }}" alt="{{ $item->title }}">
                    </a>
                </td>
                <td>
                    <h4>{{ $item->title }}</h4>
                    <div class="info">
                        <div>
                            <span>{{ $item->typeVers }}</span>
                        </div>
                        @if($item->start_month)
                            <div>
                                <span>Первый месяц:</span>
                                <span>{{ $item->start_month }}</span>
                            </div>
                        @endif
                    </div>
                </td>
                <td class="text-center">
                    {{ $item->qty }}
                </td>
                <td class="text-center">
                    0
                </td>
                <td nowrap>
                    <span class="osbold">{{ $item->price * $item->qty }} руб.</span>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<hr>
<div>
    <div class="text-right" style="font-size: 18px">Итого:&nbsp;<b>{{ $orders->totalPrice }}</b> руб.</div>
</div>
<div>
    <div class="w-100">
        <div class="text-center">
            <span class="payment_type_title">Тип оплаты:</span>
            <span>{{ $orders->paysystem->name }}</span>
        </div>
    </div>
    <table class="sale_order_full_table d-flex justify-content-center text-center w-100">
        <tbody class="__paper mt-3">
        <tr>
            <td class="ps_logo">
                <div class="pay_name">
                    <h4>Оплата заказа</h4>
                </div>
                <img src="{{ Storage::url($orders->paysystem->logo) }}" border=0 alt="" width="100"
                     height="100"/>
                <div class="paysystem_name">{{ $orders->paysystem->name }}</div>
                <br>
            </td>
        </tr>
        <tr>
            <td class="form-payment">
                @include('personal.orders.payment.buttons.' . $orders->paysystem->code, ['payData' => $orders->collectPayData(), 'order' => $orders])
            </td>
        </tr>
        </tbody>
    </table>
    <div class="w-100">
        <div class="text-right" style="margin-top: 10px">
            <a class="btn btn-danger" href="{{ route('order.cancel', $orders->id) }}"
               title="Вернуться к покупкам">
                Отменить заказ
            </a>
        </div>
    </div>
</div>
