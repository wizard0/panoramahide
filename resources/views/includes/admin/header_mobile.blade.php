<!-- HEADER MOBILE-->
<header class="header-mobile d-block d-lg-none">
    <div class="header-mobile__bar">
        <div class="container-fluid">
            <div class="header-mobile-inner">
                <a class="admin_logo" href="{{ route('admin') }}">
                </a>
                <button class="hamburger hamburger--slider" type="button">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                </button>
            </div>
        </div>
    </div>
    <nav class="navbar-mobile">
        <div class="container-fluid">
            <ul class="navbar-mobile__list list-unstyled">
            @foreach(config('admin.menu') as $menu)
                @if (is_array($menu) && array_key_exists('sub', $menu))
                    <li class="has-sub">
                        <a href="#">
                            <i class="fas fa-copy">{{ __($menu['name']) }}</i>
                        </a>
                        <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                            @foreach($menu['sub'] as $subMenu)
                                <li>
                                    <a href="{{ route($subMenu['route']) }}">{{ __($subMenu['name']) }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @else
                    <li>
                        <a class="js-arrow" href="{{ route($menu['route']) }}">
                            <i class="fas fa-tachometer-alt"></i>{{ __($menu['name']) }}</a>
                    </li>
                @endif
            @endforeach
            </ul>
        </div>
    </nav>
</header>
<!-- END HEADER MOBILE-->
