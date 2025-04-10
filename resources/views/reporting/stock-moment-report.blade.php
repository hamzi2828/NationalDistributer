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




                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4 class="card-title">{{ $title }}</h4>
                                </div>
                                
                                <div class="card-body">
                                    <form action="{{ route('stock-moment-report') }}" method="GET" class="form-inline row">
                                        <div class="form-group col-md-3 mb-1">
                                            <label for="start_date" class="mb-25">Start Date</label>
                                            <input type="text" id="start_date" class="form-control flatpickr-basic"
                                                   name="start_date" value="{{ request('start_date') }}">
                                        </div>
                                
                                        <div class="form-group col-md-3 mb-1">
                                            <label for="end_date" class="mb-25">End Date</label>
                                            <input type="text" id="end_date" class="form-control flatpickr-basic"
                                                   name="end_date" value="{{ request('end_date') }}">
                                        </div>
                                
                                        <div class="form-group col-md-2 mb-1 d-flex align-items-end">
                                            <button type="submit"
                                                    class="btn w-100 btn-primary">Search
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                
                            
                              
                                <div class="row">
                                    <div class="col-md-12">
                                       
                                        
                                        <div class="d-flex gap-1 justify-content-end  pb-1">
                                            
                                            <a href="javascript:void(0)" class="btn btn-primary rounded btn-sm" onclick="downloadExcel('Stock Moment Report')">
                                                <i data-feather='download-cloud'></i>
                                                Download Excel
                                            </a>
                                        </div>
                                    </div>
                                </div>
                        

                               <div class="table-responsive">
                                    <style>
                                        .table {
                                            width: 100%;
                                            border-collapse: collapse;
                                        }
                                    
                                        .table th, .table td {
                                            border: 1px solid #dee2e6; /* Light grey border for table cells */
                                            padding: 8px;
                                            text-align: center;
                                        }
                                    
                                        .table th.section-divider, .table td.section-divider {
                                            border-right: 2px solid #343a40; /* Darker, thicker border for section dividers */
                                        }
                                    
                                        .table th.main-section {
                                            background-color: #f8f9fa; /* Light background for main section headers */
                                            font-weight: bold;
                                            text-transform: uppercase;
                                        }
                                    
                                        .top-border, .table td.top-border {
                                            border-top: 2px solid #343a40 !important; /* Thicker, darker top border */
                                        }
                                    
                                        .bottom-border, .table td.bottom-border {
                                            border-bottom: 2px solid #343a40 !important; /* Thicker, darker bottom border */
                                        }
                                    </style>

                                    <table id="excel-table" class="table w-100 table-hover table-responsive table-striped">
                                    
                                        <thead>
                                            <tr>
                                                <th class="section-divider top-border" style="border-left: 2px solid #343a40; border-right: 2px solid #343a40;">#</th>
                                                <th class="section-divider top-border">Products</th>
                                                <th colspan="4"class="section-divider top-border">Opening Qty</th>
                                                <th colspan="3" class="section-divider top-border">Purchase</th>
                                                <th colspan="4" class="section-divider top-border">Sale</th>
                                                <th colspan="2" class="section-divider top-border">Closing</th>
                                            </tr>
                                            <tr>
                                                <th class="section-divider bottom-border" style="border-left: 2px solid #343a40; border-right: 2px solid #343a40;"></th>
                                                <th class="bottom-border section-divider"></th>
                                                <th class="bottom-border ">Stock  </th>
                                                <th class="bottom-border ">Sales</th>
                                                <th class="bottom-border ">Return <br>Vendor</th>
                                                <th class="bottom-border section-divider">Total (OQ)</th>
                                                <th class="bottom-border">Qty</th>
                                                <th class="bottom-border">Return</th>
                                                <th class="bottom-border section-divider">Net</th>
                                                <th class="bottom-border">Qty</th>
                                                <th class="bottom-border">Return </th>
                                                <th class="bottom-border">Refund </th>
                                                <th class="bottom-border section-divider">Net</th>                                            
                                                <th class="bottom-border section-divider">Qty</th>
                                            </tr>
                                        </thead>
                                        
                                        
                                            <tbody>
                                                @foreach($products as $index => $product)
                                                    @php
                                                        // Find the corresponding previous_product for this product
                                                        $previousProduct = $previos_products->firstWhere('id', $product->id);
                                                        if ($previousProduct) {
                                                            $previousTotalStock = $previousProduct->stocks->sum('quantity'); 
                                                        }
                                             @endphp

                                                    
                                                <tr>
                                                    <td class="section-divider" style="border-left: 2px solid #343a40;">
                                                        {{ $index + 1 }}</td>
            
                                                    <td class="section-divider">
                                                        <strong>{{ $product->title }}</strong>
                                                    </td>
                                                    {{-- Opening Stock --}}
                                                    <td > {{ $previousTotalStock }} </td>
                                                    {{-- Opening Sales --}}
                                                    <td> 
                                                        @php
                                                            $initialDate = '2014-07-30';
                                                            $startDate = request('start_date');
                                                            $previousTotalSales = $product->sold_quantity_between_dates($initialDate,$startDate);
                                                        @endphp
                                                         {{ $previousTotalSales }}
                                                    </td>
                                                    {{-- Opening Return Vendor --}}
                                                    <td>
                                                        @php
                                                         $initialDate = '2014-07-30';
                                                         $startDate = request('start_date');
                                                        $previousTotalVendorReturn = $product->returned_quantity_between_dates($initialDate,$startDate); 
                                                        @endphp
                                                        
                                                        {{ $previousTotalVendorReturn }} 
                                                     </td>
                                                        {{-- Opening OQ --}}
                                                    <td class="section-divider"> 
                                                        @php
                                                        // Apply the formula for previous products
                                                        $previousOQ = $previousTotalStock - ($previousTotalSales + $previousTotalVendorReturn);
                                                        @endphp
                                                        {{ $previousOQ }} 
                                                    </td>   
                                                    {{-- Purchase - Total --}}
                                                    <td class="">
                                                        @php
                                                            $purchaseStock = $product->stocks->sum('quantity');
                                                        @endphp
                                                        {{ $purchaseStock }}
                                                    </td>
                                                    {{-- Purchase - Return --}}
                                                    <td class="">
                                                        @php
                                                            $startDate = request('start_date');
                                                            $endDate = request('end_date');
                                                            $totalVendorReturn = $product->returned_quantity_between_dates( $startDate, $endDate);
                                                        @endphp
                                                        
                                                        {{ $totalVendorReturn }}
                                                    </td>
                                                        {{-- Purchase net --}}
                                                    <td class="section-divider">
                                                        {{ $PurchaseNet = $purchaseStock - $totalVendorReturn }}
                                                    </td>
                                                    {{-- Sale - Total Sales --}}
                                                    <td class="">
                                                        @php
                                                            $startDate = request('start_date');
                                                            $endDate = request('end_date');
                                                            $totalSales = $product->sold_quantity_between_dates($startDate, $endDate);
                                                        @endphp
                                                     {{ $totalSales }}
                                                    </td>
                                                    {{-- Sale - Customer Return --}}
                                                    <td class="">
                                                        @php
                                                          $startDate = request('start_date');
                                                          $endDate = request('end_date');
                                                          $totalCustomerReturn = $product->return_customer_between_dates( $startDate, $endDate);
                                                        @endphp
                                                        
                                                        {{ $totalCustomerReturn }}</td>
                                                    {{-- Sale - Customer Refund --}}
                                                    <td class="">
                                                        @php
                                                          $startDate = request('start_date');
                                                          $endDate = request('end_date');
                                                          $totalCustomerRefund = $product->refund_quantity_between_dates( $startDate, $endDate); 
                                                        @endphp
                                                        
                                                        {{ $totalCustomerRefund }}
                                                    </td>
                                                    {{-- Sale Net --}}
                                                    <td class="section-divider">{{ $netSale =  $totalSales - ($totalCustomerReturn + $totalCustomerRefund) }}</td>
                                                    {{-- Closing Quantity --}}
                                                    <td class="section-divider">{{ ($previousOQ + $PurchaseNet) - $netSale }}</td>
                                                </tr>
                                                @endforeach
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

    </script>
</x-dashboard>