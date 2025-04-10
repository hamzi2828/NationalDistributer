@can('viewCustomersMenu', \App\Models\Customer::class)
    <li class="nav-item {{ (request () -> routeIs ('customers.*')) ? 'has-sub open' : '' }}">
        <a class="d-flex align-items-center" href="javascript:void(0)">
            <i data-feather='user-check'></i>
            <span class="menu-title text-truncate" data-i18n="Customers">Customers</span>
        </a>
        <ul class="menu-content">
            @can('viewAllCustomers', \App\Models\Customer::class)
                <li class="{{ request () -> routeIs ('customers.index') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route ('customers.index') }}">
                        <i data-feather="circle"></i>
                        <span class="menu-item text-truncate" data-i18n="All Customers">All Customers</span>
                    </a>
                </li>
            @endcan

            @can('create', \App\Models\Customer::class)
                <li class="{{ request () -> routeIs ('customers.create') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route ('customers.create') }}">
                        <i data-feather="circle"></i>
                        <span class="menu-item text-truncate" data-i18n="Add Customers">Add Customers</span>
                    </a>
                </li>
            @endcan
        </ul>
    </li>
@endcan