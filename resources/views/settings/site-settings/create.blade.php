<x-dashboard :title="$title">
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper p-0">
            <div class="content-body">
                <section id="basic-horizontal-layouts">
                    <div class="row">
                        <div class="col-md-12 col-md-12">
                            @include('errors.validation-errors')
                            <div class="card">
                                <div class="border-bottom-light card-header mb-2 pb-1 pb-1">
                                    <h4 class="card-title">{{ $title }}</h4>
                                </div>
                                <form class="form" method="post" enctype="multipart/form-data"
                                      action="{{ route ('site-settings.store') }}">
                                    @csrf
                                    <div class="card-body pt-0">
                                        <div class="row">
                                            <div class="col-md-10 mb-1">
                                                <div class="row">
                                                    <div class="col-md-3 mb-1">
                                                        <label class="col-form-label font-small-4">Title</label>
                                                        <input type="text" class="form-control" autofocus="autofocus"
                                                               name="title" placeholder="Title"
                                                               value="{{ old ('title', optional($settings -> settings) ?-> title) }}" />
                                                    </div>
                                                    
                                                    <div class="col-md-3 mb-1">
                                                        <label class="col-form-label font-small-4">Email</label>
                                                        <input type="email" class="form-control"
                                                               name="email" placeholder="Email"
                                                               value="{{ old ('email', optional($settings -> settings) ?-> email) }}" />
                                                    </div>
                                                    
                                                    <div class="col-md-3 mb-1">
                                                        <label class="col-form-label font-small-4">Phone</label>
                                                        <input type="text" class="form-control"
                                                               name="phone" placeholder="Phone"
                                                               value="{{ old ('phone', optional($settings -> settings) ?-> phone) }}" />
                                                    </div>

                                                    <div class="col-md-3 mb-1">
                                                        <label class="col-form-label font-small-4">
                                                            Reviews Enable Without Login
                                                        </label>
                                                        <select name="reviews_enable_with_login" class="form-control">
                                                            <option value="0" @selected(old('reviews_enable_with_login', optional($settings->settings)->reviews_enable_with_login) == '0')>
                                                                No
                                                            </option>
                                                            <option value="1" @selected(old('reviews_enable_with_login', optional($settings->settings)->reviews_enable_with_login) == '1')>
                                                                Yes
                                                            </option>
                                                        </select>
                                                    </div>
                                                    


                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-3 mb-1">
                                                        <label class="col-form-label font-small-4">
                                                            Display On PDF Invoices
                                                        </label>
                                                        <select name="display_on_pdf" class="form-control">
                                                            <option
                                                                    value="0" @selected(old ('display_on_pdf', optional($settings -> settings) ?-> display_on_pdf) == '0')>
                                                                No
                                                            </option>
                                                            <option
                                                                    value="1"@selected(old ('display_on_pdf', optional($settings -> settings) ?-> display_on_pdf) == '1')>
                                                                Yes
                                                            </option>
                                                        </select>
                                                    </div>
                                                    
                                                    <div class="col-md-3 mb-1">
                                                        <label class="col-form-label font-small-4">E-Commerce</label>
                                                        <select name="e_commerce" class="form-control">
                                                            <option
                                                                    value="0" @selected(old ('e_commerce', optional ($settings -> settings) -> e_commerce) == '0')>
                                                                No
                                                            </option>
                                                            <option
                                                                    value="1"@selected(old ('e_commerce', optional ($settings -> settings) -> e_commerce) == '1')>
                                                                Yes
                                                            </option>
                                                        </select>
                                                    </div>
                                                    
                                                    <div class="col-md-3 mb-1">
                                                        <label class="col-form-label font-small-4"
                                                               for="display-out-of-stock-products">
                                                            Display Out-of-Stock Products
                                                        </label>
                                                        <select name="display-out-of-stock-products"
                                                                class="form-control select2"
                                                                data-placeholder="Select" required="required"
                                                                id="display-out-of-stock-products">
                                                            <option></option>
                                                            <option value="1" @selected(optional ($settings -> settings) -> display_out_of_stock_products === '1')>
                                                                Yes
                                                            </option>
                                                            <option value="0" @selected(optional ($settings -> settings) -> display_out_of_stock_products === '0')>
                                                                No
                                                            </option>
                                                        </select>
                                                    </div>
                                                    
                                                    <div class="col-md-3 mb-1">
                                                        <label class="col-form-label font-small-4"
                                                               for="display-top-categories">
                                                            Display Top Categories
                                                        </label>
                                                        <select name="display-top-categories"
                                                                class="form-control select2"
                                                                data-placeholder="Select" required="required"
                                                                id="display-top-categories">
                                                            <option></option>
                                                            <option value="1" @selected(optional ($settings -> settings) -> display_top_categories === '1')>
                                                                Yes
                                                            </option>
                                                            <option value="0" @selected(optional ($settings -> settings) -> display_top_categories === '0')>
                                                                No
                                                            </option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-3 mb-1">
                                                        <label class="col-form-label font-small-4" for="display-popup">
                                                            Display Popup
                                                        </label>
                                                        <select name="display_popup" class="form-control select2" data-placeholder="Select" required="required" id="display-popup">
                                                            <option></option>
                                                            <option value="yes" @selected(optional($settings->settings)->display_popup === 'yes')>
                                                                Yes
                                                            </option>
                                                            <option value="no" @selected(optional($settings->settings)->display_popup === 'no')>
                                                                No
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 mb-1">
                                                        <label class="col-form-label font-small-4" for="display-shop-banner">
                                                            Display Shop Banner
                                                        </label>
                                                        <select name="display_shop_banner" class="form-control select2" data-placeholder="Select" required="required" id="display-shop-banner">
                                                            <option></option>
                                                            <option value="yes" @selected(optional($settings->settings)->display_shop_banner === 'yes')>
                                                                Yes
                                                            </option>
                                                            <option value="no" @selected(optional($settings->settings)->display_shop_banner === 'no')>
                                                                No
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 mb-1">
                                                        <label class="col-form-label font-small-4" for="display-shop-categories">
                                                            Display shop Categories
                                                        </label>
                                                        <select name="display_shop_categories" class="form-control select2" data-placeholder="Select" required="required" id="display-shop-categories">
                                                            <option></option>
                                                            <option value="yes" @selected(optional($settings->settings)->display_shop_categories === 'yes')>
                                                                Yes
                                                            </option>
                                                            <option value="no" @selected(optional($settings->settings)->display_shop_categories === 'no')>
                                                                No
                                                            </option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-3 mb-1">
                                                        <label class="col-form-label font-small-4" for="display-prices-without-login">
                                                            Display Prices Without Login
                                                        </label>
                                                        <select name="display_prices_without_login" class="form-control select2" data-placeholder="Select" required="required" id="display-prices-without-login">
                                                            <option></option>
                                                            <option value="yes" @selected(optional($settings->settings)->display_prices_without_login === 'yes')>
                                                                Yes
                                                            </option>
                                                            <option value="no" @selected(optional($settings->settings)->display_prices_without_login === 'no')>
                                                                No
                                                            </option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-6 mb-1">
                                                        <label class="col-form-label font-small-4">Address</label>
                                                        <textarea name="address" class="form-control"
                                                                  rows="3">{{ old ('address', optional($settings -> settings) ?-> address) }}</textarea>
                                                    </div>
                                                    
                                                    <div class="col-md-6 mb-1">
                                                        <label class="col-form-label font-small-4">Invoice PDF Footer
                                                                                                   Content</label>
                                                        <textarea name="pdf-footer-content" class="form-control"
                                                                  rows="3">{{ old ('pdf-footer-content', $settings ?-> settings ?-> pdf_footer_content ?? '') }}</textarea>
                                                    </div>
                                                    
                                                    <div class="col-md-6 mb-1">
                                                        <label class="col-form-label font-small-4">
                                                            TopBar Tagline
                                                        </label>
                                                        <textarea name="tagline" class="form-control"
                                                                  rows="3">{{ old ('tagline', optional ($settings ?-> settings) ?-> tagline ?? 'WELCOME TO WOLMART STORE MESSAGE OR REMOVE IT!') }}</textarea>
                                                    </div>
                                                    
                                                    <div class="col-md-12 mb-1">
                                                        <label class="col-form-label font-small-4">
                                                            Short Description
                                                        </label>
                                                        <textarea name="description" class="form-control"
                                                                  rows="3">{{ old ('description', optional ($settings ?-> settings) ?-> description) }}</textarea>
                                                    </div>
                                                    
                                                    <div class="col-md-12">
                                                        <h2 class="mt-1 mb-1 border-bottom text-danger fw-bolder pb-25">
                                                            Social Media Handles
                                                        </h2>
                                                    </div>
                                                    
                                                    <div class="col-md-6 mb-1">
                                                        <label class="col-form-label font-small-4" for="facebook">
                                                            Facebook
                                                        </label>
                                                        <input type="text" name="facebook" class="form-control"
                                                               id="facebook"
                                                               value="{{ old ('facebook', optional ($settings ?-> settings) ?-> facebook) }}">
                                                    </div>
                                                    
                                                    <div class="col-md-6 mb-1">
                                                        <label class="col-form-label font-small-4" for="twitter">
                                                            Twitter
                                                        </label>
                                                        <input type="text" name="twitter" class="form-control"
                                                               id="twitter"
                                                               value="{{ old ('twitter', optional ($settings ?-> settings) ?-> twitter) }}">
                                                    </div>
                                                    
                                                    <div class="col-md-6 mb-1">
                                                        <label class="col-form-label font-small-4" for="instagram">
                                                            Instagram
                                                        </label>
                                                        <input type="text" name="instagram" class="form-control"
                                                               id="instagram"
                                                               value="{{ old ('instagram', optional ($settings ?-> settings) ?-> instagram) }}">
                                                    </div>
                                                    
                                                    <div class="col-md-6 mb-1">
                                                        <label class="col-form-label font-small-4" for="youtube">
                                                            Youtube
                                                        </label>
                                                        <input type="text" name="youtube" class="form-control"
                                                               id="youtube"
                                                               value="{{ old ('youtube', optional ($settings ?-> settings) ?-> youtube) }}">
                                                    </div>
                                                    
                                                    <div class="col-md-6 mb-1">
                                                        <label class="col-form-label font-small-4" for="pinterest">
                                                            Pinterest
                                                        </label>
                                                        <input type="text" name="pinterest" class="form-control"
                                                               id="pinterest"
                                                               value="{{ old ('pinterest', optional ($settings ?-> settings) ?-> pinterest) }}">
                                                    </div>
                                                    
                                                    <div class="col-md-6 mb-1">
                                                        <label class="col-form-label font-small-4" for="tiktok">
                                                            Tiktok
                                                        </label>
                                                        <input type="text" name="tiktok" class="form-control"
                                                               id="tiktok"
                                                               value="{{ old ('tiktok', optional ($settings ?-> settings) ?-> tiktok) }}">
                                                    </div>
                                                    
                                                    <div class="col-md-6 mb-1">
                                                        <label class="col-form-label font-small-4" for="whatsapp">
                                                            WhatsApp
                                                        </label>
                                                        <input type="text" name="whatsapp" class="form-control"
                                                               id="whatsapp"
                                                               value="{{ old ('tiktok', optional ($settings ?-> settings) ?-> whatsapp) }}">
                                                    </div>
                                                    
                                                    <div class="col-md-12">
                                                        <h2 class="mt-1 mb-1 border-bottom text-danger fw-bolder pb-25">
                                                            Shipping Charges
                                                        </h2>
                                                    </div>
                                                    
                                                    <div class="col-md-4 mb-1">
                                                        <label class="col-form-label font-small-4" for="shipping">
                                                            Shipping
                                                        </label>
                                                        <select name="shipping" class="form-control select2"
                                                                data-placeholder="Select" required="required"
                                                                id="shipping">
                                                            <option></option>
                                                            <option value="0" @selected(optional ($settings -> settings) -> shipping === '0')>
                                                                Free Shipping
                                                            </option>
                                                            <option value="1" @selected(optional ($settings -> settings) -> shipping === '1')>
                                                                Paid Shipping
                                                            </option>
                                                        </select>
                                                    </div>
                                                    
                                                    <div class="col-md-4 mb-1 {{ optional ($settings -> settings) -> shipping === '0' ? 'd-none' : '' }}"
                                                         id="courier-info">
                                                        <label class="col-form-label font-small-4" for="courier-id">
                                                            Courier
                                                        </label>
                                                        <select name="courier-id" class="form-control select2"
                                                                data-placeholder="Select" required="required"
                                                                id="courier-id">
                                                            <option></option>
                                                            @if(count ($couriers) > 0)
                                                                @foreach($couriers as $courier)
                                                                    <option value="{{ $courier -> id }}"
                                                                            @selected(optional ($settings -> settings) -> courier == $courier -> id)>
                                                                        {{ $courier -> title }}
                                                                    </option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                    
                                                    <div class="col-md-4 mb-1">
                                                        <label class="col-form-label font-small-4"
                                                               for="shipping-charges">
                                                            Shipping Charges
                                                        </label>
                                                        <input type="number" step="any" id="shipping-charges"
                                                               value="{{ optional ($settings -> settings) -> shipping_charges ?? '0' }}"
                                                               name="shipping-charges" class="form-control"
                                                                @readonly(optional ($settings -> settings) -> shipping === '0')>
                                                    </div>


                                                    <div class="col-md-12">
                                                        <h2 class="mt-1 mb-1 border-bottom text-danger fw-bolder pb-25">
                                                        Currency
                                                        </h2>
                                                    </div>
                                                    
                                                    <div class="col-md-4 mb-1">
                                                        <label class="col-form-label font-small-4" for="currency">
                                                            Currency
                                                        </label>
                                                        <select name="currency" class="form-control select2"
                                                                data-placeholder="Select" required="required"
                                                                id="currency">
                                                            <option></option>
                                                            <option value="$" @selected(optional($settings->settings)->currency === '$')>
                                                                $ (USD)
                                                            </option>
                                                            <option value="€" @selected(optional($settings->settings)->currency === '€')>
                                                                € (EU)
                                                            </option>
                                                            <option value="£" @selected(optional($settings->settings)->currency === '£')>
                                                                £ (GBP)
                                                            </option>
                                                            <option value="SAR" @selected(optional($settings->settings)->currency === 'SAR')>
                                                                SAR (ریال)
                                                            </option>
                                                            <option value="AED" @selected(optional($settings->settings)->currency === 'AED')>
                                                                AED (درہم)
                                                            </option>
                                                            <option value="Rs" @selected(optional($settings->settings)->currency === 'Rs')>
                                                                RS (PKR)
                                                            </option>
                                                            <option value="AUD" @selected(optional($settings->settings)->currency === 'AUD')>
                                                                $ (AUD)
                                                            </option>
                                                            <option value="¥" @selected(optional($settings->settings)->currency === '¥')>
                                                                ¥ (CYN)
                                                            </option>
                                                            <option value="INR" @selected(optional($settings->settings)->currency === 'INR')>
                                                                RS (INR)
                                                            </option>
                                                        </select>
                                                    </div>
                                                    


                                                  
                                                    
                                                    
                                                    
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-2 mb-1">
                                                <div
                                                        class="align-items-center border d-flex flex-column justify-content-center pt-50 rounded-2">
                                                    <div class="custom-avatar">
                                                        <img
                                                                src="{{ optional ($settings -> settings) -> logo ? asset ($settings -> settings -> logo) : asset ('/assets/img/default-thumbnail.jpg') }}"
                                                                id="account-upload-img"
                                                                class="uploadedAvatar rounded"
                                                                alt="logo image"
                                                                width="150"
                                                        />
                                                        <div class="mt-1">
                                                            <label for="account-upload"
                                                                   class="btn btn-sm btn-primary mb-75 me-25">Upload</label>
                                                            <input type="file" id="account-upload" hidden="hidden"
                                                                   name="logo"
                                                                   accept="image/*" />
                                                            <button type="button" id="account-reset"
                                                                    class="btn btn-sm btn-outline-secondary mb-75">Reset
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div
                                                        class="align-items-center border d-flex flex-column justify-content-center pt-50 rounded-2 mt-2">
                                                    <div class="custom-avatar">
                                                        <img
                                                                src="{{ optional ($settings -> settings) -> sidebar_image ? asset ($settings -> settings -> sidebar_image) : asset ('/assets/img/default-thumbnail.jpg') }}"
                                                                id="account-upload-img"
                                                                class="uploadedAvatar rounded"
                                                                alt="logo image"
                                                                width="150"
                                                        />
                                                        <div class="mt-1">
                                                            <label for="sidebar-image"
                                                                   class="btn btn-sm btn-primary mb-75 me-25 w-100">Upload</label>
                                                            <input type="file" id="sidebar-image" hidden="hidden"
                                                                   name="sidebar-image"
                                                                   accept="image/*" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary me-1">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    @push('scripts')
        <script type="text/javascript">
            $ ( '#shipping' ).on ( 'change', function () {
                let shipping = $ ( this ).val ();
                
                if ( parseInt ( shipping ) === 1 ) {
                    $ ( '#shipping-charges' ).prop ( 'readonly', false );
                    $ ( '#courier-info' ).removeClass ( 'd-none' );
                }
                else {
                    $ ( '#shipping-charges' ).val ( '0' );
                    $ ( '#shipping-charges' ).prop ( 'readonly', true );
                    $ ( '#courier-info' ).addClass ( 'd-none' );
                }
            } );
        </script>
    @endpush
</x-dashboard>
