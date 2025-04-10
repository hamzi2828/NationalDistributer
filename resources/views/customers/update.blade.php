<x-dashboard :title="$title">
    @push('styles')
        <style>
            .select2-container--default .select2-results > .select2-results__options {
                max-height : 300px;
            }
        </style>
    @endpush
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
                                      action="{{ route ('customers.update', ['customer' => $customer -> id]) }}">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" id="customer-id" value="{{ $customer -> id }}">
                                    <div class="card-body pt-0">
                                        <div class="row">
                                            <div class="col-md-9">
                                                <div class="row">
                                                    <div class="col-md-4 mb-1">
                                                        <label class="col-form-label font-small-4">Company Name</label>
                                                        <input type="text" class="form-control"
                                                               required="required" autofocus="autofocus"
                                                               name="name" placeholder="Company Name"
                                                               value="{{ old ('name', $customer -> name) }}" />
                                                    </div>
                                                    
                                                    <div class="col-md-4 mb-1">
                                                        <label class="col-form-label font-small-4">License No</label>
                                                        <input type="text" class="form-control"
                                                               name="license" placeholder="License No"
                                                               value="{{ old ('license', $customer -> license) }}" />
                                                    </div>
                                                    
                                                    <div class="col-md-4 mb-1">
                                                        <label class="col-form-label font-small-4">Email</label>
                                                        <input type="email" class="form-control"
                                                               name="email" placeholder="Email"
                                                               value="{{ old ('email', $customer -> email) }}" />
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-4 mb-1">
                                                        <label class="col-form-label font-small-4">Phone No.</label>
                                                        <input type="text" class="form-control"
                                                               name="phone" placeholder="Phone No"
                                                               value="{{ old ('phone', $customer -> phone) }}" />
                                                    </div>
                                                    
                                                    <div class="col-md-4 mb-1">
                                                        <label class="col-form-label font-small-4">Mobile No.</label>
                                                        <input type="text" class="form-control"
                                                               name="mobile" placeholder="Mobile No"
                                                               value="{{ old ('mobile', $customer -> mobile) }}" />
                                                    </div>
                                                    
                                                    <div class="col-md-4 mb-1">
                                                        <label class="col-form-label font-small-4">Representative
                                                                                                   Name</label>
                                                        <input type="text" class="form-control"
                                                               name="representative" placeholder="Representative Name"
                                                               value="{{ old ('representative', $customer -> representative) }}" />
                                                    </div>
                                                    
                                                    <div class="col-md-4 mb-1 d-none">
                                                        <label class="col-form-label font-small-4">Gender</label>
                                                        <select name="gender" class="form-control select2"
                                                                required="required">
                                                            <option value="male" @selected(old ('gender', $customer -> name) == 'male')>
                                                                Male
                                                            </option>
                                                            <option value="female" @selected(old ('gender', $customer -> gender) == 'female')>
                                                                Female
                                                            </option>
                                                        </select>
                                                    </div>
                                                    
                                                    <div class="col-md-12 mb-1">
                                                        <label class="col-form-label font-small-4">Address</label>
                                                        <textarea class="form-control" name="address"
                                                                  rows="5">{{ old ('address', $customer -> address) }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-3 mb-1">
                                                <div class="align-items-center border d-flex flex-column justify-content-center pt-50 rounded-2">
                                                    <div class="custom-avatar d-flex justify-content-center align-items-center flex-column">
                                                        <img
                                                                src="{{ $customer -> picture() }}"
                                                                id="account-upload-img"
                                                                class="uploadedAvatar rounded w-75"
                                                                alt="profile image"
                                                        />
                                                        <div class="mt-1">
                                                            <label for="account-upload"
                                                                   class="btn btn-sm btn-primary mb-75 me-25">Upload</label>
                                                            <input type="file" id="account-upload" hidden="hidden"
                                                                   name="image"
                                                                   accept="image/*" />
                                                            <button type="button" id="account-reset"
                                                                    class="btn btn-sm btn-outline-secondary mb-75">Reset
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-4 mb-1">
                                                <label class="col-form-label font-small-4 pt-0">Add Products By
                                                                                                Attribute</label>
                                                <div class="card">
                                                    <div class="card-body p-0 border p-1 rounded-2"
                                                         style="height: 270px">
                                                        
                                                        <div class="mb-1 customer-update">
                                                            <select class="form-control select2"
                                                                    id="customer-attributes"
                                                                    data-placeholder="Select Attribute">
                                                                <option></option>
                                                                @if(count ($attributes) > 0)
                                                                    @foreach($attributes as $attribute)
                                                                        <option value="{{ $attribute -> id }}"
                                                                                class="li-{{ $attribute -> id }}">
                                                                            {{ $attribute -> title }}
                                                                        </option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                        
                                                        <select class="form-control"
                                                                id="customer-products-price"
                                                                data-placeholder="Select Product(s)">
                                                            <option></option>
                                                        </select>
                                                    
                                                    </div>
                                                </div>
                                                
                                                <label class="col-form-label font-small-4 pt-0">Add Simple
                                                                                                Products</label>
                                                <div class="card">
                                                    <div class="card-body p-0 border p-1 rounded-2"
                                                         style="height: 270px">
                                                        
                                                        <select class="form-control select2"
                                                                id="customer-simple-products-price"
                                                                data-placeholder="Select Product(s)">
                                                            <option></option>
                                                            @if(count ($simple_products) > 0)
                                                                @foreach($simple_products as $simple_product)
                                                                    <option value="{{ $simple_product -> id }}">
                                                                        {{ $simple_product -> productTitle() }}
                                                                    </option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-8 mb-1">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-hover customer-product-prices d-none">
                                                        <thead>
                                                        <tr>
                                                            <th width="5%"></th>
                                                            <th width="55%">Product</th>
                                                            <th width="15%">Sale/Unit</th>
                                                            <th width="25%">Customer Price</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody id="customer-product-prices">
                                                        <tr>
                                                            <td colspan="2"></td>
                                                            <td colspan="2">
                                                                <input type="number"
                                                                       id="update-new-added-products-price"
                                                                       class="form-control" step="0.01"
                                                                       placeholder="Update added products prices...">
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                    
                                                    @if(count ($prices) > 0 || count ($simple_products_prices) > 0)
                                                        <table class="table table-bordered table-hover">
                                                            <thead>
                                                            <tr>
                                                                <th width="5%"></th>
                                                                <th width="55%">Product</th>
                                                                <th width="15%">Sale/Unit</th>
                                                                <th width="25%">Customer Price</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody id="@if(count ($prices) < 1 || count ($simple_products_prices) < 1) customer-product-prices @endif">
                                                            
                                                            @if(count ($prices) > 0)
                                                                @foreach($prices as $price)
                                                                    @php
                                                                        $products = explode (',', $price -> products);
                                                                        $prices = explode (',', $price -> prices);
                                                                    @endphp
                                                                    <tr>
                                                                        <td>
                                                                            <a href="javascript:void(0)"
                                                                               onclick="toggle_attribute_products({{ $price -> attribute_id }})"
                                                                               class="text-danger icon-{{ $price -> attribute_id }}">
                                                                                <i data-feather="chevron-down"
                                                                                   style="width: 25px; height: 25px;"></i>
                                                                            </a>
                                                                        </td>
                                                                        <td align="left"
                                                                            class="text-danger font-medium-5">
                                                                            <strong>{{ $price -> title }}</strong>
                                                                        </td>
                                                                        <td colspan="2">
                                                                            <input type="text"
                                                                                   onchange="update_product_prices_by_attribute(this.value, {{ $price -> attribute_id }})"
                                                                                   class="form-control" min="0"
                                                                                   placeholder="Update {{ $price -> title }} prices">
                                                                        </td>
                                                                    </tr>
                                                                    @if(count ($products) > 0)
                                                                        @foreach($products as $key => $product_id)
                                                                            @php $product = \App\Models\Product::find($product_id) @endphp
                                                                            <tr class="sale-product-{{ $product -> id }} attribute-products-{{ $price -> attribute_id }} d-none">
                                                                                <input type="hidden" name="products[]"
                                                                                       value="{{ $product -> id }}">
                                                                                <td class="d-flex flex-column justify-content-center align-content-center text-center">
                                                                                    <span>{{ $loop -> iteration }}</span>
                                                                                    <a href="javascript:void(0)"
                                                                                       data-product-id="{{ $product -> id }}"
                                                                                       class="remove-sale-product">
                                                                                        <i data-feather="trash-2"></i>
                                                                                    </a>
                                                                                </td>
                                                                                
                                                                                <td>
                                                                                    {{ $product -> productTitle() }}
                                                                                </td>
                                                                                
                                                                                <td>{{ number_format ($product -> sale_unit, 2) }}</td>
                                                                                
                                                                                <td>
                                                                                    <input class="form-control attribute-id-{{ $price -> attribute_id }}"
                                                                                           type="text"
                                                                                           step="0.01" name="price[]"
                                                                                           required="required"
                                                                                           value="{{ $prices[$key] }}">
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                            
                                                            @if(count ($simple_products_prices) > 0)
                                                                <tr>
                                                                    <td></td>
                                                                    <td align="left" colspan="3"
                                                                        class="text-danger font-medium-5">
                                                                        <strong>Simple Products</strong>
                                                                    </td>
                                                                </tr>
                                                                @foreach($simple_products_prices as $simple_products_price)
                                                                    <tr class="sale-product-{{ $simple_products_price -> product_id }}">
                                                                        <input type="hidden" name="products[]"
                                                                               value="{{ $simple_products_price -> product_id }}">
                                                                        <td class="d-flex flex-column justify-content-center align-content-center text-center">
                                                                            <span>{{ $loop -> iteration }}</span>
                                                                            <a href="javascript:void(0)"
                                                                               data-product-id="{{ $simple_products_price -> product_id }}"
                                                                               class="remove-sale-product">
                                                                                <i data-feather="trash-2"></i>
                                                                            </a>
                                                                        </td>
                                                                        
                                                                        <td>
                                                                            {{ $simple_products_price -> product -> productTitle() }}
                                                                        </td>
                                                                        
                                                                        <td>{{ number_format ($simple_products_price -> product -> sale_unit, 2) }}</td>
                                                                        
                                                                        <td>
                                                                            <input class="form-control attribute-id-{{ $simple_products_price -> product_id }}"
                                                                                   type="text"
                                                                                   step="0.01" name="price[]"
                                                                                   required="required"
                                                                                   value="{{ $simple_products_price -> price }}">
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            @endif
                                                            </tbody>
                                                        </table>
                                                    @endif
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
</x-dashboard>
