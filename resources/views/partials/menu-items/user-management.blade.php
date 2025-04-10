@if(in_array ('user-management-privilege', auth () -> user () -> permissions()) || in_array ( 'admin', auth () -> user () -> user_roles () ))
    <li class="nav-item {{ (str_replace ('/', '', request () -> route () -> getPrefix ()) == 'user-management') ? 'has-sub open' : '' }}">
        <a class="d-flex align-items-center" href="javascript:void(0)">
            <i data-feather='sliders'></i>
            <span class="menu-title text-truncate" data-i18n="User Management">User Management</span>
        </a>
        @can('viewRolesMenu', \App\Models\Role::class)
            <ul class="menu-content">
                <li class="{{ request () -> routeIs ('roles.*') ? 'has-sub open' : '' }}">
                    <a class="d-flex align-items-center" href="#">
                        <i data-feather="unlock"></i>
                        <span class="menu-item text-truncate" data-i18n="Roles">Roles</span>
                    </a>
                    <ul class="menu-content">
                        @can('viewAllRoles', \App\Models\Role::class)
                            <li class="{{ request () -> routeIs ('roles.index') ? 'active' : '' }}">
                                <a class="d-flex align-items-center" href="{{ route ('roles.index') }}">
                                    <span class="menu-item text-truncate" data-i18n="All Roles">All Roles</span>
                                </a>
                            </li>
                        @endcan
                        @can('create', \App\Models\Role::class)
                            <li class="{{ request () -> routeIs ('roles.create') ? 'active' : '' }}">
                                <a class="d-flex align-items-center" href="{{ route ('roles.create') }}">
                                    <span class="menu-item text-truncate" data-i18n="Add Roles">Add Roles</span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            </ul>
        @endcan
    </li>
@endif