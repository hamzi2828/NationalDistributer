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
                                      action="{{ route ('stock-returns.store') }}">
                                    @csrf
                                    <div class="card-body pt-0">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="card">
                                                            <div class="card-header d-block p-0">
                                                                <input type="text" name="reference-no"
                                                                       class="form-control mb-1"
                                                                       placeholder="Reference No." required="required">
                                                                
                                                                <select name="vendor-id" class="form-control select2"
                                                                        required="required" id="return-vendor"
                                                                        data-placeholder="Select vendor">
                                                                    <option></option>
                                                                    @if(count ($vendors) > 0)
                                                                        @foreach($vendors as $vendor)
                                                                            <option value="{{ $vendor -> id }}" @selected(old('vendor-id') == $vendor -> id)>
                                                                                {{ $vendor -> name }}
                                                                            </option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                            <div class="card-body p-0 mt-1 border p-1 rounded-2"
                                                                 style="height: 270px">
                                                                <select class="form-control"
                                                                        id="return-products"
                                                                        data-placeholder="Select Product(s)">
                                                                    <option></option>
                                                                    @if(count ($products) > 0)
                                                                        @foreach($products as $product)
                                                                            @if($product -> available_quantity() > 0)
                                                                                <option value="{{ $product -> id }}">
                                                                                    {{ $product -> productTitle() }}
                                                                                </option>
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                            
                                                            <textarea name="description" class="form-control mt-2"
                                                                      maxlength="100" placeholder="Description"
                                                                      rows="2">{{ old ('description') }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-8 mb-1">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-hover">
                                                        <thead>
                                                        <tr>
                                                            <th width="2%"></th>
                                                            <th width="35%">Product</th>
                                                            <th width="8%">Available Qty.</th>
                                                            <th width="15%">Return Qty.</th>
                                                            <th width="20%">TP/Unit (Return)</th>
                                                            <th width="20%">Net Price</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody id="returned-products"></tbody>
                                                        <tfoot id="return-footer" class="d-none">
                                                        <tr>
                                                            <td colspan="5" align="right">
                                                                <strong>Total</strong>
                                                            </td>
                                                            <td>
                                                                <input type="number" step="0.01"
                                                                       readonly="readonly" name="total-vendor-return"
                                                                       class="form-control" id="return-total">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="5" align="right">
                                                                <strong>Discount (Flat)</strong> <br />
                                                                <strong class="text-danger">
                                                                    Entries are not being recorded in GL.
                                                                </strong>
                                                            </td>
                                                            <td>
                                                                <input type="number" step="any" name="discount"
                                                                       class="form-control" id="discount"
                                                                       onchange="calculate_vendor_stock_return_total(this.value)"
                                                                       value="0">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="5" align="right">
                                                                <strong>Net Amount</strong>
                                                            </td>
                                                            <td>
                                                                <input type="number" name="return-total" step="0.01"
                                                                       readonly="readonly"
                                                                       class="form-control" id="net-return-total">
                                                            </td>
                                                        </tr>
                                                        </tfoot>
                                                    </table>
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