<tr>
    <td colspan="2">
        <h5 class="mb-0">Attributes</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="attributes-privilege" @checked(!empty($permission) && in_array ('attributes-privilege', $permission -> permission))>
            <label class="form-check-label">attributes</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">All attributes</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="all-attributes-privilege" @checked(!empty($permission) && in_array ('all-attributes-privilege', $permission -> permission))>
            <label class="form-check-label">All attributes</label>
        </div>
    </td>
</tr>
<tr>
    <td colspan="2"></td>
    <td>
        <div class="d-flex gap-2 flex-column">
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="privilege[]"
                       value="edit-attributes-privilege" @checked(!empty($permission) && in_array ('edit-attributes-privilege', $permission -> permission))>
                <label class="form-check-label">Edit attributes</label>
            </div>

            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="privilege[]"
                       value="delete-attributes-privilege" @checked(!empty($permission) && in_array ('delete-attributes-privilege', $permission -> permission))>
                <label class="form-check-label">Delete attributes</label>
            </div>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">Add attributes</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="add-attributes-privilege" @checked(!empty($permission) && in_array ('add-attributes-privilege', $permission -> permission))>
            <label class="form-check-label">Add attributes</label>
        </div>
    </td>
</tr>