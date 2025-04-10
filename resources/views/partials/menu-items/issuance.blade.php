@can('viewIssuanceMenu', \App\Models\Issuance::class)
    <li class="nav-item {{ (request () -> routeIs ('issuance.*')) ? 'has-sub open' : '' }}">
        <a class="d-flex align-items-center" href="javascript:void(0)">
            <i data-feather='truck'></i>
            <span class="menu-title text-truncate" data-i18n="Transfers">Transfers</span>
        </a>
        <ul class="menu-content">
            @can('viewAllIssuance', \App\Models\Issuance::class)
                <li class="{{ request () -> routeIs ('issuance.index') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route ('issuance.index') }}">
                        <i data-feather="circle"></i>
                        <span class="menu-item text-truncate" data-i18n="All Transfers">All Transfers</span>
                    </a>
                </li>
            @endcan

            @can('create', \App\Models\Issuance::class)
                <li class="{{ request () -> routeIs ('issuance.create') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route ('issuance.create') }}">
                        <i data-feather="circle"></i>
                        <span class="menu-item text-truncate" data-i18n="Add Transfers">Add Transfers</span>
                    </a>
                </li>
            @endcan
        </ul>
    </li>
@endcan