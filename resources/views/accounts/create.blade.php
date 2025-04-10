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
                                      action="{{ route ('accounts.store') }}">
                                    @csrf
                                    <div class="card-body pt-0">
                                        <div class="row">

                                            <div class="col-md-4 mb-1">
                                                <label class="col-form-label font-small-4"
                                                       for="attribute">Account Head</label>
                                                <select name="account-head-id" class="form-control select2"
                                                        data-placeholder="Select"
                                                        onchange="select_account_head_type(this.value, '{{ route ('accounts.get-account-head-type-id') }}')">
                                                    <option></option>
                                                    {!! $account_heads !!}
                                                </select>
                                            </div>

                                            <div class="col-md-4 mb-1">
                                                <label class="col-form-label font-small-4"
                                                       for="attribute">
                                                    Account Type
                                                    <sup class="text-danger fs-5 top-0">*</sup>
                                                </label>
                                                <select name="account-type-id" class="form-control select2"
                                                        data-placeholder="Select" id="account-type-id">
                                                    <option></option>
                                                    @if(count ($types) > 0)
                                                        @foreach($types as $type)
                                                            <option value="{{ $type -> id }}" @selected(old ('account-type-id') == $type -> id)>
                                                                {{ $type -> title }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>

                                            <div class="col-md-4 mb-1">
                                                <label class="col-form-label font-small-4">
                                                    Name
                                                    <sup class="text-danger fs-5 top-0">*</sup>
                                                </label>
                                                <input type="text" class="form-control"
                                                       required="required" autofocus="autofocus"
                                                       name="name" placeholder="Name" value="{{ old ('name') }}"/>
                                            </div>

                                            <div class="col-md-3 mb-1">
                                                <label class="col-form-label font-small-4">Phone No</label>
                                                <input type="text" class="form-control"
                                                       name="phone" placeholder="Phone No" value="{{ old ('phone') }}"/>
                                            </div>
                                            
                                            <div class="col-md-9 mb-1">
                                                <label class="col-form-label font-small-4">Description</label>
                                                <textarea name="description" rows="5"
                                                          class="form-control">{{ old ('description') }}</textarea>
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