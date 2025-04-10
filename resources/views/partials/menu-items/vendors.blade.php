@can('viewVendorsMenu', \App\Models\Vendor::class)
    <li class="nav-item {{ request () -> routeIs ('vendors.*') ? 'has-sub open' : '' }}">
        <a class="d-flex align-items-center" href="javascript:void(0)">
            <i data-feather='layers'></i>
            <span class="menu-title text-truncate" data-i18n="vendors">Vendors</span>
        </a>
        <ul class="menu-content">
            @can('viewAllVendors', \App\Models\Vendor::class)
                <li class="{{ request () -> routeIs ('vendors.index') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route ('vendors.index') }}">
                        <i data-feather="circle"></i>
                        <span class="menu-item text-truncate" data-i18n="All Vendors">All Vendors</span>
                    </a>
                </li>
            @endcan
            @can('create', \App\Models\Vendor::class)
                <li class="{{ request () -> routeIs ('vendors.create') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route ('vendors.create') }}">
                        <i data-feather="circle"></i>
                        <span class="menu-item text-truncate" data-i18n="Add Vendors">Add Vendors</span>
                    </a>
                </li>
            @endcan
        </ul>
    </li>
@endcan