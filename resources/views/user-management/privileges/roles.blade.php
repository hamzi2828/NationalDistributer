<tr>
    <td colspan="2">
        <h5 class="mb-0">Roles</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="roles-privilege" @checked(!empty($permission) && in_array ('roles-privilege', $permission -> permission))>
            <label class="form-check-label">Roles</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">All Roles</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="all-roles-privilege" @checked(!empty($permission) && in_array ('all-roles-privilege', $permission -> permission))>
            <label class="form-check-label">All Roles</label>
        </div>
    </td>
</tr>
<tr>
    <td colspan="2"></td>
    <td>
        <div class="d-flex gap-2 flex-column">
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="privilege[]"
                       value="edit-roles-privilege" @checked(!empty($permission) && in_array ('edit-roles-privilege', $permission -> permission))>
                <label class="form-check-label">Edit Roles</label>
            </div>

            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="privilege[]"
                       value="delete-roles-privilege" @checked(!empty($permission) && in_array ('delete-roles-privilege', $permission -> permission))>
                <label class="form-check-label">Delete Roles</label>
            </div>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">Add Roles</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="add-roles-privilege" @checked(!empty($permission) && in_array ('add-roles-privilege', $permission -> permission))>
            <label class="form-check-label">Add Roles</label>
        </div>
    </td>
</tr>