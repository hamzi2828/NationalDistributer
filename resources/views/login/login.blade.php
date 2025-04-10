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

                      
                            <a class="brand-logo" href="{{ route ('login') }}">
                                <img src="{{ asset ('/assets/img/ims.png') }}">
                                {{-- <h2 class="brand-text text-primary ms-1">{{ config ('app.name') }}</h2> --}}
                                <h2 class="brand-text text-primary ms-1">Inventory Management System</h2>
    
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
                                <h2 class="card-title fw-bold mb-1">National Distributors 🌸️️</h2>
                                <p class="card-text mb-2">Please sign-in to your account.</p>
                                <form class="auth-login-form mt-2" action="{{ route ('authenticate.user') }}"
                                      method="post" id="login-form">
                                    @csrf
                                    <div class="mb-1">
                                        <label class="form-label" for="login-email">Email</label>
                                        <input class="form-control" id="login-email" type="text" name="login-email"
                                               placeholder="john@example.com" aria-describedby="login-email"
                                               autofocus="autofocus" value="{{ old ('login-email') }}"
                                               tabindex="1"/>
                                    </div>
                                    <div class="mb-1">
                                        <div class="d-flex justify-content-between">
                                            <label class="form-label" for="login-password">Password</label>
                                        </div>
                                        <div class="input-group input-group-merge form-password-toggle">
                                            <input class="form-control form-control-merge" id="login-password"
                                                   type="password" name="login-password" placeholder="············"
                                                   aria-describedby="login-password" tabindex="2"/>
                                            <span class="input-group-text cursor-pointer">
                                                <i data-feather="eye"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="mb-1">
                                        <div class="form-check">
                                            <input class="form-check-input" id="remember-me" name="remember-me"
                                                   type="checkbox" checked="checked"
                                                   tabindex="3"/>
                                            <label class="form-check-label" for="remember-me"> Remember Me</label>
                                        </div>
                                    </div>
                        {{--  <button class="btn btn-primary w-100" tabindex="4">Sign in</button>--}}
                                    <button class="btn btn-primary w-100 g-recaptcha"
                                            {{-- data-sitekey="6LcPV_IpAAAAAC55848kihvlcqe5y9aN0z77eGMI" --}}
                                            data-callback='login'
                                            data-action='submit'>Submit
                                    </button>
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