    @if (empty($cart))
        <p class="cart_empty">
        В вашей корзине ещё нет товаров.
        </p>
    @else
        <form method="post" action="/personal/cart/" name="basket_form" id="basket_form">
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
                <div id="{{ $item->id }}" class="acc-table-row ">
                    <div class="acc-table-item acc-table-item-img">
                        <a href="">
                            <img
                                    @if (!$item->product->image)
                                    src="/img/no_photo.png"
                                    @else
                                    src="{{ $item->product->image }}"
                                    @endif
                                    title="{{ $item->title }}"
                                    alt="{{ $item->title }}">
                        </a>
                    </div>

                    <div class="acc-table-item acc-table-item-about">
                        <h4>{{ $item->title }}</h4>
                        <div class="cart-item-subscr-info">
                        </div>
                        <div class="price">{{ $item->price }} руб.</div>
                    </div>


                    <div class="acc-table-item">
                        <div class="incart-quantity-number">
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
                        <span class="osbold">0</span>
                    </div>

                    <div class="acc-table-item">
                        <span class="osbold" id="sum_{{ $item->id }}">{{ $item->price * $item->qty }} руб.</span>
                    </div>

                    <div class="acc-table-item">
                        <div class="del-fromcart">
                            <a href="#" data-id="{{ $item->id }}" data-type="{{ $item->type }}" title="Удалить" class="cartItem">
                                <span class="cross deleteFromCart">X</span>
                            </a>
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
               href="{{ route('order.make') }}"
               style="margin-bottom:20px">Оформить заказ<i class="fa fa-arrow-right"></i></a>
            @endif
        </div>


            <input type="hidden" id="column_headers" value="NAME,DISCOUNT,PROPS,DELETE,DELAY,PRICE,QUANTITY,SUM"/>
            <input type="hidden" id="offers_props" value=""/>
            <input type="hidden" id="action_var" value="action"/>
            <input type="hidden" id="quantity_float" value="N"/>
            <input type="hidden" id="count_discount_4_all_quantity"
                   value="N"/>
            <input type="hidden" id="price_vat_show_value"
                   value="Y"/>
            <input type="hidden" id="hide_coupon" value="N"/>
            <input type="hidden" id="coupon_approved" value="N"/>
            <input type="hidden" id="use_prepayment" value="N"/>
            <input type="hidden" name="BasketOrder" value="BasketOrder"/>

            <div class="pull-right"></div>
        </form>
    @endif
