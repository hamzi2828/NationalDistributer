<tr>
    <td colspan="2">
        <h5 class="mb-0">customers</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="customers-privilege" @checked(!empty($permission) && in_array ('customers-privilege', $permission -> permission))>
            <label class="form-check-label">customers</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">All customers</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="all-customers-privilege" @checked(!empty($permission) && in_array ('all-customers-privilege', $permission -> permission))>
            <label class="form-check-label">All customers</label>
        </div>
    </td>
</tr>
<tr>
    <td colspan="2"></td>
    <td>
        <div class="d-flex gap-2 flex-column">
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="privilege[]"
                       value="edit-customers-privilege" @checked(!empty($permission) && in_array ('edit-customers-privilege', $permission -> permission))>
                <label class="form-check-label">Edit customers</label>
            </div>

            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="privilege[]"
                       value="active-inactive-customers-privilege" @checked(!empty($permission) && in_array ('active-inactive-customers-privilege', $permission -> permission))>
                <label class="form-check-label">active/inactive customers</label>
            </div>

            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="privilege[]"
                       value="delete-customers-privilege" @checked(!empty($permission) && in_array ('delete-customers-privilege', $permission -> permission))>
                <label class="form-check-label">Delete customers</label>
            </div>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">Add customers</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="add-customers-privilege" @checked(!empty($permission) && in_array ('add-customers-privilege', $permission -> permission))>
            <label class="form-check-label">Add customers (simple)</label>
        </div>
    </td>
</tr>