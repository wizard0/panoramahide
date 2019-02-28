@extends('layouts.app')

@section('breadcrumbs-content')
    <li>
        <a href="/">Главная</a>
    </li>
    @if($route_name !== 'personal')
        <li>
            <a href="{{ route('personal') }}">Личный кабинет</a>
        </li>
    @endif
    <li class="active">
        @include('personal.title')
    </li>
@endsection

@section('content')
    <div class="content">
        @include('includes.breadcrumbs')
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-3 left-sidebar">
                    <div class="account-menu">
                        <ul>
                            <li class="history @if($route_name === 'personal.orders') active @endif">
                                <a href="{{ route('personal.orders') }}">Статус заказов</a>
                            </li>
                            <li class="incart @if($route_name === 'personal.cart') active @endif">
                                <a href="{{ route('personal.cart') }}">Моя корзина</a>
                            </li>
                            <li class="mysubs @if($route_name === 'personal.subscriptions') active @endif">
                                <a href="{{ route('personal.subscriptions') }}">Мои подписки</a>
                            </li>
                            <li class="personal @if($route_name === 'personal.profile') active @endif">
                                <a href="{{ route('personal.profile') }}">Личные данные</a>
                            </li>
                            <li class="mymags @if($route_name === 'personal.magazines') active @endif">
                                <a href="{{ route('personal.magazines') }}">Мои журналы</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-9 __paper">
                    <h3 class="text-center text-uppercase section-title personal-title">@include('personal.title')</h3>
                    <div id="{!! str_replace('.', '-', $route_name) !!}-content" class="personal-content">
                        @if($route_name !== 'personal')
                            @yield('page-content')
                        @else
                            <p>В личном кабинете Вы можете проверить текущее состояние корзины, ход выполнения Ваших заказов, просмотреть или изменить личную информацию, а также подписаться на новости и другие информационные рассылки.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
