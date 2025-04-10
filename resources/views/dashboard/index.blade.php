<x-dashboard :title="$title">
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper p-0">
            <div class="content-header row">
            </div>
            <div class="content-body"><!-- Dashboard Ecommerce Starts -->
                <section id="dashboard-ecommerce">

                    <div class="row pe-0">
                        <!-- Statistics Card -->
                        <div class="col-xl-12 col-md-12 col-md-12">
                            <div class="card card-statistics">
                                <div class="card-body statistics-body" style="padding-bottom: 0 !important;">
                                    <div class="row">
                                        <div class="col-xl-3 col-sm-6 col-md-12 mb-2 mb-xl-0">
                                            <div class="d-flex flex-row">
                                                <div class="avatar bg-light-primary me-2">
                                                    <div class="avatar-content">
                                                        <i data-feather="box" class="avatar-icon"></i>
                                                    </div>
                                                </div>
                                                <div class="my-auto">
                                                    <h4 class="fw-bolder mb-0 open-orders-count">
                                                        <i data-feather='loader'></i>
                                                    </h4>
                                                    <p class="card-text font-small-3 mb-0">Open Orders</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-sm-6 col-md-12 mb-2">
                                            <div class="d-flex flex-row">
                                                <div class="avatar bg-light-success me-2">
                                                    <div class="avatar-content">
                                                        <i data-feather="dollar-sign" class="avatar-icon"></i>
                                                    </div>
                                                </div>
                                                <div class="my-auto">
                                                    <h4 class="fw-bolder mb-0 closed-orders-count">
                                                        <i data-feather='loader'></i>
                                                    </h4>
                                                    <p class="card-text font-small-3 mb-0">Closed Orders</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-sm-6 col-md-12 mb-2 mb-xl-0">
                                            <div class="d-flex flex-row">
                                                <div class="avatar bg-light-info me-2">
                                                    <div class="avatar-content">
                                                        <i data-feather="credit-card" class="avatar-icon"></i>
                                                    </div>
                                                </div>
                                                <div class="my-auto">
                                                    <h4 class="fw-bolder mb-0 payable-count">
                                                        <i data-feather='loader'></i>
                                                    </h4>
                                                    <p class="card-text font-small-3 mb-0">Payable</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-sm-6 col-md-12 mb-2 mb-sm-0">
                                            <div class="d-flex flex-row">
                                                <div class="avatar bg-light-danger me-2">
                                                    <div class="avatar-content">
                                                        <i data-feather="rotate-ccw" class="avatar-icon"></i>
                                                    </div>
                                                </div>
                                                <div class="my-auto">
                                                    <h4 class="fw-bolder mb-0 receivable-count">
                                                        <i data-feather='loader'></i>
                                                    </h4>
                                                    <p class="card-text font-small-3 mb-0">Receivable</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/ Statistics Card -->
                    </div>

                    <div class="row pe-0">
                        <!-- Medal Card -->
                        <div class="col-xl-4 col-md-6 col-md-12">
                            <div class="row mx-0">
                                <div class="card card-congratulation-medal">
                                    <div class="card-body">
                                        <h5>Welcome 🎉 <u>{{ auth () -> user () -> name }}!</u></h5>
                                        <p class="card-text font-small-3">
                                            {{ !in_array ( 'admin', auth () -> user () -> user_roles () ) ? 'Daily' : 'Total' }}
                                            Sales Value
                                        </p>
                                        <h3 class="mb-75 mt-2 pt-50">
                                            <a href="{{ route ('sales.index') }}" class="sales-count">
                                                <i data-feather='loader'></i>
                                            </a>
                                        </h3>
                                        <a href="{{ route ('sales.index') }}" class="btn btn-primary">View Sales</a>
                                        <img src="https://pixinvent.com/demo/vuexy-html-bootstrap-admin-template/assets/img/illustrations/card-advance-sale.png"
                                             class="congratulation-medal bottom-0" alt="Medal Pic"
                                             style="height: 140px; top: unset"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-md-6">
                                    <div class="card">
                                        <div class="card-body pb-50">
                                            <h6>Today Orders</h6>
                                            <h2 class="fw-bolder mb-1 daily-sales-count">
                                                <i data-feather='loader'></i>
                                            </h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-md-6">
                                    <div class="card card-tiny-line-stats">
                                        <div class="card-body pb-50">
                                            <h6>Daily Profit</h6>
                                            <h2 class="fw-bolder mb-1 daily-profit-count">
                                                <i data-feather='loader'></i>
                                            </h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-md-6">
                                    <div class="card">
                                        <div class="card-body pb-50">
                                            <h6>Inventory Value (TP Wise)</h6>
                                            <h2 class="fw-bolder mb-1 inventory-value-tp-wise">
                                                <i data-feather='loader'></i>
                                            </h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-md-6">
                                    <div class="card card-tiny-line-stats">
                                        <div class="card-body pb-50">
                                            <h6>Inventory Value (Sale Wise)</h6>
                                            <h2 class="fw-bolder mb-1 inventory-value-sale-wise">
                                                <i data-feather='loader'></i>
                                            </h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/ Medal Card -->

                        <!-- Statistics Card -->
                        <div class="col-xl-8 col-md-8 col-md-12">
                            <div class="card card-statistics">
                                <!-- Revenue Report Card -->
                                <div class="col-lg-12 col-md-12 pe-0 border-top">
                                    <div class="card card-revenue-budget">
                                        <div class="row mx-0">
                                            <div class="col-md-12 col-md-12 revenue-report-wrapper">
                                                <div class="d-sm-flex justify-content-between align-items-center mb-1">
                                                    <h4 class="card-title mb-50 mb-sm-0">Sales, Cash in Hand & Expanse Report</h4>
                                                </div>
                                                <div id="revenue-report-chart"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--/ Revenue Report Card -->
                            </div>
                        </div>
                        <!--/ Statistics Card -->
                    </div>

                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-md-12">
                            <div class="card">
                                <div class="card-header d-flex flex-sm-row flex-column justify-content-md-between align-items-start justify-content-start">
                                    <div>
                                        <h4 class="card-title mb-25">Daily Sales</h4>
                                        <span class="card-subtitle text-muted">Daily Closed Sales</span>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div id="daily-sales-chart"></div>
                                </div>
                            </div>
                            <!--/ Statistics Card -->
                        </div>
                    </div>

                    <div class="row match-height">
                        <!-- Statistics Card -->
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header d-flex flex-sm-row flex-column justify-content-md-between align-items-start justify-content-start">
                                    <div>
                                        <h4 class="card-title mb-25">Monthly Sales</h4>
                                        <span class="card-subtitle text-muted">Monthly Closed Sales</span>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div id="line-chart"></div>
                                </div>
                            </div>
                            <!--/ Statistics Card -->
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-md-12 pe-0">
                            <div class="card card-company-table">
                                <div class="card-body p-0">
                                    <h4 class="card-title mb-0 pt-1 ps-1 pb-1">Top Selling Products</h4>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th class="text-start">Product</th>
                                                <th class="text-center">Qty</th>
                                                <th class="text-end">Revenue</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if(count ($top_selling) > 0)
                                                @foreach($top_selling as $selling)
                                                    <tr>
                                                        <td class="text-start text-nowrap d-flex flex-column">
                                                            <span class="font-small-3">
                                                                {{ $selling -> product -> productTitle() }}
                                                            </span>
                                                        </td>
                                                        <td class="text-center">
                                                            {{ number_format ($selling -> quantity) }}
                                                        </td>
                                                        <td class="text-end">
                                                            {{ number_format ($selling -> net_price, 2) }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-md-12 pe-0">
                            <div class="card card-company-table">
                                <div class="card-body p-0">
                                    <h4 class="card-title mb-0 pt-1 ps-1 pb-1">Top Selling Attributes</h4>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>Attribute</th>
                                                <th class="text-center">Sale Quantity</th>
                                                <th class="text-end">Revenue</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if(count ($top_selling_attributes) > 0)
                                                @foreach($top_selling_attributes as $top_selling_attribute)
                                                    <tr>
                                                        <td class="text-nowrap d-flex flex-column">
                                                            <span class="font-small-3">
                                                                {{ $top_selling_attribute -> title }}
                                                            </span>
                                                        </td>
                                                        <td align="center">
                                                            {{ number_format ($top_selling_attribute -> quantity) }}
                                                        </td>
                                                        <td align="right">
                                                            {{ number_format (($top_selling_attribute -> net - $top_selling_attribute -> discount), 2) }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Dashboard Ecommerce ends -->

            </div>
        </div>
    </div>
    <!-- END: Content-->
    @push('scripts')
        <script src="{{ asset('/app-assets/vendors/js/charts/apexcharts.min.js') }}"></script>
        <script type="text/javascript">
            let t = "#f3f3f3";
            let p = "#b9b9c3";
        </script>
    @endpush
</x-dashboard>
