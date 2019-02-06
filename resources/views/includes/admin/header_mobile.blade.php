<!-- HEADER MOBILE-->
<header class="header-mobile d-block d-lg-none">
    <div class="header-mobile__bar">
        <div class="container-fluid">
            <div class="header-mobile-inner">
                <a class="logo" href="index.html">
                    <img src="images/icon/logo.png" alt="CoolAdmin" />
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
                <li>
                    <a class="js-arrow" href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i>{{ __('admin.dashboard') }}</a>
                </li>
                <li class="has-sub">
                    <a href="#">
                        <i class="fas fa-copy">{{ __('admin.content management') }}</i>
                    </a>
                    <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                        @include('includes.admin.content_management_menu')
                    </ul>
                </li>

            </ul>
        </div>
    </nav>
</header>
<!-- END HEADER MOBILE-->
