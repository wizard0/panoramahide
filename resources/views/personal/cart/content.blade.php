@if (empty($cart))
    <p class="cart_empty text-center">
        В вашей корзине ещё нет товаров.
    </p>
@else
    <form method="post" action="/personal/cart/" name="basket_form" id="basket_form">
        <div class="table-responsive">
            <table class="table __personal __cart">
                <thead>
                <tr>
                    <th>Журнал</th>
                    <th>Описание</th>
                    <th>Количество</th>
                    <th>Скидка</th>
                    <th>Цена</th>
                    <th>Удалить</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($cart->items as $item)
                    <tr>
                        <td>
                            <a href="">
                                <img src="{{ !$item->product->image ? asset('img/no_photo.png') : $item->product->image }}" title="{{ $item->title }}" alt="{{ $item->title }}">
                            </a>
                        </td>
                        <td>
                            <h4>{{ $item->title }}</h4>
                            <div class="info"></div>
                            <div class="price">{{ $item->price }} руб.</div>
                        </td>
                        <td class="text-center">
                            <div class="incart-quantity-number">
                                <input type="hidden" id="QUANTITY_{{ $item->id }}"
                                       name="QUANTITY_{{ $item->id }}" value="{{ $item->qty }}"/>
                                <input class="" type="text" id="QUANTITY_INPUT_{{ $item->id }}" name="QUANTITY_INPUT_{{ $item->id }}" maxlength="18" max="99999"
                                       style="max-width: 50px"
                                       value="{{ $item->qty }}"
                                       disabled
                                >

                            </div>
                        </td>
                        <td class="text-center">0</td>
                        <td nowrap>
                            <div id="sum_{{ $item->id }}">{{ $item->price * $item->qty }} руб.</div>
                        </td>
                        <td class="text-center">
                            <a class="btn btn-sm text-danger ajax-link" href="#" action="{{ route('cart.del') }}" data-id="{{ $item->id }}" data-loading="1" title="Удалить"
                               data-callback="cartDeleteItem"
                            >
                                <span class="glyphicon glyphicon-remove"></span>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <hr>
        <div>
            <div class="text-right" id="allSum_FORMATED" style="font-size: 18px">Итого:&nbsp;<b>{{ $cart->totalPrice }}</b> руб.</div>
            @if ($displayCheckout)
                <hr>
                <div class="text-right">
                    <a class="btn btn-primary button-link checkout"
                       title="Оформить заказ"
                       href="{{ route('order.make') }}"
                       style="margin-bottom:20px">
                        Оформить заказ
                        <i class="fa fa-arrow-right"></i>
                    </a>
                </div>

            @endif
        </div>
        {{--
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
                            <img src="{{ !$item->product->image ? asset('img/no_photo.png') : $item->product->image }}" title="{{ $item->title }}" alt="{{ $item->title }}">
                        </a>
                    </div>

                    <div class="acc-table-item acc-table-item-about">
                        <h4>{{ $item->title }}</h4>
                        <div class="cart-item-subscr-info">
                            {{ $item->typeVers }}
                        </div>
                        <div class="price">{{ $item->price }} руб.</div>
                    </div>

                    <div class="acc-table-item">
                        <div class="incart-quantity-number">
                            <input type="hidden" id="QUANTITY_{{ $item->id }}"
                                   name="QUANTITY_{{ $item->id }}" value="{{ $item->qty }}"/>
                            <input class="" type="text" id="QUANTITY_INPUT_{{ $item->id }}" name="QUANTITY_INPUT_{{ $item->id }}" maxlength="18" max="99999"
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
                            <a class="btn btn-sm text-danger ajax-link" href="#" action="{{ route('cart.del') }}" data-id="{{ $item->id }}" data-loading="1" title="Удалить"
                               data-callback="cartDeleteItem"
                            >
                                <span class="glyphicon glyphicon-remove"></span>
                            </a>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
            @endforeach
        </div>
        <hr>
        <div class="cart-footer">
            <div class="cart-total osbold text-right" id="allSum_FORMATED" style="font-size: 18px">Итого:&nbsp;<b>{{ $cart->totalPrice }}</b> руб.</div>
            @if ($displayCheckout)
                <hr>
                <div class="text-right">
                    <a class="btn btn-primary button-link checkout"
                       title="Оформить заказ"
                       href="{{ route('order.make') }}"
                       style="margin-bottom:20px">
                        Оформить заказ
                        <i class="fa fa-arrow-right"></i>
                    </a>
                </div>

            @endif
        </div>
        --}}

        <input type="hidden" id="column_headers" value="NAME,DISCOUNT,PROPS,DELETE,DELAY,PRICE,QUANTITY,SUM"/>
        <input type="hidden" id="offers_props" value=""/>
        <input type="hidden" id="action_var" value="action"/>
        <input type="hidden" id="quantity_float" value="N"/>
        <input type="hidden" id="count_discount_4_all_quantity" value="N"/>
        <input type="hidden" id="price_vat_show_value" value="Y"/>
        <input type="hidden" id="hide_coupon" value="N"/>
        <input type="hidden" id="coupon_approved" value="N"/>
        <input type="hidden" id="use_prepayment" value="N"/>
        <input type="hidden" name="BasketOrder" value="BasketOrder"/>

        <div class="pull-right"></div>
    </form>
@endif
