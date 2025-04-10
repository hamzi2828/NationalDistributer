<div class="row mb-2 mt-2 border-top pt-2">
    <div class="col-lg-8 d-flex align-items-center">
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" id="check-all" />
            <label class="form-check-label" for="check-all">Assign All Privileges</label>
        </div>
    </div>
    
    <div class="col-lg-4">
        <input type="text" class="form-control" id="search-privileges" placeholder="Search Privileges">
    </div>
</div>

<div class="table-responsive">
    <table class="table table-bordered text-capitalize" id="privileges">
        <thead>
        <tr>
            <th width="30%">Modules</th>
            <th width="30%">Sub Modules</th>
            <th width="40%">Privileges</th>
        </tr>
        </thead> 
        <tbody>
        @include('user-management.privileges.dashboard', ['permission' => $permission])
        @include('user-management.privileges.sales', ['permission' => $permission])
        @include('user-management.privileges.products', ['permission' => $permission])

        @include('user-management.privileges.review-settings', ['permission' => $permission])
        @include('user-management.privileges.stocks', ['permission' => $permission])

        @include('user-management.privileges.stock-returns', ['permission' => $permission])
        @include('user-management.privileges.stock-returns-customers', ['permission' => $permission])
        @include('user-management.privileges.stock-takes', ['permission' => $permission])
        @include('user-management.privileges.adjustments', ['permission' => $permission])
        @include('user-management.privileges.issuance', ['permission' => $permission])

        @include('user-management.privileges.customers', ['permission' => $permission])

        @include('user-management.privileges.vendors', ['permission' => $permission])
        
        @include('user-management.privileges.accounts', ['permission' => $permission])
        @include('user-management.privileges.account-settings', ['permission' => $permission])
        @include('user-management.privileges.accounts-reporting', ['permission' => $permission])
        @include('user-management.privileges.reporting', ['permission' => $permission])
        @include('user-management.privileges.users', ['permission' => $permission])
        @include('user-management.privileges.user-management', ['permission' => $permission])
        @include('user-management.privileges.settings', ['permission' => $permission])
        </tbody>
    </table>
</div>
