@if(in_array ('account-settings-privilege', auth () -> user () -> permissions()) || in_array ( 'admin', auth () -> user () -> user_roles () ))
    <li class="nav-item {{ (str_replace ('/', '', request () -> route () -> getPrefix ()) == 'account-settings') ? 'has-sub open' : '' }}">
        <a class="d-flex align-items-center" href="javascript:void(0)">
            <i data-feather='settings'></i>
            <span class="menu-title text-truncate" data-i18n="Account Settings">Account Settings</span>
        </a>
        <ul class="menu-content">
            @can('viewAccountTypesMenu', \App\Models\AccountType::class)
                <li class="{{ request () -> routeIs ('account-types.*') ? 'has-sub open' : '' }}">
                    <a class="d-flex align-items-center" href="javascript:void(0)">
                        <i data-feather="list"></i>
                        <span class="menu-item text-truncate" data-i18n="Account Types">Account Types</span>
                    </a>
                    <ul class="menu-content">
                        @can('viewAllAccountTypes', \App\Models\AccountType::class)
                            <li class="{{ request () -> routeIs ('account-types.index') ? 'active' : '' }}">
                                <a class="d-flex align-items-center" href="{{ route ('account-types.index') }}">
                                    <i data-feather="circle"></i>
                                    <span class="menu-item text-truncate"
                                          data-i18n=">All Account Types">All Account Types</span>
                                </a>
                            </li>
                        @endcan
                        @can('create', \App\Models\AccountType::class)
                            <li class="{{ request () -> routeIs ('account-types.create') ? 'active' : '' }}">
                                <a class="d-flex align-items-center" href="{{ route ('account-types.create') }}">
                                    <i data-feather="circle"></i>
                                    <span class="menu-item text-truncate"
                                          data-i18n="Add Account Types">Add Account Types</span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan
            
            <li class="{{ request () -> routeIs ('financial-year.*') ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="{{ route ('financial-year.create') }}">
                    <i data-feather="calendar"></i>
                    <span class="menu-item text-truncate" data-i18n="Financial Year">Financial Year</span>
                </a>
            </li>
        </ul>
    </li>
@endif