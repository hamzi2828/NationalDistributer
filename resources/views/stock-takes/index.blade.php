<x-dashboard :title="$title">
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper p-0">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- Basic table -->
                <section id="basic-datatable">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="table-responsive">
                                    <table class="table table-bordered align-baseline table-sm">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Products</th>
                                            <th>Available Qty.</th>
                                            <th>Physical Qty.</th>
                                            <th>Difference</th>
                                            <th>Date Added</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count ($stock_takes) > 0)
                                            @foreach($stock_takes as $stock_take)
                                                @php
                                                    $products = explode (',', $stock_take -> products);
                                                    $available_quantities = explode (',', $stock_take -> available_quantities);
                                                    $live_quantities = explode (',', $stock_take -> live_quantities);
                                                @endphp
                                                <tr>
                                                    <td>{{ $loop -> iteration }}</td>
                                                    <td>
                                                        @if(count ($products) > 0)
                                                            @foreach($products as $product_id)
                                                                {{ \App\Models\Product::find($product_id) -> productTitle() }}
                                                                <br/>
                                                            @endforeach
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if(count ($available_quantities) > 0)
                                                            @foreach($available_quantities as $available_quantity)
                                                                {{ $available_quantity }}
                                                                <br/>
                                                            @endforeach
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if(count ($live_quantities) > 0)
                                                            @foreach($live_quantities as $live_quantity)
                                                                {{ $live_quantity }}
                                                                <br/>
                                                            @endforeach
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if(count ($live_quantities) > 0)
                                                            @foreach($live_quantities as $key => $live_quantity)
                                                                {{ ($live_quantity - $available_quantities[$key]) }}
                                                                <br/>
                                                            @endforeach
                                                        @endif
                                                    </td>
                                                    <td>{{ $stock_take -> created_at }}</td>
                                                    <td>
                                                        <div class="align-content-start d-flex justify-content-start">
                                                            <a class="btn btn-dark btn-sm d-block mb-25 me-25" target="_blank"
                                                               href="{{ route ('stock-take', ['stock_take' => $stock_take -> uuid]) }}">
                                                                Print
                                                            </a>

                                                            @can('edit', $stock_take)
                                                                <a class="btn btn-primary btn-sm d-block mb-25 me-25"
                                                                   href="{{ route ('stock-takes.edit', ['stock_take' => $stock_take -> uuid]) }}">
                                                                    Edit
                                                                </a>
                                                            @endcan

                                                            @can('delete', $stock_take)
                                                                <form method="post"
                                                                      id="delete-confirmation-dialog-{{ $stock_take -> uuid }}"
                                                                      action="{{ route ('stock-takes.destroy', ['stock_take' => $stock_take -> uuid]) }}">
                                                                    @method('DELETE')
                                                                    @csrf
                                                                    <button type="button"
                                                                            onclick="delete_dialog('{{ $stock_take -> uuid }}')"
                                                                            class="btn btn-danger btn-sm d-block w-100">
                                                                        Delete
                                                                    </button>
                                                                </form>
                                                            @endcan
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
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
    @push('custom-scripts')
        <script type="text/javascript">
            $ ( "div.head-label" ).html ( '<h4 class="fw-bolder mb-0">{{ $title }}</h6>' );
        </script>
    @endpush
</x-dashboard>
