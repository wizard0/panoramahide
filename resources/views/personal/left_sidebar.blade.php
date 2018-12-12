<div class="col-xs-12 col-sm-12 col-md-4 col-lg-3 left-sidebar">
    <div class="account-menu">
        <ul>
            <li class="history{{ $active == 'order' ? ' active' : "" }}">
                @if ($active == 'order')
                    Статус заказов
                @else
                    <a href="/personal/order/">Статус заказов</a>
                @endif
            </li>
            <li class="incart{{ $active == 'cart' ? ' active' : "" }}">
                @if ($active == 'cart')
                    Моя корзина
                @else
                    <a href="/personal/cart/">Моя корзина</a>
                @endif
            </li>
            <li class="mysubs{{ $active == 'podpiski' ? ' active' : "" }}">
                @if ($active == 'podpiski')
                    Мои подписки
                @else
                    <a href="/personal/podpiski/">Мои подписки</a>
                @endif
            </li>
            <li class="personal{{ $active == 'profile' ? ' active' : "" }}">
                @if ($active == 'profile')
                    Личные данные
                @else
                    <a href="/personal/profile/">Личные данные</a>
                @endif
            </li>
            <li class="mymags{{ $active == 'my_mags' ? ' active' : "" }}">
                @if ($active == 'my_mags')
                    Мои журналы
                @else
                    <a href="/personal/my_mags/">Мои журналы</a>
                @endif
            </li>
        </ul>
    </div>
</div>
