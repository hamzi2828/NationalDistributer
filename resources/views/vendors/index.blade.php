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
                                            <th>Company Name</th>
                                            <th>License No</th>
                                            <th>Representative</th>
                                            <th>Mobile</th>
                                            <th>Phone</th>
                                            <th>Address</th>
                                            <th>Status</th>
                                            <th>Dated Added</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count ($vendors) > 0)
                                            @foreach($vendors as $vendor)
                                                <tr>
                                                    <td>{{ $loop -> iteration }}</td>
                                                    <td>{{ $vendor -> name }}</td>
                                                    <td>{{ $vendor -> license }}</td>
                                                    <td>{{ $vendor -> representative }}</td>
                                                    <td>{{ $vendor -> mobile }}</td>
                                                    <td>{{ $vendor -> phone }}</td>
                                                    <td>{{ $vendor -> address }}</td>
                                                    <td>
                                                        <span class="badge bg-{{ $vendor -> active == '1' ? 'success' : 'danger' }}">
                                                            {{ $vendor -> active == '1' ? 'Active' : 'Inactive' }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $vendor -> created_at }}</td>
                                                    <td>
                                                        <div class="align-content-start d-flex justify-content-start flex-column">
                                                            @can('edit', $vendor)
                                                                <a class="btn btn-primary btn-sm d-block mb-25 me-25"
                                                                   href="{{ route ('vendors.edit', ['vendor' => $vendor -> id]) }}">
                                                                    Edit
                                                                </a>
                                                            @endcan
                                                            
                                                            @can('status', $vendor)
                                                                <a class="btn btn-warning btn-sm d-block mb-25 me-25"
                                                                   onclick="return confirm('Are you sure?')"
                                                                   href="{{ route ('vendors.status', ['vendor' => $vendor -> id]) }}">
                                                                    Active/Inactive
                                                                </a>
                                                            @endcan
                                                            
                                                            @can('delete', $vendor)
                                                                <form method="post"
                                                                      id="delete-confirmation-dialog-{{ $vendor -> id }}"
                                                                      action="{{ route ('vendors.destroy', ['vendor' => $vendor -> id]) }}">
                                                                    @method('DELETE')
                                                                    @csrf
                                                                    <button type="button"
                                                                            onclick="delete_dialog({{ $vendor -> id }})"
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