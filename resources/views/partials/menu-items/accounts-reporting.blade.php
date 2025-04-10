@can('viewAccountsReportingMenu', \App\Models\User::class)
    <li class="nav-item {{ request () -> routeIs ('reporting.*') ? 'has-sub open' : '' }}">
        <a class="d-flex align-items-center" href="javascript:void(0)">
            <i data-feather='pie-chart'></i>
            <span class="menu-title text-truncate" data-i18n="Accounts Reporting">Accounts Reporting</span>
        </a>
        <ul class="menu-content">
            
            @can('viewTrialBalanceSheet', \App\Models\User::class)
                <li class="{{ request () -> routeIs ('trial-balance-sheet') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route ('trial-balance-sheet') }}">
                        <i data-feather="circle"></i>
                        <span class="menu-item text-truncate" data-i18n="Trial Balance Sheet">Trial Balance Sheet</span>
                    </a>
                </li>
            @endcan
            
            @can('customerPayableReport', \App\Models\User::class)
                <li class="{{ request () -> routeIs ('customer-receivable-report') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route ('customer-receivable-report') }}">
                        <i data-feather="circle"></i>
                        <span class="menu-item text-truncate d-full-text"
                              data-i18n="Customers Receivable">Customers Receivable</span>
                    </a>
                </li>
            @endcan
            
            @can('vendorPayableReport', \App\Models\User::class)
                <li class="{{ request () -> routeIs ('vendor-payable-report') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route ('vendor-payable-report') }}">
                        <i data-feather="circle"></i>
                        <span class="menu-item text-truncate d-full-text"
                              data-i18n="Vendors Payable">Vendors Payable</span>
                    </a>
                </li>
            @endcan
            
            @can('profitAndLossReport', \App\Models\User::class)
                <li class="{{ request () -> routeIs ('profit-and-loss-report') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route ('profit-and-loss-report') }}">
                        <i data-feather="circle"></i>
                        <span class="menu-item text-truncate d-full-text"
                              data-i18n="Profit & Loss Report">Profit & Loss Report</span>
                    </a>
                </li>
            @endcan
            
            @can('balance_sheet', \App\Models\Account::class)
                <li class="{{ request () -> routeIs ('balance-sheet') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route ('balance-sheet') }}">
                        <i data-feather="circle"></i>
                        <span class="menu-item text-truncate d-full-text"
                              data-i18n="Balance Sheet">Balance Sheet</span>
                    </a>
                </li>
            @endcan
            
            @can('customer_ageing_report', \App\Models\Account::class)
                <li class="{{ request () -> routeIs ('customer-ageing-report') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route ('customer-ageing-report') }}">
                        <i data-feather="circle"></i>
                        <span class="menu-item text-truncate d-full-text"
                              data-i18n="Customer Ageing Report">Customer Ageing Report</span>
                    </a>
                </li>
            @endcan
            
            @can('vendor_ageing_report', \App\Models\Account::class)
                <li class="{{ request () -> routeIs ('vendor-ageing-report') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route ('vendor-ageing-report') }}">
                        <i data-feather="circle"></i>
                        <span class="menu-item text-truncate d-full-text"
                              data-i18n="Vendor Ageing Report">Vendor Ageing Report</span>
                    </a>
                </li>
            @endcan
        </ul>
    </li>
@endcan
