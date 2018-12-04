@extends('layouts.app')

@section('content')
<div class="container"><div class="container show-results">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-3 left-sidebar">
                <div class="account-menu">
                    <ul>
                        <li class="history"><a href="/personal/order/">Статус заказов</a></li>
                        <li class="incart active">Моя корзина</li>
                        <li class="mysubs"><a href="/personal/podpiski/">Мои подписки</a></li>
                        <li class="personal"><a href="/personal/profile/">Личные данные</a></li>
                        <li class="mymags"><a href="/personal/my_mags/">Мои журналы</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-9">
                <h3 class="text-center text-uppercase section-title">Корзина</h3>
                @if (!$cart)
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
                        <div id="{{ $item['id'] }}" class="acc-table-row">
                            <div class="acc-table-item acc-table-item-img">
                                <a href="">
                                    <img
                                            @if (!$item['product']->image)
                                            src="/img/no_photo.png"
                                            @else
                                            src="{{ $item['product']->translate('en')->image }}"
                                            @endif
                                            title="{{ $item['product']->name }}"
                                            alt="{{ $item['product']->name }}">
                                </a>
                            </div>

                            <div class="acc-table-item acc-table-item-about">
                                <h4>{{ $item['product']->name }}</h4>
                                <div class="cart-item-subscr-info">
                                </div>
                                <div class="price">{{ $item['price'] }} руб.</div>
                            </div>


                            <div class="acc-table-item">
                                <div class="incart-quantity-number">
                                    <span class="subs-legend">Количество:&nbsp;</span>
                                    <input type="hidden" id="QUANTITY_{{ $item['id'] }}"
                                           name="QUANTITY_{{ $item['id'] }}" value="{{ $item['qty'] }}"/>
                                    <input
                                            class=""
                                            type="text"
                                            id="QUANTITY_INPUT_{{ $item['id'] }}"
                                            name="QUANTITY_INPUT_{{ $item['id'] }}"
                                            maxlength="18"
                                            max="99999"
                                            style="max-width: 50px"
                                            value="{{ $item['qty'] }}"
                                            disabled
                                    >

                                </div>
                            </div>

                            <div class="acc-table-item">
                                <span class="subs-legend">Скидка:&nbsp;</span>
                                <span class="osbold">0</span>
                            </div>

                            <div class="acc-table-item">
                                <span class="osbold" id="sum_{{ $item['id'] }}">{{ $item['price'] * $item['qty'] }} руб.</span>
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
                        <br/ >

                        <a class="btn btn-primary button-link checkout"
                           title="checkout"
                           href="javascript:void(0)" onclick=""
                           style="margin-bottom:20px">Оформить заказ<i class="fa fa-arrow-right"></i> </a>
                    </div>

                    <input type="hidden" id="column_headers"
                           value="NAME,DISCOUNT,PROPS,DELETE,DELAY,PRICE,QUANTITY,SUM"/>
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
            </div>
        </div>
    </div>
</div>
@endsection
