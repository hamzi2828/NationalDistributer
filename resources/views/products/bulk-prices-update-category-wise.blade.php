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
                                    <form method="get" action="{{ route ('products.bulk-update-prices-category-wise') }}">
                                        <div class="row">
                                            
                                            <div class="form-group offset-md-3 col-md-4 mb-1">
                                                <label class="mb-25" for="category-id">Category</label>
                                                <select name="category-id" class="form-control select2"
                                                        data-placeholder="Select" id="category-id">
                                                    <option></option>
                                                    @if(count ($categories) > 0)
                                                        @foreach($categories as $category)
                                                            <option
                                                                    value="{{ $category -> id }}" @selected(request('category-id') == $category -> id)>
                                                                {{ $category -> title }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            
                                            <div class="form-group col-md-2 mb-1">
                                                <button type="submit"
                                                        class="btn w-100 mt-2 btn-primary d-block ps-0 pe-0">Search
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                
                                <div class="table-responsive">
                                    <form method="post" action="{{ route ('products.update-bulk-update-prices') }}">
                                        @csrf
                                        
                                        <table class="table w-100 table-hover table-responsive table-striped">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Product</th>
                                                <th>TP/Box</th>
                                                <th>TP/Unit</th>
                                                <th>Sale/Box</th>
                                                <th>Sale/Unit</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if(count ($products) > 0)
                                                <tr>
                                                    <td></td>
                                                    <td
                                                        class="font-medium-5 fw-bolder text-danger">{{ $searchedCategory ?-> title }}</td>
                                                    <td>
                                                        <input type="number" step="0.01" class="form-control"
                                                               onchange="updateBulkPrice(this.value, '.tp-box')">
                                                    </td>
                                                    <td>
                                                        <input type="number" step="0.01" class="form-control"
                                                               onchange="updateBulkPrice(this.value, '.tp-unit')">
                                                    </td>
                                                    <td>
                                                        <input type="number" step="0.01" class="form-control"
                                                               onchange="updateBulkPrice(this.value, '.sale-box')">
                                                    </td>
                                                    <td>
                                                        <input type="number" step="0.01" class="form-control"
                                                               onchange="updateBulkPrice(this.value, '.sale-unit')">
                                                    </td>
                                                </tr>
                                                @foreach($products as $product)
                                                    <tr>
                                                        <td>{{ $loop -> iteration }}</td>
                                                        <td>{{ $product -> productTitle() }}</td>
                                                        <td>
                                                            <input type="number" step="0.01"
                                                                   name="tp-box[{{ $product -> id }}]"
                                                                   class="form-control tp-box"
                                                                   required="required" min="0"
                                                                   value="{{ $product-> tp_box }}">
                                                        </td>
                                                        <td>
                                                            <input type="number" step="0.01"
                                                                   name="tp-unit[{{ $product -> id }}]"
                                                                   class="form-control tp-unit"
                                                                   required="required" min="0"
                                                                   value="{{ $product -> tp_unit }}">
                                                        </td>
                                                        <td>
                                                            <input type="number" step="0.01"
                                                                   class="form-control sale-box"
                                                                   name="sale-box[{{ $product -> id }}]"
                                                                   required="required" min="0"
                                                                   value="{{ $product -> sale_box }}">
                                                        </td>
                                                        <td>
                                                            <input type="number" step="0.01"
                                                                   class="form-control sale-unit"
                                                                   name="sale-unit[{{ $product -> id }}]"
                                                                   required="required" min="0"
                                                                   value="{{ $product -> sale_unit }}">
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            </tbody>
                                            @if(count ($products) > 0)
                                                <tfoot>
                                                <tr>
                                                    <td colspan="5"></td>
                                                    <td>
                                                        <button type="submit" class="btn btn-primary w-100">Submit
                                                        </button>
                                                    </td>
                                                </tr>
                                                </tfoot>
                                            @endif
                                        </table>
                                    
                                    </form>
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
