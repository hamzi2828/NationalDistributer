@can('viewAccountsMenu', \App\Models\Account::class)
    <li class="nav-item {{ request () -> routeIs ('accounts.*') ? 'has-sub open' : '' }}">
        <a class="d-flex align-items-center" href="javascript:void(0)">
            <i data-feather='briefcase'></i>
            <span class="menu-title text-truncate" data-i18n="accounts">Accounts</span>
        </a>
        <ul class="menu-content">
            @can('viewAllAccounts', \App\Models\Account::class)
                <li class="{{ request () -> routeIs ('accounts.chat-of-accounts') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route ('accounts.chat-of-accounts') }}">
                        <i data-feather="circle"></i>
                        <span class="menu-item text-truncate" data-i18n="Chart of Accounts">Chart of Accounts</span>
                    </a>
                </li>
            @endcan

            @can('create', \App\Models\Account::class)
                <li class="{{ request () -> routeIs ('accounts.create') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route ('accounts.create') }}">
                        <i data-feather="circle"></i>
                        <span class="menu-item text-truncate" data-i18n="Add accounts">Add Accounts Heads</span>
                    </a>
                </li>
            @endcan

            @can('viewGeneralLedger', \App\Models\Account::class)
                <li class="{{ request () -> routeIs ('accounts.general-ledgers') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route ('accounts.general-ledgers') }}">
                        <i data-feather="circle"></i>
                        <span class="menu-item text-truncate" data-i18n="General Ledgers (New)">General Ledgers</span>
                    </a>
                </li>
            @endcan

            @can('add_transactions', \App\Models\Account::class)
                <li class="{{ request () -> routeIs ('accounts.add-transactions') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route ('accounts.add-transactions') }}">
                        <i data-feather="circle"></i>
                        <span class="menu-item text-truncate" data-i18n="Add Transactions">Add Transactions</span>
                    </a>
                </li>
            @endcan

            @can('add_transactions_quick', \App\Models\Account::class)
                <li class="{{ request () -> routeIs ('accounts.add-transactions-quick') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route ('accounts.add-transactions-quick') }}">
                        <i data-feather="circle"></i>
                        <span class="menu-item text-truncate" data-i18n="Quick Receive">Quick Receive</span>
                    </a>
                </li>
            @endcan

            @can('add_transactions_quick_pay', \App\Models\Account::class)
                <li class="{{ request () -> routeIs ('accounts.add-transactions-quick-pay') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route ('accounts.add-transactions-quick-pay') }}">
                        <i data-feather="circle"></i>
                        <span class="menu-item text-truncate" data-i18n="Quick Pay">Quick Pay</span>
                    </a>
                </li>
            @endcan

            @can('add_transactions_quick_expense', \App\Models\Account::class)
                <li class="{{ request () -> routeIs ('accounts.add-transactions-quick-expense') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route ('accounts.add-transactions-quick-expense') }}">
                        <i data-feather="circle"></i>
                        <span class="menu-item text-truncate" data-i18n="Quick Expense">Quick Expense</span>
                    </a>
                </li>
            @endcan

            @can('search_transactions', \App\Models\Account::class)
                <li class="{{ request () -> routeIs ('accounts.search-transactions') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route ('accounts.search-transactions') }}">
                        <i data-feather="circle"></i>
                        <span class="menu-item text-truncate" data-i18n="Search Transactions">Search Transactions</span>
                    </a>
                </li>
            @endcan

            @can('add_multiple_transactions', \App\Models\Account::class)
                <li class="{{ request () -> routeIs ('accounts.add-multiple-transactions') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route ('accounts.add-multiple-transactions') }}">
                        <i data-feather="circle"></i>
                        <span class="menu-item text-truncate"
                              data-i18n="Add Transactions (Multiple)">Add Transactions (Multiple)</span>
                    </a>
                </li>
            @endcan

            @can('add_transactions_complex_jv', \App\Models\Account::class)
                <li class="{{ request () -> routeIs ('accounts.add-transactions-complex-jv') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route ('accounts.add-transactions-complex-jv') }}">
                        <i data-feather="circle"></i>
                        <span class="menu-item text-truncate"
                              data-i18n="Add Transactions (Complex JV)">Add Transactions (Complex JV)</span>
                    </a>
                </li>
            @endcan

            @can('add_opening_balance', \App\Models\Account::class)
                <li class="{{ request () -> routeIs ('accounts.add-opening-balance') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route ('accounts.add-opening-balance') }}">
                        <i data-feather="circle"></i>
                        <span class="menu-item text-truncate" data-i18n="Add Opening Balance">Add Opening Balance</span>
                    </a>
                </li>
            @endcan
        </ul>
    </li>
@endcan
