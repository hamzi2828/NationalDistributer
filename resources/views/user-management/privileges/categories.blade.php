<tr>
    <td colspan="2">
        <h5 class="mb-0">Categories</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="categories-privilege" @checked(!empty($permission) && in_array ('categories-privilege', $permission -> permission))>
            <label class="form-check-label">categories</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">All categories</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="all-categories-privilege" @checked(!empty($permission) && in_array ('all-categories-privilege', $permission -> permission))>
            <label class="form-check-label">All categories</label>
        </div>
    </td>
</tr>
<tr>
    <td colspan="2"></td>
    <td>
        <div class="d-flex gap-2 flex-column">
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="privilege[]"
                       value="edit-categories-privilege" @checked(!empty($permission) && in_array ('edit-categories-privilege', $permission -> permission))>
                <label class="form-check-label">Edit categories</label>
            </div>

            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="privilege[]"
                       value="delete-categories-privilege" @checked(!empty($permission) && in_array ('delete-categories-privilege', $permission -> permission))>
                <label class="form-check-label">Delete categories</label>
            </div>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">Add categories</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="add-categories-privilege" @checked(!empty($permission) && in_array ('add-categories-privilege', $permission -> permission))>
            <label class="form-check-label">Add categories</label>
        </div>
    </td>
</tr>