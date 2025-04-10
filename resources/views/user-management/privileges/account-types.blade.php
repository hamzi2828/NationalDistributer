<tr>
    <td colspan="2">
        <h5 class="mb-0">Account Types</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="account-types-privilege" @checked(!empty($permission) && in_array ('account-types-privilege', $permission -> permission))>
            <label class="form-check-label">account types</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">All account types</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="all-account-types-privilege" @checked(!empty($permission) && in_array ('all-account-types-privilege', $permission -> permission))>
            <label class="form-check-label">All account types</label>
        </div>
    </td>
</tr>
<tr>
    <td colspan="2"></td>
    <td>
        <div class="d-flex gap-2 flex-column">
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="privilege[]"
                       value="edit-account-types-privilege" @checked(!empty($permission) && in_array ('edit-account-types-privilege', $permission -> permission))>
                <label class="form-check-label">Edit account types</label>
            </div>

            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="privilege[]"
                       value="delete-account-types-privilege" @checked(!empty($permission) && in_array ('delete-account-types-privilege', $permission -> permission))>
                <label class="form-check-label">Delete account types</label>
            </div>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">Add account types</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="add-account-types-privilege" @checked(!empty($permission) && in_array ('add-account-types-privilege', $permission -> permission))>
            <label class="form-check-label">Add account types</label>
        </div>
    </td>
</tr>