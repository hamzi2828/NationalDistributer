@can('viewAdjustmentsMenu', \App\Models\User::class)
    <li class="nav-item {{ (request () -> routeIs ('adjustments.*')) ? 'has-sub open' : '' }}">
        <a class="d-flex align-items-center" href="javascript:void(0)">
            <i data-feather='git-merge'></i>
            <span class="menu-title text-truncate" data-i18n="Adjustments">Adjustments</span>
        </a>
        <ul class="menu-content">
            @can('viewAllAdjustmentsIncrease', \App\Models\User::class)
                <li class="{{ request () -> routeIs ('adjustments.index') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route ('adjustments.index') }}">
                        <i data-feather="circle"></i>
                        <span class="menu-item text-truncate d-full-text" data-i18n="All Adjustments (Increase)">All Adjustments (Increase)</span>
                    </a>
                </li>
            @endcan

            @can('addAdjustmentsIncrease', \App\Models\User::class)
                <li class="{{ request () -> routeIs ('adjustments.create') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route ('adjustments.create') }}">
                        <i data-feather="circle"></i>
                        <span class="menu-item text-truncate d-full-text" data-i18n="Add Adjustments (Increase)">Add Adjustments (Increase)</span>
                    </a>
                </li>
            @endcan

            @can('viewAllAdjustmentsDecrease', \App\Models\User::class)
                <li class="{{ request () -> routeIs ('adjustments.decrease') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route ('adjustments.decrease') }}">
                        <i data-feather="circle"></i>
                        <span class="menu-item text-truncate d-full-text" data-i18n="All Adjustments (Decrease)">All Adjustments (Decrease)</span>
                    </a>
                </li>
            @endcan

            @can('addAdjustmentsDecrease', \App\Models\User::class)
                <li class="{{ request () -> routeIs ('adjustments.add-decrease') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route ('adjustments.add-decrease') }}">
                        <i data-feather="circle"></i>
                        <span class="menu-item text-truncate d-full-text" data-i18n="Add Adjustments (Decrease)">Add Adjustments (Decrease)</span>
                    </a>
                </li>
            @endcan

            @can('allDamageLoss', \App\Models\User::class)
                <li class="{{ request () -> routeIs ('adjustments.damage-stocks') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route ('adjustments.damage-stocks') }}">
                        <i data-feather="circle"></i>
                        <span class="menu-item text-truncate d-full-text" data-i18n="All Damage/Loss">All Damage/Loss</span>
                    </a>
                </li>
            @endcan

            @can('addDamageLoss', \App\Models\User::class)
                <li class="{{ request () -> routeIs ('adjustments.add-damage-stocks') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route ('adjustments.add-damage-stocks') }}">
                        <i data-feather="circle"></i>
                        <span class="menu-item text-truncate d-full-text" data-i18n="Add Damage/Loss">Add Damage/Loss</span>
                    </a>
                </li>
            @endcan

        </ul>
    </li>
@endcan
