<tr>
    <td colspan="2">
        <h5 class="mb-0">Account roles</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="account-roles-privilege" @checked(!empty($permission) && in_array ('account-roles-privilege', $permission -> permission))>
            <label class="form-check-label">account roles</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">All account roles</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="all-account-roles-privilege" @checked(!empty($permission) && in_array ('all-account-roles-privilege', $permission -> permission))>
            <label class="form-check-label">All account roles</label>
        </div>
    </td>
</tr>
<tr>
    <td colspan="2"></td>
    <td>
        <div class="d-flex gap-2 flex-column">
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="privilege[]"
                       value="edit-account-roles-privilege" @checked(!empty($permission) && in_array ('edit-account-roles-privilege', $permission -> permission))>
                <label class="form-check-label">Edit account roles</label>
            </div>

            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="privilege[]"
                       value="delete-account-roles-privilege" @checked(!empty($permission) && in_array ('delete-account-roles-privilege', $permission -> permission))>
                <label class="form-check-label">Delete account roles</label>
            </div>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">Add account roles</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="add-account-roles-privilege" @checked(!empty($permission) && in_array ('add-account-roles-privilege', $permission -> permission))>
            <label class="form-check-label">Add account roles</label>
        </div>
    </td>
</tr>