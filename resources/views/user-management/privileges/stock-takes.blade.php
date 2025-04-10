<tr>
    <td colspan="2">
        <h5 class="mb-0">stock takes</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="stock-take-privilege" @checked(!empty($permission) && in_array ('stock-take-privilege', $permission -> permission))>
            <label class="form-check-label">stock takes</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">All products</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="all-stock-take-privilege" @checked(!empty($permission) && in_array ('all-stock-take-privilege', $permission -> permission))>
            <label class="form-check-label">All stock takes</label>
        </div>
    </td>
</tr>
<tr>
    <td colspan="2"></td>
    <td>
        <div class="d-flex gap-2 flex-column">
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="privilege[]"
                       value="edit-stock-take-privilege" @checked(!empty($permission) && in_array ('edit-stock-take-privilege', $permission -> permission))>
                <label class="form-check-label">Edit stock takes</label>
            </div>

            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="privilege[]"
                       value="delete-stock-take-privilege" @checked(!empty($permission) && in_array ('delete-stock-take-privilege', $permission -> permission))>
                <label class="form-check-label">Delete stock takes</label>
            </div>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">Add stock takes (attribute)</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="add-stock-take-privilege" @checked(!empty($permission) && in_array ('add-stock-take-privilege', $permission -> permission))>
            <label class="form-check-label">Add stock takes (attribute)</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">Add stock takes (category)</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="add-stock-take-category-privilege" @checked(!empty($permission) && in_array ('add-stock-take-category-privilege', $permission -> permission))>
            <label class="form-check-label">Add stock takes (category)</label>
        </div>
    </td>
</tr>
