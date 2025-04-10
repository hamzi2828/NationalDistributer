<tr>
    <td colspan="2">
        <h5 class="mb-0">User Management</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="user-management-privilege" @checked(!empty($permission) && in_array ('user-management-privilege', $permission -> permission))>
            <label class="form-check-label">User Management</label>
        </div>
    </td>
</tr>
@include('user-management.privileges.roles', ['permission' => $permission])