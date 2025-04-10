<tr>
    <td colspan="2">
        <h5 class="mb-0">stocks</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="stocks-privilege" @checked(!empty($permission) && in_array ('stocks-privilege', $permission -> permission))>
            <label class="form-check-label">stocks</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">All stocks</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="all-stocks-privilege" @checked(!empty($permission) && in_array ('all-stocks-privilege', $permission -> permission))>
            <label class="form-check-label">All stocks</label>
        </div>
    </td>
</tr>
<tr>
    <td colspan="2"></td>
    <td>
        <div class="d-flex gap-2 flex-column">
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="privilege[]"
                       value="edit-stocks-privilege" @checked(!empty($permission) && in_array ('edit-stocks-privilege', $permission -> permission))>
                <label class="form-check-label">Edit stocks</label>
            </div>

            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="privilege[]"
                       value="delete-stocks-privilege" @checked(!empty($permission) && in_array ('delete-stocks-privilege', $permission -> permission))>
                <label class="form-check-label">Delete stocks</label>
            </div>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">Add stocks</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="add-stocks-privilege" @checked(!empty($permission) && in_array ('add-stocks-privilege', $permission -> permission))>
            <label class="form-check-label">Add stocks</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">Check Stock</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="check-stock-privilege" @checked(!empty($permission) && in_array ('check-stock-privilege', $permission -> permission))>
            <label class="form-check-label">Check Stock</label>
        </div>
    </td>
</tr>
