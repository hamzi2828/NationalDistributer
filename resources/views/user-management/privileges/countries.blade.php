<tr>
    <td colspan="2">
        <h5 class="mb-0">countries</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="countries-privilege" @checked(!empty($permission) && in_array ('countries-privilege', $permission -> permission))>
            <label class="form-check-label">countries</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">All countries</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="all-countries-privilege" @checked(!empty($permission) && in_array ('all-countries-privilege', $permission -> permission))>
            <label class="form-check-label">All countries</label>
        </div>
    </td>
</tr>
<tr>
    <td colspan="2"></td>
    <td>
        <div class="d-flex gap-2 flex-column">
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="privilege[]"
                       value="edit-countries-privilege" @checked(!empty($permission) && in_array ('edit-countries-privilege', $permission -> permission))>
                <label class="form-check-label">Edit countries</label>
            </div>

            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="privilege[]"
                       value="delete-countries-privilege" @checked(!empty($permission) && in_array ('delete-countries-privilege', $permission -> permission))>
                <label class="form-check-label">Delete countries</label>
            </div>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">Add countries</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="add-countries-privilege" @checked(!empty($permission) && in_array ('add-countries-privilege', $permission -> permission))>
            <label class="form-check-label">Add countries</label>
        </div>
    </td>
</tr>