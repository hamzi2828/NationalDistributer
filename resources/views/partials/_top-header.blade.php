<!-- BEGIN: Header-->
<nav class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-light navbar-shadow">
    <div class="navbar-container d-flex content">
        <div class="bookmark-wrapper d-flex align-items-center">
            <ul class="nav navbar-nav d-xl-none">
                <li class="nav-item">
                    <a class="nav-link menu-toggle" href="#">
                        <i class="ficon" data-feather="menu"></i>
                    </a>
                </li>
            </ul>
        </div>

        <ul class="nav navbar-nav align-items-center ms-auto">
            <li class="nav-item d-none d-lg-block">
                <a class="nav-link nav-link-style" href="javascript:void(0)" id="toggleTheme">
                    <i class="ficon" data-feather="moon"></i>
                </a>
            </li>

            <!-- Open Sales Notification -->
            <li class="nav-item dropdown dropdown-notification me-25" id="openSalesNotification">
                <a class="nav-link" href="#" data-bs-toggle="dropdown">
                    <i class="ficon" data-feather="shopping-cart"></i>
                    <span class="badge rounded-pill bg-danger badge-up" id="openSalesCount">0</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-media dropdown-menu-end">
                    <li class="dropdown-menu-header">
                        <div class="dropdown-header d-flex">
                            <h4 class="notification-title mb-0 me-auto">New Orders</h4>
                            <div class="badge rounded-pill badge-light-danger" id="openSalesCountHeader">0</div>
                        </div>
                    </li>
                    <li class="scrollable-container media-list" id="openSalesList">
                        <!-- Open sales will be populated here -->
                    </li>
                    {{-- <li class="dropdown-menu-footer">
                        <a class="btn btn-primary w-100" href="{{ route('sales.index') }}">View all open sales</a>
                    </li> --}}
                </ul>
            </li>

            {{-- <li class="nav-item dropdown dropdown-notification me-25">
                <a class="nav-link" href="#" data-bs-toggle="dropdown">
                    <i class="ficon" data-feather="bell"></i>
                    <span class="badge rounded-pill bg-danger badge-up">5</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-media dropdown-menu-end">
                    <li class="dropdown-menu-header">
                        <div class="dropdown-header d-flex">
                            <h4 class="notification-title mb-0 me-auto">Notifications</h4>
                            <div class="badge rounded-pill badge-light-primary">6 New</div>
                        </div>
                    </li>
                    <li class="scrollable-container media-list">
                        <a class="d-flex" href="#">
                            <div class="list-item d-flex align-items-start">
                                <div class="me-1">
                                    <div class="avatar">
                                        <img src="{{ asset('/app-assets/images/portrait/small/avatar-s-15.jpg') }}"
                                             alt="avatar" width="32" height="32">
                                    </div>
                                </div>
                                <div class="list-item-body flex-grow-1">
                                    <p class="media-heading"><span class="fw-bolder">Congratulation Sam 🎉</span>winner!
                                    </p><small class="notification-text"> Won the monthly best seller badge.</small>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="dropdown-menu-footer">
                        <a class="btn btn-primary w-100" href="#">Read all notifications</a>
                    </li>
                </ul>
            </li> --}}
            <li class="nav-item dropdown dropdown-user">
                <a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="#"
                   data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="user-nav d-sm-flex d-none">
                        <span class="user-name fw-bolder">{{ auth () -> user () -> name }}</span>
                        @if(count (auth () -> user () -> get_user_roles()) > 0)
                            <span class="user-status">{{ implode (',', auth () -> user () -> get_user_roles()) }}</span>
                        @endif
                    </div>
                    <span class="avatar">
                        <img class="round"
                             src="{{ !empty(trim (auth () -> user () -> avatar)) ? asset (auth () -> user () -> avatar) : asset('/app-assets/images/portrait/small/avatar-s-11.jpg') }}"
                             alt="avatar" height="40" width="40">
                        <span class="avatar-status-online"></span>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-user">
                    <a class="dropdown-item" href="#">
                        <i class="me-50" data-feather="user"></i> Profile
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route ('logout') }}">
                        <i class="me-50" data-feather="power"></i> Logout
                    </a>
                </div>
            </li>
        </ul>
    </div>
</nav>

<!-- Open Sales Notification Script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initial fetch
        fetchOpenSales();

        // Set interval to fetch every 3 seconds
        setInterval(fetchOpenSales, 3000);

        function fetchOpenSales() {
            fetch('/analytics/get_open_sales')
                .then(response => response.json())
                .then(data => {
                    // Update count badges
                    document.getElementById('openSalesCount').textContent = data.count;
                    document.getElementById('openSalesCountHeader').textContent = data.count + ' New';

                    // Clear previous list
                    const salesList = document.getElementById('openSalesList');
                    salesList.innerHTML = '';

                    // Add sales to the list
                    if (data.sales.length > 0) {
                        data.sales.forEach(sale => {
                            const saleItem = document.createElement('a');
                            saleItem.className = 'd-flex';
                            saleItem.href = '/sales';

                            saleItem.innerHTML = `
                                <div class="list-item d-flex align-items-start">
                                    <div class="me-1">
                                        <div class="avatar bg-light-danger">
                                            <div class="avatar-content"><i data-feather="shopping-cart"></i></div>
                                        </div>
                                    </div>
                                    <div class="list-item-body flex-grow-1">
                                        <p class="media-heading"><span class="fw-bolder">New Order</span></p>
                                        <small class="notification-text">Order #${sale.order_no}</small>
                                    </div>
                                </div>
                            `;

                            salesList.appendChild(saleItem);

                            // Initialize feather icons for the new elements
                            if (typeof feather !== 'undefined') {
                                feather.replace();
                            }
                        });
                    } else {
                        salesList.innerHTML = '<div class="text-center p-2">No New Order found</div>';
                    }
                })
                .catch(error => {
                    console.error('Error fetching open sales:', error);
                });
        }
    });
</script>
<!-- END: Header-->
