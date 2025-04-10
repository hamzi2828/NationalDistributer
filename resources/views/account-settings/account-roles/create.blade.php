<x-dashboard :title="$title">
    @push('styles')
        <link rel="stylesheet" href="{{ asset ('/assets/chosen_v1.8.7/chosen.min.css') }}"></script>
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
                                      action="{{ route ('account-roles.store') }}">
                                    @csrf
                                    <div class="card-body pt-0">
                                        <div class="row">
                                            <div class="col-md-12 mb-1">
                                                <label class="col-form-label font-small-4">Title</label>
                                                <input type="text" class="form-control"
                                                       required="required" autofocus="autofocus"
                                                       name="title" placeholder="Title" value="{{ old ('title') }}"/>
                                            </div>
                                        </div>

                                        @for($loop = 0; $loop <= 4; $loop++)
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label class="col-form-label font-small-4">Account Head</label>
                                                    <select name="account-head-id[]" class="form-control chosen-select"
                                                            data-placeholder="Select">
                                                        <option></option>
                                                        {!! $account_heads !!}
                                                    </select>
                                                </div>

                                                <div class="col-md-3">
                                                    <label class="col-form-label font-small-4">Transaction Type</label>
                                                    <select name="type[]" class="form-control chosen-select"
                                                            required="required" data-placeholder="Select">
                                                        <option value="credit" @selected(old ('type.'.$loop) == 'credit')>Credit</option>
                                                        <option value="debit" @selected(old ('type.'.$loop) == 'debit')>Debit</option>
                                                    </select>
                                                </div>
                                            </div>
                                        @endfor

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