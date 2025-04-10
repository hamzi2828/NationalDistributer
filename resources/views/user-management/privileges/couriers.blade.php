<tr>
    <td colspan="2">
        <h5 class="mb-0">couriers</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="couriers-privilege" @checked(!empty($permission) && in_array ('couriers-privilege', $permission -> permission))>
            <label class="form-check-label">couriers</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">All couriers</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="all-couriers-privilege" @checked(!empty($permission) && in_array ('all-couriers-privilege', $permission -> permission))>
            <label class="form-check-label">All couriers</label>
        </div>
    </td>
</tr>
<tr>
    <td colspan="2"></td>
    <td>
        <div class="d-flex gap-2 flex-column">
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="privilege[]"
                       value="edit-couriers-privilege" @checked(!empty($permission) && in_array ('edit-couriers-privilege', $permission -> permission))>
                <label class="form-check-label">Edit couriers</label>
            </div>

            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="privilege[]"
                       value="delete-couriers-privilege" @checked(!empty($permission) && in_array ('delete-couriers-privilege', $permission -> permission))>
                <label class="form-check-label">Delete couriers</label>
            </div>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">Add couriers</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="add-couriers-privilege" @checked(!empty($permission) && in_array ('add-couriers-privilege', $permission -> permission))>
            <label class="form-check-label">Add couriers</label>
        </div>
    </td>
</tr>