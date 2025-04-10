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
                                    <form action="{{ route('stock-out-summary-report') }}" method="GET" class="form-inline row">
                                        <div class="form-group col-md-3 mb-1">
                                            <label for="filter_date" class="mb-25">Filter Date</label>
                                            <input type="text" id="filter_date" class="form-control flatpickr-basic @error('filter_date') is-invalid @enderror"
                                                   name="filter_date" value="{{ old('filter_date', request('filter_date')) }}">
                                            @error('filter_date')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                


                                        <div class="form-group col-md-4 mb-1">
                                            <label class="mb-50">User</label>
                                            <select name="user-id" class="form-control select2"
                                                    data-placeholder="Select">
                                                <option></option>
                                                @if(count ($users) > 0)
                                                    @foreach($users as $user)
                                                        <option value="{{ $user -> id }}" @selected($user -> id == request ('user-id'))>
                                                            {{ $user -> name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>




                                        <div class="form-group col-md-2 mb-1 d-flex align-items-end">
                                            <button type="submit"
                                                    class="btn w-100 btn-primary">Search
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                
                                <div class="table-responsive">
                                    <table id="excel-table" class="table w-100 table-hover table-responsive table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Products</th>
                                                <th>Quantity</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($products as $index => $product)
                                                @php
                                                    $startDate = request('filter_date');
                                                    $userId = request('user-id');
                                                    $productsold = $product->sold_quantity_on_date_by_user($startDate, $userId);
                                                @endphp
                                                @if($productsold > 0) <!-- Only show the product if productsold is greater than 0 -->
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td><strong>{{ $product->title }}</strong></td>
                                                        <td>{{ $productsold }}</td>
                                                    </tr>
                                                @endif
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
</x-dashboard>
