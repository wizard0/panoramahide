<div class="acc-table-wrapper">
    <div class="acc-table-row acc-table-row-header">
        <div class="acc-table-item">Журнал</div>
        <div class="acc-table-item">Описание</div>
        <div class="acc-table-item">Количество</div>
        <div class="acc-table-item">Скидка</div>
        <div class="acc-table-item">Цена</div>
        <div class="acc-table-item">Удалить</div>
    </div>

    @foreach ($cart->items as $item)
        @php
            $title = $item->product->name;
            if ($item->type == Cart::PRODUCT_TYPE_RELEASE) {
                $title = $item->product->journal->name . ' №' . $item->product->number . '. ' . $item->product->year;
            }
        @endphp
        <div id="{{ $item->id }}" class="acc-table-row">
            <div class="acc-table-item acc-table-item-img">
                <a href="">
                    <img
                            @if (!$item->product->image)
                            src="/img/no_photo.png"
                            @else
                            src="{{ $item->product->image }}"
                            @endif
                            title="{{ $title }}"
                            alt="{{ $title }}">
                </a>
            </div>

            <div class="acc-table-item acc-table-item-about">
                <h4>{{ $title }}</h4>
                <div class="cart-item-subscr-info">
                </div>
                <div class="price">{{ $item->price }} руб.</div>
            </div>


            <div class="acc-table-item">
                <div class="incart-quantity-number">
                    <span class="subs-legend">Количество:&nbsp;</span>
                    <input type="hidden" id="QUANTITY_{{ $item->id }}"
                           name="QUANTITY_{{ $item->id }}" value="{{ $item->qty }}"/>
                    <input
                            class=""
                            type="text"
                            id="QUANTITY_INPUT_{{ $item->id }}"
                            name="QUANTITY_INPUT_{{ $item->id }}"
                            maxlength="18"
                            max="99999"
                            style="max-width: 50px"
                            value="{{ $item->qty }}"
                            disabled
                    >

                </div>
            </div>

            <div class="acc-table-item">
                <span class="subs-legend">Скидка:&nbsp;</span>
                <span class="osbold">0</span>
            </div>

            <div class="acc-table-item">
                <span class="osbold" id="sum_{{ $item->id }}">{{ $item->price * $item->qty }} руб.</span>
            </div>

            <div class="acc-table-item">
                <div class="del-fromcart">
                    <a href="/personal/cart/?action=delete&id=7429"
                       data-itemid="7429" title="Удалить"><span class="cross"></span></a>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    @endforeach
</div>
<div class="cart-footer">
    <div class="cart-total osbold" id="allSum_FORMATED">Итого:&nbsp;{{ $cart->totalPrice }} руб.</div>
    <br />

    @if ($displayCheckout)
    <a class="btn btn-primary button-link checkout"
       title="checkout"
       href="{{ route('order.make') }}" onclick=""
       style="margin-bottom:20px">Оформить заказ<i class="fa fa-arrow-right"></i> </a>
    @endif
</div>
