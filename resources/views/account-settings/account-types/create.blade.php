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
                                      action="{{ route ('account-types.store') }}">
                                    @csrf
                                    <div class="card-body pt-0">
                                        <div class="row">
                                            <div class="col-md-9 mb-1">
                                                <label class="col-form-label font-small-4"
                                                       for="title">Title</label>
                                                <input type="text" id="title" class="form-control"
                                                       required="required" autofocus="autofocus"
                                                       name="title" placeholder="Title" value="{{ old ('title') }}"/>
                                            </div>

                                            <div class="col-md-3 mb-1">
                                                <label class="col-form-label font-small-4"
                                                       for="title">Account Tye</label>
                                                <select name="type" class="form-control select2" required="required"
                                                        data-placeholder="Select">
                                                    <option></option>
                                                    <option value="credit" @selected(old ('type') == 'credit')>Credit</option>
                                                    <option value="debit" @selected(old ('type') == 'debit')>Debit</option>
                                                </select>
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