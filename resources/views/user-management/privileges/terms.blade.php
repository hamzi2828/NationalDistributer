<tr>
    <td colspan="2">
        <h5 class="mb-0">terms</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="terms-privilege" @checked(!empty($permission) && in_array ('terms-privilege', $permission -> permission))>
            <label class="form-check-label">terms</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">All terms</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="all-terms-privilege" @checked(!empty($permission) && in_array ('all-terms-privilege', $permission -> permission))>
            <label class="form-check-label">All terms</label>
        </div>
    </td>
</tr>
<tr>
    <td colspan="2"></td>
    <td>
        <div class="d-flex gap-2 flex-column">
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="privilege[]"
                       value="edit-terms-privilege" @checked(!empty($permission) && in_array ('edit-terms-privilege', $permission -> permission))>
                <label class="form-check-label">Edit terms</label>
            </div>

            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="privilege[]"
                       value="delete-terms-privilege" @checked(!empty($permission) && in_array ('delete-terms-privilege', $permission -> permission))>
                <label class="form-check-label">Delete terms</label>
            </div>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">Add terms</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="add-terms-privilege" @checked(!empty($permission) && in_array ('add-terms-privilege', $permission -> permission))>
            <label class="form-check-label">Add terms</label>
        </div>
    </td>
</tr>