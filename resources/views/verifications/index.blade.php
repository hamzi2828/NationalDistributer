<x-guest :title="$title">
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <div class="auth-wrapper auth-cover">
                    <div class="auth-inner row m-0">
                        <!-- Brand logo-->
                        <a class="brand-logo" href="{{ route ('product-verification') }}">
                            <img src="{{ asset ('/assets/img/ims.png') }}">
                            <h2 class="brand-text text-primary ms-1">{{ config ('app.name') }}</h2>
                        </a>
                        <!-- /Brand logo-->
                        <!-- Left Text-->
                        <div class="d-none d-lg-flex col-lg-8 align-items-center p-5">
                            <div class="w-100 d-lg-flex align-items-center justify-content-center">
                                <img class="img-fluid w-75"
                                     src="{{ asset ('/assets/img/567-5674919_inventory-management-inventory-management-system-png-transparent-png.png') }}"/>
                            </div>
                        </div>
                        <!-- /Left Text-->
                        <!-- Login-->
                        <div class="d-flex col-lg-4 align-items-center auth-bg px-2 p-lg-5">
                            <div class="col-md-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
                                @include('errors.validation-errors')
                                <h2 class="card-title fw-bold mb-1"> Verification 👋</h2>
                                <p class="card-text mb-2">Please enter the license key.</p>
                                <form class="mt-2" action="{{ route ('verify-product') }}" method="post">
                                    @csrf
                                    <div class="mb-1">
                                        <label class="form-label" for="license-key">License Key</label>
                                        <input class="form-control" id="license-key" type="text" name="license-key"
                                               required="required"
                                               autofocus="autofocus" value="{{ old ('license-key') }}"
                                               tabindex="1"/>
                                    </div>
                                    <button class="btn btn-primary w-100">Submit</button>
                                </form>
                            </div>
                        </div>
                        <!-- /Login-->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Content-->
</x-guest>
