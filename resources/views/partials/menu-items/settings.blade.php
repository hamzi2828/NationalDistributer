@if(in_array ('settings-privilege', auth () -> user () -> permissions()) || in_array ( 'admin', auth () -> user () -> user_roles () ))
    <li class="nav-item {{ (str_replace ('/', '', request () -> route () -> getPrefix ()) == 'settings') ? 'has-sub open' : '' }}">
        <a class="d-flex align-items-center" href="javascript:void(0)">
            <i data-feather='settings'></i>
            <span class="menu-title text-truncate" data-i18n="Settings">Settings</span>
        </a>
        <ul class="menu-content">
            @can('viewCategoryMenu', \App\Models\Category::class)
                <li class="{{ request () -> routeIs ('categories.*') ? 'has-sub open' : '' }}">
                    <a class="d-flex align-items-center" href="javascript:void(0)">
                        <i data-feather="list"></i>
                        <span class="menu-item text-truncate" data-i18n="Categories">Categories</span>
                    </a>
                    <ul class="menu-content">
                        @can('viewAllCategories', \App\Models\Category::class)
                            <li class="{{ request () -> routeIs ('categories.index') ? 'active' : '' }}">
                                <a class="d-flex align-items-center" href="{{ route ('categories.index') }}">
                                    <i data-feather="circle"></i>
                                    <span class="menu-item text-truncate"
                                          data-i18n="All Categories">All Categories</span>
                                </a>
                            </li>
                        @endcan
                        @can('create', \App\Models\Category::class)
                            <li class="{{ request () -> routeIs ('categories.create') ? 'active' : '' }}">
                                <a class="d-flex align-items-center" href="{{ route ('categories.create') }}">
                                    <i data-feather="circle"></i>
                                    <span class="menu-item text-truncate"
                                          data-i18n="Add Categories">Add Categories</span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan

            @can('viewAttributeMenu', \App\Models\Attribute::class)
                <li class="{{ request () -> routeIs ('attributes.*') ? 'has-sub open' : '' }}">
                    <a class="d-flex align-items-center" href="#">
                        <i data-feather="git-pull-request"></i>
                        <span class="menu-item text-truncate" data-i18n="Attributes">Attributes</span>
                    </a>
                    <ul class="menu-content">
                        @can('viewAllAttributes', \App\Models\Attribute::class)
                            <li class="{{ request () -> routeIs ('attributes.index') ? 'active' : '' }}">
                                <a class="d-flex align-items-center" href="{{ route ('attributes.index') }}">
                                    <i data-feather="circle"></i>
                                    <span class="menu-item text-truncate"
                                          data-i18n="All Attributes">All Attributes</span>
                                </a>
                            </li>
                        @endcan
                        @can('create', \App\Models\Attribute::class)
                            <li class="{{ request () -> routeIs ('attributes.create') ? 'active' : '' }}">
                                <a class="d-flex align-items-center" href="{{ route ('attributes.create') }}">
                                    <i data-feather="circle"></i>
                                    <span class="menu-item text-truncate"
                                          data-i18n="Add Attributes">Add Attributes</span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan

            @can('viewTermMenu', \App\Models\Term::class)
                <li class="{{ request () -> routeIs ('terms.*') ? 'has-sub open' : '' }}">
                    <a class="d-flex align-items-center" href="#">
                        <i data-feather="command"></i>
                        <span class="menu-item text-truncate" data-i18n="Terms">Terms</span>
                    </a>
                    <ul class="menu-content">
                        @can('viewAllTerms', \App\Models\Term::class)
                            <li class="{{ request () -> routeIs ('terms.index') ? 'active' : '' }}">
                                <a class="d-flex align-items-center" href="{{ route ('terms.index') }}">
                                    <i data-feather="circle"></i>
                                    <span class="menu-item text-truncate"
                                          data-i18n="All Terms">All Terms</span>
                                </a>
                            </li>
                        @endcan
                        @can('create', \App\Models\Term::class)
                            <li class="{{ request () -> routeIs ('terms.create') ? 'active' : '' }}">
                                <a class="d-flex align-items-center" href="{{ route ('terms.create') }}">
                                    <i data-feather="circle"></i>
                                    <span class="menu-item text-truncate"
                                          data-i18n="Add Terms">Add Terms</span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan

            @can('viewManufacturerMenu', \App\Models\Manufacturer::class)
                <li class="{{ request () -> routeIs ('manufacturers.*') ? 'has-sub open' : '' }}">
                    <a class="d-flex align-items-center" href="#">
                        <i data-feather="truck"></i>
                        <span class="menu-item text-truncate" data-i18n="Manufacturers">Manufacturers</span>
                    </a>
                    <ul class="menu-content">
                        @can('viewAllManufacturers', \App\Models\Manufacturer::class)
                            <li class="{{ request () -> routeIs ('manufacturers.index') ? 'active' : '' }}">
                                <a class="d-flex align-items-center" href="{{ route ('manufacturers.index') }}">
                                    <i data-feather="circle"></i>
                                    <span class="menu-item text-truncate"
                                          data-i18n="All Manufacturers">All Manufacturers</span>
                                </a>
                            </li>
                        @endcan
                        @can('create', \App\Models\Manufacturer::class)
                            <li class="{{ request () -> routeIs ('manufacturers.create') ? 'active' : '' }}">
                                <a class="d-flex align-items-center" href="{{ route ('manufacturers.create') }}">
                                    <i data-feather="circle"></i>
                                    <span class="menu-item text-truncate"
                                          data-i18n="Add Manufacturers">Add Manufacturers</span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan

            @can('viewBranchMenu', \App\Models\Branch::class)
                <li class="{{ request () -> routeIs ('branches.*') ? 'has-sub open' : '' }}">
                    <a class="d-flex align-items-center" href="#">
                        <i data-feather="git-branch"></i>
                        <span class="menu-item text-truncate" data-i18n="Branches">Branches</span>
                    </a>
                    <ul class="menu-content">
                        @can('viewAllBranches', \App\Models\Branch::class)
                            <li class="{{ request () -> routeIs ('branches.index') ? 'active' : '' }}">
                                <a class="d-flex align-items-center" href="{{ route ('branches.index') }}">
                                    <i data-feather="circle"></i>
                                    <span class="menu-item text-truncate" data-i18n="All Branches">All Branches</span>
                                </a>
                            </li>
                        @endcan
                        @can('create', \App\Models\Branch::class)
                            <li class="{{ request () -> routeIs ('branches.create') ? 'active' : '' }}">
                                <a class="d-flex align-items-center" href="{{ route ('branches.create') }}">
                                    <i data-feather="circle"></i>
                                    <span class="menu-item text-truncate" data-i18n="Add Branches">Add Branches</span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan

            @can('viewCountriesMenu', \App\Models\Country::class)
                <li class="{{ request () -> routeIs ('countries.*') ? 'has-sub open' : '' }}">
                    <a class="d-flex align-items-center" href="javascript:void(0)">
                        <i data-feather="globe"></i>
                        <span class="menu-item text-truncate" data-i18n="Countries">Countries</span>
                    </a>
                    <ul class="menu-content">
                        @can('viewAllCountries', \App\Models\Country::class)
                            <li class="{{ request () -> routeIs ('countries.index') ? 'active' : '' }}">
                                <a class="d-flex align-items-center" href="{{ route ('countries.index') }}">
                                    <i data-feather="circle"></i>
                                    <span class="menu-item text-truncate" data-i18n="All Countries">All Countries</span>
                                </a>
                            </li>
                        @endcan
                        @can('create', \App\Models\Country::class)
                            <li class="{{ request () -> routeIs ('countries.create') ? 'active' : '' }}">
                                <a class="d-flex align-items-center" href="{{ route ('countries.create') }}">
                                    <i data-feather="circle"></i>
                                    <span class="menu-item text-truncate" data-i18n="Add Countries">Add Countries</span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan


            <li class="{{ request()->routeIs('taxes.*') ? 'has-sub open' : '' }}">
                <a class="d-flex align-items-center" href="javascript:void(0)">
                    <i data-feather="percent"></i>
                    <span class="menu-item text-truncate" data-i18n="Taxes">Taxes</span>
                </a>
                <ul class="menu-content">
                    {{-- @can('viewAllTaxes', \App\Models\Tax::class) --}}
                        <li class="{{ request()->routeIs('taxes.index') ? 'active' : '' }}">
                            <a class="d-flex align-items-center" href="{{ route('taxes.index') }}">
                                <i data-feather="circle"></i>
                                <span class="menu-item text-truncate" data-i18n="All Taxes">All Taxes</span>
                            </a>
                        </li>
                    {{-- @endcan --}}
                    {{-- @can('create', \App\Models\Tax::class) --}}
                        <li class="{{ request()->routeIs('taxes.create') ? 'active' : '' }}">
                            <a class="d-flex align-items-center" href="{{ route('taxes.create') }}">
                                <i data-feather="circle"></i>
                                <span class="menu-item text-truncate" data-i18n="Add Tax">Add Tax</span>
                            </a>
                        </li>

                        <li class="{{ request()->routeIs('taxes.apply') ? 'active' : '' }}">
                            <a class="d-flex align-items-center" href="{{ route('taxes.apply') }}">
                                <i data-feather="circle"></i>
                                <span class="menu-item text-truncate" data-i18n="Apply Tax">Apply Tax</span>
                            </a>
                        </li>

                    {{-- @endcan --}}
                </ul>
            </li>


            @can('menu', \App\Models\Courier::class)
                <li class="{{ request () -> routeIs ('couriers.*') ? 'has-sub open' : '' }}">
                    <a class="d-flex align-items-center" href="javascript:void(0)">
                        <i data-feather="truck"></i>
                        <span class="menu-item text-truncate" data-i18n="Couriers">Couriers</span>
                    </a>
                    <ul class="menu-content">
                        @can('all', \App\Models\Courier::class)
                            <li class="{{ request () -> routeIs ('couriers.index') ? 'active' : '' }}">
                                <a class="d-flex align-items-center" href="{{ route ('couriers.index') }}">
                                    <i data-feather="circle"></i>
                                    <span class="menu-item text-truncate" data-i18n="All Couriers">All Couriers</span>
                                </a>
                            </li>
                        @endcan
                        @can('create', \App\Models\Courier::class)
                            <li class="{{ request () -> routeIs ('couriers.create') ? 'active' : '' }}">
                                <a class="d-flex align-items-center" href="{{ route ('couriers.create') }}">
                                    <i data-feather="circle"></i>
                                    <span class="menu-item text-truncate" data-i18n="Add Couriers">Add Couriers</span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan

            @can('menu', \App\Models\Coupon::class)
                <li class="{{ request () -> routeIs ('coupons.*') ? 'has-sub open' : '' }}">
                    <a class="d-flex align-items-center" href="javascript:void(0)">
                        <i data-feather="percent"></i>
                        <span class="menu-item text-truncate" data-i18n="Coupons">Coupons</span>
                    </a>
                    <ul class="menu-content">
                        @can('all', \App\Models\Coupon::class)
                            <li class="{{ request () -> routeIs ('coupons.index') ? 'active' : '' }}">
                                <a class="d-flex align-items-center" href="{{ route ('coupons.index') }}">
                                    <i data-feather="circle"></i>
                                    <span class="menu-item text-truncate" data-i18n="All Coupons">All Coupons</span>
                                </a>
                            </li>
                        @endcan
                        @can('create', \App\Models\Coupon::class)
                            <li class="{{ request () -> routeIs ('coupons.create') ? 'active' : '' }}">
                                <a class="d-flex align-items-center" href="{{ route ('coupons.create') }}">
                                    <i data-feather="circle"></i>
                                    <span class="menu-item text-truncate" data-i18n="Add Coupons">Add Coupons</span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan

            @can('viewMenu', \App\Models\Page::class)
                <li class="{{ request () -> routeIs ('pages.*') ? 'has-sub open' : '' }}">
                    <a class="d-flex align-items-center" href="javascript:void(0)">
                        <i data-feather="layout"></i>
                        <span class="menu-item text-truncate" data-i18n="Pages">Pages</span>
                    </a>
                    <ul class="menu-content">
                        @can('all', \App\Models\Page::class)
                            <li class="{{ request () -> routeIs ('pages.index') ? 'active' : '' }}">
                                <a class="d-flex align-items-center" href="{{ route ('pages.index') }}">
                                    <i data-feather="circle"></i>
                                    <span class="menu-item text-truncate" data-i18n="All Pages">All Pages</span>
                                </a>
                            </li>
                        @endcan
                        @can('create', \App\Models\Page::class)
                            <li class="{{ request () -> routeIs ('pages.create') ? 'active' : '' }}">
                                <a class="d-flex align-items-center" href="{{ route ('pages.create') }}">
                                    <i data-feather="circle"></i>
                                    <span class="menu-item text-truncate" data-i18n="Add Pages">Add Pages</span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan

            @can('create', \App\Models\SiteSettings::class)
                <li class="{{ request () -> routeIs ('site-settings.create') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route ('site-settings.create') }}">
                        <i data-feather="cpu"></i>
                        <span class="menu-item text-truncate"
                              data-i18n="Site Settings">Site Settings</span>
                    </a>
                </li>
            @endcan

            @can('create', \App\Models\HomeSetting::class)
                <li class="{{ request () -> routeIs ('home-settings.create') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route ('home-settings.create') }}">
                        <i data-feather="cpu"></i>
                        <span class="menu-item text-truncate"
                              data-i18n="Home Page Settings">Home Page Settings</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('home-settings.newsletter_email') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route('home-settings.newsletter_email') }}">
                        <i data-feather="mail"></i> <!-- Updated icon -->
                        <span class="menu-item text-truncate" data-i18n="News Letter Settings">News Letter Email</span>
                    </a>
                </li>

            @endcan

        </ul>
    </li>
@endif
