@extends('personal.index')

@section('page-content')
    @if ($id)
        @include('personal.orders.details')
    @else
        @forelse($orders as $order)
            @if ($loop->first)
                <div class="acc-table-wrapper">
                    <div class="acc-table-row acc-table-row-header">
                        <div class="acc-table-item">Заказ</div>
                        <div class="acc-table-item">Состав заказа</div>
                        <div class="acc-table-item">Дата оформления</div>
                        <div class="acc-table-item">Статус</div>
                    </div>
                </div>
            @endif
            <div class="acc-table-row">
                <div class="acc-table-item subscr-table-readmore">
                    <span class="osbold">№</span>{{ $order->id }}<br>
                    <a href="{{ route('personal.order', $order->id) }}">подробнее</a>
                </div>
                <div class="acc-table-item acc-table-item-title">
                    @foreach($order->items as $item)
                        <div class="acc-table-item-unit">
                            <span class="osbold">{{ $item->title }}</span>
                            <div class="ad-type">
                                {{ $item->typeVers }}
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="acc-table-item acc-table-item-duo">
                    {{ $order->date }}
                </div>
                <div class="acc-table-item acc-table-item-duo">
                    <span class="status status-{{ $order->status }}">{{ $order->txtstatus }}</span>
                </div>
                <div class="clear"></div>
            </div>
        @empty
            <p class="cart_empty">Вы пока не оформляли заказов.</p>
        @endforelse
    @endif
@endsection
