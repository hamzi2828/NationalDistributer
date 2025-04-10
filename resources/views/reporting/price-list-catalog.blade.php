<x-dashboard :title="$title">
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper p-0">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- Basic table -->
                <section>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{ $title }}</h4>
                                </div>
                                <div class="card-body">
                                    <form method="get" action="{{ route ('price-list-catalog') }}">
                                        <label for="selected-products">
                                            <input type="hidden" name="selected-products" id="selected-products">
                                        </label>
                                        <div class="row">
                                            <div class="form-group col-md-3 mb-1">
                                                <label class="mb-25" for="category">Category</label>
                                                <select name="category-id" class="form-control select2"
                                                        data-placeholder="Select" id="category">
                                                    <option></option>
                                                    @if(count ($categories) > 0)
                                                        @foreach($categories as $category)
                                                            <option value="{{ $category -> id }}" @selected(request ('category-id') == $category -> id)>
                                                                {{ $category -> title }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            
                                            <div class="form-group col-md-3 mb-1">
                                                <label class="mb-25" for="product-availability">Product
                                                                                                Availability</label>
                                                <select name="product-availability" class="form-control select2"
                                                        data-placeholder="Select" id="product-availability">
                                                    <option value="all" @selected(request ('product-availability') == 'all')>
                                                        All Products
                                                    </option>
                                                    <option value="available" @selected(request ('product-availability') == 'available')>
                                                        Available Products
                                                    </option>
                                                </select>
                                            </div>
                                            
                                            <div class="form-group col-md-2 mb-1">
                                                <label class="mb-25" for="price-appreciation">
                                                    Price Appreciation (%)
                                                </label>
                                                <input type="number" name="price-appreciation" class="form-control"
                                                       value="{{ request ('price-appreciation') }}"
                                                       onchange="togglePriceFilter()"
                                                       @if(request ('price-depreciation') > 0) readonly="readonly"
                                                       @endif
                                                       id="price-appreciation">
                                            </div>
                                            
                                            <div class="form-group col-md-2 mb-1">
                                                <label class="mb-25" for="price-depreciation">
                                                    Price Depreciation (%)
                                                </label>
                                                <input type="number" name="price-depreciation" class="form-control"
                                                       value="{{ request ('price-depreciation') }}"
                                                       onchange="togglePriceFilter()"
                                                       @if(request ('price-appreciation') > 0) readonly="readonly"
                                                       @endif
                                                       id="price-depreciation">
                                            </div>
                                            
                                            <div class="form-group col-md-2 mb-1">
                                                <button type="submit"
                                                        class="btn w-100 mt-2 btn-primary d-block ps-0 pe-0">Search
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                
                                @if(count ($products) > 0)
                                    <div class="row">
                                        <div class="col-md-12 d-flex justify-content-end">
                                            <a href="{{ route ('price-list-catalog-report', request () -> all ()) }}"
                                               target="_blank" id="printLink"
                                               class="btn btn-dark me-2 mb-1 btn-sm">
                                                <i data-feather="printer"></i> Print
                                            </a>
                                        </div>
                                    </div>
                                @endif
                                
                                <div class="table-responsive">
                                    <table class="table w-100 table-hover table-responsive table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th>#</th>
                                            <th></th>
                                            <th>Product</th>
                                            <th>Pack Size</th>
                                            <th>Price/Box</th>
                                        </tr>
                                        </thead>
                                        <tbody style="vertical-align: baseline;">
                                        @if(count ($products) > 0)
                                            @foreach($products as $product)
                                                <tr>
                                                    <td width="5%">
                                                        <div class="d-flex flex-row justify-content-center align-items-center gap-25">
                                                            <label class="d-flex justify-content-center align-items-center">
                                                                <input type="checkbox" name="products[]"
                                                                       style="width: 15px; height: 15px;"
                                                                       class="products" onclick="mark_selected()"
                                                                       value="{{ $product -> id }}">
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td width="5%">{{ $loop -> iteration }}</td>
                                                    <td width="15%">
                                                        @if(!empty(trim ($product -> avatar())))
                                                            <img src="{{ asset ($product -> avatar()) }}"
                                                                 alt="{{ $product -> productTitle() }}"
                                                                 style="width: 80px;">
                                                        @endif
                                                    </td>
                                                    <td width="60%">{{ $product -> productTitle() }}</td>
                                                    <td align="center">{{ $product -> pack_size }}</td>
                                                    <td width="20%">
                                                        @if(request ('price-appreciation') > 0)
                                                            <span style="text-decoration: line-through;">
                                                                {{ number_format ($product -> sale_box, 2) }}
                                                            </span> <br />
                                                            @php
                                                                $appreciation = ($product -> sale_box * request ('price-appreciation')) / 100;
                                                            @endphp
                                                            {{ number_format (($product -> sale_box + $appreciation), 2) }}
                                                        @elseif(request ('price-depreciation') > 0)
                                                            <span style="text-decoration: line-through;">
                                                                {{ number_format ($product -> sale_box, 2) }}
                                                            </span> <br />
                                                            @php
                                                                $appreciation = ($product -> sale_box * request ('price-depreciation')) / 100;
                                                            @endphp
                                                            {{ number_format (($product -> sale_box - $appreciation), 2) }}
                                                        @else
                                                            {{ number_format ($product -> sale_box, 2) }}
                                                        @endif
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
                </section>
                <!--/ Basic table -->
            </div>
        </div>
    </div>
</x-dashboard>
