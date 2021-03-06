<div class="container">
    <div class="row justify-content-around">
        <div class="col-xl-8 col-lg-8 col-12 order-3 order-xl-2 order-lg-2">

            @include('magazines.detail.breadcrumbs', compact('journal'))

            <div class="row issue-main">
                <div class="col-xl-4 col-lg-4 col-md-3 col-sm-4 col-12">
                    <div class="issue-cover">
                        <img src="{{ $journal->image }}">
                        <input id="journal" type="hidden" value="{{ $journal->id }}">
                    </div>
                </div>
                <div class="col-xl-8 col-lg-8 col-md-9 col-sm-8 col-12 unit-order-block">
                    <h3>Подписка</h3>
                    <div class="subscribe-form">
                        <div class="row no-gutters form-margin align-items-end mag-art-filter">
                            <div class="d-flex justify-content-start">
                                <div>
                                    <input id="print" type="radio" name="version" value="{{ Subscription::TYPE_PRINTED }}">
                                    <label for="print" class="rightsharp">
                                        <span>Печатная</span>
                                    </label>
                                </div>
                                <div style="margin-left: -1px;">
                                    <input id="electro" type="radio" name="version" value="{{ Subscription::TYPE_ELECTRONIC }}">
                                    <label for="electro" class="leftsharp">
                                        <span>Электронная</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row subscribe-fields">
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 d-flex flex-column justify-content-end">
                                <label>Начало подписки</label>
                                <select id="start_months"></select>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-6 d-flex flex-column justify-content-end">
                                <label>Срок подписки</label>
                                <select id="count_months"></select>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-6 d-flex flex-column justify-content-end">
                                <div class="quantity">
                                    <div class="input-stepper">
                                        <button data-input-stepper="decrease"><span>-</span></button>
                                        <input type="text" id="quantity" value="1" pattern="[0-9]*">
                                        <button data-input-stepper="increase"><span class="plus">+</span></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-xl-end justify-content-lg-end justify-content-md-end justify-content-sm-end justify-content-center mb-24">
                            <span class="price">Итого: <span id="cur_price">0</span> руб.</span>
                            <input type="hidden" id="single_price">
                        </div>
                        <div class="row no-gutters justify-content-xl-end justify-content-lg-end justify-content-md-end justify-content-sm-end justify-content-center flex-xl-row flex-lg-row flex-md-row flex-sm-row flex-column align-items-center">
                            <div class="request">
                                <a href="#" data-toggle="modal" data-target="#abonement-modal">оформить по абонементу</a>
                            </div>
                            <div class="justify-content-center d-flex align-items-center or">
                                <span style="color: #7e8c9f;">или</span>
                            </div>
                            <div><button class="" id="add_2_basket_btn"><span>добавить в корзину</span></button></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-lg-2 col-12 order-2 order-xl-3 order-lg-3">

            @include('includes.sidebar', ['hide' => ['subscribe', 'title']])

        </div>

        @include('includes.sidebar_modals')
    </div>
</div>

<script>
    var SubscribeManager = new JSSubscribeManager('{!! json_encode([
        'prices' => $subscriptions['prices'],
        'monthNames' => [
            1 => __('Январь'),
            2 => __('Февраль'),
            3 => __('Март'),
            4 => __('Апрель'),
            5 => __('Май'),
            6 => __('Июнь'),
            7 => __('Июль'),
            8 => __('Август'),
            9 => __('Сентябрь'),
            10 => __('Октябрь'),
            11 => __('Ноябрь'),
            12 => __('Декабрь')
        ],
        'monthTerms' => [
            1 => '1 месяц',
            2 => '2 месяца',
            3 => '3 месяца',
            4 => '4 месяца',
            5 => '5 месяцев',
            6 => '6 месяцев',
            12 => '12 месяцев'
        ]
    ]) !!}');
    $(document).ready(function () {
        $('#add_2_basket_btn').on('click', function () {
            var version = SubscribeManager.version.filter(':checked').val();
            var quantity = SubscribeManager.quantityInput.val();
            var journal_id = $('input#journal').val();
            var additionalData = {
                'type': version,
                'start_month': SubscribeManager.startMonth.val(),
                'term': SubscribeManager.terms.val(),
                'single_price': SubscribeManager.singlePrice.val(),
                'journal_id': journal_id,
            };
            CartManager.addToCart(version, 'subscription', 0, quantity, additionalData);
        })
    })
</script>

@include('includes.modals.abonement', compact('journal', 'subscriptions'))
