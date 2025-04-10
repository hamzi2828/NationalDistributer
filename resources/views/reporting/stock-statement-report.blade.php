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
                                {{-- <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4 class="card-title">{{ $title }}</h4>
                                    <div class="input-group w-25">
                                        <input type="text" id="search-input" class="form-control" placeholder="Search...">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-primary" type="button" onclick="searchTable()">
                                                <i data-feather="search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4 class="card-title">{{ $title }}</h4>
                                  
                                </div>
                     
                            
                                @if(count($products) > 0)
                                <div class="row">
                                    <div class="col-md-12">
                                       
                                        
                                        <div class="d-flex gap-1 justify-content-end pt-1 pb-1">
                                            <div class="input-group w-25" style="width: 15% !important;">
                                                <input type="text" id="search-input" class="form-control" placeholder="Search..." onkeyup="searchTable()">
                                            </div>
                                            <a href="javascript:void(0)" class="btn btn-primary rounded btn-sm" onclick="downloadExcel('Stock Statement')">
                                                <i data-feather='download-cloud'></i>
                                                Download Excel
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif 

                            <div class="table-responsive">
                                <table id="excel-table" class="table w-100 table-hover table-responsive table-striped">
                                    <thead>
                                        <tr>
                                            <th>Sr. No.</th>
                                            <th>Picture</th>
                                            <th>SKU</th>
                                            <th>Product Name</th>
                                            <th>Category</th> 
                                            @php
                                                // Get unique branch names
                                                $branches = $products->flatMap(function($product) {
                                                    return $product->all_stocks->pluck('branch.name');
                                                })->unique();
                                                
                                                // Initialize array to hold total quantities for each branch
                                                $branchTotals = [];
                                            @endphp
                                            @foreach($branches as $branch)
                                                <th>{{ $branch }}</th>
                                                @php
                                                    $branchTotals[$branch] = 0; // Initialize branch totals
                                                @endphp
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $net = 0; @endphp
                                        @if(count($products) > 0)
                                            @foreach($products as $product)
                                                @php
                                                    $value = ($product->stock_value_sale_wise() * $product->available_quantity());
                                                    $net += $value;
                                                @endphp
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>
                                                        <img src="{{ asset($product->image) }}" alt="{{ $product->productTitle() }}" width="50" height="50">
                                                    </td>
                                                    <td>{{ $product->sku }}</td>
                                                    <td>{{ $product->productTitle() }}</td>
                                                    <td>{{ $product->category->title }}</td>
                                                    @foreach($branches as $branch)
                                                    @php
                                                    // Filter the stocks for the current branch
                                                    $branchStocks = $product->all_stocks->filter(function($stock) use ($branch) {
                                                        return $stock->branch->name === $branch;
                                                    });

                                                    // Retrieve the branch ID from the first stock item (assuming there is at least one)
                                                    $branchId = $branchStocks->first()->branch_id ?? null;

                                                    // Merge the branch ID into the request
                                                    request()->merge(['branch-id' => $branchId]);

                                                    // Calculate the available quantity for the current branch using the branch-specific method
                                                    $branchQuantity = $branchId ? $product->available_quantity() : 0;

                                                    // Add to branch totals for both main and other branches
                                                    $branchTotals[$branch] = ($branchTotals[$branch] ?? 0) + $branchQuantity;
                                                @endphp
                                                    <td>{{ $branchQuantity }}</td>
                                                @endforeach
                                                
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="5" style="text-align: right;">Total Quantity</th>
                                            @foreach($branchTotals as $branchTotal)
                                                <th>{{ $branchTotal }}</th>
                                            @endforeach
                                        </tr>
                                    </tfoot>
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
    <script>
        function searchTable() {
            // Get input value and table rows
            let input = document.getElementById('search-input').value.toLowerCase();
            let rows = document.querySelectorAll('#excel-table tbody tr');
            
            rows.forEach(row => {
                let cells = row.querySelectorAll('td');
                let match = false;
                
                // Loop through cells in the row
                cells.forEach(cell => {
                    if (cell.innerText.toLowerCase().includes(input)) {
                        match = true;
                    }
                });
                
                // Show or hide row based on search match
                if (match) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    </script>
</x-dashboard>