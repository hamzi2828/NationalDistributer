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
                                            <th>From Branch</th>
                                            <th>To Branch</th>
                                            <th>Products</th>
                                            <th>Quantity</th>
                                            <th>Received</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count ($issuance) > 0)
                                            @foreach($issuance as $issued)
                                                <tr>
                                                    <td>{{ $loop -> iteration }}</td>
                                                    <td>{{ $issued -> issuance_from_branch -> fullName() }}</td>
                                                    <td>{{ $issued -> issuance_to_branch -> fullName() }}</td>
                                                    <td>
                                                        @if(count($issued -> products) > 0)
                                                            @foreach($issued -> products as $product)
                                                                {{ $product -> product -> productTitle() }}
                                                                <hr class="mt-25 mb-25" />
                                                            @endforeach
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if(count($issued -> products) > 0)
                                                            @foreach($issued -> products as $product)
                                                                {{ $product -> quantity }}
                                                                <hr class="mt-25 mb-25" />
                                                            @endforeach
                                                        @endif
                                                    </td>
                                                    <td>
                                                    <span class="badge badge-light-primary">
                                                        {{ $issued -> received == '1' ? 'Yes' : 'No' }}
                                                    </span>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            @can('print', \App\Models\Issuance::class)
                                                                <a class="btn btn-dark btn-sm d-block mb-25 me-25"
                                                                   target="_blank"
                                                                   href="{{ route ('issuance.invoice', ['issuance' => $issued -> id]) }}">
                                                                    Print
                                                                </a>
                                                            @endcan
                                                            
                                                            @can('p_print', \App\Models\Issuance::class)
                                                                <a class="btn btn-warning btn-sm d-block mb-25 me-25"
                                                                   target="_blank"
                                                                   href="{{ route ('issuance.p-invoice', ['issuance' => $issued -> id]) }}">
                                                                    P-Print
                                                                </a>
                                                            @endcan
                                                            
                                                            @if($issued -> received == '0')
                                                                
                                                                @can('received', $issued)
                                                                    <a class="btn btn-info btn-sm d-block mb-25 me-25"
                                                                       onclick="return confirm('Are you sure?')"
                                                                       href="{{ route ('issuance.received', ['issuance' => $issued -> id]) }}">
                                                                        Received
                                                                    </a>
                                                                @endcan
                                                                
                                                                @can('edit', $issued)
                                                                    <a class="btn btn-primary btn-sm d-block mb-25 me-25"
                                                                       href="{{ route ('issuance.edit', ['issuance' => $issued -> id]) }}">
                                                                        Edit
                                                                    </a>
                                                                @endcan
                                                                
                                                                @can('delete', $issued)
                                                                    <form method="post"
                                                                          id="delete-confirmation-dialog-{{ $issued -> id }}"
                                                                          action="{{ route ('issuance.destroy', ['issuance' => $issued -> id]) }}">
                                                                        @method('DELETE')
                                                                        @csrf
                                                                        <button type="button"
                                                                                onclick="delete_dialog({{ $issued -> id }})"
                                                                                class="btn btn-danger btn-sm d-block w-100">
                                                                            Delete
                                                                        </button>
                                                                    </form>
                                                                @endcan
                                                            @endif
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