@can('viewUsersMenu', \App\Models\User::class)
    <li class="nav-item {{ request () -> routeIs ('users.*') ? 'has-sub open' : '' }}">
        <a class="d-flex align-items-center" href="javascript:void(0)">
            <i data-feather='users'></i>
            <span class="menu-title text-truncate" data-i18n="Users">Users</span>
        </a>
        <ul class="menu-content">
            @can('viewAllUsers', \App\Models\User::class)
                <li class="{{ request () -> routeIs ('users.index') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route ('users.index') }}">
                        <i data-feather="circle"></i>
                        <span class="menu-item text-truncate" data-i18n="All Users">All Users</span>
                    </a>
                </li>
            @endcan
            @can('create', \App\Models\User::class)
                <li class="{{ request () -> routeIs ('users.update') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route ('users.create') }}">
                        <i data-feather="circle"></i>
                        <span class="menu-item text-truncate" data-i18n="Add Users">Add Users</span>
                    </a>
                </li>
            @endcan
        </ul>
    </li>
@endcan