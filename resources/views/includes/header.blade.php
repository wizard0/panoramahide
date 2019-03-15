@php
    $categories = \App\Models\Category::has('journals')->where('active', 1)->withTranslation()->get();
@endphp

<div class="header">
    <div class="container">
        <div class="row align-items-center">
            <div class="header_navigation_mobile col-12 d-block d-lg-none">
                <nav class="" role="navigation">
                    <div class="__menu">
                        <button type="button" class="btn --open-toggle-menu">
                            <i class="fa fa-bars" aria-hidden="true"></i>
                        </button>
                        <div id="menu">
                            <ul>
                                <li><a href="/">{{ __('Главная') }}</a></li>
                                <li><a href="{{ route('journals', ['sort_by' => 'name']) }}">{{ __('Журналы по алфавиту') }}</a></li>
                                <li>
                                    <a href="#" class="toggle-button" data-target=".dropdown-flex-menu" data-toggle-next="1">
                                        {{ __('Журналы по темам') }}
                                        <i class="fa fa-chevron-down" aria-hidden="true"></i>
                                    </a>
                                    <ul class="dropdown-flex-menu shadow">
                                        @foreach($categories as $category)
                                            <li>
                                                <a class="d-block grey-link" href="/search/?category={{ $category->id }}&amp;type=journal&amp;extend=1">
                                                    {{ $category->name }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                                <li><a href="/publishers/">Издательства</a></li>
                                <li><a href="/favorites/">Избранное</a></li>
                                <li><a href="/about_system/">О системе</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="__login">
                        @include('includes.auth.login')
                    </div>
                    <div class="__cart">
                        @include('personal.cart.header', [
                            'cart' => Session::has('cart') ? Session::get('cart') : null,
                            'toCart' => true,
                        ])
                    </div>
                </nav>
            </div>
            <div class="header__logo col-10 col-sm-8 col-xl-3 col-lg-3 offset-1 offset-sm-2 offset-md-2 offset-lg-0">
                <div class="logo">
                    <a href="/">
                        <img src="/img/ru/logo.svg"/>
                    </a>
                </div>
            </div>
            <div class="header__phones col-12 col-xl-7 col-lg-6 col-md-8 col-sm-8">
                <div class="row header-phones justify-content-center">
                    <div class="col-xl-auto col-lg-auto col-md-6 col-sm-6 col-12 header-phone">
                        <span>{{ __('Подписка') }}:</span>
                        <p>+7 495 274-22-22, доб.79</p>
                    </div>
                    <div class="col-xl-auto col-lg-auto col-md-6 col-sm-6 col-12 header-phone">
                        <span>{{ __('Телефон для справок') }}:</span>
                        <p>+7 495 274-22-22</p>
                    </div>
                </div>
            </div>

            <div class="header__login col-12 col-xl-2 col-lg-3 col-md-4 col-sm-4 d-none d-sm-block">
                <div class="login">
                    @include('includes.auth.login')
                </div>
                <div class="request">
                    <a class="btn btn-outline-danger" href="#" data-toggle="modal"
                       data-target="#request-modal">{{ __('Заявка на подписку') }}</a>
                </div>
            </div>

            <div class="header__navigation col-12 col-xl-10 col-lg-9 d-none d-lg-block">
                <nav class=" {{-- @todo подозрения, что на js эти классы удаляются, тогда скачет навигация, что недопустимо - navmenu navmenu-fixed-left offcanvas --}}"
                     role="navigation">
                    <ul class="topmenu">
                        <li><a href="{{ route('journals', ['sort_by' => 'name']) }}">{{ __('Журналы по алфавиту') }}</a>
                        </li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" role="button" id="menu_1" data-toggle="dropdown"
                               aria-haspopup="true" aria-expanded="false" href="#">Журналы по темам</a>
                            <div class="dropdown-menu" aria-labelledby="menu_1">
                                <div class="d-flex flex-wrap w-100">
                                    @foreach($categories as $category)
                                        <div class="col-xl-6 col-lg-6 col-12">
                                            <a class="d-block grey-link"
                                               href="/search/?category={{ $category->id }}&amp;type=journal&amp;extend=1">{{ $category->name }}</a>
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
                {{--<div class="hamburger">--}}
                    {{--<a data-toggle="offcanvas" data-target=".navmenu" data-canvas="body"--}}
                       {{--class="d-flex flex-column justify-content-center align-items-center">--}}
                        {{--<span class="icon-bar"></span>--}}
                        {{--<span class="icon-bar"></span>--}}
                        {{--<span class="icon-bar"></span>--}}
                    {{--</a>--}}
                {{--</div>--}}
            </div>
            <div class="header__cart col-12 col-xl-2 col-lg-3 d-none d-lg-block">
                @include('personal.cart.header', ['cart' => Session::has('cart') ? Session::get('cart') : null])
            </div>
        </div>
    </div>
</div>
