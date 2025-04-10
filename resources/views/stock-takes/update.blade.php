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
                                    <div class="table-responsive">
                                        <form method="post"
                                              action="{{ route ('stock-takes.update', ['stock_take' => $stock_take -> uuid]) }}">
                                            @csrf
                                            @method('PUT')
                                            <table class="table w-100 table-hover table-responsive table-striped">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Attribute</th>
                                                    <th>Term</th>
                                                    <th>Barcode</th>
                                                    <th>Available Quantity</th>
                                                    <th>Physical Quantity</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @if(count ($products) > 0)
                                                    @foreach($products as $product)
                                                        <tr>
                                                            <td></td>
                                                            <td colspan="5"
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
                                                                            @foreach($term -> product_terms as $product_terms)
                                                                                @foreach($product_terms -> stock_takes as $stock_take)
                                                                                    @if(!empty($stock_take -> product))
                                                                                        {{ $stock_take -> product -> productTitle() }}
                                                                                    @endif
                                                                                @endforeach
                                                                            @endforeach
                                                                        </td>
                                                                        <td>
                                                                            @foreach($term -> product_terms as $product_terms)
                                                                                @foreach($product_terms -> stock_takes as $stock_take)
                                                                                    @if(!empty($stock_take -> product))
                                                                                        {{ $stock_take -> available_qty }}
                                                                                        <input type="hidden"
                                                                                               class="form-control"
                                                                                               value="{{ $stock_take -> id }}"
                                                                                               name="stock-take-id[]">
                                                                                    @endif
                                                                                @endforeach
                                                                            @endforeach
                                                                        </td>
                                                                        <td>
                                                                            @foreach($term -> product_terms as $product_terms)
                                                                                @foreach($product_terms -> stock_takes as $stock_take)
                                                                                    @if(!empty($stock_take -> product))
                                                                                        <input type="number"
                                                                                               class="form-control"
                                                                                               autofocus="autofocus"
                                                                                               required="required"
                                                                                               name="live-quantity[]"
                                                                                               value="{{ $stock_take -> live_qty }}">
                                                                                    @endif
                                                                                @endforeach
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
                                                        <td></td>
                                                        <td colspan="5">
                                                            <button type="submit" class="btn btn-primary">Update
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
                    </div>
                </section>
                <!--/ Basic table -->
            </div>
        </div>
    </div>
</x-dashboard>
