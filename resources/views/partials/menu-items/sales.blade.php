@can('viewSalesMenu', \App\Models\Sale::class)
    <li class="nav-item {{ request()->is('sales*') ? 'has-sub open' : '' }}">
        <a class="d-flex align-items-center" href="javascript:void(0)">
            <i data-feather='dollar-sign'></i>
            <span class="menu-title text-truncate" data-i18n="Sales">Sales</span>
        </a>
        <ul class="menu-content">
            @can('viewAllSales', \App\Models\Sale::class)
                <li class="{{ request()->routeIs('sales.index') && !request()->has('closed') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route('sales.index') }}">
                        <i data-feather="circle"></i>
                        <span class="menu-item text-truncate">All Sales (Open)</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('sales.index') && request()->query('closed') == 'true' ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route('sales.index', ['closed' => 'true']) }}">
                        <i data-feather="circle"></i>
                        <span class="menu-item text-truncate">All Sales (Closed)</span>
                    </a>
                </li>
            @endcan

            @can('create', \App\Models\Sale::class)
                <li class="{{ request()->routeIs('sales.create') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route('sales.create') }}">
                        <i data-feather="circle"></i>
                        <span class="menu-item text-truncate">Add Sales</span>
                    </a>
                </li>
            @endcan

            @can('quick_sale', \App\Models\Sale::class)
                <li class="{{ request()->routeIs('quick-sale') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route('quick-sale') }}">
                        <i data-feather="circle"></i>
                        <span class="menu-item text-truncate">Quick Sale</span>
                    </a>
                </li>
            @endcan

            @can('create_sale_attribute', \App\Models\Sale::class)
                <li class="{{ request()->routeIs('sales.create.attribute') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route('sales.create.attribute') }}">
                        <i data-feather="circle"></i>
                        <span class="menu-item text-truncate">Add Sales (Attribute)</span>
                    </a>
                </li>
            @endcan
        </ul>
    </li>
@endcan
