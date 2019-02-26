@switch($route_name)
    @case('personal.orders')
        Статус заказов
        @break
    @case('personal.cart')
        Моя корзина
        @break
    @case('personal.subscriptions')
        Мои подписки
        @break
    @case('personal.profile')
        Личные данные
        @break
    @case('personal.magazines')
        Мои журналы
        @break
    @default
        Личный кабинет
@endswitch
