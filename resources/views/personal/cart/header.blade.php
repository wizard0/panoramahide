<div class="cart-holder" id="cart-in-header">
    <ul>
        <li class="dropdown">
            <a class="dropdown-toggle"
               @if (Auth::check())
                   @if($cart)
                   href="#" role="button" id="dropdownMenuLink3" data-toggle="dropdown" aria-haspopup="true"
                   aria-expanded="false"
                   @else
                   href="{{ route('personal.cart') }}"
                   @endif
               @else
               href="#" data-toggle="modal" data-target="#login-modal"
               @endif
            >
                <span>Корзина</span>
            </a>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink3">
                <div id="basket_html">
                    @if ($cart)
                        @foreach ($cart->items as $key => $item)
                            @continue($loop->iteration > 3)
                            <div class="cartItem __basket" data-id="{{ $item->product->id }}"
                                 data-type="{{ $item->type }}">
                                <div>
                                    <div class="__title" style="font-size: 14px;">
                                        <a href="{{ $item->product->getLink() }}"
                                           style="background: none; padding-left: 0;">
                                            {{ $item->product->name }}
                                        </a>
                                    </div>
                                    <div class="__type">{{ $item->version == Cart::VERSION_ELECTRONIC ? 'Электронный выпуск' : 'Печатный выпуск' }}</div>
                                    <div class="__price">
                                        <span>{{ $item->qty }}</span>
                                        <span>×</span>
                                        <span>{{ $item->price * $item->qty }}</span>
                                        <span>RUB</span>
                                    </div>
                                </div>
                                <div>
                                    <div class="__delete">
                                        <a class="btn btn-sm text-danger ajax-link" href="#"
                                           action="{{ route('cart.del') }}" data-id="{{ $item->id }}" data-loading="1"
                                           title="Удалить"
                                           data-callback="cartDeleteItem"
                                        >
                                            <span class="glyphicon glyphicon-remove"></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @if(count($cart->items) > 3)
                            <div class="cartItem __more" class="text-center w-100">
                                И еще {{ count($cart->items) - 3 }}
                            </div>
                        @endif
                    @endif
                    <div class="text-center w-100">
                        <a href="{{ route('personal.cart') }}">
                            Перейти в мою корзину
                        </a>
                    </div>
                </div>
            </div>
        </li>
    </ul>
    <div id="count_in_basket" class="purchase-number" style="width: 13px;">
        <span>{{ $cart ? $cart->totalQty : "" }}</span>
    </div>
</div>
