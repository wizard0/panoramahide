<div class="cart-holder" id="cart-in-header">
    <ul>
        <li class="dropdown">
            <a class="dropdown-toggle" role="button" id="dropdownMenuLink3" href="/personal/cart/"><span>Корзина</span></a>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink3">
                <div class="d-flex flex-wrap w-100" id="basket_html">
                    @if ($cart)
                    @foreach ($cart->items as $item)
                    <div class="row form-group col-12 _basket"
                         data-id="{{ $item['product']->id }}"
                         data-type="{{ $item['type'] }}">
                        <div class="col-11">
                            <div style="font-size: 14px;">
                                <a href="{{ $item['product']->getUrl() }}" style="background: none; padding-left: 0;">
                                    {{ $item['product']->name }}
                                </a>
                            </div>
                            @if ($item['version'] == Cart::VERSION_ELECTRONIC)
                                <div style="font-size: 12px;">Электронный выпуск</div>
                            @else
                                <div style="font-size: 12px;">Электронный выпуск</div>
                            @endif
                            <div style="font-size: 14px;">
                                <span>{{ $item['qty'] }}</span>
                                <span>×</span>
                                <span>{{ $item['price'] * $item['qty'] }}</span>
                                <span>RUB</span>
                            </div>
                        </div>
                        <div class="col-1">
                            <button class="close _delete_basket" title="">×</button>
                        </div>
                    </div>
                    @endforeach
                    @endif
            </div>
        </li>
    </ul>
    <div id="count_in_basket" class="purchase-number" style="width: 13px;"><span>{{ $cart->totalQty }}</span></div>
</div>
