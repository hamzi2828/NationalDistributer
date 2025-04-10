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
                                            <th>Stock Date</th>
                                            <th>Total</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count ($stocks) > 0)
                                            @foreach($stocks as $stock)
                                                <tr>
                                                    <td>{{ $loop -> iteration }}</td>
                                                    <td>{{ $stock -> invoice_no }}</td>
                                                    <td>{{ $stock -> stock_date }}</td>
                                                    <td>{{ number_format ($stock -> total, 2) }}</td>
                                                    <td>
                                                        <div class="d-flex">
                                                            <a class="btn btn-dark btn-sm d-block mb-25 me-25"
                                                               target="_blank"
                                                               href="{{ route ('adjustment-increase-invoice', ['stock' => $stock -> id]) }}">
                                                                Print
                                                            </a>
                                                            
                                                            @can('editAdjustmentsIncrease', auth () -> user ())
                                                                <a class="btn btn-primary btn-sm d-block mb-25 me-25"
                                                                   href="{{ route ('adjustments.edit', ['adjustment' => $stock -> id]) }}">
                                                                    Edit
                                                                </a>
                                                            @endcan
                                                            
                                                            @can('deleteAdjustmentsIncrease', auth () -> user ())
                                                                <form method="post"
                                                                      id="delete-confirmation-dialog-{{ $stock -> id }}"
                                                                      action="{{ route ('adjustments.destroy', ['adjustment' => $stock -> id]) }}">
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
