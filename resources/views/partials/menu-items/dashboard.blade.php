@can('viewDashboardMenu', \App\Models\User::class)
    <li class="nav-item {{ request () -> routeIs ('dashboard') ? 'active' : '' }}">
        <a class="d-flex align-items-center" href="{{ route ('dashboard') }}">
            <i data-feather="pie-chart"></i>
            <span class="menu-title text-truncate" data-i18n="Dashboard">Dashboard</span>
        </a>
    </li>
@endcan