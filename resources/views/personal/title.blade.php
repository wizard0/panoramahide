@switch($route_name)
    @case('personal.orders')
        Статус заказов
        @break
    @case('personal.order')
        Заказ №{{ $id }}
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
    @case('order.make')
        Оформление заказа
        @break
    @case('order.complete')
        Заказ сформирован
        @break
    @default
        Личный кабинет
@endswitch
