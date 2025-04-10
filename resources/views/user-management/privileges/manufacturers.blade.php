<tr>
    <td colspan="2">
        <h5 class="mb-0">manufacturers</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="manufacturers-privilege" @checked(!empty($permission) && in_array ('manufacturers-privilege', $permission -> permission))>
            <label class="form-check-label">manufacturers</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">All manufacturers</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="all-manufacturers-privilege" @checked(!empty($permission) && in_array ('all-manufacturers-privilege', $permission -> permission))>
            <label class="form-check-label">All manufacturers</label>
        </div>
    </td>
</tr>
<tr>
    <td colspan="2"></td>
    <td>
        <div class="d-flex gap-2 flex-column">
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="privilege[]"
                       value="edit-manufacturers-privilege" @checked(!empty($permission) && in_array ('edit-manufacturers-privilege', $permission -> permission))>
                <label class="form-check-label">Edit manufacturers</label>
            </div>

            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="privilege[]"
                       value="delete-manufacturers-privilege" @checked(!empty($permission) && in_array ('delete-manufacturers-privilege', $permission -> permission))>
                <label class="form-check-label">Delete manufacturers</label>
            </div>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">Add manufacturers</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="add-manufacturers-privilege" @checked(!empty($permission) && in_array ('add-manufacturers-privilege', $permission -> permission))>
            <label class="form-check-label">Add manufacturers</label>
        </div>
    </td>
</tr>