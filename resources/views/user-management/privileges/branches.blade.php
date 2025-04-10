<tr>
    <td colspan="2">
        <h5 class="mb-0">Branches</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="branches-privilege" @checked(!empty($permission) && in_array ('branches-privilege', $permission -> permission))>
            <label class="form-check-label">branches</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">All branches</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="all-branches-privilege" @checked(!empty($permission) && in_array ('all-branches-privilege', $permission -> permission))>
            <label class="form-check-label">All branches</label>
        </div>
    </td>
</tr>
<tr>
    <td colspan="2"></td>
    <td>
        <div class="d-flex gap-2 flex-column">
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="privilege[]"
                       value="edit-branches-privilege" @checked(!empty($permission) && in_array ('edit-branches-privilege', $permission -> permission))>
                <label class="form-check-label">Edit branches</label>
            </div>

            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="privilege[]"
                       value="delete-branches-privilege" @checked(!empty($permission) && in_array ('delete-branches-privilege', $permission -> permission))>
                <label class="form-check-label">Delete branches</label>
            </div>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">Add branches</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="add-branches-privilege" @checked(!empty($permission) && in_array ('add-branches-privilege', $permission -> permission))>
            <label class="form-check-label">Add branches</label>
        </div>
    </td>
</tr>