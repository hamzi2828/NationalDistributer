<x-dashboard :title="$title">
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper p-0">
            <div class="content-header row"></div>
            <div class="content-body">
                <section id="dashboard-ecommerce">
                    <div class="row pe-0">
                        <!-- Statistics Card -->
                        <div class="col-xl-12 col-md-12 col-md-12">
                            <div class="d-flex justify-content-center align-items-center">
                                <img src="{{ asset ('/assets/img/home-logo.png') }}" alt="Logo" style="max-height: 450px; max-width: 100%">
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</x-dashboard>
