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
                                            <th>Attribute</th>
                                            <th>Title</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count ($terms) > 0)
                                            @foreach($terms as $term)
                                                <tr>
                                                    <td>{{ $loop -> iteration }}</td>
                                                    <td>{{ $term -> attribute -> title }}</td>
                                                    <td>{{ $term -> title }}</td>
                                                    <td>
                                                        <div class="align-content-start d-flex justify-content-start">
                                                            @can('edit', $term)
                                                                <a class="btn btn-primary btn-sm d-block mb-25 me-25"
                                                                   href="{{ route ('terms.edit', ['term' => $term -> id]) }}">
                                                                    Edit
                                                                </a>
                                                            @endcan
                                                            
                                                            @can('delete', $term)
                                                                <form method="post"
                                                                      id="delete-confirmation-dialog-{{ $term -> id }}"
                                                                      action="{{ route ('terms.destroy', ['term' => $term -> id]) }}">
                                                                    @method('DELETE')
                                                                    @csrf
                                                                    <button type="button"
                                                                            onclick="delete_dialog({{ $term -> id }})"
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