<tr>
    <td colspan="2">
        <h5 class="mb-0">pages</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="pages-privilege" @checked(!empty($permission) && in_array ('pages-privilege', $permission -> permission))>
            <label class="form-check-label">pages</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">All pages</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="all-pages-privilege" @checked(!empty($permission) && in_array ('all-pages-privilege', $permission -> permission))>
            <label class="form-check-label">All pages</label>
        </div>
    </td>
</tr>
<tr>
    <td colspan="2"></td>
    <td>
        <div class="d-flex gap-2 flex-column">
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="privilege[]"
                       value="edit-pages-privilege" @checked(!empty($permission) && in_array ('edit-pages-privilege', $permission -> permission))>
                <label class="form-check-label">Edit pages</label>
            </div>

            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="privilege[]"
                       value="delete-pages-privilege" @checked(!empty($permission) && in_array ('delete-pages-privilege', $permission -> permission))>
                <label class="form-check-label">Delete pages</label>
            </div>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">Add pages</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="add-pages-privilege" @checked(!empty($permission) && in_array ('add-pages-privilege', $permission -> permission))>
            <label class="form-check-label">Add pages</label>
        </div>
    </td>
</tr>