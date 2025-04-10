
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
                            @include('sales.search')
                            <div class="card">
                                <div class="table-responsive">
                                    <table class="table w-100 table-striped">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Actions</th>
                                            <th>Sale ID</th>
                                            <th>Order No</th>
                                            <th>User</th>
                                            <th>Customer</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Discount (%)</th>
                                            <th>Discount (Flat)</th>
                                            <th>Shipping</th>
                                            <th>Net Price</th>
                                            <th>Remarks</th>
                                            <th>Closed Date</th>
                                            <th>Dated Added</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count ($sales) > 0)
                                            @foreach($sales as $sale)
                                                <tr>
                                                    <td>{{ $loop -> iteration }}</td>
                                                    <td>
                                                        <div>
                                                            @if($sale -> refunded == '1')
                                                                <a class="btn btn-dark btn-sm d-block mb-25 me-25"
                                                                   target="_blank"
                                                                   href="{{ route ('refund.invoice', ['sale' => $sale -> id]) }}">
                                                                    Print
                                                                </a>
                                                            @else
                                                                <a class="btn btn-info btn-sm d-block mb-25 me-25"
                                                                   target="_blank"
                                                                   href="{{ route ('sales.c-invoice', ['sale' => $sale -> id]) }}">
                                                                    C-Print
                                                                </a>

                                                                <a class="btn btn-dark btn-sm d-block mb-25 me-25"
                                                                   target="_blank"
                                                                   href="{{ route ('sales.invoice', ['sale' => $sale -> id]) }}">
                                                                    View/Print
                                                                </a>

                                                                <a class="btn btn-primary btn-sm d-block mb-25 me-25"
                                                                   target="_blank"
                                                                   href="{{ route ('sales.invoice', ['sale' => $sale -> id, 'picture' => 'true']) }}">
                                                                    Print (P)
                                                                </a>

                                                                <a class="btn bg-bitbucket btn-sm d-block mb-25 me-25 text-white"
                                                                   target="_blank"
                                                                   href="{{ route ('sales.invoice-html', ['sale' => $sale -> id]) }}">
                                                                    Print (H)
                                                                </a>

                                                                <a class="btn bg-adn btn-sm d-block mb-25 me-25 text-white"
                                                                   target="_blank"
                                                                   href="{{ route ('sales.invoice-commerce', ['sale' => $sale -> id]) }}">
                                                                    Print (C)
                                                                </a>
                                                            @endif

                                                            @if($sale -> sale_closed == '1' && $sale -> refunded == '0')
                                                                @can('sale_refund', $sale)
                                                                    <a class="btn btn-info btn-sm d-block mb-25 me-25"
                                                                       onclick="return confirm('Are you sure?')"
                                                                       href="{{ route ('sales.refund-sale', ['sale' => $sale -> id]) }}">
                                                                        Refund
                                                                    </a>
                                                                @endcan

                                                                <a class="btn btn-warning btn-sm d-block mb-25 me-25"
                                                                   target="_blank"
                                                                   href="{{ route ('sales.ticket', ['sale' => $sale -> id]) }}">
                                                                    Ticket
                                                                </a>
                                                            @endif

                                                            @if($sale -> sale_closed == '0')
                                                                @can('status', $sale)
                                                                    <a class="btn btn-foursquare btn-sm d-block mb-25 me-25"
                                                                       onclick="return confirm('Are you sure?')"
                                                                       href="{{ route ('sales.status', ['sale' => $sale -> id]) }}">
                                                                        {{ $sale -> status == '1' ? 'Deactivate' : 'Activate' }}
                                                                    </a>
                                                                @endcan

                                                                @can('close_bill', $sale)
                                                                    <a class="btn btn-warning btn-sm d-block mb-25 me-25"
                                                                       onclick="return confirm('Are you sure?')"
                                                                       href="{{ route ('sales.close-sale', ['sale' => $sale -> id]) }}">
                                                                        Close
                                                                    </a>
                                                                @endcan
                                                            {{--
                                                                @can('edit', $sale)
                                                                    <a class="btn btn-primary btn-sm d-block mb-25 me-25"
                                                                       href="{{ route ('sales.edit', ['sale' => $sale -> id]) }}">
                                                                        Edit
                                                                    </a>
                                                                @endcan --}}

                                                                @can('edit', $sale)
                                                                    <a class="btn btn-primary btn-sm d-block mb-25 me-25"
                                                                    href="{{ route('sales.edit', ['sale' => $sale->id]) }}"
                                                                    data-created-by="{{ $sale->user->branch_id  }}"
                                                                    onclick="return checkOrderCreator(this)">
                                                                        Edit
                                                                    </a>
                                                                @endcan

                                                                {{-- @can('edit_online', $sale)
                                                                <a class="btn btn-primary btn-sm d-block mb-25 me-25"
                                                                href="{{ route('sales.edit', ['sale' => $sale->id]) }}"
                                                                data-created-by="{{ $sale->user->branch_id  }}"
                                                                onclick="return checkOrderCreator(this)">
                                                                    Edit
                                                                </a>
                                                             @endcan --}}

                                                                @can('delete', $sale)
                                                                    <form method="post"
                                                                          id="delete-confirmation-dialog-{{ $sale -> id }}"
                                                                          action="{{ route ('sales.destroy', ['sale' => $sale -> id]) }}">
                                                                        @method('DELETE')
                                                                        @csrf
                                                                        <button type="button"
                                                                                onclick="delete_dialog({{ $sale -> id }})"
                                                                                class="btn btn-danger btn-sm d-block w-100">
                                                                            Delete
                                                                        </button>
                                                                    </form>
                                                                @endcan
                                                            @endif

                                                            <a class="btn btn-secondary btn-sm d-block mb-25 me-25 text-white"
                                                               href="javascript:void(0)"
                                                               onclick="loadTrackingPopup('{{ route ('sales.tracking', ['sale' => $sale -> id]) }}')">
                                                                Tracking
                                                            </a>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        {{ $sale -> id }}
                                                        @if($sale -> is_online == '1')
                                                            <span class="badge bg-warning">
                                                            Online
                                                        </span>
                                                        @endif
                                                        <span class="badge bg-primary">
                                                            {{ $sale -> status == '1' ? 'Active' : 'Inactive' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        {{ $sale -> sale_id }}
                                                    </td>
                                                    <td>
                                                        {{ $sale -> user ?-> name }}
                                                        {{-- <td>{{ $sale->user ? $sale->user->name . ' (Branch ID: ' . $sale->user->branch_id . ')' : '' }}</td> --}}
                                                    </td>
                                                    <td>
                                                        {{ $sale -> customer -> name }}
                                                        @if($sale -> refunded == '1')
                                                            <span class="badge bg-primary">Sale Refunded</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $sale -> sold_quantity() }}</td>
                                                    <td>{{ number_format ($sale -> total, 2) }}</td>
                                                    <td>{{ number_format ($sale -> percentage_discount, 2)	 }}</td>
                                                    <td>{{ number_format ($sale -> flat_discount, 2)	 }}</td>
                                                    <td>{{ number_format ($sale -> shipping, 2)	 }}</td>
                                                    <td>{{ number_format ($sale -> net, 2) }}</td>
                                                    <td>{{ $sale -> remarks }}</td>
                                                    <td>{{ $sale -> closed_at }}</td>
                                                    <td>{{ $sale -> created_at }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            {{ $sales -> appends(request() -> query()) -> links('pagination::bootstrap-5') }}
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


@push('custom-scripts')
    <script type="text/javascript">
        function checkOrderCreator(element) {
            var orderCreatorBranchId = element.getAttribute('data-created-by');
            var loggedInUserbranchId = "{{ Auth::user()->branch_id }}";

            if (orderCreatorBranchId != loggedInUserbranchId) {
                return confirm('You are not the creator of this order. and your branch ID does not match . Are you sure you want to edit it?');
            }

            return true;
        }
    </script>
@endpush

    @endpush
</x-dashboard>
