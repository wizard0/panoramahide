@extends('layouts.app')

@section('content')
<div class="container"><div class="container show-results">
        <div class="row">

            @include('personal.left_sidebar', ['active' => 'cart'])

            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-9">
                <h3 class="text-center text-uppercase section-title">Корзина</h3>
                @if (!$cart)
                    <p class="cart_empty">
                    В вашей корзине ещё нет товаров.
                    </p>
                @else
                <form method="post" action="/personal/cart/" name="basket_form" id="basket_form">

                    @include('personal.cart_content', ['cart' => $cart, 'displayCheckout' => true])

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
