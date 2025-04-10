<div class="card mb-3">
    <div class="card-header border-bottom">
        <h5 class="card-title mb-0">Search</h5>
    </div>
    <div class="card-body mt-1">
        <form method="get" action="{{ request () -> fullUrl () }}">
            <div class="row">
                <div class="col-md-3 form-group">
                    <label class="col-form-label font-small-4" for="start-date">Start Date</label>
                    <input type="text" name="start-date" class="form-control flatpickr-basic" id="start-date"
                           value="{{ request ('start-date') }}">
                </div>
                
                <div class="col-md-3 form-group">
                    <label class="col-form-label font-small-4" for="end-date">End Date</label>
                    <input type="text" name="end-date" class="form-control flatpickr-basic" id="end-date"
                           value="{{ request ('end-date') }}">
                </div>
                
                <div class="col-md-3 form-group">
                    <label class="col-form-label font-small-4" for="sale-id">Sale ID</label>
                    <input type="number" name="sale-id" class="form-control" id="sale-id"
                           value="{{ request ('sale-id') }}">
                </div>
                
                <div class="col-md-3 form-group">
                    <label class="col-form-label font-small-4" for="order-no">Order No</label>
                    <input type="number" name="order-no" class="form-control" id="order-no"
                           value="{{ request ('order-no') }}">
                </div>
                
                <div class="col-md-3 form-group">
                    <label class="col-form-label font-small-4" for="customer-id">Customer</label>
                    <select name="customer-id" class="form-control select2" data-placeholder="Select"
                            data-allow-clear="true"
                            id="customer-id">
                        <option></option>
                        @if(count ($customers) > 0)
                            @foreach($customers as $customer)
                                <option value="{{ $customer -> id }}"
                                        @selected(request ('customer-id') == $customer -> id)>
                                    {{ $customer -> name }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
                
                <div class="col-md-3 form-group">
                    <label class="col-form-label font-small-4" for="user-id">User</label>
                    <select name="user-id" class="form-control select2" data-placeholder="Select"
                            data-allow-clear="true"
                            id="user-id">
                        <option></option>
                        @if(count ($users) > 0)
                            @foreach($users as $user)
                                <option value="{{ $user -> id }}"
                                        @selected(request ('user-id') == $user -> id)>
                                    {{ $user -> name }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
                
                <div class="col-md-1 form-group">
                    <button type="submit" class="btn btn-primary w-100 mt-38">
                        <i data-feather='search'></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>