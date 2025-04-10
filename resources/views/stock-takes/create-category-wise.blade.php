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
                                    <form method="get" action="{{ route ('stock-takes.create-category') }}">
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
                                    <form method="post" action="{{ route ('stock-takes.store') }}">
                                        @csrf
                                        <table class="table w-100 table-hover table-responsive table-striped">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Category</th>
                                                <th>Product</th>
                                                <th>Available Quantity</th>
                                                <th>Physical Quantity</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if(count ($categoryProducts) > 0)
                                                @foreach($categoryProducts as $categoryProduct)
                                                    <tr>
                                                        <td></td>
                                                        <td colspan="4"
                                                            class="font-medium-5 fw-bolder text-danger">{{ $categoryProduct -> title }}</td>
                                                    </tr>
                                                    @if(count ($categoryProduct -> products) > 0)
                                                        @foreach($categoryProduct -> products as $product)
                                                            <tr>
                                                                <td>{{ $loop -> iteration }}</td>
                                                                <td></td>
                                                                <td>{{ $product -> productTitle() }}</td>
                                                                <td>
                                                                    {{ $product -> available_quantity() }}
                                                                    <input type="hidden"
                                                                           class="form-control"
                                                                           value="{{ $product -> available_quantity() }}"
                                                                           name="available-quantity[]">
                                                                    <input type="hidden"
                                                                           class="form-control"
                                                                           value="{{ $product -> id }}"
                                                                           name="product-id[]">
                                                                </td>
                                                                <td>
                                                                    <input type="number" class="form-control"
                                                                           autofocus="autofocus"
                                                                           required="required"
                                                                           name="live-quantity[]">
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                            @endif
                                            </tbody>
                                            @if(count ($categoryProducts) > 0)
                                                <tfoot>
                                                <tr>
                                                    <td colspan="2"></td>
                                                    <td colspan="3">
                                                        <button type="submit" class="btn btn-primary">Submit</button>
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
