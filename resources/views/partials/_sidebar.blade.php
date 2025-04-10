<!-- BEGIN: Main Menu-->
<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item me-auto">
                <a class="navbar-brand" href="{{ route ('dashboard') }}">
                    <span class="brand-logo">
                        <img src="{{ asset ('/assets/img/home-logo.png') }}" id="logo">
                    </span>
                    {{-- <h2 class="brand-text">{{ config ('app.name') }}</h2> --}}
                    <h2 class="brand-text">ND</h2>

                </a>
            </li>
            <li class="nav-item nav-toggle">
                <a class="nav-link modern-nav-toggle pe-0" data-bs-toggle="collapse">
                    <i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i>
                    <i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc"
                       data-ticon="disc"></i>
                </a>
            </li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main mt-1" id="main-menu-navigation" data-menu="menu-navigation">

            <li class="nav-item {{ request () -> routeIs ('home') ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="{{ route ('home') }}">
                    <i data-feather="home"></i>
                    <span class="menu-title text-truncate" data-i18n="Home">Home</span>
                </a>
            </li>

            @include('partials.menu-items.dashboard')
            @include('partials.menu-items.sales')
            @include('partials.menu-items.products')
            @include('partials.menu-items.stock-takes')
            @include('partials.menu-items.adjustments')
            @include('partials.menu-items.issuance')
            @include('partials.menu-items.customers')
            @include('partials.menu-items.vendors')
            @include('partials.menu-items.accounts')
            @include('partials.menu-items.accounts-reporting')
            @include('partials.menu-items.account-settings')
            @include('partials.menu-items.reporting')
            @include('partials.menu-items.users')
            @include('partials.menu-items.user-management')
            @include('partials.menu-items.settings')

        </ul>
    </div>
</div>
<!-- END: Main Menu-->
