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
                                            <th>Title</th>
                                            <th>Code</th>
                                            <th>Discount (%)</th>
                                            <th>Usage Frequency</th>
                                            <th>Used Frequency</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count ($coupons) > 0)
                                            @foreach($coupons as $coupon)
                                                <tr>
                                                    <td>{{ $loop -> iteration }}</td>
                                                    <td>{{ $coupon -> title }}</td>
                                                    <td>{{ $coupon -> code }}</td>
                                                    <td>{{ number_format ($coupon -> discount, 2) }}</td>
                                                    <th>{{ $coupon -> use_frequency }}</th>
                                                    <th>{{ $coupon -> used_frequency }}</th>
                                                    <td>{{ \Carbon\Carbon::parse($coupon['start_date'])->format('d/m/Y') }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($coupon['end_date'])->format('d/m/Y') }}</td>
                                                    <th style="font-weight: normal;">{{ $coupon->status }}</th>
                                                    <td class="w-100">
                                                        <div class="align-content-start d-flex justify-content-start flex-column ">
                                                            @can('edit', $coupon)
                                                                <a class="btn btn-primary btn-sm d-block mb-25 me-25"
                                                                   href="{{ route ('coupons.edit', ['coupon' => $coupon -> id]) }}">
                                                                    Edit
                                                                </a>
                                                            @endcan
                                                            
                                                            @can('delete', $coupon)
                                                                <form method="post"
                                                                      id="delete-confirmation-dialog-{{ $coupon -> id }}"
                                                                      action="{{ route ('coupons.destroy', ['coupon' => $coupon -> id]) }}">
                                                                    @method('DELETE')
                                                                    @csrf
                                                                    <button type="button"
                                                                            onclick="delete_dialog({{ $coupon -> id }})"
                                                                            class="btn btn-danger btn-sm d-block w-100">
                                                                        Delete
                                                                    </button>
                                                                </form>
                                                            @endcan
                                                            @can('delete', $coupon)
                                                            <form method="post" class="mb-25" action="{{ route('coupons.status', ['coupon' => $coupon->id]) }}">
                                                                @csrf
                                                                @method('PATCH')
                                                                <!-- Pass the current status in a hidden input field -->
                                                                <input type="hidden" name="status" value="{{ $coupon->status }}">
                                                                <button type="submit" onclick="return confirmStatusChange('{{ $coupon->status }}')" 
                                                                    class="btn btn-warning mt-25 btn-sm d-block w-100">
                                                                    Active / Inactive
                                                                </button>
                                                            </form>
                                                            
                                                            <!-- Include this script in your Blade file or in a separate JS file -->
                                                            <script>
                                                                function confirmStatusChange(currentStatus) {
                                                                    var newStatus = currentStatus === 'active' ? 'inactive' : 'active';
                                                                    return confirm('Are you sure you want to change the status to ' + newStatus + '?');
                                                                }
                                                            </script>
                                                            
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