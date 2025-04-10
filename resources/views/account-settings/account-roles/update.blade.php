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
                                      action="{{ route ('account-roles.update', ['account_role' => $role -> id]) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="card-body pt-0">
                                        <div class="row">
                                            <div class="col-md-12 mb-1">
                                                <label class="col-form-label font-small-4"
                                                       for="title">Title</label>
                                                <input type="text" id="title" class="form-control"
                                                       required="required" autofocus="autofocus"
                                                       name="title" placeholder="Title"
                                                       value="{{ old ('title', $role -> title) }}"/>
                                            </div>
                                        </div>

                                        @if(count ($role -> role_models) > 0)
                                            @foreach($role -> role_models as $key => $accountRole)
                                                <input type="hidden" name="role-models[]"
                                                       value="{{ $accountRole -> id }}">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label class="col-form-label font-small-4">Account Head</label>
                                                        <select name="account-head-id[]"
                                                                class="form-control chosen-select"
                                                                required="required" data-placeholder="Select">
                                                            <option>{{ $accountRole -> account_head -> name }}</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <label class="col-form-label font-small-4">Transaction Type</label>
                                                        <select name="type[]" class="form-control chosen-select"
                                                                required="required" data-placeholder="Select">
                                                            <option value="credit" @selected(old ('type.'.$key, $accountRole -> type) == 'credit')>Credit</option>
                                                            <option value="debit" @selected(old ('type.'.$key, $accountRole -> type) == 'debit')>Debit</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif

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