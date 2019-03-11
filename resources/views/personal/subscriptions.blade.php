@extends('personal.index')

@section('page-content')
    @if(count($subscriptions) !== 0)
        <div class="table-responsive">
            <table class="table __personal __subscriptions">
                <thead>
                <tr>
                    <th>
                        <a href="{{ route('personal.subscriptions', $sort) }}">
                            Вид
                            <i class="fa fa-sort" aria-hidden="true"></i>
                        </a>
                    </th>
                    <th>Название журнала</th>
                    <th>Начало подписки</th>
                    <th>Период</th>
                </tr>
                </thead>
                <tbody>
                @foreach($subscriptions as $subscription)
                    <tr>
                        <td>
                            {{ $subscription->getType() }}
                        </td>
                        <td>
                            {{ $subscription->journal->name }}<br>
                            @if($subscription->type === Subscription::TYPE_ELECTRONIC)
                                <a href="{{ route('subscriptions.releases', $subscription->id) }}"
                                   class="info">Выпуски</a>
                            @endif
                        </td>
                        <td>
                            {{ $subscription->getBegin() }} г.
                        </td>
                        <td>
                            {{ $subscription->term }} мес.<br>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="cart_empty">У вас нет оплаченных подписок.</p>
    @endif
@endsection
