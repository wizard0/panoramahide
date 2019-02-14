<!-- MENU SIDEBAR-->
<aside class="menu-sidebar d-none d-lg-block">
    <div class="admin_logo_container">
        <a class="admin_logo" href="{{ route('admin') }}">
        </a>
    </div>
    <div class="menu-sidebar__content js-scrollbar1">
        <nav class="navbar-sidebar">
            <ul class="list-unstyled navbar__list">
                @foreach(config('admin.menu') as $menu)
                    @if (array_key_exists('sub', $menu))
                        <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-copy"></i>{{ __($menu['name']) }}
                            </a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                @foreach($menu['sub'] as $subMenu)
                                    <li class="{{ (url()->current() == route($subMenu['route'])) ? "active" : ''}}">
                                        <a href="{{ route($subMenu['route']) }}">{{ __($subMenu['name']) }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @else
                        <li  class="{{ (url()->current() == route($menu['route'])) ? 'active' : '' }}">
                            <a class="js-arrow" href="{{ route($menu['route']) }}">
                                <i class="fas fa-tachometer-alt"></i>{{ __($menu['name']) }}</a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </nav>
    </div>
</aside>
<!-- END MENU SIDEBAR-->
