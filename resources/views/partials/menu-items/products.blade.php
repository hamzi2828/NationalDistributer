@can('viewProductsMenu', \App\Models\Product::class)
    <li class="nav-item {{ (request()->routeIs('products.*')) ? 'has-sub open' : '' }}">
        <a class="d-flex align-items-center" href="javascript:void(0)">
            <i data-feather='archive'></i>
            <span class="menu-title text-truncate" data-i18n="Products">Products</span>
        </a>
        <ul class="menu-content">
            @can('viewAllProducts', \App\Models\Product::class)
                <li class="{{ request () -> routeIs ('products.index') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route ('products.index') }}">
                        <i data-feather="circle"></i>
                        <span class="menu-item text-truncate" data-i18n="All Products (Detailed)">All Products (Detailed)</span>
                    </a>
                </li>
            @endcan
            
            @can('viewAllProductSimple', \App\Models\Product::class)
                <li class="{{ request () -> routeIs ('products.simple-products') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route ('products.simple-products') }}">
                        <i data-feather="circle"></i>
                        <span class="menu-item text-truncate" data-i18n="All Products">All Products</span>
                    </a>
                </li>
            @endcan
            
         
            
            @can('create', \App\Models\Product::class)
                <li class="{{ request () -> routeIs ('products.create') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route ('products.create') }}">
                        <i data-feather="circle"></i>
                        <span class="menu-item text-truncate" data-i18n="Add Products">Add Products (Simple)</span>
                    </a>
                </li>
            @endcan
            
            @can('create_variable', \App\Models\Product::class)
                <li class="{{ request () -> routeIs ('products.create.variable') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route ('products.create.variable') }}">
                        <i data-feather="circle"></i>
                        <span class="menu-item text-truncate" data-i18n="Add Products">Add Products (Variable)</span>
                    </a>
                </li>
            @endcan

            
            @can('bulkUpdatePrices', \App\Models\User::class)
                <li class="{{ request () -> routeIs ('products.bulk-update-prices') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route ('products.bulk-update-prices') }}">
                        <i data-feather="circle"></i>
                        <span class="menu-item" data-i18n="Bulk Price Update (Attribute Wise)">
                            Bulk Price Update (Attribute Wise)
                        </span>
                    </a>
                </li>
            @endcan
            
            @can('bulkUpdatePricesCategoryWise', \App\Models\User::class)
                <li class="{{ request () -> routeIs ('products.bulk-update-prices-category-wise') ? 'active' : '' }}">
                    <a class="d-flex align-items-center"
                       href="{{ route ('products.bulk-update-prices-category-wise') }}">
                        <i data-feather="circle"></i>
                        <span class="menu-item" data-i18n="Bulk Price Update (Category Wise)">
                            Bulk Price Update (Category Wise)
                        </span>
                    </a>
                </li>
            @endcan
            

        </ul>
    </li>
@endcan

@can('reviews_sidebar', \App\Models\User::class)
    <li class="nav-item {{ request()->routeIs('reviews.*') ? 'has-sub open' : '' }}">
    <a class="d-flex align-items-center" href="javascript:void(0)">
        <i data-feather='star'></i>
        <span class="menu-title text-truncate" data-i18n="Products Reviews">Products Reviews</span>
    </a>
    <ul class="menu-content">  
        <li class="{{ request()->routeIs('reviews.index') ? 'active' : '' }}">
            <a class="d-flex align-items-center" href="{{ route('reviews.index') }}">
                <i data-feather="circle"></i>
                <span class="menu-item text-truncate" data-i18n="Products Reviews"> Reviews</span>
            </a>
        </li>
        @can('reviews_report_sidebar', \App\Models\User::class)
        <li class="{{ request()->routeIs('reviews.report') ? 'active' : '' }}">
            <a class="d-flex align-items-center" href="{{ route('reviews.report') }}">
                <i data-feather="circle"></i>
                <span class="menu-item text-truncate" data-i18n="Products Reviews"> Reviews Report</span>
            </a>
        </li>
        @endcan
        
    </ul>
</li>
@endcan



