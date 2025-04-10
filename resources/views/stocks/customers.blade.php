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
                                    <table class="datatable table w-100 table-striped">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Reference No</th>
                                            <th>Customer</th>
                                            <th>Stock Date</th>
                                            <th>Return G.Total</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count ($stocks) > 0)
                                            @foreach($stocks as $stock)
                                                <tr>
                                                    <td>{{ $loop -> iteration }}</td>
                                                    <td>{{ $stock -> invoice_no }}</td>
                                                    <td>
                                                        @if($stock -> stock_type == 'vendor')
                                                            {{ $stock -> vendor -> name }}
                                                        @else
                                                            {{ $stock -> customer -> name }}
                                                        @endif
                                                    </td>
                                                    <td>{{ $stock -> stock_date }}</td>
                                                    <td>{{ number_format ($stock -> return_net, 2) }}</td>
                                                    <td>
                                                        <div>
                                                            @if($stock -> stock_type == 'vendor')
                                                                <a class="btn btn-dark btn-sm d-block mb-25 me-25"
                                                                   target="_blank"
                                                                   href="{{ route ('stock.invoice', ['stock' => $stock -> id]) }}">
                                                                    Print
                                                                </a>
                                                            @else
                                                                <a class="btn btn-dark btn-sm d-block mb-25 me-25"
                                                                   target="_blank"
                                                                   href="{{ route ('stock.return-customer-invoice', ['stock' => $stock -> id]) }}">
                                                                    Print
                                                                </a>
                                                            @endif
                                                            
                                                            @can('edit', $stock)
                                                                <a class="btn btn-primary btn-sm d-block mb-25 me-25"
                                                                   href="{{ route ('stocks.edit', ['stock' => $stock -> id]) }}">
                                                                    Edit
                                                                </a>
                                                            @endcan
                                                            
                                                            @can('delete', $stock)
                                                                <form method="post"
                                                                      id="delete-confirmation-dialog-{{ $stock -> id }}"
                                                                      action="{{ route ('stocks.destroy', ['stock' => $stock -> id]) }}">
                                                                    @method('DELETE')
                                                                    @csrf
                                                                    <button type="button"
                                                                            onclick="delete_dialog({{ $stock -> id }})"
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