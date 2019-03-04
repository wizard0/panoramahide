@extends('personal.index')

@section('page-content')
    @if ($id)
        <div class="back-personal-button">
            <a href="{{ route('personal.orders') }}" class="btn btn-light" title="Вернуться к заказам">
                <span class="glyphicon glyphicon-chevron-left"></span>
                Вернуться к заказам
            </a>
        </div>
        @include('personal.orders.details')
    @else
        @if(count($orders) !== 0)
            <div class="table-responsive">
                <table class="table __personal __orders">
                    <thead>
                    <tr>
                        <th>Заказ</th>
                        <th>Состав заказа</th>
                        <th>Дата оформления</th>
                        <th>Статус</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>
                                №{{ $order->id }}<br>
                                <a href="{{ route('personal.order', $order->id) }}" class="info">подробнее</a>
                            </td>
                            <td>
                                @foreach($order->items as $item)
                                    <div class="list-item">
                                        {{ $item->title }}
                                        <div class="info">
                                            {{ $item->typeVers }}
                                        </div>
                                    </div>
                                @endforeach
                            </td>
                            <td>
                                {{ $order->date }}
                            </td>
                            <td>
                                <span class="status status-{{ $order->status }}">{{ $order->txtstatus }}</span>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="cart_empty">Вы пока не оформляли заказов.</p>
        @endif
    @endif
@endsection
