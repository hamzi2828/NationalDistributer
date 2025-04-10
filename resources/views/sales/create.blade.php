<x-dashboard :title="$title">
    @push('styles')
        <link rel="stylesheet" href="{{ asset ('/assets/chosen_v1.8.7/chosen.min.css') }}"></script>
        <style>
            tbody, td, tfoot, th, thead, tr {
                padding : 10px !important;
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
                                <form class="form" method="post"
                                      action="{{ route ('sales.store') }}">
                                    @csrf
                                    <input type="hidden" id="shipping-charges"
                                           value="{{ optional ($settings -> settings) -> shipping_charges }}">
                                    <div class="card-body pt-0">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="card">
                                                            <div class="card-header d-block p-0">
                                                                <select name="customer_id" class="form-control select2"
                                                                        required="required" id="sale-customer"
                                                                        data-placeholder="Select Customer">
                                                                    <option></option>
                                                                    @if(count ($customers) > 0)
                                                                        @foreach($customers as $customer)
                                                                            <option
                                                                                    value="{{ $customer -> id }}" @selected(old('customer-id') == $customer -> id)>
                                                                                {{ $customer -> customerDetails() }}
                                                                            </option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>

                                                            </div>
                                                            <div class="card-body p-0 mt-1 border p-1 rounded-2"
                                                                 style="height: 270px">

                                                                <ul class="p-0 d-flex gap-3 list-unstyled">
                                                                    <li>
                                                                        <input type="radio" name="customer-type"
                                                                               id="credit-customer" checked="checked"
                                                                               value="credit" @checked(old ('customer-type') == 'credit')>
                                                                        <label for="credit-customer">Credit
                                                                                                     Customer</label>
                                                                    </li>
                                                                    <li>
                                                                        <input type="radio" name="customer-type"
                                                                               id="cash-customer"
                                                                               value="cash" @checked(old ('customer-type') == 'cash')>
                                                                        <label for="cash-customer">Cash Customer</label>
                                                                    </li>
                                                                </ul>

                                                                <select class="form-control"
                                                                        id="sale-products"
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

                                                            <textarea name="remarks" class="form-control mt-2"
                                                                      maxlength="100" placeholder="Remarks"
                                                                      rows="2">{{ old ('remarks') }}</textarea>

                                                            <input type="number" name="boxes" class="form-control mt-2"
                                                                   placeholder="No. of Boxes" value="1" min="1"
                                                                   required="required">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-8 mb-1">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-hover" id="salesTable">
                                                        <thead>
                                                        <tr>
                                                            <th width="2%"></th>
                                                            <th width="30%">Product</th>
                                                            <th width="8%">Available Qty.</th>
                                                            <th width="10%">Sale Qty.</th>
                                                            <th width="20%">Price</th>
                                                            <th width="10%">Discount</th>
                                                            <th width="20%">Net Price</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody id="sold-products"></tbody>
                                                        <tfoot id="sale-footer" class="d-none">
                                                        <tr>
                                                            <td colspan="6" align="right">
                                                                <strong>Total</strong>
                                                            </td>
                                                            <td>
                                                                <input type="number" step="0.01" readonly="readonly"
                                                                       class="form-control" id="sale-total">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="6" align="right">
                                                                <strong>Discount (Flat)</strong>
                                                            </td>
                                                            <td>
                                                                <input type="number" step="0.01" value="0"
                                                                       name="flat-discount" required="required"
                                                                       class="form-control" id="flat-discount">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="6" align="right">
                                                                <strong>Discount (%)</strong>
                                                            </td>
                                                            <td>
                                                                <input type="number" step="0.01" max="100" value="0"
                                                                       name="percentage-discount" required="required"
                                                                       class="form-control" id="sale-discount">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="6" align="right">
                                                                <strong>Shipping</strong>
                                                            </td>
                                                            <td>
                                                                <select name="shipping" data-placeholder="Select"
                                                                        class="form-control select2" id="shipping"
                                                                        required="required">
                                                                    <option></option>
                                                                    <option value="0">Free</option>
                                                                    <option value="1">Paid</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="6" align="right">
                                                                <strong>Net Price</strong>
                                                            </td>
                                                            <td>
                                                                <input type="number" step="0.01" readonly="readonly"
                                                                       class="form-control" id="net-price">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="6" align="right">
                                                                <strong>Paid Amount</strong>
                                                            </td>
                                                            <td>
                                                                <input type="number" step="0.01" name="paid-amount"
                                                                       value="0" readonly="readonly"
                                                                       class="form-control" id="paid-amount">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="6" align="right">
                                                                <strong>Balance</strong>
                                                            </td>
                                                            <td>
                                                                <input type="number" step="0.01" readonly="readonly"
                                                                       class="form-control" id="balance">
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
    @push('scripts')
        <script type="text/javascript" src="{{ asset ('/assets/chosen_v1.8.7/chosen.jquery.min.js') }}"></script>
        <script type="text/javascript">
            $ ( ".chosen-select" ).chosen ();
        </script>
    @endpush
</x-dashboard>
