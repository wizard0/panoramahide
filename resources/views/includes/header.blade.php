@php
$categories = \App\Category::has('journals')->where('active', 1)->withTranslation()->get();
@endphp

<div class="header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-8 offset-xl-0 offset-lg-0 offset-md-2 offset-sm-1 offset-2 order-4 order-xl-1 order-lg-1 order-md-2 order-sm-2">
                <div class="logo">
                    <a href="/">
                        <img src="/img/ru/logo.svg"/>
                    </a>
                </div>
            </div>
            <div class="col-xl-7 col-lg-7 col-md-8 col-sm-8 order-5 order-xl-2 order-lg-2 order-md-4 order-sm-4">
                <div class="row header-phones justify-content-center">
                    <div class="col-xl-auto col-lg-auto col-md-6 col-sm-6 col-6 header-phone">
                        <span>{{ __('Подписка') }}:</span>
                        <p>+7 495 274-22-22, доб.79</p>
                    </div>
                    <div class="col-xl-auto col-lg-auto col-md-6 col-sm-6 col-6 header-phone">
                        <span>{{ __('Телефон для справок') }}:</span>
                        <p>+7 495 274-22-22</p>
                    </div>
                </div>
            </div>

            <div class="d-flex flex-column align-items-center col-xl-2 col-lg-2 col-md-4 col-sm-4 col-8 order-2 order-xl-3 order-lg-3 order-md-5 order-sm-5">
                <div class="login">
                    @if (Auth::check())
                        <a class="grey-link" href="/personal/">{{ __('Личный кабинет') }}</a>
                        /
                        <a class="grey-link" href="/logout">{{ __('Выйти') }}</a>
                    @else
                        <a href="#" class="grey-link" data-toggle="modal" data-target="#login-modal">{{ __('Войти') }}</a>
                        /
                        <a href="#" class="grey-link" data-toggle="modal" data-target="#registration-modal">{{ __('Регистрация') }}</a>
                    @endif
                </div>
                <div class="request"><a href="#" data-toggle="modal" data-target="#request-modal">{{ __('Заявка на подписку') }}</a></div>
            </div>

            <div class="col-xl-10 col-lg-10 col-md-2 col-sm-2 col-2 order-1 order-sm-1 order-xl-4 order-lg-4 order-md-1">
                <nav class="navmenu navmenu-fixed-left offcanvas" role="navigation">
                    <ul class="topmenu">
                        <li><a href="{{ route('journals', ['sort_by' => 'name']) }}">{{ __('Журналы по алфавиту') }}</a></li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" role="button" id="menu_1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#">Журналы по темам</a>
                            <div class="dropdown-menu" aria-labelledby="menu_1">
                                <div class="d-flex flex-wrap w-100">
                                    @foreach($categories as $category)
                                    <div class="col-xl-6 col-lg-6 col-12">
                                        <a class="d-block grey-link" href="/search/?category={{ $category->id }}&amp;type=journal&amp;extend=1">{{ $category->name }}</a>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </li>
                        <li><a href="/publishers/">Издательства</a></li>
                        <li><a href="/favorites/">Избранное</a></li>
                        <li><a href="/about_system/">О системе</a></li>
                    </ul>
                </nav>
                <div class="hamburger">
                    <a data-toggle="offcanvas" data-target=".navmenu" data-canvas="body" class="d-flex flex-column justify-content-center align-items-center">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                </div>
            </div>
            <div class="d-flex col-xl-2 col-lg-2 col-md-2 col-sm-2 col-2 order-sm-3 order-3 order-xl-5 order-lg-5 order-md-3 offset-sm-1 offset-xl-0 offset-lg-0 offset-md-2 justify-content-xl-center justify-content-lg-center justify-content-end">
                @include('personal.cart.header', ['cart' => Session::has('cart') ? Session::get('cart') : null])
            </div>
        </div>
    </div>
</div>
