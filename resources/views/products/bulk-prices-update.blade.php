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
                                    <form method="get" action="{{ route ('products.bulk-update-prices') }}">
                                        <div class="row">

                                            <div class="form-group offset-md-3 col-md-4 mb-1">
                                                <label class="mb-25">Attribute</label>
                                                <select name="attribute-id" class="form-control select2"
                                                        data-placeholder="Select">
                                                    <option></option>
                                                    @if(count ($attributes) > 0)
                                                        @foreach($attributes as $attribute)
                                                            <option
                                                                value="{{ $attribute -> id }}" @selected(request('attribute-id') == $attribute -> id)>
                                                                {{ $attribute -> title }}
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
                                                <th>Attribute</th>
                                                <th>Term</th>
                                                <th>Barcode</th>
                                                <th>TP/Box</th>
                                                <th>TP/Unit</th>
                                                <th>Sale/Box</th>
                                                <th>Sale/Unit</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if(count ($products) > 0)
                                                @foreach($products as $product)
                                                    <tr>
                                                        <td></td>
                                                        <td colspan="3"
                                                            class="font-medium-5 fw-bolder text-danger">{{ $product -> title }}</td>
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
                                                    @if(count ($product -> terms) > 0)
                                                        @foreach($product -> terms as $term)
                                                            @if(count ($term -> product_terms) > 0)
                                                                <tr>
                                                                    <td>{{ $loop -> iteration }}</td>
                                                                    <td></td>
                                                                    <td>{{ $term -> title }}</td>
                                                                    <td>
                                                                        @foreach($term -> product_terms as $product)
                                                                            @if(!empty($product -> product))
                                                                                {{ $product -> product -> productTitle() }}
                                                                            @endif
                                                                        @endforeach
                                                                    </td>
                                                                    <td>
                                                                        @foreach($term -> product_terms as $product)
                                                                            @if(!empty($product -> product))
                                                                                <input type="number" step="0.01"
                                                                                       name="tp-box[{{ $product -> product -> id }}]"
                                                                                       class="form-control tp-box"
                                                                                       required="required" min="0"
                                                                                       value="{{ $product -> product -> tp_box }}">
                                                                            @endif
                                                                        @endforeach
                                                                    </td>
                                                                    <td>
                                                                        @foreach($term -> product_terms as $product)
                                                                            @if(!empty($product -> product))
                                                                                <input type="number" step="0.01"
                                                                                       name="tp-unit[{{ $product -> product -> id }}]"
                                                                                       class="form-control tp-unit"
                                                                                       required="required" min="0"
                                                                                       value="{{ $product -> product -> tp_unit }}">
                                                                            @endif
                                                                        @endforeach
                                                                    </td>
                                                                    <td>
                                                                        @foreach($term -> product_terms as $product)
                                                                            @if(!empty($product -> product))
                                                                                <input type="number" step="0.01"
                                                                                       class="form-control sale-box"
                                                                                       name="sale-box[{{ $product -> product -> id }}]"
                                                                                       required="required" min="0"
                                                                                       value="{{ $product -> product -> sale_box }}">
                                                                            @endif
                                                                        @endforeach
                                                                    </td>
                                                                    <td>
                                                                        @foreach($term -> product_terms as $product)
                                                                            @if(!empty($product -> product))
                                                                                <input type="number" step="0.01"
                                                                                       class="form-control sale-unit"
                                                                                       name="sale-unit[{{ $product -> product -> id }}]"
                                                                                       required="required" min="0"
                                                                                       value="{{ $product -> product -> sale_unit }}">
                                                                            @endif
                                                                        @endforeach
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                            @endif
                                            </tbody>
                                            @if(count ($products) > 0)
                                                <tfoot>
                                                <tr>
                                                    <td colspan="7"></td>
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
