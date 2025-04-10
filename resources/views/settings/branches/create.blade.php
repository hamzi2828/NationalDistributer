<x-dashboard :title="$title">
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
                                      action="{{ route ('branches.store') }}">
                                    @csrf
                                    <div class="card-body pt-0">
                                        <div class="row">
                                            <div class="col-md-2 mb-1">
                                                <label class="col-form-label font-small-4"
                                                       for="code">Code</label>
                                                <input type="text" id="code" class="form-control"
                                                       required="required" autofocus="autofocus"
                                                       name="code" placeholder="Branch Code"
                                                       value="{{ old ('code') }}"/>
                                            </div>

                                            <div class="col-md-4 mb-1">
                                                <label class="col-form-label font-small-4"
                                                       for="name">Name</label>
                                                <input type="text" id="name" class="form-control"
                                                       required="required"
                                                       name="name" placeholder="Branch Name"
                                                       value="{{ old ('name') }}"/>
                                            </div>

                                            <div class="col-md-3 mb-1">
                                                <label class="col-form-label font-small-4"
                                                       for="manager">Branch Manager</label>
                                                <select name="branch-manager-id" class="form-control select2"
                                                        data-placeholder="Select" required="required">
                                                    <option></option>
                                                    @if(count($users) > 0)
                                                        @foreach($users as $user)
                                                            <option value="{{ $user -> id }}" @selected(old ('branch-manager-id') == $user -> id)>
                                                                {{ $user -> name }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>

                                            <div class="col-md-3 mb-1">
                                                <label class="col-form-label font-small-4"
                                                       for="country">Country</label>
                                                <select name="country-id" class="form-control select2"
                                                        data-placeholder="Select" required="required">
                                                    <option></option>
                                                    @if(count($countries) > 0)
                                                        @foreach($countries as $country)
                                                            <option value="{{ $country -> id }}" @selected(old ('country-id') == $country -> id)>
                                                                {{ $country -> title }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-3 mb-1">
                                                <label class="col-form-label font-small-4"
                                                       for="landline">Landline</label>
                                                <input type="text" id="landline" class="form-control"
                                                       required="required" name="landline" placeholder="Landline"
                                                       value="{{ old ('landline') }}"/>
                                            </div>

                                            <div class="col-md-3 mb-1">
                                                <label class="col-form-label font-small-4"
                                                       for="mobile">Mobile</label>
                                                <input type="text" id="mobile" class="form-control"
                                                       required="required" name="mobile" placeholder="Mobile"
                                                       value="{{ old ('mobile') }}"/>
                                            </div>

                                            <div class="col-md-6 mb-1">
                                                <label class="col-form-label font-small-4"
                                                       for="address">Address</label>
                                                <textarea rows="5" id="address" class="form-control"
                                                          required="required" name="address"
                                                          placeholder="Address">{{ old ('address') }}</textarea>
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
</x-dashboard>