<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="row">
        <div class="acc-table-wrapper">
            <div class="acc-table-row acc-table-row-header">
                <div class="acc-table-item">Журнал</div>
                <div class="acc-table-item">Описание</div>
                <div class="acc-table-item">Количество</div>
                <div class="acc-table-item">Скидка</div>
                <div class="acc-table-item">Цена</div>
            </div>
            @foreach($orders[0]->items as $item)
                <div class="acc-table-row">
                    <div class="acc-table-item acc-table-item-img">
                        <a href="{{ $item->route }}">
                            <img @if (!$item->image) src="/img/no_photo.png" @else src="{{ $item->image }}" @endif
                                 alt="{{ $item->title }}" title="{{ $item->title }}">
                        </a>
                    </div>
                    <div class="acc-table-item acc-table-item-about">
                        <h4>{{ $item->title }}</h4>
                        <div class="cart-item-subscr-info">
                            <div><span>{{ $item->typeVers }}</span></div>
                            @if($item->start_month)<div><span>Первый месяц:</span><span>{{ $item->start_month }}</span></div>@endif
                        </div>
                        <div class="price"></div>
                    </div>
                    <div class="acc-table-item">
                        <div class="incart-quantity-number">
                            {{ $item->qty }}
                        </div>
                    </div>
                    <div class="acc-table-item">
                        <span class="osbold">0</span>
                    </div>
                    <div class="acc-table-item">
                        <span class="osbold">{{ $item->price * $item->qty }} руб.</span>
                    </div>
                </div>
            @endforeach
            <div class="acc-table-row">
                <div class="acc-table-item">
                </div>
                <div class="acc-table-item">
                    <span class="payment_type_title">Тип оплаты:</span>
                    <span>{{ $orders[0]->paysystem->name }}</span>
                </div>
                <div class="acc-table-item">
                    <div>
                        <span class="status status-{{ $orders[0]->status }}">{{ $orders[0]->txtstatus }}</span>
                    </div>
                </div>
                <div class="acc-table-item">
                    <span class="osbold">Итого</span>
                </div>
                <div class="acc-table-item">
                    <span class="osbold">{{ $orders[0]->totalPrice }} руб. </span>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <table class="sale_order_full_table">
            <tr>
                <td class="ps_logo">
                    <div class="pay_name">Оплата заказа</div>
                    <img src="{{ Storage::url($orders[0]->paysystem->logo) }}" border=0 alt="" width="100" height="100" />
                    <div class="paysystem_name">{{ $orders[0]->paysystem->name }}</div><br>
                </td>
            </tr>
            <tr>
                <td>
                    @include('personal.orders.payment.buttons.' . $orders[0]->paysystem->code, ['payData' => $orders[0]->collectPayData(), 'order' => $orders[0]])
                </td>
            </tr>
        </table>
    </div>
    <div class="form-buttons-holder">
        <button class="btn btn-primary greybtn" onclick="location.href='{{ route('order.cancel', $orders[0]->id) }}'" value="Вернуться к покупкам" style="width:200px">
            Отменить заказ
        </button>
    </div>
</div>
