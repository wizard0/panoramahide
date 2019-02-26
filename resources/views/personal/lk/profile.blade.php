@extends('personal.index')

@section('page-content')
    <!--div class="profile-legend">
        <span class="grblue">Дата обновления:<span class="osital">26.02.2019 13:47:51</span></span>
        <span class="grblue">Последняя авторизация:<span class="osital">26.02.2019 14:05:08</span></span>
    </div-->
    <form action="{{ route('personal.profile') }}" class="ajax-form" enctype="multipart/form-data" method="post">
        <div class="form-container">
            <div class="form-wrapper">
                <div class="form-row">
                    <div class="form-label">Обращение:</div>
                    <div class="form-holder"><input type="text" class="form-field" name="title" value="{{ $user->title }}" placeholder="Как к вам обращаться?"></div>
                </div>

                <div class="form-row">
                    <div class="form-label">Имя:</div>
                    <div class="form-holder"><input type="text" class="form-field" name="name" value="{{ $user->name }}" placeholder="Ваше имя"></div>
                </div>

                <div class="form-row">
                    <div class="form-label">Фамилия:</div>
                    <div class="form-holder"><input type="text" class="form-field" name="last_name" placeholder="Фамилия" value="{{ $user->last_name }}"></div>
                </div>

                <div class="form-row">
                    <div class="form-label">Отчество:</div>
                    <div class="form-holder"><input type="text" class="form-field" name="second_name" value="{{ $user->second_name }}" placeholder="Отчество"></div>
                </div>

                <div class="form-row">
                    <div class="form-label">Email:</div>
                    <div class="form-holder"><input type="email" class="form-field" readonly value="{{ $user->email }}" placeholder="Email"></div>
                </div>


                <div class="form-row">
                    <div class="form-label">Страна:</div>
                    <div class="form-holder">
                        <select class="form-control" name="country" placeholder="Выберите страну из списка">
                            <option value="1"  @if($user->country == 1) selected @endif >Россия</option>
                            <option value="14" @if($user->country == 14)selected @endif >Украина</option>
                            <option value="4"  @if($user->country == 4) selected @endif >Белоруссия</option>
                            <option value="6"  @if($user->country == 6) selected @endif >Казахстан</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-label">О себе:</div>
                    <div class="form-holder"><textarea name="notes" class="form-control">{{ $user->notes }}</textarea></div>
                </div>

                <div class="form-row">
                    <div class="form-label">Дата рождения</div>
                    <div class="form-holder">
                        <div class="input-group date" id="datetimepicker">
                            <input type="text" name="birthday" class="form-control" value="">
                            <span class="input-group-addon">
                                <span class="glyphicon-calendar glyphicon"></span>
                            </span>
                       </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-label">Пол:</div>
                    <div class="form-holder">
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-outline-secondary @if($user->gender == 1) active @endif ">
                            <input type="radio" name="gender" @if($user->gender == 1) checked @endif value="1" autocomplete="off">Женский</label>
                            <label class="btn btn-outline-secondary @if($user->gender == 2) active @endif ">
                            <input type="radio" name="gender" @if($user->gender == 2) checked @endif value="2" autocomplete="off">Мужской</label>
                        </div>
                    </div>
                 </div>


                <div class="form-row">
                    <div class="form-label"></div>
                    <div class="form-holder">
                        <div class="checkbox simple-checkbox">
                            <input type="checkbox" name="agree" value="1" id="agree" @if( $user->agree ) checked @endif>
                            <label for="agree"><span>Согласен получать рассылку</span></label>
                        </div>
                    </div>
                </div>


                <div class="form-row">
                    <div class="form-label">Предпочитаемые версии журнала:</div>
                    <div class="form-holder">
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-outline-secondary @if( $user->version === Cart::VERSION_PRINTED) active @endif">
                            <input type="radio" name="version" value="{{ Cart::VERSION_PRINTED }}" autocomplete="off" @if( $user->version == Cart::VERSION_PRINTED) checked @endif>Печатный</label>
                            <label class="btn btn-outline-secondary @if( $user->version === Cart::VERSION_ELECTRONIC) active @endif">
                            <input type="radio" name="version" value="{{ Cart::VERSION_ELECTRONIC }}" autocomplete="off" @if( $user->version == Cart::VERSION_PRINTED) checked @endif>Электронный</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-buttons-holder">
            <button type="submit" class="btn inner-form-submit">
                <span>Зарегистрироваться</span>
            </button>
            <button class="btn btn-primary greybtn" onClick="window.location.reload()">
                <span>Отменить</span>
            </button>
        </div>
    </form>
    <script type="text/javascript">
        $(function () {
            $('#datetimepicker').datetimepicker();
        });
    </script>
@endsection
