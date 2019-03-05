@extends('personal.index')

@section('page-content')
    @forelse($subscriptions as $subscription)
        @if ($loop->first)
            <table class="table __personal __subscriptions">
                <thead>
                    <tr>
                        <th><a href="{{ route('personal.subscriptions', $sort) }}">Вид</a></th>
                        <th>Название журнала</th>
                        <th>Начало подписки</th>
                        <th>Периуд</th>
                    </tr>
                </thead>
        @endif
            <tr>
                <td>
                    {{ $subscription->getType() }}
                </td>
                <td>
                    {{ $subscription->journal->name }}<br>
                    @if($subscription->type === Subscription::TYPE_ELECTRONIC)
                        <a href="{{ route('subscriptions.releases', $subscription->id) }}" class="info">Выпуски</a>
                    @endif
                </td>
                <td>
                    {{ $subscription->getBegin() }} г.
                </td>
                <td>
                    {{ $subscription->term }} мес.<br>
                </td>
            </tr>
        @if($loop->last)
            </table>
        @endif
    @empty
        <p class="cart_empty">У вас нет оплаченных подписок.</p>
    @endforelse
@endsection
