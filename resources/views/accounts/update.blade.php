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
                                      action="{{ route ('accounts.update', ['account' => $account -> id]) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="card-body pt-0">
                                        <div class="row">
                                            <div class="col-md-3 mb-1">
                                                <label class="col-form-label font-small-4"
                                                       for="attribute">Account Head</label>
                                                <select name="account-head-id" class="form-control select2"
                                                        data-placeholder="Select" data-allow-clear="true">
                                                    <option></option>
                                                    @if(count ($account_heads) > 0)
                                                        @foreach($account_heads as $account_head)
                                                            <option value="{{ $account_head -> id }}" @selected(old ('account-head-id', $account -> account_head_id) == $account_head -> id) @disabled($account_head -> id == $account -> id)>
                                                                {{ $account_head -> name }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            
                                            <div class="col-md-3 mb-1">
                                                <label class="col-form-label font-small-4"
                                                       for="attribute">Account Type</label>
                                                <select name="account-type-id" class="form-control select2"
                                                        data-placeholder="Select">
                                                    <option></option>
                                                    @if(count ($types) > 0)
                                                        @foreach($types as $type)
                                                            <option value="{{ $type -> id }}" @selected(old ('account-type-id', $account -> account_type_id) == $type -> id)>
                                                                {{ $type -> title }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            
                                            <div class="col-md-3 mb-1">
                                                <label class="col-form-label font-small-4">Name</label>
                                                <input type="text" class="form-control"
                                                       required="required" autofocus="autofocus"
                                                       name="name" placeholder="Name"
                                                       value="{{ old ('name', $account -> name) }}" />
                                            </div>
                                            
                                            <div class="col-md-3 mb-1">
                                                <label class="col-form-label font-small-4">Phone No</label>
                                                <input type="text" class="form-control"
                                                       name="phone" placeholder="Phone No"
                                                       value="{{ old ('phone', $account -> phone) }}" />
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-12 mb-1">
                                                <textarea name="description" rows="5"
                                                          class="form-control">{{ old ('description', $account -> description) }}</textarea>
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