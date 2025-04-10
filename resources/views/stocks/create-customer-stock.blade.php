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
                                <form class="form" method="post"
                                      action="{{ route ('stocks.return-customer-stock') }}">
                                    @csrf
                                    <input type="hidden" id="counter" value="0">
                                    
                                    <div class="card-body pt-0">
                                        <div class="row">
                                            <div class="col-md-3 mb-1">
                                                <label class="col-form-label font-small-4"
                                                       for="stock-date">Stock Date</label>
                                                <input type="text"
                                                       class="form-control flatpickr-basic"
                                                       required="required" id="stock-date"
                                                       name="stock-date" placeholder="Stock Date"
                                                       value="{{ old ('stock-date') }}" />
                                            </div>
                                            
                                            <div class="col-md-3 mb-1">
                                                <label class="col-form-label font-small-4"
                                                       for="invoice-no">Reference No</label>
                                                <input type="text" class="form-control"
                                                       required="required" autofocus="autofocus"
                                                       name="invoice-no" id="invoice-no"
                                                       value="{{ old ('invoice-no') }}"
                                                       onchange="validateInvoiceNo()" />
                                            </div>
                                            
                                            <div class="col-md-3 mb-1">
                                                <label class="col-form-label font-small-4"
                                                       for="vendors">Customer</label>
                                                <select id="vendors" name="customer-id"
                                                        class="form-control select2"
                                                        required="required"
                                                        data-placeholder="Select"
                                                        onchange="validateInvoiceNo()">
                                                    <option></option>
                                                    @if(count ($customers))
                                                        @foreach($customers as $customer)
                                                            <option value="{{ $customer -> id }}" @selected(old ('customer-id') == $customer -> id)>
                                                                {{ $customer -> name }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            
                                            <div class="col-md-3 mb-1">
                                                <label class="col-form-label font-small-4"
                                                       for="branch-id">Warehouse/Branch</label>
                                                <select name="branch-id"
                                                        class="form-control select2" id="branch-id"
                                                        required="required"
                                                        data-placeholder="Select">
                                                    <option></option>
                                                    @if(count ($branches))
                                                        @foreach($branches as $key => $branch)
                                                            <option value="{{ $branch -> id }}"
                                                                    @selected(old ('branch-id') == $branch -> id)>
                                                                {{ $branch -> fullName() }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="card">
                                                            <div class="card-body p-0 border p-1 rounded-2"
                                                                 style="height: 270px">
                                                                <label for="stock-add-products"></label>
                                                                <select id="stock-add-products"
                                                                        onchange="addStockProduct('{{ route ('stocks.add-customer-return-stock-products') }}', this.value)" class="form-control select2"
                                                                        data-placeholder="Select">
                                                                    <option></option>
                                                                    @if(count ($products))
                                                                        @foreach($products as $key => $product)
                                                                            <option value="{{ $product -> id }}">
                                                                                {{ $product -> productTitle() }}
                                                                            </option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                             
                                                            <label for="description"></label>
                                                            <textarea name="description" class="form-control mt-2"
                                                                      id="description"
                                                                      maxlength="100" placeholder="Description"
                                                                      rows="2">{{ old ('description') }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-8 mb-1">
                                                <div id="addProducts"></div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="offset-md-9 col-md-3 pe-2 mb-2">
                                                <label class="mb-25" for="grand-total">Total Purchase Cost</label>
                                                <input type="number" readonly="readonly" step="0.01"
                                                       class="form-control grand-total" name="grand-total"
                                                       id="grand-total">
                                            </div>
                                            
                                            <div class="offset-md-9 col-md-3 mb-1 pe-2 pb-25">
                                                <label class="mb-25" for="return-discount">
                                                    Discount (%) - Return
                                                </label>
                                                <input type="number" step="0.01" name="net-discount"
                                                       class="form-control net-discount" id="return-discount"
                                                       onchange="calculate_customer_return_stock_discount(this.value, 'percentage')"
                                                       value="{{ old ('net-discount', 0) }}">
                                            </div>
                                            
                                            <div class="offset-md-9 col-md-3 mb-1 pe-2 pb-25">
                                                <label class="mb-25" for="flat-return-discount">
                                                    Discount (Flat) - Return
                                                </label>
                                                <input type="number" step="0.01" name="flat-return-discount"
                                                       class="form-control flat-return-discount"
                                                       id="flat-return-discount"
                                                       onchange="calculate_customer_return_stock_discount(this.value, 'flat')"
                                                       value="{{ old ('net-discount', 0) }}">
                                            </div>
                                            
                                            <div class="offset-md-9 col-md-3 pe-2 mb-2">
                                                <label class="mb-25" for="return-grand-total">Paid to Customer</label>
                                                <input type="number" readonly="readonly" step="0.01"
                                                       class="form-control return-grand-total" id="return-grand-total">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex justify-content-start align-content-start">
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
