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
                                        <th>Title</th>
                                        <th>Account Models</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count ($roles) > 0)
                                        @foreach($roles as $role)
                                            <tr>
                                                <td>{{ $loop -> iteration }}</td>
                                                <td>{{ $role -> title }}</td>
                                                <td></td>
                                                <td>
                                                    <div class="align-content-start d-flex justify-content-start">
                                                        @can('edit', $role)
                                                            <a class="btn btn-primary btn-sm d-block mb-25 me-25"
                                                               href="{{ route ('account-roles.edit', ['account_role' => $role -> id]) }}">
                                                                Edit
                                                            </a>
                                                        @endcan

                                                        @can('delete', $role)
                                                            <form method="post"
                                                                  id="delete-confirmation-dialog-{{ $role -> id }}"
                                                                  action="{{ route ('account-roles.destroy', ['account_role' => $role -> id]) }}">
                                                                @method('DELETE')
                                                                @csrf
                                                                <button type="button"
                                                                        onclick="delete_dialog({{ $role -> id }})"
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