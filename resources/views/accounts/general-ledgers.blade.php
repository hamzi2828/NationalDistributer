<x-dashboard :title="$title">
    @push('styles')
        <link rel="stylesheet" href="{{ asset ('/assets/chosen_v1.8.7/chosen.min.css') }}"></script>
    @endpush
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper p-0">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- Basic table -->
                <section>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{ $title }}</h4>
                                </div>
                                <div class="card-body">
                                    <form method="get" action="{{ route ('accounts.general-ledgers') }}">
                                        <div class="row">
                                            <div class="form-group col-md-4">
                                                <label class="mb-50" for="account-head-id">Account Head</label>
                                                <select name="account-head-id" id="account-head-id"
                                                        class="form-control select2"
                                                        data-placeholder="Select">
                                                    <option></option>
                                                    {!! $account_heads !!}
                                                </select>
                                            </div>
                                            
                                            <div class="form-group col-md-4 mb-1">
                                                <label class="mb-25" for="start-date">Start Date</label>
                                                <input type="text" class="form-control flatpickr-basic" id="start-date"
                                                       data-date-format="d-m-Y"
                                                       name="start-date" value="{{ request ('start-date') }}">
                                            </div>
                                            
                                            <div class="form-group col-md-4 mb-1">
                                                <label class="mb-25" for="end-date">End Date</label>
                                                <input type="text" class="form-control flatpickr-basic"
                                                       data-date-format="d-m-Y" id="end-date"
                                                       name="end-date" value="{{ request ('end-date') }}">
                                            </div>
                                            
                                            <div class="form-group col-md-4">
                                                <label class="mb-50" for="branch-id">Branch</label>
                                                <select name="branch-id" id="branch-id"
                                                        class="form-control chosen-select"
                                                        data-placeholder="Select">
                                                    <option></option>
                                                    @if(count ($branches) > 0)
                                                        @foreach($branches as $branch)
                                                            <option value="{{ $branch -> id }}" @selected(request ('branch-id') == $branch -> id)>
                                                                {{ $branch -> name }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            
                                            <div class="form-group col-md-2 mb-1">
                                                <button type="submit"
                                                        class="btn w-100 mt-2 btn-primary d-block">Search
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                
                                @if(count ($ledgers) > 0)
                                    <div class="row">
                                        <div class="col-md-12 d-flex justify-content-end">
                                            <a href="{{ route ('general-ledgers', request () -> all ()) }}"
                                               target="_blank"
                                               class="btn btn-dark me-2 mb-1 btn-sm">
                                                <i data-feather="printer"></i> Print
                                            </a>
                                        </div>
                                    </div>
                                @endif
                                
                                <div class="table-responsive">
                                    <table class="table w-100 table-hover table-responsive table-striped">
                                        <thead>
                                        <tr>
                                            <th> Sr. No</th>
                                            <th> Branch</th>
                                            <th> Trans. ID</th>
                                            <th> Invoice/Sale ID</th>
                                            <th> Chq/Trans. No</th>
                                            <th> Voucher No.</th>
                                            <th> Date</th>
                                            <th> Description</th>
                                            <th> Debit</th>
                                            <th> Credit</th>
                                            <th> Running Balance</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        {!! $ledgers['html'] !!}
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td></td>
                                            <td colspan="9" align="right">
                                                <strong style="font-size: 12pt; color: #000000;">Net Closing</strong>
                                            </td>
                                            <td>
                                                <strong style="font-size: 12pt; color: #000000;">
                                                    {{ number_format ( $ledgers[ 'net_closing' ], 2 ) }}
                                                </strong>
                                            </td>
                                        </tr>
                                        </tfoot>
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
    @push('scripts')
        <script type="text/javascript" src="{{ asset ('/assets/chosen_v1.8.7/chosen.jquery.min.js') }}"></script>
        <script type="text/javascript">
            $ ( ".chosen-select" ).chosen ();
        
        
        </script>
    @endpush
</x-dashboard>
