<tr>
    <td colspan="2">
        <h5 class="mb-0">Settings</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="settings-privilege" @checked(!empty($permission) && in_array ('settings-privilege', $permission -> permission))>
            <label class="form-check-label">Settings</label>
        </div>
    </td>
</tr>
@include('user-management.privileges.categories', ['permission' => $permission])
@include('user-management.privileges.attributes', ['permission' => $permission])
@include('user-management.privileges.manufacturers', ['permission' => $permission])
@include('user-management.privileges.terms', ['permission' => $permission])
@include('user-management.privileges.branches', ['permission' => $permission])
@include('user-management.privileges.countries', ['permission' => $permission])
@include('user-management.privileges.pages', ['permission' => $permission])
@include('user-management.privileges.couriers', ['permission' => $permission])
@include('user-management.privileges.coupons', ['permission' => $permission])
@include('user-management.privileges.site-settings', ['permission' => $permission])
@include('user-management.privileges.home-settings', ['permission' => $permission])

 