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
                                <table class="datatable table w-100 table-striped">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Account Head</th>
                                        <th>Account Type</th>
                                        <th>Name</th>
                                        <th>Phone No</th>
                                        <th>Date Created</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count ($accounts) > 0)
                                        @foreach($accounts as $account)
                                            <tr>
                                                <td>{{ $loop -> iteration }}</td>
                                                <td>{{ @$account -> account_head -> name }}</td>
                                                <td>{{ @$account -> account_type -> title }}</td>
                                                <td>{{ $account -> name }}</td>
                                                <td>{{ $account -> phone }}</td>
                                                <td>{{ $account -> created_at }}</td>
                                                <td>
                                                    <div class="align-content-start d-flex justify-content-start">
                                                        @can('edit', $account)
                                                            <a class="btn btn-primary btn-sm d-block mb-25 me-25"
                                                               href="{{ route ('accounts.edit', ['account' => $account -> id]) }}">
                                                                Edit
                                                            </a>
                                                        @endcan

                                                        @can('delete', $account)
                                                            <form method="post"
                                                                  id="delete-confirmation-dialog-{{ $account -> id }}"
                                                                  action="{{ route ('accounts.destroy', ['account' => $account -> id]) }}">
                                                                @method('DELETE')
                                                                @csrf
                                                                <button type="button"
                                                                        onclick="delete_dialog({{ $account -> id }})"
                                                                        class="btn btn-danger btn-sm d-block w-100">Delete
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