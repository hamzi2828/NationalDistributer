<x-dashboard :title="$title">
    @push('styles')
        <link rel="stylesheet" href="{{ asset ('/assets/chosen_v1.8.7/chosen.min.css') }}"></script>
        <style>
            tbody, td, tfoot, th, thead, tr {
                padding : 10px !important;
            }
        </style>
    @endpush
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper p-0">
            <div class="content-body">
                <section id="basic-horizontal-layouts">
                    <div class="row">
                        <div class="col-md-12 col-md-12">
                            @include('errors.validation-errors')
                            <div class="card">
                                <div class="border-bottom-light card-header mb-2 pb-1 pb-1">
                                    <h4 class="card-title">{{ $title }}</h4>
                                </div>
                                <form class="form" method="post"
                                      action="{{ route ('issuance.store') }}">
                                    @csrf
                                    <div class="card-body pt-0">
                                        <div class="row">
                                            <div class="offset-md-2 col-md-4 mb-1">
                                                <label class="col-form-label font-small-4"
                                                       for="title">Transfer From</label>
                                                <select name="from-branch-id" class="form-control select2"
                                                        id="transfer-from-branch"
                                                        required="required" data-placeholder="Select">
                                                    <option></option>
                                                    @if(count ($branches) > 0)
                                                        @foreach($branches as $branch)
                                                        @if($branch->id == Auth::user()->branch_id)
                                                            <option value="{{ $branch -> id }}" @selected(old ('from-branch-id') == $branch -> id)>
                                                                {{ $branch -> name }}
                                                            </option>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </select>

                                                {{-- <select name="from-branch-id" class="form-control select2"
                                                    id="transfer-from-branch"
                                                    required="required" data-placeholder="Select">
                                                <option></option>
                                                @foreach($branches as $branch)
                                                    @if($branch->id == Auth::user()->branch_id)
                                                        <option value="{{ $branch->id }}" selected>
                                                            {{ $branch->name }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select> --}}


                                            </div>
                                            
                                            <div class="col-md-4 mb-1">
                                                <label class="col-form-label font-small-4"
                                                       for="title">Transfer To</label>
                                                <select name="to-branch-id" class="form-control select2"
                                                        required="required" data-placeholder="Select">
                                                    <option></option>
                                                    @if(count ($branches) > 0)
                                                        @foreach($branches as $branch)
                                                        @if($branch->id != Auth::user()->branch_id)
                                                            <option value="{{ $branch -> id }}" @selected(old ('to-branch-id') == $branch -> id)>
                                                                {{ $branch -> name }}
                                                            </option>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </select> 
                                                {{-- <select name="to-branch-id" class="form-control select2"
                                                        required="required" data-placeholder="Select">
                                                    <option></option>
                                                    @foreach($branches as $branch)
                                                        @if($branch->id != Auth::user()->branch_id)
                                                            <option value="{{ $branch->id }}" @selected(old('to-branch-id') == $branch->id)>
                                                                {{ $branch->name }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select> --}}

                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="card">
                                                            <div class="card-body p-0 mt-1 border p-1 rounded-2"
                                                                 style="height: 270px">
                                                                <select class="form-control select2"
                                                                        id="transfer-products"
                                                                        data-placeholder="Transfer Product(s)">
                                                                    <option></option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-8 mb-1 mt-1">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-hover">
                                                        <thead>
                                                        <tr>
                                                            <th width="2%"></th>
                                                            <th width="45%">Product</th>
                                                            <th width="18%">Available Qty.</th>
                                                            <th width="35%">Transfer Qty.</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody id="transfer-products-table"></tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary me-1">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
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
