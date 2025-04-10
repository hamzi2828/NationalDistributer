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
                                    <form method="get" action="{{ route ('attribute-wise-quantity-report') }}">
                                        <div class="row">

                                            <div class="form-group  col-md-4 mb-1">
                                                <label class="mb-25">Attribute</label>
                                                <select name="attribute-id" class="form-control select2"
                                                        data-placeholder="Select">
                                                    <option></option>
                                                    <option value="0" @selected(request('attribute-id') == '0')>Select
                                                        All
                                                    </option>
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

                                            <div class="form-group col-md-4 mb-1">
                                                <label class="mb-50">Branch</label>
                                                <select name="branch-id" class="form-control select2"
                                                        data-placeholder="Select">
                                                    <option></option>
                                                    @if(count ($branches) > 0)
                                                        @foreach($branches as $branch)
                                                            <option value="{{ $branch -> id }}" @selected($branch -> id == request ('branch-id'))>
                                                                {{ $branch -> name }}
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

                                @if(count ($attributes) > 0)
                                    <div class="row">
                                        <div class="col-md-12 d-flex justify-content-end">
                                            <a href="{{ route ('attribute-wise-quantity-invoice', ['attribute-id' => request ('attribute-id')]) }}"
                                               target="_blank"
                                               class="btn btn-dark me-2 mb-1 btn-sm">
                                                <i data-feather="printer"></i> Print
                                            </a>
                                        </div>
                                    </div>
                                @endif

                                <div class="table-responsive">
                                    <table class="table w-100 table-hover table-responsive table-striped">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Attribute</th>
                                            <th>Term</th>
                                            <th>Barcode</th>
                                            <th>Available Quantity</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php $quantity = 0 @endphp
                                        @if(count ($products) > 0)
                                            @foreach($products as $product)
                                                @php $attrWiseQty = 0 @endphp
                                                <tr>
                                                    <td></td>
                                                    <td colspan="6"
                                                        class="font-medium-5 fw-bolder text-danger">{{ $product -> title }}</td>
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
                                                                            @php
                                                                                $quantity += $product -> product -> available_quantity();
                                                                                $attrWiseQty += $product -> product -> available_quantity();
                                                                            @endphp
                                                                            {{ $product -> product -> available_quantity() }}
                                                                        @endif
                                                                    @endforeach
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                @endif
                                                {{-- <tr>
                                                    <td colspan="4"></td>
                                                    <td>
                                                        <strong>{{ number_format ($attrWiseQty) }}</strong>
                                                    </td>
                                                </tr> --}}
                                            @endforeach
                                        @endif
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td colspan="4" class="text-end">
                                                Total Available Quantity:
                                            </td>
                                            <td>
                                                <strong>{{ number_format ($quantity) }}</strong>
                                            </td>
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
</x-dashboard>