@can('viewProductsMenu', \App\Models\Product::class)
<li class="nav-item {{ (request()->routeIs('stocks.*')) ? 'has-sub open' : '' }}">
    <a class="d-flex align-items-center" href="javascript:void(0)">
        <i data-feather="shopping-cart"></i>
        <span class="menu-title text-truncate" data-i18n="Products Reviews">Purchase </span>
    </a>
    <ul class="menu-content">   
                    
        @can('viewAllStocks', \App\Models\Stock::class)
        <li class="{{ request () -> routeIs ('stocks.index') ? 'active' : '' }}">
            <a class="d-flex align-items-center" href="{{ route ('stocks.index') }}">
                <i data-feather="circle"></i>
                <span class="menu-item text-truncate" data-i18n="All Stocks">All Stocks</span>
            </a>
        </li>
    @endcan
    
    @can('create', \App\Models\Stock::class)
        <li class="{{ request () -> routeIs ('stocks.create') ? 'active' : '' }}">
            <a class="d-flex align-items-center" href="{{ route ('stocks.create') }}">
                <i data-feather="circle"></i>
                <span class="menu-item text-truncate" data-i18n="Add Stocks">Add Stocks</span>
            </a>
        </li>
    @endcan
    
    @can('checkStock', \App\Models\User::class)
        <li class="{{ request () -> routeIs ('stocks.check-stock') ? 'active' : '' }}">
            <a class="d-flex align-items-center" href="{{ route ('stocks.check-stock') }}">
                <i data-feather="circle"></i>
                <span class="menu-item text-truncate" data-i18n="Check Stock">Check Stock</span>
            </a>
        </li>
    @endcan
        
    </ul>
</li>
@endcan



@can('viewProductsMenu', \App\Models\Product::class)
<li class="nav-item {{ (request()->routeIs('stock-returns.*') || request()->routeIs('stocks.customers') || request()->routeIs('stocks.add-customer')) ? 'has-sub open' : '' }}">
  
    <a class="d-flex align-items-center" href="javascript:void(0)">
        <i data-feather="rotate-ccw"></i>
        <span class="menu-title text-truncate" data-i18n="Products Reviews">Returns </span>
    </a>
    <ul class="menu-content">  
                    
        @can('viewAllStockReturns', \App\Models\StockReturn::class)
        <li class="{{ request () -> routeIs ('stock-returns.index') ? 'active' : '' }}">
            <a class="d-flex align-items-center" href="{{ route ('stock-returns.index') }}">
                <i data-feather="circle"></i>
                <span class="menu-item text-truncate" data-i18n="All Stock Returns">All Returns (Vendor)</span>
            </a>
        </li>
    @endcan
    
    @can('create', \App\Models\StockReturn::class)
        <li class="{{ request () -> routeIs ('stock-returns.create') ? 'active' : '' }}">
            <a class="d-flex align-items-center" href="{{ route ('stock-returns.create') }}">
                <i data-feather="circle"></i>
                <span class="menu-item text-truncate" data-i18n="Add Stock Returns">Add Returns (Vendor)</span>
            </a>
        </li>
    @endcan
    
    @can('viewAllCustomerStockReturns', \App\Models\Stock::class)
        <li class="{{ request () -> routeIs ('stocks.customers') ? 'active' : '' }}">
            <a class="d-flex align-items-center" href="{{ route ('stocks.customers') }}">
                <i data-feather="circle"></i>
                <span class="menu-item text-truncate" data-i18n="All Stock Returns (Customer)">All Returns (Customer)</span>
            </a>
        </li>
    @endcan 
    
    @can('createCustomerStockReturn', \App\Models\Stock::class)
        <li class="{{ request () -> routeIs ('stocks.add-customer') ? 'active' : '' }}">
            <a class="d-flex align-items-center" href="{{ route ('stocks.add-customer') }}">
                <i data-feather="circle"></i>
                <span class="menu-item text-truncate" data-i18n="Add Stock Returns (Customer)">Add Returns (Customer)</span>
            </a>
        </li>
    @endcan
        
    </ul>
</li>
@endcan

