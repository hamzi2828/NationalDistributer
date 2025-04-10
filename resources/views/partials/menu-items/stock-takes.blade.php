@can('viewStockTakeMenu', \App\Models\StockTake::class)
    <li class="nav-item {{ (request () -> routeIs ('stock-takes.*')) ? 'has-sub open' : '' }}">
        <a class="d-flex align-items-center" href="javascript:void(0)">
            <i data-feather='package'></i>
            <span class="menu-title text-truncate" data-i18n="Products">Stock Take</span>
        </a>
        <ul class="menu-content">
            @can('viewAllStockTake', \App\Models\StockTake::class)
                <li class="{{ request () -> routeIs ('stock-takes.index') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route ('stock-takes.index') }}">
                        <i data-feather="circle"></i>
                        <span class="menu-item text-truncate" data-i18n="All Stock Takes">All Stock Take</span>
                    </a>
                </li>
            @endcan

            @can('create', \App\Models\StockTake::class)
                <li class="{{ request () -> routeIs ('stock-takes.create') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route ('stock-takes.create') }}">
                        <i data-feather="circle"></i>
                        <span class="menu-item text-truncate" data-i18n="Add Stock Takes">Add Stock Take (Attribute)</span>
                    </a>
                </li>
            @endcan

            @can('create_category_category', \App\Models\StockTake::class)
                <li class="{{ request () -> routeIs ('stock-takes.create-category') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route ('stock-takes.create-category') }}">
                        <i data-feather="circle"></i>
                        <span class="menu-item text-truncate" data-i18n="Add Stock Takes">Add Stock Take (Category)</span>
                    </a>
                </li>
            @endcan
        </ul>
    </li>
@endcan
