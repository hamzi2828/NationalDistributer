<tr>
    <td colspan="2">
        <h5 class="mb-0">Account Settings</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="account-settings-privilege" @checked(!empty($permission) && in_array ('account-settings-privilege', $permission -> permission))>
            <label class="form-check-label">Account Settings</label>
        </div>
    </td>
</tr>
@include('user-management.privileges.account-types', ['permission' => $permission])
@include('user-management.privileges.account-roles', ['permission' => $permission])