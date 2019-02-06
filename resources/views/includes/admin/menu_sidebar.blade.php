<!-- MENU SIDEBAR-->
<aside class="menu-sidebar d-none d-lg-block">
    <div class="logo">
        <a href="#">
            <img src="/images/icon/logo.png" alt="Cool Admin" />
        </a>
    </div>
    <div class="menu-sidebar__content js-scrollbar1">
        <nav class="navbar-sidebar">
            <ul class="list-unstyled navbar__list">
                <li class="active">
                    <a class="js-arrow" href="#">
                        <i class="fas fa-tachometer-alt"></i>{{ __('admin.dashboard') }}</a>
                </li>
                <li class="has-sub">
                    <a class="js-arrow" href="#">
                        <i class="fas fa-copy">{{ __('admin.content management') }}</i>
                    </a>
                    <ul class="list-unstyled navbar__sub-list js-sub-list">
                        @include('includes.admin.content_management_menu')
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>
<!-- END MENU SIDEBAR-->
