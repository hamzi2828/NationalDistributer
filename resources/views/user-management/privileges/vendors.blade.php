<tr>
    <td colspan="2">
        <h5 class="mb-0">vendors</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="vendors-privilege" @checked(!empty($permission) && in_array ('vendors-privilege', $permission -> permission))>
            <label class="form-check-label">vendors</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">All vendors</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="all-vendors-privilege" @checked(!empty($permission) && in_array ('all-vendors-privilege', $permission -> permission))>
            <label class="form-check-label">All vendors</label>
        </div>
    </td>
</tr>
<tr>
    <td colspan="2"></td>
    <td>
        <div class="d-flex gap-2 flex-column">
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="privilege[]"
                       value="edit-vendors-privilege" @checked(!empty($permission) && in_array ('edit-vendors-privilege', $permission -> permission))>
                <label class="form-check-label">Edit vendors</label>
            </div>
            
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="privilege[]"
                       value="active-inactive-vendors-privilege" @checked(!empty($permission) && in_array ('active-inactive-vendors-privilege', $permission -> permission))>
                <label class="form-check-label">active/inactive vendors</label>
            </div>
            
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="privilege[]"
                       value="delete-vendors-privilege" @checked(!empty($permission) && in_array ('delete-vendors-privilege', $permission -> permission))>
                <label class="form-check-label">Delete vendors</label>
            </div>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">Add vendors</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="add-vendors-privilege" @checked(!empty($permission) && in_array ('add-vendors-privilege', $permission -> permission))>
            <label class="form-check-label">Add vendors</label>
        </div>
    </td>
</tr>