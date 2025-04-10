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
                                            <th>Net Price</th>
                                            <th>Date Added</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count ($returns) > 0)
                                            @foreach($returns as $return)
                                                <tr>
                                                    <td>{{ $loop -> iteration }}</td>
                                                    <td>{{ $return -> reference_no }}</td>
                                                    <td>{{ number_format ($return -> net_price, 2) }}</td>
                                                    <td>{{ $return -> created_at }}</td>
                                                    <td>
                                                        <div class="d-flex">
                                                            <a class="btn btn-dark btn-sm d-block mb-25 me-25"
                                                               target="_blank"
                                                               href="{{ route ('damage-stock-invoice', ['stock_return' => $return -> id]) }}">
                                                                Print
                                                            </a>
                                                            
                                                            @can('editDamageLoss', \App\Models\User::class)
                                                                <a class="btn btn-primary btn-sm d-block mb-25 me-25"
                                                                   href="{{ route ('adjustments.edit-damage-stocks', ['stock_return' => $return -> id]) }}">
                                                                    Edit
                                                                </a>
                                                            @endcan
                                                            
                                                            @can('deleteDamageLoss', \App\Models\User::class)
                                                                <form method="post"
                                                                      id="delete-confirmation-dialog-{{ $return -> id }}"
                                                                      action="{{ route ('adjustments.delete-damage-stocks', ['stock_return' => $return -> id]) }}">
                                                                    @method('DELETE')
                                                                    @csrf
                                                                    <button type="button"
                                                                            onclick="delete_dialog({{ $return -> id }})"
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
