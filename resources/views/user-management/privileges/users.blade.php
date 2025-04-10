<tr>
    <td colspan="2">
        <h5 class="mb-0">Users</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="users-privilege" @checked(!empty($permission) && in_array ('users-privilege', $permission -> permission))>
            <label class="form-check-label">Users</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">All Users</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="all-users-privilege" @checked(!empty($permission) && in_array ('all-users-privilege', $permission -> permission))>
            <label class="form-check-label">All Users</label>
        </div>
    </td>
</tr>
<tr>
    <td colspan="2"></td>
    <td>
        <div class="d-flex gap-2 flex-column">
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="privilege[]"
                       value="edit-users-privilege" @checked(!empty($permission) && in_array ('edit-users-privilege', $permission -> permission))>
                <label class="form-check-label">Edit Users</label>
            </div>

            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="privilege[]"
                       value="delete-users-privilege" @checked(!empty($permission) && in_array ('delete-users-privilege', $permission -> permission))>
                <label class="form-check-label">Delete Users</label>
            </div>

            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="privilege[]"
                       value="status-users-privilege" @checked(!empty($permission) && in_array ('status-users-privilege', $permission -> permission))>
                <label class="form-check-label">Active/Inactive Users</label>
            </div>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">Add Users</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="add-users-privilege" @checked(!empty($permission) && in_array ('add-users-privilege', $permission -> permission))>
            <label class="form-check-label">Add Users</label>
        </div>
    </td>
</tr>