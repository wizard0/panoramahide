@component('components.modal', ['id' => 'abonement-modal', 'title' => 'Оформление по абонементу'])
    @slot('body')
        <form role="form" name="rospachat_form" target="_blank" action="{{ route('print.abonement') }}">
            <input type="hidden" name="provider" value="ROSP">
            <input type="hidden" name="element_id" value="{{ $journal->id }}">
            <input type="hidden" name="element_name" value="{{ $journal->name }}">
            <input type="hidden" name="index_rospechat" value="{{ $journal->index_rospechat }}">
            <input type="hidden" name="index_pochta" value="{{ $journal->index_krp }}">
            {{--<input type="hidden" name="rospechat_months"--}}
                   {{--value='{!! json_encode($subscriptions['prices']['printed']) !!}'>--}}
            <div style="font-size: 12px;">
                <p>Распечатайте абонемент и оформите подписку в любом отделении почтовой связи:</p>
                <p>
                </p>
                <ul class="custom-list">
                    <li><span class="glyphicon glyphicon-ok"></span>&nbsp;&nbsp;по каталогу ОАО «Агентство «Роспечать»
                    </li>
                    <li><span class="glyphicon glyphicon-ok"></span>&nbsp;&nbsp;по каталогу российской прессы</li>
                </ul>
                <p></p>
                <p>Цены во всех каталогах одинаковые, поэтому не важно по какому каталогу оформлять подписку на
                    почте.</p>
            </div>
            <div class="row no-gutters form-margin align-items-end mag-art-filter">
                <div class="d-flex justify-content-start">
                    <div>
                        <input id="rosp" type="radio" name="provider" value="ROSP" checked="checked">
                        <label for="rosp" class="rightsharp">
                            <span>Роспечать</span>
                        </label>
                    </div>
                    <div style="margin-left: -1px;">
                        <input id="ruspost" type="radio" name="provider" value="RUSPOST">
                        <label for="ruspost" class="leftsharp">
                            <span>Каталог российской прессы</span>
                        </label>
                    </div>
                </div>
            </div>
            <label>Как вас зовут</label>
            <input type="text" placeholder="ФИО" name="rospechat_fio">
            <label>Индекс</label>
            <input type="text" placeholder="Индекс" name="rospechat_index">
            <label>Адрес</label>
            <input type="text" placeholder="Город, улица, дом, корпус, квартира" name="rospechat_address">
            <div class="quantity">
                <div class="input-stepper">
                    <button type="button" data-input-stepper="decrease"><span>-</span></button>
                    <input type="text" name="rospechat_count" value="1" pattern="[0-9]*">
                    <button type="button" data-input-stepper="increase"><span class="plus">+</span></button>
                </div>
            </div>
            <div class="row no-gutters form-margin align-items-end mag-art-filter">
                <div class="d-flex justify-content-start">
                    <div>
                        <input id="radio-period" type="radio" name="radio-period" checked="">
                        <label for="radio-period">
                            @php
                                $halfyear = date('m') < 6 ? '1' : '2';
                                $year = date('Y');
                            @endphp
                            <span>{{ $halfyear }} полугодие {{ $year }}</span>
                        </label>
                    </div>
                </div>
            </div>
            <div style="text-align: right">
                <input class="btn basic-button" type="submit" name="rospachat_form_button_pdf" value="Сохранить в PDF">
                <input class="btn basic-button" type="submit" name="rospachat_form_button_print" value="Распечатать">
            </div>
        </form>
    @endslot
@endcomponent
