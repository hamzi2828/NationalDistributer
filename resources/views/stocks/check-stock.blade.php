<x-dashboard :title="$title">
    @push('styles')
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
                                <div class="card-body pt-0">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card">
                                                        <div class="card-body p-0 mt-1 border p-1 rounded-2"
                                                             style="height: 270px">
                                                            
                                                            <select class="form-control"
                                                                    id="check-stock"
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
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-8 mb-1">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover" id="salesTable">
                                                    <thead>
                                                    <tr>
                                                        <th width="75%">Product</th>
                                                        <th width="25%">Available Qty.</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="sold-products"></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</x-dashboard>
