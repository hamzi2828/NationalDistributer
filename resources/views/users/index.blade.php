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
                                            <th>Country</th>
                                            <th>Branch</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Mobile</th>
                                            <th>Role(s)</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count ($users) > 0)
                                            @foreach($users as $user)
                                                <tr>
                                                    <td>{{ $loop -> iteration }}</td>
                                                    <td>{{ $user -> country ? $user -> country -> title : '' }}</td>
                                                    <td>{{ $user -> branch ? $user -> branch -> name : '' }}</td>
                                                    <td>
                                                        {{ $user -> name }}
                                                        @if($user -> type == 'frontend')
                                                            <span class="badge bg-danger">Frontend</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $user -> email }}</td>
                                                    <td>{{ $user -> mobile }}</td>
                                                    <td>
                                                        @if(count($user -> roles) > 0)
                                                            @foreach($user -> roles as $role)
                                                                @if(!empty($role -> role))
                                                                    {{ $role -> role -> title }}
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    </td>
                                                    <td>{{ $user -> status }}</td>
                                                    <td>
                                                        <div class="align-content-start d-flex justify-content-start flex-column">
                                                            
                                                            @can('edit', \App\Models\User::class)
                                                                <a class="btn btn-primary btn-sm d-block mb-25"
                                                                   href="{{ route ('users.edit', ['user' => $user -> id]) }}">
                                                                    Edit
                                                                </a>
                                                            @endcan
                                                            
                                                            @can('status', $user)
                                                            @if(auth()->user()->id != $user->id)
                                                                <form method="post" class="mb-25" action="{{ route('users.status', ['user' => $user->id]) }}">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-warning btn-sm d-block w-100">
                                                                        Active/Inactive
                                                                    </button>
                                                                </form>
                                                            @endif
                                                        @endcan
                                                            
                                                            @can('delete', $user)
                                                                @if(auth () -> user () -> id != $user -> id)
                                                                    <form method="post"
                                                                          id="delete-confirmation-dialog-{{ $user -> id }}"
                                                                          action="{{ route ('users.destroy', ['user' => $user -> id]) }}">
                                                                        @method('DELETE')
                                                                        @csrf
                                                                        <button type="button"
                                                                                onclick="delete_dialog({{ $user -> id }})"
                                                                                class="btn btn-danger btn-sm d-block w-100">
                                                                            Delete
                                                                        </button>
                                                                    </form>
                                                                @endif
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