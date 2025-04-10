<x-dashboard :title="$title">
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper p-0">
            <div class="content-header row"></div>
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
                                            <th>Title</th>
                                            <th>Rate (%)</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count($taxes) > 0)
                                            @foreach($taxes as $tax)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $tax->title }}</td>
                                                    <td>{{ number_format($tax->rate, 2) }}%</td> <!-- Display tax rate with two decimals -->
                                                    <td>
                                                        <div class="align-content-start d-flex justify-content-start">
                                                            {{-- @can('edit', $tax) --}}
                                                                <a class="btn btn-primary btn-sm d-block mb-25 me-25"
                                                                   href="{{ route('taxes.edit', ['tax' => $tax->id]) }}">
                                                                    Edit
                                                                </a>
                                                            {{-- @endcan --}}

                                                            {{-- @can('delete', $tax) --}}
                                                                <form method="post"
                                                                      id="delete-confirmation-dialog-{{ $tax->id }}"
                                                                      action="{{ route('taxes.destroy', ['tax' => $tax->id]) }}">
                                                                    @method('DELETE')
                                                                    @csrf
                                                                    <button type="button"
                                                                            onclick="delete_dialog({{ $tax->id }})"
                                                                            class="btn btn-danger btn-sm d-block w-100">
                                                                        Delete
                                                                    </button>
                                                                </form>
                                                            {{-- @endcan --}}
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="4" class="text-center">No taxes available.</td>
                                            </tr>
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
            $("div.head-label").html('<h4 class="fw-bolder mb-0">{{ $title }}</h4>');
        </script>
    @endpush
</x-dashboard>
