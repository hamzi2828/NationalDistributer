@can('viewReportingMenu', \App\Models\User::class)
    <li class="nav-item {{ request () -> routeIs ('reporting.*') ? 'has-sub open' : '' }}">
        <a class="d-flex align-items-center" href="javascript:void(0)">
            <i data-feather='pie-chart'></i>
            <span class="menu-title text-truncate" data-i18n="General Reporting">General Reporting</span>
        </a>
        <ul class="menu-content">
            @can('viewGeneralSalesReport', \App\Models\User::class)
                <li class="{{ request () -> routeIs ('general-sales-report') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route ('general-sales-report') }}">
                        <i data-feather="circle"></i>
                        <span class="menu-item text-truncate"
                              data-i18n="General Sales Report">General Sales Report</span>
                    </a>
                </li>
            @endcan
            
            @can('viewGeneralSalesReportAttributeWise', \App\Models\User::class)
                <li class="{{ request () -> routeIs ('general-sales-report-attribute-wise') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route ('general-sales-report-attribute-wise') }}">
                        <i data-feather="circle"></i>
                        <span class="menu-item text-truncate  d-full-text"
                              data-i18n="General Sales Report (Attribute Wise)">General Sales Report (Attribute Wise)</span>
                    </a>
                </li>
            @endcan
            
            @can('viewGeneralSalesReportProductWise', \App\Models\User::class)
                <li class="{{ request () -> routeIs ('general-sales-report-product-wise') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route ('general-sales-report-product-wise') }}">
                        <i data-feather="circle"></i>
                        <span class="menu-item text-truncate  d-full-text"
                              data-i18n="General Sales Report (Product Wise)">General Sales Report (Product Wise)</span>
                    </a>
                </li>
            @endcan
            
            @can('viewStockValuationTPReport', \App\Models\User::class)
                <li class="{{ request () -> routeIs ('stock-valuation-tp-report') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route ('stock-valuation-tp-report') }}">
                        <i data-feather="circle"></i>
                        <span class="menu-item text-truncate d-full-text"
                              data-i18n="Stock Valuation Report (TP)">Stock Valuation Report (TP Wise)</span>
                    </a>
                </li>
            @endcan
            
            @can('viewStockValuationSaleReport', \App\Models\User::class)
                <li class="{{ request () -> routeIs ('stock-valuation-sale-report') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route ('stock-valuation-sale-report') }}">
                        <i data-feather="circle"></i>
                        <span class="menu-item text-truncate d-full-text"
                              data-i18n="Stock Valuation Report (Sale)">Stock Valuation Report (Sale Wise)</span>
                    </a>
                </li>
            @endcan

            @can('viewStockStatementReport', \App\Models\User::class)
            <li class="{{ request()->routeIs('stock-statement-report') ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="{{ route('stock-statement-report') }}">
                    <i data-feather="circle"></i>
                    <span class="menu-item text-truncate d-full-text"
                          data-i18n="Stock Statement Report (Current Available)">Stock Statement Report (Current Available)</span>
                </a>
            </li>
            @endcan
            
            
            @can('viewThresholdReport', \App\Models\User::class)
                <li class="{{ request () -> routeIs ('threshold-report') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route ('threshold-report') }}">
                        <i data-feather="circle"></i>
                        <span class="menu-item text-truncate d-full-text"
                              data-i18n="Threshold Report">Threshold Report</span>
                    </a>
                </li>
            @endcan
            
            @can('attributeWiseQuantityReport', \App\Models\User::class)
                <li class="{{ request () -> routeIs ('attribute-wise-quantity-report') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route ('attribute-wise-quantity-report') }}">
                        <i data-feather="circle"></i>
                        <span class="menu-item text-truncate d-full-text"
                              data-i18n="Available Stock Report (Attribute Wise)">Available Stock Report (Attribute Wise)</span>
                    </a>
                </li>
            @endcan
            
            @can('categoryWiseQuantityReport', \App\Models\User::class)
                <li class="{{ request () -> routeIs ('category-wise-quantity-report') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route ('category-wise-quantity-report') }}">
                        <i data-feather="circle"></i>
                        <span class="menu-item text-truncate d-full-text"
                              data-i18n="Available Stock Report (Category Wise)">Available Stock Report (Category Wise)</span>
                    </a>
                </li>
            @endcan
            
            @can('productSalesAnalysisReport', \App\Models\User::class)
                <li class="{{ request () -> routeIs ('product-sales-analysis-report') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route ('product-sales-analysis-report') }}">
                        <i data-feather="circle"></i>
                        <span class="menu-item text-truncate d-full-text"
                              data-i18n="Sales Analysis Report (Products)">Sales Analysis Report (Products)</span>
                    </a>
                </li>
            @endcan
            
            @can('attributeSalesAnalysisReport', \App\Models\User::class)
                <li class="{{ request () -> routeIs ('attribute-sales-analysis-report') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route ('attribute-sales-analysis-report') }}">
                        <i data-feather="circle"></i>
                        <span class="menu-item text-truncate d-full-text"
                              data-i18n="Sales Analysis Report (Attributes)">Sales Analysis Report (Attributes)</span>
                    </a>
                </li>
            @endcan
            
            @can('customerReturnReport', \App\Models\User::class)
                <li class="{{ request () -> routeIs ('customer-return-report') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route ('customer-return-report') }}">
                        <i data-feather="circle"></i>
                        <span class="menu-item text-truncate d-full-text"
                              data-i18n="Customer Return Report">Customer Return Report</span>
                    </a>
                </li>
            @endcan
            
            @can('vendorReturnReport', \App\Models\User::class)
                <li class="{{ request () -> routeIs ('vendor-return-report') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route ('vendor-return-report') }}">
                        <i data-feather="circle"></i>
                        <span class="menu-item text-truncate d-full-text"
                              data-i18n="Vendor Return Report">Vendor Return Report</span>
                    </a>
                </li>
            @endcan
            
            @can('supplierWiseReport', \App\Models\User::class)
                <li class="{{ request () -> routeIs ('supplier-wise-report') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route ('supplier-wise-report') }}">
                        <i data-feather="circle"></i>
                        <span class="menu-item text-truncate d-full-text"
                              data-i18n="Supplier Wise Report">Supplier Wise Report</span>
                    </a>
                </li>
            @endcan
            
            @can('purchaseAnalysisReport', \App\Models\User::class)
                <li class="{{ request () -> routeIs ('purchase-analysis-report') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route ('purchase-analysis-report') }}">
                        <i data-feather="circle"></i>
                        <span class="menu-item text-truncate d-full-text"
                              data-i18n="Analysis Report (Purchase)">Analysis Report (Purchase)</span>
                    </a>
                </li>
            @endcan
            
            @can('saleAnalysisReport', \App\Models\User::class)
                <li class="{{ request () -> routeIs ('sale-analysis-report') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route ('sale-analysis-report') }}">
                        <i data-feather="circle"></i>
                        <span class="menu-item text-truncate d-full-text"
                              data-i18n="Analysis Report (Sale)">Analysis Report (Sale)</span>
                    </a>
                </li>
            @endcan
            
            @can('viewProfitReport', \App\Models\User::class)
                <li class="{{ request () -> routeIs ('profit-report') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route ('profit-report') }}">
                        <i data-feather="circle"></i>
                        <span class="menu-item text-truncate d-full-text" data-i18n="Profit Report">Profit Report</span>
                    </a>
                </li>
            @endcan
            
            <li class="{{ request () -> routeIs ('price-list-catalog') ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="{{ route ('price-list-catalog') }}">
                    <i data-feather="circle"></i>
                    <span class="menu-item text-truncate d-full-text"
                          data-i18n="Balance Sheet">Price List Catalog</span>
                </a>
            </li>
            @can('couponReport', \App\Models\User::class)

            <li class="{{ request () -> routeIs ('coupon-genral-report') ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="{{ route ('coupon-genral-report') }}">
                    <i data-feather="circle"></i>
                    <span class="menu-item text-truncate d-full-text"
                          data-i18n="Coupon Genral Report">Coupon Report</span>
                </a>
            </li>
            @endcan

            <li class="{{ request () -> routeIs ('stock-moment-report') ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="{{ route ('stock-moment-report') }}">
                    <i data-feather="circle"></i>
                    <span class="menu-item text-truncate d-full-text"
                          data-i18n="Vendors Payable">Stock Moment Report</span>
                </a>
            </li>
            
            <li class="{{ request () -> routeIs ('stock-out-summary-report') ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="{{ route ('stock-out-summary-report') }}">
                    <i data-feather="circle"></i>
                    <span class="menu-item text-truncate d-full-text"
                          data-i18n="Vendors Payable">Stock Out Summary Report</span>
                </a>
            </li>

            <li class="{{ request () -> routeIs ('high-low-sale-report') ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="{{ route ('high-low-sale-report') }}">
                    <i data-feather="circle"></i>
                    <span class="menu-item text-truncate d-full-text"
                          data-i18n="Vendor Ageing Report">High/Low (Online) </span>
                </a>
            </li>

            
            <li class="{{ request () -> routeIs ('high-low-sale-report-pos') ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="{{ route ('high-low-sale-report-pos') }}">
                    <i data-feather="circle"></i>
                    <span class="menu-item text-truncate d-full-text"
                          data-i18n="Vendor Ageing Report">High/Low (Pos) </span>
                </a>
            </li>

            <li class="{{ request () -> routeIs ('high-low-sale-report-pos-vs-online') ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="{{ route ('high-low-sale-report-pos-vs-online') }}">
                    <i data-feather="circle"></i>
                    <span class="menu-item text-truncate d-full-text"
                          data-i18n="Vendor Ageing Report">High/Low (Pos vs Online) </span>
                </a>
            </li> 


            
            <li class="{{ request () -> routeIs ('daily-closing-summary-report') ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="{{ route ('daily-closing-summary-report') }}">
                    <i data-feather="circle"></i>
                    <span class="menu-item text-truncate d-full-text"
                          data-i18n="Vendor Ageing Report">Daily Closing Report (Summary)</span>
                </a>
            </li> 


        </ul>
    </li>
@endcan
